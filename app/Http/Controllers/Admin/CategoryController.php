<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Category;
use Validator,Pusher;
use Illuminate\Http\Request;
use DB;

class CategoryController extends Controller
{

    public $module = 'category';

    public function __construct(){
        $this->module_name =  ucfirst(config('pgvietnam.modules.' . $this->module));
    }

    public function index(Request $request){
        $data = Category::getAll();
        return view('admin.category.list', array(
            'data'=>$data,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }

    public function getData(Request $request){
        $filters = $request->input('filters');
        return Category::all($filters);
    }


   
    public function add(){
        $category = Category::getAll();
        return view('admin.category.add', array(
            'category' =>$category,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'slug'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('category.add')
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('category.add')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('category.add')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/category/',$file->getClientOriginalName());
            $link = 'upload/category/'.$file->getClientOriginalName();
            
        }

        $status = $request->status;
        $name = $request->name;
        $intro = $request->intro;
        $slug = $request->slug;
        $thumbnail = $link;
        $preItem['name']  = $name;
        $preItem['intro']  = $intro;
        $preItem['site_title']  = $request->site_title;
        $preItem['meta_desc']  = $request->meta_desc;
        $preItem['meta_key']  = $request->meta_key;
        $preItem['parent_id']  = $request->parent_id;
        $preItem['image_link']  = $thumbnail;
        $preItem['slug']  = $request->slug;
        $preItem['sort_order']  = 1;
        $preItem['status']  = 1;
        // insert and check data empty
        $item = Category::firstOrNew($preItem);
        $result = $item->save();
       
        $isOk = '';
        return redirect()->route('category.list')->with('notify', sprintf('Thêm thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }
    public function edit(Request $request,$id){
          $category = Category::getAll();
        $info = Category::find($id);
        return view('admin.category.edit', array(
            'category'=>$category,
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'slug'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('category.edit')
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('category.edit')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('category.edit')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/category/',$file->getClientOriginalName());
            $link = 'upload/category/'.$file->getClientOriginalName();
            
        }else{
            $link = $request->thumbnail;
        }

          $status = $request->status;
        $name = $request->name;
        $intro = $request->intro;
        $slug = $request->slug;
        $thumbnail = $link;
        $preItem['name']  = $name;
        $preItem['intro']  = $intro;
        $preItem['site_title']  = $request->site_title;
        $preItem['meta_desc']  = $request->meta_desc;
        $preItem['meta_key']  = $request->meta_key;
        $preItem['image_link']  = $thumbnail;
        $preItem['slug']  = $request->slug;
         $preItem['parent_id']  = $request->parent_id;
        $preItem['status']  = $request->status;
         $preItem['sort_order']  = 1;
        $item = Category::find($id);
        $results = $item->update($preItem);
        
        $isOk = '';
        return redirect()->route('category.list')->with('notify', sprintf('Sửa thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }
    public function show($params)
    {
        $results = Category::find($params);
        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }



    public function destroy($params)
    {
        $results = Category::destroy($params);
        if($results) {
            // xoa cac post lien quan
            DB::table('post_categories')->where('id_category',$params)->get()->each(function($analytic) {
                DB::table('post_categories')->where('id', $analytic->id)->delete();
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
            return Category::search($preItems);
        }else{
            return Category::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = Category::batchRemove($data);
        }else{
            Category::removeAll();
            $results = 1;
        }

        if($results) {
          
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
