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
        return view('collection.index') ;
    }

    public function create(Request $request)
    {
        $message = '';

        $validator = Validator::make($request->all(),[
            'amount'=> 'required',
            'category_code'=> 'required',
            'entityvalues'=> 'required',
            'ordate'=> 'required',
            'orno'=> 'required',
            'orno'=> 'required',
            'personid'=> 'required',
            'type'=> 'required'
        ]);

        if ($validator-> fails()) {
            return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);

        }


        $collection = new Collection;
        $collection_line = new Collection_line;

        $data = array();
        $data['orno']           = $request-> input('orno');
        $data['ordate']         = $request-> input('ordate');
        $data['type']           = $request-> input('type');
        $data['personid']       = $request-> input('personid');
        $data['category_code']  = $request-> input('category_code');
        $data['amount']         = $request-> input('amount');
        $data['entityvalues']   = $request-> input('entityvalues');
        $data['remarks']        = $request-> input('remarks');

        if (!$this->orValidations($data)['isvalid']) {
            return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>$this->orValidations($data)['message']
            ]);
        } else {
            // saving collections
            DB::transaction(function($data) use($data){
                // dd($data['orno']);
                $collection = new Collection;
                
                $collection->orno           = $data['orno'];
                $collection->ordate         = $data['ordate'];
                $collection->type           = $data['type'];
                $collection->personid       = $data['personid'];
                $collection->category       = $data['category_code'];
                $collection->amount         = $data['amount'];
                $collection->remarks        = $data['remarks'];
                
                $collection->save();

                if($collection->id)
                {
                    if ($data['entityvalues'][0]['entityvalue1']) {
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

    public function update(Request $request)
    {
        $message = '';

        $validator = Validator::make($request->all(),[
            'amount'=> 'required',
            'category_code'=> 'required',
            'entityvalues'=> 'required',
            'ordate'=> 'required',
            'orno'=> 'required',
            'orno'=> 'required',
            'personid'=> 'required',
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
            $data['action']        = 'EDIT';
            $data['collectionid']   = $request-> input('collectionid');
            $data['orno']           = $request-> input('orno');
            $data['ordate']         = $request-> input('ordate');
            $data['type']           = $request-> input('type');
            $data['personid']       = $request-> input('personid');
            $data['category_code']  = $request-> input('category_code');
            $data['amount']         = $request-> input('amount');
            $data['entityvalues']   = $request-> input('entityvalues');
            $data['remarks']        = $request-> input('remarks');

            if (!$this->orValidations($data)['isvalid']) {
                return response()->json([
                    'status'=> 403,
                    'data'=>'',
                    'message'=>$this->orValidations($data)['message']
                ]);

            }

            $transaction = DB::transaction(function($data) use($data){
                $collection = new Collection;
                
                $collectionUpdated = DB::table('collection')
                    -> where('collectionid',$data['collectionid'])
                    -> update([
                        'ordate'            =>$data['ordate'],
                        'type'              =>$data['type'],
                        'personid'          =>$data['personid'],
                        'category'          =>$data['category_code'],
                        'amount'            =>$data['amount'],
                        'remarks'           =>$data['remarks']
                    ]);

                $collection_lineUpdated = DB::table('collection_line')
                    -> where('collectionid',$data['collectionid'])
                    -> update(['active'=>0]);

                if ($data['entityvalues'][0]['entityvalue1']) {
                    foreach ($data['entityvalues'] as $key => $entityvalue) {
                        $collection_line = new Collection_line;

                        $collection_line->collectionid = $data['collectionid'];
                        $collection_line->entityvalue1 = $entityvalue['entityvalue1'];
                        $collection_line->entityvalue2 = $entityvalue['entityvalue2'];
                        $collection_line->entityvalue3 = $entityvalue['entityvalue3'];
                        $collection_line->save();

                        if (!$collection_line->id) {
                            throw new \Exception('Collection line not created.');
                        }
                    } 
                }
                return response()->json([
                    'status'=> 200,
                    'data'=>'',
                    'message'=>'Successfully updated.'
                ]);
            });
            
            return $transaction;
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
                // DB::raw('CAST(orno as UNSIGNED) as orno'),
                'orno',
                'collection.personid',
                DB::raw('CONCAT(person.lname,", ",person.fname, " ",COALESCE(person.mname,"")) as fullname'),
                'collection.type',
                'ordate',
                'collection_category.description as category_description', 
                'collection_category.code as category_code',
                DB::raw('CAST(collection.amount as DECIMAL(18,2)) as amount'),

                'posted',
                'posted',
                'collection.deleted',
                'remarks',
                'collection.created_at')
            -> leftjoin('collection_category','collection_category.code','=','collection.category')
            -> leftjoin('person', 'person.personid','=','collection.personid')
            -> where('collection.deleted',0)
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
                ->select('entityvalue1','entityvalue2','entityvalue3')
                ->where('collectionid',$col['collectionid'])
                ->where('active',1)
                ->get();
            $result[$key]['entityvalues'] = $collection_line;
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
            ->select (
                'orno',
                'ordate',
                'collection_category.description as category',
                'collection.amount','collection.created_at')
            -> leftjoin('collection_category','collection_category.code','=','collection.category')
            -> where('collection.posted',1);

        if ($formData['startdate'] && $formData['enddate']) {
            $orlist = $orlist
                 ->whereBetween('ordate', [$formData['startdate'], $formData['enddate']]);
        }
        foreach ($orlist->get() as $key => $or) {
            $total += $or->amount;
        }

        $data = array(
            'orlist'=>$orlist->get(),
            'total'=> number_format($total, 2, '.', ','),
            'formData'=>$formData
        );
        return view('collection.reports.orlisting', array('data'=>$data));
    }

    public function reports_orcategorysummary(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'datestart'=> 'required',
            'dateend'=> 'required',
        ]);

        if ($validator->fails()) {
            throw new \Exception("Error Processing Request", 1);
        }
        $formData = array(
            'datestart'=> $request->input('datestart'),
            'dateend'=> $request->input('dateend'),
        );

        $category = DB::select('CALL sp_categorysummary(?,?)',array($formData['datestart'],$formData['dateend']));

        $data = array(
            'categorylist'=>$category,
            'formData'=>$formData
        );

        return response() -> json([
            'status'=>200,
            'data'=>array(
                'categorysummarylist'=>$category),
            'message'=>''
        ]);

    }
    public function delete(Request $request)
    {
        $formData = array(
            'orno'=> $request-> input('orno')
        );

        $isORNoExist = DB::table('transaction')
            -> where('refid',$formData['orno'])
            ->where('trantype','COLLECTION')
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

    public function orValidations($data){
        $validation = array(
            'isvalid'=>true
        );

        $collection = new Collection;
        $collection_line = new Collection_line;

        $orCollectionType= substr($data['orno'],0,3);
        $collectionTypeList = array('SI-','OR-');
        if (!in_array($orCollectionType, $collectionTypeList)) {
            $validation['isvalid'] = false;
            $validation['message'] = "OR no. {$data['orno']} is not valid. Should begin with SI- or OR-.";
        }

        $orMonthYear = date('Ym',strtotime($data['ordate']));

        $isClosed = DB::table('transaction')
            ->where('trantype','CLOSING')
            ->where('refid',$orMonthYear)
            ->where('posted',1)
            ->where('deleted',0)
            ->first();

        if ($isClosed) {
            $validation['isvalid'] = false;
            $validation['message'] = date('F Y',strtotime($data['ordate']))." already closed. Can't create any transaction.";
        }

        $getLastPostMonth = DB::table('transaction')
            ->where('trantype','CLOSING')
            ->where('trantype1','<>','BEGBAL')
            ->where('posted',1)
            ->where('deleted',0)
            ->orderBy('refid','DESC')
            ->first();

        if ($getLastPostMonth) {
            $postMonth = $getLastPostMonth->refid;
            if ($postMonth > $orMonthYear) {
                $validation['isvalid'] = false;
                $validation['message'] = "OR Date is ealier than current month is not allowed.";
            }
        }

        $isOrnoExist = $collection
                    -> where('orno','=',$data['orno'])
                    -> where('deleted',0)
                    -> first();

        if ($isOrnoExist && $data['action'] !='EDIT') {
            $validation['isvalid'] = false;
            $validation['message'] = "OR no. {$data['orno']} is already exists.";
        }
        return $validation;
    }
}
