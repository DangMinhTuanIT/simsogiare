$(document).ready( function(){

	$('#submitbt').click(function(){
		if(checkFormsubmit())
			document.feng_shui.submit();
//			search_feng_shui();
	})
});
function checkFormsubmit()
{
	
	if(!notEmpty("giosinh","Bạn chưa nhập giờ sinh")){
		return false;
	}
	if(!notValue("ngaysinh","Hãy nhập ngày sinh")){
		return false;
	}
	if(!notValue("thangsinh","Hãy nhập tháng sinh")){
		return false;
	}
	if(!notValue("namsinh","Hãy nhập năm sinh")){
		return false;
	}
	if(!notEmpty("gioitinh","Bạn chưa nhập giới tính")){
		return false;
	}
	return true;
}

function check_fengshui(){
	 var giosinh = $( "#giosinh" ).val();
	 var ngaysinh = $( "#ngaysinh" ).val();
	 var thangsinh = $( "#thangsinh" ).val();
	 var namsinh = $( "#namsinh" ).val();
	 // alert(namsinh)
	 var gioitinh = $( "#gioitinh" ).val();
	 if(gioitinh==0){
	 	gioitinh='nu';
	 }else{
	 	gioitinh='nam';
	 }
	 let link_fengshui = $( "#link_fengshui" ).val();
	link_search = link_fengshui.replace('sex',gioitinh);
	link_search1 = link_search.replace('day',ngaysinh);
	link_search2 = link_search1.replace('month',thangsinh);
	link_search3 = link_search2.replace('year',namsinh);
	link = link_search3.replace('time',giosinh);
	 // alert(link);
	 // $link	= 
	 window.location.href=link;
	
}
jQuery('#check_fengshui_phone1').click(function(){
	var sodienthoai = $( "#sodienthoai" ).val();
    var giosinh = $( "#giosinh" ).val();
    var ngaysinh = $( "#ngaysinh" ).val();
    var thangsinh = $( "#thangsinh" ).val();
    var namsinh = $( "#namsinh" ).val();
    // alert(namsinh)
    var gioitinh = $( "#gioitinh" ).val();
    if(gioitinh==0){
      gioitinh='nu';
    }else{
      gioitinh='nam';
    }
    let link_fengshui = $( "#link_fengshui_phone" ).val();
   link_search = link_fengshui.replace('phone',sodienthoai);
   link_search0 = link_search.replace('sex',gioitinh);
   link_search1 = link_search0.replace('day',ngaysinh);
   link_search2 = link_search1.replace('month',thangsinh);
   link_search3 = link_search2.replace('year',namsinh);
   link = link_search3.replace('time',giosinh);
    // alert(link);
    // $link   = 
    window.location.href=link;
})
    
