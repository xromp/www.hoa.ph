<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

use App\Collection_category;

class CollectionCategoryController extends Controller
{
    public function get() 
    {
 		$category = DB::table('collection_category')
 			-> select ('code', 'description', 'frequency', 'isfixamount', 'amount', 'datestarteffectivity', 'dateendeffectivity')
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
    		'description'=> $request-> input('description')
    	);

    	$isCodeExist = DB::table('collection_category')
    		-> where('code',$formData['code'])
    		->first();

    	if ($isCodeExist) {
    		return response() -> json([
    			'status' => 403,
    			'data' => '',
    			'message'=> 'Code aleady exist.'
    		]);	
    	}

    	$transaction = DB::transaction(function($formData) use ($formData) {
    		$category = new Collection_category;

    		$category->code 		= $formData['code'];
    		$category->description 	= $formData['description'];

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
