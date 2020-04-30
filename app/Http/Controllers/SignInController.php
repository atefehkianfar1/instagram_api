<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelperClass\GlobalVariables;
use App\Http\Controllers\HelperClass\JsonResponseClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class SignInController extends Controller
{
    public function __construct()
    {
        $this->json=new JsonResponseClass();
        $this->key=GlobalVariables::$api_key;
    }
    public function login(Request $request)
    {
        $this->validate($request,[
            'key'=>'required',
            'username'=>'required|max:11',
            'password'=>'required|min:6',
        ]);
        if($request->key!=$this->key)
            return response()->json($this->json->json_response(403));
        if($request->username=='' or $request->password=='')
            return response()->json($this->json->json_auth(403,""));
        $credentials=$request->only('username','password');
        $user = User::where('username', $credentials['username'])->first();
        if(!$user)
            return response()->json($this->json->json_auth(404,"",$user));
        if($user and !Hash::check($credentials['password'], $user->password))
            return response()->json($this->json->json_auth(401,"",$user));
        if (!Hash::check($credentials['password'], $user->password))
            return response()->json($this->json->json_auth(403,"",$user));
        if ($user->active == 0)
            return response()->json($this->json->json_auth(402,"",$user));
        try {
            $token = JWTAuth::fromUser($user);
            return response()->json($this->json->json_auth(200,$token,$user));
        } catch (JWTException $e) {
            return response()->json(['status' => 'Error'], 500);
        }
    }
}
