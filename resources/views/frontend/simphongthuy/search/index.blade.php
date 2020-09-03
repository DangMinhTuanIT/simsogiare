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
                              @php
                              $active = $giosinh==$key ? 'selected' : '';
                               @endphp
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
                              @php $number = strlen($i)==1 ? '0'.$i : $i;
                              $active = $day==$i ? 'selected' : '';
                               @endphp
                              <option {{$active}} value="{{$i}}">{{$number}}</option>
                              @endfor
                           </select>
                           <select id="thangsinh" class="form-control" name="thangsinh">
                              @for($i=1;$i<13;$i++)
                              @php $number = strlen($i)==1 ? '0'.$i : $i;
                             $active = $month==$i ? 'selected' : '';
                               @endphp
                              <option {{$active}} value="{{$i}}">{{$number}}</option>
                              @endfor
                              
                           </select>
                           <select id="namsinh" class="form-control" name="namsinh">
                              @for($i=1959;$i<2022;$i++)
                             @php $number = strlen($i)==1 ? '0'.$i : $i;
                             $active = $year==$i ? 'selected' : '';
                               @endphp
                              <option {{$active}} value="{{$i}}">{{$i}}</option>
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
   <div class="ngu_hanh">{!!@$ngu_hanh!!}</div>
   
   <div class="simslist_block_title">{!!@$simslist_block_title!!}</div>
   {!!WebService::get_bottom_related_simphongthuy()!!}
</div>
            </div>
                     @include('frontend.sidebar_simphongthuy')
         </div>
      </div>
   </div>
</div>
@endsection