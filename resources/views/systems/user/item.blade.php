@extends('home')

@section('title', $module_name)

@section('style')
    @parent
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <form class="form_validation" id="collapseWrap" action="{{ route('profile.update') }}" method="post" class="user-item">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ $module_name }}
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix hub_item">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group form-float mar-bot0">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="data[name]" value="{{ $item->name }}" required>
                                        <label class="form-label">Tên*</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group form-float mar-bot0">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="data[email]" value="{{ $item->email }}" readonly>
                                        <label class="form-label">Email*</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group form-float mar-bot0">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="data[phone]" value="{{ $item->phone }}" required>
                                        <label class="form-label">Điện thoại</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group form-float mar-bot0">
                                    <div class="form-line">
                                        <input type="password" class="form-control" name="data[password]" value="">
                                        <label class="form-label">Mật khẩu(bỏ trống nếu không muốn thay đổi)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group form-float mar-bot0">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="data[address]" value="{{ $item->address }}" >
                                        <label class="form-label">Địa chỉ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-teal btn-lg waves-effect">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    @include('general.layouts.data-table-scripts')
    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>
@endsection