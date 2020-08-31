@extends('auth.index')

@section('title', 'Đăng ký thành công')

@section('style')
    <style>
        .login-box{width: 500px;}
        #sign_up button{width: 150px;}
    </style>
@endsection

@section('content')
    <div class="card erro-page">
        <div class="body">
            <h1>ĐĂNG KÝ THÀNH CÔNG</h1>
            <p>{{ $content }}</p>
            <a href="{{ env('APP_URL') }}" class="btn btn-lg bg-teal waves-effect">Về trang chủ</a>
        </div>
    </div>
@endsection
