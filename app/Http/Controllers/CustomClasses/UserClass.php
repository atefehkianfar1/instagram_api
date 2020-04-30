<?php

namespace App\Http\Controllers\CustomClasses;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserClass extends Controller
{
    public function mine($user_id){
        return Post::where('user_id',$user_id)->get();
    }
}
