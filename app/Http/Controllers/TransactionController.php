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
    		-> leftjoin('expense  as e','e.orno','=','t.refid')
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

    	$isORNoExist = DB::table('transaction')
    		-> where('refid',$formData['refid'])
            -> where('trantype',$formData['trantype'])
            -> where('deleted',0)
    		-> first();
    	if ($isORNoExist) {
    		if ($isORNoExist->posted) {
	    		return response() -> json([
	    			'status'=>403,
	    			'data'=>'',
	    			'message'=>"OR no. {$isORNoExist->refid} is already posted."
	    		]);
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
                    -> where('orno',$formData['refid'])
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
}
