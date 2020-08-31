<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\SimOrder;
use App\Model\SimGenre;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;
class GenreController extends Controller
{
    public $module = 'genres';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request){
        return view('admin.genre.list', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request){
        $filters = $request->input('filters');
        return SimGenre::all($filters);
    }
    public function add(){
        return view('admin.genre.add', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name_genre'     => 'required',
             'regex'     => 'required',
             'detect'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('genre.add')
                ->withErrors($validator)
                ->withInput();
        }
        
        $preItem['name_genre'] = $request->input('name_genre');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
         $preItem['description'] = $request->input('description');
        $preItem['content'] = $request->input('content');
        $preItem['detect'] = $request->input('detect');
        $preItem['regex'] = $request->input('regex');
        $preItem['type_sidebar'] = $request->input('type_sidebar');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimGenre::firstOrNew($preItem);
        $result = $item->save();
        return redirect()->route('genre.list')->with('notify', sprintf('Thêm thành công %s ' . config('simsogiare.modules.' . $this->module),''));
    }
    public function edit(Request $request,$id){
        $info = SimGenre::find($id);
        return view('admin.genre.edit', array(
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
         $validator = Validator::make($request->all(), [
            'name_genre'     => 'required',
             'regex'     => 'required',
             'detect'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('genre.edit',array($id))
                ->withErrors($validator)
                ->withInput();
        }
         $preItem['name_genre'] = $request->input('name_genre');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
         $preItem['description'] = $request->input('description');
        $preItem['content'] = $request->input('content');
        $preItem['detect'] = $request->input('detect');
        $preItem['regex'] = $request->input('regex');
        $preItem['status'] = $request->input('status');
         $preItem['type_sidebar'] = $request->input('type_sidebar');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimGenre::find($id);
        $results = $item->update($preItem);
       
        $isOk = '';
        return redirect()->route('genre.edit',array($id))->with('notify', sprintf('Sửa thành công %s ' . config('simsogiare.modules.' . $this->module), $isOk));
    }
    public function destroy($params)
    {  
        $results = true;
        $results = SimGenre::destroy($params);
        $item = SimGenre::find($params);
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
            return SimGenre::search($preItems);
        }else{
            return SimGenre::all();
        }
    }

    public function All(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = SimGenre::batchRemove($data);
        }else{
            SimGenre::removeAll();
            $results = 1;
        }

        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
