<div class="footer lazy after-lazy" style="background-image: url(&quot;https://muasim.com.vn/images/config/footer.jpg&quot;); display: block;">
<div class="footer_inner container">
   <div class="left">
      <div class="left-top">
         <div class="img">
            <img src="/images/home/footer-image-v1.png" alt="">
         </div>
         <h4>TRUNG TÂM PHÂN PHỐI SIM SỐ ĐẸP VÀ THẺ CÀO CÁC MẠNG</h4>
         <p>Qúy khách cần thêm thông tin, cần được biết về cách thức mua sim....</p>
         <p>Đừng ngần ngại hãy nhấc máy gọi ngay cho chúng tôi để được hỗ trợ tốt nhất (24/24).</p>
         <p>Hotline bán&nbsp;hàng : <a href="tel:0909234234 "><span style="color:#e11b1e">0909.234.234 </span></a><span style="color:#e11b1e">-</span><a href="tel: 0919234234 "><span style="color:#e11b1e"> 0909.234.234 </span></a></p>
         <p> Địa chỉ : 581/59 Trường Chinh, Phường Tân Sơn Nhì, Tân Phú, Tp. Hồ Chí Minh</p>
      </div>
   </div>
   <div class="center fl">
      <div class="navigation_sub">
         <ul class="menu-bottom">
            <li class="  level0  first-item">
               <span class="click-mobile" data-id="menu-sub1"></span>  <a href="https://muasim.com.vn//sim-loc-phat/dau-so-09.html" title="Hỗ trợ khách hàng">   Hỗ trợ khách hàng   </a>
               <ul id="menu-sub1">
                  <li class="  level1  first-sitem ">
                     <a href="#" title="Bảo mật thông tin khách hàng">     Bảo mật thông tin khách hàng </a>
                  </li>
                  <li class="  level1  mid-sitem ">
                     <a href="#" title="Ý nghĩa các con số trong sim">     Ý nghĩa các con số trong sim </a>
                  </li>
                  <li class="  level1  mid-sitem ">
                     <a href="#" title="Chính sách vận chuyển">     Chính sách vận chuyển </a>
                  </li>
                  <li class="  level1  mid-sitem ">
                     <a href="#" title="Hướng dẫn mua sim">     Hướng dẫn mua sim </a>
                  </li>
                  <li class="  level1  mid-sitem ">
                     <a href="#" title="Giới thiệu">    Giới thiệu </a>
                  </li>
                  <li class="  level1  mid-sitem ">
                     <a href="#" title="Liên hệ">     Liên hệ </a>
                  </li>
               </ul>
            </li>
         </ul>
         <div class="clear"></div>
      </div>
   </div>
   <div class="footer_r">
      <div class="block_facebook facebook_0 blocks_banner blocks0 block" id="block_id_125">
         <div class="block_title"><span>Kết nối trên facebook</span></div>
         <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2F&tabs&width=340&height=196&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=1218709491592197" width="340" height="196" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
      </div>
   </div>
</div>
<div class="clear"></div>
<div class="footer_bottom_b">
   <div class=" container">
      <div class="footer_bottom">
         <div class="share_column"></div>
         <div class="copy-right">
            <span class="cpy">Copyright © {{date('Y')}} muabansimso.vn </span> All Right Reserved. | Thiết kế web: Expro.vn
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="viewCard" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-body">
            <div class="check_order"></div>
         </div>
      </div>
   </div>
</div>
@yield('scripts')
<script   async='async' language="javascript" type="text/javascript" src="https://muasim.com.vn/cache/js/eea75a4641485b9d8272ad5903b8d3fd.js?20200730075429" ></script>
<script   async='async' language="javascript" type="text/javascript" src="{{asset('/js/jquery_home.js')}}" ></script>
<script>
   @if ($errors->any())
       @foreach ($errors->all() as $error)
           showNotification('bg-black', '{{ $error }}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
       @endforeach
   @endif
   @if(\Route::current()->getName()!='account.credit')
   @if(session('notify'))
           showNotification('bg-green', '{{session('notify')}}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
   @endif
   @endif
</script>
</body>
</html>