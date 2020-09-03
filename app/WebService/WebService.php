<?php

namespace App\WebService;
use App\Helpers;
use App\Options;
use App\Model\Page;
use App\Model\Category;
use App\Model\Sim;
use Illuminate\Pagination\Paginator;
use DB,Pusher,Session,Route,HTML;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Image, URL,Config;
use Auth,QrCode,Mail;
use App\User;
use Illuminate\Support\Str;
use App\myHelper;
use Jenssegers\Agent\Agent;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler,Storage;

class WebService {
    // SEO
    public function getSEO($data = array()){
        $seo = array();
        $seo['title'] = $data['title'];
        $seo['keywords'] = $data['keywords'];
        $seo['description'] = $data['description'];
        $seo['og_title'] = $data['og_title'];
        $seo['og_description'] = $data['og_description'];
        $seo['og_url'] = str_replace('http','https',$data['og_url']);
        $seo['og_img'] = $data['og_img'];
        $seo['current_url'] = $data['current_url'];
        $seo['current_url_amp'] = $data['current_url_amp'];
        return $seo;
    }//end function
    public function amp_html($html){
      return \App\myHelper::ampify($html);
    }
    public function get_sidebar_simphongthuy_hop_menh(){
      $items = DB::table('sim_fate')->where('status',1)->orderBy('weight','asc')->get();
      $html='';
      $html.='<div class="sims_categories sub_block" id="sims_group_3">
         <div class="sub_block_title cat_title_block" data-id="id_fengshui_1" id="sub_block_title">
            <div class="normal"><span>Sim hợp mệnh</span></div>
         </div>
         <div class="fillter_categories_label" id="id_fengshui_1">
            <div class="wrapper_head scroll_manu">';
            if(count($items)>0){
              foreach ($items as $key => $item) {
                $href = route('home.sim_phong_thuy_filter',array($item->slug));
                $html.='<div class="filter_item ">
                  <div class="filter_item_inner">
                     <a href="'.$href.'" title="'.$item->name_sim_fate.'" class="feng_1">
                        <!-- <span class=check_box></span> -->
                        <span>'.$item->name_sim_fate.'</span>
                     </a>
                  </div>
               </div>';
              }
            }
              $html.= '
            </div>
            <div class="clear"></div>
         </div>
         <!-- end .sims_categories_label  -->
         <div class="clear"></div>
      </div>';
      return $html;
    }
    public function get_sidebar_simphongthuy_hop_tuoi(){
      $items = DB::table('sim_age')->where('status',1)->orderBy('weight','asc')->get();
      $html='';
      $html.='<div class="sims_categories sub_block" id="sims_group_3">
         <div class="sub_block_title cat_title_block" data-id="id_fengshui_1" id="sub_block_title">
            <div class="normal"><span>Sim hợp Tuổi</span></div>
         </div>
         <div class="fillter_categories_label" id="id_fengshui_1">
            <div class="wrapper_head scroll_manu">';
            if(count($items)>0){
              foreach ($items as $key => $item) {
                $href = route('home.sim_phong_thuy_filter',array($item->slug));
                $html.='<div class="filter_item ">
                  <div class="filter_item_inner">
                     <a href="'.$href.'" title="'.$item->name_sim_age.'" class="feng_1">
                        <!-- <span class=check_box></span> -->
                        <span>'.$item->name_sim_age.'</span>
                     </a>
                  </div>
               </div>';
              }
            }
              $html.= '
            </div>
            <div class="clear"></div>
         </div>
         <!-- end .sims_categories_label  -->
         <div class="clear"></div>
      </div>';
      return $html;
    }
    public function get_sidebar_simphongthuy_hop_namsinh(){
      $items = DB::table('sim_year')->where('status',1)->orderBy('id','desc')->get();
      $html='';
      $html.='<div class="sims_categories sub_block" id="sims_group_3">
         <div class="sub_block_title cat_title_block" data-id="id_fengshui_1" id="sub_block_title">
            <div class="normal"><span>Sim hợp Năm Sinh</span></div>
         </div>
         <div class="fillter_categories_label" id="id_fengshui_1">
            <div class="wrapper_head scroll_manu">';
            if(count($items)>0){
              foreach ($items as $key => $item) {
                $href = route('home.sim_phong_thuy_filter',array($item->slug));
                $html.='<div class="filter_item ">
                  <div class="filter_item_inner">
                     <a href="'.$href.'" title="'.$item->name_sim_year.'" class="feng_1">
                        <!-- <span class=check_box></span> -->
                        <span>'.$item->name_sim_year.'</span>
                     </a>
                  </div>
               </div>';
              }
            }
              $html.= '
            </div>
            <div class="clear"></div>
         </div>
         <!-- end .sims_categories_label  -->
         <div class="clear"></div>
      </div>';
      return $html;
    }
    //
    public function get_bottom_related_simphongthuy(){
      $html='';
      $items = DB::table('sim_year')->where('status',1)->orderBy('weight','desc')->get();
      if(count($items)>0):
      $html.=' <div class="pos_fengshui1">
                     <div class="block_fengshui pos_fengshui1 clearfix">
                        <div class="fengshui_year">';
                        foreach ($items as $key => $item) {
                          $href = route('home.sim_phong_thuy_filter',array($item->slug));
                         $html.= '<a href="'.$href.'" title="'.$item->name_sim_year.'">'.$item->name_sim_year.'</a>';
                        }
                           
                           $html.='
                        </div>
                     </div>
                  </div>';
                  endif;
                  return $html;
    }
    public function sim_phong_thuy($id_sim){
      $info = Sim::find($id_sim);
      $client = new Client();
      $client->setClient(new GuzzleClient(array(
              // DISABLE SSL CERTIFICATE CHECK
              'verify' => false,
          )));
        $number_sim = $item_sim->number_sim;

      $link = 'https://muasim.com.vn/sim-phong-thuy/dien-giai-'.$number_sim.'/1-1-1959-nam-0.html';
      $crawler = $client->request('GET',$link);
      $client->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
      $client->setHeader('Referer', 'https://muasim.com.vn/sim-phong-thuy/01-01-1959-nam-0.html');
      $client->setHeader('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9');
      if($crawler->filter('.content_result')->count()>0){
          $detail_replace = $crawler->filter('.content_result')->eq('0')->html();
          $detail_replace = preg_replace('/<div class="point_center">([\s\S]*?)<\/div>/', '', $detail_replace);
          preg_match_all('/src\=\"([^\"]+)/', $detail_replace, $content_image);
          $count_img = count($content_image[1]);
          // replace hinh anh
          for ($k=0; $k < $count_img; $k++) { 
              $url =  @$content_image[1][$k];
              $arr_image = explode('/',$url);
              // lay ten anh
              preg_match_all('/[^\/]+.(gif|jpe?g|tiff|png|webp|bmp)/', $content_image[1][$k], $output_array);
              $images = @$output_array[0][0];
              Storage::disk('public')->put('upload/'.$images, file_get_contents(@$url));
              $image_current = ('storage/app/public/upload/'.$images);
              $patterns = '('.$content_image[1][$k].')';
              if($k==0){
                  $detail_replace = str_replace($content_image[1][$k],'/'.$image_current,$detail_replace);
                  $detail_replace_current = preg_replace($patterns, '/'.$image_current, $detail_replace);
              }else{
                  $detail_replace = str_replace($content_image[1][$k],'/'.$image_current,$detail_replace);
                  $detail_replace_current = preg_replace($patterns, '/'.$image_current, $detail_replace);
              }
          }
          // diem so cua sim theo nam
          $point_center = $crawler->filter('.point_center .text-back-d')->eq('0')->html();
          $info->update([
              'content'=>$detail_replace_current,
              'point_sim'=>$point_center,
          ]);
        }
    }
    public function get_data_simphongthuy($data,$type=''){
      $html='';
      $html.=' <div class="div_sim">
                 <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                       <tr class="tr_header_sim" align="center">
                       </tr>
                       <tr class="tr_header_sim" align="center">
                          <th class="th_stt">
                             <div class="stt"><strong>Stt</strong></div>
                          </th>
                          <th>
                             <div class="number">
                                Số sim
                             </div>
                          </th>
                          <th nowrap="nowrap">
                             <div class="price">
                                <span class="table_title_threshold_pr"><span>Giá bán</span></span>
                             </div>
                          </th>
                          <th nowrap="nowrap" class="manu_mb">
                             <div class="manu"><strong>Mạng</strong></div>
                          </th>
                          <th nowrap="nowrap">
                             <div class="manu"><strong>Điểm</strong></div>
                          </th>
                          <th nowrap="nowrap">
                             <div class="category"><strong>Diễn giải</strong></div>
                          </th>
                          <th nowrap="nowrap" class="manu_mb">
                             <div class="category"><strong>Mua ngay</strong></div>
                          </th>
                       </tr>';
                       if(count($data)>0):
                         $i=0;
                        foreach ($data as $key => $item) {
                           $i++;
                   $number_sim_tring = $item->number_sim_tring;
                    $sim_int = $item->number_sim;
                     $genre =  (self::get_name_regex_genre($item->id_genre_min));
                     // check thể loại sim
                     $regex = $genre->regex;
                     $number_sim_tring = \App\myHelper::check_regex_number_string($regex,$sim_int,$number_sim_tring);
                        $image_cat = $item->image_cat;
                       // lay the loai sim
                  // check bg_0
                  $bg = $i%2==1 ? 'bg_1' : 'bg_0'; 
                  $diengiai = route('home.diengiai_simphongthuy',array($sim_int,$type));
                  $href = route('single_sim.list',$sim_int);
                       $html.='<tr class="tr_sim bg_0" align="center">
                          <td class="item_stt">
                             <div>1</div>
                          </td>
                          <td class="item_number" align="left">
                             <div>
                                <a class="modal" href="'.$href.'" rel="">'.$number_sim_tring.'</a>
                             </div>
                          </td>
                          <td class="price" align="right">
                             <div>
                                <span>'.myHelper::convert_money($item->price).'</span>
                             </div>
                          </td>
                          <td class="tr_sim manu_mb color_4">
                             <span class="image" style="background: url(/uploads/'.$image_cat.') no-repeat center center;background-size: contain;"></span>
                          </td>
                          <td class="tr_sim_point" align="right">
                             <span class="point_feng">'.$item->point_sim.'/10 điểm</span>
                          </td>
                          <td>
                             <div class="view_pt_area">
                                <a href="'.$diengiai.'" title="Xem điểm phong thủy" class="view_pt">
                                <span>Xem diễn giải</span>
                                </a>
                             </div>
                          </td>
                          <td class="tr_buy_now">
                             <a href="'.$href.'" title="'.$sim_int.'">Mua sim</a>
                          </td>
                       </tr>';
                        }

                       endif;
                       
          $html.='</tbody>
                 </table>
              </div>';
              $html.=$data->links();
      return $html;
    }
    // end sim phong thuy
    public function get_slug_page($id_page){
        $slug = '';
        $page = Page::find($id_page);
        if(count($page)>0){
          return '<a href="'.URL::to($page->slug).'" title="'.$page->title.'">'.$page->title.'</a>';
        }else
          return '';
    }
    public function get_name_page($id_page,$type=''){
        $name = '';
        $page = Page::find($id_page);
        if(count($page)>0){
          $name = ($type=='title') ? $page->title : URL::to($page->slug);
          return $name;
        }else
          return '';
    }
    
