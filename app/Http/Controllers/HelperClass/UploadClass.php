<?php

namespace App\Http\Controllers\HelperClass;

use App\Models\Category;
use App\Models\ProductMultimedia;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadClass extends Controller
{
    public function __construct()
    {
        $dir='';
        $this->dir=trim($dir);
    }
    //handle uploading files
    public function upload($request){
        switch ($request->file_type){
            case 'photo':
                return $this->photos($request);
                break;
            case 'video':
                return $this->videos($request);
                break;
            case 'voice':
                return $this->voices($request);
                break;
            case 'doc':
                return $this->docs($request);
                break;
            case 'message_file':
                return $this->message_file($request);
                break;
            default:
                break;
        }
    }
    private function message_file($request)
    {
        $type='message_file';
        $files = $request['file'];
        $count = count($files);

        if ($count > 1) {
            for ($i = 0; $i < $count; $i++) {
                $extension = $files[$i]->getClientOriginalExtension();
                if (!$this->fileSize($type, $files[$i]->getSize(),'message_file'))
                    return 603;

                $fileName = $type . '_' . str_random(6) . '.' . $extension;
                $src[] = 'public/files/message/' . $fileName;
                //main host
                $path ='/home/onlinenews/public_html/public/files/message/';
                $upload[] = $files[$i]->move($path, $fileName);
                //localhost
//                $upload[] = $files[$i]->move(public_path('files/message/'), $fileName);
            }
            if(sizeof($upload)==$count)
                return $src;
            return 601;
        }
        if($count==1)
        {
            $files=$files[0];

            $extension = $files->getClientOriginalExtension();
            if (!$this->fileSize($type, $files->getSize(),'message_file'))
                return $this->fileSize($type, $files->getSize(),'message_file');
//                return 603;
            $fileName = $type . '_' . str_random(6) . '.' . $extension;

            $src[] = 'public/files/message/' . $fileName;
            //main host
            $path ='/home/onlinenews/public_html/public/files/message/';
            $upload[] = $files->move($path, $fileName);
            //localhost
//            $upload = $files->move(public_path('files/message/'), $fileName);
            if($upload)
                return $src;
            return 601;
        }
    }
    private function photos($request)
    {
        $type=$request['type'];
        $allow=['news','product','profile','slider','logo','banner','android','flag','icons','preLoader','interview','category','page','contest','publisher'];
        if(!in_array($type,$allow))
            return 503;
        $files = $request['file'];
        $count = count($files);

        if ($count > 1) {
            for ($i = 0; $i < $count; $i++) {
                $extension = $files[$i]->getClientOriginalExtension();
                if ($extension != 'jpg' and $extension != 'png' and $extension != 'jpeg' and $extension != 'gif')
                    return 602;
                if (!$this->fileSize($type, $files[$i]->getSize(),'photo'))
                    return 603;

                $imageName = $type . '_' . str_random(6) . '.' . $extension;
                $src[] = 'public/files/photo/' . $type . '/' . $imageName;
                //main host
                $path ='/home/onlinenews/public_html/public/files/photo/'. $type . '/';
                $upload[] = $files[$i]->move($path, $imageName);
                //localhost
//                $upload[] = $files[$i]->move(public_path('files/photo/' . $type . '/'), $imageName);
            }
            if(sizeof($upload)==$count)
                return $src;
            return 601;
        }
        if($count==1)
        {
            $files=$files[0];
            $extension = $files->getClientOriginalExtension();
            if ($extension != 'jpg' and $extension != 'png' and $extension != 'jpeg' and $extension != 'gif')
                return 602;

            if (!$this->fileSize($type, $files->getSize(),'photo'))
                return $this->fileSize($type, $files->getSize(),'photo');
//                return 603;
            $imageName = $type . '_' . str_random(6) . '.' . $extension;

            $src[] = 'public/files/photo/' . $type . '/' . $imageName;
            //main host
            $path ='/home/onlinenews/public_html/public/files/photo/'. $type . '/';
            $upload[] = $files->move($path, $imageName);
            //localhost
//            $upload = $files->move(public_path('files/photo/' . $type . '/'), $imageName);

            if($upload)
                return $src;
            return 601;
        }
    }
    private function videos($request)
    {
        $type=$request['type'];
        if($type != 'news' and $type != 'interview' and $type != 'product')
            return 503;
        $files = $request['file'];
        $count = count($files);
        if ($count > 1) {
            for ($i = 0; $i < $count; $i++) {
                $extension = $files[$i]->getClientOriginalExtension();
                if ($extension != 'mp4' and $extension != 'flv' and $extension != 'avi' and $extension != 'wma')
                    return 602;
                if (!$this->fileSize($type, $files[$i]->getSize(),'video'))
                    return 603;
                $imageName = $type . '_' . str_random(6) . '.' . $extension;
                $src[] = 'public/files/video/' . $type . '/' . $imageName;
                //main host
                $path ='/home/onlinenews/public_html/public/files/video/'. $type . '/';
                $upload[] = $files[$i]->move($path, $imageName);
                //localhost
//                $upload[] = $files[$i]->move(public_path('files/video/' . $type . '/'), $imageName);
            }
            if(sizeof($upload)==$count)
                return $src;
            return 601;
        }
        if($count==1)
        {
            $files=$files[0];
            $extension = $files->getClientOriginalExtension();
            if ($extension != 'mp4' and $extension != 'flv' and $extension != 'avi' and $extension != 'wma')
                return 602;
            if (!$this->fileSize($type, $files->getSize(),'video'))
                return 603;
            $imageName = $type . '_' . str_random(6) . '.' . $extension;
            $src[] = 'public/files/video/' . $type . '/' . $imageName;
            //main host
            $path ='/home/onlinenews/public_html/public/files/video/'. $type . '/';
            $upload[] = $files->move($path, $imageName);
            //localhost
//            $upload = $files->move(public_path('files/video/' . $type . '/'), $imageName);
            if($upload)
                return $src;
            return 601;
        }
    }
    private function voices($request)
    {
        $type=$request['type'];
        if($type != 'news' and $type != 'interview' and $type!='product')
            return 503;
        $files = $request['file'];
        $count = count($files);
        if ($count > 1) {
            for ($i = 0; $i < $count; $i++) {
                $extension = $files[$i]->getClientOriginalExtension();
                if ($extension != 'mp3' and $extension != 'wav' and $extension != 'amr' and $extension != 'wma')
                    return 602;
                if (!$this->fileSize($type, $files[$i]->getSize(),'voice'))
                    return 603;
                $imageName = $type . '_' . str_random(6) . '.' . $extension;
                $src[] = 'public/files/voice/' . $type . '/' . $imageName;
                //main host
                $path ='/home/onlinenews/public_html/public/files/voice/'. $type . '/';
                $upload[] = $files[$i]->move($path, $imageName);
                //localhost
//                $upload[] = $files[$i]->move(public_path('files/voice/' . $type . '/'), $imageName);
            }
            if(sizeof($upload)==$count)
                return $src;
            return 601;
        }
        if($count==1)
        {
            $files=$files[0];
            $extension = $files->getClientOriginalExtension();
            if ($extension != 'mp3' and $extension != 'wav' and $extension != 'amr' and $extension != 'wma')
                return 602;
            if (!$this->fileSize($type, $files->getSize(),'voice'))
                return 603;
            $imageName = $type . '_' . str_random(6) . '.' . $extension;
            $src[] = 'public/files/voice/' . $type . '/' . $imageName;
            //main host
            $path ='/home/onlinenews/public_html/public/files/voice/'. $type . '/';
            $upload[] = $files->move($path, $imageName);
            //localhost
//            $upload = $files->move(public_path('files/voice/' . $type . '/'), $imageName);
            if($upload)
                return $src;
            return 601;
        }
    }
    private function docs($request)
    {
        $type=$request['type'];
        if($type != 'news' and $type != 'interview' and $type!='product')
            return 503;
        $files = $request['file'];
        $count = count($files);
        if ($count > 1) {
            for ($i = 0; $i < $count; $i++) {
                $extension = $files[$i]->getClientOriginalExtension();
                if ($extension != 'pdf' and $extension != 'doc' and $extension != 'docx' and $extension != 'pps' and $extension != 'xls' and $extension != 'pptx' and $extension != 'xlsx' and $extension != 'zip' and $extension != 'rar' and $extension != 'txt')
                    return 602;
                if (!$this->fileSize($type, $files[$i]->getSize(),'file'))
                    return 603;
                $imageName = $type . '_' . str_random(6) . '.' . $extension;
                $src[] = 'public/files/doc/' . $type . '/' . $imageName;
                //main host
                $path ='/home/onlinenews/public_html/public/files/doc/'. $type . '/';
                $upload[] = $files[$i]->move($path, $imageName);
                //localhost
//                $upload[] = $files[$i]->move(public_path('files/doc/' . $type . '/'), $imageName);
            }
            if(sizeof($upload)==$count)
                return $src;
            return 601;
        }
        if($count==1)
        {
            $files=$files[0];
            $extension = $files->getClientOriginalExtension();
            if ($extension != 'pdf' and $extension != 'doc' and $extension != 'docx' and $extension != 'pps' and $extension != 'xls' and $extension != 'xlsx' and $extension != 'zip' and $extension != 'rar' and $extension!='txt')
                return 602;
            if (!$this->fileSize($type, $files->getSize(),'file'))
                return 603;
            $imageName = $type . '_' . str_random(6) . '.' . $extension;
            $src[] = 'public/files/doc/' . $type . '/' . $imageName;
            //main host
            $path ='/home/onlinenews/public_html/public/files/doc/'. $type . '/';
            $upload[] = $files->move($path, $imageName);
            //localhost
//            $upload = $files->move(public_path('files/doc/' . $type . '/'), $imageName);
            if($upload)
                return $src;
            return 601;
        }
    }
    private function fileSize($type,$size,$file)
    {
        switch ($type)
        {
            case 'interview':
                if($file=='photo' and $size>1000000000)
                    return false;
                elseif($file=='video' and $size>100000000000000)
                    return false;
                elseif($file=='voice' and $size>100000000000000)
                    return false;
                elseif($file=='doc' and $size>100000000)
                    return false;
                else return true;
                break;
            case 'news':
                if($file=='photo' and $size>10000000000)
                    return false;
                elseif($file=='video' and $size>100000000000000)
                    return false;
                elseif($file=='voice' and $size>100000000000000)
                    return false;
                elseif($file=='doc' and $size>1000000000)
                    return false;
                else return true;
                break;
            case 'category':
                if($size>10000000)
                    return false;
                else return true;
                break;
            case 'page':
                if($size>10000000)
                    return false;
                else return true;
                break;
            case 'publisher':
                if($size>10000000)
                    return false;
                else return true;
                break;
            case 'profile':
                if($size>100000000)
                    return false;
                else return true;
                break;
            case 'logo':
                if($size>1000000)
                    return false;
                else return true;
                break;
            case 'flag':
                if($size>100000)
                    return false;
                else return true;
                break;
            case 'banner':
                if($size>10000000)
                    return false;
                else return true;
                break;
            case 'preLoader':
                if($size>10000000)
                    return false;
                else return true;
                break;
            case 'android':
                if($file=='photo' and $size>1000000)
                    return false;
                elseif($file=='video' and $size>100000000000000)
                    return false;
                else return true;
                break;
            case 'commercial':
                if($size>10000000)
                    return false;
                else return true;
                break;
            case 'product':
                if($file=='photo' and $size>1000000000)
                    return false;
                elseif($file=='video' and $size>100000000)
                    return false;
                elseif($file=='voice' and $size>10000000000)
                    return false;
                elseif($file=='doc' and $size>100000000)
                    return false;
                else return true;
                break;
            case 'message_file':
                if($size>10000000000000)
                    return false;
                else return true;
                break;
            case 'contest':
                if($size>10000000000000)
                    return false;
                else return true;
                break;
            default:
                return false;
        }
    }

    public function delete($src)
    {
        $array=explode('/',$src); //public/files/video/product/product_QXj.mp4
        $fileName=$array[sizeof($array)-1]; //product_QXj.mp4
        $type=$array[sizeof($array)-2]; // category slider profile product
        $is=$this->getExtension($fileName); //photo or video

        //$is : photo/video ; $type : category/slider/profile/product
        //localhost
//        return public_path().'/files/'.$is.'/' . $type . '/'. $fileName;
//        $delete=\Illuminate\Support\Facades\File::delete(public_path().'/files/'.$is.'/'. $type . '/'. $fileName);
//        if(!$delete)
//            return 404;
        //Main host
        \Illuminate\Support\Facades\File::delete('/home/onlinenews/public_html/public/files/'.$is.'/' . $type . '/'. $fileName);

        return 200;
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getExtension($fileName)
    {
      $extension = explode('.', $fileName);
       $extension = $extension[1];
        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif')
            $is = 'photo';
        elseif ($extension == 'mp4' || $extension == 'flv' || $extension == 'avi' || $extension == 'wma')
            $is = 'video';
        elseif ($extension == 'mp3' || $extension == 'wav' || $extension == 'amr' || $extension == 'wma')
            $is = 'voice';
        else $is = 'file';
        return $is;
    }
}
