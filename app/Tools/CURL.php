<?php
/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 8/30/2018
 * Time: 12:30 AM
 */
namespace App\Tools;
class CURL {
    var $callback = false;
    var $secure = false;
    var $conn = false;
    var  $cookiefile=false;

    var $img_get_src='/src=\s*"[^\"]*\"/is';
    var $href_get_src='/href=\s*\"[^\"]*\"/is';
    var $href_get_title='/title=\s*\"[^\"]*\"/is';
    var $reg_img="/<\s*img\s+[^>]*>/is";
    //var $cookiefile ="dirname(__FILE__).'/cookie.txt')";
    function setCallback($func_name) {
        $this->callback = $func_name;
    }

    function close() {
        curl_close($this->conn);
    }
    function doRequest($method, $url, $vars) {
        $this->conn = curl_init();
        $ch = $this->conn;

        $user_agent = "Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 6.1)";
        //curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);

        if($this->secure) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }


        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //var_dump(parse_url($m[1]));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //preg_match('/^Set-Cookie: (.*?);/m',curl_exec($ch),$m);
        //curl_setopt($ch, CURLOPT_COOKIEFILE,$this->cookiefile);
        //curl_setopt($ch, CURLOPT_COOKIEJAR,$this->cookiefile);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, count($vars));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        }
        $data = curl_exec($ch);
        if ($data) {
            if ($this->callback)
            {
                $callback = $this->callback;
                $this->callback = false;
                return call_user_func($callback, $data);
            } else {
                return $data;
            }
        } else {
            return curl_error($ch);
        }
    }

    function get($url) {
        return $this->doRequest('GET', $url, 'NULL');
    }

    function post($url, $vars) {
        return $this->doRequest('POST', $url, $vars);
    }

    /*Regex*/
    function remove_tag($text,$add_fist){
        $result='<p>'.$text.'</p>';
        $result=str_replace("&nbsp;"," ",$result);
        $result=preg_replace("/<!--[^(-->)].*-->/is","",$result);
        //Remove tag <tr> by </p><p>
        $result=preg_replace("/<\s*(\/)?tr[^\w^>]*[^>]*>/is","</p><p>",$result);
        //Remove tag <br> by </p><p>
        $result=preg_replace("/<\s*br\s*(\/)?[^>]*>/is","</p><p>",$result);
        //Remove tag <td> by "  "
        $result=preg_replace("/<\s*(\/)?td[^\w^>]*[^>]*>/is","  ",$result);
        //Remove all tag by empty
        $result=preg_replace("/<\s*(\/)?\s*(hr|!-*|meta|a|b|u|h\d|table|div|ul|li|select|option|span|font|tbody|strong|em|col|colgroup|iframe|center|header|footer|article|input)[^\w^>]*[^>]*(\/)?>/is","",$result);
        $result=preg_replace("/<\s*(\/)?\s*i>/is","",$result);
        $result=preg_replace("/<\s*col\s*(\/)?[^>]*\s*>/is","",$result);
        //Remove <script> tag
        $result= preg_replace('/<script[^>]*>[^<]*<\/script>/is', '', $result);
        $result= preg_replace('/<script[^>]*>[^<]*<![[]CDATA[^<]*<\/script>/is', '', $result);
        //Thêm mỗi thẻ </p> lẻ thẻ </p><p>, <p> lẻ thẻ </p><p>
        $result=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$result);
        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$result);
        $result=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$result);
        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);
        @preg_match_all($this->reg_img, $text, $match_img);
        $arr_img=$match_img[0];
        foreach($arr_img as $element_img){
            $text_img=$element_img;
            $text_img=str_replace("'",'"',$text_img);
            preg_match($this->img_get_src,$text_img,$match_img_e);
            $result=str_replace($element_img,'</p><img '.$match_img_e[0].' /><p>',$result);
        }
        /**
         * Kiểm tra có cặp thẻ <p></p> không chứa giá trị thì remove
         */
        $result=preg_replace("/<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>/is","</p><p>",$result);
        /**
         * Kiểm tra có cặp thẻ <p></p> trước thẻ <img
         * Nếu có, thay thế bằng thẻ </p>
         */
        $result=preg_replace("/<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<img/is","</p><img",$result);
        /**
         * Kiểm tra có cặp thẻ đóng /> sau đó là cặp thẻ <p></p>
         * Nếu có, thay thế bằng thẻ <p>
         */
        $result=preg_replace("/\/><p><\/p>/is","/><p>",$result);
        /**
         * Kiểm tra có thẻ <p> đứng đơn lẻ không
         * Nếu có, thêm vào trước thẻ </p> -> kết quả: </p><p>
         */
        preg_match("/[^>]\s*<p>/is",$result,$match_p);
        $match_p_replace=str_replace("<p>","</p><p>",$match_p[0]);
        $result=str_replace($match_p[0],$match_p_replace,$result);
        /**
         * Kiểm tra có thẻ </p> đứng đơn lẻ không
         * Nếu có, thêm vào sau thẻ <p> -> kết quả: </p><p>
         */
        preg_match("/<\/p>\s*[^<]/is",$result,$match_p);
        $match_p_replace=str_replace("</p>","</p><p>",$match_p[0]);
        $result=str_replace($match_p[0],$match_p_replace,$result);
        /**
         * Thêm vào đầu, cuối nội dung 2 thẻ <p> và </p>
         */
        $result='<p>'.$result.'</p>';
        /**
         * Lọc những cặp thẻ <p>*,</p>* lặp lại nhiều lần
         * để thay thế bằng 1 lần <p>,</p>
         */
        $result=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$result);
        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);
        $result=preg_replace("/'/is",'"',$result);
        $result=preg_replace("/\s+/is",' ',$result);
        if($add_fist!=''){
            $result=preg_replace("/src=\s*(\"|')\s*\//is",'src="'.$add_fist.'/',$result);
            $result=preg_replace("/src=\s*(\"|')\s*[.]+\//is",'src="'.$add_fist.'/',$result);
        }
        $result=preg_replace("/<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>/is","",$result);
        /** Một số trường hợp nhiều ảnh khi preg xong còn /></p><img src=...
         * Vì vậy remove </p> ở giữa đi
         */
        $result=preg_replace("/\/><\/?p><img/is","/><img",$result);
        return $result;
    }

    function remove_tag1($text){
        //$result='<p>'.$text.'</p>';
        $result=$text;
        $result=str_replace("&nbsp;"," ",$result);
        $result=preg_replace("/<!--[^(-->)].*-->/is","",$result);
        //Remove tag <tr> by </p><p>
        //$result=preg_replace("/<\s*(\/)?tr[^\w^>]*[^>]*>/is","</p><p>",$result);
        //Remove tag <br> by </p><p>
        $result=preg_replace("/<\s*br\s*(\/)?[^>]*>/is","</p><p>",$result);
        //Remove tag <td> by "  "
        //$result=preg_replace("/<\s*(\/)?td[^\w^>]*[^>]*>/is","  ",$result);
        //Remove all tag by empty
        $result=preg_replace("/<\s*(\/)?\s*(hr|!-*|meta|a|div|select|option|col|colgroup|iframe|header|footer|article|center|input)[^\w^>]*[^>]*(\/)?>/is","",$result);
        $result=preg_replace("/<\s*(\/)?\s*i>/is","",$result);
        $result=preg_replace("/<\s*col\s*(\/)?[^>]*\s*>/is","",$result);
        //Remove <script> tag
        $result= preg_replace('/<script[^>]*>[^<]*<\/script>/is', '', $result);
        $result= preg_replace('/<script[^>]*>[^<]*<![[]CDATA[^<]*<\/script>/is', '', $result);
        //Thêm mỗi thẻ </p> lẻ thẻ </p><p>, <p> lẻ thẻ </p><p>



      //  $result=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$result);
      //  $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$result);
     //   $result=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$result);

        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);

        @preg_match_all($this->reg_img, $text, $match_img);
        $arr_img=$match_img[0];
        foreach($arr_img as $element_img){
            $text_img=$element_img;
            $text_img=str_replace("'",'"',$text_img);
            $count_match_e=preg_match($this->img_get_src,$text_img,$match_img_e);
            if($count_match_e>0):
            $result=str_replace($element_img,'</p><img '.$match_img_e[0].' /><p>',$result);
            endif;
        }
        /**
         * Kiểm tra có cặp thẻ <p></p> không chứa giá trị thì remove
         */
        $result=preg_replace("/<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>/is","</p><p>",$result);
        /**
         * Kiểm tra có cặp thẻ <p></p> trước thẻ <img
         * Nếu có, thay thế bằng thẻ </p>
         */
        $result=preg_replace("/<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<img/is","</p><img",$result);
        /**
         * Kiểm tra có cặp thẻ đóng /> sau đó là cặp thẻ <p></p>
         * Nếu có, thay thế bằng thẻ <p>
         */
        $result=preg_replace("/\/><p><\/p>/is","/><p>",$result);
        /**
         * Kiểm tra có thẻ <p> đứng đơn lẻ không
         * Nếu có, thêm vào trước thẻ </p> -> kết quả: </p><p>
         */
        /**
         * Kiểm tra có thẻ </p> đứng đơn lẻ không
         * Nếu có, thêm vào sau thẻ <p> -> kết quả: </p><p>
         */
        /**
         * Thêm vào đầu, cuối nội dung 2 thẻ <p> và </p>
         */
        $result='<p>'.$result.'</p>';
        /**
         * Lọc những cặp thẻ <p>*,</p>* lặp lại nhiều lần
         * để thay thế bằng 1 lần <p>,</p>
         */



    /*News
        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);
    */
        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);
        $result=preg_replace("/'/is",'"',$result);
        $result=preg_replace("/\s+/is",' ',$result);
        $result=preg_replace("/<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>/is","",$result);

        /** Một số trường hợp nhiều ảnh khi preg xong còn /></p><img src=...
         * Vì vậy remove </p> ở giữa đi
         */
        $result=preg_replace("/\/><\/?p><img/is","/><img",$result);
        return $result;
    }
    function remove_fix($text){
        //$result='<p>'.$text.'</p>';
        $result=$text;
        $result=str_replace("&nbsp;"," ",$result);
        $result=preg_replace("/<!--[^(-->)].*-->/is","",$result);
        //Remove tag <tr> by </p><p>
        //$result=preg_replace("/<\s*(\/)?tr[^\w^>]*[^>]*>/is","</p><p>",$result);
        //Remove tag <br> by </p><p>
        $result=preg_replace("/<\s*br\s*(\/)?[^>]*>/is","</p><p>",$result);
        //Remove tag <td> by "  "
        //$result=preg_replace("/<\s*(\/)?td[^\w^>]*[^>]*>/is","  ",$result);
        //Remove all tag by empty
        $result=preg_replace("/<\s*(\/)?\s*(hr|!-*|meta|div|select|option|col|colgroup|iframe|header|footer|input)[^\w^>]*[^>]*(\/)?>/is","",$result);
        $result=preg_replace("/<\s*(\/)?\s*i>/is","",$result);
        $result=preg_replace("/<\s*col\s*(\/)?[^>]*\s*>/is","",$result);
        //Remove <script> tag
        $result= preg_replace('/<script[^>]*>[^<]*<\/script>/is', '', $result);
        $result= preg_replace('/<script[^>]*>[^<]*<![[]CDATA[^<]*<\/script>/is', '', $result);
        //Thêm mỗi thẻ </p> lẻ thẻ </p><p>, <p> lẻ thẻ </p><p>



        //  $result=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$result);
        //  $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$result);
        //   $result=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$result);

        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);

        @preg_match_all($this->reg_img, $text, $match_img);
        $arr_img=$match_img[0];
        foreach($arr_img as $element_img){
            $text_img=$element_img;
            $text_img=str_replace("'",'"',$text_img);
            $count_match_e=preg_match($this->img_get_src,$text_img,$match_img_e);
            if($count_match_e>0):
                $result=str_replace($element_img,'</p><img '.$match_img_e[0].' /><p>',$result);
            endif;
        }
        /**
         * Kiểm tra có cặp thẻ <p></p> không chứa giá trị thì remove
         */
        $result=preg_replace("/<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>/is","</p><p>",$result);
        /**
         * Kiểm tra có cặp thẻ <p></p> trước thẻ <img
         * Nếu có, thay thế bằng thẻ </p>
         */
        $result=preg_replace("/<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<img/is","</p><img",$result);
        /**
         * Kiểm tra có cặp thẻ đóng /> sau đó là cặp thẻ <p></p>
         * Nếu có, thay thế bằng thẻ <p>
         */
        $result=preg_replace("/\/><p><\/p>/is","/><p>",$result);
        /**
         * Kiểm tra có thẻ <p> đứng đơn lẻ không
         * Nếu có, thêm vào trước thẻ </p> -> kết quả: </p><p>
         */
        /**
         * Kiểm tra có thẻ </p> đứng đơn lẻ không
         * Nếu có, thêm vào sau thẻ <p> -> kết quả: </p><p>
         */
        /**
         * Thêm vào đầu, cuối nội dung 2 thẻ <p> và </p>
         */
        $result='<p>'.$result.'</p>';
        /**
         * Lọc những cặp thẻ <p>*,</p>* lặp lại nhiều lần
         * để thay thế bằng 1 lần <p>,</p>
         */



        /*News
            $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);
        */
        $result=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$result);
        $result=preg_replace("/'/is",'"',$result);
        $result=preg_replace("/\s+/is",' ',$result);
        $result=preg_replace("/<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>/is","",$result);

        /** Một số trường hợp nhiều ảnh khi preg xong còn /></p><img src=...
         * Vì vậy remove </p> ở giữa đi
         */
        $result=preg_replace("/\/><\/?p><img/is","/><img",$result);
        return $result;
    }
    function remove_all_tag($text){
        $result=str_replace("'",'"',$text);
        $result=preg_replace("/'/is",'"',$result);
        $result=preg_replace("/<!--[^(-->)].*-->/is","",$result);
        $result=preg_replace("/<\s*(a|b|i|img|u|h\d|table|tr|td|div|ul|li|select|option|span|font|tbody|strong|em|col|colgroup|iframe|center|header|footer|article|p)[^\w^>]*[^>]*>/is"," ",$result);
        $result=preg_replace("/<\s*\/\s*(a|b|i|img|u|h\d|table|tr|td|div|ul|li|select|option|span|font|tbody|strong|em|colgroup|iframe|center|header|footer|article|p)[^\w^>]*[^>]*>/is"," ",$result);
        $result=preg_replace("/<\s*col\s*(\/)?[^>]*\s*>/is"," ",$result);
        //Remove <script> tag
        $result= preg_replace('/<script[^>]*>[^<]*<\/script>/is', '', $result);
        $result= preg_replace('/<script[^>]*>[^<]*<![[]CDATA[^<]*<\/script>/is', '', $result);

        $result=preg_replace("/<\s*br\s*(\/)?[^>]*>/is"," ",$result);
        $result=preg_replace("/'/is",'"',$result);
        $result=preg_replace("/\s+/is",' ',$result);
        $result=preg_replace("/<[<]*\d\s*$/is",'',$result);
        return $result;
    }
    //------------------------------------get img src------------------------------------
    function get_img_src($text,$add_fist){
        $text_img=str_replace("'",'"',$text);
        preg_match($this->img_get_src, $text_img, $match_img);
        if(count($match_img)>0):
            $result=preg_replace("/src=\s*|\s*\"/is","",$match_img[0]);
            return $add_fist!=''?$add_fist.$result:$result;
        else:
            preg_match('/src=([^"]*).(?:jpg|bmp|gif|png)/i', $text_img, $match_img);
            if(count($match_img)>0):
                $result=preg_replace("/src=\s*|\s*\"/is","",$match_img[0]);
                return $add_fist!=''?$add_fist.$result:$result;
            else:
                return '';
            endif;
        endif;
    }

    //------------------------------------get href in a------------------------------------
    function get_href_src($text,$add_fist){
        $text_img=str_replace("'",'"',$text);
        preg_match($this->href_get_src, $text_img, $match_img);
        if(count($match_img)>0):
            $result=preg_replace("/href=\s*|\s*\"/is","",$match_img[0]);
            return $add_fist!=''?$add_fist.$result:$result;
        else:
            preg_match('/href=\s*(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU', $text_img, $match_img);
            if(count($match_img)>0):
                //print_r($match_img);
                //echo $match_img[0]."Q===========<br/>";
                //$result=preg_replace("/href=\s*|\s*\"/is","",$match_img[0]);
                $result=$match_img[2];
                //echo $result."A===========<br/>";
                return $add_fist!=''?$add_fist.$result:$result;
            else:
                return '';
            endif;
        endif;
    }
    //------------------------------------get title in a------------------------------------
    function get_title_src($text){
        $text_img=str_replace("'",'"',$text);
        preg_match($this->href_get_title, $text_img, $match_img);
        if(count($match_img)>0):
            $result=preg_replace("/title=\s*|\s*\"/is","",$match_img[0]);
            return $result;
        else:
            return '';
        endif;
    }
    //-----------------------------------remove tag a-------------------------------------------
    function remove_tag_a($text){
        $result=$text;
        $result=preg_replace("/<\s*a\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/a\s*>/is","",$result);
        return $result;
    }
    //-----------------------------------remove tag ul-------------------------------------------
    function remove_tag_ul($text){
        $result=$text;
        $result=preg_replace("/<\s*ul\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/ul\s*>/is","",$result);
        $result=preg_replace("/<\s*li\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/li\s*>/is","",$result);
        return $result;
    }

    //-----------------------------------remove tag a-------------------------------------------
    function remove_tag_h($text){
        $result=$text;
        $result=preg_replace("/<\s*h\d\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/h\d\s*>/is","",$result);
        return $result;
    }
    //-----------------------------------remove tag p-------------------------------------------
    function remove_tag_p($text){
        $result=$text;
        $result=preg_replace("/<\s*p\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/p\s*>/is","",$result);
        return $result;
    }
    //-----------------------------------remove img---------------------------------------------
    function remove_tag_img($text){
        $result=$text;
        $result=preg_replace("/<\s*img\s*[^>]*>/is","",$result);
        return $result;
    }
    //-----------------------------------remove div---------------------------------------------
    function remove_tag_div($text){
        $result=$text;
        //$result=preg_replace("/<\s*div[^>]*>/is","",$result);
        //$result=preg_replace("/<\s*\/div\s*>/is","",$result);
        $result=preg_replace("/<\s*(\/)?\s*(hr|!-*|div)[^\w^>]*[^>]*(\/)?>/is","",$result);
        return $result;
    }
    //-----------------------------------remove b---------------------------------------------
    function remove_tag_b($text){
        $result=$text;
        $result=preg_replace("/<\s*b\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/b\s*>/is","",$result);
        return $result;
    }
    //-----------------------------------remove b---------------------------------------------
    function remove_tag_script($text){
        $result=$text;
        $result=preg_replace("/<\s*script\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/script\s*>/is","",$result);
        return $result;
    }
    //-----------------------------------remove b---------------------------------------------
    function remove_tag_iframe($text){
        $result=$text;
        $result=preg_replace("/<\s*iframe\s*[^>]*>/is","",$result);
        $result=preg_replace("/<\s*\/iframe\s*>/is","",$result);
        return $result;
    }
    //-----------------------------------remove by regex------------------------------------------
    function remove_by_regex($text,$regex,$change_by){
        $result=preg_replace($regex,$change_by,$text);
        $result=preg_replace("/(<\s*p\s*>\s*)+/is",'<p>',$result);
        $result=preg_replace("/(<\s*\/\s*p\s*>\s*)+/is",'</p>',$result);
        return $result;
    }
    //------------------------------------remove quote------------------------------------
    function remove_quote($text){
        $result=str_replace("'",'"',$text);
        $result=preg_replace("/'/is",'"',$result);
        return $result;
    }
    //------------------------------------Sosanh 2 chuoi------------------------------------------
    function compare_string($str,$str_compare){//Chú ý: giá trị của $str_compare có thể '' còn $str phải có giá trị
        if($str==$str_compare)	return TRUE;
        //$str1=str_replace(" ","",$str);
        //$str2=str_replace(" ","",$str_compare);
        //$str1=preg_replace("/\s/is","",$str1);
        $str1=$this->slug_title($str);
        $str2=$this->slug_title($str_compare);
        //$str2=preg_replace("/\s/is","",$str2);
        if($str1==$str2) return TRUE;
        $str1= $this->vn_realtext($str);
        $str2= $this->vn_realtext($str_compare);
        if($str1==$str2) return TRUE;
        return FALSE;
    }
    //------------------------------------Check Url------------------------------------------
    function validate_url($url) {
        $path = parse_url($url, PHP_URL_PATH);
        $encoded_path = array_map('urlencode', explode('/', $path));
        $url = str_replace($path, implode('/', $encoded_path), $url);
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
    function spaces_url($url){
        $parts = parse_url($url);
        $path_parts = array_map('rawurldecode', explode('/', $parts['path']));

        return
            $parts['scheme'] . '://' .
            $parts['host'] .
            implode('/', array_map('rawurlencode', $path_parts))
            ;
    }
}