<?php

namespace App\Http\Controllers;

use Validator;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Socialite;

class UserController extends Controller
{

    public $module = 'user';
    public function __construct()
    {
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }

    public function index(Request $request)
    {
        $results = User::all();
        $roles = Role::getAll();

        $u_filters = $request->all();
        $users = User::getAll();

        $status = [];
        foreach (config('simsogiare.status') as $_status){
            $status[] = ['name' => $_status, 'value' => $_status];
        }

        $filters = [
            'editor'    => [
                'name'      => 'Cập nhật bởi',
                'options'   => $users,
                'default'   => ''
            ],
            'status'    => [
                'name'      => 'Trạng thái',
                'options'   => $status,
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

        return view('systems.user.list', array(
            'results' => $results,
            'roles' => $roles,
            'filters'   => $filters,
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }

    public function getData(Request $request){
        $filters = $request->input('filters');
        return User::all($filters);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data.*.name'    => 'required',
            'data.*.email'   => 'required',
            'data.*.password'   => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.list')
                ->withErrors($validator)
                ->withInput();
        }

        $preItems = $request->input('data');

        $isOk = 0;
        foreach ($preItems as $preItem){
            $item = new User();
            $item->name = $preItem['name'];
            $item->email = $preItem['email'];
            $item->password = bcrypt($preItem['password']);
            $item->author = auth()->user()->id;
            $item->editor = auth()->user()->id;
            $item->status = config('simsogiare.status.active');
            $item->type = $preItem['type'];;
            $result = $item->save();
            if ($result) {
				if(isset($preItem['roles']) && $preItem['roles']){
					$item->role_name = implode(', ', $preItem['roles']);
					$item->assignRole($preItem['roles']);
				}
                $item->save();
                event(new simsogiare((object)[
                    'name'      => $item->name,
                    'module'    => $this->module,
                    'action'    => config('simsogiare.actions.store'),
                ]));
                $isOk++;
            }
        }
        return redirect()->route('user.list')->with('notify', sprintf('Thêm thành công %s thành viên', $isOk));
    }

    public function show()
    {
        $results = User::where('id', '=', auth()->user()->id)->first();
        if($results) {
            return view('systems.user.item', array('item' => $results, 'module' => $this->module, 'module_name' => $this->module_name));
        }else{
            return view('access_denied');
        }
    }

    public function showUserInfo($params)
    {
        $results = User::find($params);
        if($results) {
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

    public function update(Request $request, $params)
    {
        $results = null;
        $item = User::find($params);
        if($item) {

            $email = $request->input('email');
            if($email && $email != $item->email){
                $exist = User::where('email', $email)->first();
                if($exist){
                    return response()->json(array('err' => 1, 'message' => 'Email này đã có người sử dụng'));
                }
            }
            $item->editor = auth()->user()->id;
            $item->status = $request->input('status');
            $item->name = $request->input('name');
            $item->phone = $request->input('phone');
            $item->address = $request->input('address');
            $password = $request->input('password');
            if($password && !empty($password)){
                $item->password = bcrypt($password);
            }
            $roles = $request->input('roles');
            if($roles) {
                $item->role_name = implode(', ', $roles);
                $item->syncRoles($roles);
            }
            if($email){
                $item->email = $email;
            }

            $results = $item->save();
        }
        if($results) {
            $data = [
                'name'          => $item->name,
                'role_name'     => $item->role_name,
                'editor_name'   => auth()->user()->name,
                'type'          => $item->type,
                'updated_at'    => $item->updated_at,
                'status'        => $item->status,
            ];
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

    public function profile(Request $request)
    {
        $results = null;
        $data = $request->input('data');
        $item = User::find(auth()->user()->id);
        if($item) {
            $item->editor = auth()->user()->id;
            if($data['name']){
                $item->name = $data['name'];
            }
            /*
            if($data['email']) {
                $item->email = $data['email'];
            }
            */
            if($data['phone']) {
                $item->phone = $data['phone'];
            }
            $item->address = $data['address'];
            if($data['name']){
                $item->password = bcrypt($data['password']);
            }
            $results = $item->save();
        }
        if($results) {
            $data = $item->toArray();
            $data['editor_name'] = auth()->user()->name;
            event(new simsogiare((object)[
                'name'      => $item->name,
                'module'    => $this->module,
                'action'    => config('simsogiare.actions.update'),
            ]));
            return redirect()->route('profile.info')->with('notify', sprintf('Cập nhật thành công'));
        }else{
            return redirect()->route('profile.info')->with('notify', sprintf('Cập nhật thất bại'));
        }
    }

    public function destroy($params)
    {
        $item = User::find($params);
        $results = User::destroy($params);
        if($results) {
            event(new simsogiare((object)[
                'name'      => $item->name,
                'module'    => $this->module,
                'action'    => config('simsogiare.actions.destroy'),
            ]));
            return response()->json(array('err' => 0, 'data' => $results));
        }else{
            return response()->json(array('err' => 1, 'data' => $results));
        }
    }

    public function search(Request $request){
        $preItems = $request->input('q');
        $preItems = urldecode($preItems);
        if($preItems) {
            return User::search($preItems);
        }else{
            return User::all();
        }
    }

    public function removeAll(Request $request)
    {
        $data = $request->input('data');
        $data = \App\myHelper::validIDs($data);

        if($data){
            $results = User::batchRemove($data);
        }else{
            User::removeAll();
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
