<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\SimOrder;
use App\Model\SimGenre;
use App\Model\SimBirth;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;
class SimBirthController extends Controller
{
    public $module = 'sim_birth';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request){
        return view('admin.sim_birth.list', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request){
        $filters = $request->input('filters');
        return SimBirth::all($filters);
    }
    public function add(){
        return view('admin.sim_birth.add', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name_birth'     => 'required',
             'regex'     => 'required',
             'detect'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sim_birth.add')
                ->withErrors($validator)
                ->withInput();
        }
        
        $preItem['name_birth'] = $request->input('name_birth');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
        $preItem['detect'] = $request->input('detect');
        $preItem['regex'] = $request->input('regex');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimBirth::firstOrNew($preItem);
        $result = $item->save();
        return redirect()->route('sim_birth.list')->with('notify', sprintf('Thêm thành công %s ' . config('simsogiare.modules.' . $this->module),''));
    }
    public function edit(Request $request,$id){
        $info = SimBirth::find($id);
        return view('admin.sim_birth.edit', array(
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
         $validator = Validator::make($request->all(), [
            'name_birth'     => 'required',
             'regex'     => 'required',
             'detect'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('sim_birth.edit',array($id))
                ->withErrors($validator)
                ->withInput();
        }
         $preItem['name_birth'] = $request->input('name_birth');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
        $preItem['detect'] = $request->input('detect');
        $preItem['regex'] = $request->input('regex');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimBirth::find($id);
        $results = $item->update($preItem);
       
        $isOk = '';
        return redirect()->route('sim_birth.edit',array($id))->with('notify', sprintf('Sửa thành công %s ' . config('simsogiare.modules.' . $this->module), $isOk));
    }
    public function destroy($params)
    {  
        $results = true;
        $results = SimBirth::destroy($params);
        $item = SimBirth::find($params);
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
            return SimBirth::search($preItems);
        }else{
            return SimBirth::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = SimBirth::batchRemove($data);
        }else{
            SimBirth::removeAll();
            $results = 1;
        }

        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
