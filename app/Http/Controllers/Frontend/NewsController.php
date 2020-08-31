<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\myHelper;
use Validator;
use Illuminate\Http\Request;
use Goutte\Client;
use App\Model\Sim;
use App\Model\News;
use App\Model\SimOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use WebService,URL,Redirect;


class NewsController extends Controller
{
    public function single(Request $request,$slug1,$id){
       $info = News::get_info($id);
       if(!empty($info)){
        return view('frontend.news.index',
            array(
                'news'=>$info,
            ));
        }else{
            return view('frontend.404');
        }
        
    }
    
	
}