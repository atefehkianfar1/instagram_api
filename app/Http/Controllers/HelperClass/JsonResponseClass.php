<?php

namespace App\Http\Controllers\HelperClass;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\Array_;

class JsonResponseClass
{
    //all json responses
    public function json_response($status){
        switch ($status){
            case 200:
                $json=[
                    "title"=>"موفق",
                    "msg"=>"عملیات با موفقیت انجام شد",
                    "content"=>[],
                    "status"=>'success',
                    "code"=>200,
                    "http_code"=>200,
                ];
                break;
            case 201:
                $json=[
                    "title"=>"موجودی کافی نیست",
                    "msg"=>"ابتدا کیف پول خود را شارژ کنید ، سپس مجددا تلاش کنید",
                    "content"=>[],
                    "status"=>'success',
                    "code"=>200,
                    "http_code"=>200,
                ];
                break;
            case 300:
                $json=1;
                break;
            case 400:
                $json=[
                    "title"=>"خطایی رخ داده",
                    "msg"=>"لطفا با پشتیبانی تماس بگیرید",
                    "content"=>[],
                    "status"=>'error',
                    "code"=>400,
                    "http_code"=>400,
                ];
                break;
            case 401:
                $json=[
                    "title"=>"اجازه دسترسی ندارید",
                    "msg"=>"نام پارامتر مورد نظر را اشتباه وارد کرده اید",
                    "content"=>[],
                    "status"=>'error',
                    "code"=>401,
                    "http_code"=>401,
                ];
                break;
            case 402:
                $json=[
                    "title"=>"اجازه دسترسی ندارید",
                    "msg"=>"آیتمی که قصد حذف یا لغو آن را دارید در جایی مورد استفاده قرار گرفته است بنابراین اجازه حذف آن را ندارید",
                    "content"=>[],
                    "status"=>'error',
                    "code"=>402,
                    "http_code"=>402,
                ];
                break;
            case 403:
                $json=[
                    "title"=>"اجازه دسترسی ندارید",
                    "msg"=>"",
                    "content"=>[],
                    "status"=>'access_denied',
                    "code"=>403,
                    "http_code"=>403,
                ];
                break;
            case 404:
                $json=[
                    "title"=>"موردی یافت نشد",
                    "msg"=>"پارامتر ارسالی را مجددا چک کنید",
                    "content"=>[],
                    "status"=>'not_found',
                    "code"=>404,
                    "http_code"=>404,
                ];
                break;
            case 406:
                $json=[
                    "title"=>"موجودی کافی نیست",
                    "msg"=>"",
                    "content"=>[],
                    "status"=>'not_enough',
                    "code"=>4046,
                    "http_code"=>406,
                ];
                break;
            case 422:
                $json=[
                    "title"=>"تکراری می باشد",
                    "msg"=>"اطلاعاتی با این مقادیر قبلا درج شده است",
                    "content"=>[],
                    "status"=>'exist',
                    "code"=>422,
                    "http_code"=>422,
                ];
                break;
            case 503:
                $json=[
                    "title"=>"wrong url",
                    "msg"=>"Check the url",
                    "content"=>[],
                    "status"=>'wrong_url',
                    "code"=>503,
                    "http_code"=>503,
                ];
                break;
            //upload file responses
            case 600:
                $json=[
                    "title"=>"فایلی یافت نشد",
                    "msg"=>"فایلی برای آپلود انتخاب نشده است",
                    "content"=>[],
                    "status"=>'file_not_fount',
                    "code"=>600,
                    "http_code"=>600,
                ];
                break;
            case 601:
                $json=[
                    "title"=>"یک یا تعداد از تصاویر اپلود نشد",
                    "msg"=>"در فرآیند آپلود فایل خطایی رخ داده ، با پشتیبانی تماس بگیرید",
                    "content"=>[],
                    "status"=>'not_uploaded',
                    "code"=>600,
                    "http_code"=>600,
                ];
                break;
            case 602:
                $json=[
                    "title"=>"فرمت غیر مجاز",
                    "msg"=>"فایلی که انتخاب میکنید باید یکی از فرمتهای مجاز باشد",
                    "content"=>[],
                    "status"=>'wrong_format',
                    "code"=>602,
                    "http_code"=>602,
                ];
                break;
            case 603:
                $json=[
                    "title"=>"حجم فایل بیش از حد مجاز است",
                    "msg"=>"اندازه تصویر را تغییر داده و مجددا اقدام کنید",
                    "content"=>[],
                    "status"=>'large_file',
                    "code"=>603,
                    "http_code"=>603,
                ];
                break;
            default:
                $json=[
                    "title"=>"کد نامعتبر است",
                    "msg"=>"کد در کلاس ریسپانس تعریف نشده است",
                    "content"=>['با پشتیبانی تماس بگیرید'],
                    "status"=>'wrong_code',
                    "code"=>000,
                    "http_code"=>000,
                ];
        }
        return $json;
    }
    //json response structure is same for all GET json responses
    public function json_items($items,$title){
        if(sizeof($items)>0)
            $json=[
                "title"=>"List of ".$title,
                "msg"=>"",
                "status"=>'success',
                "code"=>200,
                "http_code"=>200,
                "content"=>$items,
            ];
        else
            $json=[
                "title"=>"There is no item",
                "msg"=>"",
                "status"=>'not_found',
                "code"=>200,
                "http_code"=>200,
                "content"=>[],
            ];
        return $json;
    }
    public function single_item($item,$title)
    {
        if(is_array($item)==false and !empty($item))
            $item=$item->toArray();
        if($item!=404 and !empty($item) and sizeof($item)>0)
            $json=[
                "title"=>"Info of ".$title,
                "msg"=>"",
                "status"=>'success',
                "code"=>200,
                "http_code"=>200,
                "content"=>$item,
            ];
        else {
            $array=new Arr();
            $json=[
                "title"=>"There is no item",
                "msg"=>"",
                "status"=>'not_found',
                "code"=>404,
                "http_code"=>404,
                "content"=>$array,
            ];
        }
        return $json;
    }
    public function json_response_parameter($status,$content)
    {
        switch ($status){
            case 200:  //single content : needs to have [] to have the same response structure
                $json=[
                    "title"=>"موفق",
                    "msg"=>"عملیات با موفقیت انجام شد",
                    "content"=>[$content],
                    "status"=>'success',
                    "code"=>200,
                    "http_code"=>200,
                ];
                break;
            case 202:  //single content : needs to have [] to have the same response structure
                $json=[
                    "title"=>"موفق",
                    "msg"=>"عملیات با موفقیت انجام شد",
                    "content"=>$content,
                    "status"=>'success',
                    "code"=>200,
                    "http_code"=>200,
                ];
                break;
            case 201: //same as 200 but for array of content
                $json=[
                    "title"=>"موفق",
                    "msg"=>"عملیات با موفقیت انجام شد",
                    "content"=>$content,
                    "status"=>'success',
                    "code"=>200,
                    "http_code"=>200,
                ];
                break;
            case 400:
                $json=[
                    "title"=>"خطایی رخ داده است",
                    "msg"=>"پیغام خطا : ".$content,
                    "content"=>[],
                    "status"=>'error',
                    "code"=>400,
                    "http_code"=>400,
                ];
                break;

            case 403:
                $json=[
                    "title"=>"اجازه دسترسی ندارید",
                    "msg"=>"پیغام خطا : ".$content,
                    "content"=>[],
                    "status"=>'error',
                    "code"=>403,
                    "http_code"=>403,
                ];
                break;
            case 404:
                $json=[
                    "title"=>"موردی یافت نشد",
                    "msg"=>"پارامتر ارسالی را مجددا چک کنید",
                    "content"=>[$content],
                    "status"=>'not_found',
                    "code"=>404,
                    "http_code"=>404,
                ];
                break;
            case 401:
                $array=new Arr();
                $json=[
                    "title"=>"موردی یافت نشد",
                    "msg"=>"پارامتر ارسالی را مجددا چک کنید",
                    "content"=>$array,
                    "status"=>'not_found',
                    "code"=>404,
                    "http_code"=>404,
                ];
                break;
            case 405:
                $json=[
                    "title"=>"خطایی به شرح زیر رخ داده است",
                    "msg"=>"سبد خریدی با این شماره وجود داره ولی مرحله اتمام خرید را پشت سر گذاشته است لطفا فیلد کوکی را خالی ارسال کنید تا سبد خرید جدیدی برای شما ایجاد شود",
                    "content"=>[$content],
                    "status"=>'basket_paid',
                    "code"=>405,
                    "http_code"=>405,
                ];
                break;
            case 406:
                $json=[
                    "title"=>"موجودی انبار کافی نیست",
                    "msg"=>$content,
                    "content"=>[],
                    "status"=>'not_enough',
                    "code"=>406,
                    "http_code"=>406,
                ];
                break;
            case 407:
                $json=[
                    "title"=>"موجودی کیف پول شما کافی نیست . کیف پول خود را شارژ کنید یا نوع پرداخت را تغییر دهید.",
                    "msg"=>'موجودی فعلی شما :'.$content.' تومان میباشد :',
                    "content"=>[url('/').'user/wallet/charge'],
                    "status"=>'not_enough',
                    "code"=>406,
                    "http_code"=>406,
                ];
                break;
            case 408:
                $json=[
                    "title"=>"تراکنش مورد نظر موفق نیست",
                    "msg"=>"",
                    "content"=>[$content],
                    "status"=>'transaction_failed',
                    "code"=>408,
                    "http_code"=>408,
                ];
                break;
            case 409:
                $json=[
                    "title"=>"کاربر از تراکنش انصراف داد",
                    "msg"=>"",
                    "content"=>[$content],
                    "status"=>'price_shortage',
                    "code"=>409,
                    "http_code"=>409,
                ];
                break;
            case 422:
                //it's a single item so needs []
                if(is_integer($content))
                    $content=[$content];
                $json=[
                    "title"=>"تکراری می باشد",
                    "msg"=>"اطلاعاتی با این مقادیر قبلا درج شده است",
                    "content"=>$content,
                    "status"=>'exist',
                    "code"=>422,
                    "http_code"=>422,
                ];
                break;
            case 602:
                //it's a single item so needs []
                if(is_integer($content))
                    $content=[$content];
                $json=[
                    "title"=>"خطایی رخ داده",
                    "msg"=>"فرمت فایل مجاز نیست",
                    "content"=>$content,
                    "status"=>'exist',
                    "code"=>422,
                    "http_code"=>422,
                ];
                break;
            default:
                $json=[
                    "title"=>"کد نامعتبر است",
                    "msg"=>"کد در کلاس ریسپانس تعریف نشده است",
                    "content"=>[],
                    "status"=>'wrong_code',
                    "code"=>000,
                    "http_code"=>000,
                ];
        }
        return $json;
    }
    public function method_response($status,$content)
    {
        $response=[
            "status" => $status,
            "content" => $content
        ];
        return $response;
    }
    public function payment_json($status,$url)
    {
        switch ($status){
            case 200:
                $json=[
                    'title'=>'آماده پرداخت',
                    'msg'=>'برای ارجاع به درگاه پرداخت لینک زیر را در مرورگر باز کنید',
                    "content"=>$url,
                    "status"=>'success',
                    "code"=>200,
                    "http_code"=>200,
                ];
                break;
            default:
                $json=[
                    'title'=>'خطایی رخ داده است',
                    'msg'=>'امکان پرداخت نمیباشد',
                    'status'=>$status,
                    "url"=>''
                ];
        }
        return $json;
    }
    public function payment_check($status,$transaction_code,$tracking_code)
    {
        switch ($status){
            case 100:
                $json=[
                    'title'=>'موفق شدید',
                    'msg'=>'پرداخت با موفقیت انجام شد',
                    'transaction_code'=>$transaction_code,
                    "tracking_code"=>$tracking_code,
                    'status'=>'success',
                    'code'=>200,
                ];
                break;
            case 103:
                $json=[
                    'title'=>'پرداخت توسط کاربر لغو شد',
                    'msg'=>'پرداخت توسط کاربر لغو شد',
                    'transaction_code'=>'',
                    "tracking_code"=>'',
                    'status'=>'cancel',
                    'code'=>103,
                ];
                break;
            default:
                $json=[
                    'title'=>'پرداخت انجام نشد',
                    'msg'=>'پرداخت با انجام نشد با پشتیبانی تماس بگیرید',
                    'transaction_code'=>'',
                    "tracking_code"=>'',
                    'status'=>'error',
                    'code'=>400,
                ];
        }
        return $json;
    }

