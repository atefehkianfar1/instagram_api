<?php

namespace App\Http\Controllers\CustomClasses;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserClass extends Controller
{
    public function handle_user_items($items,$me_id){
        foreach ($items as $item){
            $this->handle_user($item,$me_id);
        }
    }
    public function handle_user($item,$me_id){
        $user=DB::table('user_follow')->where([['me_id',$me_id],['user_id',$item->id]])->first();
        if($user){
            $item->followed=true;
        } else $item->followed=false;
        return $item;
    }
    public function profile($user_id,$me_id){
        $item=User::where('id',$user_id)->with('posts')->first();
        $post_object=new PostClass();
        $post_object->handle_post_items($item->posts);
        $this->handle_user($item,$me_id);
        return $item;
    }
}
