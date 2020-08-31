<form class="form_validation collapse{{ (old('data')) ? ' in' : '' }} in 123" enctype="multipart/form-data"  id="formDemo" action="<?php echo URL::to('admin/setting/update/'.$info->id);?>" method="post" role="form">
	  <input type="hidden" name="_method" value="PUT">
   <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group form-float">
        <div class="form-line focused">
            <input type="text" id="name_setting" name="name_setting" value="{{$info->name_setting}}"  class="form-control">
            <label class="form-label" for="modal_name">Name</label>
        </div>
    </div>
     <div class="form-group form-float">
        <div class="form-line focused">
          <?php  $value_setting = ($info->value_setting); ?>
            <textarea rows="4" cols="50" id="value_setting" type="text" required  class="content" name="value_setting"><?php echo str_replace('               ','',$value_setting)?></textarea>
            <label class="form-label" for="modal_name">Mô tả</label>
        </div>
    </div>
     <div class="form-group form-float js">
<label class="form-label">Hình ảnh (jpg, png) (<span class="red">size không quá 1MB</span>)</label>
<div class="box">
<input type="hidden" class="thumbnail" name="thumbnail" value="{{@$info->image}}">
  <input type="file" value="{{ old('link_v2') }}" name="link_v2" id="link_v2" class="inputfile_v2 inputfile-1">
  <label class="chonhinhanh" for="link_v2">
     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
     </svg>
     <span>Chọn hình ảnh …</span>
  </label>
</div>
@if($info->image!='')
 <div class="img_thumb">
  <a href="<?php echo URL::to('/').'/'.@$info->image ?>" data-fancybox="images-preview_1" class="btn-close"> <img src="<?php echo URL::to('/').'/'.@$info->image ?>" width="150">
  </a>
</div>
@endif
</div>
<button type="submit" class="btn bg-teal btn-lg waves-effect">EDIT</button>
</form>
<script type="text/javascript">
	 var inputfile_v2 = document.querySelectorAll( '.inputfile_v2' );
       Array.prototype.forEach.call( inputfile_v2, function( input_v2 )
       {

           var label_v2    = input_v2.nextElementSibling,
               labelVal_v2 = input_v2.innerHTML;
   
           input_v2.addEventListener( 'change', function( e )
           {
               var fileName_v2 = '';
               if( this.files && this.files.length > 1 )
                   fileName_v2 = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
               else
                   fileName_v2 = e.target.value.split( '\\' ).pop();
   
               if( fileName_v2 )
                   label_v2.querySelector( 'span' ).innerHTML = fileName_v2;
               else
                   label_v2.innerHTML = labelVal_v2;
           });
   
           // Firefox bug fix
           input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
           input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
       });
</script>
<style type="text/css">
	.inputfile_v2 {
		    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
	}
</style>