<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mail ,URL;
use Illuminate\Support\Facades\DB;
use Goutte\Client;
use App\Model\ProfileService;
use App\Model\GroupService;
use App\Model\Gallery;
use App\Model\Service;
use App\Model\Order;
use App\Model\Profile;
use App\Model\PlaceDim;
use App\Model\PriceDim;
use App\Model\TypeDim;
use App\Model\Transaction;
use App\Model\Notifications;
use App\Model\Tags;
use App\Model\News;
use App\Options;
use DateTime,WebService;
use Carbon\Carbon,money_format;

class myHelper{

    public static $admins = [1];
    public static function convert_money($price){
        return sprintf('%s', number_format($price, 0));
    }

     public static function convert_time_order($time){
        try{
            $arr = explode(' ', $time);
            $arr_day = explode('-', $arr[0]);
            $arr_time = explode(':', $arr[1]);
             return $arr_day[2].'/'.$arr_day[1].'/'.$arr_day[0].' '.$arr_time[0].':'.$arr_time[1];
        }catch (\Exception $e) {
            $e->getMessage();
        }

        
    }
    public static function filter_select_html(){
    $html='';
    $html.='<select class="order-select" name="order-select" ><option value="'.URL::current().'">Sắp xếp</option>';$arr_filter = array(
          URL::current().'?order=random'=>"Ngẫu nhiên",
          URL::current().'?price=asc'=>'Giá từ thấp tới cao',
          URL::current().'?price=desc'=>'Giá từ cao tới thấp'
        ) ;
          $active = '';
          $get_key = http_build_query(@$_GET);
           foreach ($arr_filter as $key => $value) {
              $active = (@strpos($key, $get_key) !== false) ? 'selected' : '';
             $html.= '<option '.$active.' value="'.$key.'">'.$value.'</option>';
           }
        $html.='</select>';
      return $html; 
  }
    public static function str_slug($str, $seperator = '-') {
        $str = strip_tags($str);
        $str = trim(mb_strtolower($str,"UTF-8"));
        $str = preg_replace('/(\s+)|(\-)/', ' ', $str);
        $str = preg_replace('/(à|À|Á|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-zA-z0-9-\s]/', '', $str);
        $str = preg_replace('/\s+/', $seperator, $str);
        return trim($str, '-');
    }
    // strong search sim
    public static function strong_sim_search($type,$dau,$duoi,$sim_int,$number_sim_tring){
        $ketqua_dau = $number_sim_tring;
        $ketqua_duoi = $number_sim_tring;
        $results = $number_sim_tring;
        $vitri_first = $vitri_duoi = $vitri_dau = $vitri_last = '';
        if($dau!=''):
            $arr = str_split($dau);
            // chay vong loop cac gia tri
            for ($k=0; $k < count($arr); $k++) { 
              $i=0;
              $last = '';
              foreach ($arr as $key => $item) {
                $i++;
                // them dau cham vao 1 gia tri
                if($i==$k){
                 $item = $item.'.';
                }
                // noi cac item lại thành 1
                $last .= $item;
              }
              // check voi gia tri 2
              if (strpos($number_sim_tring, $last) !== false) {
                // lay các ky tu dung truoc vi tri duoi,
                $vitri_dau = '<strong style="color:red">'.substr($number_sim_tring,0,strlen($last)).'</strong>';
                $vitri_last = substr($number_sim_tring,strlen($last),(strlen($number_sim_tring) - strlen($last)));
                // tim vi tri dau
                $ketqua_dau = $vitri_dau.$vitri_last;
                break;
              }
            }
        endif;
        if($duoi!=''):
            $arr_duoi = str_split($duoi);
            // chay vong loop cac gia tri
            for ($m=0; $m < count($arr_duoi); $m++) { 
              $n=0;
              $last_duoi = '';
              foreach ($arr_duoi as $key => $val) {
                $n++;
                // them dau cham vao 1 gia tri
                if($n==$m){
                 $val = $val.'.';
                }
                // noi cac item lại thành 1
                $last_duoi .= $val;
              }
              // check voi gia tri 2
              if (strpos(($number_sim_tring), $last_duoi) !== false) {
                // lay các ky tu dung truoc vi tri duoi,
                $vitri_first = substr($number_sim_tring,0,(strlen($number_sim_tring) - strlen($last_duoi)));
                // tim vi tri duoi
                $vitri_duoi = '<strong style="color:red">'.substr($number_sim_tring,-strlen($last_duoi),strlen($last_duoi)).'</strong>';
                $ketqua_duoi = $vitri_first.$vitri_duoi;
                break;
              }
            }
        endif;
        // truong hop la giua
        if($type=='giua'){
            $_duoi =  strlen($number_sim_tring) - strlen(@$last_duoi) - strlen(@$last);
            $results = $vitri_dau.substr($number_sim_tring, (strlen(@$last)),$_duoi).$vitri_duoi;
        }
         
         switch ($type) {
            // ket qua duoi
            case 'duoi':
              // lay lenth cua so duoi
                $length = strlen($duoi);
                if($length>2&&2==2){
                     // tu 2 so tro di
                    $results = $ketqua_duoi;
                }else{
                    $length_sim = strlen($number_sim_tring);
                    $pos_sim = (int) $length_sim -  (int) $length;
                    $results =  substr($number_sim_tring,0,$pos_sim).'<strong style="color:red">'.$duoi.'</strong>';
                }
             break;
             // ket qua dau
            case 'dau':
              // lay lenth cua dau so
                $length = strlen($dau);
                if($length>2 &&2==2){
                    // tu 2 so tro di
                    $results = $ketqua_dau;
                }else{
                    $length_sim = strlen($number_sim_tring);
                    $pos_sim = (int) $length_sim -  (int) $length;
                    $results =  '<strong style="color:red">'.$dau.'</strong>'.substr($number_sim_tring,$length,$pos_sim);
                }
               
             break;
           default:

             # code...
             break;
         }
         return $results;
    }
    //
    public static function check_regex_number_string($regex,$number,$number_string){
        $ketqua =  $number_string;
        $ketqua_khac ='';
        $giatri2 = $number_string;
        $check = false;
        preg_match($regex, $number, $output_array);
        // truong hop sim taxi co 3 cham 45.45.45
        if($regex=='/(([0-9]{3})\g2|([0-9]{2})\g3{2})$/'){
            if(count($output_array)==4){
                $check = true;
                $ketqua_khac = str_replace(@$output_array[3], '<strong style="color:red">'.@$output_array[3].'</strong>', $giatri2);
            }
        }
        $bien1 = $output_array[0];
        // lay gia tri can them strong
        $arr = str_split($bien1);
        $arr_check = [];
        // chay vong loop cac gia tri
        for ($k=0; $k < count($arr); $k++) { 
          $i=0;
          $last = '';
          foreach ($arr as $key => $item) {
            $i++;
            // them dau cham vao 1 gia tri
            if($i==$k){
             $item = $item.'.';
            }
            // noi cac item lại thành 1
            $last .= $item;
          }
          // check voi gia tri 2
          if (strpos($giatri2, $last) !== false) {
            $ketqua = str_replace($last, '<strong style="color:red">'.$last.'</strong>', $giatri2);
          }
        }
        if($check){
            $ketqua = $ketqua_khac;
        }
        return ($ketqua);
    }
    public static function get_meta_desc($meta_desc,$desc){
        $seo_description = $meta_desc ;
        if($meta_desc==''){
            @$meta_description=preg_replace('/[\n\r]/','',strip_tags($desc));
            $title_length = mb_strlen($meta_description);
            $seo_description =trim(mb_substr($meta_description,0,162)) . ($title_length > 162 ? '...' : '');
            $seo_description =str_replace('&nbsp;', ' ', $seo_description);
        }
        return $seo_description;
    }
    public static function time_elapsed($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'năm',
            'm' => 'tháng',
            'w' => 'tuần',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' trước' : 'just now';
    }
    public static function random_tags_news(){
        $tags = Tags::orderBy('id','desc')->get();
        $arr_data = $results = [];
        // lay du lieu
        if(count($tags)>0){
            foreach($tags as $item){
                $arr_data[] = $item->id;
            }
            $results = self::array_random($arr_data, 5);
        }
        return $results;
    }
    public static function check_prediction_news($id){
        $prediction = false;
        //step 1 check xem category co phai la nhan dinh khong
        $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('C.id',$id)
            ->groupBy('A.id')
            ->select('A.*')
            ->get();
        if(count($results)>0){
            foreach($results as $item){
                if($item->id==15){
                    $prediction = true;
                }
            }
        }
        return $prediction;
        // tra ve true neu la nhan dinh
    }
    public static function array_random($array, $number = null)
    {
        try{

        $requested = ($number === null) ? 1 : $number;
        $count = count($array);

        if ($requested > $count) {
            throw new \RangeException(
                "You requested {$requested} items, but there are only {$count} items available."
            );
        }

        if ($number === null) {
            return $array[array_rand($array)];
        }

        if ((int) $number === 0) {
            return [];
        }

        $keys = (array) array_rand($array, $number);

        $results = [];
        foreach ($keys as $key) {
            $results[] = $array[$key];
        }

        return $results;
        }catch (\Exception $e) {
        $e->getMessage();
            // Handle the current node list is empty..
        }
    }
   
