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
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="<?php echo URL::to('admin/category/update/'.$info->id);?>" method="post" role="form">
  <input type="hidden" name="_method" value="PUT">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <div class="card">
            <div class="header">
               <h2>
                  THÊM MỚI <span class="text-uppercase">{{ $module_name }}</span>
               </h2>
            </div>
            <div class="body">
               <!--  -->
               <h3 class="section-title tit section-title-bold"><b></b><span class="section-title-main">Sửa Page</span><b></b></h3>
               <div class="number_of_items m-t-20">
                  <div class="hub_items">
                     <button type="submit" class="btn bg-teal btn-lg waves-effect">EDIT</button>
                     <p><hr>Demo Link: <a href="@php echo  URL::to('category/'.$info->slug.'-ca'.$info->id.'.html'); @endphp " target="_blank">@php echo  URL::to('category/'.$info->slug.'-ca'.$info->id.'.html')@endphp </a>
                     <hr></p>
                     <div class="row clearfix hub_item">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin0">
                           <div class="form-group form-float">
                              <label class="form-label">Tên Page</label>
                              <div class="form-line">
                                 <input type="text" class="form-control title_slugify" name="name" value="{{ $info->name }}" placeholder="Tên Page" required>
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
                           <label class="form-label">Danh mục cha</label>
                           <div class="form-float">
                              <select name="parent_id" id="" class="select">
                                 <option value="0">Chọn thể loại</option>
                                 <?php
                                 if(!empty($category)){
                                    foreach ($category as $cat) {
                                      $style = $info->parent_id == $cat->id ? 'selected' : '';
                                      echo '<option '.$style.' value="'.$cat->id.'">'.$cat->name.'</option>';
                                    }
                                 }
                                  ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Mô tả ngắn</label>
                           <div class="form-float">
                              <div> <textarea rows="4" cols="50" id="intro" class="intro" name="description">{{ $info->intro }}</textarea></div>
                           </div>
                        </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">Meta title</label>
                           <div class="form-float">
                              <div class="form-line">
                               <input type="text" class="form-control" id="seo_title" name="site_title" value="{{ $info->site_title }}" placeholder="Site Title">
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
                        </div>
                       <div class="col-md-12 col-sm-12 col-xs-12">
                           <label class="form-label">SEO Keyword:</label>
                           <div class="form-float">
                              <div> <textarea rows="4" id="seo_keyword" cols="50" style="height: 50px;width:100%;" class="meta_key" name="meta_key">{{ $info->meta_key }}</textarea></div>
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
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                           <select name="status" class="form-control show-tick ms type_price valid" aria-invalid="false">
                              @foreach (config('simsogiare.status_profile') as $key => $value)
                              <option  value="{{$key}}">{{$value}}</option>
                              @endforeach
                           </select>
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
<script src="{{ asset('/public/admin/ckfinder/ckfinder.js') }}"></script>
<script src="{{ asset('/public/admin/ckeditor/ckeditor.js') }}"></script>

<script src="{{ asset('/public/plugins/nouislider/nouislider.js') }}"></script>
<script src="{{ asset('/public/plugins/light-gallery/js/lightgallery-all.js') }}"></script>
<script src="{{ asset('/public/plugins/momentjs/moment.js') }}"></script>
<script src="{{ asset('/public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="//ajax.aspnetcdn.com/ajax/mvc/5.2.3/jquery.validate.unobtrusive.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="{{ asset('/public/js/slugify.js') }}"></script>
@include('admin.category.scripts')
@endsection