<?php

namespace App\Http\Controllers;

use App\Log;
use App\myHelper;
use Validator;
use Illuminate\Http\Request;
use App\User;

class LogController extends Controller
{

    public $module = 'log';
    public function __construct()
    {
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }

    public function index(Request $request)
    {
        return view('systems.log.list', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name
        ));
    }

    public function getData(Request $request){
        $filters = $request->input('filters');
        return Log::all($filters);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data.code'      => 'required',
            'data.name'      => 'required',
            'data.message'   => 'required',
            'data.module'    => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('log.list')
                ->withErrors($validator)
                ->withInput();
        }

        $preItem = $request->input('data');

        $item = new Log();
        $item->name = $preItem['name'];
        $item->module = $preItem['module'];
        $item->save();

        return redirect()->route('log.list')->with('notify', sprintf('Đã ghi log'));
    }

    public function show($params)
    {
        $results = Log::find($params);
        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

    public function update(Request $request, $params)
    {
        return response()->json(array('err' => 1, 'message' => 'Yêu cầu không hợp lệ'));
    }

    public function destroy($params)
    {
        $this->middleware(['permission:Xóa log hệ thống']);

        $results = Log::destroy($params);
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
            return Log::search($preItems);
        }else{
            return Log::all();
        }
    }

    public function removeAll(Request $request)
    {
        $this->middleware(['permission:Xóa log hệ thống']);

        $data = $request->input('data');
        $data = myHelper::validIDs($data);

        if($data){
            $results = Log::batchRemove($data);
        }else{
            Log::removeAll();
            $results = 1;
        }

        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

}
