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
    //
    public function index()
    {
    	return view('person.index');
    }

    public function store(Request $request)
    {

    	$validator = Validator::make($request->all(), [
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
            ->select('t.transactionid','p.personid','c.orno','c.ordate','cc.description as category','cc.description as description','t.amount')
            ->leftjoin('collection as c', 'c.referenceid', '=', 'p.personid')
            ->leftjoin('collection_category as cc', 'cc.code', '=', 'c.category')
            ->leftjoin('transaction as t', 't.refid', '=', 'c.orno')
            ->where('t.trantype','COLLECTION')
            ->where('t.deleted',0);

        if ($formData['personid']) {
            $collection = $collection-> where('personid',$formData['personid']);
        }
        $collection = $collection->get();

        foreach ($collection as $key => $col) {
            $totalCollection += $col->amount;
        }

        return response()->json([
            'status'=> 200,
            'data'=>array(
                'collection'=> $collection,
                'total'=>$totalCollection
            ),
            'message'=>''
        ]);
    }
}
