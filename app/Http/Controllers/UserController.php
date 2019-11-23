<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\UserRole;
use Auth;
use Validator;

class UserController extends Controller
{
    public function show(Request $request){
    	$users = User::with('userRole.role')->where('id', '!=', Auth::user()->id)->get();
    	return response()->json([
    		'users' => $users
    	]);
    }

    public function create(Request $request){
    	$validator = Validator::make($request->all(), [
    					'first_name' => 'required',
    					'last_name' => 'required',
    					'email' => 'required',
    					'role' => 'required|in:'.implode(',', ['1', '2'])
    				 ]);

    	if($validator->fails()){
    		return response()->json([
    			'errors' => $validator->messages()
    		], 422);
    	}

    	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $tempPassword = '';
        for ($counter = 0; $counter <= 11; $counter++) {
            $tempPassword .= $characters[rand(0, $charactersLength - 1)];
        }

    	$user = new User();
    	$user->email = $request->email;
    	$user->profile = [
    						'first_name' => $request->first_name,
    						'last_name' => $request->last_name
    					 ];
    	$user->password = bcrypt($tempPassword);
    	$user->save();


    	$userRole = new UserRole();
    	$userRole->role_id = $request->role;
    	$userRole->user_id = $user->id;
    	$userRole->save();


    	$userInfo = User::with('userRole.role')
    				->where('id', $user->id)
    				->first();

    	return response()->json([
			'user' => 'create!',
			'userInfo' => $userInfo
		]);
    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}
