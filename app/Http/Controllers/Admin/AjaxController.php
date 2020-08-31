<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\GroupService;
use App\Model\ProfileService;
use App\Model\Service;
use App\Model\Profile;
use App\Model\Gallery;
use App\Model\AreaDim;
use App\Model\DirectionDim;
use App\Model\PlaceDim;
use App\Model\PriceDim;
use App\Model\TypeDim;
use App\Model\UnitDim;
use Validator,URL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\myHelper;

class AjaxController extends Controller
{
    public function __construct(){

    }
    public function images(Request $request){
        @$url=URL::to('/');
        @$errorImgFile = $url."/uploads/upload-error.png";
        if (@$request->hasFile('file')) {
            @$temp = explode(".", @$_FILES["file"]["name"]);
            @$temp=self::str_slug(@$temp['0']).'.'.@$temp['1'];
            @$destinationFilePath = './upload/editor/'.$temp ;
            $file = $request->file;
            $ext = $file->getClientOriginalExtension();

            $file->move(base_path().'/upload/editor/',$file->getClientOriginalName());
            $link = '/upload/news/'.$file->getClientOriginalName();
            echo @$link;
        }
    }
    public function str_slug($str, $seperator = '-') {
        $str = strip_tags($str);
        $str = trim(mb_strtolower($str,"UTF-8"));
        $str = preg_replace('/(\s+)|(\-)/', ' ', $str);
        $str = preg_replace('/(à|À|Á|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-zA-z0-9-\s]/', '', $str);
        $str = preg_replace('/\s+/', $seperator, $str);
        return trim($str, '-');
    }
    
}
