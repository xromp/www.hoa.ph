<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use DB;
use Hash;

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

        if (Auth::attempt(['username' => 'admin','password'=>$formData['password']])) {
            return response() ->json([
                'status'=>200,
                'message'=>'Successfully login.',
                'data'=>''
            ]);
        } else {
            return response() ->json([
                'status'=>403,
                'message'=>'Login failed.',
                'data'=>''
            ]);
        }
    }
}
