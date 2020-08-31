<?php

namespace App\Http\Controllers;

use Validator;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Socialite;

class RoleController extends Controller
{

    public $module = 'role';
    public function __construct()
    {
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }

    public function index(Request $request)
    {
        $roles = Role::all();
        $permissions = Role::permissions_all();

        $u_filters = $request->all();
        $users = User::getAll();
        $filters = [
            'editor'    => [
                'name'      => 'Cập nhật bởi',
                'options'   => $users,
                'default'   => ''
            ],
            'updated_at'    => [
                'name'      => 'Ngày cập nhật',
                'options'   => [
                    ['name' => 'Mới nhất', 'value' => 'desc'],
                    ['name' => 'Cũ nhất', 'value' => 'asc']
                ],
                'default'   => ''
            ],
        ];
        if($u_filters){
            foreach ($filters as $k => $filter){
                if(isset($u_filters[$k])){
                    $filters[$k]['default'] = htmlspecialchars($u_filters[$k]);
                }
            }
        }

        return view('systems.role.list', array(
            'roles' => $roles,
            'permissions' => $permissions,
            'filters'   => $filters,
            'module' => $this->module,
            'module_name' => $this->module_name
        ));
    }

    public function getData(Request $request){
        $filters = $request->input('filters');
        return Role::all($filters);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data.*.name'               => 'required',
            'data.*.permissions'        => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('role.list')
                ->withErrors($validator)
                ->withInput();
        }

        $preItems = $request->input('data');

        $isOk = 0;
        foreach ($preItems as $preItem){
            $item = Role::create([
                'name'              => $preItem['name'],
                'author'            => auth()->user()->id,
                'editor'            => auth()->user()->id,
                'permission_name'   => implode(', ', $preItem['permissions'])
            ]);
            if ($item) {
                $item->givePermissionTo($preItem['permissions']);
                $isOk++;
                event(new simsogiare((object)[
                    'name'      => $item->name,
                    'module'    => $this->module,
                    'action'    => config('simsogiare.actions.store'),
                ]));
            }
        }
        return redirect()->route('role.list')->with('notify', sprintf('Thêm thành công %s vai trò', $isOk));
    }

    public function show($params)
    {
        $results = Role::find($params)->toArray();
        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

    public function update(Request $request, $params)
    {
        $results = null;
        $item = Role::find($params);
        if($item) {
            $item->name = $request->input('name');
            if(!$item->is_system) {
                $item->syncPermissions($request->input('permissions'));
                $item->permission_name   = implode(', ', $request->input('permissions'));
                $results = 1;
                $item->save();
            }else{
                return response()->json(array('err' => 1, 'message' => 'Không thể thay đổi vai trò này'));
            }

        }
        if($results) {
            $data = array(
                'id'                    => $item->id,
                'name'                  => $item->name,
                'permission_name'       => $item->permission_name,
                'editor_name'           => auth()->user()->name,
                'updated_at'            => $item->updated_at,
            );
            event(new simsogiare((object)[
                'name'      => $item->name,
                'module'    => $this->module,
                'action'    => config('simsogiare.actions.update'),
            ]));
            return response()->json(array('err' => 0, 'data' => $data));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

    public function destroy($params)
    {
        $item = Role::find($params);
        if(!$item->is_system) {
            $results = Role::destroy($params);
            if ($results) {
                event(new simsogiare((object)[
                    'name'      => $item->name,
                    'module'    => $this->module,
                    'action'    => config('simsogiare.actions.destroy'),
                ]));
                return response()->json(array('err' => 0, 'data' => $results));
            } else {
                return response()->json(array('err' => 1, 'data' => $results));
            }
        }else{
            return response()->json(array('err' => 1, 'message' => 'Không thể xóa vai trò này'));
        }
    }

    public function search(Request $request){
        $preItems = $request->input('q');
        $preItems = urldecode($preItems);
        if($preItems) {
            return Role::search($preItems);
        }else{
            return Role::all();
        }
    }

    public function removeAll(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = Role::batchRemove($data);
        }else{
            Role::removeAll();
            $results = 1;
        }

        if($results) {
            event(new simsogiare((object)[
                'name'      => '',
                'module'    => $this->module,
                'action'    => config('simsogiare.actions.removeAll'),
            ]));
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }
}
