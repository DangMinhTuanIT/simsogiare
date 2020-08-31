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
                 <div class="wrapper_fengshui">
   <div class="title">
      <h1>Tìm sim phong thuỷ, số điện thoại hợp tuổi</h1>
   </div>
   <div class="pos_fengshui">
      <div id="tab1_content" class="tra-cuu tab1_content selected">
         <div class="body-tool">
            <form method="post" action="https://muasim.com.vn/sim-phong-thuy.html" name="feng_shui" class="form" onsubmit="javascript: return checkFormsubmit();">
               <table width="60%" cellspacing="0" cellpadding="10">
                  <tbody>
                     <tr>
                        <td class="text-bold text-primary">Giờ sinh : </td>
                        <td>
                           <select style="width:100%;" id="giosinh" class="form-control" name="giosinh">
                              <option value="0">Tý (23-01h)</option>
                              <option value="1">Sửu (1h-3h)</option>
                              <option value="2">Dần (3h-5h)</option>
                              <option value="3">Mão (5h-7h)</option>
                              <option value="4">Thìn (7h-9h)</option>
                              <option value="5">Tỵ (9h-11h)</option>
                              <option value="6">Ngọ (11h-13h)</option>
                              <option value="7">Mùi (13h-15h)</option>
                              <option value="8">Thân (15h-17h)</option>
                              <option value="9">Dậu (17h-19h)</option>
                              <option value="10">Tuất (19h-21h)</option>
                              <option value="11">Hợi (21h-23h)</option>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td class="text-bold text-primary">Ngày sinh (D.Lịch) : </td>
                        <td>
                           <select id="ngaysinh" class="form-control" name="ngaysinh">
                              <!-- <option value="0" selected>Ngày</option> -->
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                              <option value="25">25</option>
                              <option value="26">26</option>
                              <option value="27">27</option>
                              <option value="28">28</option>
                              <option value="29">29</option>
                              <option value="30">30</option>
                              <option value="31">31</option>
                           </select>
                           <select id="thangsinh" class="form-control" name="thangsinh">
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                           </select>
                           <select id="namsinh" class="form-control" name="namsinh">
                              <option value="1959">1959</option>
                              <option value="1960">1960</option>
                              <option value="1961">1961</option>
                              <option value="1962">1962</option>
                              <option value="1963">1963</option>
                              <option value="1964">1964</option>
                              <option value="1965">1965</option>
                              <option value="1966">1966</option>
                              <option value="1967">1967</option>
                              <option value="1968">1968</option>
                              <option value="1969">1969</option>
                              <option value="1970">1970</option>
                              <option value="1971">1971</option>
                              <option value="1972">1972</option>
                              <option value="1973">1973</option>
                              <option value="1974">1974</option>
                              <option value="1975">1975</option>
                              <option value="1976">1976</option>
                              <option value="1977">1977</option>
                              <option value="1978">1978</option>
                              <option value="1979">1979</option>
                              <option value="1980">1980</option>
                              <option value="1981">1981</option>
                              <option value="1982">1982</option>
                              <option value="1983">1983</option>
                              <option value="1984">1984</option>
                              <option value="1985">1985</option>
                              <option value="1986">1986</option>
                              <option value="1987">1987</option>
                              <option value="1988">1988</option>
                              <option value="1989">1989</option>
                              <option value="1990">1990</option>
                              <option value="1991">1991</option>
                              <option value="1992">1992</option>
                              <option value="1993">1993</option>
                              <option value="1994">1994</option>
                              <option value="1995">1995</option>
                              <option value="1996">1996</option>
                              <option value="1997">1997</option>
                              <option value="1998">1998</option>
                              <option value="1999">1999</option>
                              <option value="2000">2000</option>
                              <option value="2001">2001</option>
                              <option value="2002">2002</option>
                              <option value="2003">2003</option>
                              <option value="2004">2004</option>
                              <option value="2005">2005</option>
                              <option value="2006">2006</option>
                              <option value="2007">2007</option>
                              <option value="2008">2008</option>
                              <option value="2009">2009</option>
                              <option value="2010">2010</option>
                              <option value="2011">2011</option>
                              <option value="2012">2012</option>
                              <option value="2013">2013</option>
                              <option value="2014">2014</option>
                              <option value="2015">2015</option>
                              <option value="2016">2016</option>
                              <option value="2017">2017</option>
                              <option value="2018">2018</option>
                              <option value="2019">2019</option>
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td class="text-bold text-primary">Giới tính : </td>
                        <td>
                           <select id="gioitinh" class="form-control" name="gioitinh">
                              <option value="1">Nam</option>
                              <option value="0">Nữ</option>
                           </select>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <div class="submit_form">
                  <!--      <a class="button" href="javascript: void(0)" id='submitbt'>
                     <span>Tìm sim hợp tuổi</span>
                     </a> -->
                  <input type="button" onclick="check_fengshui()" name="submit" id="submitbt1" class="button" value="Tìm sim hợp tuổi">
               </div>
               <input type="hidden" name="module" id="link_fengshui" value="{{URL::to('/sim-phong-thuy/day-month-year-sex-time.html')}}">   
            </form>
         </div>
         <div class="shading">
         </div>
      </div>
   </div>
   <div class="content_fengshui">
      <p><span style="font-size:14px"><strong>Sim phong thủy, xem bói số điện thoại theo năm sinh, chọn sim hợp tuổi theo cung mạng. Công cụ chấm điểm số điện thoại giúp quý khách tìm mua được những sim số đẹp theo phong thủy.</strong></span></p>
      <h2><span style="font-size:18px"><strong>Một sim số hợp phong thủy nhất phải hội đủ các yếu tố như sau:</strong></span><br>
         &nbsp;
      </h2>
      <h2 style="margin-left:40px"><span style="font-size:14px">+ Phải là con số cân bằng âm dương.</span></h2>
      <p style="margin-left:40px"><span style="font-size:14px">+ Phải là con số tương sinh giữa ngũ hành của dãy số với ngũ hành của người sử dụng.</span></p>
      <p style="margin-left:40px"><span style="font-size:14px">+ Phải là con số chứa ẩn sự may mắn, tốt lành, đại cát</span></p>
      <p style="margin-left:40px"><span style="font-size:14px">+ Cuối cùng là phải có quái khí hàm chứa các yếu tố tương hỗ cho người dùng.</span></p>
      <p><span style="font-size:14px">Chỉ cần bạn nhập chính xác&nbsp;sim số đẹp&nbsp;của bạn và chọn ngày tháng năm sinh&nbsp;&nbsp;cùng giờ sinh để xem kết quả. Công cụ được lập trình tính toán dựa trên những nguyên tắc trên đây hội tụ đầy đủ những yếu tố tạo ra một số đẹp hợp phong thủy cho bạn,&nbsp;phong thủy số điện thoại&nbsp;: Nên chọn thế nào cho đúng ?</span></p>
      <p><br>
         <span style="font-size:14px">Theo các chuyên gia phong thủy cho rằng: Bất kể số nào cũng phải dựa vào quy luật tự nhiên (tức quy luật âm dương ngũ hành). Có nam có nữ (tức có dương có âm mới có sinh), có sinh tất có thành cho nên trong dịch học 9 số (còn gọi là cửu tinh) được sắp xếp theo nhóm số (sinh và số thành) : 1- 6 là Thủy, 2-7 là Hỏa, 3-8 là Mộc và 4-9 là Kim.</span>
      </p>
      <p><br>
         <span style="font-size:14px">Vậy khi dùng số để mong cầu sự sinh thành thì nên dùng 2 số cuối của dãy số, biểu thị sự sinh thành mới mong hợp quy luật tự nhiên .</span>
      </p>
      <p><span style="color:#ff3300"><u><em><span style="font-size:14px">Cụ thể :</span></em></u></span></p>
      <ul>
         <li><span style="font-size:14px">Người có niên mệnh là Thủy, hoặc mệnh quái Khảm thì nên dùng 2 số cuối (1-6).</span></li>
      </ul>
      <p style="margin-left:40px">&nbsp;</p>
      <ul>
         <li><span style="font-size:14px">Người niên mệnh là Hỏa, hoặc mệnh quái Ly, ( niên mệnh Thổ nữa ) thì nên dùng 2 số cuối (2-7).</span></li>
      </ul>
      <p style="margin-left:40px">&nbsp;</p>
      <ul>
         <li><span style="font-size:14px">Người niên mệnh Mộc, hoặc mệnh quái Chấn, Tốn thì nên dùng 2 số (3-8)</span></li>
      </ul>
      <p style="margin-left:40px">&nbsp;</p>
      <ul>
         <li><span style="font-size:14px">Người niên mệnh Kim hoặc mệnh quái Càn, Đoài thì dùng 2 số (4-9).</span></li>
      </ul>
      <p style="margin-left:40px">&nbsp;</p>
      <p><span style="font-size:14px">Tuy nhiên trong ngũ hành, thì hành Mộc biểu thị sự sinh, hơn nữa về thời vận, hiện nay đang trong vận 8 (từ 2004-2023). Thì nhóm số (3-8), (4-6), (1-6) đều là số đẹp chỉ cần hợp mệnh nữa là mỹ mãn.</span></p>
      <p><br>
         <span style="font-size:14px">Tóm lại, nếu kinh tế không khá giả thì các bạn chỉ nên chơi 2 số cuối là được.<br>
         Theo ý kiến riêng của chúng tôi thì:</span>
      </p>
      <p><br>
         <span style="font-size:14px">Các bạn mệnh Mộc (3-8) và mệnh Thủy (1-6) nếu chọn được 2 số cuối trùng với 2 số trên thì quá tốt.<br>
         Người niên mệnh Kim chọn được một trong hai số cuối là 4 cũng ổn</span>
      </p>
      <p><a href="https://muasim.com.vn/p/cham-diem-cho-sim-so-dien-thoai">Chấm điểm cho sim số điện thoại</a><br>
         &nbsp;
      </p>
      <p><span style="font-size:14px">Các niên mệnh còn lại ta chọn số tùy thích đi, vì phong thủy còn nhiều cái khác nữa mà.</span><br>
         <span style="font-size:14px">Chúc các bạn gặp nhiều may mắn và chọn được số điện thoại hợp phong thủy!</span>
      </p>
      <p><span style="font-size:14px">Hiện tại trung tâm&nbsp;sim số đẹp phong thủy&nbsp;Việt Nam ( muasim.com.vn ) có rất nhiều sim số hợp phong thủy cho bạn lựa chọn theo tư duy của bạn bài viết trên chỉ mang tính chất tham khảo để có cơ sở chọn số.Tuy nhiên để lựa chọn được một&nbsp;<a href="https://muasim.com.vn/p/sim-phong-thuy" title="sim phong thuy">sim phong thủy</a>&nbsp;điểm 10 là rất khó, bởi những sim số này phải tuân theo một quy luật hết sức chặt chẽ về phong thủy. điểm tương đối chỉ từ 7,5 đến 9,5 là đạt.</span></p>
      <p><br>
         <span style="color:#ff3300"><span style="font-size:12px"><em>Tags:&nbsp;sim phong thuy, sim so dep phong thuy, sim dien thoai phong thuy, xem boi so dien thoai, cham diem cho sim, sim hop tuoi, sim hop menh, kho sim phong thuy</em></span></span>
      </p>
   </div>
   <div class="pos_fengshui1">
      <div class="block_fengshui fengshui_0 blocks_fengshui blocks0 block" id="block_id_196">
         <div class="fengshui_year">
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-2006.html" title="Sim hợp tuổi 2006">Sim hợp tuổi 2006</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-2005.html" title="Sim hợp tuổi 2005">Sim hợp tuổi 2005</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-2004.html" title="Sim hợp tuổi 2004">Sim hợp tuổi 2004</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-2003.html" title="Sim hợp tuổi 2003">Sim hợp tuổi 2003</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-2002.html" title="Sim hợp tuổi 2002">Sim hợp tuổi 2002</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-2001.html" title="Sim hợp tuổi 2001">Sim hợp tuổi 2001</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-2000.html" title="Sim hợp tuổi 2000">Sim hợp tuổi 2000</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1999.html" title="Sim hợp tuổi 1999">Sim hợp tuổi 1999</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1998.html" title="Sim hợp tuổi 1998">Sim hợp tuổi 1998</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1997.html" title="Sim hợp tuổi 1997">Sim hợp tuổi 1997</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1996.html" title="Sim hợp tuổi 1996">Sim hợp tuổi 1996</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1995.html" title="Sim hợp tuổi 1995">Sim hợp tuổi 1995</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1994.html" title="Sim hợp tuổi 1994">Sim hợp tuổi 1994</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1993.html" title="Sim hợp tuổi 1993">Sim hợp tuổi 1993</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1992.html" title="Sim hợp tuổi 1992">Sim hợp tuổi 1992</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1991.html" title="Sim hợp tuổi 1991">Sim hợp tuổi 1991</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1990.html" title="Sim hợp tuổi 1990">Sim hợp tuổi 1990</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1989.html" title="Sim hợp tuổi 1989">Sim hợp tuổi 1989</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1988.html" title="Sim hợp tuổi 1988">Sim hợp tuổi 1988</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1987.html" title="Sim hợp tuổi 1987">Sim hợp tuổi 1987</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1986.html" title="Sim hợp tuổi 1986">Sim hợp tuổi 1986</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1985.html" title="Sim hợp tuổi 1985">Sim hợp tuổi 1985</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1984.html" title="Sim hợp tuổi 1984">Sim hợp tuổi 1984</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1983.html" title="Sim hợp tuổi 1983">Sim hợp tuổi 1983</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1982.html" title="Sim hợp tuổi 1982">Sim hợp tuổi 1982</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1981.html" title="Sim hợp tuổi 1981">Sim hợp tuổi 1981</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1980.html" title="Sim hợp tuổi 1980">Sim hợp tuổi 1980</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1979.html" title="Sim hợp tuổi 1979">Sim hợp tuổi 1979</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1978.html" title="Sim hợp tuổi 1978">Sim hợp tuổi 1978</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1977.html" title="Sim hợp tuổi 1977">Sim hợp tuổi 1977</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1976.html" title="Sim hợp tuổi 1976">Sim hợp tuổi 1976</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1975.html" title="Sim hợp tuổi 1975">Sim hợp tuổi 1975</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1974.html" title="Sim hợp tuổi 1974">Sim hợp tuổi 1974</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1973.html" title="Sim hợp tuổi 1973">Sim hợp tuổi 1973</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1972.html" title="Sim hợp tuổi 1972">Sim hợp tuổi 1972</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1971.html" title="Sim hợp tuổi 1971">Sim hợp tuổi 1971</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1970.html" title="Sim hợp tuổi 1970">Sim hợp tuổi 1970</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1969.html" title="Sim hợp tuổi 1969">Sim hợp tuổi 1969</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1968.html" title="Sim hợp tuổi 1968">Sim hợp tuổi 1968</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1967.html" title="Sim hợp tuổi 1967">Sim hợp tuổi 1967</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1966.html" title="Sim hợp tuổi 1966">Sim hợp tuổi 1966</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1965.html" title="Sim hợp tuổi 1965">Sim hợp tuổi 1965</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1964.html" title="Sim hợp tuổi 1964">Sim hợp tuổi 1964</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1963.html" title="Sim hợp tuổi 1963">Sim hợp tuổi 1963</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1962.html" title="Sim hợp tuổi 1962">Sim hợp tuổi 1962</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1961.html" title="Sim hợp tuổi 1961">Sim hợp tuổi 1961</a>
            <a href="https://muasim.com.vn/sim-phong-thuy/sim-hop-tuoi-1960.html" title="Sim hợp tuổi 1960">Sim hợp tuổi 1960</a>
         </div>
      </div>
   </div>
</div>
            </div>
                     @include('frontend.sidebar_simphongthuy')
         </div>
      </div>
   </div>
</div>
@endsection