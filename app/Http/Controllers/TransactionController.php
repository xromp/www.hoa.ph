<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Transaction;
use App\Colection;
use App\Colection_line;
use App\Colection_category;
use DB;

class TransactionController extends Controller
{
    public function comparative(Request $request)
    {
    	$formData = array(
    		'startdate'=> $request->input('startdate'),
    		'enddate'=>$request->input('enddate')
    	);

    	$totalCollection = 0;
    	$totalExpense = 0;

    	$collection = DB::table('transaction as t')
    		-> select(
    			DB::raw('COALESCE(cc.code,"") as category'), 
    			DB::raw('max(COALESCE(cc.description,"NO DEFINED CATEGORY")) as description'),
    			// DB::raw('max(COALESCE(p.type,"NO DEFINED TYPE")) as type'),
    			DB::raw('SUM(t.amount) as amount'))
    		-> leftjoin('collection  as c','c.orno','=','t.refid')
    		-> leftjoin('collection_category  as cc','cc.code','=','c.category')
    		// -> leftjoin('person  as p','p.personid','=','c.referenceid')
    		-> where('t.deleted',false)
    		-> Where('trantype','COLLECTION')
    		-> groupBy('cc.code');

    	$expense = DB::table('transaction as t')
    		-> select(
    			DB::raw('COALESCE(ec.code,"") as category'), 
    			DB::raw('max(COALESCE(ec.description,"NO DEFINED CATEGORY")) as description'),
    			DB::raw('SUM(t.amount) as amount'))
    		-> leftjoin('expense  as e','e.pcv','=','t.refid')
    		-> leftjoin('expense_category  as ec','ec.code','=','e.category')
    		-> where('t.deleted',false)
    		-> Where('trantype','EXPENSE')
    		-> groupBy('ec.code');

    	if ($formData['startdate'] && $formData['enddate']) {
			$collection = $collection-> whereBetween('refdate',[$formData['startdate'], $formData['enddate']]);
			$expense = $expense-> whereBetween('refdate',[$formData['startdate'], $formData['enddate']]);
    	}
    	
    	$collection = $collection->get();
    	$expense = $expense->get();
        
    	foreach ($collection as $key => $col) {
    		$totalCollection += $col->amount;
    	}


    	foreach ($expense as $key => $exp) {
    		$totalExpense += $exp->amount;
    	}
    	$data = array(
    		'data'=> array(
	    		'collection'=>array(
	    			'details'=>$collection,
	    			'total'=>$totalCollection
	    		),
    			'expense'=> array(
    				'details'=> $expense,
    				'total'=> $totalExpense
    			)
    		),
    		'formdata'=>$formData
    	);
    	// dd($data);
    	return view('collection.reports.comparative', array('data'=>$data));
    }

