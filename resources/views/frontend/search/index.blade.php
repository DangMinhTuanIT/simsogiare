@extends('frontend.layouts.app')
@section('seo')
<?php
$title = @$category->seo_title!='' ? @$category->seo_title: @$name_cat . ' - '.\App\myHelper::get_option_seo('seo-title-add','text');
$desc = \App\myHelper::get_option_seo('seo-description-add','text');
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

<div class="head head_nohome">
   <div class="dbreadcrumbs">
      <div class="container">
      </div>
   </div>
   <div class="clear"></div>
   <div class="wrapper_content_p cls">
      <div class="main_wrapper container cls ">
         <div class="wrapper_content nohome">
            <div class="main-area-right cls">
               <div class="search_area">
                  <div class="note_title ">
                    <?php $sim_dau = $dau!="" ? 'đầu '.$dau : '';
                    $sim_duoi = $duoi!="" ? "đuôi ".$duoi : ""; ?>
                     <h1><span>Sim số đẹp {{@$sim_dau}} {{@$sim_duoi}}</span></h1>
                    {!!\App\myHelper::filter_select_html()!!}
                  </div>
                  <div class="sumary_sim">
                    {!!@$category->description!!}
                  </div>
                  <div class="clear"></div>
               </div>
               <div class="filter_search search_area" >
                  <div class="title_filter">	Lọc sim theo yêu cầu</div>
                  <div class="block-search">
                     <div class="sims_select_filter">
                      
                       {!!WebService::category_network_category(@$filter_according,@$slug1,@$slug2)!!}
                        {!!WebService::price_range_category(@$filter_according,@$slug1,@$slug2)!!}
                        <!-- end .sims_price sub_block	-->
                     </div>
                     <div class="clear"></div>
                  </div>
               </div>
               <div class="product_wrap container top_sim_fengshui">
                  <div class="clear"></div>
                  <div class="topmodule">
                     <div class="moduletable">
                       {!!WebService::list_sim_search(@$data_sim,$type,$dau,$duoi)!!}
                     </div>
                  </div>
                  <div class="clear"></div>
               </div>
               
                  <!--	RELATE TAGS		-->
                  {!!WebService::dauso($slug_cat,$dauso_id)!!}
            </div>
           <div class='right'>
                     @include('frontend.sidebar')
                  </div>
         </div>
      </div>
   </div>
</div>
@endsection