<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

use App\Expense;
use App\Expense_line;


class ExpenseController extends Controller
{
    public function index()
    {
    	return view('expense.index');
    }
    public function get(Request $request)
    {
    	$formData = array(
    		'orno'=> $request-> input('orno'),
            'startdate'=> $request-> input('startdate'),
            'enddate'=> $request-> input('enddate'),
            'posted'=> $request-> input('posted')
    	);

        $expense = DB::table('expense')
            ->select (
                'expenseid',
                'pcv',
                'orno',
                'ordate',
                'expense_category.description as category_description',
                'expense.category as category_code',
                'expense_category_type.description as category_type_desc',
                'expense.category_type as category_type_code',
                'establishment',
                DB::raw('CAST(expense.amount as DECIMAL(18,2)) as amount'),
                'remarks',
                'posted',
                'deleted',
                'expense.created_at')
            -> leftjoin('expense_category','expense_category.code','=','expense.category')
            -> leftjoin('expense_category_type','expense.category_type','=','expense_category_type.code')
            -> where('deleted',0)
            ->where('posted',$formData['posted']);

        if ($formData['orno']) {
            $expense -> where('orno',$formData['orno']);            
        }
        if ($formData['startdate'] && $formData['enddate']) {
            $expense -> whereBetween('ordate',[$formData['startdate'],$formData['enddate']]);
        }
        $expense = $expense->get();

        return response()-> json([
            'status'=>200,
            'data'=>$expense,
            'message'=>''
        ]);
    }

    public function create(Request $request)
    {
        $message = '';

        $validator = Validator::make($request->all(),[
            'amount'                => 'required',
            'category_code'         => 'required',
            'category_type_code'    => 'required',
            'entityvalues'          => 'required',
            'ordate'                => 'required',
            'orno'                  => 'required',
            'establishment'         => 'required',
        ]);

        if ($validator-> fails()) {
            return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);

        } else {
            $expense = new Expense;
            $expenses_line = new Expense_line;

            $data = array();
            $data['orno']               = $request-> input('orno');
            $data['ordate']             = $request-> input('ordate');
            $data['category_code']      = $request-> input('category_code');
            $data['category_type_code'] = $request-> input('category_type_code');
            $data['amount']             = $request-> input('amount');
            $data['entityvalues']       = $request-> input('entityvalues');
            $data['remarks']            = $request-> input('remarks');
            $data['establishment']      = $request-> input('establishment');

            $orMonthYear = date('mY',strtotime($data['ordate']));

            $isClosed = DB::table('transaction')
                ->where('trantype','CLOSING')
                ->where('refid',$orMonthYear)
                ->where('posted',1)
                ->where('deleted',0)
                ->first();

            if ($isClosed) {
                return response()->json([
                    'status'=>403,
                    'data'=>'',
                    'message'=> date('F Y',strtotime($data['ordate']))." already closed. Can't create transaction."
                ]);
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
                    return response()->json([
                        'status'=>403,
                        'data'=>'',
                        'message'=> "OR Date is ealier than current month is not allowed."
                    ]);
                }
            }
            
            $transaction = DB::transaction(function($data) use($data){
                $pcv = 1;
                $expense = new Expense;
                $pcvLastest = DB::table('expense')
                    ->where('deleted',0)
                    ->orderBy('pcv','desc')
                    ->first();
                if ($pcvLastest) {
                    $pcv = $pcvLastest->pcv+1;
                }

                $expense->orno              = $data['orno'];
                $expense->pcv               = $pcv;
                $expense->ordate            = $data['ordate'];
                $expense->category          = $data['category_code'];
                $expense->category_type     = $data['category_type_code'];
                $expense->amount            = $data['amount'];
                $expense->establishment     = $data['establishment'];
                $expense->remarks           = $data['remarks'];
                
                $expense->save();


                if($expense->id)
                {
                    foreach ($data['entityvalues'] as $key => $entityvalue) {
                        $expense_line = new Expense_line;

                        $expense_line->expenseid = $expense->id;
                        $expense_line->entityvalue1 = $entityvalue['entityvalue1'];
                        $expense_line->entityvalue2 = $entityvalue['entityvalue2'];
                        $expense_line->entityvalue3 = $entityvalue['entityvalue3'];
                        $expense_line->save();

                        if (!$expense_line->id) {
                            throw new \Exception('Expense line not created.');
                        }
                    } 
                }
                else 
                {
                    throw new \Exception('Expense not created.');
                }

                return response()->json([
                    'status'=> 200,
                    'data'=>array(
                        'pcv'=>0
                    ),
                    'message'=>"PCV No. {$pcv} Successfully saved."
                ]);         

            });

