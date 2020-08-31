<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\SimOrder;
use App\Model\SimGenre;
use App\Model\SimSection;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;
class SectionController extends Controller
{
    public $module = 'genres';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request,$id){
        return view('admin.section.list', array(
            'filters' => [],
            'module' => $this->module,
            'id_section'=>$id,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request,$id){
        $filters = $request->input('filters');
        $filters['id_category'] = $id;
        return SimSection::all($filters);
    }
    public function add($id){
        $parrent  = DB::table('sim_section')->where('id_category',$id)->where('status',1)->orderBy('weight','asc')->get();
        return view('admin.section.add', array(
            'filters' => [],
            'id_section'=>$id,
            'parrent'=>$parrent,
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name_section'     => 'required',
             'number_section'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('section.add')
                ->withErrors($validator)
                ->withInput();
        }
        
        $preItem['name_section'] = $request->input('name_section');
        $preItem['slug'] = \App\myHelper::str_slug($request->input('name_section'));
        $preItem['id_category'] = $id;
        $preItem['weight'] = $request->input('weight');
        $preItem['number_section'] = $request->input('number_section');
        $preItem['status'] = $request->input('status');
        $preItem['parent_id'] = $request->input('parent_id');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimSection::firstOrNew($preItem);
        $result = $item->save();
        return redirect()->route('section.list',array($id))->with('notify', sprintf('Thêm thành công %s ' . config('simsogiare.modules.' . $this->module),''));
    }
    public function edit(Request $request,$id,$id2){
        $parrent = DB::table('sim_section')->where('id_category',$id)->where('status',1)->orderBy('weight','asc')->get();
        $info = SimSection::find($id2);
        return view('admin.section.edit', array(
            'info' =>$info,
            'filters' => [],
            'parrent'=>$parrent,
            'id_section'=>$id,
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id,$id2){
         $validator = Validator::make($request->all(), [
            'name_section'     => 'required',
             'number_section'     => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('genre.edit',array($id,$id2))
                ->withErrors($validator)
                ->withInput();
        }
         $preItem['name_genre'] = $request->input('name_genre');
        $preItem['slug'] = \App\myHelper::str_slug($request->input('name_section'));
                $preItem['weight'] = $request->input('weight');
        $preItem['detect'] = $request->input('detect');
        $preItem['parent_id'] = $request->input('parent_id');
        $preItem['regex'] = $request->input('regex');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimSection::find($id2);
        $results = $item->update($preItem);
       
        $isOk = '';
        return redirect()->route('section.edit',array($id,$id2))->with('notify', sprintf('Sửa thành công %s ' . config('simsogiare.modules.' . $this->module), $isOk));
    }
    public function destroy($params)
    {  
        $results = true;
        $results = SimSection::destroy($params);
        $item = SimSection::find($params);
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
            return SimSection::search($preItems);
        }else{
            return SimSection::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = SimSection::batchRemove($data);
        }else{
            SimSection::removeAll();
            $results = 1;
        }

        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
