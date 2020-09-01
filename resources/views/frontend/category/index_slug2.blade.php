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

                     <h1><span>{{@$name_cat}}</span></h1>
                     {!!\App\myHelper::filter_select_html()!!}
                  </div>
                  <div class="sumary_sim">
                    {!!@$category->description!!}
                  </div>
                  <div class="clear"></div>
               </div>
               <div class="filter_search search_area">
                  <div class="title_filter">	Lọc sim theo yêu cầu</div>
                  <div class="block-search">
                     <div class="sims_select_filter">
                      {!!WebService::dauso_slug2_first_name($type,@$slug_cat,@$id_category,@$slug1,@$slug2)!!}
                       {!!WebService::category_network_category_slug2(@$filter_according,@$slug1,@$slug2)!!}
                        {!!WebService::price_range_category_slug2(@$filter_according,@$slug1,@$slug2)!!}
                        <!-- end .sims_price sub_block	-->
                     </div>
                     <div class="clear"></div>
                  </div>
               </div>
               <div class="product_wrap container top_sim_fengshui">
                  <div class="clear"></div>
                  <div class="topmodule">
                     <div class="moduletable">
                       {!!WebService::list_sim_category(@$data_sim)!!}
                     </div>
                  </div>
                  <div class="clear"></div>
               </div>
                  <!--	RELATE TAGS		-->
                  {!!WebService::dauso(@$slug_cat,@$dauso_id,@$slug2)!!}
               <div class="description_sim">
                  {!!$category->content!!}
               </div>
               <div class="clear"></div>
               <div class="pos4 container" style="display: none;">
                  <div class="block_newslist newslist_0 blocks_news_list blocks0 block" id="block_id_186">
                     <div class="block_title"><span>Có thể bạn quan tâm</span></div>
                     <div id="newslist-slideShow">
                        <div class="newslist-home owl-carousel owl-theme owl-responsive-900 owl-loaded">
                           <div class="owl-stage-outer">
                              <div class="owl-stage"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="block_newslist newslist_0 blocks_news_list blocks0 block" id="block_id_191">
                     <div class="news_list_body cls ">
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://muasim.com.vn/y-nghia-cac-con-so-trong-sim-dien-thoai-n58.html" title="Ý nghĩa các con số trong sim điện thoại">Ý nghĩa các con số trong sim điện thoại      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://muasim.com.vn/sim-phong-thuy-n59.html" title="Sim phong thủy chọn mua sim hợp tuổi, hợp mệnh">Sim phong thủy chọn mua sim hợp tuổi, hợp mệnh      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://muasim.com.vn/xem-phong-thuy-sim-n112.html" title="Xem phong thủy sim">Xem phong thủy sim      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://muasim.com.vn/sim-viettel-10-so-037-n667.html" title="Sim viettel 10 số 037 ">Sim viettel 10 số 037       </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://muasim.com.vn/dau-sim-so-dep-084-cua-mang-nao-n668.html" title="Đầu sim số đẹp 084 của mạng nào?">Đầu sim số đẹp 084 của mạng nào?      </a> 
                              </div>
                           </div>
                        </div>
                        <div class="news-item">
                           <div class="title">
                              <div class="link">
                                 <a href="https://muasim.com.vn/sim-tu-quy-nam-sinh-viettel-n669.html" title="Sim tứ quý năm sinh viettel">Sim tứ quý năm sinh viettel      </a> 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
           <div class='right'>
                     @include('frontend.sidebar')
                  </div>
         </div>
      </div>
   </div>
</div>
@endsection