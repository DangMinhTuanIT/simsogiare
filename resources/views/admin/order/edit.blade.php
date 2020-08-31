@extends('home')
@section('title', $module_name)
@section('style')
@parent

@endsection
@section('content')
<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in" enctype="multipart/form-data"  id="formDemo" action="{{route('orders.update_db',array($info->id))}}" method="post" role="form">
  <input type="hidden" name="_method" value="PUT">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <!-- Input Group -->
   <div class="row clearfix"> 
    <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Thông tin khách hàng
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><label for="key">Tên khách hàng</label></label>
                        <input type="text" value="{{$info->name_customer}}" class="form-control" disabled="">
                    </div>
                    <div class="form-group">
                        <label><label for="key">Số điện thoại</label></label>
                        <input type="text" value="{{$info->phone_customer}}" class="form-control" disabled="">
                    </div>
                    <div class="form-group">
                        <label><label for="key">Địa chỉ</label></label>
                        <input type="text" value="{{$info->address_customer}}" class="form-control" disabled="">
                    </div>
                    <div class="form-group">
                        <label><label for="key">Email</label></label>
                        <input type="text" value="{{$info->email_customer}}" class="form-control" disabled="">
                    </div>
                    <div class="form-group">
                        <label><label for="status">Tình trang đơn hàng</label></label>
                        <select id="status" name="status" class="form-control">
                          @foreach(config('simsogiare.status_order') as $key => $item)
                          @php $active = $key==$info->status ? ' selected="selected"' : '' @endphp 
                          <option value="{{$key}}">{{$item}}</option>
                          @endforeach
                        </select>                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a type="button" href="{{route('orders.list')}}" data-target="ignore" class="btn btn-default">Quay lại</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Thông tin đặt hàng
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label><label for="key">Thời gian đặt</label></label>
                        <input type="text" value="{{App\myHelper::convert_time_order($info->created_at)}}" class="form-control" disabled="">
                    </div>
                    <div class="form-group">
                        <label><label for="key">Số đã đặt</label></label>
                        <input type="text" value="{{$info->phone_sim}}" class="form-control" disabled="">
                    </div>
                    <div class="form-group">
                        <label><label for="key">Giá tiền</label></label>
                        <input type="text" value="{{$info->price}}" class="form-control" disabled="">
                    </div>
                    <div class="form-group">
                        <label><label for="key">Tin nhắn</label></label>
                        <textarea class="form-control" disabled="">{{$info->note_customer}}</textarea>
                    </div>
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

@endsection