    public function post(Request $request)
    {
    	$formData = array(
    		'trantype'=> $request-> input('trantype'),
    		'refid'=> $request-> input('refid'),
    		'refdate'=> $request-> input('refdate'),
    		'amount'=> $request-> input('amount')
    	);

    	$validator = validator::make($request->all(),[
    		'trantype'=>'required',
    		'refid'=>'required',
    		'refdate'=>'required',
    		'amount'=>'required'
    	]);


        $isCollectionPosted = DB::table('collection')
            -> where('orno',$formData['refid'])
            -> where('deleted',0)
            -> where('posted',1)
            -> first();

        if ($isCollectionPosted) {
            if ($isCollectionPosted->posted) {
                return response() -> json([
                    'status'=>403,
                    'data'=>'',
                    'message'=>"Collection OR no. {$isCollectionPosted->orno} is already posted."
                ]);
            }
        }

    	$isTransPosted = DB::table('transaction')
    		-> where('refid',$formData['refid'])
            -> where('trantype',$formData['trantype'])
            -> where('deleted',0)
            -> where('posted',1)
    		-> first();

    	if ($isTransPosted) {
    		if ($isTransPosted->posted) {
	    		return response() -> json([
	    			'status'=>403,
	    			'data'=>'',
	    			'message'=>"Transactino OR no. {$isTransPosted->refid} is already posted."
	    		]);
    		}
    	}
        $orMonthYear = date('Ym',strtotime($formData['refdate']));
        $isClosed = DB::table('transaction')
            ->where('trantype','CLOSING')
            ->where('refid',$orMonthYear)
            ->where('posted',1)
            ->where('deleted',0)
            ->first();

        if ($isClosed) {
            $validation['isvalid'] = false;
            $validation['message'] = date('F Y',strtotime($formData['ordate']))." already closed. Can't create transaction.";
        }

        $getLastPostMonth = DB::table('transaction')
            ->where('trantype','CLOSING')
            ->where('posted',1)
            ->where('deleted',0)
            ->orderBy('refid','DESC')
            ->first();

        if ($getLastPostMonth) {
            $postMonth = $getLastPostMonth->refid;
            if ($postMonth > $orMonthYear) {
                $validation['isvalid'] = false;
                $validation['message'] = "PCV Date is ealier than current month is not allowed.";
            }
        }


    	DB::transaction(function($formData) use($formData) {
    		$transaction  = new Transaction;

            if ($formData['trantype'] == 'COLLECTION') {
        		DB::table('collection')
        			-> where('orno',$formData['refid'])
        			-> update(['posted'=>1]);
            } else if ($formData['trantype'] == 'EXPENSE') {
                DB::table('expense')
                    -> where('pcv',$formData['refid'])
                    -> update(['posted'=>1]);
            } else {
                throw new \Exception('Transaction posting failed.');
            }

    		$transaction->trantype		= $formData['trantype'];
    		$transaction->refid			= $formData['refid'];
    		$transaction->refdate		= $formData['refdate'];
    		$transaction->amount		= $formData['amount'];
    		$transaction->posted		= 1;
    		$transaction->created_at	= date("Y-m-d H:i:s");
    		
    		$transaction->save();

    		if (!$transaction->id) {
    			throw new \Exception('Transaction posting not created.');
    		}
    	});
        return response() -> json([
            'status'=>200,
            'data'=>'',
            'message'=>"Successfully posted."
        ]);
    }

    public function monthEndPosting(Request $request)
    {
        $formData = array(
            'month'=>$request->input('month'),
            'year'=>$request->input('year')
        );
        $formData['month'] = sprintf('%02d', $formData['month']);

        $isPosted = DB::table('transaction')
            ->where('trantype','CLOSING')
            ->where('refid',$formData['year'].$formData['month'])
            ->where('posted',1)
            ->where('deleted',0)
            ->first();
        if ($isPosted) {
            return response()->json([
                'status'=>403,
                'data'=>'',
                'message'=>'Already posted.'
            ]);
        }

        $transaction = DB::transaction(function($formData) use($formData){
            $amount = 0;
            $balanceForwarded = array();
            $formData['refid'] = $formData['year'].$formData['month'];

            $collection = DB::table('transaction')
                ->select(DB::raw('SUM(amount) as amount'))
                ->where('posted',1)
                ->where('deleted',0)
                ->where('closed',0)
                ->where('trantype','COLLECTION')
                ->whereMonth('refdate',$formData['month'])
                ->whereYear('refdate',$formData['year'])
                ->first();
            if ($collection->amount) {
                $amount = $collection->amount;
            }

            $transaction = new Transaction;
            $transaction->trantype          = 'CLOSING';
            $transaction->trantype1         = 'COLLECTION';
            $transaction->refid             = $formData['refid'];
            $transaction->refdate           = date("Y-m-d H");
            $transaction->amount            = $amount;
            $transaction->posted            = 1;
            $transaction->closed            = 0;
            $transaction->datefinancial     = date("Y-m-d H");
            $transaction->save();

            $amount = 0;

            $expense = DB::table('transaction')
                ->select(DB::raw('SUM(amount) as amount'))
                ->where('posted',1)
                ->where('closed',0)
                ->where('deleted',0)
                ->where('trantype','EXPENSE')
                ->whereMonth('refdate',$formData['month'])
                ->whereYear('refdate',$formData['year'])
                ->first();
            if ($expense->amount) {
                $amount = $expense->amount;
            }

            $transaction = new Transaction;
            $transaction->trantype          = 'CLOSING';
            $transaction->trantype1         = 'EXPENSE';
            $transaction->refid             = $formData['refid'];
            $transaction->refdate           = date("Y-m-d H");
            $transaction->amount            = $amount;
            $transaction->posted            = 1;
            $transaction->closed            = 0;
            $transaction->datefinancial     = date("Y-m-d H");
            $transaction->save();

            $balanceForwarded = $this->getCurrentBalanceForwarded($formData['month'], $formData['year']);

            if (!$balanceForwarded) {
                throw new \Exception("No Balance forwarded", 1);
            }
            $transaction = new Transaction;
            $transaction->trantype          = 'CLOSING';
            $transaction->trantype1         = 'CURRENT';
            $transaction->refid             = $formData['refid'];
            $transaction->refdate           = date("Y-m-d H");
            $transaction->amount            = ($collection->amount + $balanceForwarded['total']) - $expense->amount;
            $transaction->posted            = 1;
            $transaction->closed            = 0;
            $transaction->datefinancial     = date("Y-m-d H");
            $transaction->save();

            // update transaction balance forwarded to closed.
            $updateBalanceForwarded = DB::table('transaction')
                ->where('transactionid',$balanceForwarded['transactionid'])
                ->update(['closed'=>1]);

            $updateTransaction = DB::table('transaction')
                ->whereMonth('refdate',$formData['month'])
                ->whereYear('refdate',$formData['year'])
                ->where('posted',1)
                ->where('closed',0)
                ->where('deleted',0)
                ->where(function($q){
                    $q->where('trantype','COLLECTION')
                      ->orWhere('trantype','EXPENSE');
                })
                ->update(['closed'=>1]);

            return response()-> json([
                'status'=>200,
                'data'=>'',
                'message'=>'Successfully posted.'
            ]);

        });
        return $transaction;
    }

