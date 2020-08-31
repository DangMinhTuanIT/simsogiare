@extends('home')
@section('title', $module_name)
@section('style')
@parent
<link href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
<link href="{{ asset('public/plugins/dropzone/dropzone.css') }}" rel="stylesheet" />
<link href="{{ asset('public/plugins/light-gallery/css/lightgallery.css') }}" rel="stylesheet">
<link href="{{ asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection
@section('content')
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="{{ route('news.create') }}" method="post" role="form">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 float-right">
         <?php
                        $op_vis_array = array("1" => "Draft","0" => "Public");
    $month_array = array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun", "07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
                        $op_vis_str = "Public";
                        $op_vis = "Public";
                        $op_date_year = date("Y");
                        $op_date_month = date("m");
                        $op_date_day = date("d");
                        $op_date_hour = date("H");
                        $op_date_minute = date("i");?>
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
                <button type="submit" class="btn bg-teal btn-lg waves-effect">Thêm</button>
              </div>
          </div>
        </div>
         <div class="card ">
          <div class="postbox">
            <h3 class="hndle">Thể loại</h3>
            <div class="inside">
              <?php

               echo WebService::showCategories($category)?>
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
               <h3 class="section-title tit section-title-bold"><b></b><span class="section-title-main">Thêm Tin tức</span><b></b></h3>
               <div class="number_of_items m-t-20">
                  <div class="hub_items">
                     <button type="submit" class="btn bg-teal btn-lg waves-effect">Thêm mới</button>
                     <br>
                     <br>
                     <div class="row clearfix hub_item">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin0">
                           <div class="form-group form-float">
                              <label class="form-label">Tiêu đề</label>
                              <div class="form-line">
                                 <input type="text" class="form-control title_slugify" name="title" value="{{ old('title') }}" placeholder="Tiêu đề" required>
                              </div>
                           </div>
                        </div>
                       <div class="col-md-12 col-sm-12 col-xs-12 margin0">
                           <div class="form-group form-float">
                              <label class="form-label">Slug</label>
                              <div class="form-line">
                                 <input type="text" class="form-control slug_slugify" name="slug" value="{{ old('slug') }}" placeholder="Slug" required>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Nổi bật</label>
                           <div class="form-float">
                              <input type="checkbox" name="feature" class="feature">
                           </div>
                        </div>
                         <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Tags</label>
                           <div class="form-float">
                              <select id='pre-selected-options' name="tags[]" multiple="true">
                                @foreach($tags as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Nội dung</label>
                           <div class="form-float">
                              <div> <textarea rows="4" cols="50" id="description" type="text" required  class="content" name="content">{{ old('content') }}</textarea></div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Mô tả ngắn</label>
                           <div class="form-float">
                              <div> <textarea rows="4" cols="50" id="content" class="intro" name="intro">{{ old('intro') }}</textarea></div>
                           </div>
                        </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Meta title</label>
                           <div class="form-float">
                              <div class="form-line">
                               <input type="text" class="form-control" id="seo_title" name="site_title" value="{{ old('site_title') }}" placeholder="Nếu để trống sẽ lấy tiêu đề">
                                <div class="clear pd_lender" style="font-size:14px;color:#060;"><span id="char_title" style="color:#F00; font-weight:bold;"></span>ký tự, Max 70 ký tự</div>
                              </div>
                           </div>
                        </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">SEO Description:</label>
                           <div class="form-float">
                              <div> <textarea rows="4" cols="50" style="height: 50px;width:100%;" id="seo_description" class="meta_desc" name="meta_desc">{{ old('meta_desc') }}</textarea></div>
                           </div>
                           <div class="clear pd_lender" style="font-size:14px;color:#060;"><span id="char_description" style="color:#F00; font-weight:bold;"></span> ký tự, Max <b>150-160</b> ký tự</div>
                           <p style="color:#9e9e9e">Nếu để trống sẽ lấy 100 ký tự đầu tiên ở phần mô tả nối sau bằng dấu ... </p>
                        </div>
				               <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">SEO Keyword:</label>
                           <div class="form-float">
                              <div> <textarea rows="4" id="seo_keyword" cols="50" style="height: 50px;width:100%;" class="meta_key" name="meta_key"><?php echo  old('meta_key')!='' ?  old('meta_key') : \App\myHelper::keyword_random()?></textarea></div>
                               <div class="clear pd_lender" style="font-size:14px;color:#060;"><span id="char_keyword" style="color:#F00; font-weight:bold;"></span> ký tự</div>
                           </div>
                        </div>
                       
                      
                        <div class="col-md-4 col-sm-12 col-xs-12 js">
                           <label class="form-label">Hình ảnh (jpg, png) (<span class="red">size không quá 1MB</span>)</label>
                           <div class="box">
                              <input type="file" value="{{ old('link') }}" name="link" id="link" class="inputfile inputfile-1">
                              <label class="chonhinhanh" for="link">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                 </svg>
                                 <span>Chọn hình ảnh …</span>
                              </label>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                           <select name="status" class="form-control show-tick ms type_price valid" aria-invalid="false">
                              @foreach (config('pgvietnam.status_profile') as $key => $value)
                              <option  value="{{$key}}">{{$value}}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                  </div>
               </div>
               <button type="submit" class="btn bg-teal btn-lg waves-effect">Thêm mới</button>
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

<!-- <script src="{{ asset('/public/plugins/nouislider/nouislider.js') }}"></script> -->
<!-- <script src="{{ asset('/public/plugins/light-gallery/js/lightgallery-all.js') }}"></script> -->
<script src="{{ asset('/public/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('/public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="//ajax.aspnetcdn.com/ajax/mvc/5.2.3/jquery.validate.unobtrusive.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{ asset('/public/js/slugify.js') }}"></script>
@include('admin.news.scripts')
@endsection