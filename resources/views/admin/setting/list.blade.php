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
        <button class="btn bg-teal btn-lg waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#collapseWrap" aria-expanded="false"
                aria-controls="collapseWrap">
            THÊM MỚI
        </button>
        <input type="hidden" class="home_url_image" name="">
    <form class="form_validation collapse{{ (old('data')) ? ' in' : '' }}" enctype="multipart/form-data" id="collapseWrap" action="{{ route('setting.create') }}" method="post">
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
                       
                        <h2 class="card-inside-title text-uppercase">{{ $module_name }}</h2>
                        <div class="number_of_items m-t-20">
                            <div class="hub_items">
                                <div class="row clearfix hub_item">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name_setting" value="">
                                                <label class="form-label">Tên</label>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                         <div class="form-group form-float">
                                            <div class="form-line focused">
                                                <textarea rows="4" cols="50" id="value_setting" type="text" required  class="content" name="value_setting"></textarea>
                                                <label class="form-label">Mô tả</label>
                                            </div>
                                        </div>
                                    </div>
                                      <div class="col-md-12 col-sm-12 col-xs-12">
                                         <div class="form-group form-float js">
                                              <label class="form-label">Hình ảnh (jpg, png) (<span class="red">size không quá 1MB</span>)</label>
                                                   <div class="box">
                                                      <input type="file" value="" name="link" id="link" class="inputfile inputfile-1">
                                                      <label class="chonhinhanh" for="link">
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                                         </svg>
                                                         <span>Chọn hình ảnh …</span>
                                                      </label>
                                                   </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-teal btn-lg waves-effect">Thêm mới</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Input Group -->
    </form>
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
                                    <li><a href="javascript:void(0);" class="remove_selected waves-effect waves-block">Xóa các mục đã chọn</a></li>
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
                                    <th>Name</th>
                                    <th>Mô tả</th>
                                    <th>Ngày cập nhât</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Mô tả</th>
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
    @include('filters')
    <div class="modal fade" id="mdModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header relative">
                    <h4 class="modal-title center" id="defaultModalLabel">THÔNG TIN CHI TIẾT</h4>
                    <div class="approved"></div>
                </div>
                <div class="modal-body">
                   
                   <div class="info-settings"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">ĐÓNG</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('general.layouts.data-table-scripts')

    <style type="text/css">
        textarea#value_setting {
    margin-top: 14px;
    width: 100%;
}
        .form-group .form-line.focused .form-label {
                display: block;
                font-weight: bold;
                color: #000;
            }
    </style>

    <script src="{{ asset('/public/plugins/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('/public/plugins/light-gallery/js/lightgallery-all.js') }}"></script>
    <script src="{{ asset('/public/plugins/momentjs/moment.js') }}"></script>
    <script src="{{ asset('/public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <script type="text/javascript">
       
         var inputs = document.querySelectorAll( '.inputfile' );
       Array.prototype.forEach.call( inputs, function( input )
       {
           var label    = input.nextElementSibling,
               labelVal = label.innerHTML;
   
           input.addEventListener( 'change', function( e )
           {
               var fileName = '';
               if( this.files && this.files.length > 1 )
                   fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
               else
                   fileName = e.target.value.split( '\\' ).pop();
   
               if( fileName )
                   label.querySelector( 'span' ).innerHTML = fileName;
               else
                   label.innerHTML = labelVal;
           });
   
           // Firefox bug fix
           input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
           input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
       });
       var home_url_image = jQuery('.home_url_image').val();
        dataCenter.searchRoute = '{{ route('setting.search') }}';
        dataCenter.filterRoute = '{{ route('setting.list') }}';
        dataCenter.truncateRoute = '{{ route('setting.truncate') }}';
        dataCenter.columns = [
            null,
            {data: 'name_setting', name: 'name_setting'},
            {data: 'value_setting', name: 'value_setting'},
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
                    return '<input type="checkbox" class="_item_checked" id="_item_checked_'+ row['id'] +'" name="_item_checked[]" value="'+ row['id'] +'"><label for="_item_checked_'+ row['id'] +'"></label>';
                }
            },
            {
                targets: [2],
                searchable:  false,
                orderable:   false,
                className: '',
                render: function (data, type, row){
                    if(row['value_setting']!=''){
                        return row['value_setting'];
                    }else{
                        return '<img src="'+home_url_image+'/'+row['image']+'" style="width:100px">';
                    }
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
                        html += '<button type="button" class="btn bg-teal edit waves-effect view-settings info" date-id="'+ row['id'] +'" title="Sửa"><i class="material-icons">mode_edit</i></button>';
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
       
        $(function () {

            dataCenter.dataWrap = $('.data-wrap').html();

            var params = {
                route: '{{ route('setting.data') }}' + '?@php echo \App\myHelper::getFilters($filters); @endphp',
                columns: dataCenter.columns
            };
            dataCenter.paging(params);

        });


        $(document).ready(function(){

         

            $('.data-wrap').on('click', 'button.remove, button.info', function () {
                dataCenter.cRow = $(this).closest('tr');
                if($(this).hasClass('remove')) {
                    dataCenter.remove({
                        'url': '{{ route('setting.remove') }}',
                        'id': $(this).val(),
                        'parent': 'item'
                    });
                }
            });
           
              $(document).on('click','.view-settings',function(e) {

               var id = $(this).attr('date-id');
                  $.ajax({
                       url:'{{ route('setting.view_setting') }}',
                       method:"GET",
                       data:{id:id},
                        beforeSend: function() {
                           },
                           success:function(data){
                             $('#mdModal').modal({
                                show: 'false'
                            }); 
                            jQuery('.info-settings').html(data);
                           
                       }
                   });
               });
            // 
        });
    </script>
@endsection