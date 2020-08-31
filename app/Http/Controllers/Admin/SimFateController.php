<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\SimOrder;
use App\Model\SimFate;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;
class SimFateController extends Controller
{
    public $module = 'sim_fate';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request){
        return view('admin.sim_fate.list', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request){
        $filters = $request->input('filters');
        return SimFate::all($filters);
    }
    public function add(){
        return view('admin.sim_fate.add', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name_sim_fate'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sim_fate.add')
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
                return redirect()->route('sim_fate.list')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('sim_fate.list')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $link = 'category'."-".$datetime_convert. '-' .$file->getClientOriginalName();
            $file->move(base_path().'/uploads/',$link);
            
        }
        $image = $link!='' ? $link : '';
        $preItem['name_sim_fate'] = $request->input('name_sim_fate');
        $preItem['description'] = $request->input('description');
        $preItem['content'] = $request->input('content');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $preItem['image'] = $image; 
        $item = SimFate::firstOrNew($preItem);
        $result = $item->save();
        return redirect()->route('sim_fate.list')->with('notify', sprintf('Thêm thành công %s ' . config('simsogiare.modules.' . $this->module),''));
    }
    public function edit(Request $request,$id){
        $info = SimFate::find($id);
        return view('admin.sim_fate.edit', array(
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
         $validator = Validator::make($request->all(), [
            'name_sim_fate'     => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('sim_fate.edit',array($id))
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
                return redirect()->route('sim_fate.edit',array($id))
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
        $preItem['name_sim_fate'] = $request->input('name_sim_fate');
        $preItem['slug'] = $request->input('alias');
        $preItem['description'] = $request->input('description');
        $preItem['content'] = $request->input('content');
        $preItem['weight'] = $request->input('weight');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $preItem['image'] = $image; 
        $item = SimFate::find($id);
        $results = $item->update($preItem);
       
        $isOk = '';
        return redirect()->route('sim_fate.edit',array($id))->with('notify', sprintf('Sửa thành công %s ' . config('simsogiare.modules.' . $this->module), $isOk));
    }
    public function destroy($params)
    {  
        $results = true;
        $results = SimFate::destroy($params);
        $item = SimFate::find($params);
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
            return SimFate::search($preItems);
        }else{
            return SimFate::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = SimFate::batchRemove($data);
        }else{
            SimFate::removeAll();
            $results = 1;
        }

        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
