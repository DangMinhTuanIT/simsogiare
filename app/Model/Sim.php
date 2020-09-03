<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class Sim extends Model{
	protected $table = 'sim';

    protected $fillable = [
        'number_sim',
        'number_sim_tring',
        'slug',
        'price',
        'weight',
        'id_category_network',
        'id_genre',
        'id_section',
        'id_sim_birth',
        'group',
        'id_price_range',
        'image_url',
        'content',
        'point_sim',
        'id_sim_fate',
        'id_sim_age',
        'id_sim_year',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'status',
        'type',
    ];
    public static function detail_sim($slug)
    {
      $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.slug as slug_genre','b.image as image_cat','d.regex',DB::raw('min(d.id) as id_genre_min'))
       ->orderBy('d.id','desc')
       ->where('a.slug',$slug)->first();
       return $items;
    }
    // sim phong thuy
    public static function simphongthuy_hopmenh(){
      $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.slug as slug_genre','b.image as image_cat','d.regex',DB::raw('min(d.id) as id_genre_min'));
       $items = $items->where('a.point_sim','>=',6)
       ->orderBy('a.point_sim','desc')
       ->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')->paginate(50);
       return $items;
    }
    public static function simphongthuy_hopnamsinh(){
      $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.slug as slug_genre','b.image as image_cat','d.regex',DB::raw('min(d.id) as id_genre_min'));
       $items = $items->where('a.point_sim','>=',6)
       ->orderBy('a.point_sim','desc')
       ->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')->paginate(50);
       return $items;
    }
    public static function simphongthuy_hoptuoi(){
      $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.slug as slug_genre','b.image as image_cat','d.regex',DB::raw('min(d.id) as id_genre_min'));
       $items = $items->where('a.point_sim','>=',6)
       ->orderBy('a.point_sim','desc')
       ->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')->paginate(50);
       return $items;
    }
    // search so duoi sim
    public static function search_sim_duoi($num,$type='',$string='',$order_type='',$order=''){
        $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.slug as slug_genre','b.image as image_cat','d.regex',DB::raw('min(d.id) as id_genre_min'));
       
       // truong hop gia va oder ramdom va search so duoi
       if($type =='price_range' && $order_type=='order'){
        $items = $items->where('e.slug',$string)
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       // truong hop category va oder ramdom va search so duoi
       } else if($type =='category_network' && $order_type=='order'){
        $items = $items->where('b.slug',$string)
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       // truong hop gia va order theo gia va search so duoi
       }else if($type =='price_range' && $order_type=='price'){
        $items = $items->where('e.slug',$string)->orderBy('a.price',$order)
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       // truong hop category va order theo gia va search so duoi
       }else if($type =='category_network' && $order_type=='price'){
        $items = $items->where('b.slug',$string)->orderBy('a.price',$order)
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       // truong hop the loai gia va search so duoi
       }else if($type =='price_range'){
        $items = $items->where('e.slug',$string)->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       // truong hop the loai va search so duoi
       }else if($type =='category_network'){
        $items = $items->where('b.slug',$string)->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       // truong hop search va order ramdon
       }else if($order_type=='order'){
           $items = $items
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       // truong hop search va order theo gia
       }else if($order_type=='price'){
           $items = $items->orderBy('a.price',$order)
          ->where('a.number_sim','like','%'.$num)->paginate(50);
       }else{
        $items = $items->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like','%'.$num)->paginate(50);
       }

       return $items;
    }
    public static function search_sim_dau($num,$type='',$string='',$order_type='',$order=''){
        $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.slug as slug_genre','b.image as image_cat','d.regex',DB::raw('min(d.id) as id_genre_min'));
       // truong hop gia
       if($type =='price_range' && $order_type=='order'){
        $items = $items->where('e.slug',$string)->orderBy('a.id','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$num.'%')->paginate(50);
       // truong hop category
       }else if($type =='price_range' && $order_type=='price'){
        $items = $items->where('e.slug',$string)->orderBy('a.price',$order)
       ->where('a.number_sim','like',$num.'%')->paginate(50);
       // truong hop category
       }else if($type =='category_network' && $order_type=='price'){
        $items = $items->where('b.slug',$string)->orderBy('a.price',$order)
       ->where('a.number_sim','like',$num.'%')->paginate(50);
       // truong hop category
       }else if($type =='price_range'){
        $items = $items->where('e.slug',$string)->orderBy('a.price','desc')
       ->where('a.number_sim','like',$num.'%')->paginate(50);
       // truong hop category
       }else if($type =='category_network'){
        $items = $items->where('b.slug',$string)->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$num.'%')->paginate(50);
       }else if($order_type=='order'){
           $items = $items
       ->where('a.number_sim','like',$num.'%')->paginate(50);
       // truong hop search va order theo gia
       }else if($order_type=='order'){
           $items = $items->orderBy('a.price',$order)
          ->where('a.number_sim','like',$num.'%')->paginate(50);
       }else{
        $items = $items->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$num.'%')->paginate(50);
       }
       return $items;
    }
    public static function search_sim_giua($dau,$duoi,$type='',$string='',$order_type='',$order=''){
        $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.slug as slug_genre','b.image as image_cat','d.regex',DB::raw('min(d.id) as id_genre_min'));
       // truong hop gia
       if($type =='price_range' && $order_type=='order'){
        $items = $items->where('e.slug',$string)->orderBy('a.id','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->paginate(50);
       // truong hop category
       }else if($type =='price_range' && $order_type=='price'){
        $items = $items->where('e.slug',$string)->orderBy('a.id',$order)
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->paginate(50);
       // truong hop category
       }else if($type =='category_network' && $order_type=='price'){
        $items = $items->where('b.slug',$string)->orderBy('a.id',$order)
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->paginate(50);
       // truong hop category
       }else if($type =='price_range'){
        $items = $items->where('e.slug',$string)->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->paginate(50);
       // truong hop category
       }else if($type =='category_network'){
        $items = $items->where('b.slug',$string)->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->paginate(50);
       }else if($order_type=='order'){
           $items = $items
       ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->orderBy(DB::raw('RAND()'))->paginate(50);
       // truong hop search va order theo gia
       }else if($order_type=='price'){
           $items = $items->orderBy('a.price',$order)
          ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->paginate(50);
       }else{
        $items = $items->orderBy('a.price','desc')
       ->orderBy('e.id','desc')
       ->orderBy('d.id','desc')
       ->where('a.number_sim','like',$dau.'%')
       ->where('a.number_sim','like','%'.$duoi)->paginate(50);
       }
       
       return $items;
    }
    // category sim theo nha mang
    public static function category_network($slug,$order_type='',$order='')
    {
      $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
       // truong hop  order random
       if($order_type=='order'){
           $items = $items->where('b.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
       // truong hop  order theo gia
       }else if($order_type=='price'){
           $items = $items->orderBy('a.price',$order)
          ->where('b.slug',$slug)->paginate(50);
       }else{
          $items = $items->orderBy('d.id','desc')
          ->where('b.slug',$slug)->paginate(50);
       }
       return $items;
    }
     // category sim theo nha mang filter
    public static function category_network_filter($slug,$slug2,$order_type='',$order='')
    {
      $items = null;
      $th1 = DB::table('sim_genre')->where('slug',$slug2)->select('id')->first();
       if($th1 && !empty($th1)){
        // filter theo the loai
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
       // truong hop  order random
       if($order_type=='order'){
           $items = $items->where('d.slug',$slug2)
       ->where('b.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
       // truong hop  order theo gia
       }else if($order_type=='price'){
           $items = $items->orderBy('a.price',$order)
          ->where('d.slug',$slug2)
       ->where('b.slug',$slug)->paginate(50);
       }else{
          $items = $items->orderBy('d.id','desc')
          ->where('d.slug',$slug2)
       ->where('b.slug',$slug)->paginate(50);
       }
     }
      $th2 = DB::table('sim_price_range')->where('slug',$slug2)->first();
       //truong hop 2 theo gia
       if($th2 && !empty($th2)){
         $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
           // truong hop  order random
           if($order_type=='order'){
               $items = $items->where('e.slug',$slug2)
           ->where('b.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
              ->where('e.slug',$slug2)
           ->where('b.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
              ->where('e.slug',$slug2)
           ->where('b.slug',$slug)->paginate(50);
           }
       }
       $th3 = DB::table('sim_section')->where('slug',$slug2)->first();
       //truong hop 2 theo gia
       if($th3 && !empty($th3)){
        $number_section = $th3->number_section;
         $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')->join('sim_section as f','f.id','=','a.id_section')
       ->groupBy('a.id')
       ->where('a.number_sim','like',$number_section.'%')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
           // truong hop  order random
           if($order_type=='order'){
               $items = $items
           ->where('b.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
           ->where('b.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
           ->where('b.slug',$slug)->paginate(50);
           }
       }
       return $items;
    }
     // category sim theo the loai
    public static function category_genre($slug,$order_type='',$order='')
    {
      $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
       // truong hop  order random
       if($order_type=='order'){
           $items = $items->where('d.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
       // truong hop  order theo gia
       }else if($order_type=='price'){
           $items = $items->orderBy('a.price',$order)
          ->where('d.slug',$slug)->paginate(50);
       }else{
          $items = $items->orderBy('d.id','desc')
          ->where('d.slug',$slug)->paginate(50);
       }
       return $items;
    }
     // category sim theo the loai filter
    public static function category_genre_filter($slug,$slug2,$order_type='',$order='')
    {
      $items = null;
       //truong hop 1, chon nha mang
       $th1 = DB::table('sim_category_network')->where('slug',$slug2)->select('id')->first();
       if($th1 && !empty($th1)){
        $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
            // truong hop  order random
           if($order_type=='order'){
               $items = $items->where('b.slug',$slug2)
              ->where('d.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
              ->where('b.slug',$slug2)
              ->where('d.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
             ->where('b.slug',$slug2)
              ->where('d.slug',$slug)->paginate(50);
           }
       }
       $th2 = DB::table('sim_price_range')->where('slug',$slug2)->first();
       //truong hop 2
       if($th2 && !empty($th2)){
          $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
       
          // truong hop  order random
           if($order_type=='order'){
               $items = $items->where('e.slug',$slug2)
              ->where('d.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
              ->where('e.slug',$slug2)
              ->where('d.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
             ->where('e.slug',$slug2)
              ->where('d.slug',$slug)->paginate(50);
           }
       }
        $th3 = DB::table('sim_section')->where('slug',$slug2)->first();
       //truong hop 2 theo gia
       if($th3 && !empty($th3)){
        $number_section = $th3->number_section;
         $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->where('a.number_sim','like',$number_section.'%')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
           // truong hop  order random
           if($order_type=='order'){
               $items = $items
           ->where('d.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
           ->where('d.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
           ->where('d.slug',$slug)->paginate(50);
           }
       }
       return $items;
    }
    // category sim theo gia
    public static function category_price_range($slug,$order_type='',$order='')
    {
      $items = null;
       $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
        // truong hop  order random
       if($order_type=='order'){
           $items = $items->where('e.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
       // truong hop  order theo gia
       }else if($order_type=='price'){
           $items = $items->orderBy('a.price',$order)
          ->where('e.slug',$slug)->paginate(50);
       }else{
          $items = $items->orderBy('d.id','desc')
          ->where('e.slug',$slug)->paginate(50);
       }
       return $items;
    }
    // category sim theo gia filter
    public static function category_price_range_filter($slug,$slug2,$order_type='',$order=''){

      //truong hop 1, chon nha mang
       $th1 = DB::table('sim_category_network')->where('slug',$slug2)->select('id')->first();
       if($th1 && !empty($th1)){
        $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
       
            // truong hop  order random
           if($order_type=='order'){
               $items = $items->where('b.slug',$slug2)
              ->where('e.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
              ->where('b.slug',$slug2)
              ->where('e.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
             ->where('b.slug',$slug2)
              ->where('e.slug',$slug)->paginate(50);
           }

       }
       $th2 = DB::table('sim_price_range')->where('slug',$slug2)->first();
       //truong hop 2 chon dau so
       if($th2 && !empty($th2)){
          $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
       

        // truong hop  order random
           if($order_type=='order'){
               $items = $items->where('e.slug',$slug2)
              ->where('d.slug',$slug)->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
              ->where('e.slug',$slug2)
              ->where('d.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
              ->where('e.slug',$slug2)
              ->where('d.slug',$slug)->paginate(50);
           }
       }
       $th3 = DB::table('sim_section')->where('slug',$slug2)->first();
       //truong hop 2 chon dau so
       if($th3 && !empty($th3)){
        $number_section = $th3->number_section;
          $items = DB::table('sim as a')->join('sim_category_network as b','b.id','=','a.id_category_network')
       ->join('join_sim_genre as c','a.id','=','c.id_sim')->join('sim_genre as d','c.id_genre','=','d.id')
       ->join('sim_price_range as e','e.id','=','a.id_price_range')
       ->where('a.number_sim','like',$number_section.'%')
       ->groupBy('a.id')
       ->select('a.*','b.name_network','d.name_genre','d.regex','b.image as image_cat',DB::raw('min(d.id) as id_genre_min'));
       

        // truong hop  order random
           if($order_type=='order'){
               $items = $items->where('e.slug',$slug)->orderBy(DB::raw('RAND()'))->paginate(50);
           // truong hop  order theo gia
           }else if($order_type=='price'){
               $items = $items->orderBy('a.price',$order)
              ->where('e.slug',$slug)->paginate(50);
           }else{
              $items = $items->orderBy('d.id','desc')
              ->where('e.slug',$slug)->paginate(50);
           }
       }
       return $items;
    }
    // all api admin
     public static function all($filters = [])
    {
        
        $items = DB::table('sim as s')
        ->join('sim_category_network as a','a.id','=','s.id_category_network')
        ->join('sim_genre as b','b.id','=','s.id_genre')
        ->orderBy('s.id','asc')
            ->select('s.*','a.name_network','b.name_genre','b.regex');
        $items = myHelper::buildSQL($items, $filters, 's.id', 'desc');
         return DataTables::of($items)
         ->editColumn('price', function ($item) {
            return myHelper::convert_money($item->price); 
        })
        ->editColumn('status', function ($item) {
            $class=$item->status==1 ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs';
            return '<span class="btn btn-success btn-xs">Có sẵn</span>'; 
        })
        ->editColumn('number_sim_tring',function($item){
            $number_sim_tring = $item->number_sim_tring;
            $sim_int = $item->number_sim;

             $regex = $item->regex;
                preg_match($regex, $sim_int, $output_array);
               $strong = ($output_array[0]);
               preg_match($regex, $number_sim_tring, $output_array_string);
               if(count($output_array_string)>0){
                $strong = ($output_array_string[0]);
               }
               if(count($output_array)>2){
                $strong = ($output_array[2]);
               }
               if(count($output_array)>3){
                $strong = ($output_array[4]);
               }
              return $number_sim_tring = str_replace($strong, '<strong style="color:red">'.$strong.'</strong>', $number_sim_tring);
        })
        ->rawColumns(['status','price','number_sim_tring'])
        ->make(true);

        return Datatables::queryBuilder($q)->make(true);

    }
    
    public static function getAll()
    {
        return DB::table('sim as s')->select('s.*')->get();
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('sim as a')
            ->select('a.*')
            ->where('a.name_customer', 'like', '%' . $params . '%')
            ->groupBy('a.id')
            ->orderBy('a.id', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('sim')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('sim')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}