@extends('auth.index')

@section('title', 'Đăng nhập')

@section('content')
    <style>
        #sign_in .fb_login{
            background: #4267b2;
            padding: 20px 30px;
            display: inline-block;
            margin-bottom: 25px;
            border-radius: 50px;
            width: 100%;
            text-align: center;
            font-size: 20px;
            color: #fff;
        }
        @media screen and (max-width: 767px){
            .login-box {
                width: 330px;
            }
            .login-page .login-box .logo a {
                font-size: 22px;
                margin-top: 30px;
            }
            .login-page .card .body{
                padding: 20px 7px;
            }
            #sign_in .input-group-addon {
                padding: 6px 5px;
            }
            .form-line .form-control{
                padding-left: 10px !important;
            }
            #sign_in .fb_login {
                padding: 10px 10px;
                font-size: 13px;
            }
            .login-page .login-box .msg {
                font-size: 12px;
                margin-bottom: 10px;
            }
            .login-submit{
                margin: 0;
            }
            .login-submit .col-xs-8{
               padding-left: 0;
                padding-right: 0px;
                width: 55%;
            }
            .login-submit  .col-xs-4{
                width: 45%;
                padding-right: 0px;
                padding-left: 10px;
            }

        }
         @media screen and (max-width: 320px){
            .login-box {
                width: 260px;
            }
        }
    </style>
    <form id="sign_in" method="POST" action="{{ route('account.login') }}">
        @if( ! empty($err))
            <div class="alert alert-danger">
                {{ $err }}
            </div>
        @endif
        {{ csrf_field() }}
        <br>
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
        <div class="row login-submit">
            <div class="col-xs-8 p-t-5" >
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="filled-in chk-col-pink">
                <label for="remember" style="display: none;">Ghi nhớ đăng nhập</label>
            </div>
            <div class="col-xs-4">
                <button class="btn btn-block bg-pink waves-effect" type="submit">ĐĂNG NHẬP</button>
            </div>
        </div>
        <div class="row m-t-15 m-b--20" style="display:none">
            <div class="col-xs-6">
                <a class="btn btn-link" href="#">
                    Đăng ký
                </a>
            </div>
            <div class="col-xs-6 align-right">
                <a class="btn btn-link" href="#">
                    Quên mật khẩu?
                </a>
            </div>
        </div>
    </form>
@endsection
