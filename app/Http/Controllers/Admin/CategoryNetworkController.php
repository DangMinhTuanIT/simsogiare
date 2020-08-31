<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\SimOrder;
use App\Model\SimCategoryNetwork;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;
class CategoryNetworkController extends Controller
{
    public $module = 'category_networks';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request){
        return view('admin.category_networks.list', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request){
        $filters = $request->input('filters');
        return SimCategoryNetwork::all($filters);
    }
    public function add(){
        return view('admin.category_networks.add', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name_network'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('category_networks.add')
                ->withErrors($validator)
                ->withInput();
        }
        $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('category_networks.list')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('category_networks.list')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $link = 'category'."-".$datetime_convert. '-' .$file->getClientOriginalName();
            $file->move(base_path().'/uploads/',$link);
            
        }
        $image = $link!='' ? $link : '';
        $preItem['name_network'] = $request->input('name_network');
        $preItem['description'] = $request->input('description');
        $preItem['content'] = $request->input('content');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $preItem['image'] = $image; 
        $item = SimCategoryNetwork::firstOrNew($preItem);
        $result = $item->save();
        return redirect()->route('category_networks.list')->with('notify', sprintf('Thêm thành công %s ' . config('simsogiare.modules.' . $this->module),''));
    }
    public function edit(Request $request,$id){
        $info = SimCategoryNetwork::find($id);
        return view('admin.category_networks.edit', array(
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
         $validator = Validator::make($request->all(), [
            'name_network'     => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('category_networks.edit',array($id))
                ->withErrors($validator)
                ->withInput();
        }
       $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('category_networks.edit',array($id))
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('category_networks.edit',array($id))
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $link = 'category'."-".$datetime_convert. '-' .$file->getClientOriginalName();
            $file->move(base_path().'/uploads/',$link);
            
        }else{
           $link = $request->thumbnail;
        }
        $image = $link!='' ? $link : '';
        $preItem['name_network'] = $request->input('name_network');
        $preItem['slug'] = $request->input('alias');
        $preItem['description'] = $request->input('description');
        $preItem['content'] = $request->input('content');
        $preItem['weight'] = $request->input('weight');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $preItem['image'] = $image; 
        $item = SimCategoryNetwork::find($id);
        $results = $item->update($preItem);
       
        $isOk = '';
        return redirect()->route('category_networks.edit',array($id))->with('notify', sprintf('Sửa thành công %s ' . config('simsogiare.modules.' . $this->module), $isOk));
    }
    public function destroy($params)
    {  
        $results = true;
        $results = SimCategoryNetwork::destroy($params);
        $item = SimCategoryNetwork::find($params);
        if($results) {
            return response()->json(array('err' => 0, 'data' => $item));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    public function search(Request $request){
        $preItems = $request->input('q');
        $preItems = urldecode($preItems);
        if($preItems) {
            return SimCategoryNetwork::search($preItems);
        }else{
            return SimCategoryNetwork::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = SimCategoryNetwork::batchRemove($data);
        }else{
            SimCategoryNetwork::removeAll();
            $results = 1;
        }

        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
