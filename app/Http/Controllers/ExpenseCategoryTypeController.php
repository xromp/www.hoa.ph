<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

use App\Expense_category_type;

class ExpenseCategoryTypeController extends Controller
{
   	
    public function get(Request $request)
    {	
    	$formData = array(
    		'category_code'=>$request->input('category_code')
    	);

 		$category = DB::table('expense_category_type')
 			-> select ('category_code','code', 'description')
 			-> where('category_code',$formData['category_code'])
 			-> where('active',1)
 			-> get();

 		return response()-> json([
 			'status'=> 200,
 			'data'=> $category,
 			'message' => ''
 		]);
    }

   	public function create(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'code'=> 'required',
    		'category_code'=> 'required',
    		'description'=> 'required'
		]);

    	if ($validator-> fails()) {
    		return response() -> json([
    			'status' => 403,
    			'data' => '',
    			'message'=> 'Unable to save'
    		]);
    	}

    	$formData = array(
    		'code'=> $request-> input('code'),
    		'category_code'=> $request-> input('category_code'),
    		'description'=> $request-> input('description')
    	);

    	$isCodeExist = DB::table('expense_category_type')
    		-> where('code',$formData['code'])
    		-> where('active',1)
    		->first();

    	if ($isCodeExist) {
    		return response() -> json([
    			'status' => 403,
    			'data' => '',
    			'message'=> 'Code aleady exist.'
    		]);	
    	}

    	$transaction = DB::transaction(function($formData) use ($formData) {
    		$category = new Expense_category_type;

    		$category->code 			= $formData['code'];
    		$category->category_code 	= $formData['category_code'];
    		$category->description 		= $formData['description'];

    		$isSave = $category->save();

    		if (!$isSave) {
    			throw new \Exception("Error Processing Request", 1);
    		}

    		return response() -> json([
    			'status'=>200,
    			'message'=>'Successfully saved.',
    			'data'=>''
    		]);
    	});
    	return $transaction;
    }
}
