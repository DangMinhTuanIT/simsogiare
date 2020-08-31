<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Setting;
use Validator;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public $module = 'setting';

    public function __construct(){
        $this->module_name =  ucfirst(config('pgvietnam.modules.' . $this->module));
    }

    public function index(Request $request){
        return view('admin.setting.list', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }

    public function getData(Request $request){
        $filters = $request->input('filters');
        return Setting::all($filters);
    }
    public function view_setting(Request $request)
    {
        $id = $request->id;
        $info = Setting::find($id);
        return view('admin.setting.view', array(
            'info'=>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_setting'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('setting.list')
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link')) {
            $file = $request->link;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('setting.list')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('setting.list')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/setting/',$file->getClientOriginalName());
            $link = 'upload/setting/'.$file->getClientOriginalName();
            
        }
        $image = $link!='' ? $link : '';
        $preItem['value_setting'] = $request->input('value_setting');
        $preItem['name_setting'] = $request->input('name_setting');
        $preItem['status'] = 'Hoàn thành'; 
        $preItem['image'] = $image; 
        $item = Setting::firstOrNew($preItem);
        $result = $item->save();

       
        $isOk = '';
        return redirect()->route('setting.list')->with('notify', sprintf('Thêm thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }

    public function show($params)
    {
        $results = Setting::find($params);
        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    public function update_db(Request $request, $id){
         $validator = Validator::make($request->all(), [
            'name_setting'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('setting.list')
                ->withErrors($validator)
                ->withInput();
        }
        $link = '';
        if ($request->hasFile('link_v2')) {
            $file = $request->link_v2;
            $ext = $file->getClientOriginalExtension();

            if($ext != 'jpg' && $ext != 'png' && $ext !='jpeg'){
                return redirect()->route('setting.list')
                    ->withErrors('Chỉ chấp nhận hình ảnh có đuôi: jpg, png')
                    ->withInput();
            }
            $size = $file->getSize();
            if($size > 1024 * 1024 * 3){
                return redirect()->route('setting.list')
                    ->withErrors('Vui lòng nhập hình ảnh nhỏ hơn 3Mb')
                    ->withInput();
            }
            $file->move(base_path().'/upload/setting/',$file->getClientOriginalName());
            $link = 'upload/setting/'.$file->getClientOriginalName();
            
        }else{
            $link = $request->thumbnail;
        }

        $image = $link!='' ? $link : '';
        $preItem['value_setting'] = $request->input('value_setting');
        $preItem['name_setting'] = $request->input('name_setting');
        $preItem['status'] = 'Hoàn thành'; 
        $preItem['image'] = $image; 
        $item = Setting::find($id);
        $results = $item->update($preItem);
        
        $isOk = '';
        return redirect()->route('setting.list')->with('notify', sprintf('Sửa thành công %s ' . config('pgvietnam.modules.' . $this->module), $isOk));
    }

    public function update(Request $request, $params)
    {
        $results = null;
        $item = Setting::find($params);
        if($item) {
            $data = $request->all();
            $results = $item->update($data);
        }
        if($results) {
            
            $data = array(
                'id'            => $item->id,
                'name_setting'       => $item->name_setting,
                'value_setting'          => $item->value_setting,
                'updated_at'    => $item->updated_at,
            );
            return response()->json(array('err' => 0, 'data' => $data));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

    public function destroy($params)
    {
        $item = Setting::find($params);
        $results = Setting::destroy($params);
        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    public function search(Request $request){
        $preItems = $request->input('q');
        $preItems = urldecode($preItems);
        if($preItems) {
            return Setting::search($preItems);
        }else{
            return Setting::all();
        }
    }

    public function removeAll(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = Setting::batchRemove($data);
        }else{
            Setting::removeAll();
            $results = 1;
        }

        if($results) {
           
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
