<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Model\Sim;
use App\Model\JoinSimGenre;
use App\Model\SimGenre;
use App\Model\SimGetData;
use Validator,Pusher,URL;
use App\Jobs\SimPhongThuyQueue;
use Illuminate\Http\Request,WebService;
use DB;
class SimController extends Controller
{
    public $module = 'sim';

    public function __construct(){
        $this->module_name =  ucfirst(config('simsogiare.modules.' . $this->module));
    }
    public function index(Request $request){
        $category_network = DB::table('sim_category_network')->orderBy('weight','asc')->get();
        $genre = DB::table('sim_genre')->orderBy('weight','asc')->get();
        $birth = DB::table('sim_birth')->orderBy('weight','asc')->get();
        return view('admin.sim.list', array(
            'category_network'=>$category_network,
            'genre'=>$genre,
            'birth'=>$birth,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function getData(Request $request){
        $filters = $request->input('filters');
        $id_sim_birth = $request->id_sim_birth;
        $id_category_network = $request->id_category_network;
        $id_genre = $request->id_genre;
        if($id_genre!=''){
            $filters['id_genre'] = $id_genre;
        }
        if($id_category_network!=''){
            $filters['id_category_network'] = $id_category_network;
        }
        if($id_sim_birth!=''){
            $filters['id_sim_birth'] = $id_sim_birth;
        }
        return Sim::all($filters);
    }
    public function import(){

        return view('admin.sim.import', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function import_sim(){

        return view('admin.sim.import_sim', array(
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));
    }
    public function import_sim_post(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'content'     => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->route('sim.import_sim')
        //         ->withErrors($validator)
        //         ->withInput();
        // }
        $group = $request->group !='' ? $request->group : 0;
        $prefix = $request->prefix !='' ? $request->prefix : 1;
        $content = $request->pData;
        $arr_import = explode('-', $content);
        $info_data = SimGetData::find(1);
        /*
        $items_sim_section = DB::table('sim_section as a')->join('sim_category_network as b','a.id_category','=','b.id')->orderBy('b.weight','asc')->orderBy('a.weight','asc')->where('a.parent_id','!=',0)->where('a.status',1)->select('a.id','a.id_category','a.number_section')->get();
        $arr_section = [];
        $arr_category_network = [];
        foreach ($items_sim_section as $val) {
            $arr_section[$val->id] = $val->number_section;
            $arr_category_network[$val->id_category.'_'.$val->number_section] = $val->number_section;
        }

        $info_data->update([
            'sim_section'=>serialize($arr_section),
            'sim_category_network'=>serialize($arr_category_network),
        ]);
        */
        $arr_price = unserialize($info_data->price_range);
        $arr_section = unserialize($info_data->sim_section);
        $arr_category_network = unserialize($info_data->sim_category_network);
        $arr_sim_genre = unserialize($info_data->sim_genre);
        $sim_birth = unserialize($info_data->sim_birth);
        echo count($arr_import);
        foreach ($arr_import as $key => $item) {
            // try {
                $id_price_range = 0;
                $id_section = $id_category_network = 0;
                $id_sim_birth = 0;
                $id_genre =0;
                $join_sim_genre = [];
                // step 2 tach gia tien va sim ra
                // lay gia tien
                $arr_sim = explode('|', $item);
                // lay so sim
                $sim = @$arr_sim[0];
                //step 2.1 phan loaij theo gia tien

                // tim khoang gia check theo gia ket thuc, neu <= gia bat dau thi khoang gia trong đó
                $price = @$arr_sim[1];
                foreach ($arr_price as $value) {
                   if($price>=$value['price_start_int'] && $price<=$value['price_end_int'] || $price>=$value['price_start_int'] && $value['price_end_int']==0){
                        $id_price_range = $value['id'];
                        break;
                   }
                }
                 // step 2.2 tim the loai sim
                // tim theo 3 hoac 4 so dau tien
                // check dau so va tim nhà mạng
                 $sim_int = str_replace('.', '', $sim);
                // truong hop 3 so dau
                $number_section_check = substr($sim_int, 0,3);
                $number_section_check_4 = substr($sim_int, 0,4);
                if(array_search($number_section_check, $arr_section)){
                    $id_section = array_search($number_section_check, $arr_section);
                    $id_category_network = array_search($number_section_check, $arr_category_network);
                    // truong hop 4 so dau
                }elseif (array_search($number_section_check_4, $arr_section)){
                    $id_section = array_search($number_section_check_4, $arr_section);
                    $id_category_network = array_search($number_section_check_4, $arr_category_network);
                }
                $arr_cat_network = explode('_', $id_category_network);
                $id_category_network = $arr_cat_network[0];
                $id_section;
                //step 2.3 tim nha mang theo dau so, nha mang va dau so
                // xoa het dau . va tim theo regex
                // uu tien nhung cai co weight lon truoc de check
                 $mm = 0;
                foreach ($arr_sim_genre as $item_genre) {
                    // dau tien check xem dau so là bao nhieu so
                    // check dau so voi sim và nhan ket qua vi du : 098 3 so thi check 3 so dau cua sim
                    $regex = $item_genre['regex'];
                    preg_match($regex, $sim_int, $output_array);

                    if(count($output_array)>1){
                        $mm++;
                        if($mm==1){
                            $id_genre =  $item_genre['id'];
                        }
                        $id_genre =  $item_genre['id'];
                        $join_sim_genre[] =  $id_genre;
                    }
                }
                 $id_sim_birth = 1;
                $price = $price*$prefix;
                 // if($key<5000):
                 // 'call create_sim('.$sim_int.',"'.$sim.'",'.$price.','.$id_category_network.','.$id_genre.','.$id_section.','.$id_sim_birth.','.$group.','.$id_price_range.')';
                 //     $items = DB::select(DB::raw('call create_sim('.$sim_int.',"'.$sim.'",'.$price.','.$id_category_network.','.$id_genre.','.$id_section.','.$id_sim_birth.','.$group.','.$id_price_range.')'));
                 //     echo $items[0]->id;
                 //     WebService::sim_phong_thuy($items[0]->id);
                 //     die;
                 //    foreach ($join_sim_genre as $value_sim_genre) {
                 //        DB::statement(DB::raw('call create_join_sim_genre('.$items[0]->id.','.$value_sim_genre.')'));
                 //    }
                     $params = array(
                        'number_sim'=>$sim_int,
                        'number_sim_tring'=>$sim,
                        'slug'=>$sim_int,
                        'price'=>$price,
                        'id_category_network'=>$id_category_network,
                        'id_genre'=>$id_genre,
                        'id_section'=>$id_section,
                        'id_sim_birth'=>$id_sim_birth,
                        'id_price_range'=>$id_price_range,
                        'group_sim'=>$group,
                        'status'=>1,
                        'type'=>1
                    );

                    $item_first = Sim::where('number_sim',$sim_int)->first();
                    if (!$item_first) {
                        $item = Sim::firstOrNew($params);
                        $result = $item->save();
                        SimPhongThuyQueue::dispatch($item->id);
                        // WebService::sim_phong_thuy($item->id);
                        foreach ($join_sim_genre as $value_sim_genre) {
                           JoinSimGenre::create(array('id_sim'=>$item->id,'id_genre'=>$value_sim_genre));
                        }
                    }
                // endif;

               
               
            // }catch (\Exception $e) {
            // echo    $e->getMessage();   
            // }
        }
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'content'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sim.import')
                ->withErrors($validator)
                ->withInput();
        }
        $group = $request->group !='' ? $request->group : 0;
        $prefix = $request->prefix !='' ? $request->prefix : 1;
        
        $content = $request->input('content');
        $description = preg_replace("/\r\n|\r|\n/", '<br/>', $content);
        $arr_import = explode('<br/>', $description);
        // check gia sim
        $items_price = DB::table('sim_price_range')->orderBy('weight','asc')->select('id','price_start_int','price_end_int')->get();
        $arr_price = [];
        foreach ($items_price as $item) {
            $arr_price_item = [];
            $arr_price_item['id'] = $item->id;
            $arr_price_item['price_start_int'] = $item->price_start_int;
            $arr_price_item['price_end_int'] = $item->price_end_int;
            array_push($arr_price, $arr_price_item);
        }
        // get dau so va lay nha mang cua sim
        $items_sim_section = DB::table('sim_section as a')->join('sim_category_network as b','a.id_category','=','b.id')->orderBy('b.weight','asc')->orderBy('a.weight','asc')->where('a.status',1)->select('a.id','a.id_category','a.number_section')->get();
        $arr_section = [];
        foreach ($items_sim_section as $val) {
            $arr_section_item = [];
            $arr_section_item['id'] = $val->id;
            $arr_section_item['id_category'] = $val->id_category;
            $arr_section_item['number_section'] = $val->number_section;
            array_push($arr_section, $arr_section_item);
        }
        // step 1 tach dau cach va foreach tung sim
        // khoi tao cac bien


        // check thể loại sim vidu sim ngũ quý
        $items_sim_genre = DB::table('sim_genre')->orderBy('weight','asc')->select('id','regex')->get();
        $arr_sim_genre = [];
        foreach ($items_sim_genre as $item) {
            $arr_sim_genre_item = [];
            $arr_sim_genre_item['id'] = $item->id;
            $arr_sim_genre_item['regex'] = $item->regex;
            array_push($arr_sim_genre, $arr_sim_genre_item);
        }
         $items_birth = DB::table('sim_birth')->orderBy('weight','asc')->select('id','regex')->get();
        $arr_birth = [];
        foreach ($items_birth as $val_birth) {
            $arr_birth_item = [];
            $arr_birth_item['id'] = $val_birth->id;
            $arr_birth_item['regex'] = $val_birth->regex;
            array_push($arr_birth, $arr_birth_item);
        }
        // dem so luong import vao
        $dem = 0;
        // chay vong loop import sim
        foreach ($arr_import as $key => $item) {

            // tao bien dau tien
            $id_price_range = 0;
            $id_section = $id_category_network = 0;
            $id_sim_birth = 0;
            $id_genre =0;
            $join_sim_genre = [];
            // step 2 tach gia tien va sim ra
            // lay gia tien
            $item = preg_replace("/\t/", 'space', $item);
            $arr_sim = explode('space', $item);
            // lay so sim
            $sim = $arr_sim[0];
            //step 2.1 phan loaij theo gia tien

            // tim khoang gia check theo gia ket thuc, neu <= gia bat dau thi khoang gia trong đó
            $price = $arr_sim[1];
            foreach ($arr_price as $value) {
               if($price>=$value['price_start_int'] && $price<=$value['price_end_int'] || $price>=$value['price_start_int'] && $value['price_end_int']==0){
                    $id_price_range = $value['id'];
                    break;
               }
            }

             $id_price_range;
             // step 2.2 tim the loai sim
            // tim theo 3 hoac 4 so dau tien
            // check dau so va tim nhà mạng
            $sim_int = str_replace('.', '', $sim);
            foreach ($arr_section as $key => $item_section) {
                // dau tien check xem dau so là bao nhieu so
                // check dau so voi sim và nhan ket qua vi du : 098 3 so thi check 3 so dau cua sim
                $number_first_section = strval(strlen($item_section['number_section']));
                $number_section_check = substr($sim_int, 0,$number_first_section);
                if($item_section['number_section']==$number_section_check){
                    $id_section = $item_section['id'];
                    $id_category_network = $item_section['id_category'];
                    break;
                }
            }
             $id_section;
             $id_category_network;
            //step 2.3 tim nha mang theo dau so, nha mang va dau so
            // xoa het dau . va tim theo regex
            // uu tien nhung cai co weight lon truoc de check
             $mm = 0;
            foreach ($arr_sim_genre as $item_genre) {
                // dau tien check xem dau so là bao nhieu so
                // check dau so voi sim và nhan ket qua vi du : 098 3 so thi check 3 so dau cua sim
                $regex = $item_genre['regex'];
                preg_match($regex, $sim_int, $output_array);

                if(count($output_array)>1){
                    $mm++;
                    if($mm==1){
                        $id_genre =  $item_genre['id'];
                    }
                    $id_genre =  $item_genre['id'];
                    $join_sim_genre[] =  $id_genre;
                }
            }
            // check năm sinh cua sim
            foreach ($arr_birth as $item_birth) {
                // dau tien check xem dau so là bao nhieu so
                // check dau so voi sim và nhan ket qua vi du : 098 3 so thi check 3 so dau cua sim
                $regex = $item_birth['regex'];
                preg_match($regex, $sim_int, $output_array_birth);
                if(count($output_array_birth)>0){
                    $id_sim_birth =  $item_birth['id'];
                    break;
                }
            }
            $price = $price*$prefix;
            $params = array(
                'number_sim'=>$sim_int,
                'number_sim_tring'=>$sim,
                'slug'=>$sim_int,
                'price'=>$price,
                'id_category_network'=>$id_category_network,
                'id_genre'=>$id_genre,
                'id_section'=>$id_section,
                'id_sim_birth'=>$id_sim_birth,
                'id_price_range'=>$id_price_range,
                'group'=>$group,
                'status'=>1,
                'type'=>1
            );
            // check du lieu va insert
            $item_first = Sim::where('number_sim',$sim_int)->first();
            if (@count($item_first)==0) {
                $item = Sim::firstOrNew($params);
                $result = $item->save();
                foreach ($join_sim_genre as $value_sim_genre) {
                   JoinSimGenre::create(array('id_sim'=>$item->id,'id_genre'=>$value_sim_genre));
                }
            }else{
                $item_first->update($params);
                $results = JoinSimGenre::where('id_sim',$item_first->id)->get()->each(function($analytic) {
                    $analytic->delete();
                });
                foreach ($join_sim_genre as $value_sim_genre) {
                   JoinSimGenre::create(array('id_sim'=>$item_first->id,'id_genre'=>$value_sim_genre));
                }
            }

            $dem++;
        }

        
        
       
        //step 2.3  tim theo nam sinh
        // step 3 check theo so kho
         return view('admin.sim.result', array(
            'dem' =>$dem,
            'filters' => [],
            'module' => $this->module,
            'module_name' => $this->module_name,
        ));

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
        $preItem['detect'] = $request->input('detect');
        $preItem['regex'] = $request->input('regex');
        $preItem['status'] = $request->input('status');
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
