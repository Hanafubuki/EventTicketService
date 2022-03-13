<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthsController extends Controller
{

    /**
     * User login's function
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginUserRequest $request)
    {
      //Check if username exists
      $user = User::where('email', $request->input('email'))->first();
      if(!$user){
          return response(['message' => 'User not found'], 404);
      }

      //Check if passwords match
      if (Hash::check($request->input('password'), $user->password)) {
        //Generate login token
        $token = $user->createToken('Access granted')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
      }
      return response(['message' => 'Passwords doesn\'t match'], 404);
    }



    /**
     * Store a newly created user in storage.
     * Hash password before inserting
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterUserRequest $request)
    {
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }


    /**
     * User logout.
     * Remove token from database
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
      $request->user()->token()->revoke();
      $response = ['message' => 'You have been successfully logged out!'];
      return response($response, 200);
    }

}
