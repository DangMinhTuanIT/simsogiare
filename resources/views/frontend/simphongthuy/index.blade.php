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
                              @php $giosinh_arr = config('simsogiare.giosinh')  @endphp
                              @foreach($giosinh_arr as $key =>$item)
                              <option {{@$active}} value="{{$key}}">{{$item}}</option>
                              @endforeach 
                           </select>
                        </td>
                     </tr>
                     <tr>
                        <td class="text-bold text-primary">Ngày sinh (D.Lịch) : </td>
                        <td>
                           <select id="ngaysinh" class="form-control" name="ngaysinh">
                             @for($i=1;$i<32;$i++)
                              @php $number = strlen($i)==1 ? '0'.$i : $i; @endphp
                              <option value="{{$i}}">{{$number}}</option>
                              @endfor
                           </select>
                           <select id="thangsinh" class="form-control" name="thangsinh">
                              @for($i=1;$i<13;$i++)
                              @php $number = strlen($i)==1 ? '0'.$i : $i; @endphp
                              <option value="{{$i}}">{{$number}}</option>
                              @endfor
                              
                           </select>
                           <select id="namsinh" class="form-control" name="namsinh">
                              @for($i=1959;$i<2022;$i++)
                              @php $number = strlen($i)==1 ? '0'.$i : $i; @endphp
                              <option value="{{$i}}">{{$i}}</option>
                              @endfor
                              
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
   {!!WebService::get_bottom_related_simphongthuy()!!}
</div>
            </div>
                     @include('frontend.sidebar_simphongthuy')
         </div>
      </div>
   </div>
</div>
@endsection