<?php

namespace App\Http\Controllers\HelperClass;

use App\Http\Controllers\CustomClasses\UserClass;
use App\Http\Controllers\v1\NewsClass;
use App\Http\Controllers\v1\PageClass;
use App\Http\Controllers\v1\ProductClass;
use App\Models\File;
use App\Models\News;
use App\Models\Page;
use App\Models\Product;
use App\Models\Tag;
use App\User;
use Illuminate\Support\Facades\DB;


class SearchClass
{
    function __construct()
    {
//        $this->page=new PageClass();
//        $this->product=new ProductClass();

    }
    public function search_text($request){

    }

//    public function location($city_id,$user_id){
//        $items=News::where([['city_id',$city_id],['active',1]])->get();
//        $news=new NewsClass();
//        $news->handle_news_items($items,$user_id,1);
//        $this->handel_type($items,'news');
//        return $items;
//    }
    /**
     * @param $type : news / product
     * @param $text
     */
//    private function tags($type,$text){
//       $id=Tag::where([['type',$type],['content','like', '%'.$text.'%']])->get()->pluck('main_id');
//        if($type=='news')
//        {
//            $items=News::whereIn('id',$id)->where('active',1)->get();
//            $this->handel_type($items,'news');
//        }
//        else{
//            $items=Product::whereIn('id',$id)->where('active',1)->get();
//            $this->handel_type($items,'product');
//        }
//        return $items->sortByDesc('created_at');
//    }
    public function users($text,$me_id){
        $items=User::where([['name','like', '%'.$text.'%'],['active',1]])
            ->orWhere([['username','like', '%'.$text.'%'],['active',1]])->get();
        $user_object=new UserClass();
        $user_object->handle_user_items($items,$me_id);
        return $items;
    }

//    public function products($text,$user_id){
//        $items=Product::where([['title','like', '%'.$text.'%'],['active',1]])
//            ->orWhere([['content','like', '%'.$text.'%'],['active',1]])->get();
//        //Search in tags too
//        $id=Tag::where([['type','product'],['content','like', '%'.$text.'%']])->get()->pluck('main_id');
//        $items2=Product::whereIn('id',$id)->where('active',1)->get();
//        $items=$items->merge($items2); //merge all news together
//
//        $this->product->handle_product_items($items,$user_id,1);
//        $this->handel_type($items,'product');
//        return $items->sortByDesc('id');
//    }
//    public function pages($text,$user_id){
//        $items=Page::where([['title','like', '%'.$text.'%'],['active',1]])
//            ->orWhere([['name','like', '%'.$text.'%'],['active',1]])->get();
//        $this->page->handle_page_items($items,$user_id);
//        $this->handel_type($items,'page');
//        return $items;
//    }
//    public function news_paginate($from,$size,$text,$user_id){
//        $items=News::where([['title','like', '%'.$text.'%'],['active',1]])
//            ->orWhere([['content','like', '%'.$text.'%'],['active',1]])->get();
//        //Search in tags too
//        $id=Tag::where([['type','news'],['content','like', '%'.$text.'%']])->get()->pluck('main_id');
//        $items2=News::whereIn('id',$id)->where('active',1)->get();
//        $items=$items->merge($items2); //merge all news together
//
//        $this->news->handle_news_items($items,$user_id,1);
//        $items=$items->where('row_id','>=',$from)->take($size);
//        $this->handel_type($items,'news');
//        return $items->sortByDesc('created_at')->values();
//    }
//    public function products_paginate($from,$size,$text,$user_id){
//        $items=Product::where([['title','like', '%'.$text.'%'],['active',1]])
//            ->orWhere([['content','like', '%'.$text.'%'],['active',1]])->get();
//        //Search in tags too
//        $id=Tag::where([['type','product'],['content','like', '%'.$text.'%']])->get()->pluck('main_id');
//        $items2=Product::whereIn('id',$id)->where('active',1)->get();
//        $items=$items->merge($items2); //merge all news together
//
//        $this->product->handle_product_items($items,$user_id,1);
//        $items=$items->where('row_id','>=',$from)->take($size);
//        $this->handel_type($items,'product');
//        return $items->sortByDesc('id')->values();
//    }
//    public function pages_paginate($from,$size,$text,$user_id){
//        $items=Page::where([['title','like', '%'.$text.'%'],['active',1]])
//            ->orWhere([['name','like', '%'.$text.'%'],['active',1]])->get();
//        $this->page->handle_page_items($items,$user_id);
//        $items=$items->where('row_id','>=',$from)->take($size);
//        $this->handel_type($items,'page');
//        return $items;
//    }
    //it will search among products news pages and tags
//    public function general($text,$user_id)
//    {
//        $products=$this->products($text);
//        $news=$this->news($text);
//        $pages=$this->pages($text);
//        $tag1=$this->tags('news',$text);
//        $tag2=$this->tags('products',$text);
//        $items=collect($products)->merge($news)->merge($tag1)->merge($tag2)->merge($pages);
//        //remove duplicate records
//        $items = $items->unique()->values()->all();
//
//        $news=new NewsClass();
//        foreach ($items as $item){
//            if($item->item_type=='news')
//            {
//                $news->handle_news($item,$user_id,1);
//            }
//        }
//        return $items;
//    }
    private function handel_type($items,$type):void{
        foreach ($items as $item){
            $item->item_type=$type;
        }
    }
}
