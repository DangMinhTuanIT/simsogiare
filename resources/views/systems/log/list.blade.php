@extends('home')

@section('title', $module_name)

@section('style')
    @parent
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        HOẠT ĐỘNG GẦN ĐÂY
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                @if(auth()->user()->can('Xóa tất cả ' . config('simsogiare.modules.' . $module)))
                                    <li><a href="javascript:void(0);" class="remove_selected">Xóa các mục đã chọn</a></li>
                                    <li><a href="javascript:void(0);" class="remove_all">Xóa tất cả</a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive data-wrap">
                        <table id="dataList" class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="all_items" value="-1" id="_check_all" class="_check_all filled-in"/>
                                        <label for="_check_all"></label>
                                    </th>
                                    <th>Hành động</th>
                                    <th>Mô tả</th>
                                    <th>Module</th>
                                    <th>Ngày tạo</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Hành động</th>
                                    <th>Mô tả</th>
                                    <th>Module</th>
                                    <th>Ngày tạo</th>
                                    <th>Chức năng</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('filters')
@endsection

@section('script')
    @include('general.layouts.data-table-scripts')
    <script type="text/javascript">
        dataCenter.searchRoute = '{{ route('log.search') }}';
        dataCenter.filterRoute = '{{ route('log.list') }}';
        dataCenter.truncateRoute = '{{ route('log.truncate') }}';
        dataCenter.columns = [
            null,
            {data: 'name', name: 'name'},
            {data: 'message', name: 'message'},
            {data: 'module', name: 'module'},
            {data: 'created_at', name: 'created_at'},
            null
        ];
        dataCenter.tableConfigs.columnDefs = [
            {
                width: '10px',
                targets: [0],
                searchable:  false,
                orderable:   false,
                className: 'item-checkbox dt-body-center',
                render: function (data, type, row){
                    return '<input type="checkbox" class="_item_checked" id="_item_checked_'+ row['id'] +'" name="_item_checked[]" value="'+ row['id'] +'"><label for="_item_checked_'+ row['id'] +'"></label>';
                }
            },
            {
                // puts a button in the last column
                width: '50px',
                targets: [-1],
                searchable: false,
                orderable: false,
                className: "cell-center",
                render: function (data, type, row) {
                    @if(auth()->user()->can('Xóa ' . config('simsogiare.modules.' . $module)))
                        return '<button type="button" class="btn bg-red waves-effect remove" value="'+ row['id'] +'" title="Xóa"><i class="material-icons">delete_forever</i></button>';
                    @else
                        return '';
                    @endif
                }
            }
        ];
        @php
            if(old('data')){
                $start = count(old('data'));
                $old = 1;
            }else{
                $start = 1;
                $old = '';
            }
        @endphp

        $(function () {

            dataCenter.dataWrap = $('.data-wrap').html();

            var params = {
                route: '{{ route('log.data') }}' + '?@php echo \App\myHelper::getFilters($filters); @endphp',
                columns: dataCenter.columns
            };
            dataCenter.paging(params);
        });

        $(document).ready(function(){

            if ($.fn.selectpicker) {
                $('[name=dataList_length]').selectpicker();
            }

            $('.data-wrap').on('click', 'button.remove', function () {
                dataCenter.cRow = $(this).closest('tr');
                dataCenter.remove({
                    'url': '{{ route('log.remove') }}',
                    'id': $(this).val(),
                    'parent': 'item'
                });
            });
        });
    </script>
@endsection