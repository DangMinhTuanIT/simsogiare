<script src="{{URL::to('')}}/js/slugify.js"></script>
<script type="text/javascript">
   $('.slug_slugify').slugify('.title_slugify');
   
       $("#pre-selected-options, #pre-selected-category").select2();

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
       jQuery.validator.addMethod('ckrequired', function (value, element, params) {
    var idname = jQuery(element).attr('id');
    var messageLength =  jQuery.trim ( CKEDITOR.instances[idname].getData() );
    return !params  || messageLength.length !== 0;
}, "Image field is required");

        $("#formDemo").validate({
          event: 'blur',
            rules: {
                title: "required",
                slug: "required",
                category: "required",
            },
            content: {
              required: function(textarea) {
                CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                return editorcontent.length === 0;
              }
            },
            messages: {
                name: "Vui lòng nhập tên dự án",
                slug: "Vui lòng nhập slug",
                category: "Vui lòng chọn thể loại",
                content: "Vui lòng nhập nội dung",
            }
        });
        $('#seo_title').bind('input keyup keydown keypress', function(){
            var charCount1 = $(this).val().replace(/\s/g, '').length;
            $("#char_title").text(charCount1);
          });
          $('#seo_keyword').bind('input keyup keydown keypress', function(){
            var charCount2 = $(this).val().replace(/\s/g, '').length;
            $("#char_keyword").text(charCount2);
          });
          $('#seo_description').bind('input keyup keydown keypress', function(){
            var charCount3 = $(this).val().replace(/\s/g, '').length;
            $("#char_description").text(charCount3);
          });
           $('#description').summernote({
            placeholder: 'Please enter your description',
            tabsize: 2,
            focus: true,
            height: 500,
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            callbacks: {
                onImageUpload : function(files, editor, welEditable) {

                     for(var i = files.length - 1; i >= 0; i--) {
                             sendFile(files[i], this);
                    }
                }
            }
        });
           var IMAGE_PATH='{{URL::to('/')}}';
       function sendFile(file, el) {
        var form_data = new FormData();
        form_data.append('file', file);
        var url1 = "{{route('ajax.admin.images')}}";
        $.ajax({
            data: form_data,
            type: "POST",
            url: url1,
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
              var image = IMAGE_PATH +'/'+ url;
                $(el).summernote('editor.insertImage', url);
            }
        });
        }
     

</script>
<style type="text/css">
  .select2-container {
  width: 100% !important;
  }
  .error{
    color: red
  }
  .feature{
    position: relative !important;
    left:0 !important;
    opacity: 1 !important;
  }
</style>