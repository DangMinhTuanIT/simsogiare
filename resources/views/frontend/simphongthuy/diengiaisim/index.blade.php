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
                    <h1 class="title feng_cb text-center">
                                 <span>Xem phong thủy sim theo ngày tháng năm sinh</span>
                        </h1>
                     <div class="pos_fengshui">
                        <div id="tab1_content" class="tra-cuu tab1_content selected">
                           <div class="body-tool">
                              <form method="post" action="/sim-phong-thuy.html" name="feng_shui" class="form" onsubmit="javascript: return checkFormsubmit();">
                                 <table width="60%" cellspacing="0" cellpadding="10">
                                    <tbody>
                                       <tr>
                                          <td class="text-bold text-primary">Nhập số điện thoại : </td>
                                          <td>
                                             <input id="sodienthoai" class="form-control" width="300" type="text" value="{{$phone}}" placeholder="Nhập số sim cần xem" name="sodienthoai">
                                          </td>
                                       </tr>
                                       <tr>
                                          <td class="text-bold text-primary">Giờ sinh : </td>
                                          <td>
                                             <select style="width:100%;" id="giosinh" class="form-control" name="giosinh">
                                                @php $giosinh_arr = config('simsogiare.giosinh')  @endphp
                                                @foreach($giosinh_arr as $key =>$item)
                                                <option value="{{$key}}">{{$item}}</option>
                                                @endforeach 
                                             </select>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td class="text-bold text-primary">Ngày sinh (D.Lịch) : </td>
                                          <td>
                                             <select id="ngaysinh" class="form-control" name="ngaysinh">
                                               @for($i=1;$i<32;$i++)
                                                @php $number = strlen($i)==1 ? '0'.$i : $i;
                                                 @endphp
                                                <option  value="{{$i}}">{{$number}}</option>
                                                @endfor
                                             </select>
                                             <select id="thangsinh" class="form-control" name="thangsinh">
                                                @for($i=1;$i<13;$i++)
                                                @php $number = strlen($i)==1 ? '0'.$i : $i;
                                                 @endphp
                                                <option  value="{{$i}}">{{$number}}</option>
                                                @endfor
                                                
                                             </select>
                                             <select id="namsinh" class="form-control" name="namsinh">
                                                @for($i=1959;$i<2022;$i++)
                                               @php $number = strlen($i)==1 ? '0'.$i : $i;
                                                 @endphp
                                                <option  value="{{$i}}">{{$i}}</option>
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
                                    <input type="button" name="submit" id="check_fengshui_phone1" class="button submitbt1" value="Xem Điểm">
                                 </div>
                                 <input type="hidden" name="module" id="link_fengshui_phone" value="{{URL::to('sim-phong-thuy/dien-giai-phone/day-month-year-sex-time.html')}}">   
                              </form>
                           </div>
                           <div class="shading">
                           </div>
                        </div>
                     </div>
                     <div class="sim-phong-thuy">
                        {!!@$info->content!!}
                        <div class="point_center">Tổng điểm:<span class="text-bold text-back-d" style="font-size:22px;"> {{@$info->point_sim}} / 10 </span></div>
                        <div class="buy_detail">
                              <a class="link_sims" href="{{route('single_sim.list',array($info->number_sim))}}" title="{{@$info->number_sim}}">Mua sim {{@$info->number_sim}}</a>
                           </div>
                     </div>
                  </div>
                     {!!WebService::get_bottom_related_simphongthuy()!!}
                  </div>
            </div>
                     @include('frontend.sidebar_simphongthuy')
         </div>
      </div>
   </div>
</div>
<script>
   if (typeof check_fengshui_phone == 'function') { 
   function check_fengshui_phone(){
    var sodienthoai = $( "#sodienthoai" ).val();
    var giosinh = $( "#giosinh" ).val();
    var ngaysinh = $( "#ngaysinh" ).val();
    var thangsinh = $( "#thangsinh" ).val();
    var namsinh = $( "#namsinh" ).val();
    // alert(namsinh)
    var gioitinh = $( "#gioitinh" ).val();
    if(gioitinh==0){
      gioitinh='nu';
    }else{
      gioitinh='nam';
    }
    let link_fengshui = $( "#link_fengshui_phone" ).val();
   link_search = link_fengshui.replace('phone',sodienthoai);
   link_search0 = link_search.replace('sex',gioitinh);
   link_search1 = link_search0.replace('day',ngaysinh);
   link_search2 = link_search1.replace('month',thangsinh);
   link_search3 = link_search2.replace('year',namsinh);
   link = link_search3.replace('time',giosinh);
    // alert(link);
    // $link   = 
    window.location.href=link;
   
}
}
</script>
@endsection