@extends('home')

@section('title', $module_name)

@section('style')
    @parent
    <link href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/dropzone/dropzone.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/light-gallery/css/lightgallery.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection

@section('content')

        <a class="btn bg-teal btn-lg waves-effect m-b-15" href="{{route('tags.add')}}">
            THÊM MỚI
        </a>
<input type="hidden" name="" value="{{URL::to('admin/tags/edit/')}}" class="page_edit">

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        DANH SÁCH <span class="text-uppercase">{{ $module_name }}</span>
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                               
                                    <li><a href="javascript:void(0);" class="remove_selected waves-effect waves-block">Xóa các mục đã chọn</a></li>
                                    <li><a href="javascript:void(0);" class="remove_all">Xóa tất cả</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    @include('search')
                    <div class="table-responsive data-wrap">
                        <table id="dataList" class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="all_items" value="-1" id="_check_all" class="_check_all filled-in"/>
                                        <label for="_check_all"></label>
                                    </th>
                                    <th>Mã</th>
                                    <th>Tên Tags</th>
                                    <th>Ngày cập nhât</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Mã</th>
                                    <th>Tên Tags</th>
                                    <th>Ngày cập nhât</th>
                                    <th>Chức năng</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('general.layouts.data-table-scripts')
    <script src="{{ asset('/public/plugins/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('/public/plugins/light-gallery/js/lightgallery-all.js') }}"></script>
    <script src="{{ asset('/public/plugins/momentjs/moment.js') }}"></script>
    <script src="{{ asset('/public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <script type="text/javascript">
        dataCenter.searchRoute = '{{ route('tags.search') }}';
        dataCenter.filterRoute = '{{ route('tags.list') }}';
        dataCenter.truncateRoute = '{{ route('tags.truncate') }}';
        var page_edit = jQuery('.page_edit').val();
        dataCenter.columns = [
            null,
             {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'updated_at', name: 'updated_at'},
            null
        ];
        var home_url = '{{URL::to('/')}}';
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
                width: '40px',
                targets: [1],
                searchable:  false,
                orderable:   false,
                className: '',
                render: function (data, type, row){
                    return  row['id'];
                }
            },
             {
                targets: [2],
                searchable:  false,
                orderable:   false,
                className: '',
                render: function (data, type, row){
                    return '<a target="_blank" href="'+home_url+'/tag/'+ row['slug'] +'.html">'+row['title']+'</a>';
                }
            },
            {
                // puts a button in the last column
                width: '90px',
                targets: [-1],
                searchable: false,
                orderable: false,
                className: "cell-center",
                render: function (data, type, row) {
                    var html = '';
                        html += '<a class="btn bg-teal waves-effect edit info" href="'+page_edit+'/'+row['id'] +'" title="Sửa"><i class="material-icons">mode_edit</i></a>';
                        html += '<button type="button" class="btn bg-red waves-effect remove" value="'+ row['id'] +'" title="Xóa"><i class="material-icons">delete_forever</i></button>';
                    return html;
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
        var checkFirst = '{{ $old }}';
        //Get noUISlider Value and write on

        $(function () {

            dataCenter.dataWrap = $('.data-wrap').html();

            var params = {
                route: '{{ route('tags.data') }}' + '?@php echo \App\myHelper::getFilters($filters); @endphp',
                columns: dataCenter.columns
            };
            dataCenter.paging(params);
        });


        $(document).ready(function(){
            $('.data-wrap').on('click', 'button.remove, button.info', function () {
                dataCenter.cRow = $(this).closest('tr');
                if($(this).hasClass('remove')) {
                    dataCenter.remove({
                        'url': '{{ route('tags.remove') }}',
                        'id': $(this).val(),
                        'parent': 'item'
                    });
                }
            });
          
        });
    </script>
@endsection