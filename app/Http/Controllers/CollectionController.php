<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;

use App\Collection;
use App\Collection_line;

class CollectionController extends Controller
{
    public function index()
    {
    	return view('collection.index')	;
    }

    public function create(Request $request)
    {
        $message = '';

    	$validator = Validator::make($request->all(),[
			'amount'=> 'required',
    		'category'=> 'required',
    		'entityvalues'=> 'required',
    		'ordate'=> 'required',
    		'orno'=> 'required',
    		'orno'=> 'required',
    		'refid'=> 'required',
    		'type'=> 'required'    	
		]);

    	if ($validator-> fails()) {
	        return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);

    	} else {
            $collection = new Collection;
        	$collection_line = new Collection_line;

            $data = array();
            $data['orno'] 			= $request-> input('orno');
            $data['ordate'] 		= $request-> input('ordate');
            $data['type']			= $request-> input('type');
            $data['referenceid'] 	= $request-> input('refid');
            $data['category'] 		= $request-> input('category');
            $data['amount_paid'] 	= $request-> input('amount');
            $data['entityvalues'] 	= $request-> input('entityvalues');
            $data['remarks']        = $request-> input('remarks');

            $isOrnoExist = $collection
                        -> where('orno','=',$data['orno'])
                        -> where('deleted',0)
                        -> first();

            if ($isOrnoExist) {
                return response()->json([
                    'status'=> 403,
                    'data'=>'',
                    'message'=>"OR no. {$data['orno']} is already exists."
                ]);         
            } else {
            	// saving collections
            	DB::transaction(function($data) use($data){
            		// dd($data['orno']);
            		$collection = new Collection;
	            	
	            	$collection->orno 			= $data['orno'];
	            	$collection->ordate 		= $data['ordate'];
	            	$collection->type 			= $data['type'];
	            	$collection->referenceid 	= $data['referenceid'];
	            	$collection->category 		= $data['category'];
	            	$collection->amount_paid 	= $data['amount_paid'];
                    $collection->remarks    = $data['remarks'];
        		    
	            	$collection->save();

	            	if($collection->id)
				    {
		            	foreach ($data['entityvalues'] as $key => $entityvalue) {
		            		$collection_line = new Collection_line;

			            	$collection_line->collectionid = $collection->id;
			            	$collection_line->entityvalue1 = $entityvalue['entityvalue1'];
			            	$collection_line->entityvalue2 = $entityvalue['entityvalue2'];
			            	$collection_line->entityvalue3 = $entityvalue['entityvalue3'];
		            		$collection_line->save();

		            		if (!$collection_line->id) {
		            			throw new \Exception('Collection line not created.');
		            		}
	            		} 
	            	}
	            	else 
	            	{
				        throw new \Exception('Collection not created.');
	            	}
            	});

            }

            return response()->json([
                'status'=> 200,
                'data'=>'',
                'message'=>'Successfully saved.'
            ]);    		
    	}    
    }

    public function get(Request $request)
    {
        $formData = array(
            'collectionid'=>$request->input('collectionid'),
            'orno'=>$request->input('orno'),
            'startdate'=>$request->input('startdate'),
            'enddate'=>$request->input('enddate'),
            'posted'=>$request->input('posted')
        );

        $collection = DB::table('collection')
            ->select (
                'collectionid',
                DB::raw('CAST(orno as UNSIGNED) as orno'),
                'referenceid',
                'type',
                'ordate',
                'collection_category.description as category_description', 
                'collection_category.code as category_code',
                DB::raw('CAST(amount_paid as DECIMAL(18,2)) as amount'),

                'posted',
                'posted',
                'deleted',
                'remarks',
                'collection.created_at')
            -> leftjoin('collection_category','collection_category.code','=','collection.category')
            -> where('deleted',0)
            -> where('posted',$formData['posted']);

        if ($formData['orno']) {
            $collection -> where('orno',$formData['orno']);            
        }
        if ($formData['collectionid']) {
            $collection -> where('collectionid',$formData['collectionid']);            
        }
        if ($formData['startdate'] && $formData['enddate']) {
            $collection -> whereBetween('ordate',[$formData['startdate'],$formData['enddate']]);            
        }
        $collection = $collection->get();
        $result = json_decode($collection, true);
        // dd($result);

        foreach ($result as $key => $col) {
            $collection_line = new Collection_line;

            $collection_line = DB::table('collection_line')
                ->where('collectionid',$col['collectionid'])
                ->first();

            $result[$key]['entityvalues'] = array(
                'entityvalue1'=>$collection_line->entityvalue1,
                'entityvalue2'=>$collection_line->entityvalue2,
                'entityvalue3'=>$collection_line->entityvalue3
            );
        }

        return response()-> json([
            'status'=>200,
            'data'=>$result,
            'message'=>''
        ]);
    }

    public function reports_orlisting(Request $request)
    {   

        $formData = array(
            'startdate' => $request-> input('startdate'),
            'enddate' => $request-> input('enddate')
        );

        $total = 0;
        $data = [];
        // dd($formData);

        $orlist = DB::table('collection')
            -> leftjoin('collection_category','collection_category.code','=','collection.category')
            ->select ('orno','ordate','collection_category.description as category','amount_paid','collection.created_at');

        if ($formData['startdate'] && $formData['enddate']) {
            $orlist = $orlist
                 ->whereBetween('ordate', [$formData['startdate'], $formData['enddate']]);
        }
        foreach ($orlist->get() as $key => $or) {
            $total += $or->amount_paid;
        }

        $data = array(
            'orlist'=>$orlist->get(),
            'total'=> number_format($total, 2, '.', ','),
            'formData'=>$formData
        );
        return view('collection.reports.orlisting', array('data'=>$data));
    }

    public function delete(Request $request)
    {
        $formData = array(
            'orno'=> $request-> input('orno')
        );

        $isORNoExist = DB::table('transaction')
            -> where('refid',$formData['orno'])
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
            DB::table('collection')
                -> where('orno',$formData['orno'])
                -> update(['deleted'=>1]);
        });

        return response() -> json([
            'status'=>200,
            'data'=>'',
            'message'=>"Successfully deleted."
        ]);
    }
}
