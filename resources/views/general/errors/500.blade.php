@extends('auth.index')

@section('title', '500 - Dịch vụ hiện tại không có sẵn')

@section('content')
    <div class="card erro-page">
        <div class="body">
            <h1 style="font-size: 150px;">500</h1>
            <p>Dịch vụ hiện tại không có sẵn</p>
            <a href="javascript:history.go(-1);" class="btn bg-teal waves-effect">Trở lại trang trước</a>
        </div>
    </div>
@endsection
