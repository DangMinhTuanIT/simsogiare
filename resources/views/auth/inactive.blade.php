@extends('auth.index')

@section('title', 'ĐĂNG NHẬP')

@section('content')
    <div class="text-center">
        <h3>Không thể truy cập</h3>
        <p class="col-red">Tài khoản của bạn hiện tại chưa đươc kích hoạt. Vui lòng liên hệ với quản trị để được hỗ trợ</p>
        <a href="javascript:history.go(-1);" class="btn bg-teal waves-effect">Trở lại trang trước</a>
    </div>
@endsection
