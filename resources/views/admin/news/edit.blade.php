@extends('home')
@section('title', $module_name)
@section('style')
@parent
<link href="{{ asset('/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/dropzone/dropzone.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/light-gallery/css/lightgallery.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection
@section('content')
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="<?php echo URL::to('admin/news/update/'.$info->id);?>" method="post" role="form">
  <input type="hidden" name="_method" value="PUT">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix"> 
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 float-right">
         <?php
    $op_vis_array = array("1" => "Draft","0" => "Public");
    $month_array = array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun", "07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
    $updated_at = $info->updated_at;
    $arr_dated = explode(' ', $updated_at);
    $op_date = explode('-', $arr_dated[0]);
    $op_time = explode(':', $arr_dated[1]);
    $status_news = config('pgvietnam.status_news');
    $op_vis_str = $info->status;
    $op_vis = $info->status;
    $op_date_year = $op_date[0];
    $op_date_month = $op_date[1];
    $op_date_day = $op_date[2];
    $op_date_hour = $op_time[0];
    $op_date_minute = $op_time[1];
            ?>
          <div class="card ">
            <div class="postbox">
              <div id="visibility">
                <p class="title"><?php echo isset($op_vis_str) ? $op_vis_str : '' ?></p>
                <div id="post-visibility-select" style="display: block;">
                    <?php
                    echo \App\myHelper::create_crbox("op_vis", $op_vis_array, "radio", $op_vis);
                    ?>
                </div>
              </div>
              <div id="timestampdiv" style="display: block;">
                <p class="title"><b>DATE</b></p>
                <div class="timestamp-wrap">
                    <?php
                    echo \App\myHelper::Create_Selectbox("op_date_month", $month_array, $op_date_month, "tabindex='4'", "N");?>
                    <input type="text" tabindex="4" maxlength="2" size="2" name="op_date_day" id="op_date_day" value="<?php echo  isset($op_date_day) ? $op_date_day : '' ?>" />
                    ,
                    <input type="text" tabindex="4" maxlength="4" size="4" name="op_date_year" id="op_date_year" value="<?php echo isset($op_date_year) ? $op_date_year : '' ?>" />
                    <!--@-->
                    <input type="hidden" tabindex="4" maxlength="2" size="2" name="op_date_hour" id="op_date_hour" value="<?php echo isset($op_date_hour) ? $op_date_hour : '' ?>" />
                    <!--:-->
                    <input type="hidden" tabindex="4" maxlength="2" size="2" name="op_date_minute" id="op_date_minute" value="<?php echo isset($op_date_minute) ? $op_date_minute : '' ?>" />
                </div>
              </div>
              <div class="submit">
                <button type="submit" class="btn bg-teal btn-lg waves-effect">EDIT</button>
              </div>
          </div>
        </div>
         <div class="card ">
          <div class="postbox">
            <h3 class="hndle">Thể loại</h3>
            <div class="inside">
              <?php
               echo WebService::showCategoriesChecked($category,$post_category_a)?>
           </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
         <div class="card">
            <div class="header">
               <h2>
                  THÊM MỚI <span class="text-uppercase">{{ $module_name }}</span>
               </h2>
            </div>
            <div class="body">
               <!--  -->
               <h3 class="section-title tit section-title-bold"><b></b><span class="section-title-main">Sửa Tin tức</span><b></b></h3>
               <div class="number_of_items m-t-20">
                  <div class="hub_items">
                     <?php $link_news =  route('news.list_slug1',array($info->slug,$info->id));
                     if($info->id_category==15){
                       $link_news =  URL::to('nhan-dinh-bong-da/'.$info->slug);
                     }
                     ?>
                     <p><hr>Demo Link: <a href="{{$link_news}}" target="_blank">{{$link_news}}</a>
                     <hr></p>
                     <div class="row clearfix hub_item">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin0">
                           <div class="form-group form-float">
                              <label class="form-label">Tiêu đề</label>
                              <div class="form-line">
                                 <input type="text" class="form-control title_slugify" name="title" value="{{ $info->title }}" placeholder="Tiêu đề" required>
                              </div>
                           </div>
                        </div>
                       <div class="col-md-12 col-sm-12 col-xs-12 margin0">
                           <div class="form-group form-float">
                              <label class="form-label">Slug</label>
                              <div class="form-line">
                                 <input type="text" class="form-control slug_slugify" name="slug" value="{{ $info->slug }}" placeholder="Slug" required>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                         <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Nổi bật</label>
                           <div class="form-float">
                              <input type="checkbox" @php echo $info->feature==1 ? 'checked' : '' @endphp  name="feature" class="feature">
                           </div>
                        </div>
                        
                         <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Tags</label>
                           <div class="form-float">
                              <select id='pre-selected-options' name="tags[]" multiple="true">
                                @foreach($tags as $item)
                                <option <?php foreach ($post_tags_a as $row) {
                           echo $row->id_tag==$item->id ? 'selected' :'';
                           } ?> value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Nội dung</label>
                           <div class="form-float">
                              <div> <textarea rows="4" cols="50" id="description" type="text" required  class="content" name="content">{{ $info->content }}</textarea></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Mô tả ngắn</label>
                           <div class="form-float">
                              <div> <textarea rows="4" cols="50" id="content" class="intro" name="intro">{{ $info->intro }}</textarea></div>
                           </div>
                        </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Meta title</label>
                           <div class="form-float">
                              <div class="form-line">
                               <input type="text" class="form-control" id="seo_title" name="site_title" value="{{ $info->site_title }}" placeholder="Nếu để trống sẽ lấy tiêu đề">
                                <div class="clear pd_lender" style="font-size:14px;color:#060;"><span id="char_title" style="color:#F00; font-weight:bold;"></span>ký tự, Max 70 ký tự</div>
                              </div>
                           </div>
                        </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">SEO Description:</label>
                           <div class="form-float">
                              <div> <textarea rows="4" cols="50" style="height: 50px;width:100%;" id="seo_description" class="meta_desc" name="meta_desc">{{ $info->meta_desc }}</textarea></div>
                           </div>
                           <div class="clear pd_lender" style="font-size:14px;color:#060;"><span id="char_description" style="color:#F00; font-weight:bold;"></span> ký tự, Max <b>150-160</b> ký tự</div>
                           <p style="color:#9e9e9e">Nếu để trống sẽ lấy 100 ký tự đầu tiên ở phần mô tả nối sau bằng dấu ...</p>
                        </div>
                       <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">SEO Keyword:</label>
                           <div class="form-float">
                              <div> <textarea rows="4" id="seo_keyword" cols="50" style="height: 50px;width:100%;" class="meta_key" name="meta_key"><?php echo  $info->meta_key!='' ?  $info->meta_key : \App\myHelper::keyword_random()?></textarea></div>
                               <div class="clear pd_lender" style="font-size:14px;color:#060;"><span id="char_keyword" style="color:#F00; font-weight:bold;"></span> ký tự</div>
                           </div>
                        </div>
                       
                      
                        <div class="col-md-4 col-sm-12 col-xs-12 js">
                           <label class="form-label">Hình ảnh (jpg, png) (<span class="red">size không quá 1MB</span>)</label>
                           <div class="box">
                            <input type="hidden" class="thumbnail" name="thumbnail" value="{{@$info->image_link}}">
                              <input type="file" value="{{ old('link') }}" name="link" id="link" class="inputfile inputfile-1">
                              <label class="chonhinhanh" for="link">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                 </svg>
                                 <span>Chọn hình ảnh …</span>
                              </label>
                           </div>
                           @if($info->image_link!='')
                             <div class="img_thumb">
                              <a href="<?php echo URL::to('/').'/'.@$info->image_link ?>" data-fancybox="images-preview_1" class="btn-close"> <img src="<?php echo URL::to('/').'/'.@$info->image_link ?>" width="150">
                              </a>
                           </div>
                           @endif
                        </div>
                        
                     </div>
                  </div>
               </div>
               <button type="submit" class="btn bg-teal btn-lg waves-effect">EDIT</button>
            </div>
         </div>
      </div>
      
   </div>
   <!-- #END# Input Group -->
</form>
@include('filters')
@endsection
@section('script')
@include('general.layouts.data-table-scripts')
<!-- <script src="{{ asset('/public/admin/ckfinder/ckfinder.js') }}"></script> -->
<!-- <script src="{{ asset('/public/admin/ckeditor/ckeditor.js') }}"></script> -->

<script src="{{ asset('/plugins/nouislider/nouislider.js') }}"></script>
<script src="{{ asset('/plugins/light-gallery/js/lightgallery-all.js') }}"></script>
<script src="{{ asset('/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="//ajax.aspnetcdn.com/ajax/mvc/5.2.3/jquery.validate.unobtrusive.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{ asset('/js/slugify.js') }}"></script>
@include('admin.news.scripts')
@endsection