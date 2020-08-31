@extends('home')

@section('title', $module_name)

@section('style')
    @parent
@endsection

@section('content')
<input type="hidden" name="" value="{{str_replace('/abc','',route('genre.edit',array('abc')))}}" class="page_edit">

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
                    <div class="filters">
                       <div class="row clearfix">
                          <div class="col-md-3 focused">
                             <p>
                                <b>Nhà mạng</b>
                             </p>
                             <select name="filters[id_category_network]" data-name="id_category_network" class="form-control show-tick">
                                <option value="">Mặc định</option>
                                @if(!empty($category_network))
                                @foreach($category_network as $item)
                                @php $active = @$_GET['id_category_network']==$item->id ? 'selected' : '' @endphp 
                                <option {{$active}} value="{{$item->id}}">{{$item->name_network}}</option>
                                @endforeach
                                @endif
                                </select>
                          </div>
                          <div class="col-md-3">
                             <p>
                                <b>Thể loại</b>
                             </p>
                             <select name="filters[id_genre]" data-name="id_genre" class="form-control show-tick">
                                <option value="">Mặc định</option>
                                 @if(!empty($genre))
                                @foreach($genre as $item)
                                @php $active = @$_GET['id_genre']==$item->id ? 'selected' : '' @endphp 
                                <option  {{$active}} value="{{$item->id}}">{{$item->name_genre}}</option>
                                @endforeach
                                @endif   
                             </select>
                          </div>
                          <div class="col-md-3">
                             <p>
                                <b>Năm sinh</b>
                             </p>
                             <select name="filters[id_sim_birth]" data-name="id_sim_birth" class="form-control show-tick">
                                <option value="">Mặc định</option>
                                 @if(!empty($birth))
                                @foreach($birth as $item)
                                @php $active = @$_GET['id_sim_birth']==$item->id ? 'selected' : '' @endphp 
                                <option {{$active}} value="{{$item->id}}">{{$item->name_birth}}</option>
                                @endforeach
                                @endif       
                             </select>
                          </div>
                          
                          <div class="col-md-3">
                              <div class="center filter-tip">
                                   <button class="btn bg-orange btn-lg waves-effect filter_results">Lọc kết quả</button>
                                   <a href="javascript:;" class="btn bg-blue-grey btn-lg waves-effect filter_remove">Xóa bộ lọc</a>
                                </div>
                          </div>
                       </div>
                    </div>
                    @include('search')
                    <div class="table-responsive data-wrap">
                        <table id="dataList" class="table table-bordered table-striped table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="all_items" value="-1" id="_check_all" class="_check_all filled-in"/>
                                        <label for="_check_all"></label>
                                    </th>
                                     <th>#</th>
                                    <th>Số SIM</th>
                                    <th>Giá bán</th>
                                    <th>Nhà mạng</th>
                                    <th>Thể loại</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                     <th>#</th>
                                    <th>Số SIM</th>
                                    <th>Giá bán</th>
                                    <th>Nhà mạng</th>
                                    <th>Thể loại</th>
                                    <th>Trạng thái</th>
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
    <script type="text/javascript">
        dataCenter.searchRoute = '{{ route('sim.search') }}';
        dataCenter.filterRoute = '{{ route('sim.list') }}';
        dataCenter.truncateRoute = '{{ route('sim.truncate') }}';
        var page_edit = jQuery('.page_edit').val();
        dataCenter.columns = [
            null,
            {data: 'id', name: 'id'},
            {data: 'number_sim_tring', name: 'number_sim_tring'},
            {data: 'price', name: 'price'},
            {data: 'name_network', name: 'name_network'},
            {data: 'name_genre', name: 'name_genre'},
            {data: 'status', name: 'status'},
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
         <?php $new_query_string = '' ;
        $params = $_GET;
        $new_query_string = http_build_query( $params );
             ?>
        $(function () {
            dataCenter.dataWrap = $('.data-wrap').html();
            var params = {
                route: '{{ route('sim.data') }}' + '?@php echo $new_query_string; @endphp',
                columns: dataCenter.columns
            };
            dataCenter.paging(params);
        });


        $(document).ready(function(){
            $('.data-wrap').on('click', 'button.remove, button.info', function () {
                dataCenter.cRow = $(this).closest('tr');
                if($(this).hasClass('remove')) {
                    dataCenter.remove({
                        'url': '{{ route('sim.remove') }}',
                        'id': $(this).val(),
                        'parent': 'item'
                    });
                }
            });
          
        });
    </script>
@endsection