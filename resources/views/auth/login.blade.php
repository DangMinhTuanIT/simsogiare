@extends('auth.index')

@section('title', 'Đăng nhập')

@section('content')
<form id="sign_in" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <div class="msg">Đăng nhập để bắt đầu</div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">person</i>
        </span>
        <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
            <input type="text" class="form-control" name="email" placeholder="Email" required autofocus>
        </div>
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">lock</i>
        </span>
        <div class="form-line">
            <input id="password" type="password" class="form-control" placeholder="Mật khẩu" name="password" required>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 p-t-5">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-pink">
            <label for="remember">Ghi nhớ đăng nhập</label>
        </div>
        <div class="col-xs-4">
            <button class="btn btn-block bg-pink waves-effect" type="submit">ĐĂNG NHẬP</button>
        </div>
    </div>
    <div class="row m-t-15 m-b--20" style="display:none">
        <div class="col-xs-6">
            <a class="btn btn-link" href="{{ route('register') }}">
                Đăng ký thành viên
            </a>
        </div>
        <div class="col-xs-6 align-right">
            <a class="btn btn-link" href="{{ route('password.request') }}">
                Quên mật khẩu?
            </a>
        </div>
    </div>
</form>
@endsection
