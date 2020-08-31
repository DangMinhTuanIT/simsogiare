<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\myHelper;
use Validator;
use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Model\Sim;

class SingleController extends Controller
{
	
    public function single_sim($slug){
    	$info = Sim::detail_sim($slug);
    	if(!empty($info)){
    		return view('frontend.sim_single.index')->with('info',$info);
    	}else{
    		return view('frontend.404');
    	}
	}
     
	
}