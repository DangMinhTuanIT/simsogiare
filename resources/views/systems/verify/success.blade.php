@extends('auth.index')

@section('title', 'Xác nhận thông tin')

@section('content')
    <div class="align-center">
        <h3 class="col-teal m-b-0">Xác nhận thành công</h3>
        <a href="{{ route('home') }}" class="btn bg-teal waves-effect">Về trang chủ</a>
    </div>
@endsection