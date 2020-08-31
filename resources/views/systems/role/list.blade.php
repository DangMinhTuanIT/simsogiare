@extends('home')

@section('title', $module_name)

@section('style')
    @parent
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('public/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/plugins/multi-select/css/multi-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @if(auth()->user()->can('Thêm ' . config('simsogiare.modules.' . $module)))
        <button class="btn bg-teal btn-lg waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#collapseWrap" aria-expanded="false"
                aria-controls="collapseWrap">
            THÊM MỚI
        </button>
        <form class="form_validation collapse{{ (old('data')) ? ' in' : '' }}" id="collapseWrap" action="{{ route('role.create') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- Input Group -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                THÊM MỚI <span class="text-uppercase">{{ $module_name }}</span>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="nouislider_quanity">
                                        <h2 class="card-inside-title">Số lượng <span class="text-lowercase">{{ $module_name }}</span></h2>
                                        <div id="nouislider_quanity"></div>
                                        <div class="m-t-20 font-12"><b>{{ $module_name }} </b><span class="js-nouislider-value"></span></div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="card-inside-title text-uppercase">{{ $module_name }}</h2>
                            <div class="number_of_items m-t-20">
                                <div class="hub_items">
                                    @if(old('data'))
                                        @foreach(old('data') as $item)
                                            <div class="row clearfix hub_item">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group form-float mar-bot0">
                                                        <div class="form-line">
                                                            <input type="text" class="form-control" name="data[{{ $loop->index }}][name]" value="{{ $item['name'] }}" required>
                                                            <label class="form-label">Tên*</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label class="form-label">Quyền hạn*</label>
                                                    <select id="optgroup" class="optgroup ms" name="data[{{ $loop->index }}][permissions][]" multiple="multiple" required>
                                                        @php \App\myHelper::getOptionGroups($permissions, $item) @endphp
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn bg-teal btn-lg waves-effect">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Input Group -->
        </form>
        <div class="hub_item_temp hub_temp">
            <div class="row clearfix hub_item">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group form-float mar-bot0">
                        <div class="form-line">
                            <input type="text" class="form-control" data-name="name" required>
                            <label class="form-label">Tên*</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label class="form-label">Quyền hạn*</label>
                    <select class="input_permissions ms" multiple="multiple" data-name="permissions" required>
                        @php \App\myHelper::getOptionGroups($permissions) @endphp
                    </select>
                </div>
            </div>
        </div>
    @endif

    @include('filters')
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
                                <th>Vai trò</th>
                                <th>Chức năng</th>
                                <th>Cập nhật bởi</th>
                                <th>Ngày cập nhật</th>
                                <th>Chức năng</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>Vai trò</th>
                                <th>Chức năng</th>
                                <th>Cập nhật bởi</th>
                                <th>Ngày cập nhật</th>
                                <th>Chức năng</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">THÔNG TIN CHI TIẾT</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" name="modal_name" class="form-control" id="modal_name" required>
                            <label class="form-label" for="modal_name">Tên*</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <label class="form-label">Quyền hạn*</label>
                        <select id="modal_permissions" name="modal_permissions[]" class="ms" multiple="multiple" required></select>
                        <div style="visibility: hidden;position: absolute;z-index: -100;" class="modal_permissions_all">
                            @php \App\myHelper::getOptionGroups($permissions) @endphp
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-teal waves-effect update-item">LƯU THAY ĐỔI</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">ĐÓNG</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('general.layouts.data-table-scripts')
    <script src="{{ asset('/public/plugins/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('/public/plugins/multi-select/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript">
        dataCenter.searchRoute = '{{ route('role.search') }}';
        dataCenter.filterRoute = '{{ route('role.list') }}';
        dataCenter.truncateRoute = '{{ route('role.truncate') }}';
        dataCenter.columns = [
            null,
            {data: 'name', name: 'name'},
            {data: 'permission_name', name: 'permission_name'},
            {data: 'editor_name', name: 'editor_name'},
            {data: 'updated_at', name: 'updated_at'},
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
                    if(row['is_system'] == 0)
                        return '<input type="checkbox" class="_item_checked" id="_item_checked_'+ row['id'] +'" name="_item_checked[]" value="'+ row['id'] +'"><label for="_item_checked_'+ row['id'] +'"></label>';
                    else
                        return '';
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
                    if(row['is_system'] == 1){
                        @if(auth()->user()->can('Sửa ' . config('simsogiare.modules.' . $module)))
                            return '<button type="button" class="btn bg-teal waves-effect info" value="'+ row['id'] +'" title="Sửa"><i class="material-icons">visibility</i></button>';
                        @endif
                    }else{
                        var html = '';
                        @if(auth()->user()->can('Sửa ' . config('simsogiare.modules.' . $module)))
                            html += '<button type="button" class="btn bg-teal waves-effect info" value="'+ row['id'] +'" title="Sửa"><i class="material-icons">mode_edit</i></button>';
                        @endif
                        @if(auth()->user()->can('Xóa ' . config('simsogiare.modules.' . $module)))
                            html += '<button type="button" class="btn bg-red waves-effect remove" value="'+ row['id'] +'" title="Xóa"><i class="material-icons">delete_forever</i></button>';
                        @endif
                            return html;
                    }


                }
            },
            {
                // puts a button in the last column
                targets: [2],
                searchable: false,
                orderable: false,
                render: function (data, type, row) {
                    return row['permission_name'].replace(new RegExp(row['name'], 'gi'), '');
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
        function getNoUISliderValue(slider, percentage) {
            slider.noUiSlider.on('update', function () {
                var val = slider.noUiSlider.get();
                if (percentage) {
                    val = parseInt(val);
                }
                $(slider).parent().find('span.js-nouislider-value').text(val);
                if(!checkFirst) {
                    var parent = $('.hub_item_temp');
                    var dist = $('.hub_items');
                    dist.html('');
                    for (var i = 0; i < val; i++) {
                        parent.find('[data-name]').each(function(){
                            var _name = $(this).data('name');
                            $(this).attr('name', 'data[' + i + ']['+ _name +']');
                            if('permissions' == _name) {
                                parent.find('.input_permissions').attr({
                                    'name': 'data[' + i + '][permissions][]',
                                    'id': 'optgroup' + i
                                });
                            }
                        });

                        dist.append(parent.html()).promise().done(function(){
                            dist.find('#optgroup' + i).addClass('optgroup');
                        });
                    }
                    $.AdminBSB.input.activate();
                    $('.optgroup').multiSelect({ selectableOptgroup: true }).promise().done(function(){
                        $('.ms-selectable .ms-list').before('<label class="ms-selectable-label">Có sẵn</label>');
                        $('.ms-selection .ms-list').before('<label class="ms-selection-label">Đã chọn</label>');
                    });

                }
            });
        }
        $(function () {

            dataCenter.dataWrap = $('.data-wrap').html();

            var params = {
                route: '{{ route('role.data') }}' + '?@php echo \App\myHelper::getFilters($filters); @endphp',
                columns: dataCenter.columns
            };
            dataCenter.paging(params);

            var rangeSlider = document.getElementById('nouislider_quanity');
            if(rangeSlider) {
                noUiSlider.create(rangeSlider, {
                    start: '{{ $start }}',
                    step: 1,
                    range: {
                        'min': 1,
                        'max': 5
                    }
                });
                getNoUISliderValue(rangeSlider, true);
            }
            checkFirst = 0;
        });
        $(document).ready(function(){

            var hub_select = $('.hub_items .ms');
            if(hub_select.length){
                hub_select.removeClass('ms');
                if ($.fn.selectpicker) {
                    $('.hub_items select').selectpicker();
                }
            }

            if ($.fn.selectpicker) {
                $('[name=dataList_length]').selectpicker();
            }

            $('.data-wrap').on('click', 'button.remove, button.info', function () {
                dataCenter.cRow = $(this).closest('tr');
                if($(this).hasClass('remove')) {
                    dataCenter.remove({
                        'url': '{{ route('role.remove') }}',
                        'id': $(this).val(),
                        'parent': 'item'
                    });
                }else{
                    dataCenter.info($(this), {
                        'url'      : '{{ route('role.info') }}',
                        'id'       : $(this).val(),
                        'parent'   : 'item'
                    }, function (data) {
                        if(data) {
                            var cItem = {
                                name: (data['name']) ? data['name'] : '',
                            };
                            $('[name=modal_name]').val(cItem.name);

                            $('#mdModal').data('id', data['id']);
                            if($('#ms-modal_permissions').length) {
                                $('#modal_permissions').multiSelect('destroy');
                                $('#ms-modal_permissions').remove();
                            }
                            $('#modal_permissions').html($('.modal_permissions_all').html()).promise().done(function(){
                                $('#modal_permissions').find('option').each(function(){
                                    var re = new RegExp( $(this).text(), "g" );
                                    if(re.test(data['permission_name'])){
                                        $(this).attr('selected', 'selected');
                                    }
                                });
                                $('#modal_permissions').multiSelect({ selectableOptgroup: true }).promise().done(function(){
                                    if(!$('#mdModal .ms-selectable-label').length) {
                                        $('#mdModal .ms-selectable .ms-list').before('<label class="ms-selectable-label">Có sẵn</label>');
                                        $('#mdModal .ms-selection .ms-list').before('<label class="ms-selection-label">Đã chọn</label>');
                                    }
                                });
                            });
                        }
                    });
                }
            });
            $('#mdModal').on('click', '.update-item', function () {

                var data = {};
                $('#mdModal [name*=modal_]').each(function(){
                    var _key = $(this).attr('name').replace('modal_', '').replace('[]', '');
                    data[_key] = $(this).val();
                });
                var params = {
                    'url'   : '{{ route('role.update') }}',
                    'id'    : $('#mdModal').data('id'),
                    'data'  : data
                };
                dataCenter.update($(this), params);

            });
        });
    </script>
@endsection