  (function($){
      window.currentX = 0;
      window.currentY = 0;
      window.currentDeg = 0;
      window.time = 0;
      window.surfing = 0;
      window.dem = 1;
      window.items = $('.card-info').html();

      window.zIndex = 10;
      
      function reset (){
        window.currentX = 0;
        window.currentY = 0;
        window.currentDeg = 0;
        window.time = 0;
        window.surfing = 0;
      }
      
      function getItems(){
        if(window.dem % (window.items - 1) == 0){
          var html = '';
          console.log(items);
          for(var i=1;i<=window.items;i++){

            html += '<div class="card-info" style="z-index: '+ window.zIndex +'"><div class="card-image"><img src="'+ i +'.jpg"><h1>'+ i +'.jpg</h1><p>Họ tên</p><img src="uploads/girls/'+ i +'.jpg"><p>Hình ảnh</p></div></div>';
            window.zIndex--;
          }
          // $('.rectangle-inner').append(html);
        }
        window.dem++;
      }
      
      function start(event){
        window.time = Date.now() / 1000;
        window.currentX = event.pageX;
        window.currentY = event.pageY;
        if (event.targetTouches && event.targetTouches.length == 1) {
          var touch = event.targetTouches[0];
          window.currentX = touch.pageX;
          window.currentY = touch.pageY;
        }
      }
      
      function move(event){
        var pageX = event.pageX;
        var pageY = event.pageY;
        var item = $(event.target).closest('.card-info');
        if (event.targetTouches && event.targetTouches.length == 1) {
          var touch = event.targetTouches[0];
          pageX = touch.pageX;
          pageY = touch.pageY;
        }
        if(window.surfing || (Math.abs(pageX - window.currentX) > 20 && Math.abs(pageY - window.currentY) < 20)){
          $('.log').html('lướt chậm');
          var distant = pageX - window.currentX;
          window.surfing = 1;
          window.currentDeg = distant / (8*Math.PI);
          item.css({transform: 'rotate('+ window.currentDeg +'deg)'});
        }
      }
      
      function end(event){
        window.surfing = 0;
        var deg = window.currentDeg;
        var pageX = event.pageX;
        var item = $(event.target).closest('.card-info');
        if (event.changedTouches && event.changedTouches.length == 1) {
          var touch = event.changedTouches[0];
          pageX = touch.pageX;
        }
        var distant = pageX - window.currentX;
        var diff = (Date.now() / 1000) - window.time;
        
        if(diff < 0.1 && Math.abs(distant) >= 65){
          $('.log').html('lướt nhanh');
          out(deg, item);
        }else{
          if(Math.abs(deg) >= 5.5){
            $('.log').html('deg >= 5.5: Tự động lướt');
            out(deg, item);
          }else{
            $('.log').html('deg < 5.5: Về vị trí cũ');
            item.animate({
              deg: deg
            },{
              duration: Math.abs(deg * 100),
              step: function(current){
                item.css({transform: "rotate("+ (deg-current) +"deg)"});
              }
            });
          }
        }
        reset();
      }
      
      function out(deg, item){
        if(deg < 0){
          item.animate({
            deg: 40
          },{
            duration: 800,
            step: function(current){
              item.css({transform: "rotate("+ (deg - current) +"deg)"});
            },
            done: function(){

              getItems();
              item.addClass('hide');
            }
          });
        }else{
          item.animate({
            deg: 40
          },{
            duration: 800,
            step: function(current){
              item.css({transform: "rotate("+ (deg + current) +"deg)"});
            },
            done: function(){
              
              getItems();
              item.addClass('hide');
            }
          });
        }
      }
      
      document.addEventListener("dragstart", start);
      document.addEventListener("dragover", move);
      document.addEventListener("dragend", end);
      
      document.addEventListener("touchstart", start, false);
      document.addEventListener("touchmove", move, false);
      document.addEventListener("touchend", end, false);
          
      $('.rectangle').height($(window).height());
          
    })(jQuery);