@extends('auth.index')

@section('content')
<form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">
    <div class="msg">
        Đặt lại mật khẩu
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">email</i>
        </span>
        <div class="form-line {{ $errors->has('email') ? 'error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="input-group">
    <span class="input-group-addon">
        <i class="material-icons">lock</i>
    </span>
        <div class="form-line {{ $errors->has('password') ? 'error' : '' }}">
            <input type="password" class="form-control" name="password" minlength="6" placeholder="Mật khẩu" required="" aria-required="true">
            @if ($errors->has('password'))
                <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="input-group">
    <span class="input-group-addon">
        <i class="material-icons">lock</i>
    </span>
        <div class="form-line">
            <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Xác nhận mật khẩu" required="" aria-required="true">
        </div>
    </div>

    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">CẬP NHẬT</button>

</form>
@endsection
