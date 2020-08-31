@extends('frontend.layouts.app')
@section('seo')
<?php
$title = '404';
$desc = 'Lỗi';
  $data_seo = array(
      'title' => $title,
      'keywords' => \App\myHelper::get_option_seo('seo-keywords-add','text'),
      'description' => $desc,
      'og_title' => $title,
      'og_description' => $desc,
      'og_url' => Request::url(),
      'og_img' => \App\myHelper::get_option_seo('seo-image-add','image'),
      'current_url' =>Request::url(),
      'current_url_amp' =>''
  );
  $seo = WebService::getSEO($data_seo);
  ?>
@include('frontend.partials.seo')
@endsection
@section('content')
    <div id="wrapper_container_fix" class="clear">
    	<div class="container clear">
    	    <div class="body-container border-group clear">
               <section id="section" class="section clear">
                      <div class="group-section-wrap clear row">
                            <div class="col-xs-12 col-sm-7 col-lg-7">
                               <!-- Info -->
                                <div class="info">
                                   <h1>Oppps!</h1>
                                   <h2>Trang bạn truy cập không tồn tại!</h2>
                                   <p>Vui lòng nhập đường dẫn chính xác hoặc trở về Trang chủ</p>
                                   <div class="tbl_back clear">
                                    <a href="{{url('/')}}" class="btn btn-info">Trang chủ</a>
                                   </div>
                               </div>
                               <!-- end Info -->
                            </div>
                      </div><!--group-section-wrap-->
               </section><!--#section-->
            </div><!--body-container-->
    	</div>
    </div>
    <style>
      #wrapper_container_fix{
        padding: 220px;
        text-align: center;
      }
    </style>
@endsection
