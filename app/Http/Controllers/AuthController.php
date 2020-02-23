<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
	public function show(Request $request){
		$userInfo = User::with('userRole.role')->where('id', Auth::user()->id)->first();
		return response()->json([
			'role' => $userInfo->userRole->role->name			
		]);
	}

    public function create(Request $request){
    	// ------------------------------------------------------------------------------------
    	// LOGIN AUTHENTICATION LOGIC
    	// ------------------------------------------------------------------------------------
    	if($request->action == 'login'){
    		$userData = array(
	            'email' => strtolower($request->email),
	            'password' => $request->password,
	        );

    		if(Auth::attempt($userData, true)){
	            $user = User::with('userRole.role')->select("*")->where('email', '=' ,$request->email)->first();
	    		
	    		return response()->json([
	    			'token' => $user->createToken('Tokenizer')->accessToken,
	    			'user_info' => Auth::user(),
	    			'role' => $user->userRole->role->name
	    		]);
	        }
	        else{
	            return response()->json([
	            	'errorMsg' => 'The provided credentials are invalid.',
	            	'request' => $request->all()
	            ], 403);
	        }
    	}
    	if($request->action == 'logout'){
    		$request->user()->token()->revoke();
    		return response()->json([
				'action' => 'logout'
			]);
    	}
    	// ------------------------------------------------------------------------------------
    }

    public function delete(){

    }
}
