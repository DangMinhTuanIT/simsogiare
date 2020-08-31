<script type="text/javascript">
   $('.slug_slugify').slugify('.title_slugify');
   jQuery(function($){
       $('#description').closest('form').submit(CKupdate);
        function CKupdate() {
           for (instance in CKEDITOR.instances)
              CKEDITOR.instances[instance].updateElement();
              return true;
        }
     CKEDITOR.replace('description',{
                  width: '100%',
                  resize_maxWidth: '100%',
                  resize_minWidth: '100%',
          height:'300'
                 }
    );
    CKEDITOR.instances['description'];
    });
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
</script>