    public function getMonthEndPostingDetails(Request $request){
        $formData = array(
            'month'=>$request->input('month'),
            'year'=>$request->input('year')
        );
        $totalCollection = 0;
        $totalExpense = 0;

        $expense = DB::table('transaction')
            ->select(DB::raw('SUM(amount) as amount'))
            ->where('posted',1)
            ->where('closed',0)
            ->where('deleted',0)
            ->where('trantype','EXPENSE')
            ->whereMonth('refdate',$formData['month'])
            ->whereYear('refdate',$formData['year'])
            ->first();
        if ($expense->amount) {
            $totalExpense = $expense->amount;
        }

        $collection = DB::table('transaction')
            ->select(DB::raw('SUM(amount) as amount'))
            ->where('posted',1)
            ->where('closed',0)
            ->where('deleted',0)
            ->where('trantype','COLLECTION')
            ->whereMonth('refdate',$formData['month'])
            ->whereYear('refdate',$formData['year'])
            ->first();
        if ($collection->amount) {
            $totalCollection = $collection->amount;
        }

        return response()->json([
            'status'=>'200',
            'data'=>array(
                'total_collection'=>$totalCollection,
                'total_expense'=>$totalExpense
            ),
            'message'=>''
        ]);
    }

    public function currentbalance(Request $request){
        // get transaction doesnt closed
        $formData = array(
            'month' => $request->input('month'),
            'year' => $request->input('year')
        );
        $formData['datename'] = date('F Y', strtotime($formData['year'].sprintf('%02d', $formData['month']).'01'));
        $formData['refid'] = $formData['year'].sprintf('%02d', $formData['month']);

        $totalPrevCollection = 0;
        $totalPrevExpense = 0;
        $totalCurrentExpense = 0;
        $totalCurrentCollections = 0;
        $totalCurrent =0;

        $balanceForwarded = array(
            'monthname' => '',
            'total' => 0
        );
        $balanceEnding = array(
            'monthname' => $formData['datename'],
            'total' => 0
        );

        // get previous current posting
        $balanceForwarded = $this->getCurrentBalanceForwarded($formData['month'],$formData['year']);

        $currentCollection = DB::table('transaction as t')
            ->select(
                DB::raw('COALESCE(c.category,"") as category'), 
                DB::raw('MAX(COALESCE(cc.description,"")) as category_desc'), 
                DB::raw('sum(COALESCE(t.amount,0)) as amount')
            )
            ->leftjoin('collection as c','t.refid','=','c.orno')
            ->leftjoin('collection_category as cc','cc.code','=','c.category')
            ->where('trantype','COLLECTION')
            ->whereMonth('refdate',$formData['month'])
            ->whereYear('refdate',$formData['year'])
            ->where('t.posted',1)
            ->where('t.closed',0)
            ->where('t.deleted',0)
            ->where('c.posted',1)
            ->where('c.deleted',0)
            ->groupBy('c.category')
            ->get();

        foreach ($currentCollection as $key => $exp) {
            $totalCurrentCollections += $exp->amount;
        }

        $currentExpense = DB::table('transaction as t')
            ->select(
                DB::raw('COALESCE(c.category,"") as category'), 
                DB::raw('MAX(COALESCE(cc.description,"")) as category_desc'), 
                DB::raw('sum(COALESCE(t.amount,0)) as amount')
            )
            ->leftjoin('expense as c','t.refid','=','c.pcv')
            ->leftjoin('expense_category as cc','cc.code','=','c.category')
            ->where('trantype','EXPENSE')
            ->whereMonth('refdate',$formData['month'])
            ->whereYear('refdate',$formData['year'])
            ->where('t.posted',1)
            ->where('t.closed',0)
            ->where('t.deleted',0)
            ->where('c.posted',1)
            ->where('c.deleted',0)
            ->groupBy('c.category')
            ->get();

        foreach ($currentExpense as $key => $exp) {
            $totalCurrentExpense += $exp->amount;
        }

        // Ending Balance for the month
        $balanceEnding['total'] = ($balanceForwarded['total'] + $totalCurrentCollections ) - $totalCurrentExpense;
        $data = array(
            'data'=>array(
                'collection'=>array(
                    'details'=> $currentCollection,
                    'details_total'=> $totalCurrentCollections,
                    'prev_total'=>$totalPrevCollection
                ),
                'expense'=>array(
                    'details'=>$currentExpense,
                    'details_total'=> $totalCurrentExpense,
                    'prev_total'=>$totalPrevExpense
                ),
                'balanceforwarded' => $balanceForwarded,
                'balanceending' => $balanceEnding
            ),
            'formData' => $formData
        );
        return view('collection.reports.current-balance', array('data'=>$data));
    }

