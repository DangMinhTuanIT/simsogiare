<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->type == config('simsogiare.user_type.customer')) {
            return redirect()->route('customer.info');
        }
        return view('welcome');
    }

    public function notify(){
        return view('welcome');
    }

    public function about(){
        return view('public.about');
    }

    public function contact(){
        return view('public.contact');
    }

    public function support(){
        return view('public.support');
    }

    public function promotion(){
        return view('public.support');
    }
}
