<?php

namespace App\Http\Controllers\CustomClasses;

use App\Http\Controllers\HelperClass\DateTimeClass;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    private function handle_post_items($items){
        foreach ($items as $item){
            $this->handle_post($item);
        }
    }
    private function handle_post($item){
        $this->date->changeTime($item);
        return $item;
    }
}
