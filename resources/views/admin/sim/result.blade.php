@extends('home')
@section('title', $module_name)
@section('style')
@parent
@endsection
@section('content')
   <!-- Input Group -->
   <div class="row clearfix">
<div class="col-lg-12">
        <div id="nav-scroll-anchor"></div>
        <div class="panel panel-default" id="nav-scroll-container" style="position: relative;">
            <div class="panel-body clearfix">
                <div class="search-table pull-right">
                    <a class="btn btn-primary" href="{{route('sim.list')}}">
                        <i class="fa fa-plus-circle "></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <div class="alert alert-success">Đã nhập vào thành công {{$dem}} trên {{$dem}} tổng số SIM - tỷ lệ thành công 100 phần trăm</div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="col-lg-2">Dòng</th>
                        <th>Lỗi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
        <!-- /.panel -->
    </div>
                  </div>
   <!-- #END# Input Group -->
@include('filters')
@endsection
@section('script')
@include('general.layouts.data-table-scripts')
@endsection