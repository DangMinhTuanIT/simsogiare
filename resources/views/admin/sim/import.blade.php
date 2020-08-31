@extends('home')
@section('title', $module_name)
@section('style')
@parent
@endsection
@section('content')
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="{{ route('sim.store') }}" method="post" role="form">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix">
    <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Thông tin cơ bản
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><label for="group">Số kho</label></label>
                        <input type="text" id="group" name="group" class="form-control" placeholder="Mặc định là kho 0">                        <p class="help-block">Số kho, dùng để sắp xếp ở trang chủ. Số lớn được ưu tiên xếp trước</p>
                    </div>
                    <div class="form-group">
                        <label><label for="prefix">Giá nhân thêm</label></label>
                        <input type="text" id="prefix" name="prefix" class="form-control" placeholder="">                        <p class="help-block">Dùng để sửa lại giá, ví dụ ở CSV ghi là 1200 nhưng thực tế là 120 000 thì hãy nhập giá nhân thêm là 100. Để trống để bỏ qua chức năng này</p>
                    </div>
                    <div class="form-group">
                        <label><label for="content">Danh sách số</label></label>
                        <textarea id="content" name="content" class="form-control" required="" placeholder="" rows="10">{{old('content')}}</textarea>                    </div>
                     <button type="submit" class="btn btn-primary">Nhập vào</button>
                    <a type="button" href="{{route('sim.list')}}" class="btn btn-default">Quay lại</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
       <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Định dạng của file CSV
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr><th>Số sim</th>
                            <th>Giá tiền</th>
                            <th>Số kho (Tùy chọn)</th>
                        </tr></thead>
                        <tbody>
                            <tr>
                                <td>0989.7373.48</td>
                                <td>120,000</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>0989.7373.47</td>
                                <td>1200.000</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>0989.7373.49</td>
                                <td>1 200 000</td>
                                <td>1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Cách tạo ra file CSV
                </div>
                <div class="panel-body">
                    <a target="_blank" href="http://youtu.be/NMbW4pNNOUQ">Video hướng dẫn xuất file Excel ra file CSV</a>
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