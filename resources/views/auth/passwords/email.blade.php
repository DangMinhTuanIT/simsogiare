@extends('auth.index')

@section('content')
<form id="forgot_password" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="">
    <div class="msg">
        Nhập email bạn đã đăng ký. Chúng tôi sẽ gửi đường dẫn đặt lại mật khẩu qua email
    </div>
    <div class="input-group">
    <span class="input-group-addon">
        <i class="material-icons">email</i>
    </span>
        <div class="form-line">
            <input type="email" class="form-control" name="email" placeholder="Email" required="" autofocus="" aria-required="true">
        </div>
    </div>

    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">ĐẶT LẠI MẬT KHẨU</button>

    <div class="row m-t-20 m-b--5 align-center">
        <a href="{{ route('login') }}">Đăng nhập!</a>
    </div>
</form>
@endsection