    public function json_auth($status,$token,$user)
    {
        $empty_user=new Arr();
        switch ($status) {
            case 200:
                $json = [
                    "title" => "عملیات موفق",
                    "msg" => "pick the token from content field",
                    "content" => $token,
                    "user" => $user,
                    "status" => 'success',
                    "code" => 200,
                    "http_code" => 200,
                ];
                break;
            case 400:
                $json = [
                    "title" => "خطایی رخ داده است",
                    "msg" => "خطایی رخ داده است با پشتیبانی تماس بگیرید",
                    "content" => "",
                    "user" => $empty_user,
                    "status" => 'error',
                    "code" => 400,
                    "http_code" => 400,
                ];
                break;
            case 401:
                $json = [
                    "title" => "رمز عبور اشتباه است",
                    "msg" => "رمز عبور را اشتباه وارد کرده اید",
                    "content" => "",
                    "user" => $empty_user,
                    "status" => 'wrong_password',
                    "code" => 401,
                    "http_code" => 401,
                ];
                break;
            case 402:
                $json = [
                    "title" => "کاربر غیرفعال است",
                    "msg" => "",
                    "content" => "",
                    "user" => $empty_user,
                    "status" => 'inactive',
                    "code" => 402,
                    "http_code" => 402,
                ];
                break;
            case 403:
                $json = [
                    "title" => "عملیات ناموفق",
                    "msg" => "اطلاعاتی که وارد کرده اید معتبر نیست",
                    "content" => "",
                    "user" => $empty_user,
                    "status" => 'invalid_credentials',
                    "code" => 403,
                    "http_code" => 403,
                ];
                break;
            case 404:
                $json = [
                    "title" => "عملیات ناموفق",
                    "msg" => "اطلاعاتی که وارد کرده اید معتبر نیست",
                    "content" => "",
                    "user" => $empty_user,
                    "status" => 'invalid_credentials',
                    "code" => 404,
                    "http_code" => 404,
                ];
                break;
            default:
                $json=1;
        }
        return $json;
    }

    public function basket_json($status,$item)
    {
        switch ($status) {
            case 200:
                $json=[
                    "title"=>"موفق",
                    "msg"=>"سبد خرید بروزرسانی شد",
                    "content"=>[$item],
                    "status"=>'success',
                    "code"=>200,
                    "http_code"=>200,
                ];
                break;
            case 201:
                $json=[
                    "title"=>"نا موفق",
                    "msg"=>"محصولی با این مشخصات قبلا به سبد خرید شما اضافه شده است",
                    "content"=>[$item],
                    "status"=>'warning',
                    "code"=>201,
                    "http_code"=>201,
                ];
                break;
            case 401:
                $json=[
                    "title"=>"فیلدهای ستاره دار را انتخاب کنید",
                    "msg"=>"",
                    "content"=>[$item],
                    "status"=>'warning',
                    "code"=>401,
                    "http_code"=>401,
                ];
                break;
            case 406:
                $json=[
                    "title"=>"موجودی کافی نیست",
                    "msg"=>$item,
                    "content"=>[],
                    "status"=>'warning',
                    "code"=>406,
                    "http_code"=>406,
                ];
                break;
            case 407:
                $json=[
                    "title"=>"موجودی انبار کافی نیست!",
                    "msg"=> "موجودی انبار ".$item['supply_count'].' مورد میباشد'."\n".
                        $item['basket_item_count']." مورد از این کالا در سبد خرید شما موجود است"."\n",
//                    "تنها اجازه اضافه کردن".($item['supply_count']-$item['basket_item_count'])." مورد دیگر را دارید",
                    "content"=>[],
                    "status"=>'warning',
                    "code"=>407,
                    "http_code"=>407,
                ];
                break;
            default:
                $json=[
                    "title"=>"کد نامعتبر است",
                    "msg"=>"کد در کلاس ریسپانس تعریف نشده است",
                    "content"=>['با پشتیبانی تماس بگیرید'],
                    "status"=>'wrong_code',
                    "code"=>000,
                    "http_code"=>000,
                ];
        }
        return $json;
    }

}