            return $transaction;
        }    
    }

    public function update(Request $request)
    {
        $message = '';

        $validator = Validator::make($request->all(),[
            'expenseid'             => 'required',
            'pcv'                   => 'required',
            'amount'                => 'required',
            'category_code'         => 'required',
            'category_type_code'    => 'required',
            'entityvalues'          => 'required',
            'ordate'                => 'required',
            'orno'                  => 'required',
            'establishment'         => 'required',
        ]);

        if ($validator-> fails()) {
            return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);

        } else {
            $expense = new Expense;
            $expenses_line = new Expense_line;

            $data = array();
            $data['expenseid']              = $request-> input('expenseid');
            $data['pcv']                    = $request-> input('pcv');
            $data['orno']                   = $request-> input('orno');
            $data['ordate']                 = $request-> input('ordate');
            $data['category_code']          = $request-> input('category_code');
            $data['category_type_code']     = $request-> input('category_type_code');
            $data['amount']                 = $request-> input('amount');
            $data['entityvalues']           = $request-> input('entityvalues');
            $data['remarks']                = $request-> input('remarks');
            $data['establishment']          = $request-> input('establishment');

            $isPCVnoExist = $expense
                        -> where('pcv','=',$data['pcv'])
                        -> where('deleted',0)
                        -> first();

            if (!$isPCVnoExist) {
                return response()->json([
                    'status'=> 403,
                    'data'=>'',
                    'message'=>"PCV No. {$data['pcv']} doesn't exists."
                ]);         
            } else {
                // saving collections
                $transaction = DB::transaction(function($data) use($data){
                    // dd($data['orno']);
                $expenseUpdated = DB::table('expense')
                    -> where('expenseid',$data['expenseid'])
                    -> update([
                        'orno'              =>$data['orno'],
                        'ordate'            =>$data['ordate'],
                        'category'          =>$data['category_code'],
                        'category_type'     =>$data['category_type_code'],
                        'amount'            =>$data['amount'],
                        'establishment'     =>$data['establishment'],
                        'remarks'           =>$data['remarks']
                    ]);

                $expense_lineUpdated = DB::table('expense_line')
                    -> where('expenseid',$data['expenseid'])
                    -> update(['active'=>0]);

                // add if has details in expense header
                if (false) {
                    foreach ($data['entityvalues'] as $key => $entityvalue) {
                        $expense_line = new Expense_line;

                        $expense_line->collectionid = $data['collectionid'];
                        $expense_line->entityvalue1 = $entityvalue['entityvalue1'];
                        $expense_line->entityvalue2 = $entityvalue['entityvalue2'];
                        $expense_line->entityvalue3 = $entityvalue['entityvalue3'];
                        $expense_line->save();

                        if (!$collection_line->id) {
                            throw new \Exception('Collection line not created.');
                        }
                    } 
                }

                    return response()->json([
                        'status'=> 200,
                        'data'=>array(
                            'pcv'=>$data['pcv']
                        ),
                        'message'=>"PCV No. {$data['pcv']}. Successfully updated."
                    ]);         

                });

            }
            return $transaction;
        }    
    }

    public function delete(Request $request)
    {
        $formData = array(
            'orno'=> $request-> input('orno')
        );

        $isORNoExist = DB::table('transaction')
            -> where('refid',$formData['orno'])
            ->where('trantype','EXPENSE')
            ->where('deleted',0)
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

        DB::transaction(function($formData) use($formData){
            DB::table('expense')
                -> where('pcv',$formData['orno'])
                -> update(['deleted'=>1]);
        });

        return response() -> json([
            'status'=>200,
            'data'=>'',
            'message'=>"Successfully deleted."
        ]);
    }
}
