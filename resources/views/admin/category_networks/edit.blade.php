@extends('home')
@section('title', $module_name)
@section('style')
@parent

@endsection
@section('content')
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="{{route('category_networks.update_db',array($info->id))}}" method="post" role="form">
  <input type="hidden" name="_method" value="PUT">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix"> 
    <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Thông tin về nhà mạng
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><label for="name_network">Tên nhà mạng</label></label>
                        <input type="text" id="name_network" name="name_network" value="{{$info->name_network}}" class="form-control title_slugify" placeholder="Tên nhà mạng, ví dụ: Viettel">                    </div>
                    <div class="form-group">
                        <label><label for="status">Trạng thái</label></label>
                        <select id="status" name="status" class="form-control">
                            @foreach(config('simsogiare.status_category_network') as $key => $item)
                             @php $active = $info->status==$key ? 'selected="selected"' : '' @endphp
                            <option {{$active}} value="{{$key}}">{{$item}}</option>
                            @endforeach
                        </select>                        
                        <p class="help-block">Tình trạng active sẽ được hiển thị ở trang chủ.</p>
                    </div>
                    <div class="form-group">
                        <label><label for="weight">Vị trí</label></label>
                        <select id="weight" name="weight" class="form-control">
                            @for($i=1;$i<11;$i++)
                            @php $active = $info->weight==$i ? 'selected="selected"' : '' @endphp
                            <option {{$active}} value="{{$i}}">{{$i}}</option>
                            @endfor
   
</select>                        <p class="help-block">Vị trí sắp xếp của nhà mạng, số nhỏ đứng trước.</p>
                    </div>
                    <div class="form-group">
                         <div class="form-group form-float js">
                            <label class="form-label">Hình ảnh (jpg, png) (<span class="red">size không quá 1MB</span>)</label>
                            <div class="box">
                            <input type="hidden" class="thumbnail" name="thumbnail" value="{{@$info->image}}">
                              <input type="file" value="{{ old('link') }}" name="link" id="link" class="inputfile inputfile-1">
                              <label class="chonhinhanh" for="link">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                 </svg>
                                 <span>Chọn hình ảnh …</span>
                              </label>
                            </div>
                            @if($info->image!='')
                             <div class="img_thumb">
                              <a href="<?php echo URL::to('/uploads').'/'.@$info->image ?>" data-fancybox="images-preview_1" class="btn-close"> <img src="<?php echo URL::to('/uploads').'/'.@$info->image ?>" width="150">
                              </a>
                            </div>
                            @endif
                    </div>
                    <div class="form-group form-float ">
                        <div><label for="weight">Mô tả ngắn</label></div>
                        <textarea name="description" id="" cols="60" rows="4">{{$info->description}}</textarea>
                      </div>
                       <div class="form-group form-float ">
                        <div><label for="weight">Nội dung chính</label></div>
                        <textarea name="content" id="description" cols="20" rows="5">{{$info->content}}</textarea>
                      </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a type="button" href="{{route('category_networks.list')}}" class="btn btn-default">Quay lại</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
       <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Thông tin về SEO
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><label for="alias">Đường dẫn</label></label>
                        <input type="text" id="alias" name="alias" value="{{$info->slug}}" class="form-control slug_slugify" placeholder="Đường dẫn thân thiện">                        <p class="help-block">Chỉ được sử dụng các từ a-z 0-9 dấu gạch ngang (-). Ví dụ: viettel. Nếu không nhập thì được tạo từ động từ tên của nhà mạng</p>
                    </div>
                    <div class="form-group">
                        <label><label for="meta_title">Tiêu đề của trang</label></label>
                        <input type="text" id="meta_title" name="meta_title" value="{{$info->seo_title}}" class="form-control" placeholder="Tiêu đề của trang" maxlength="128">                    </div>
                    <div class="form-group">
                        <label><label for="meta_keywords">Từ khóa</label></label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{$info->seo_keyword}}" class="form-control auto-tags" placeholder="Từ khóa của trang, mỗi từ khóa cách nhau bằng dấu phẩy" maxlength="128">                    </div>
                    <div class="form-group">
                        <label><label for="meta_description">Trích dẫn</label></label>
                        <textarea id="meta_description" name="meta_description" value="{{$info->seo_description}}" class="form-control" placeholder="Trích dẫn của trang">{{$info->seo_description}}</textarea>                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
                  </div>
               
           
</form>
@include('filters')
@endsection
@section('script')
@include('general.layouts.data-table-scripts')
@include('admin.category_networks.scripts')
@endsection