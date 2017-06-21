<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Person;
use App\Person_profile;
use App\Collection;
use App\Collection_line;
use App\Transaction;
use DB;
class PersonController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
    	return view('person.index');
    }

    public function store(Request $request)
    {

    	$validator = Validator::make($request->all(), [
            'action'=>'required',
    		'lname'=>'required|max:100',
    		'fname'=>'required|max:100',
            'type'=>'required'
		]);

        if ($validator->fails()) {
            return response()-> json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);
        }

        $formData = array(
            'personid'              =>$request->input('personid'),
            'action'                =>$request->input('action'),
            'lname'                 =>$request->input('lname'),
            'fname'                 =>$request->input('fname'),
            'mname'                 =>$request->input('mname'),

            'wife_lname'            =>$request->input('wife_lname'),
            'wife_fname'            =>$request->input('wife_fname'),
            'wife_mname'            =>$request->input('wife_mname'),
            'wife_birthday'         =>$request->input('wife_birthday'),

            'wife_contact_mobileno' =>$request->input('wife_contact_mobileno'),
            'wife_email'            =>$request->input('wife_email'),

            'status'                =>$request->input('status'),
            'type'                  =>$request->input('type'),
            'gender'                =>$request->input('gender'),
            'birthday'              =>$request->input('birthday'),
            'address_street'        =>$request->input('address_street'),
            'address_city'          =>$request->input('address_city'),
            'address_province'      =>$request->input('address_province'),
            'contact_mobileno'      =>$request->input('contact_mobileno'),
            'contact_telephoneno'   =>$request->input('contact_telephoneno'),
            'email'                 =>$request->input('email'),
            'year_moved'            =>$request->input('year_moved'),
            'representative'                =>$request->input('representative'),
            'representative_relationship'   =>$request->input('representative_relationship'),
            'representative_contactno'        =>$request->input('representative_contactno')
        );

        $transaction = DB::transaction(function($formData) use($formData){
            $person = new Person;
            
            if ($formData['action'] == 'EDIT') {
                $isPersonExist = DB::table('person')
                    -> where('personid',$formData['personid'])
                    ->first();

                if (!$isPersonExist) {
                    return response()->json([
                        'status' => 403,
                        'data' => 'null',
                        'message' => 'Person doesn\'t exists.'
                    ]);
                }

                DB::table('person')
                    -> where('personid',$formData['personid'])
                    -> update([
                        'lname'=>$formData['lname'],
                        'fname'=>$formData['fname'],
                        'mname'=>$formData['mname']
                    ]);

                DB::table('person_profile')
                    -> where('personid',$formData['personid'])
                    -> where('active',1)
                    -> update([
                        'active'=>0,
                        'dateendeffectivity'=>date('Y-m-d')
                    ]);
                $person->personid = $formData['personid'];

            } else if ($formData['action'] == 'CREATE') {

                $person->lname = $formData['lname'];
                $person->fname = $formData['fname'];
                $person->mname = $formData['mname'];
                $person->type = $formData['type'];
                $person->datestarteffectivity = Carbon::now();
                $person->dateendeffectivity = '2099-12-31';
                $person->createdby = 1;
                $person->save();

                $person->personid = $person->id;
            }


            if ( ($person->id && $formData['action'] == 'CREATE') || ($formData['action'] == 'EDIT') ) {
                $profileFieldCodes = [
                    array('fieldcode'=>'STATUS','fieldname'=>'Civil Status','fieldvalue'=>$formData['status']),
                    array('fieldcode'=>'GENDER','fieldname'=>'Gender','fieldvalue'=>$formData['gender']),
                    array('fieldcode'=>'BIRTHDAY','fieldname'=>'Birthday','fieldvalue'=>$formData['birthday']),
                    array('fieldcode'=>'ADDRESS_STREET','fieldname'=>'Address Street','fieldvalue'=>$formData['address_street']),
                    array('fieldcode'=>'ADDRESS_CITY','fieldname'=>'Address City','fieldvalue'=>$formData['address_city']),
                    array('fieldcode'=>'ADDRESS_PROVINCE','fieldname'=>'Address City','fieldvalue'=>$formData['address_province']),
                    array('fieldcode'=>'CONTACT_MOBILENO','fieldname'=>'Mobile No.','fieldvalue'=>$formData['contact_mobileno']),
                    array('fieldcode'=>'CONTACT_TELEPHONENO','fieldname'=>'Telephone No.','fieldvalue'=>$formData['contact_telephoneno']),
                    array('fieldcode'=>'EMAIL','fieldname'=>'Email','fieldvalue'=>$formData['email']),
                    array('fieldcode'=>'YEAR_MOVED','fieldname'=>'Year moved to Green Ridge','fieldvalue'=>$formData['year_moved']),
                    array('fieldcode'=>'REPRESENTATIVE','fieldname'=>'Authorized Representative','fieldvalue'=>$formData['representative']),
                    array('fieldcode'=>'REPRESENTATIVE_RELATIONSHIP','fieldname'=>'Authorized Representative Relationship.','fieldvalue'=>$formData['representative_relationship']),
                    array('fieldcode'=>'REPRESENTATIVE_CONTACTNO','fieldname'=>'Authorized Representative Contact No.','fieldvalue'=>$formData['representative_contactno']),

                    array('fieldcode'=>'WIFE_LNAME','fieldname'=>'Wife lastname','fieldvalue'=>$formData['wife_lname']),
                    array('fieldcode'=>'WIFE_FNAME','fieldname'=>'Wife firstname','fieldvalue'=>$formData['wife_fname']),
                    array('fieldcode'=>'WIFE_MNAME','fieldname'=>'Wife middlename','fieldvalue'=>$formData['wife_mname']),

                    array('fieldcode'=>'WIFE_BIRTHDAY','fieldname'=>'Birthday','fieldvalue'=>$formData['wife_birthday']),
                    array('fieldcode'=>'WIFE_CONTACT_MOBILENO','fieldname'=>'Mobile No.','fieldvalue'=>$formData['wife_contact_mobileno']),
                    array('fieldcode'=>'WIFE_EMAIL','fieldname'=>'Email','fieldvalue'=>$formData['wife_email']),

                ];

                foreach ($profileFieldCodes as $key => $profile) {
                    $person_profile = new Person_profile;

                    $person_profile->personid   = $person->personid;
                    $person_profile->fieldcode  = $profile['fieldcode'];
                    $person_profile->fieldname  = $profile['fieldname'];
                    $person_profile->fieldvalue = $profile['fieldvalue'];
                    $person_profile->fieldgroup = '01';
                    $person_profile->datestarteffectivity = date('Y-m-d');
                    $person_profile->dateendeffectivity = '2099-12-31';
                    $person_profile->created_at  = date('Y-m-d H:i:s');
                    $person_profile->createdby  = 1;

                    $person_profile->save();
                }
            } else {
                throw new \Exception("Error Processing Request");

                
            }

            return response()->json([
                'status' => 200,
                'data' => 'null',
                'message' => 'Successfully saved.'
            ]);
        });

        return $transaction;
    }

    public function getPersonProfile(Request $request) 
    {
        $personid = $request-> input('personid');
        $type = $request-> input('type');
        $person_profile = DB::select('CALL sp_personprofile(?,?)',array($personid,$type));

        return response()->json([
            'status'=> 200,
            'data'=>$person_profile,
            'message'=>''
        ]);
    }

    public function getPersonCollection(Request $request) 
    {
        $formData = array(
            'personid'=> $request-> input('personid')
        );

        $totalCollection = 0;

        $collection = DB::table('person as p')
            ->select(
                't.transactionid',
                'p.personid',
                'c.orno',
                'c.ordate',
                'c.category',
                'cc.description as description',
                'c.collectionid',
                'c.remarks',
                't.amount')
            ->leftjoin('collection as c', 'c.personid', '=', 'p.personid')
            ->leftjoin('collection_category as cc', 'cc.code', '=', 'c.category')
            ->leftjoin('transaction as t', 't.refid', '=', 'c.orno')
            ->where('t.trantype','COLLECTION')
            ->where('t.posted',1)
            ->where('t.deleted',0);

        if ($formData['personid']) {
            $collection = $collection-> where('c.personid',$formData['personid']);
        }
        $collection = $collection->get();
        $result = json_decode($collection, true);

        foreach ($result as $key => $col) {
            $totalCollection += $col['amount'];
            $collection_line = new Collection_line;

            $collection_line = DB::table('collection_line')
                ->select('entityvalue1','entityvalue2','entityvalue3')
                ->where('collectionid',$col['collectionid'])
                ->where('active',1)
                ->get();

            $collection_line = json_decode($collection_line, true);
            $entityvalues =  array();
            foreach ($collection_line as $key1 => $col_line) {
                $i = $col_line['entityvalue1']."-".$col_line['entityvalue2'];
                array_push($entityvalues, $i);
            }
            $result[$key]['entityvalues_desc'] = implode(",", $entityvalues);
            $result[$key]['entityvalues'] = $collection_line;
        }

        return response()->json([
            'status'=> 200,
            'data'=>array(
                'collection'=> $result,
                'total'=>$totalCollection
            ),
            'message'=>''
        ]);
    }

    public function getMonthlyDues(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'personid'=>'required'
        ]);

        if ($validator-> fails()) {
            return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);
        }

        $formData = array(
            'personid'=> $request->input('personid')
        );

        $transaction = DB::transaction(function($formData) use ($formData) {
            $collection = DB::table('collection as c')
                -> select(
                    'cl.entityvalue1 as month',
                    'cl.entityvalue2 as year',
                    DB::raw('CONCAT(cl.entityvalue1,"-",cl.entityvalue2) as code')
                    )
                ->leftjoin('collection_line as cl','c.collectionid','=','cl.collectionid')
                ->leftjoin('transaction as t','t.refid','=','c.orno')
                ->where('personid',$formData['personid'])
                ->where('c.category','MONTHLYDUES')
                ->where('t.posted',1)
                ->where('active',1)
                ->get();
            return response() ->json([
                'status'=> 200,
                'data'=> array(
                    'monthlydueslist'=>$collection
                ),
                'message'=>''
            ]);
        });

        return $transaction;
    }

    public function getCarSticker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'personid'=>'required'
        ]);

        if ($validator-> fails()) {
            return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);
        }

        $formData = array(
            'personid'=> $request->input('personid')
        );

        $transaction = DB::transaction(function($formData) use ($formData) {
            $collection = DB::table('collection as c')
                -> select(
                    'cl.entityvalue1 as stickerid',
                    'cl.entityvalue2 as plateno',
                    'cl.entityvalue3 as year',
                    DB::raw('CONCAT(cl.entityvalue1,"-",cl.entityvalue3) as code')
                    )
                ->leftjoin('collection_line as cl','c.collectionid','=','cl.collectionid')
                ->leftjoin('transaction as t','t.refid','=','c.orno')
                ->where('personid',$formData['personid'])
                ->where('c.category','CARSTICKER')
                ->where('t.posted',1)
                ->where('active',1)
                ->get();
            return response() ->json([
                'status'=> 200,
                'data'=> array(
                    'carstickerlist'=>$collection
                ),
                'message'=>''
            ]);
        });

        return $transaction;
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'personid'=> 'required'
        ]);

        if ($validator-> fails()) {
            return response()->json([
                'status'=> 403,
                'data'=>'',
                'message'=>'Unable to save.'
            ]);
        }

        $formData = array(
            'personid'=> $request-> input('personid')
        );
        
        $transaction = DB::transaction(function($formData) use($formData){
            $updated = DB::table('person')
                -> where('personid',$formData['personid'])
                -> update(['deleted'=>1]);

            if (!$updated) {
                throw new \Exception("Not updated.");
                
            }
            return response() -> json([
                'status'=>200,
                'data'=>$formData['personid'],
                'message'=>"Successfully deleted."
            ]);
        });
        return $transaction;
    }
}
