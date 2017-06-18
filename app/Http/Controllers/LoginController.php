<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use DB;

class LoginController extends Controller
{
    public function index()
    {
    	return view('login.login');
    }

    public function login(Request $request)
    {
        $formData = array(
            'username'=> $request->input('username'),
            'password'=> $request->input('password'),
        );
    	$login = DB::table('user')
            -> where('username',$formData['username'])
            -> where('password',$formData['password'])
    		->first();

        if (!$login) {
            return response() ->json([
                'status'=>403,
                'message'=>'Login failed.',
                'data'=>''
            ]);
        }

        return response() ->json([
            'status'=>200,
            'message'=>'Successfully login.',
            'data'=>''
        ]);
    	
    }
}
