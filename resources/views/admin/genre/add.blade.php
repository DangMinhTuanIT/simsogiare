@extends('home')
@section('title', $module_name)
@section('style')
@parent
@endsection
@section('content')
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="{{ route('genre.store') }}" method="post" role="form">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix">
    <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    
                    Thông tin về thể loại
                
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><label for="name_genre">Tên thể loại</label></label>
                        <input type="text" id="name_genre" name="name_genre" value="{{old('name_genre')}}" class="form-control title_slugify" placeholder="Tên thể loại SIM, ví dụ: Sim tứ quý">                    </div>
                    <div class="form-group">
                        <label><label for="status">Trạng thái</label></label>
                        <select id="status" name="status" class="form-control">
                            @foreach(config('simsogiare.status_category_network') as $key => $item)
                             @php $active = old('status')==$key ? 'selected="selected"' : '' @endphp
                            <option {{$active}} value="{{$key}}">{{$item}}</option>
                            @endforeach
                        </select>                        
                        <p class="help-block">Tình trạng active sẽ được hiển thị ở trang chủ.</p>
                    </div>
                    <div class="form-group">
                        <label><label for="weight">Vị trí</label></label>
                        <select id="weight" name="weight" class="form-control">
                            @for($i=1;$i<25;$i++)
                            @php $active = old('weight')==$i ? 'selected="selected"' : '' @endphp
                            <option {{$active}} value="{{$i}}">{{$i}}</option>
                            @endfor
   
</select>                        <p class="help-block">Vị trí sắp xếp của thể loại, số nhỏ đứng trước. Chú ý sẽ ảnh hưởng tới kết quả tự động nhận dạng nếu sai vị trí. Ví dụ bạn không thể để thể loại "tam hoa" đứng trước "tứ quý"

</p>
                    </div>
                     <div class="form-group">
                        <label><label for="type_sidebar">Sidebar</label></label>
                        <select id="type_sidebar" name="type_sidebar" class="form-control">
                            @php $type_sidebar = config('simsogiare.type_sidebar') @endphp
                            @foreach($type_sidebar as $key => $item)
                            @php $active = old('type_sidebar')==$key ? 'selected="selected"' : '' @endphp
                            <option {{$active}} value="{{$key}}">{{$item}}</option>
                            @endforeach
                        </select>                       
                    </div>
                   <div class="form-group">
                        <label><label for="regex">Chuỗi nhận dạng</label></label>
                        <input type="text" id="regex" name="regex" value="{{old('regex')}}" class="form-control" placeholder="Tự động nhận dạng lúc import SIM" data-max-length="1">                        <p class="help-block">
                            Là mẫu để tự động nhận dạng SIM thuộc thể loại này. Ví dụ muốn nhận dạng sim kép có số 1 và 2: <b>/(1122|2211)$/</b>
                        </p>
                    </div>
                    <div class="form-group">
                        <label><label for="detect">Số SIM mẫu</label></label>
                        <input type="text" id="detect" name="detect" value="{{old('detect')}}" class="form-control" placeholder="Số SIM mẫu thuộc thể loại này" data-max-length="1">                    </div>
                          <div class="form-group form-float ">
                        <div><label for="weight">Mô tả ngắn</label></div>
                        <textarea name="description" id="" cols="60" rows="4">{{old('description')}}</textarea>
                      </div>
                       <div class="form-group form-float ">
                        <div><label for="weight">Nội dung chính</label></div>
                        <textarea name="content" id="description" cols="20" rows="5">{{old('content')}}</textarea>
                      </div>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                    <a type="button" href="{{route('genre.list')}}" class="btn btn-default">Quay lại</a>
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
                        <input type="text" id="alias" name="alias" value="{{old('alias')}}" class="form-control slug_slugify" placeholder="Đường dẫn thân thiện">                        <p class="help-block">Chỉ được sử dụng các từ a-z 0-9 dấu gạch ngang (-). Ví dụ: viettel. Nếu không nhập thì được tạo từ động từ tên của nhà mạng</p>
                    </div>
                    <div class="form-group">
                        <label><label for="meta_title">Tiêu đề của trang</label></label>
                        <input type="text" id="meta_title" name="meta_title" value="{{old('meta_title')}}" class="form-control" placeholder="Tiêu đề của trang" maxlength="128">                    </div>
                    <div class="form-group">
                        <label><label for="meta_keywords">Từ khóa</label></label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{old('meta_keywords')}}" class="form-control auto-tags" placeholder="Từ khóa của trang, mỗi từ khóa cách nhau bằng dấu phẩy" maxlength="128">                    </div>
                    <div class="form-group">
                        <label><label for="meta_description">Trích dẫn</label></label>
                        <textarea id="meta_description" name="meta_description" value="{{old('meta_description')}}" class="form-control" placeholder="Trích dẫn của trang">{{old('seo_description')}}</textarea>                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
                  </div>
   <!-- #END# Input Group -->
</form>
@include('filters')
@endsection
@section('script')
@include('general.layouts.data-table-scripts')
@include('admin.genre.scripts')
@endsection