    public static function keyword_random(){
        try{
        $keyword_random = self::get_option_seo('keywords-random','text');
        $arr = explode(',',$keyword_random);
        $random = self::array_random($arr, 5);
        foreach ($random as $item) {
           $items[] = $item;
        }
        $results = implode(', ', $items);
        return $results;
        }catch (\Exception $e) {
        $e->getMessage();
            // Handle the current node list is empty..
        }
    }
    public static function get_data_frontend(){
        if(Auth::guard('customer')->check()){
           return Auth::guard('customer')->getUser(); 
        }else{
            return false;
        }
    }
    public static function end_time($time){
        $arr_time = explode(' ',$time);
        @$day_arr = explode('-',$arr_time[0]);
        @$time_arr = explode(':',$arr_time[1]);
        return @$day_arr[2].'/'.$day_arr[1].'/'.$day_arr[0].' '.$time_arr[0].':'.$time_arr[1];
    }
    public static function end_day($time){
        $arr_time = explode(' ',$time);
        @$day_arr = explode('-',$arr_time[0]);
        @$time_arr = explode(':',$arr_time[1]);
        return @$day_arr[2].'/'.$day_arr[1].'/'.$day_arr[0];
    }
     public static function start_time($time){
        $arr_time = explode(' ',$time);
        $day_arr = explode('/',$arr_time[0]);
        $time_arr = explode(':',$arr_time[1]);
        return $day_arr[2].'-'.$day_arr[1].'-'.$day_arr[0].' '.$time_arr[0].':'.$time_arr[1].':'.'00';
    }
    public static function get_day_profile($match_time){
         $arr_match_time = explode(' ',$match_time);
        $arr_time = explode(':',$arr_match_time[1]);
        $arr_day = explode('-',$arr_match_time[0]);
        $minute = $arr_time[0].':'.$arr_time[1];
        $year = $arr_day[0];
        // $year = substr($year,2, 2);
        $day = $arr_day[2].'/'.$arr_day[1].'/'.$year;
        return $day;
    }
  
    public static function time_day_created_at($time){
        $created_arr = explode(' ', $time);
        $arr_day = $created_arr[0];
        $arr_time = $created_arr[1];
        $day_arr = explode('-', $arr_day);
        $time_arr = explode(':', $arr_time);
        return $time_arr[0].':'.$time_arr[1].' '.$day_arr[2].'/'.$day_arr[1].'/'.$day_arr[0];
    }
    public static function percent($percent){
        $percent_win = config('pgvietnam.percent_win');
        return $percent_win[$percent];
    }

     public static function getThumbnail($path,$img_path, $width, $height, $type = "fit")
    {
        return app('App\Http\Controllers\ImageController')->getImageThumbnail($path,$img_path, $width, $height, $type);
    }

    public static function get_intro_description($desc){
        @$meta_description=preg_replace('/[\n\r]/','',strip_tags($desc));
        $title_length = mb_strlen($meta_description);
        $seo_description =trim(mb_substr($meta_description,0,55)) . ($title_length > 55 ? '...' : '');
        $seo_description =str_replace('&nbsp;', ' ', $seo_description);
        return  $seo_description;
    }
    public static function get_meta_keyword($meta_keyword){
        $seo_keyword = $meta_keyword ;
        if($meta_keyword==''){
            $seo_keyword = self::keyword_random();
        }
        return $seo_keyword;
    }

    public static function getLine($path){
        $lines = explode('-', $path);
        $result = '';
        if($lines && count($lines) > 1){
            foreach ($lines as $line){
                $result .= '&#151;';
            }
        }
        echo $result;
    }
    public static function total_status_pending_notification($id){
            $notification = Notifications::count_status_pending($id);
            return $notification;
    }
    public static function get_option_seo($value,$note){
        $q = DB::table('settings as s')
        ->orderBy('s.id','DESC')
        ->where('s.name_setting',$value)
            ->select('s.*')->first();
        if(!empty($q) && $note=='text'){
            return $q->value_setting;
        }else if(!empty($q) && $note=='image'){
            return URL::to($q->image);
        }else{
           return false; 
        }
    }
    public static function get_slug_profile($slug,$title){
        $html = '';
        $slug = URL::to($slug.'.html');
        $html = '<a href="'.$slug.'">'.$title.'</a>';
       return $html;
    }
     
    
    public static function time_elapsed_string($datetime, $full = false) {
        $time = time() - $time; // to get the time since that moment
            $time = ($time<1)? 1 : $time;
            $tokens = array (
                31536000 => 'year',
                2592000 => 'month',
                604800 => 'week',
                86400 => 'day',
                3600 => 'hour',
                60 => 'minute',
                1 => 'second'
            );

            foreach ($tokens as $unit => $text) {
                if ($time < $unit) continue;
                $numberOfUnits = floor($time / $unit);
                return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
            }
    }
   
