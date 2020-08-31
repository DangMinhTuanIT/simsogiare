@extends('home')

@section('title', $module_name)

@section('style')
    @parent

@endsection

@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        <span class="text-uppercase">{{ $module_name }}</span>
                        <small>Có thể sử dụng các shortcode trong phần nội dung với định dạng <code>$field_name$</code> ví dụ: <code>$name$</code>, <code>$url$</code>, ...</small>
                    </h2>
                </div>
                <div class="body">
                    <form class="form_validation" id="collapseWrap" action="{{ route('options.update') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="panel-group" id="tks_accordion" role="tablist" aria-multiselectable="true">
							@foreach($results as $i=>$item)
								@php $k = isset($k) ? $k : 0; @endphp
								@if($k != $item->group)
									@php $k = $item->group; @endphp
							<div class="panel panel-default">	
								<div class="panel-heading" role="tab" id="headingOne_{{ $item->group }}">
									<h4 class="panel-title">
										<a class="collapsed" role="button" data-toggle="collapse" data-parent="#tks_accordion" href="#collapseOne_{{ $item->group }}" aria-expanded="false"aria-controls="collapseOne_{{ $item->group }}">
											@if($item->group == 1)
												CÀI ĐẶT CHUNG
											@elseif($item->group == 3)
												NỘI DUNG EMAIL
											@elseif($item->group == 4)
												CẤU HÌNH SMS
											@elseif($item->group == 2)
												EMAIL SERVER
											@else
												KHÁC
											@endif
										</a>
									</h4>
								</div>
								<div id="collapseOne_{{ $item->group }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_{{ $item->group }}">
									<div class="panel-body">
								@endif
										@if($item->type == 'textarea')
											<h2 class="card-inside-title">{{ $item->name }}</h2>
											<div class="row clearfix">
												<div class="col-sm-12">
													<div class="form-group">
														<div class="form-line">
															<textarea id="tinymce_{{$item->id}}" name="data[{{ $item->o_key }}]">{{ $item->o_value }}</textarea>
														</div>
													</div>
												</div>
											</div>
										@elseif($item->type == 'checkbox')
											<div class="row clearfix">
												<div class="col-sm-12">
													<div class="form-group">
														<input type="checkbox" id="{{ $item->o_key }}_{{ $item->id }}" class="filled-in" {{ $item->o_value ? 'checked' : '' }} />
														<label for="{{ $item->o_key }}_{{ $item->id }}">{{ $item->name }}</label>
													</div>
												</div>
											</div>
										@elseif($item->type == 'password')
											<h2 class="card-inside-title m-b-0">{{ $item->name }}</h2>
											<div class="row clearfix">
												<div class="col-sm-12">
													<div class="form-group m-b-0">
														<div class="form-line">
															<input type="password" class="form-control" name="data[{{ $item->o_key }}]">
														</div>
													</div>
												</div>
											</div>
										@else
											<h2 class="card-inside-title m-b-0">{{ $item->name }}</h2>
											<div class="row clearfix">
												<div class="col-sm-12">
													<div class="form-group m-b-0">
														<div class="form-line">
															<input class="form-control" name="data[{{ $item->o_key }}]" value="{{ $item->o_value }}">
														</div>
													</div>
												</div>
											</div>
										@endif
								@if(!isset($results[$i+1]) || (isset($results[$i+1]) && $results[$i+1]->group != $k))
										</div>
									</div>
								</div>
								@endif
							@endforeach
						</div>
                        <button type="submit" class="btn bg-teal btn-lg waves-effect">Lưu thay đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/public/plugins/autosize/autosize.js') }}"></script>
    <script src="{{ asset('/public/plugins/tinymce/tinymce.js') }}"></script>
    <script>
        var hub_select = $('.ms');
        if(hub_select.length){
            hub_select.removeClass('ms');
            if ($.fn.selectpicker) {
                $('select').selectpicker();
            }
        }
        editor_config = {
            selector: "textarea[id^=tinymce_]",
            theme: "modern",
            path_absolute : "",
            relative_urls: false,
            height: 300,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Quản lý media',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            },
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak fullscreen',
                'searchreplace wordcount visualblocks visualchars code',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fullscreen | code',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        };
        tinymce.init(editor_config);
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '{{ env('APP_URL') }}' + '/public/plugins/tinymce';

        autosize($('textarea.auto-growth'));

        @isset($error)
        showNotification('bg-black', '{{ $error }}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
        @endisset
        @isset($success)
        showNotification('bg-green', '{{ $success }}', 'top', 'right', 'animated bounceInRight', 'animated bounceOutRight');
        @endisset
    </script>
@endsection