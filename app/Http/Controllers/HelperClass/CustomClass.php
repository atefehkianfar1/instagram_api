<?php

namespace App\Http\Controllers\HelperClass;

use App\Models\Basket;
use App\Models\City;
use App\Models\Cookie;
use App\Models\Order;
use App\Models\Store;
use App\Models\Wallet;
use App\Models\WalletCookie;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kavenegar;
use Larabookir\Gateway\Exceptions\RetryException;

class CustomClass
{
    public function sms($users,$msg)
    {
        $users=User::whereIn('id',$users)->get();
        $store=Store::first();
        foreach($users as $user)
        {
            $this->normal_send_sms($msg,$user->cellphone);
        }
        $json=new JsonResponseClass();
        return $json->method_response(200, '');
    }
    public function push_notification($users,$title,$msg)
    {
        $users=User::whereIn('id',$users)->get();
        foreach($users as $user)
        {
            $this->send_notification($user->firebase_token,$title,$msg);
        }
        $json=new JsonResponseClass();
        return $json->method_response(200, '');
    }
    private function send_notification($to,$title,$body)
    {
        $msg = '{"to":"' . $to . '",
                "data":
                {"title":"' . $title . '",
                "body": "' . $body . '"
                }
                }';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $msg,
            CURLOPT_HTTPHEADER => array(
//                "authorization: key=AAAA_iHwElw:APA91bFNdaLJWi429zrrGmu93ZAcL74NL1N5jRMR7oZGXvD5WUC5X5OdeMLcWYC_x40j6Kw_RL0jPY-Yg1PSneQyBGKkJoUgS0_1C6Fzwk_5dvrp3jc5Ql-9Qd7WhqqVlPXQzavN9qAt",
                "authorization: key=AAAA_iHwElw:APA91bFNdaLJWi429zrrGmu93ZAcL74NL1N5jRMR7oZGXvD5WUC5X5OdeMLcWYC_x40j6Kw_RL0jPY-Yg1PSneQyBGKkJoUgS0_1C6Fzwk_5dvrp3jc5Ql-9Qd7WhqqVlPXQzavN9qAt",
                //	"authorization: key=کلیدی که از گوگل میگیرد برای پروژتون",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 088edd10-ede2-51c7-f09d-4996f9207c2a"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
//            echo $response;
        }
    }
    public function send_sms($token,$cellphone,$template)
    {
        $receptor = trim($cellphone);
        $fields = [
            'receptor' => $receptor,
            'token' => $token,
            'template' => $template
        ];
        $url = "https://api.kavenegar.com/v1/636C4B4473756E434A396C6C6636395173582B55304A4C586237335A434F4B50/verify/lookup.json?receptor=" . $receptor . "&token=" . $token . "&template=" . $template . "";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);
        if($result->return->status == true)
            return 200;
        return 400;
    }
    public function normal_send_sms($token,$cellphone)
    {
       return 200;
        $store=Store::first();
        try{
//           $sender = "10005505055000";
            $sender = $store->sms;
            $message = $token;
            $receptor = array($cellphone);
            $result = Kavenegar::Send($sender,$receptor,$message);
            //sms has been send successfully
//           return $result;
            if($result)
                return 200;
        }
        catch(\Kavenegar\Exceptions\ApiException $e){
            // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
        catch(\Kavenegar\Exceptions\HttpException $e){
            // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
            echo $e->errorMessage();
        }
    }

    public function cookieCode(){
        function random($length, $chars = '')
        {
            if (!$chars) {
//                $chars = implode(range('a','f'));
                $chars .= implode(range('0','9'));
            }
            $shuffled = str_shuffle($chars);
            return substr($shuffled, 0, $length);
        }
        function serialkey_activation_code()
        {
            return random(3).random(3).random(3);
        }
        $code=serialkey_activation_code();
        $check=Cookie::where('code',$code)->first();
        if($check){
            $code=$this->activation_code();
        }
        return $code;
    }
    public function cities($state_id)
    {
        $cities=City::where([['parent_id',$state_id],['active',1]])->get();
        return $cities;
    }

    public static function random($length = 100)
    {
        if ( ! function_exists('openssl_random_pseudo_bytes'))
        {
            throw new RetryException('OpenSSL extension is required.');
        }

        $bytes = openssl_random_pseudo_bytes($length * 2);

        if ($bytes === false)
        {
            throw new RetryException('Unable to generate random string.');
        }

        return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int  $length
     * @return string
     */
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
