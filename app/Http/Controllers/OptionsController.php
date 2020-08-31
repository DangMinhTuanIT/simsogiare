<?php

namespace App\Http\Controllers;

use App\Options;
use Validator;
use Illuminate\Http\Request;

class OptionsController extends Controller
{

    public $module = 'options';
    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }

    public function index(Request $request)
    {

        $results = Options::all();

        return view('systems.options.list', array(
            'results' => $results,
            'module' => $this->module,
            'module_name' => $this->module_name
        ));
    }

    public function store(Request $request){}

    public function show($params){}

    public function update(Request $request)
    {
        $isOk = null;
        $allItems = $request->input('data');
        if(session()->token() == $request->input('_token')) {
            foreach ($allItems as $k=>$option) {
                $item = Options::where('o_key' , strip_tags($k))->first();
                if ($item) {
                    if($item->type != 'password') {
                        $item->o_value = strip_tags($option);
                        $item->editor = auth()->user()->id;
                        $item->save();
                        $isOk = 1;
                    }else{
                        if(!empty($option)){
                            $item->o_value = strip_tags($option);
                            $item->editor = auth()->user()->id;
                            $item->save();
                            $isOk = 1;
                        }
                    }
                }
            }
        }
        $results = Options::all();
        if($isOk) {
            event(new simsogiare((object)[
                'name' => 'Hệ thống',
                'module' => $this->module,
                'action' => config('simsogiare.actions.update'),
            ]));
            return view('systems.options.list', array(
                'results' => $results,
                'module' => $this->module,
                'module_name' => $this->module_name,
                'success' => 'Cập nhật thành công'));
        }else{
            return view('systems.options.list', array(
                'results' => $results,
                'module' => $this->module,
                'module_name' => $this->module_name,
                'error' => 'Cập nhật không thành công'));
        }
    }

    public function destroy($params){}

    public function search(Request $request){}

}
