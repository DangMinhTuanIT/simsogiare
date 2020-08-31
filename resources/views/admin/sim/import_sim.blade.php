@extends('home')
@section('title', $module_name)
@section('style')
@parent
@endsection
@section('content')
<!-- <form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="{{ route('sim.import_sim_post') }}" method="post" role="form"> -->
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
                        <textarea id="content" name="content" class="form-control" required="" placeholder="" rows="10">{{old('content')}}</textarea>                    

                    </div>
                    <div class="form-group">
                <label>Kiểu giá: </label>
                <label><input type="radio" name="tygia" value="1" checked=""> 1.000.000 = 1tr</label>
                <label><input type="radio" name="tygia" value="1000"> 1.000 = 1tr</label>
                <label><input type="radio" name="tygia" value="1000000"> 1 = 1tr</label>
            </div>
            <div class="form-group">
                <label for="datasim">Kiểu bảng số</label>
                <select class="form-control" id="kieubs">
                    <option value="2">2 cột (Số + giá)</option>
                    <option value="4">4 cột (Số + giá + mạng + loại)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kiểu đăng:</label>
                <label><input type="radio" name="kieu" value="0" checked=""> Đăng mới</label>
                <label><input type="radio" name="kieu" value="1"> Đăng thêm</label>
            </div>
                     <button type="submit"  id="DangSim" onclick="DangSim()" class="btn btn-primary">Nhập vào</button>
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
<!-- </form> -->
@include('filters')
@endsection
@section('script')
<script>
    
    function DangSim() {
        let datasim = $("#content").val();
        if(!content){
            alert('Chưa nhập dữ liệu');
        }
        let tygia = $('input[name="tygia"]:checked').val();
        let kieubs = $("#kieubs").val();
        let pData = "";
        // Phân tích data sim
        let data1 = datasim.split("\n");
        if(data1.length > 0) {
            openLoading();
            let demdong = 0;
            for (let i = 0; i < data1.length; i++) {
                let data2 = $.trim(data1[i]);
                let data3 = data2.split("\t");
                if(data3.length === 2) {
                    let soSimW = fixDBW(data3[0]);
                    let gia = fixDB(data3[1]);

                    gia = gia * tygia;
                    pData += soSimW  + "|" + gia + "-";
                } else if(data3.length === 4) {
                    let soSimW = fixDBW(data3[0]);
                    let gia = fixDB(data3[1]);
                    let mang = $.trim(data3[2].toLowerCase());
                    let loai = $.trim(data3[3]);

                    gia = gia * tygia;
                    pData += soSimW + "|" + mang + "|" + gia + "|" + loai + "-";
                }
                demdong += 1;
                if(demdong === 300000) {
                    alert("Hệ thống chỉ cho phép đăng tối đa 300K sim 1 lần!")
                    break;
                }
            }
             $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
           });
               $.ajax({
              url:'{{route('sim.import_sim_post')}}',
              method:"POST",
              data:{
                pData:pData,
              },
               beforeSend: function() {
                       // this_history.html('<i class="loading-icon fa fa-spin fa-spinner" style="display: table;margin: 0 auto;    font-size: 35px;"></i>');
                  },
                  success:function(data){
              }
            });
            }
    }
   
    function fixDB(data) {
        data = data.replace(/[^0-9]/g, '');
        return data;
    }

    function fixDBW(data) {
        data = data.replace(/[^0-9.]/g, '');
        return data;
    }
    function openLoading (){

    }
    function closeLoading (){

    }
</script>
@include('general.layouts.data-table-scripts')
@endsection