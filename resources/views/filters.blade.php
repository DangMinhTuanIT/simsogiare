@if($filters)
    <style>
        .filters{
            margin: 15px 0;
            padding-bottom: 15px;
        }
    </style>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    LỌC KẾT QUẢ
                </h2>
            </div>
            <div class="body">
                <div class="filters">
                    <div class="row clearfix">
                        @foreach($filters as $k=>$item)
                            <div class="col-md-3">
                                <p>
                                    <b>{{ $item['name'] }}</b>
                                </p>
                                <select name="filters[{{ $k }}]" data-name="{{ $k }}" class="form-control show-tick">
                                    <option value="">Mặc định</option>
                                    @foreach($item['options'] as $o=>$option)
                                        @php
                                            if(is_object($option))
                                                $option = (array) $option;
                                            if(isset($option['value'])){
                                                $val = $option['value'];
                                            }elseif(isset($option['id'])){
                                                $val = $option['id'];
                                            }else{
                                                $val = $o;
                                            }
                                            if(isset($option['name'])){
                                                $name = $option['name'];
                                            }else{
                                                $name = $option;
                                            }
                                        @endphp
                                        <option value="{{ $val }}" {{ ($item['default'] != '' && $item['default'] == $val) ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="center">
                    <button class="btn bg-orange btn-lg waves-effect filter_results">Lọc kết quả</button>
                    <a href="javascript:;" class="btn bg-blue-grey btn-lg waves-effect filter_remove">Xóa bộ lọc</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif