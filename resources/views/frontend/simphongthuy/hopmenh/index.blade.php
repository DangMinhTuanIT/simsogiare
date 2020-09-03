@extends('frontend.layouts.app')
@section('seo')
<?php
   $title = \App\myHelper::get_option_seo('seo-title-add','text');
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
      <div class="main_wrapper container cls simphongthuy ">
         <div class="wrapper_content nohome">
            <div class="main-area-right cls">
               <div class="search_area">
                  <div class="note_title">
                     <h1> <span>{{$info->name_sim_fate}}</span></h1>
                  </div>
                  <div class="sumary_sim">Nhiều người tìm kiếm, chọn và sử dụng {{$info->name_sim_fate}} như là cách để tăng thêm may mắn, tăng thêm tự tin cho công việc cũng như cuộc sống. Vậy bạn đã có chưa? Hãy cùng tìm hiểu cách chọn {{$info->name_sim_fate}} dưới đây.</div>
               </div>
               <div class="top_sim_fengshui home_fengshui fengshui_over">
                  <div class="topmodule">
                     <div class="moduletable">
                       {!!WebService::get_data_simphongthuy($data_sim,$type)!!}
                     </div>
                  </div>
                  <div class="out_topmodule">
                  </div>
                  @if($info->content!='')
                  <div class="description_sim">
                     <?php
                     $content = str_replace('muasim.com.vn', URL::to('/'), $info->content);
                     $content = str_replace('Muasim.com.vn', URL::to('/'), $content);
                      ?>
                     {!!$content!!}
                  </div>
                  @endif
                  {!!WebService::get_bottom_related_simphongthuy()!!} 
               </div>
            </div>
            @include('frontend.sidebar_simphongthuy')
         </div>
      </div>
   </div>
</div>
@endsection