    public function get_image_qrcode($total){
        return URL::to('qr_momo?total='.$total);
    }
    public function get_name_regex_genre($id)
    {
      try{
        $item = DB::table('sim_genre')->where('id',$id)->first();
        $obj = (object) ['name_genre'=>$item->name_genre,'regex'=>$item->regex];
       return $obj;
      }catch (\Exception $e) {
       echo  $e->getMessage();
            // Handle the current node list is empty..
        }
    }
    public function get_image_sim($image = '',$phonesim,$price_int,$type,$theloaisim){
       try{
      if($image==''){
        return app('App\Http\Controllers\ImageController')->get_image($phonesim,$price_int,$type,$theloaisim);
      }else{
        return $image;
      }
      }catch (\Exception $e) {
        echo $e->getMessage();
            // Handle the current node list is empty..
        }
    }
    //dat sim sidebar moi nhat
    public function order_sim_lastest(){
       $html='';
       // lay ra 6 khách hàng mới đắtj
       $items = DB::table('sim_order')->where('status',1)->orderBy('id','desc')->limit(6)->get();
       if(!empty($items)):
       $html.='<div class="block_order order-_order order_2 block" id="block_id_194">
           <div class="search_field">
              <div class="sub_block_title sale_sim_list service-sim" data-id="id_order">
                 <div class="normal"><span>Đơn đặt hàng mua sim</span></div>
              </div>
              <div class="fillter_categories_label">
                 <div class="wrapper_sale scroll_manu" id="id_order">';
                 foreach ($items as $key => $value) {
                  $phone_sim = $value->phone_sim;
                  $phone_sim = substr($phone_sim, 0,6).'..'.substr($phone_sim, 8,2);

                   $html.='
                    <div class="sale_item block_order_item flex-view">
                       <div class="name">
                          <div class="order_item">'.$value->name_customer.'</div>
                       <div class="order_sim">Đặt Sim: '.$phone_sim.'</div>
                       </div>
                       <div class="status_sim">Mới Đặt</div>
                    </div>
                    ';
                 }
                    $html.='
                 </div>
                 <!-- end .sims_categories_label  -->
              </div>
           </div>
        </div>';
      endif;
       return $html;
    }
    public function menu_sim_genre(){
      try{
          $html='';
          $html.='<ul class="child-item cls">';
          $items = DB::table('sim_genre')->where('status',1)->orderBy('weight','asc')->get();
          if(!empty($items)){
            foreach ($items as $key => $value) {
              $html.='<li><a href="'.route('category.list_slug1',array($value->slug)).'" title="'.$value->name_genre.'">'.$value->name_genre.'</a></li>';
            }
                           $html.='</ul>';

          }
          return $html;
      }catch (\Exception $e) {
        $e->getMessage();
            // Handle the current node list is empty..
        }
    }
    public function price_range_category($type='',$slug1 = '',$slug2='')
    {
      $html='';
      if($type!='price'):
      $items = DB::table('sim_price_range')->orderBy('weight','asc')->get();
      $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn khoảng giá:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      // check active
                     $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                      $href=route('category.list_slug2',array($slug1,$value->slug));
                     $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_price_range.'">'.$value->name_price_range.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';
        endif;
          return $html;
    }
    public function price_range_category_slug2($type='',$slug1 = '',$slug2='')
    {
      $html='';

      if($type!='price'):
      $items = DB::table('sim_price_range')->orderBy('weight','asc')->get();
      $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn khoảng giá:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      // check active
                     $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                     
                      $href=route('category.list_slug2',array($slug1,$value->slug));
                      // truong slug cung truong thi slug2 còn khac thi slug3
          
                      $first = DB::table('sim_price_range')->where('slug',$slug2)->first();
                      if($first){
                        $href=route('category.list_slug2',array($slug1,$value->slug));
                      }else{
                       $href=route('category.list_slug3',array($slug1,$slug2,$value->slug));

                      }
                      // neu truong hop dang active thi tro ve slug truoc
                    if($active=='active_rm'){
                       $href=route('category.list_slug1',array($slug1));
                    }
                     $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_price_range.'">'.$value->name_price_range.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';
        endif;
          return $html;
    }
    public function price_range_category_slug3($type='',$slug1 = '',$slug2='',$slug3='')
    {
      $html='';

      if($type!='price'):
      $items = DB::table('sim_price_range')->orderBy('weight','asc')->get();
      $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn khoảng giá:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      // check active
                      $info = DB::table('sim_category_network')->where('slug',$slug1)->first();
                      if($info):
                          $active =  (strpos($slug3,$value->slug) !== false) ? 'active_rm' : '';
                          $href=route('category.list_slug3',array($slug1,$slug2,$value->slug));
                         // neu truong hop dang active thi tro ve slug truoc
                          if($active=='active_rm'){
                             $href=route('category.list_slug2',array($slug1,$slug2));
                          }
                      endif;
                      $info = DB::table('sim_genre')->where('slug',$slug1)->first();
                      if($info):
                      $active =  (strpos($slug3,$value->slug) !== false) ? 'active_rm' : '';
                      $href=route('category.list_slug4',array($slug1,$slug2,$slug3,$value->slug));
                      // neu truong hop dang active thi tro ve slug truoc
                    if($active=='active_rm'){
                       $href=route('category.list_slug3',array($slug1,$slug2,$slug3));
                    }
                  endif;
                     $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_price_range.'">'.$value->name_price_range.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';
        endif;
          return $html;
    }
    // chon nha mang
    public function category_network_category($type='',$slug1 = '',$slug2=''){
      $html='';
      if($type!='category_network'):
      $items = DB::table('sim_category_network')->where('status',1)->orderBy('weight','asc')->get();

      $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn nhà mạng:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      $href=route('category.list_slug2',array($slug1,$value->slug));
                      $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                     $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_network.'">'.$value->name_network.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';
        endif;
          return $html;
    }
    public function category_network_category_slug2($type='',$slug1 = '',$slug2=''){
      $html='';
      if($type!='category_network'):
      $items = DB::table('sim_category_network')->where('status',1)->orderBy('weight','asc')->get();
      $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn nhà mạng:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      $href=route('category.list_slug2',array($slug1,$value->slug));
                      $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                      // truong slug cung truong thi slug2 còn khac thi slug3
          
                      $first = DB::table('sim_category_network')->where('slug',$slug2)->first();
                      if($first){
                        $href=route('category.list_slug2',array($slug1,$value->slug));
                      }else{
                       $href=route('category.list_slug3',array($slug1,$value->slug,$slug2));

                      }
                      // neu truong hop dang active thi tro ve slug truoc
                      if($active=='active_rm'){
                         $href=route('category.list_slug1',array($slug1));
                      }
                     $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_network.'">'.$value->name_network.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';
        endif;
          return $html;
    }
    public function slug4_list_filter($type='',$slug1 = '',$slug2='',$slug3='',$slug4){
      $html='';
    $info=  DB::table('sim_category_network')->where('slug',$slug2)->first();
     $items = DB::table('sim_section')->where('status',1)->where('parent_id',0)->where('id_category','!=',6)->groupBy('number_section')->orderBy('number_section','desc');
        if($info->id!=0){
         $items = $items->where('id_category',$info->id)->get();
        }else{
          $items = $items->get();
        }
        $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Đầu số:</span>';
            if(!empty($items)){
              foreach ($items as $value) {
                $href = route('category.list_slug4',array($slug1,$slug2,$value->slug,$slug4));
               $active =  (strpos($slug3,$value->slug) !== false) ? 'active_rm' : '';
             
                $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->number_section.'">'.$value->number_section.'</a>';
              }
            }
           $html.='
             </div>
          </div>';
          $items = DB::table('sim_category_network')->where('status',1)->orderBy('weight','asc')->get();
          $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn nhà mạng:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                       $href=route('category.list_slug4',array($slug1,$value->slug,$slug3,$slug4));
                      // neu truong hop dang active thi tro ve slug truoc
                      if($active=='active_rm'){
                         $href=route('category.list_slug3',array($slug1,$slug2,$slug3));
                      }
                     $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_network.'">'.$value->name_network.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';

$items = DB::table('sim_price_range')->orderBy('weight','asc')->get();
      $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn khoảng giá:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      // check active
                      $active =  (strpos($slug4,$value->slug) !== false) ? 'active_rm' : '';
                      $href=route('category.list_slug4',array($slug1,$slug2,$slug3,$value->slug));
                      // neu truong hop dang active thi tro ve slug truoc
                      if($active=='active_rm'){
                         $href=route('category.list_slug3',array($slug1,$slug2,$slug3));
                      }
                      $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_price_range.'">'.$value->name_price_range.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';
          return $html;
    }
    public function category_network_category_slug3($type='',$slug1 = '',$slug2='',$slug3=''){
      $html='';
      if($type!='category_network'):
      $items = DB::table('sim_category_network')->where('status',1)->orderBy('weight','asc')->get();
      $html.='<div class="search_field">
             <div id="head-select">
                <span class="stitle">Chọn nhà mạng:</span>';
                  if(count($items)>0){
                    foreach ($items as  $value) {
                      $href=route('category.list_slug2',array($slug1,$value->slug));
                      $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                      if($slug2!=''){
                         $href=route('category.list_slug3',array($slug1,$value->slug,$slug3));
                      }
                      // neu truong hop dang active thi tro ve slug truoc
                      if($active=='active_rm'){
                         $href=route('category.list_slug2',array($slug1,$slug2));
                      }
                     $html.='<a href="'.$href.'" class="'.$active.'" title="'.$value->name_network.'">'.$value->name_network.'</a>';
                    }
                  }
                $html.='
             </div>
          </div>';
        endif;
          return $html;
    }

