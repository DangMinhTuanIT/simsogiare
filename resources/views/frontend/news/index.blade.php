@extends('frontend.layouts.app')
@section('seo')
<?php
$title = $news->title.' - '.\App\myHelper::get_option_seo('seo-title-add','text');
$desc = \App\myHelper::get_meta_desc($news->meta_desc,$news->content);
$image_pickture = $news->image_link!=''?$news->image_link: \App\myHelper::get_option_seo('seo-image-add','image');
   $data_seo = array(
       'title' => $title,
       'keywords' => \App\myHelper::get_meta_keyword($news->meta_key),
       'description' => $desc,
       'og_title' => $title,
       'og_description' => $desc,
       'og_url' => Request::url(),
       'og_img' => $image_pickture,
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
         <div class="breadcrumbs_wrapper" itemscope="" itemtype="http://schema.org/WebPage">
            <ul class="breadcrumb" itemscope="itemscope" itemtype="https://schema.org/BreadcrumbList">
               <li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
                  <a title="{{ config('app.name') }}" href="{{URL::to('/')}}" itemprop="item">
                     <span itemprop="name">Trang chủ</span>
                     <meta content="1" itemprop="position">
                  </a>
               </li>
               <li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
                  <a title="{{@$news->cat_name}}" href="/" itemprop="item">
                     <span itemprop="name">{{@$news->cat_name}}</span>
                     <meta content="2" itemprop="position">
                  </a>
               </li>
               <li class="breadcrumb__item" itemprop="itemListElement" itemscope="itemscope" itemtype="http://schema.org/ListItem">
                     <span itemprop="name">{{@$news->title}}</span>
                     <meta content="3" itemprop="position">
               </li>
            </ul>
         </div>
      </div>
   </div>
   <div class="clear"></div>
   <div class="wrapper_content_p cls">
      <div class="main_wrapper container cls ">
         <div class="wrapper_content nohome">
            <div class="main-area-right cls">
   <div class="news_detail" itemscope="" itemtype="http://schema.org/NewsArticle">
      <meta itemscope="" itemprop="mainEntityOfPage" itemtype="https://schema.org/WebPage" itemid="https://google.com/article">
      <!-- NEWS NAME-->
      <h1 class="title" itemprop="headline">
         {{$news->title}}
      </h1>
      <!-- end NEWS NAME-->
      <!-- DATETIME -->
      <div class="time_rate cls">
         
         <span class="news_time" itemprop="datePublished">03/01/2020 </span>
         <font>-</font>
         <span class="new_category" itemprop="articleSection">Tin tức</span>
         <meta itemprop="dateModified" content="03/01/2020">
      </div>
      <div class="summary" itemprop="description">Sim số đẹp đã và đang là vật bất ly thân của người Việt chúng ta bởi mỗi con số đều mang một ý nghĩa riêng. Bạn là người yêu thích và đang sử dụng sim điện thoại số&nbsp;đẹp hãy cùng chúng tôi tìm hiểu ý nghĩa của từng con số nhé!</div>
      <!-- end DATETIME-->
      <figure class="image hide" itemprop="image" itemscope="" itemtype="https://schema.org/ImageObject">
         <img src="{{$image_pickture}}" alt="{{$news->title}}" itemprop="image">
         <meta itemprop="url" content="{{$image_pickture}}">
         <meta itemprop="width" content="480">
         <meta itemprop="height" content="200">
      </figure>
      <!-- SUMMARY -->
      <div class="description" itemprop="articleBody">
         <div class="description">
            @php echo WebService::callback_content(\App\myHelper::TableOfContents($news->content),$news->title) @endphp
         </div>
      </div>
      <div itemprop="author" itemscope="" itemtype="https://schema.org/Person" class="hiden">
         By <span itemprop="name">{{URL::to('/')}}</span>
      </div>
      <div itemprop="publisher" itemscope="" itemtype="https://schema.org/Organization" class="hiden">
         <div itemprop="logo" itemscope="" itemtype="https://schema.org/ImageObject">
            <img src="/home/logo-simsogiare.png" title="{{URL::to('/')}}">
            <meta itemprop="url" content="/home/logo-simsogiare.png">
            <meta itemprop="width" content="209">
            <meta itemprop="height" content="61">
         </div>
         <meta itemprop="name" content="{{URL::to('/')}}">
      </div>
      <br>

      <!--  RELATE CONTENT    -->
      <div class="related cf" style="display: none;">
         <div class="relate_title"><span>Tin cùng chuyên mục</span></div>
         <div class="related_content cls">
            <div class="item-related">
               <a class="img_a" href="https://muasim.com.vn/tin-nhan-tu-nha-mang-doa-de-ep-khach-hang-doi-sim-4g-n943.html" title="Tin nhắn từ nhà mạng dọa ép khách hàng đổi sim 4G">
               <img class="lazy after-lazy" alt="Tin nhắn từ nhà mạng dọa ép khách hàng đổi sim 4G" src="https://muasim.com.vn/images/news/2020/07/30/resized/tong-dai_1596086497.jpg" style="display: inline;">
               </a>
               <h2 class="title-item-related"><a href="https://muasim.com.vn/tin-nhan-tu-nha-mang-doa-de-ep-khach-hang-doi-sim-4g-n943.html" title="Tin nhắn từ nhà mạng dọa ép khách hàng đổi sim 4G">Tin nhắn từ nhà mạng dọa ép khách hàng đổi sim 4G</a></h2>
            </div>
            <div class="item-related">
               <a class="img_a" href="https://muasim.com.vn/mach-ban-dia-chi-ban-sim-so-dep-uy-tin-voi-gia-goc-n942.html" title="Mách bạn địa chỉ bán sim số đẹp uy tín với giá gốc">
               <img class="lazy after-lazy" alt="Mách bạn địa chỉ bán sim số đẹp uy tín với giá gốc" src="https://muasim.com.vn/images/news/2020/07/19/resized/ban-sim-so-dep-gia-goc_1595152934.jpg" style="display: inline;">
               </a>
               <h2 class="title-item-related"><a href="https://muasim.com.vn/mach-ban-dia-chi-ban-sim-so-dep-uy-tin-voi-gia-goc-n942.html" title="Mách bạn địa chỉ bán sim số đẹp uy tín với giá gốc">Mách bạn địa chỉ bán sim số đẹp uy tín với giá gốc</a></h2>
            </div>
            <div class="item-related">
               <a class="img_a" href="https://muasim.com.vn/chon-sim-dep-hop-tuoi-nguoi-dung-n941.html" title="Làm sao để chọn sim đẹp hợp tuổi người dùng">
               <img class="lazy after-lazy" alt="Làm sao để chọn sim đẹp hợp tuổi người dùng" src="https://muasim.com.vn/images/news/2020/07/18/resized/chon-sim-dep-hop-tuoi-huoi-dung_1595047133.jpg" style="display: inline;">
               </a>
               <h2 class="title-item-related"><a href="https://muasim.com.vn/chon-sim-dep-hop-tuoi-nguoi-dung-n941.html" title="Làm sao để chọn sim đẹp hợp tuổi người dùng">Làm sao để chọn sim đẹp hợp tuổi người dùng</a></h2>
            </div>
            <div class="item-related">
               <a class="img_a" href="https://muasim.com.vn/sim-dep-la-gi-y-nghia-va-loi-ich-ma-sim-dep-mang-lai-n940.html" title="Sim đẹp là gì? Ý nghĩa và lợi ích mà sim đẹp mang lại">
               <img class="lazy after-lazy" alt="Sim đẹp là gì? Ý nghĩa và lợi ích mà sim đẹp mang lại" src="https://muasim.com.vn/images/news/2020/07/06/resized/sim-dep-la-gi_1594001640.jpg" style="display: inline;">
               </a>
               <h2 class="title-item-related"><a href="https://muasim.com.vn/sim-dep-la-gi-y-nghia-va-loi-ich-ma-sim-dep-mang-lai-n940.html" title="Sim đẹp là gì? Ý nghĩa và lợi ích mà sim đẹp mang lại">Sim đẹp là gì? Ý nghĩa và lợi ích mà sim đẹp mang lại</a></h2>
            </div>
         </div>
      </div>
      <!--  end RELATE CONTENT    -->
      <input type="hidden" value="58" name="news_id" id="news_id">
      <!-- COMMENT  -->
   </div>
   <div class="clear"></div>
</div>
           <div class='right'>
               @include('frontend.sidebar')
            </div>
         </div>
      </div>
   </div>
</div>
@endsection