    public function getCurrentBalanceForwarded($month, $year){
        // get previous current posting
        $balanceForwarded = array();
        $formData = array(
            'month'=>$month,
            'year'=>$year
        );
        $formData['refid'] = $formData['year'].sprintf('%02d', $formData['month']);

        $currentClosed = DB::Table('transaction')
            ->where('trantype','CLOSING')
            ->where('trantype1','CURRENT')
            ->where('posted',1)
            ->where('closed',0)
            ->where('deleted',0)
            ->where('refid',$formData['year']."".sprintf('%02d', $formData['month']-1))
            ->first();

        if ($currentClosed) {
            $balanceForwarded['transactionid'] = $currentClosed->transactionid;
            $balanceForwarded['total'] = $currentClosed->amount;
            $balanceForwarded['monthname'] = date('F Y', strtotime(substr($currentClosed->refid, 0,4).substr($currentClosed->refid, 4,2).'01'));
        } else {
            $firstCurrentClosed = DB::Table('transaction')
                ->where('trantype','CLOSING')
                ->where('trantype1','CURRENT')
                ->where('posted',1)
                ->where('closed',0)
                ->where('deleted',0)
                ->orderBy('refid')
                ->first();

            $lastestCurrentClosed = DB::Table('transaction')
                ->where('trantype','CLOSING')
                ->where('trantype1','CURRENT')
                ->where('posted',1)
                ->where('closed',0)
                ->where('deleted',0)
                ->orderBy('refid','desc')
                ->first();

            if ($firstCurrentClosed) {
                if ($firstCurrentClosed->refid >= $formData['refid']) {
                    $balanceForwarded['transactionid'] = 0;
                    $balanceForwarded['total'] = 0;
                    $balanceForwarded['monthname'] = 'Beyond Beginning Balance.';
                } else {
                    $balanceForwarded['transactionid'] = $lastestCurrentClosed->transactionid;
                    $balanceForwarded['total'] = $lastestCurrentClosed->amount;
                    $balanceForwarded['monthname'] = date('F Y', strtotime(substr($lastestCurrentClosed->refid, 0,4).substr($lastestCurrentClosed->refid, 4,2).'01'));
                }
            }
        }

        return $balanceForwarded;
    }
}