    // dau so cua sim
    public function dauso($slug_cat="",$id_category="",$slug2=''){
      $html='';
      if($id_category>0){
        $items = DB::table('sim_section')->where('id_category',$id_category)->where('parent_id','!=',0)->where('status',1)->orderBy('weight','asc')->get();
        $html.='<div class="view_search_more"><div class="title"><span></span>Xem thêm</div><div class="sims_tags"><span>';
            if(!empty($items)){
              foreach ($items as $value) {
                $href = route('category.list_slug2',array($slug_cat,$value->slug));
               $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                $html.='<a class="'.$active.'" href="'.$href.'" title="'.$value->number_section.'">'.$value->number_section.'*</a>';
              }
            }
           $html.='</span><div class="clear"></div>
                  </div></div>';
      }
      
      return $html;
    }
    public function dauso_first_name($type='',$slug_cat="",$id_category="",$slug1='',$slug2=''){
      $html='';
      if($type=='category_price_range' || $type=='category_genre'){
        // lay items cua cac dau so neu hien thi trong trang loai gia
        $items = DB::table('sim_section')->where('status',1)->where('parent_id',0)->where('id_category','!=',6)->groupBy('number_section')->orderBy('number_section','desc')->get();
        
    }else if($type=='category_network'){
      $items = DB::table('sim_section')->where('status',1)->where('id_category',$id_category)->where('parent_id',0)->where('id_category','!=',6)->groupBy('number_section')->orderBy('number_section','desc')->get();
    }
    
     if(!empty($items)){
        $html.='<div class="search_field">
    <div id="head-select">
      <span class="stitle">Chọn đầu số:</span>';
      foreach ($items as $key => $value) {
        $href=route('category.list_slug2',array($slug1,$value->slug));
         $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
       $html.='<a class="'.$active.'" href="'.$href.'" class="" title="'.$value->number_section.'">'.$value->number_section.'</a>';
      }
        $html.='
      </div> 
</div>';
      }
      return $html;
    }
    public function dauso_slug2_first_name($type='',$slug_cat="",$id_category="",$slug1='',$slug2=''){
      $html='';
      $items = DB::table('sim_section')->where('status',1)->where('parent_id',0)->where('id_category','!=',6)->groupBy('number_section')->orderBy('number_section','desc');
        if($id_category!=0){
         $items = $items->where('id_category',$id_category)->get();
        }else{
          $items = $items->get();
        }
     if(!empty($items)){
        $html.='<div class="search_field">
    <div id="head-select">
      <span class="stitle">Chọn đầu số:</span>';
      foreach ($items as $key => $value) {
        $info = DB::table('sim_category_network')->where('slug',$slug1)->first();
        if($info):
          $href=route('category.list_slug2',array($slug1,$value->slug));
          $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
          // truong slug cung truong thi slug2 còn khac thi slug3

          $first = DB::table('sim_section')->where('slug',$slug2)->first();
          if($first){
            $href=route('category.list_slug2',array($slug1,$value->slug));
          }else{
           $href=route('category.list_slug3',array($slug1,$value->slug,$slug2));

          }
          // neu truong hop dang active thi tro ve slug truoc
          if($active=='active_rm'){
             $href=route('category.list_slug1',array($slug1));
          }
        endif;
        $info = DB::table('sim_price_range')->where('slug',$slug1)->first();
        if($info):
          $href=route('category.list_slug2',array($slug1,$value->slug));
          $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
          // truong slug cung truong thi slug2 còn khac thi slug3

          $first = DB::table('sim_section')->where('slug',$slug2)->first();
          if($first){
            $href=route('category.list_slug2',array($slug1,$value->slug));
          }else{
           $href=route('category.list_slug3',array($slug1,$slug2,$value->slug));

          }
          // neu truong hop dang active thi tro ve slug truoc
          if($active=='active_rm'){
             $href=route('category.list_slug1',array($slug1));
          }
        endif;
        $info = DB::table('sim_genre')->where('slug',$slug1)->first();
        if($info):
          $href=route('category.list_slug2',array($slug1,$value->slug));
          $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
          // truong slug cung truong thi slug2 còn khac thi slug3

          $first = DB::table('sim_section')->where('slug',$slug2)->first();
          if($first){
            $href=route('category.list_slug2',array($slug1,$value->slug));
          }else{
           $href=route('category.list_slug3',array($slug1,$slug2,$value->slug));

          }
          // neu truong hop dang active thi tro ve slug truoc
          if($active=='active_rm'){
             $href=route('category.list_slug1',array($slug1));
          }
        endif;
         $html.='<a class="'.$active.'" href="'.$href.'" class="" title="'.$value->number_section.'">'.$value->number_section.'</a>';
        }
        $html.='
      </div> 
</div>';
      }
      return $html;
    }
    public function dauso_slug3_first_name($type='',$slug_cat="",$id_category="",$slug1='',$slug2='',$slug3=''){
      $html='';
      $items = DB::table('sim_section')->where('status',1)->where('parent_id',0)->where('id_category','!=',6)->groupBy('number_section')->orderBy('number_section','desc');
        if($id_category!=0){
         $items = $items->where('id_category',$id_category)->get();
        }else{
          $items = $items->get();
        }
     if(!empty($items)){
        $html.='<div class="search_field">
          <div id="head-select">
            <span class="stitle">Chọn đầu số:</span>';
            foreach ($items as $key => $value) {
              // truong hop sim viettel
             $category = DB::table('sim_category_network')->where('slug',$slug1)->first();
             if($category):
              $href=route('category.list_slug2',array($slug1,$value->slug));
                $info = DB::table('sim_section')->where('slug',$slug2)->first();
                if($info):
                  $active =  (strpos($slug2,$value->slug) !== false) ? 'active_rm' : '';
                   $href=route('category.list_slug3',array($slug1,$value->slug,$slug3));
                  // neu truong hop dang active thi tro ve slug truoc
                  if($active=='active_rm'){
                     $href=route('category.list_slug2',array($slug1,$slug3));
                  }
                endif;
                $info = DB::table('sim_section')->where('slug',$slug3)->first();
                if($info){
                  $active =  (strpos($slug3,$value->slug) !== false) ? 'active_rm' : '';
                   $href=route('category.list_slug3',array($slug1,$value->slug,$slug3));
                  if($active=='active_rm'){
                    $href=route('category.list_slug2',array($slug1,$slug2));
                  }
                  
                }
              endif;
              $category = DB::table('sim_price_range')->where('slug',$slug1)->first();
             if($category):
                $info = DB::table('sim_section')->where('slug',$slug3)->first();
                if($info){
                  $active =  (strpos($slug3,$value->slug) !== false) ? 'active_rm' : '';
                  $href=route('category.list_slug3',array($slug1,$slug2,$value->slug));
                  if($active=='active_rm'){
                   $href=route('category.list_slug2',array($slug1,$slug2));
                    
                  }
                  
                }
              endif;
          $category = DB::table('sim_genre')->where('slug',$slug1)->first();
             if($category):
                $info = DB::table('sim_section')->where('slug',$slug3)->first();
                if($info){
                  $active =  (strpos($slug3,$value->slug) !== false) ? 'active_rm' : '';
                  $href=route('category.list_slug3',array($slug1,$slug2,$value->slug));
                  if($active=='active_rm'){
                   $href=route('category.list_slug2',array($slug1,$slug2));
                    
                  }
                  
                }
              endif;
               $html.='<a class="'.$active.'" href="'.$href.'" class="" title="'.$value->number_section.'">'.$value->number_section.'</a>';
              }
              $html.='
            </div> 
      </div>';
      }
      return $html;
    }
    // search sim theo dau, duoim giua
    public function list_sim_search($items,$type='',$dau='',$duoi=''){
      $image = '';
      // check ton tai
      $html=''; $html.='<div class="div_sim">
               <table width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                     <tr class="tr_header_sim" align="center">
                     </tr>
                     <tr class="tr_header_sim" align="center">
                        <th class="th_stt">
                           <div class="stt"><strong>Stt</strong></div>
                        </th>
                        <th>
                           <div class="number">
                              <span class="table_title_length_pr" title="Số sim">Số sim</span>
                           </div>
                        </th>
                        <th nowrap="nowrap">
                           <div class="price">
                              <span class="table_title_threshold_pr"><span>Giá bán</span></span>
                           </div>
                        </th>
                        <th nowrap="nowrap" class="manu_mb">
                           <div class="manu"><strong>Mạng</strong></div>
                        </th>
                        <th nowrap="nowrap" class="manu_mb">
                           <div class="category"><strong>Phân loại Sim</strong></div>
                        </th>
                        <th nowrap="nowrap">
                           <div class="category"><strong>Mua ngay</strong></div>
                        </th>
                     </tr>';
      if(@count($items)){
       
                     $i=0;
                foreach ($items as $item) {
                  $i++;
                   $number_sim_tring = $item->number_sim_tring;
                    $sim_int = $item->number_sim;
                     $genre =  (self::get_name_regex_genre($item->id_genre_min));
                     // check thể loại sim
                     $regex = $genre->regex;
                     $number_sim_tring = \App\myHelper::check_regex_number_string($regex,$sim_int,$number_sim_tring);
                     // truong hop search 1: so duoi
                    $number_sim_tring = \App\myHelper::strong_sim_search($type,$dau,$duoi,$sim_int,$item->number_sim_tring);
                        $image_cat = $item->image_cat;
                       // lay the loai sim
                  // check bg_0
                  $bg = $i%2==1 ? 'bg_1' : 'bg_0'; 
                  $href = route('single_sim.list',$sim_int);
                  $html.='<tr class="tr_sim '.$bg.'" align="center">
                  <td class="item_stt">
                     <div>'.$i.'</div>
                  </td>
                  <td class="item_number" align="left">
                     <div>
                        <a class="modal" href="'.$href.'" rel="">'.$number_sim_tring.'</a>
                     </div>
                  </td>
                  <td class="price" align="right">
                     <div>
                        <span>'.myHelper::convert_money($item->price).'</span>
                     </div>
                  </td>
                  <td class="manu_mb tr_sim color_5">
                     <span class="image" style="        background: url(/uploads/'.$image_cat.') no-repeat center center;background-size: contain;"></span>
                  </td>
                  <td class="manu_mb">
                     <div class="view_pt_area">
                        '.$genre->name_genre.'                              
                     </div>
                  </td>
                  <td class="tr_buy_now">
                     <a href="'.$href.'" title="'.$sim_int.'">Mua sim</a>
                  </td>
               </tr>
               
           ';
        }
        $html.=' </tbody>
               </table>
            </div>';
            $html.=$items->links();
      }else{
        $html.='<tr class="tr_sim bg_1" align="center">
                  <td class="item_stt" colspan="6">
                     <div style="    padding: 20px;
    font-weight: bold;
    font-size: 20px;">Chưa có dữ liệu</div>
                  </td>
               </tr>
            ';
             $html.=' </tbody>
               </table>
            </div>';
      }

      return $html;
    }
    // lay du lieu sim
    public function list_sim_category($items)
    {
      $image = '';
      // check ton tai
      $html=''; $html.='<div class="div_sim">
               <table width="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                     <tr class="tr_header_sim" align="center">
                     </tr>
                     <tr class="tr_header_sim" align="center">
                        <th class="th_stt">
                           <div class="stt"><strong>Stt</strong></div>
                        </th>
                        <th>
                           <div class="number">
                              <span class="table_title_length_pr" title="Số sim">Số sim</span>
                           </div>
                        </th>
                        <th nowrap="nowrap">
                           <div class="price">
                              <span class="table_title_threshold_pr"><span>Giá bán</span></span>
                           </div>
                        </th>
                        <th nowrap="nowrap" class="manu_mb">
                           <div class="manu"><strong>Mạng</strong></div>
                        </th>
                        <th nowrap="nowrap" class="manu_mb">
                           <div class="category"><strong>Phân loại Sim</strong></div>
                        </th>
                        <th nowrap="nowrap">
                           <div class="category"><strong>Mua ngay</strong></div>
                        </th>
                     </tr>';
      if(@count($items)){
       
                     $i=0;
                foreach ($items as $item) {
                  $i++;
                   $number_sim_tring = $item->number_sim_tring;
                    $sim_int = $item->number_sim;
                     $genre =  (self::get_name_regex_genre($item->id_genre_min));
                     // check thể loại sim
                     $regex = $genre->regex;
                     $number_sim_tring = \App\myHelper::check_regex_number_string($regex,$sim_int,$number_sim_tring);
                       //  preg_match($regex, $sim_int, $output_array);
                       // $strong = ($output_array[0]);
                       // preg_match($regex, $number_sim_tring, $output_array_string);
                       // if(count($output_array_string)>0){
                       //  $strong = ($output_array_string[0]);
                       // }
                       // if(count($output_array)>2){
                       //  $strong = ($output_array[2]);
                       // }
                       // if(count($output_array)>3){
                       //  $strong = (@$output_array[4]);
                       // }
                        $image_cat = $item->image_cat;
                       // lay the loai sim
                  // check bg_0
                  $bg = $i%2==1 ? 'bg_1' : 'bg_0'; 
                  $href = route('single_sim.list',$sim_int);
                  $html.='<tr class="tr_sim '.$bg.'" align="center">
                  <td class="item_stt">
                     <div>'.$i.'</div>
                  </td>
                  <td class="item_number" align="left">
                     <div>
                        <a class="modal" href="'.$href.'" rel="">'.$number_sim_tring.'</a>
                     </div>
                  </td>
                  <td class="price" align="right">
                     <div>
                        <span>'.myHelper::convert_money($item->price).'</span>
                     </div>
                  </td>
                  <td class="manu_mb tr_sim color_5">
                     <span class="image" style="        background: url(/uploads/'.$image_cat.') no-repeat center center;background-size: contain;"></span>
                  </td>
                  <td class="manu_mb">
                     <div class="view_pt_area">
                        '.$genre->name_genre.'                              
                     </div>
                  </td>
                  <td class="tr_buy_now">
                     <a href="'.$href.'" title="'.$sim_int.'">Mua sim</a>
                  </td>
               </tr>
               
           ';
        }
        $html.=' </tbody>
               </table>
            </div>';
            $html.=$items->links();
      }else{
        $html.='<tr class="tr_sim bg_1" align="center">
                  <td class="item_stt" colspan="6">
                     <div style="    padding: 20px;
    font-weight: bold;
    font-size: 20px;">Chưa có dữ liệu</div>
                  </td>
               </tr>
            ';
             $html.=' </tbody>
               </table>
            </div>';
      }

      return $html;
    }
    public function sidebar_sim($type_sidebar="",$slug_cat="")
    {
      $html='';
      // sim theo gias
                $items = DB::table('sim_price_range')->orderBy('weight')->get();
                if($items || !empty($items)){
                  $html.='<div class="sims_categories sub_block" id="sims_group_sim_theo_gia">
              <div class="sub_block_title cat_title_block" data-id="id_price_prices" id="sub_block_title">
                 <div class="normal"><span>Sim theo giá</span></div>
              </div>
              <div class="fillter_categories_label" id="id_price_prices">
                 <div class="wrapper_head">';
                  foreach ($items as $item) {
                    $href = route('category.list_slug1',array($item->slug));
                    // check active
                    $active =$slug_cat==$item->slug ? "activated " : "";
                    $html.='<div class="filter_item '.$active.' filter_item_lelel_0">
                       <div class="filter_item_inner">
                          <a href="'.$href.'" title="'.$item->name_price_range.'">
                          <span class="check_box"></span>
                          <span>'.$item->name_price_range.'</span>
                          </a>
                       </div>
                    </div>';
                  }
                }
                    $html.='
                 </div>
                 <div class="clear"></div>
              </div>
              <!-- end .sims_categories_label -->
              <div class="clear"></div>
           </div>';
           $arr_sidebar = config('simsogiare.type_sidebar');
           foreach ($arr_sidebar as $key => $item_sidebar) {
             
                $items_genre = DB::table('sim_genre')->where('type_sidebar',$key)->orderBy('weight')->get();
                if($items_genre || !empty($items)){
                  $html.='<div class="sims_categories sub_block" id="sims_group_sim_theo_gia">
              <div class="sub_block_title cat_title_block" data-id="id_price_prices" id="sub_block_title">
                 <div class="normal"><span>'.$item_sidebar.'</span></div>
              </div>
              <div class="fillter_categories_label" id="id_price_prices">
                 <div class="wrapper_head">';
                  foreach ($items_genre as $item_genre) {
                    $active = $slug_cat == $item_genre->slug ? "activated " : "";
                    $href_genre = route('category.list_slug1',array($item_genre->slug));
                    $html.='<div class="filter_item '.$active.' filter_item_lelel_0">
                       <div class="filter_item_inner">
                          <a href="'.$href_genre.'" title="'.$item_genre->name_genre.'">
                          <span class="check_box"></span>
                          <span>'.$item_genre->name_genre.'</span>
                          </a>
                       </div>
                    </div>';
                  }
                }
                    $html.='
                 </div>
                 <div class="clear"></div>
              </div>
              <!-- end .sims_categories_label -->
              <div class="clear"></div>
           </div>';
           }
      return $html;
    }
    public function get_desc_seo_website($content){
      $seo_description_product = '';
      @$meta_description_product=preg_replace('/[\n\r]/','',strip_tags($content));
                  $title_length_product = mb_strlen($meta_description_product);
                  $seo_description_product =trim(mb_substr($meta_description_product,0,325)) . ($title_length_product > 325 ? '...' : '');
                  $seo_description_product =str_replace('&nbsp;', ' ', $seo_description_product);
                  return $seo_description_product;
    }
    // category trang chủ
    public function get_category_homepage($category,$discount=''){
      $html = '';
      $items = DB::table('sim as a')->join('sim_genre as b','a.id_genre','=','b.id')->join('sim_category_network as c','a.id_category_network','=','c.id')->where('a.id_category_network',$category)->orderBy('a.price','desc')->select('a.*','b.regex','c.image as image_cat')->limit(20)->get();
      // khai bao de check the loaij sim, vi du sim ngu quy
       
       
      $html.='<div class="div_sim">
          <ul width="100%" cellspacing="0" cellpadding="0" border="0">';
          // chay vong loop
             // bien dem

             $dem =0;

            foreach ($items as $key => $value) {
              $dem++;
              // lay href cua sim
              $slug = route('single_sim.list',array($value->slug));
              // tinh toan so nằm trong thể loại sim
             $price = myHelper::convert_money($value->price);
             $number_sim_tring = $value->number_sim_tring;
            $sim_int = $value->number_sim;

             $regex = $value->regex;
             $number_sim_tring = \App\myHelper::check_regex_number_string($regex,$sim_int,$number_sim_tring);
               //  preg_match($regex, $sim_int, $output_array);
               // $strong = ($output_array[0]);
               // preg_match($regex, $number_sim_tring, $output_array_string);
               // if(count($output_array_string)>0){
               //  $strong = ($output_array_string[0]);
               // }
               // if(count($output_array)>2){
               //  $strong = ($output_array[2]);
               // }
               // if(count($output_array)>3){
               //  $strong = ($output_array[4]);
               // }
               // $number_sim_tring = str_replace($strong, '<strong style="color:red">'.$strong.'</strong>', $number_sim_tring);
            $bg_gl = $dem==1 ? 'bg_gl' : '';

              // giá sim
            $image_cat = $value->image_cat;
             $html.='<li class="tr_sim color_4  '.$bg_gl.'">
                <span class="image" style="        background: url(/uploads/'.$image_cat.') no-repeat center center;background-size: contain;">
                </span>
                <a class="modal" href="'.$slug.'" rel="" title="Mua ngay">'.$number_sim_tring.'</strong>                 <span>'.$price.' ₫</span>
                </a>
             </li>';
            }
            // lay gia tri slug cua category
            $category_info = DB::table('sim_category_network')->where('id',$category)->first();
             // xem them
            $more = route('category.list_slug1',array($category_info->slug));
            if($discount=='discount'):
             $html.='
             <li class="tr_sim tr_next">
                <a class="modal" href="" rel="" title="Xem thêm">
                   Xem thêm 
                   <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20" height="20" viewBox="0 0 284.936 284.936" style="enable-background:new 0 0 284.936 284.936;" xml:space="preserve">
                      <g>
                         <g>
                            <path d="M277.515,135.9L144.464,2.857C142.565,0.955,140.375,0,137.9,0c-2.472,0-4.659,0.955-6.562,2.857l-14.277,14.275 c-1.903,1.903-2.853,4.089-2.853,6.567c0,2.478,0.95,4.664,2.853,6.567l112.207,112.204L117.062,254.677  c-1.903,1.903-2.853,4.093-2.853,6.564c0,2.477,0.95,4.667,2.853,6.57l14.277,14.271c1.902,1.905,4.089,2.854,6.562,2.854 c2.478,0,4.665-0.951,6.563-2.854l133.051-133.044c1.902-1.902,2.851-4.093,2.851-6.567S279.417,137.807,277.515,135.9z"></path>
                            <path d="M170.732,142.471c0-2.474-0.947-4.665-2.857-6.571L34.833,2.857C32.931,0.955,30.741,0,28.267,0s-4.665,0.955-6.567,2.857  L7.426,17.133C5.52,19.036,4.57,21.222,4.57,23.7c0,2.478,0.95,4.664,2.856,6.567L119.63,142.471L7.426,254.677 c-1.906,1.903-2.856,4.093-2.856,6.564c0,2.477,0.95,4.667,2.856,6.57l14.273,14.271c1.903,1.905,4.093,2.854,6.567,2.854 s4.664-0.951,6.567-2.854l133.042-133.044C169.785,147.136,170.732,144.945,170.732,142.471z"></path>
                         </g>
                      </g>
                   </svg>
                </a>
             </li>
             ';
           endif;
           $html.='
          </ul>
          <div class="clear"></div>
       </div>';
       return $html;
    }
    public function callback_content($buffer,$title) {
        preg_match_all('/<img[^>]+>/', $buffer, $images);
        if(!empty($images)) {
            $i=-1;
            foreach($images as $index => $value) {
                
                if(!empty($value)){
                    foreach ($value as $item) {
                        $i++;
                        if(!empty($item)){
                            preg_match('/alt="(.*?)"/', $item, $img);
                            preg_match('/alt=\'(.*?)\'/', $item, $img2);
                            if(( @$img[1] == '')) {
                                 $new_img = str_replace('<img', '<img alt="'.$title.' '.($i+1).'"', $images[0][$i]);
                                $buffer = str_replace($images[0][$i], $new_img, $buffer);
                            }
                            
                        }
                        
                    }
                }
                
            }
        }

        return $buffer;
    }
    public function showCategories($categories, $parent_id = 0, $char = '')
    {
        $i=0;
        foreach ($categories as $key => $item)
        {
            $i++;
            // Nếu là chuyên mục con thì hiển thị
            if ($item->parent_id == $parent_id)
            {
                echo '<p class="category_item_input"><label for="checkbox_cmc_'.$i.'">
                <input type="checkbox" class="category_item_input checkbox" name="category_item[]" value="'.$item->id.'" id="checkbox_cmc_'.$i.'"><span>'.$char . $item->name.'</span></label>
                    <br>
                </p>';
                // Xóa chuyên mục đã lặp
                unset($categories[$key]);
                 
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                self::showCategories($categories, $item->id, $char.'---');
            }
        }
    }
    public function showCategoriesChecked($categories,$postcategory, $parent_id = 0, $char = '')
    {
        $i=0;
        foreach ($categories as $key => $item)
        { 
            $arr = [];
            $id_category = $item->id;
            foreach ($postcategory as $value) {
                $news = $value->id_category;
                $arr[] = $news;
            }
            $i++;
            // Nếu là chuyên mục con thì hiển thị
            if ($item->parent_id == $parent_id)
            {
                $check = in_array($id_category, $arr) ? 'checked' : '';
                echo '<p class="category_item_input"><label for="checkbox_cmc_'.$i.'">
                <input type="checkbox" class="category_item_input checkbox" '.$check.' name="category_item[]"  value="'.$item->id.'" id="checkbox_cmc_'.$i.'"><span>'.$char . $item->name.'</span></label>
                    <br>
                </p>';
                // Xóa chuyên mục đã lặp
                unset($categories[$key]);
                // Tiếp tục đệ quy để tìm chuyên mục con của chuyên mục đang lặp
                self::showCategoriesChecked($categories,$postcategory, $item->id, $char.'---');
            }
        }
    }

}//end class