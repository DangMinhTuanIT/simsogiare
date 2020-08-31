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
<!-- MAIN MENU -->
      <!-- MAIN MENU -->
      
      <div class="clear"></div>
      <div class="head head_nohome">
         <div class="dbreadcrumbs">
            <div class="container">
            </div>
         </div>
         <div class="clear"></div>
         <div class="wrapper_content_p cls">
            <div class='main_wrapper container cls '>
               <div class ='wrapper_content nohome'>
                  <div class="main-area-right cls">
                     <div class="banner-home">
                        <div class="img">
                            <img src="home/background-home-1.png" alt="">
                        </div>
                        <div class="content">
                           <h2 class="tit">Tìm Sim Số Đẹp</h2>
                           <p class="cont">MUABANSIMSO.VN với kho sim số đẹp lên đến <span class="sim-number">19.000.000 SIM SỐ</span> của các nhà mạng Viettel, Vinaphone, Mobifone, Vietnammobile ...
                           đa dạng về chủng loại, có nhiều mức giá, cho bạn thỏa sức chọn số tại đây</p>
                          
                        </div>
                        <div class="footer-banner">
                            <p>MIỄN PHÍ: Giao sim toàn quốc - Đăng ký thông tin chính chủ - Nhận sim - Kiểm tra đúng thông tin mới thanh toán.</p>
                        </div>
                     </div>
                     <div class="baner-3">
                        <div class="items flex-view">
                           <div class="item">
                              <img src="/images/home/baner-sim-4.jpg" alt="">
                           </div>
                           <div class="item">
                              <img src="/images/home/baner-sim-2.jpg" alt="">
                           </div>
                           <div class="item">
                              <img src="/images/home/baner-sim-1.jpg" alt="">
                           </div>
                        </div>
                     </div>
                     <div class="simslist_block_title"><span>
                        <a class="modal" href="sim-giam-gia.html" rel="" title="Sim giảm giá trong ngày">
                        Sim giảm giá trong ngày  </a>
                        </span>
                     </div>
                     <div class="pos8 cls">
                        <div class='block_sims_home sims_home_0 blocks_sims_cat blocks0 block'  id = "block_id_190" >
                           <div class="wapper-content-page sims_home_content topmodule">
                              <div class="moduletable">
                                 <div class="cat_item_store">
                                    <?php echo WebService::get_category_homepage(3); ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="pos8 cls">
                        <div class='block_sims_home sims_home_0 blocks_sims_cat blocks0 block'  id = "block_id_190" >
                           <div class="wapper-content-page sims_home_content topmodule">
                              <div class="moduletable">
                                 <div class="cat_item_store">
                                    <div class='cat-title'>
                                       <h2  class='cat-title-main'><a href="sim-vinaphone.html" title="Vinaphone">Sim Vinaphone</a></h2>
                                       <a href="sim-vinaphone.html"  class="all_more">Xem tất cả</a>
                                    </div>
                                    <?php echo WebService::get_category_homepage(3); ?>
                                 </div>
                                 <div class="cat_item_store">
                                    <div class='cat-title'>
                                       <h2  class='cat-title-main'><a href="sim-viettel.html" title="Viettel">Sim Viettel</a></h2>
                                       <a href="sim-vinaphone.html"  class="all_more">Xem tất cả</a>
                                    </div>
                                    <div class="sim_home">
                                       <?php echo WebService::get_category_homepage(1); ?>
                                    </div>
                                    <div class="clear"></div>
                                 </div>
                                 <div class="cat_item_store">
                                    <div class='cat-title'>
                                       <h2  class='cat-title-main'><a href="sim-mobifone.html" title="Mobifone">Sim Mobifone</a></h2>
                                       <a href="sim-vinaphone.html" class="all_more">Xem tất cả</a>
                                    </div>
                                    <div class="sim_home">
                                       <?php echo WebService::get_category_homepage(2); ?>
                                    </div>
                                    <div class="clear"></div>
                                 </div>
                                 <div class='clear'></div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="footer-content-home">
                        <div class="image">
                           <img src="/images/home/banner-footer-home.png" alt="">
                        </div>
                        <br>
                        <b>Chúng tôi cung cấp sim số đẹp trên khắp 63 tỉnh thành cả nước! </b>
                        <p>Miền Bắc:  Lào Cai, Yên Bái, Điện Biên, Hoà Bình, Lai Châu, Sơn La; Hà Giang, Cao Bằng, Bắc Kạn, Lạng Sơn, Tuyên Quang, Thái Nguyên; Phú Thọ, Bắc Giang, Quảng Ninh, Bắc Ninh, Hà Nam, Hải Dương; Hải Phòng, Hưng Yên, Nam Định, Ninh Bình, Thái Bình, Vĩnh Phúc.</p>
<p>
Miền Trung: Thanh Hoá, Nghệ An, Hà Tĩnh, Quảng Bình, Quảng Trị và Thừa Thiên-Huế, Đà Nẵng, Quảng Nam, Quảng Ngãi, Bình Định, Phú Yên, Khánh Hoà, Ninh Thuận, Bình Thuận, Kon Tum, Gia Lai, Đắc Lắc, Đắc Nông và Lâm Đồng.
</p>
<p>
Miền Nam: Bình Phước, Bình Dương, Đồng Nai, Tây Ninh, Bà Rịa-Vũng Tàu, Thành phố Hồ Chí Minh, Long An, Đồng Tháp, Tiền Giang, An Giang, Bến Tre, Vĩnh Long, Trà Vinh, Hậu Giang, Kiên Giang, Sóc Trăng, Bạc Liêu, Cà Mau và Thành phố Cần Thơ.</p>
<p>
Cho dù bạn ở bất cứ nơi đâu và bất cứ lúc nào trên mọi miền tổ quốc cũng đừng ngần ngại, vì chỉ với 1 cú lick chuột bạn cũng đã đặt mua ngay được 1 chiếc sim số đẹp giá gốc tại website: http://muabansimso.vn</p>
<p>
Uy tín là mục tiêu hàng đầu của website: muabansimso.vn Với đội ngũ nhân viên chuyên nghiệp bạn sẽ cảm nhận được dịch vụ tốt nhất từ phía chúng tôi. Với kho sim hàng triệu sim số đẹp giá rẻ của các mạng, cam kết bán với giá gốc, bạn sẽ thoải mái lựa chọn sim mà không phải băn khoăn đến giá. Nhanh tay lựa ngay những số đẹp nhất.</p>
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