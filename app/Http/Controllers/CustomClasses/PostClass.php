<?php

namespace App\Http\Controllers\CustomClasses;

use App\Http\Controllers\HelperClass\DateTimeClass;
use App\Models\Post;
use App\Models\UserLike;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PostClass extends Controller
{
    public function __construct()
    {
        $this->date=new DateTimeClass();
    }
    public function mine($user_id){
        $items= Post::where('user_id',$user_id)->with('user','files')->get();
        $this->handle_post_items($items);
        return $items;
    }
    public function user_posts($user_id,$me_id){
        $items=Post::where('user_id',$user_id)->with('files')->get();
        $this->handle_post_items($items,$me_id);
        return $items;
    }
    public function handle_post_items($items,$me_id){
        foreach ($items as $item){
            $this->handle_post($item,$me_id);
        }
    }
    public function handle_post($item,$me_id){
        $this->date->changeTime($item);
        if(UserLike::where([['post_id',$item->id],['user_id',$me_id]])->first())
            $item->liked=true;
        else $item->liked=false;
        $item->user;
        return $item;
    }
    public function like_dislike($user_id,$post_id){
        if($item=UserLike::where([['post_id',$post_id],['user_id',$user_id]])->delete())
            return [
                'status' => 'dislike',
                'code' => 202
            ];
        $item=new UserLike();
        $item->post_id = $post_id;
        $item->user_id=$user_id;
        $item->save();
        return [
            'status' => 'like',
            'code' => 202
        ];
    }
}
