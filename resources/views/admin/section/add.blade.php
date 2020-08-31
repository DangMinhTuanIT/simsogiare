@extends('home')
@section('title', $module_name)
@section('style')
@parent
@endsection
@section('content')
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="{{ route('section.store',array($id_section)) }}" method="post" role="form">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix">
    <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    
                   Thông tin về đầu số

                
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><label for="name_section">Tên đầu số</label></label>
                        <input type="text" id="name_section" name="name_section" value="{{old('name_section')}}" class="form-control" placeholder="Tên hiển thị đầu số, ví dụ: Đầu số 097">                    </div>
                        <div class="form-group">
                        <label><label for="number_section">Đầu số</label></label>
                        <input type="text" id="number_section" name="number_section" class="form-control" value="{{old('number_section')}}" placeholder="Đầu số của nhà mạng, ví dụ: 097">                    </div>
                         <div class="form-group">
                        <label><label for="parent_id">Chọn thể loại Cha</label></label>
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="0" >== Không có ==</option>
                            @foreach(@$parrent as $item)
                             @php $active = old('parent_id')==$item->id ? 'selected="selected"' : '' @endphp
                            <option {{$active}} value="{{$item->id}}">{{$item->name_section}}</option>
                            @endforeach
                        </select>                        
                        <p class="help-block">Tình trạng active sẽ được hiển thị ở trang chủ.</p>
                    </div>   
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
   
</select>                        <p class="help-block">Vị trí sắp xếp của đầu số, số nhỏ đứng trước.

</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                    <a type="button" href="{{route('section.list',array($id_section))}}" class="btn btn-default">Quay lại</a>
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
                    <div class="form-group" style="display: none;">
                        <label><label for="alias">Đường dẫn</label></label>
                        <input type="text" id="alias" name="alias" value="{{old('alias')}}" class="form-control" placeholder="Đường dẫn thân thiện">                        <p class="help-block">Chỉ được sử dụng các từ a-z 0-9 dấu gạch ngang (-). Ví dụ: viettel. Nếu không nhập thì được tạo từ động từ tên của nhà mạng</p>
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
@endsection