    public static function ampify($html='') {
    
            $reg_img="/<\s*img\s+[^>]*>/is";
            $img_get_src='/src=\s*"[^\"]*\"/is';
            preg_match_all($reg_img, $html, $match_img,PREG_PATTERN_ORDER);
            $url_img="";
            $width=0;
            $height=0;
            for($m= 0; $m < count($match_img[0]); $m++):
                //$result_image=preg_replace("/src=\s*|\s*\"/is","",$match_img[0][$m]);
                $image_url_content=$match_img[0][$m];
                preg_match_all($img_get_src,$match_img[0][$m],$url_image,PREG_PATTERN_ORDER);
                $result_image=preg_replace("/src=\s*|\s*\"/is","",$url_image[0][0]);
                //print_r( $url_image[0]);
                //echo "<br/>";
                //echo "=".$result_image."=";
              
                    $url_img=$result_image;
                 $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        ); 
                $url_img = str_replace('https', 'http', $url_img);
                @list($width, $height, $type, $attr) = @getimagesize($url_img); 
                if($width==0 || $height==0):
                  $url_img = str_replace('http', 'https', $url_img);
                    $url_images_end='<amp-img src="'.$url_img.'" width="100" height="60" layout="responsive"></amp-img>';
                else:
                  $url_img = str_replace('http', 'https', $url_img);
                    $url_images_end='<amp-img src="'.$url_img.'" width="'.$width.'" height="'.$height.'" layout="responsive"></amp-img>';
                endif;
                
                $html=str_replace($image_url_content,$url_images_end,$html);
            endfor;
            //print_r($match_img[0]);
            
