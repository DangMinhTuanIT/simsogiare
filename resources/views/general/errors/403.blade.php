@extends('auth.index')

@section('title', '403 - Không thể truy cập')

@section('content')
    <div class="card erro-page">
        <div class="body">
            <h1 style="font-size: 150px;">403</h1>
            <p>Không có quyền truy cập</p>
            <a href="javascript:history.go(-1);" class="btn bg-teal waves-effect">Trở lại trang trước</a>
        </div>
    </div>
@endsection
