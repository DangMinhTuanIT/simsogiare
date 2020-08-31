<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\SimOrder;
use Validator,Pusher,URL;
use Illuminate\Http\Request;
use DB;
class OrderController extends Controller
{
    public $module = 'orders';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request){
        $data = SimOrder::getAll();
        return view('admin.order.list', array(
            'data'=>$data,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request){
        $filters = $request->input('filters');
        return SimOrder::all($filters);
    }
    public function edit(Request $request,$id){
        $info =  DB::table('sim_order as a')
            ->leftJoin('sim as b', 'a.id_sim', '=', 'b.id')
            ->groupBy('a.id')
            ->where('a.id',$id)
            ->select('a.*')->first();
            print_r($info);
        return view('admin.order.edit', array(
            'info' =>$info,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function update_db(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'status'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('orders.edit',array($info->id))
                ->withErrors($validator)
                ->withInput();
        }
        $status = $request->status;
        $preItem = array('status'=>$status);
        $item = SimOrder::find($id);
        $results = $item->update($preItem);
       
        $isOk = '';
        return redirect()->route('orders.list')->with('notify', sprintf('Sửa thành công %s ' . config('simsogiare.modules.' . $this->module), $isOk));
    }
    public function destroy($params)
    {  
        $results = true;
        $results = SimOrder::destroy($params);
        $item = SimOrder::find($params);
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
            return SimOrder::search($preItems);
        }else{
            return SimOrder::all();
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
