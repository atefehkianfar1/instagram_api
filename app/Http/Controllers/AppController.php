<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomClasses\CommentClass;
use App\Http\Controllers\CustomClasses\PostClass;
use App\Http\Controllers\HelperClass\GlobalVariables;
use App\Http\Controllers\HelperClass\JsonResponseClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppController extends Controller
{
    public function __construct()
    {
        $this->user=User::first();
        $this->json=new JsonResponseClass();
        $this->post=new PostClass();
        $this->comment=new CommentClass();
        $this->key=GlobalVariables::$api_key;
    }

    public function post_mine(Request $request){
        $this->validate($request,[
            'token'=>'required'
        ]);
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json($this->json->json_auth(404,'',$user), 404);
        }
        $items = $this->post->mine($user->id);
        return response()->json($this->json->json_items($items,'posts'));
    }
}
