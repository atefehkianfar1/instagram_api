<?php

namespace App\Http\Controllers\CustomClasses;

use App\Models\PostFile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserClass extends Controller
{
    //Start Search
    public function user_search($text,$me_id){
        $items=User::where([['name','like', '%'.$text.'%'],['active',1]])
            ->orWhere([['username','like', '%'.$text.'%'],['active',1]])->get();
        $this->handle_user_items_search($items,$me_id);
        return $items;
    }
    public function handle_user_items_search($items,$me_id){
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
    //End  Search
    //Start  Profile
    public function profile($user_id,$me_id){
        $user=User::where('id',$user_id)->first();
        $this->handle_user($user,$me_id);
        $post_object=new PostClass();
        $user->posts=$post_object->user_posts($user_id,$me_id);
        return $user;
    }
}
