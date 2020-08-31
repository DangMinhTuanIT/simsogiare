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
            aria-controls="collapseWrap" >
        THÊM MỚI
    </button>
    <form class="form_validation collapse{{ (old('data')) ? ' in' : '' }}" id="collapseWrap" action="{{ route('user.create') }}" method="post">
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
                                    <div class="m-t-20 font-12"><b>{{ $module_name }}: </b><span class="js-nouislider-value"></span></div>
                                </div>
                            </div>
                        </div>
                        <h2 class="card-inside-title text-uppercase">{{ $module_name }}</h2>
                        <div class="number_of_items m-t-20">
                            <div class="hub_items">
                                @if(old('data'))
                                    @foreach(old('data') as $item)
                                        <div class="row clearfix hub_item">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                @php \App\myHelper::getSelect([
                                                    'name'  => 'data['. $loop->index .'][type]',
                                                    'label' => 'Loại người dùng',
                                                    'value' => $item['type'],
                                                    'items' => config('simsogiare.user_type'),
                                                ]); @endphp
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group form-float mar-bot0">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="data[{{ $loop->index }}][provider_id]" value="{{ $item['provider_id'] }}" required>
                                                        <label class="form-label">provider_id*</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group form-float mar-bot0">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="data[{{ $loop->index }}][name]" value="{{ $item['name'] }}" required>
                                                        <label class="form-label">Tên*</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group form-float mar-bot0">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="data[{{ $loop->index }}][email]" value="{{ $item['email'] }}" required>
                                                        <label class="form-label">Email*</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" name="data[{{ $loop->index }}][password]" value="{{ $item['password'] }}" required>
                                                        <label class="form-label">Mật khẩu*</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" name="data[{{ $loop->index }}][password_confirmation]" value="{{ $item['password_confirmation'] }}" required>
                                                        <label class="form-label">Xác nhận mật khẩu*</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-md-12 col-xs-12">
                                                <label class="form-label">Vai trò</label>
                                                <select id="optgroup" class="optgroup ms" name="data[{{ $loop->index }}][roles][]" multiple="multiple">
                                                    @if($roles)
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->name }}" @php echo in_array($role->name, $item['roles']) ? 'selected' : ''; @endphp>{{ $role->name }}</option>
                                                        @endforeach
                                                    @endif
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
            <div class="col-md-6 col-sm-6 col-xs-12">
                @php \App\myHelper::getSelect([
                    'name'  => 'type',
                    'label' => 'Loại người dùng',
                    'value' => '',
                    'items' => config('simsogiare.user_type'),
                    'is_temp'   => 1
                ]); @endphp
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group form-float mar-bot0">
                    <div class="form-line">
                        <input type="text" class="form-control" data-name="provider_id" required>
                        <label class="form-label">provider_id*</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group form-float mar-bot0">
                    <div class="form-line">
                        <input type="text" class="form-control" data-name="name" required>
                        <label class="form-label">Tên*</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group form-float mar-bot0">
                    <div class="form-line">
                        <input type="email" class="form-control" data-name="email" required>
                        <label class="form-label">Email*</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" class="form-control" data-name="password" required>
                        <label class="form-label">Mật khẩu*</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="password" class="form-control" data-name="password_confirmation" required>
                        <label class="form-label">Xác nhận mật khẩu*</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-md-12 col-xs-12">
                <label class="form-label">Vai trò</label>
                <select class="ms" data-name="roles" multiple="multiple">
                    @if($roles)
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    @endif
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
                                <li><a href="javascript:void(0);" class="remove_all">Xóa tất cả</a></li>
                                @endif
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
                                    <th>Tên</th>
                                    <th>Loại người dùng</th>
                                    <th>Cập nhật bởi</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tình trạng</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Tên</th>
                                    <th>Loại người dùng</th>
                                    <th>Cập nhật bởi</th>
                                    <th>Ngày cập nhật</th>
                                    <th>Tình trạng</th>
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
    <div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">THÔNG TIN CHI TIẾT</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-float">
                        <label>Trạng thái</label>
                        <select class="form-control show-tick ms" name="modal_status" data-title="Trạng thái" data-live-search="true">
                            @foreach (config('simsogiare.status') as $k=>$status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" name="modal_provider_id" class="form-control" id="modal_provider_id" required>
                            <label class="form-label" for="modal_provider_id">Facebbok ID*</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" name="modal_name" class="form-control" id="modal_name" required>
                            <label class="form-label" for="modal_name">Tên*</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="email" name="modal_email" class="form-control" id="modal_email" required>
                            <label class="form-label" for="modal_email">Email</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" id="modal_phone" name="modal_phone" class="form-control">
                            <label class="form-label" for="modal_phone">Điện thoại</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line focused">
                            <input type="text" id="modal_address" name="modal_address" class="form-control">
                            <label class="form-label" for="modal_address">Địa chỉ</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" id="modal_password" name="modal_password" class="form-control">
                            <label class="form-label" for="modal_password">Thay đổi mật khẩu(bỏ trống nếu không thay đổi)</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <label class="form-label">Vai trò</label>
                        <select id="modal_roles" name="modal_roles[]" class="ms" multiple="multiple"></select>
                        <div style="visibility: hidden;position: absolute;z-index: -100;" class="modal_roles_all">
                            @if($roles)
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            @endif
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
        dataCenter.searchRoute = '{{ route('user.search') }}';
        dataCenter.filterRoute = '{{ route('user.list') }}';
        dataCenter.truncateRoute = '{{ route('user.truncate') }}';
        dataCenter.columns = [
            null,
            {data: 'name', name: 'name'},
            {data: 'type', name: 'type'},
            {data: 'editor_name', name: 'editor_name'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'status', name: 'status'},
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
                width: '90px',
                targets: [-1],
                searchable: false,
                orderable: false,
                className: "cell-center",
                render: function (data, type, row) {
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
                            if('roles' == _name){
                                $(this).attr('id', 'optgroup_' + i);
                                $(this).attr('name', 'data[' + i + ']['+ _name +'][]');
                            }
                        });

                        dist.append(parent.html()).promise().done(function(){
                            dist.find('#optgroup_' + i).addClass('optgroup');
                        });
                        
                    }
                    $.AdminBSB.input.activate();
                    if($('.optgroup').length) {
                        $('.optgroup').multiSelect({selectableOptgroup: true}).promise().done(function () {
                            $('.ms-selectable .ms-list').before('<label class="ms-selectable-label">Có sẵn</label>');
                            $('.ms-selection .ms-list').before('<label class="ms-selection-label">Đã chọn</label>');
                        });
                    }
                }
            });
        }
        $(function () {

            dataCenter.dataWrap = $('.data-wrap').html();

            var params = {
                route: '{{ route('user.data') }}' + '?@php echo \App\myHelper::getFilters($filters); @endphp',
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
                    $('.hub_items [name*=type]').selectpicker();
                }
            }

            if ($.fn.selectpicker) {
                $('[name=dataList_length]').selectpicker();
            }

            $('.data-wrap').on('click', 'button.remove, button.info', function () {
                dataCenter.cRow = $(this).closest('tr');
                if($(this).hasClass('remove')) {
                    dataCenter.remove({
                        'url': '{{ route('user.remove') }}',
                        'id': $(this).val(),
                        'parent': 'item'
                    });
                }else{
                    dataCenter.info($(this), {
                        'url'      : '{{ route('user.info') }}',
                        'id'       : $(this).val(),
                        'parent'   : 'item'
                    }, function (data) {
                        if(data) {

                            for(var x in data){
                                var item = $('[name=modal_'+ x +']');
                                if(item.length){
                                    item.val(data[x]);
                                }
                            }

                            $('[name=modal_password]').val('');

                            $('#mdModal').data('id', data['id']);

                            if($('#ms-modal_roles').length) {
                                $('#modal_roles').multiSelect('destroy');
                                $('#ms-modal_roles').remove();
                            }
                            $('#modal_roles').html($('.modal_roles_all').html()).promise().done(function(){
                                $('#modal_roles').find('option').each(function(){
                                    var re = new RegExp( $(this).text(), "g" );
                                    if(re.test(data['role_name'])){
                                        $(this).attr('selected', 'selected');
                                    }
                                });
                                $('#modal_roles').multiSelect({ selectableOptgroup: true }).promise().done(function(){
                                    if(!$('#mdModal .ms-selectable-label').length) {
                                        $('#mdModal .ms-selectable .ms-list').before('<label class="ms-selectable-label">Có sẵn</label>');
                                        $('#mdModal .ms-selection .ms-list').before('<label class="ms-selection-label">Đã chọn</label>');
                                    }
                                });
                            });

                            if ($.fn.selectpicker) {
                                var ms = $('#mdModal').find('.ms');
                                if (ms.length) {
                                    ms.removeClass('ms');
                                    $('#mdModal select[name=modal_status]').selectpicker();
                                    $('#mdModal select[name=modal_type]').selectpicker();
                                }

                                setTimeout(function(){
                                    $('[name=modal_status]').val(data['status']);
                                    $('[name=modal_type]').val(data['type']);
                                    $('#mdModal select[name=modal_status]').selectpicker('refresh');
                                    // $('#mdModal select[name=modal_type]').selectpicker('refresh');
                                });
                            }
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
                    'url'   : '{{ route('user.update') }}',
                    'id'    : $('#mdModal').data('id'),
                    'data'  : data
                };
                dataCenter.update($(this), params);

            });
        });
    </script>
@endsection