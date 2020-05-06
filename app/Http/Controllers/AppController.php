<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomClasses\CommentClass;
use App\Http\Controllers\CustomClasses\PostClass;
use App\Http\Controllers\CustomClasses\UserClass;
use App\Http\Controllers\HelperClass\GlobalVariables;
use App\Http\Controllers\HelperClass\JsonResponseClass;
use App\Http\Controllers\HelperClass\SearchClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppController extends Controller
{
    public function __construct()
    {
        $this->user=new UserClass();
        $this->json=new JsonResponseClass();
        $this->post=new PostClass();
        $this->comment=new CommentClass();
        $this->search=new SearchClass();
        $this->key=GlobalVariables::$api_key;
    }
    //List of posts that belongs to me for profile page
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
    public function post_like(Request $request){
        $this->validate($request,[
            'token'=>'required'
        ]);
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json($this->json->json_auth(404,'',$user), 404);
        }
        $item = $this->post->like_dislike($user->id,$request->post_id);
        return response()->json($this->json->json_response_parameter($item['code'],$item['status']));
    }
    //End Post
    //Search
    public function user_search(Request $request){
        $this->validate($request,[
            'token'=>'required'
        ]);
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json($this->json->json_auth(404,'',$user), 404);
        }
        $items = $this->user->user_search($request->searchText,$user->id);
        return response()->json($this->json->json_items($items,'users'));
    }
    //End Search
    public function user_profile(Request $request){
        $this->validate($request,[
            'token'=>'required'
        ]);
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json($this->json->json_auth(404,'',$user), 404);
        }
        $item = $this->user->profile($request->user_id,$user->id);
        return response()->json($this->json->single_item($item,'user_id :'.$request->user_id));
    }
    //List of user posts that i followed
    public function followed_page_post(Request $request){
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
