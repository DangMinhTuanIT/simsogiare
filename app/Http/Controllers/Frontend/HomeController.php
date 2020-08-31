<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\myHelper;
use Validator;
use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon,Thread;

class HomeController extends Controller
{
	
     public function index(){
       return view('frontend.home.index');
	 }
     
	
}
