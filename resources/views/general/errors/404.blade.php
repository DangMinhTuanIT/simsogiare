@extends('auth.index')

@section('title', '404 - Không tìm thấy')

@section('content')
    <div class="card erro-page">
        <div class="body">
            <h1 style="font-size: 150px;">404</h1>
            <p>Không tìm thấy</p>
            <a href="javascript:history.go(-1);" class="btn bg-teal waves-effect">Trở lại trang trước</a>
        </div>
    </div>
@endsection