            # Replace img, audio, and video elements with amp custom elements
            $html = str_ireplace(array('<img','<video','/video>','<audio','/audio>'),
                array('<amp-img','<amp-video','/amp-video>','<amp-audio','/amp-audio>'),
                $html
            );
            $html = preg_replace('/style="[^"]*"/', ' ', $html);
            $html = str_replace('javascript:void(0);', '#', $html);
            # Add closing tags to amp-img custom element
            $html = preg_replace('/<amp-img(.*?)>/', '<amp-img$1></amp-img>',$html);
            # Whitelist of HTML tags allowed by AMP
            $html = strip_tags($html,'<h1><h2><h3><h4><h5><h6><a><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');
            return $html;
        }
    public static function count_gallery_profile($id){
        $count = Gallery::where('type_gallery',2)->where('id_profile',$id)->count();
        return $count;
    }
   
    public static function date_create_profile($id){
        $html = '';
         $profile = Profile::find($id);
         $created_at = $profile->created_at;
         $created_arr = explode(' ',$created_at);
         $date_arr = explode('-',$created_arr[0]);
         $date = $date_arr[2].'/'.$date_arr[1].'/'.$date_arr[0];
        $html = '<div class="date-created">Ngày: '.$date.'</div>';
        return $html;
    }
   
    public static function get_info_brand(){
        $html ='';
        $option = Options::getBrandInfo();
        $html ='<div class="item">Facebook: <a href="'.$option['fanpage'].'">'.$option['fanpage'].'</a></div>
        <div class="item">Telegram: <a href="'.$option['telegram'].'">'.str_replace('https://','',$option['telegram']).'</a></div>
          ';
          return $html;
    }
    public static function get_brand_header(){
        $html = '';
        $option = Options::getBrandInfo();
        $html.=' 
               <div class="header-hotline"> <a href="'.$option['fanpage'].'" title="Facebook" ><i class="fa fa-facebook-f"></i> <span class="hotline-label">Facebook</span> <span class="hotline-number">'.str_replace('https://','',$option['fanpage']).'</span></a></div>
               <div class="header-hotline zalo"> <a href="'.$option['zalo'].'" title="Facebook" ><i class="fa fa-telegram"></i> <span class="hotline-label">Zalo</span> <span class="hotline-number">'.str_replace('https://','',$option['zalo']).'</span></a></div>
               <div class="header-hotline"> <a href="'.$option['telegram'].'" title="Telegram"><i class="fa fa-telegram"></i> <span class="hotline-label">Telegram</span> <span class="hotline-number">'.str_replace('https://','',$option['telegram']).'</span></a></div>';
               return $html;
    }
    public static function get_contact_profile(){
        $html = '';
        $option = Options::getBrandInfo();
        $html ='<div class="tip-infomation">
        <p class="tit"><b></b><span class="section-title-main">HỖ TRỢ TƯ VẤN 24/7</span><b></b></p>
          <div class="item"><a class="link" href="'.$option['fanpage'].'"><span class="circle"><i class="fa fa-facebook-f"></i></span> <span class="text-hotline">'.str_replace('https://','',$option['fanpage']).'</span></a></div>
          <div class="item zalo"><a class="link" href="'.$option['zalo'].'"><span class="circle"><i class="fa fa-telegram" aria-hidden="true"></i></span> <span class="text-hotline">'.str_replace('https://','',$option['zalo']).'</span></a></div>
          <div class="item"><a class="link" href="'.$option['telegram'].'"><span class="circle"><i class="fa fa-telegram" aria-hidden="true"></i></span> <span class="text-hotline"> '.str_replace('https://','',$option['telegram']).'</span></a></div>
        </div>
          ';

          return $html;
    }
   
    public static function seo_url($string) {
        $search = array (
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        ) ;
        $replace = array (
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        ) ;
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '-', $string);
        $string = strtolower($string);
        return $string;
    }
    public static function user_name_profile($string) {
        $search = array (
            '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
            '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
            '#(ì|í|ị|ỉ|ĩ)#',
            '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
            '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
            '#(ỳ|ý|ỵ|ỷ|ỹ)#',
            '#(đ)#',
            '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
            '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
            '#(Ì|Í|Ị|Ỉ|Ĩ)#',
            '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
            '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
            '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
            '#(Đ)#',
            "/[^a-zA-Z0-9\-\_]/",
        ) ;
        $replace = array (
            'a',
            'e',
            'i',
            'o',
            'u',
            'y',
            'd',
            'A',
            'E',
            'I',
            'O',
            'U',
            'Y',
            'D',
            '-',
        ) ;
        $string = preg_replace($search, $replace, $string);
        $string = preg_replace('/(-)+/', '', $string);
        $string = strtolower($string);
        return $string;
    }
    public static function get_avatar_profile($id){
        $results = Gallery::where('id_profile',$id)->where('type_gallery',1)->first();
        if(count($results)>0){
            return $results;
        }else{
            return false;
        }

    }
    public static function order_month_customer($id_customer,$month){
        $results = Order::get_order_month_customer($id_customer,$month);
        if(count($results)>0){
            return $results;
        }else{
            return false;
        }
    }
     public static function transaction_month_customer($id_customer,$month){
        $results = Transaction::get_transaction_month_customer($id_customer,$month);
        if(count($results)>0){
            return $results;
        }else{
            return false;
        }
    }
     public static function get_name_profile($id_profile){
        $results = Profile::find($id_profile);
        if(count($results)>0){
            return $results->name;
        }else{
            return false;
        }
    }
    public static function get_gallery_profile($id){
        $results = Gallery::where('id_profile',$id)->where('type_gallery',2)->get();
        if(count($results)>0){
            return $results;
        }else{
            return false;
        }
    }
    public static function birthday_by_time($time){
        $userDob = $time;
        $dob = new DateTime($userDob);
        $now = new DateTime();
        $difference = $now->diff($dob);
        $age = $difference->y;
        return $age;
    }
    public static function getGroup($param, $current){
        $new = preg_replace('/Xem|Thêm|Sửa|Xóa tất cả|Xóa|Thay đổi danh sách|Thay đổi|Xuất tệp|Nhập tệp|Kích hoạt|Đăng/', '', $param);
        $new = trim($new);
        if($current != $new)
            return $new;
        return $current;
    }

    public static function getOptionGroups($params, $items = array()){
        $html = '';
        if($params) {
            $current = '';
            $i = 0;
            foreach ($params as $item) {
                $flag = 0;
                $group = self::getGroup($item->name, $current);
                if ($group != $current) {
                    $flag = 1;
                    $current = $group;
                }
                if ($flag) {
                    if($i){
                        $html .= '</optgroup>';
                    }else{
                        $i = 1;
                    }
                    $html .= '<optgroup label = "' . $current . '">';
                }
                $html .= '<option value="' . $item->name . '" ' . (in_array($item->name, $items) ? 'selected' : '') . '>' . $item->name . '</option>';
            }
        }
        echo $html;
    }

    public static function getFilters($filters){
        $m_filters = [];
        $m_filters['filters'] = [];
        $q_filters = '';
        if(isset($filters)){
            foreach ($filters as $k=>$_filter){
                if($_filter['default'] !== ''){
                    $m_filters['filters'][$k] = trim($_filter['default']);
                }
            }
            if($m_filters){
                $q_filters = http_build_query($m_filters);
            }
        }
        return $q_filters;
    }
    public static function edit_profile_service($id_group_service,$id_service){
        $service = Service::where('id_group_service',$id_group_service)->get();
        $html = '';
        if(!empty($service)){
            foreach ($service as $item) {
                $selected = $id_service==$item->id ? 'selected' : '';
                $html .='<option '.$selected.' value="'.$item->id.'">'.$item->name.'</option>';
            }
        }
        return $html;
    }
    public static function show_profile_service($id_group_service,$id_service){
        $service = Service::where('id_group_service',$id_group_service)->get();
        $html = '';
        if(!empty($service)){
            foreach ($service as $item) {
                if($id_service==$item->id){
                    $html .=$item->name;
                }
            }
        }
        return $html;
    }
    public static function get_type_price_profile($id,$type,$start_price,$end_price,$fix_price){
         $agreement = $range_price = $fixed_price = '';
         switch ($type) {
            case 'agreement':
                $agreement = 'block';
                break;
            case 'range_price':
                $range_price = 'block';
                break;
            case 'fixed_price':
                $fixed_price = 'block';
                break;
            
            default:
                # code...
                break;
        }
        $number = $id;
        $html ='';
        $html .= '<div class="clear none '.$range_price.'">
               <input class="start_price validate-number" id="start_price" type="text" name="start_price'.$number.'" value="'.$start_price.'" placeholder="Start Price">
            </div>';
        $html .= '<div class="clear none '.$range_price.'">
               <input class="end_price validate-number" id="end_price" type="text" name="end_price'.$number.'" value="'.$end_price.'" placeholder="End Price">
            </div>';
        $html .= '<div class="clear none '.$fixed_price.'">
               <input class="fix_price validate-number" id="fix_price" type="text" name="fix_price'.$number.'" value="'.$fix_price.'" placeholder="Fix Price">
            </div>';
        $html .= '<div class="clear none '.$agreement.'">
                <p class="title_txt">Giá thỏa thuận</p>
            </div>';
        return $html;
    }
    public static function show_type_price_profile($id,$type,$start_price,$end_price,$fix_price,$type_price){
         $agreement = $range_price = $fixed_price = '';
         switch ($type) {
            case 'agreement':
                $agreement = 'block';
                break;
            case 'range_price':
                $range_price = 'block';
                break;
            case 'fixed_price':
                $fixed_price = 'block';
                break;
            
            default:
                # code...
                break;
        }
        $currency = '';
        switch ($type_price) {
            case 'usd':
               $currency = 'USD';
                break;
             case 'vnd':
               $currency = 'VNĐ';
                break;
            
            default:
                # code...
                break;
        }
        $number = $id;
        $html ='';
        $html .= '<span class="first clear none '.$range_price.'">'.number_format($start_price).'</span>';
        $html .= '<span class="clear none '.$range_price.'"> - '.number_format($end_price).' '.$currency.'</span>';
        $html .= '<span class="clear none '.$fixed_price.'">
            '.number_format($fix_price).' '.$currency.'
            </span>';
        $html .= '<span class="clear none '.$agreement.'">
                <p class="title_txt">Giá thỏa thuận</p>
            </span>';
        return $html;
    }
     public static function buildSQLOrder($q, $filters, $order_by, $order_value = 'asc'){
        $isOrder = 0;
        if($filters){
            foreach($filters as $k=>$val){
                $q = $q->orderBy('s.' . $k,$val);
            }
        }
       
        return $q;
    }
    public static function buildSQL($q, $filters, $order_by, $order_value = 'asc'){
        $isOrder = 0;
        if($filters){
            foreach($filters as $k=>$val){
                if($k != 'updated_at') {
                    $q = $q->where('s.' . $k, '=', $val);
                }
            }
            if(isset($filters['updated_at'])){
                $isOrder = 1;
                $q = $q->orderBy('s.updated_at', $filters['updated_at']);
            }
        }

        if(!$isOrder) {
            $q = $q->orderBy($order_by, $order_value);
        }
        return $q;
    }

    public static function get_name_group_product($id){
        $get_name_group = DB::table('group_product')->where('id', $id)->first();
        return $get_name_group->name;

    } 
     public static function get_name_group_service($id){
        $get_name_group = DB::table('group_service')->where('id', $id)->first();
        return $get_name_group->name;

    } 
     public static function get_name_service($id){
        $get_name_group = DB::table('service')->where('id', $id)->first();
        return $get_name_group->name;

    } 

    public static function validIDs($params){
        if($params) {
            $IDs = [];
            if (is_array($params)) {
                foreach ($params as $item) {
                    if (is_numeric($item)) {
                        $IDs[] = htmlspecialchars($item);
                    }
                }
            }
            return $IDs;
        }
        return null;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function myLogs($action, $module, $item = '', $num = 0){
        $knotModules = config('simsogiare.modules');
        $module_name = $knotModules[$module];
        $module_name_lower = $module_name;
        $module_name = ucfirst($module_name);
        $log = new Log();

        switch ($action){
            case 'store':
                $log->code = $module . '100';
                $log->name = 'Thêm ' . $module_name_lower;
                $log->message = auth()->user()->name . ' đã thêm '. $module_name_lower .': ' . $item;
                break;
            case 'update':
                $log->code = $module . '200';
                $log->name = 'Cập nhật ' . $module_name_lower;
                $log->message = auth()->user()->name . ' đã cập nhật '. $module_name_lower .': ' . $item;
                break;
            case 'destroy':
                $log->code = $module . '300';
                $log->name = 'Xóa ' . $module_name_lower;
                $log->message = auth()->user()->name . ' đã xóa '. $module_name_lower .': ' . $item;
                break;
            case 'removeAll':
                $log->code = $module . '400';
                $log->name = 'Xóa tất cả ' . $module_name_lower;
                $log->message = auth()->user()->name . ' đã xóa tất cả '. $module_name_lower;
                break;
            case 'import':
                $log->code = $module . '500';
                $log->name = 'Import Data';
                $log->message = auth()->user()->name . ' đã import thành công: ' . number_format($num) . ' ' . $module_name_lower;
                break;
            default: return;
        }

        $log->module = $module_name;
        $log->author = auth()->user()->id;
        $log->save();
    }

    public static function notify($params){

        if(Auth::check()) {
            $id = auth()->user()->id;
        }else{
            $id = 1;
        }
        Notify::create([
            'name' => $params['name'],
            'type' => $params['type'],
            'url' => $params['url'],
            'to'    => isset($params['to']) ? $params['to'] : 1,
            'author' => $id,
            'editor' => $id,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
    }

    public static function sendEmail($params){
        $options = Options::all();
        $vOptions = [];

        foreach ($options as $option){
            $vOptions[$option->o_key] = $option->o_value;
        }

        return Mail::send($params['template'], $params, function ($message) use ($params, $vOptions) {
            $message->subject($params['subject']);
            $message->from($vOptions['mail_address'], $vOptions['mail_name']);
            $message->to($params['to']);
            $message->bcc($params['bcc']);
        });
    }

    public static function sendThankYouEmail($params){
        $email_content = Options::getEmailThankYou();
        $email_content = $email_content->o_value;
        $email_content = str_replace('$name$', $params['name'], $email_content);
        $url = route('verify.check', [
            'partner_id'    => $params['partner_id'],
            'type'          => config('simsigiare.verify.email'),
            'code'          => $params['code']
        ]);
        $email_content = str_replace('$url$', $url, $email_content);

        self::sendEmail([
            'template'  => 'systems.email.verify',
            'subject'   => env('APP_NAME') . ' - Xác nhận email',
            'to'        => $params['email'],
            'bcc'       => [],
            'content'   => $email_content
        ]);
    }

    public static function sendApprovalEmail($params){
        $email_content = Options::getEmailApprove();
        $email_content = $email_content->o_value;
        $email_content = str_replace('$name$', $params['name'], $email_content);

        self::sendEmail([
            'template'  => 'systems.email.approve',
            'subject'   => env('APP_NAME') . ' - Thông báo phê duyệt tài khoản',
            'to'        => $params['email'],
            'bcc'       => [],
            'content'   => $email_content
        ]);
    }

    public static function sendVoucherEmail($params){
        $email_content = Options::getEmailVoucher();
        $email_content = $email_content->o_value;
        $email_content = str_replace('$name$', $params['name'], $email_content);
        $email_content = str_replace('$voucher$', $params['voucher'], $email_content);

        self::sendEmail([
            'template'  => 'systems.email.voucher',
            'subject'   => env('APP_NAME') . ' - Thông báo nhận mã ưu đãi',
            'to'        => $params['email'],
            'bcc'       => [],
            'content'   => $email_content
        ]);
    }

    public static function getLocation($params = ''){
        $contents = Storage::disk('local')->get('tinh_tp.json');
        $location = json_decode($contents);
        $options = '';
        foreach ($location as $item){
            $options .= '<option '. ($item->name == $params ? 'selected' : '') .'>' . $item->name . '</option>';
        }
        return $options;
    }

    public static function getAllServices(){
        return Service::allData();
    }

    public static function getSelect($params){
        $html = '';
        $name = isset($params['is_temp']) ? 'data-name="'. $params['name'] .'"' : 'name="'. $params['name'] .'"';
        $require = isset($params['require']) ? 'frm_required' : '';
         $class = isset($params['class']) ? $params['class'] : '';

        $html .= '<div class="form-group form-float">
                <label>' . $params['label'] . '</label>
                <select class="form-control show-tick ms '.$class.''.$require.'" ' . $name .' id="'.$class.'" data-title="' . $params['label'] . '" data-live-search="true">';
                    foreach ($params['items'] as $item){
                        if(!is_object($item) && !is_array($item)){

                            $html .= '<option value="' . $item . '" ' . (($params['value'] == $item) ? 'selected' : '') . ' >' . $item . '</option>';
                        }else{
                            $item = (array) $item;
                            $html .= '<option value="' . $item['id'] . '" ' . (($params['value'] == $item['id']) ? 'selected' : '') . ' >' . $item['name'] . '</option>';
                        }
                    }
        $html .= '</select>
            </div>';

        echo $html;
    }

    public static function getSelected($params){
     
        $html = '';
        $name = isset($params['is_temp']) ? 'data-name="'. $params['name'] .'"' : 'name="'. $params['name'] .'"';
        $require = isset($params['require']) ? 'frm_required' : '';
        $html .= '<div class="form-group form-float">
                <label>' . $params['label'] . '</label>
                <select class="form-control show-tick ms '.$require.'" ' . $name .' data-title="' . $params['label'] . '" data-live-search="true">';
                    foreach ($params['items'] as $item){
                        if(!is_object($item) && !is_array($item)){
                            $html .= '<option value="' . $item . '" ' . (($params['value'] == $item) ? 'selected' : '') . ' >' . $item . '</option>';
                        }else{
                            $item = (array) $item;
                            $html .= '<option value="' . $item['id'] . '" ' . (($params['value'] == $item['id']) ? 'selected' : '') . ' >' . $item['name'] . '</option>';
                        }
                    }
        $html .= '</select>
            </div>';

        echo $html;
    }
    public static function showMoney($param){
        $len = strlen($param);
        if($len < 7){
            return $param/1000 . ' Ngàn';
        }elseif($len < 10){
            return $param/1000000 . ' Triệu';
        }else{
            return $param/1000000000 . ' Tỷ';
        }
    }

    public static function TableOfContents($content,$toc_title="Mục lục")
    {
        $items = $css_classes = $anchor = '';
        $custom_toc_position = strpos($content, '<!--TOC-->');
        $find = $replace = array();
        $items = self::extract_headings($find, $replace, $content);
        if ($items){
            $css_classes ="toc_wrap";
            $css_classes .= ' toc_wrap';
            $css_classes .= ' toc_light_blue';
            $css_classes = trim($css_classes);
            $html = '<div id="toc_container" class="' . $css_classes . '">';
            $html .= '<p class="toc_title">' . htmlentities( $toc_title, ENT_COMPAT, 'UTF-8' ) . ' <span class="toc_toggle">[<a href="#">hide</a>]</span></p>';
            $html .= '<ul class="toc_list">' . $items . '</ul></div>' . "\n";
            if ( $custom_toc_position !== false ) {
                $find[] = '<!--TOC-->';
                $replace[] = $html;
                $content = self::mb_find_replace($find, $replace, $content);
            }
            else
            {
                $replace[0] = $html . $replace[0];
                $content = self::mb_find_replace($find, $replace, $content);
            }
        }
        $content = str_replace('<!--TOC-->', '', $content);
        return $content;
    }
    public static function extract_headings( &$find, &$replace, $content = '' )
    {
        $matches = array();
        $anchor = '';
        $items = false;

        $collision_collector = array();

        if ( is_array($find) && is_array($replace) && $content ) {
            if ( preg_match_all('/(<h([1-6]{1})[^>]*>).*<\/h\2>/msuU', $content, $matches, PREG_SET_ORDER) ) {
                $new_matches = array();
                for ($i = 0; $i < count($matches); $i++) {
                    if ( trim( strip_tags($matches[$i][0]) ) != false )
                        $new_matches[] = $matches[$i];
                }
                if ( count($matches) != count($new_matches) )
                    $matches = $new_matches;
                if ( count($matches) >= 1 ) {
                    for ($i = 0; $i < count($matches); $i++) {
                        // get anchor and add to find and replace arrays
                        $anchor = self::url_anchor_target( $matches[$i][0] );
                        $find[] = $matches[$i][0];
                        $replace[] = str_replace(
                            array(
                                $matches[$i][1],                // start of heading
                                '</h' . $matches[$i][2] . '>'   // end of heading
                            ),
                            array(
                                $matches[$i][1] . '<span id="' . $anchor . '">',
                                '</span></h' . $matches[$i][2] . '>'
                            ),
                            $matches[$i][0]
                        );

                    }
                    $items = self::build_hierarchy($matches);
                }
            }
        }
        return $items;
    }
    public static function mb_find_replace( &$find = false, &$replace = false, &$string = '' )
    {
        if ( is_array($find) && is_array($replace) && $string ) {
            // check if multibyte strings are supported
            if ( function_exists( 'mb_strpos' ) ) {
                for ($i = 0; $i < count($find); $i++) {
                    $string =
                        mb_substr( $string, 0, mb_strpos($string, $find[$i]) ) .    // everything befor $find
                        $replace[$i] .                                              // its replacement
                        mb_substr( $string, mb_strpos($string, $find[$i]) + mb_strlen($find[$i]) )  // everything after $find
                    ;
                }
            }
            else {
                for ($i = 0; $i < count($find); $i++) {
                    $string = substr_replace(
                        $string,
                        $replace[$i],
                        strpos($string, $find[$i]),
                        strlen($find[$i])
                    );
                }
            }
        }

        return $string;
    }
    public static function build_hierarchy( &$matches )
    {
        $current_depth = 100;   // headings can't be larger than h6 but 100 as a default to be sure
        $html = '';
        $numbered_items = array();
        $numbered_items_min = null;
        $collision_collector = array();
        for ($i = 0; $i < count($matches); $i++) {
            if ( $current_depth > $matches[$i][2] )
                $current_depth = (int)$matches[$i][2];
        }

        $numbered_items[$current_depth] = 0;
        $numbered_items_min = $current_depth;

        for ($i = 0; $i < count($matches); $i++) {

            if ( $current_depth == (int)$matches[$i][2] )
                $html .= '<li>';

            // start lists
            if ( $current_depth != (int)$matches[$i][2] ) {
                for ($current_depth; $current_depth < (int)$matches[$i][2]; $current_depth++) {
                    $numbered_items[$current_depth + 1] = 0;
                    $html .= '<ul><li>';
                }
            }
            // list item
            if ( in_array($matches[$i][2], array(1,2,3,4,5,6)) ) {
                $html .= '<a href="#'.self::url_anchor_target($matches[$i][0]).'">';
                //if ( $this->options['ordered_list'] ) {
                // attach leading numbers when lower in hierarchy
                $html .= '<span class="toc_number toc_depth_'.($current_depth - $numbered_items_min + 1).'">';
                for ($j = $numbered_items_min; $j < $current_depth; $j++) {
                    $number = ($numbered_items[$j]) ? $numbered_items[$j] : 0;
                    $html .= $number . '.';
                }

                $html .= ($numbered_items[$current_depth] + 1) . '</span> ';
                $numbered_items[$current_depth]++;
                //}
                $html .= strip_tags($matches[$i][0]).'</a>';
            }
            // end lists
            if ( $i != count($matches) - 1 ) {
                if ( $current_depth > (int)$matches[$i + 1][2] ) {
                    for ($current_depth; $current_depth > (int)$matches[$i + 1][2]; $current_depth--) {
                        $html .= '</li></ul>';
                        $numbered_items[$current_depth] = 0;
                    }
                }

                if ( $current_depth == (int)@$matches[$i + 1][2] )
                    $html .= '</li>';
            }
            else {
                // this is the last item, make sure we close off all tags
                for ($current_depth; $current_depth >= $numbered_items_min; $current_depth--) {
                    $html .= '</li>';
                    if ( $current_depth != $numbered_items_min ) $html .= '</ul>';
                }
            }
        }
        return $html;
    }

    private static function url_anchor_target( $title )
    {
        $return = false;

        if ( $title ) {
            $return = trim( strip_tags($title) );
            // convert accented characters to ASCII
            $return = self::remove_accents( $return );
            // replace newlines with spaces (eg when headings are split over multiple lines)
            $return = str_replace( array("\r", "\n", "\n\r", "\r\n"), ' ', $return );
            // remove &amp;
            $return = str_replace( '&amp;', '', $return );
            // remove non alphanumeric chars
            $return = preg_replace( '/[^a-zA-Z0-9 \-_]*/', '', $return );

            // convert spaces to _
            $return = str_replace(
                array('  ', ' '),
                '_',
                $return
            );
            // remove trailing - and _
            $return = rtrim( $return, '-_' );

            if ( !$return ) {
                $return = 'i';
            }
        }
        $collision_collector[$return] = 1;
        return $return;
    }
   
    public static function remove_accents($string ) {
        if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;

        if (self::seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                'ª' => 'a', 'º' => 'o',
                'À' => 'A', 'Á' => 'A',
                'Â' => 'A', 'Ã' => 'A',
                'Ä' => 'A', 'Å' => 'A',
                'Æ' => 'AE','Ç' => 'C',
                'È' => 'E', 'É' => 'E',
                'Ê' => 'E', 'Ë' => 'E',
                'Ì' => 'I', 'Í' => 'I',
                'Î' => 'I', 'Ï' => 'I',
                'Ð' => 'D', 'Ñ' => 'N',
                'Ò' => 'O', 'Ó' => 'O',
                'Ô' => 'O', 'Õ' => 'O',
                'Ö' => 'O', 'Ù' => 'U',
                'Ú' => 'U', 'Û' => 'U',
                'Ü' => 'U', 'Ý' => 'Y',
                'Þ' => 'TH','ß' => 's',
                'à' => 'a', 'á' => 'a',
                'â' => 'a', 'ã' => 'a',
                'ä' => 'a', 'å' => 'a',
                'æ' => 'ae','ç' => 'c',
                'è' => 'e', 'é' => 'e',
                'ê' => 'e', 'ë' => 'e',
                'ì' => 'i', 'í' => 'i',
                'î' => 'i', 'ï' => 'i',
                'ð' => 'd', 'ñ' => 'n',
                'ò' => 'o', 'ó' => 'o',
                'ô' => 'o', 'õ' => 'o',
                'ö' => 'o', 'ø' => 'o',
                'ù' => 'u', 'ú' => 'u',
                'û' => 'u', 'ü' => 'u',
                'ý' => 'y', 'þ' => 'th',
                'ÿ' => 'y', 'Ø' => 'O',
                // Decompositions for Latin Extended-A
                'Ā' => 'A', 'ā' => 'a',
                'Ă' => 'A', 'ă' => 'a',
                'Ą' => 'A', 'ą' => 'a',
                'Ć' => 'C', 'ć' => 'c',
                'Ĉ' => 'C', 'ĉ' => 'c',
                'Ċ' => 'C', 'ċ' => 'c',
                'Č' => 'C', 'č' => 'c',
                'Ď' => 'D', 'ď' => 'd',
                'Đ' => 'D', 'đ' => 'd',
                'Ē' => 'E', 'ē' => 'e',
                'Ĕ' => 'E', 'ĕ' => 'e',
                'Ė' => 'E', 'ė' => 'e',
                'Ę' => 'E', 'ę' => 'e',
                'Ě' => 'E', 'ě' => 'e',
                'Ĝ' => 'G', 'ĝ' => 'g',
                'Ğ' => 'G', 'ğ' => 'g',
                'Ġ' => 'G', 'ġ' => 'g',
                'Ģ' => 'G', 'ģ' => 'g',
                'Ĥ' => 'H', 'ĥ' => 'h',
                'Ħ' => 'H', 'ħ' => 'h',
                'Ĩ' => 'I', 'ĩ' => 'i',
                'Ī' => 'I', 'ī' => 'i',
                'Ĭ' => 'I', 'ĭ' => 'i',
                'Į' => 'I', 'į' => 'i',
                'İ' => 'I', 'ı' => 'i',
                'Ĳ' => 'IJ','ĳ' => 'ij',
                'Ĵ' => 'J', 'ĵ' => 'j',
                'Ķ' => 'K', 'ķ' => 'k',
                'ĸ' => 'k', 'Ĺ' => 'L',
                'ĺ' => 'l', 'Ļ' => 'L',
                'ļ' => 'l', 'Ľ' => 'L',
                'ľ' => 'l', 'Ŀ' => 'L',
                'ŀ' => 'l', 'Ł' => 'L',
                'ł' => 'l', 'Ń' => 'N',
                'ń' => 'n', 'Ņ' => 'N',
                'ņ' => 'n', 'Ň' => 'N',
                'ň' => 'n', 'ŉ' => 'n',
                'Ŋ' => 'N', 'ŋ' => 'n',
                'Ō' => 'O', 'ō' => 'o',
                'Ŏ' => 'O', 'ŏ' => 'o',
                'Ő' => 'O', 'ő' => 'o',
                'Œ' => 'OE','œ' => 'oe',
                'Ŕ' => 'R','ŕ' => 'r',
                'Ŗ' => 'R','ŗ' => 'r',
                'Ř' => 'R','ř' => 'r',
                'Ś' => 'S','ś' => 's',
                'Ŝ' => 'S','ŝ' => 's',
                'Ş' => 'S','ş' => 's',
                'Š' => 'S', 'š' => 's',
                'Ţ' => 'T', 'ţ' => 't',
                'Ť' => 'T', 'ť' => 't',
                'Ŧ' => 'T', 'ŧ' => 't',
                'Ũ' => 'U', 'ũ' => 'u',
                'Ū' => 'U', 'ū' => 'u',
                'Ŭ' => 'U', 'ŭ' => 'u',
                'Ů' => 'U', 'ů' => 'u',
                'Ű' => 'U', 'ű' => 'u',
                'Ų' => 'U', 'ų' => 'u',
                'Ŵ' => 'W', 'ŵ' => 'w',
                'Ŷ' => 'Y', 'ŷ' => 'y',
                'Ÿ' => 'Y', 'Ź' => 'Z',
                'ź' => 'z', 'Ż' => 'Z',
                'ż' => 'z', 'Ž' => 'Z',
                'ž' => 'z', 'ſ' => 's',
                // Decompositions for Latin Extended-B
                'Ș' => 'S', 'ș' => 's',
                'Ț' => 'T', 'ț' => 't',
                // Euro Sign
                '€' => 'E',
                // GBP (Pound) Sign
                '£' => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                'Ơ' => 'O', 'ơ' => 'o',
                'Ư' => 'U', 'ư' => 'u',
                // grave accent
                'Ầ' => 'A', 'ầ' => 'a',
                'Ằ' => 'A', 'ằ' => 'a',
                'Ề' => 'E', 'ề' => 'e',
                'Ồ' => 'O', 'ồ' => 'o',
                'Ờ' => 'O', 'ờ' => 'o',
                'Ừ' => 'U', 'ừ' => 'u',
                'Ỳ' => 'Y', 'ỳ' => 'y',
                // hook
                'Ả' => 'A', 'ả' => 'a',
                'Ẩ' => 'A', 'ẩ' => 'a',
                'Ẳ' => 'A', 'ẳ' => 'a',
                'Ẻ' => 'E', 'ẻ' => 'e',
                'Ể' => 'E', 'ể' => 'e',
                'Ỉ' => 'I', 'ỉ' => 'i',
                'Ỏ' => 'O', 'ỏ' => 'o',
                'Ổ' => 'O', 'ổ' => 'o',
                'Ở' => 'O', 'ở' => 'o',
                'Ủ' => 'U', 'ủ' => 'u',
                'Ử' => 'U', 'ử' => 'u',
                'Ỷ' => 'Y', 'ỷ' => 'y',
                // tilde
                'Ẫ' => 'A', 'ẫ' => 'a',
                'Ẵ' => 'A', 'ẵ' => 'a',
                'Ẽ' => 'E', 'ẽ' => 'e',
                'Ễ' => 'E', 'ễ' => 'e',
                'Ỗ' => 'O', 'ỗ' => 'o',
                'Ỡ' => 'O', 'ỡ' => 'o',
                'Ữ' => 'U', 'ữ' => 'u',
                'Ỹ' => 'Y', 'ỹ' => 'y',
                // acute accent
                'Ấ' => 'A', 'ấ' => 'a',
                'Ắ' => 'A', 'ắ' => 'a',
                'Ế' => 'E', 'ế' => 'e',
                'Ố' => 'O', 'ố' => 'o',
                'Ớ' => 'O', 'ớ' => 'o',
                'Ứ' => 'U', 'ứ' => 'u',
                // dot below
                'Ạ' => 'A', 'ạ' => 'a',
                'Ậ' => 'A', 'ậ' => 'a',
                'Ặ' => 'A', 'ặ' => 'a',
                'Ẹ' => 'E', 'ẹ' => 'e',
                'Ệ' => 'E', 'ệ' => 'e',
                'Ị' => 'I', 'ị' => 'i',
                'Ọ' => 'O', 'ọ' => 'o',
                'Ộ' => 'O', 'ộ' => 'o',
                'Ợ' => 'O', 'ợ' => 'o',
                'Ụ' => 'U', 'ụ' => 'u',
                'Ự' => 'U', 'ự' => 'u',
                'Ỵ' => 'Y', 'ỵ' => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                'ɑ' => 'a',
                // macron
                'Ǖ' => 'U', 'ǖ' => 'u',
                // acute accent
                'Ǘ' => 'U', 'ǘ' => 'u',
                // caron
                'Ǎ' => 'A', 'ǎ' => 'a',
                'Ǐ' => 'I', 'ǐ' => 'i',
                'Ǒ' => 'O', 'ǒ' => 'o',
                'Ǔ' => 'U', 'ǔ' => 'u',
                'Ǚ' => 'U', 'ǚ' => 'u',
                // grave accent
                'Ǜ' => 'U', 'ǜ' => 'u',
            );
            $string = strtr($string, $chars);
        } else {
            $chars = array();
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
                ."\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
                ."\xc3\xc4\xc5\xc7\xc8\xc9\xca"
                ."\xcb\xcc\xcd\xce\xcf\xd1\xd2"
                ."\xd3\xd4\xd5\xd6\xd8\xd9\xda"
                ."\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
                ."\xe4\xe5\xe7\xe8\xe9\xea\xeb"
                ."\xec\xed\xee\xef\xf1\xf2\xf3"
                ."\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
                ."\xfc\xfd\xff";

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars = array();
            $double_chars['in'] = array("\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe");
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }
    public static function seems_utf8( $str ) {
        self::mbstring_binary_safe_encoding();
        $length = strlen($str);
        self::reset_mbstring_encoding();
        for ($i=0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) $n = 0; // 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) $n=1; // 110bbbbb
            elseif (($c & 0xF0) == 0xE0) $n=2; // 1110bbbb
            elseif (($c & 0xF8) == 0xF0) $n=3; // 11110bbb
            elseif (($c & 0xFC) == 0xF8) $n=4; // 111110bb
            elseif (($c & 0xFE) == 0xFC) $n=5; // 1111110b
            else return false; // Does not match any model
            for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }
    public static  function mbstring_binary_safe_encoding( $reset = false ) {
        static $encodings = array();
        static $overloaded = null;
        if ( is_null( $overloaded ) )
            $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );
        if ( false === $overloaded )
            return;
        if ( ! $reset ) {
            $encoding = mb_internal_encoding();
            array_push( $encodings, $encoding );
            mb_internal_encoding( 'ISO-8859-1' );
        }
        if ( $reset && $encodings ) {
            $encoding = array_pop( $encodings );
            mb_internal_encoding( $encoding );
        }
    }
    public static  function reset_mbstring_encoding() {
       self::mbstring_binary_safe_encoding( true );
    }
    public static function create_crbox($box_id, $array, $type="checkbox", $checked="", $style=""){
        if(!$box_id || !$array)     error_msg("box_id or array empty", 2);
        $return_value = "";
        $i = 0;
        foreach($array as $key => $value){
            if($type == "checkbox"){
                if( is_array($checked) ){
                    if( in_array($key, $checked) )  $equals = "checked='checked'";
                    else                            $equals = "";
                }else{
                    if( ($checked != "") && ($checked == $key) )    $equals = "checked='checked'";
                    else                                            $equals = "";
                }
                $return_value .= "<label><input type='checkbox' name='{$box_id}{$i}' class='radio' id='{$box_id}{$i}' value='{$key}' {$equals} {$style}/> {$value}&nbsp;</label>";
            }else{
                $equals = ($checked == $value) ? "checked='checked'" : "";
                $return_value .= "<label><input type='radio' name='{$box_id}' class='radio' id='{$box_id}{$i}' value='{$key}' {$equals} {$style}/> {$value}&nbsp;</label>";
            }
            $i++;
        }
        return $return_value;
    }
    public static function Create_Selectbox($box_name, $array, $selected="", $opt="", $opt_first="Y"){
        $option = "";
        if($opt_first == "Y")   $option = "<option value=''>--Option--</option>";
        foreach($array as $key => $value){
            $SELECTED = ($selected == $key) ? "selected" : "";
            $option .= "<option value='{$key}' {$SELECTED}>{$value}</option>";
        }
        $selectbox = "<select name='{$box_name}' id='{$box_name}' {$opt}>{$option}</select>";
        return $selectbox;

    }
};