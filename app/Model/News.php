<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class News extends Model{
	protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'intro',
        'reviewer_name',
        'reviewed_by',
        'content',
        'site_title',
        'meta_desc',
        'meta_key',
        'image_link',
        'image_thumb',
        'feature',
        'count_view',
        'status',
        'created_at',
        'updated_at'
    ];
     public static function all($filters = [])
    {
        $items = DB::table('news as a')
            ->join('post_categories as b', 'a.id', '=', 'b.id_news')
            ->join('category as c', 'b.id_category', '=', 'c.id')
            ->groupBy('a.id')
            ->select('a.*','c.id as id_category','c.name as cat_name');

        $items = myHelper::buildSQL($items, $filters, 'a.id', 'desc');

         return DataTables::of($items)
        ->editColumn('title', function ($item) {
            return '<a href="'.route('news.list_slug1',array($item->slug,$item->id)).'">'.$item->title.'</a>'; 
        })
      
        ->rawColumns(['title','status'])
        ->make(true);

    }
    // find id and category
    public static function get_info($id){
        $items = DB::table('news as a')
            ->leftJoin('post_categories as b', 'a.id', '=', 'b.id_news')
            ->leftJoin('category as c', 'b.id_category', '=', 'c.id')
            ->groupBy('a.id')
            ->where('a.id',$id)
            ->select('a.*','c.slug as slug_cat','c.name as cat_name')->first();
            return $items;
    }
    public static function get_tag_news($tag_id){

        $results = DB::table('tags as A')
            ->join('post_tags as B', 'A.id', '=', 'B.id_tag')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('A.id',$tag_id)
            ->groupBy('B.id_news')
            ->select('C.*')
            ->get();
            return $results;
    }
    public static function get_tag_sitemap(){

        $results = DB::table('tags as A')
            ->join('post_tags as B', 'A.id', '=', 'B.id_tag')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->groupBy('B.id_tag')
            ->select('A.*')
            ->get();
            return $results;
    }
    public static function get_category_news($category_id){

        $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('A.id',$category_id)
            ->groupBy('B.id_news')
            ->select('C.*','A.id as id_category','A.name as cat_name')
            ->get();
            return $results;
    }
    public static function get_category_news_limit($category_id,$limit){

        $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('A.id',$category_id)
            ->groupBy('B.id_news')
            ->select('C.*','A.id as id_category','A.name as cat_name')
            ->limit($limit)
            ->get();
            return $results;
    }
    public static function get_category_news_pagination($category_id){

        $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('A.id',$category_id)
            ->groupBy('B.id_news')
            ->select('C.*','A.id as id_category','A.name as cat_name')
            ->paginate(10);
            return $results;
    }
    public static function get_related_news($id){
        $category = DB::table('post_categories')->where('id_news',$id)->groupBy('id_category')->get();
        if(count($category)>0){
            $category_arr = [];
            foreach ($category as $key => $item) {
                $category_arr[] = $item->id_category;
            }
            $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('C.id','!=',$id)
            ->where('A.id',$category_arr)
            ->groupBy('B.id_news')
            ->select('C.*','A.id as id_category','A.name as cat_name')
            ->orderBy('C.created_at','desc')
            ->limit(6)
            ->get();
        }else{
            $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('C.id','!=',$id)
            ->groupBy('B.id_news')
            ->select('C.*','A.id as id_category','A.name as cat_name')
            ->limit(6)
            ->get();
        }
        
        return $results;
    }

    public static function news_hot(){

        $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->where('A.id','!=',14)
            ->select('C.*','A.id as id_category','A.name as cat_name')
            ->paginate(10);
            return $results;
    }
    public static function get_category_sitemap(){

        $results = DB::table('category as A')
            ->join('post_categories as B', 'A.id', '=', 'B.id_category')
            ->join('news as C', 'B.id_news', '=', 'C.id')
            ->groupBy('B.id_category')
            ->select('A.*')
            ->get();
            return $results;
    }
    public static function getAll()
    {
        return DB::table('news as s')->select('s.*')->get();
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('news as a')
             ->join('post_categories as b', 'a.id', '=', 'b.id_news')
            ->join('category as c', 'b.id_category', '=', 'c.id')
            ->select('a.*','c.id as id_category','c.name as cat_name')
            ->where('a.title', 'like', '%' . $params . '%')
            ->orWhere('c.name', 'like', '%' . $params . '%')
            ->groupBy('a.id')
            ->orderBy('a.id', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('news')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('news')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}