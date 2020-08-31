<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\SimOrder;
use App\Model\SimGenre;
use App\Model\SimPriceRange;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;
class PriceRangeController extends Controller
{
    public $module = 'price_range';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request){
        return view('admin.price_range.list', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request){
        $filters = $request->input('filters');
        return SimPriceRange::all($filters);
    }
    public function add(){
        return view('admin.price_range.add', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name_price_range'     => 'required',
             'price_start'     => 'required',
             'price_start'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('price_range.add')
                ->withErrors($validator)
                ->withInput();
        }
        
        $preItem['name_price_range'] = $request->input('name_price_range');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
        $preItem['price_start'] = $request->input('price_start');
        $preItem['price_start_int'] = $request->input('price_start');
        $preItem['price_end'] = $request->input('price_end');
        $preItem['price_end_int'] = $request->input('price_end');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimPriceRange::firstOrNew($preItem);
        $result = $item->save();
        return redirect()->route('price_range.list')->with('notify', sprintf('Thêm thành công %s ' . config('simsogiare.modules.' . $this->module),''));
    }
    public function edit(Request $request,$id){
        $info = SimPriceRange::find($id);
        return view('admin.price_range.edit', array(
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name_price_range'     => 'required',
             'price_start'     => 'required',
             'price_start'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('price_range.edit',array($id))
                ->withErrors($validator)
                ->withInput();
        }
          $preItem['name_price_range'] = $request->input('name_price_range');
        $preItem['slug'] = $request->input('alias');
        $preItem['weight'] = $request->input('weight');
        $preItem['price_start'] = $request->input('price_start');
        $preItem['price_start_int'] = $request->input('price_start');
        $preItem['price_end'] = $request->input('price_end');
        $preItem['price_end_int'] = $request->input('price_end');
        $preItem['status'] = $request->input('status');
         $preItem['seo_title'] = $request->input('meta_title');
        $preItem['seo_keyword'] = $request->input('meta_keywords');
         $preItem['seo_description'] = $request->input('meta_description');
        $item = SimPriceRange::find($id);
        $results = $item->update($preItem);
       
        $isOk = '';
        return redirect()->route('price_range.edit',array($id))->with('notify', sprintf('Sửa thành công %s ' . config('simsogiare.modules.' . $this->module), $isOk));
    }
    public function destroy($params)
    {  
        $results = true;
        $results = SimPriceRange::destroy($params);
        $item = SimPriceRange::find($params);
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
            $results = SimPriceRange::batchRemove($data);
        }else{
            SimPriceRange::removeAll();
            $results = 1;
        }

        if($results) {
            
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
    
}
