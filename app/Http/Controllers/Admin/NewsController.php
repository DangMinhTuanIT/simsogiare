<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Category;
use App\Model\News;
use App\Model\Tags;
use App\Model\ProfileService;
use App\Model\PostTags;
use App\Model\PostCategories;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;

class NewsController extends Controller
{

    public $module = 'news';

    public function __construct(){
        $this->module_name =  ucfirst(config('pgvietnam.modules.' . $this->module));
    }

    public function index(Request $request){
        $data = News::getAll();
        return view('admin.news.list', array(
            'data'=>$data,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }

    public function getData(Request $request){
        $filters = $request->input('filters');
        return News::all($filters);
    }


   
    public function add(){
        $category = Category::getAll();
        $tags = Tags::getAll();
        return view('admin.news.add', array(
            'category'=>$category,
            'tags'=>$tags,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'slug'     => 'required',
            'content'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('news.add')
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('news.add')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('news.add')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/news/',$file->getClientOriginalName());
            $link = 'upload/news/'.$file->getClientOriginalName();
            
        }
         $op_vis = $request->op_vis;
        $status_news = config('pgvietnam.status_news');
        $status = $status_news[$op_vis];
        $op_date_day=$request->op_date_day;
        $op_date_month=$request->op_date_month;
        $op_date_year=$request->op_date_year;
        $op_date_hour=$request->op_date_hour;
        $op_date_minute=$request->op_date_minute;
        $op_vis = (!$op_vis) ? "0" : $op_vis;
        $op_date_day = (strlen($op_date_day) < 2) ? "0{$op_date_day}" : $op_date_day;
        $op_date = "{$op_date_year}-{$op_date_month}-{$op_date_day} {$op_date_hour}:{$op_date_minute}:00";

        $title = $request->title;
        $intro = $request->intro;
        $slug = $request->slug;
        $tags = $request->tags;
        $thumbnail = $link;
        $preItem['title']  = $title;
        $preItem['content']  = $request->content;
        $preItem['intro']  = $intro;
        $preItem['feature'] =  $request->feature;
        $preItem['meta_desc']  = $request->meta_desc;
        $preItem['site_title']  = $request->site_title;
        $preItem['meta_key']  = $request->meta_key;
        $preItem['image_link']  = $thumbnail;
        $preItem['slug']  = $request->slug;
        $preItem['status']  = $status;
        $preItem['updated_at']  = $op_date;
        $preItem['created_at']  = $op_date;
         $category_item = $request->category_item;
        // insert and check data empty
        $item = News::firstOrNew($preItem);
        $result = $item->save();
        if($result){
            if(!empty($tags)){
                foreach ($tags as $value) {
                    $data_tags=array(
                        'id_news'=>$item->id,
                        'id_tag'=>$value,
                        'datetime'=>date('Y-m-d H:i:s'),
                        );
                    $item_tags = PostTags::firstOrNew($data_tags);
                    $result_tags = $item_tags->save();
                }
            }
            if(!empty($category_item)){
                foreach ($category_item as $val) {
                    $data_category=array(
                        'id_news'=>$item->id,
                        'id_category'=>$val,
                        'datetime'=>date('Y-m-d H:i:s'),
                        );
                    $item_category = PostCategories::firstOrNew($data_category);
                    $item_category->save();
                }
            }
            
           
        }
        $isOk = '';
        return redirect()->route('news.list')->with('notify', sprintf('Thêm thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }
    public function edit(Request $request,$id){
        $info = News::find($id);
        $info =  DB::table('news as a')
            ->join('post_categories as b', 'a.id', '=', 'b.id_news')
            ->join('category as c', 'b.id_category', '=', 'c.id')
            ->groupBy('a.id')
            ->where('a.id',$id)
            ->select('a.*','c.id as id_category','c.name as cat_name')->first();
        $category = Category::getAll();
        $tags = Tags::getAll();
        $post_tags_a = PostTags::where('id_news',$info->id)->get();
        $post_category_a = PostCategories::where('id_news',$info->id)->get();
        return view('admin.news.edit', array(
            'info' =>$info,
            'tags'=>$tags,
            'post_tags_a'=>$post_tags_a,
            'post_category_a'=>$post_category_a,
            'category'=>$category,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'slug'     => 'required',
            'content'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect(URL::to('admin/news/edit/'.$id))
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('news.edit')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('news.edit')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/news/',$file->getClientOriginalName());
            $link = 'upload/news/'.$file->getClientOriginalName();
            
        }else{
            $link = $request->thumbnail;
        }
        $op_vis = $request->op_vis;
        $status_news = config('pgvietnam.status_news');
        $status = $status_news[$op_vis];
        $op_date_day=$request->op_date_day;
        $op_date_month=$request->op_date_month;
        $op_date_year=$request->op_date_year;
        $op_date_hour=$request->op_date_hour;
        $op_date_minute=$request->op_date_minute;
        $op_vis = (!$op_vis) ? "0" : $op_vis;
        $op_date_day = (strlen($op_date_day) < 2) ? "0{$op_date_day}" : $op_date_day;
        $op_date = "{$op_date_year}-{$op_date_month}-{$op_date_day} {$op_date_hour}:{$op_date_minute}:00";
        $category = $request->category;
        $title = $request->title;
        $intro = $request->intro;
        $slug = $request->slug;
        $tags = $request->tags;
        $post_tags_a = PostTags::where('id_news',$id)->get();
        $post_category_a = PostCategories::where('id_news',$id)->get();
        $thumbnail = $link;
        $preItem['title']  = $title;
         $preItem['content']  = $request->content;
        $preItem['intro']  = $intro;
        $preItem['feature'] =  $request->feature;
        $preItem['meta_desc']  = $request->meta_desc;
        $preItem['site_title']  = $request->site_title;
        $preItem['meta_key']  = $request->meta_key;
        $preItem['image_link']  = $thumbnail;
        $preItem['slug']  = $request->slug;
        $preItem['status']  = $status;
        $preItem['updated_at']  = $op_date;
        $category_item = $request->category_item;
        $item = News::find($id);
        $results = $item->update($preItem);
        if($results){
           // check tags
            if(!empty($tags) && count($tags)!=count($post_tags_a)){
                 PostTags::where('id_news',$id)->get()->each(function($analytic) {
                    $analytic->delete();
                });
                foreach ($tags as $key => $value) {
                    $data_tags=array(
                        'id_news'=>$item->id,
                        'id_tag'=>$value,
                        'datetime'=>date('Y-m-d H:i:s'),
                        );
                    $item_tags = PostTags::firstOrNew($data_tags);
                    $result_tags = $item_tags->save();
                }
            }
            // check category
              if(!empty($category_item) && count($category_item)!=count($post_category_a)){
                 PostCategories::where('id_news',$id)->get()->each(function($analytic) {
                    $analytic->delete();
                });
                foreach ($category_item as $key => $value) {
                    $data_category=array(
                        'id_news'=>$item->id,
                        'id_category'=>$value,
                        'datetime'=>date('Y-m-d H:i:s'),
                        );
                    $item_category = PostCategories::firstOrNew($data_category);
                    $item_category->save();
                }
            }
          
        }
        $isOk = '';
        return redirect()->route('news.list')->with('notify', sprintf('Sửa thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }
    public function show($params)
    {
        $results = News::find($params);
        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }



    public function destroy($params)
    {  
        $results = true;
        $results = News::destroy($params);
        $item = News::find($params);
        if($results) {
              DB::table('post_categories')->where('id_news',$params)->get()->each(function($analytic) {
                DB::table('post_categories')->where('id', $analytic->id)->delete();
            });
               DB::table('post_tags')->where('id_news',$params)->get()->each(function($analytic) {
                DB::table('post_tags')->where('id', $analytic->id)->delete();
            });
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

    public function search(Request $request){
        $preItems = $request->input('q');
        $preItems = urldecode($preItems);
        if($preItems) {
            return News::search($preItems);
        }else{
            return News::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = News::batchRemove($data);
        }else{
            News::removeAll();
            $results = 1;
        }

        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
