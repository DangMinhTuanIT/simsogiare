@extends('auth.index')

@section('title', 'Xác nhận thông tin')

@section('content')
    @if ($errors->any())
        <div class="align-center">
            @foreach ($errors->all() as $error)
                <p class="col-pink">{{ $error }}</p>
            @endforeach
            <p><small>*) Nếu mã kích hoạt hết hạn, bạn hãy đăng nhập vào hệ thống và gửi yêu cầu tạo lại mã kích hoạt</small></p>
        </div>
    @endif
@endsection