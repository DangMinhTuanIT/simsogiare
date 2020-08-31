<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\myHelper;
use Validator;
use Illuminate\Http\Request;
use Goutte\Client;
use App\Model\Sim;
use App\Model\SimOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use WebService,URL;


class SearchController extends Controller
{
    // tim duoi so
    public function search_sim_duoi($id){
        if(@($_GET['order'])){
             $items = Sim::search_sim_duoi($id,'','','order',$_GET['order']);
             // order theo gia va string la the loai
        }else if(@($_GET['price'])){
             $items = Sim::search_sim_duoi($id,'','','price',$_GET['price']);
             // string la the loai
        }else if($id){
            $items = Sim::search_sim_duoi($id);
        }else{
           // loi
            return view('frontend.404');
        }
        $slug1 = 'tim-sim-duoi-so-'.$id;
            $type = 'duoi';
            $category = '';
            // dau so chi di theo nha mang
            $dauso_id = '';
             $slug_cat = '';
             $type_sidebar = '';
             $filter_according = '';
             $text_search = $id;
    	return view('frontend.search.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'text_search'=>$text_search,
            'duoi'=>$id,
            'dau'=>'',
            'filter_according'=>$filter_according,
            'category'=>$category,
            'name_cat'=>$id,
            'slug1'=>$slug1
        ]);
	}
	// tim duoi so
    public function search_sim_dau($id){
        if(@($_GET['order'])){
             $items = Sim::search_sim_dau($id,'','','order',$_GET['order']);
             // order theo gia va string la the loai
        }else if(@($_GET['price'])){
             $items = Sim::search_sim_dau($id,'','','price',$_GET['price']);
             // string la the loai
        }else if($id){
            $items = Sim::search_sim_dau($id);
        }else{
           // loi
            return view('frontend.404');
        }
        $slug1 = 'tim-sim-dau-so-'.$id;
            $type = 'dau';
            $category = '';
            // dau so chi di theo nha mang
            $dauso_id = '';
             $slug_cat = '';
             $type_sidebar = '';
             $filter_according = '';
             $text_search = $id;
        return view('frontend.search.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'text_search'=>$text_search,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'duoi'=>'',
            'dau'=>$id,
            'filter_according'=>$filter_according,
            'category'=>$category,
            'name_cat'=>$id,
         'slug1'=>$slug1
     ]);
    }
     public function search_sim_giua($duoi,$dau){
        if(@($_GET['order'])){
             $items = Sim::search_sim_giua($dau,$duoi,'','','order',$_GET['order']);
             // order theo gia va string la the loai
        }else if(@($_GET['price'])){
             $items = Sim::search_sim_giua($dau,$duoi,'','','price',$_GET['price']);
             // string la the loai
        }else if($duoi && $dau){
            $items = Sim::search_sim_giua($dau,$duoi);
        }else{
           // loi
            return view('frontend.404');
        }
        $slug1 = 'sim-duoi-so-'.$duoi.'-dau-'.$dau;
            $type = 'giua';
            $category = '';
            // dau so chi di theo nha mang
            $dauso_id = '';
             $slug_cat = '';
             $type_sidebar = '';
             $filter_according = '';
             $text_search = $dau.'*'.$duoi;
        return view('frontend.search.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'text_search'=>$text_search,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'dau'=>$dau,
            'duoi'=>$duoi,
            'filter_according'=>$filter_according,
            'category'=>$category,
            'name_cat'=>$dau,
         'slug1'=>$slug1
     ]);
    }
    // tim duoi so
    public function search_sim_duoi_theloai($id,$string){
        $info_price = DB::table('sim_price_range')->where('slug',$string)->first();
        $info_category_network = DB::table('sim_category_network')->where('slug',$string)->first();
        // order theo ramdom va string la gia
        if(@($_GET['order']) && ($info_price || !empty($info_price))){
             $items = Sim::search_sim_duoi($id,'price_range',$string,'order',$_GET['order']);
              // order theo ramdom va string la the loai
        }else if(@($_GET['order']) && ($info_category_network || !empty($info_category_network))){
             $items = Sim::search_sim_duoi($id,'category_network',$string,'order',$_GET['order']);
              // order theo gia va string la gia
        }else if(@($_GET['price']) && ($info_price || !empty($info_price))){
             $items = Sim::search_sim_duoi($id,'price_range',$string,'price',$_GET['price']);
             // order theo gia va string la the loai
        }else if(@($_GET['price']) && ($info_category_network || !empty($info_category_network))){
             $items = Sim::search_sim_duoi($id,'category_network',$string,'price',$_GET['price']);
             // string la the loai
        }else if($info_category_network || !empty($info_category_network)){
            $items = Sim::search_sim_duoi($id,'category_network',$string,'','');
            // string la the loai
        }else if($info_price || !empty($info_price)){
             $items = Sim::search_sim_duoi($id,'price_range',$string,'','');
        }else{
            // loi
            return view('frontend.404');
        }
        $slug1 = 'tim-sim-duoi-so-'.$id;
            $type = 'duoi';
            $category = '';
            // dau so chi di theo nha mang
            $dauso_id = '';
             $slug_cat = '';
             $type_sidebar = '';
             $filter_according = '';
             $text_search = $id;
        return view('frontend.search.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'text_search'=>$text_search,
            'duoi'=>$id,
            'dau'=>'',
            'slug2'=>$string,
            'filter_according'=>$filter_according,
            'category'=>$category,
            'name_cat'=>$id,
            'slug1'=>$slug1
        ]);
    }
    // tim duoi so
    public function search_sim_dau_theloai($id,$string){
        $info_price = DB::table('sim_price_range')->where('slug',$string)->first();
        $info_category_network = DB::table('sim_category_network')->where('slug',$string)->first();
        // order theo ramdom va string la gia
        if(@($_GET['order']) && ($info_price || !empty($info_price))){
             $items = Sim::search_sim_dau($id,'price_range',$string,'order',$_GET['order']);
              // order theo ramdom va string la the loai
        }else if(@($_GET['order']) && ($info_category_network || !empty($info_category_network))){
             $items = Sim::search_sim_dau($id,'category_network',$string,'order',$_GET['order']);
              // order theo gia va string la gia
        }else if(@($_GET['price']) && ($info_price || !empty($info_price))){
             $items = Sim::search_sim_dau($id,'price_range',$string,'price',$_GET['price']);
             // order theo gia va string la the loai
        }else if(@($_GET['price']) && ($info_category_network || !empty($info_category_network))){
             $items = Sim::search_sim_dau($id,'category_network',$string,'price',$_GET['price']);
             // string la the loai
        }else if($info_category_network || !empty($info_category_network)){
            $items = Sim::search_sim_dau($id,'category_network',$string,'','');
            // string la the loai
        }else if($info_price || !empty($info_price)){
             $items = Sim::search_sim_dau($id,'price_range',$string,'','');
        }else{
            // loi
            return view('frontend.404');
        }
        $slug1 = 'tim-sim-dau-so-'.$id;
            $type = 'dau';
            $category = '';
            // dau so chi di theo nha mang
            $dauso_id = '';
             $slug_cat = '';
             $type_sidebar = '';
             $filter_according = '';
             $text_search = $id;
        return view('frontend.search.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'text_search'=>$text_search,
            'duoi'=>$id,
            'dau'=>'',
            'slug2'=>$string,
            'filter_according'=>$filter_according,
            'category'=>$category,
            'name_cat'=>$id,
            'slug1'=>$slug1
     ]);
    }
     public function search_sim_giua_theloai($duoi,$dau,$string){
        $info_price = DB::table('sim_price_range')->where('slug',$string)->first();
        $info_category_network = DB::table('sim_category_network')->where('slug',$string)->first();
        // order theo ramdom va string la gia
        if(@($_GET['order']) && ($info_price || !empty($info_price))){
             $items = Sim::search_sim_giua($dau,$duoi,'price_range',$string,'order',$_GET['order']);
              // order theo ramdom va string la the loai
        }else if(@($_GET['order']) && ($info_category_network || !empty($info_category_network))){
             $items = Sim::search_sim_giua($dau,$duoi,'category_network',$string,'order',$_GET['order']);
              // order theo gia va string la gia
        }else if(@($_GET['price']) && ($info_price || !empty($info_price))){
             $items = Sim::search_sim_giua($dau,$duoi,'price_range',$string,'price',$_GET['price']);
             // order theo gia va string la the loai
        }else if(@($_GET['price']) && ($info_category_network || !empty($info_category_network))){
             $items = Sim::search_sim_giua($dau,$duoi,'category_network',$string,'price',$_GET['price']);
             // string la the loai
        }else if($info_category_network || !empty($info_category_network)){
            $items =Sim::search_sim_giua($dau,$duoi,'category_network',$string,'','');
            // string la the loai
        }else if($info_price || !empty($info_price)){
             $items = Sim::search_sim_giua($dau,$duoi,'price_range',$string,'','');
        }else{
            // loi
            return view('frontend.404');
        }
         $slug1 = 'sim-duoi-so-'.$duoi.'-dau-'.$dau;
            $type = 'giua';
            $category = '';
            // dau so chi di theo nha mang
            $dauso_id = '';
             $slug_cat = '';
             $type_sidebar = '';
             $filter_according = '';
             $text_search = $dau.'*'.$duoi;
        return view('frontend.search.index')->with([
           'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'text_search'=>$text_search,
             'dau'=>$dau,
            'duoi'=>$duoi,
            'slug2'=>$string,
            'filter_according'=>$filter_according,
            'category'=>$category,
            'name_cat'=>$dau,
            'slug1'=>$slug1
     ]);
    }
	
}