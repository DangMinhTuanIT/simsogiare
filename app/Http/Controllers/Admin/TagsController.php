<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Category;
use App\Model\Tags;
use Validator,Pusher;
use Illuminate\Http\Request;
use DB;

class TagsController extends Controller
{

    public $module = 'tags';

    public function __construct(){
        $this->module_name =  ucfirst(config('pgvietnam.modules.' . $this->module));
    }

    public function index(Request $request){
        $data = Tags::getAll();
        return view('admin.tags.list', array(
            'data'=>$data,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }

    public function getData(Request $request){
        $filters = $request->input('filters');
        return Tags::all($filters);
    }


   
    public function add(){
        return view('admin.tags.add', array(
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
        ]);

        if ($validator->fails()) {
            return redirect()->route('tags.add')
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('tags.add')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('tags.add')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/tags/',$file->getClientOriginalName());
            $link = 'upload/tags/'.$file->getClientOriginalName();
            
        }

        $status = $request->status;
        $title = $request->title;
        $tags_title = Tags::where('title',$title)->first();
        if(count($tags_title)>0){
            return redirect()->route('tags.add')
                    ->withErrors('Đã tồn tại dữ liệu')
                    ->withInput();
        }
        $intro = $request->intro;
        $slug = $request->slug;
        $tags_first = Tags::where('slug',$slug)->first();
        if(count($tags_first)>0){
            $slug = $slug.'-'.count($tags_first);
        }
        $thumbnail = $link;
        $preItem['title']  = $title;
        $preItem['intro']  = $intro;
        $preItem['site_title']  = $request->site_title;
        $preItem['meta_desc']  = $request->meta_desc;
        $preItem['meta_key']  = $request->meta_key;
        $preItem['image_link']  = $thumbnail;
        $preItem['slug']  = $slug;
        $preItem['status']  = 1;
        // insert and check data empty
        $item = Tags::firstOrNew($preItem);
        $result = $item->save();
      
        $isOk = '';
        return redirect()->route('tags.list')->with('notify', sprintf('Thêm thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }
    public function edit(Request $request,$id){
        $info = Tags::find($id);
        return view('admin.tags.edit', array(
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'slug'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tags.edit')
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('tags.edit')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('tags.edit')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/tags/',$file->getClientOriginalName());
            $link = 'upload/tags/'.$file->getClientOriginalName();
            
        }else{
            $link = $request->thumbnail;
        }

          $status = $request->status;
        $title = $request->title;
        $intro = $request->intro;
        $slug = $request->slug;
        $thumbnail = $link;
        $preItem['title']  = $title;
        $preItem['intro']  = $intro;
        $preItem['site_title']  = $request->site_title;
        $preItem['meta_desc']  = $request->meta_desc;
        $preItem['meta_key']  = $request->meta_key;
        $preItem['image_link']  = $thumbnail;
        $preItem['slug']  = $request->slug;
        $preItem['status']  = $request->status;
        $item = Tags::find($id);
        $results = $item->update($preItem);
     
        $isOk = '';
        return redirect()->route('tags.list')->with('notify', sprintf('Sửa thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }
    public function show($params)
    {
        $results = Tags::find($params);
        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }



    public function destroy($params)
    {
        $results = true;
         $item = Tags::find($params);
        $results = Tags::destroy($params);
        
        if($results) {
              DB::table('post_tags')->where('id_tag',$params)->get()->each(function($analytic) {
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
            return Tags::search($preItems);
        }else{
            return Tags::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = Tags::batchRemove($data);
        }else{
            Tags::removeAll();
            $results = 1;
        }

        if($results) {
          
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
