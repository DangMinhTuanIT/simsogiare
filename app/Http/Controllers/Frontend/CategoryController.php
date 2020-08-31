<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\myHelper;
use Validator;
use Illuminate\Http\Request;
use Goutte\Client;
use App\Model\Sim;
use App\Model\SimOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use WebService,URL;


class CategoryController extends Controller
{
    public function order_sim(Request $request){
         $validator = Validator::make($request->all(), [
            'name_customer'     => 'required',
            'address_customer'     => 'required',
            'phone_customer'=>'required',
            'email_customer'=>'required',

        ],
        [
            'name_customer.required'=>'Tên là trường bắt buộc',
            'address_customer.required'=>'Địa chỉ là trường bắt buộc',
            'phone_customer.required'=>'Số điện thoại là trường bắt buộc',
            'email_customer.required'=>'Email là trường bắt buộc',
        ]
        );

        if ($validator->fails()) {
            return redirect(URL::previous())
                ->withErrors($validator)
                ->withInput();
        }
        $id_sim=$request->id_sim;
        $name_customer=$request->name_customer;
        $email_customer=$request->email_customer;
        $phone_customer=$request->phone_customer;
        $address_customer=$request->address_customer;
        $note_customer=$request->note_customer;
       $info_sim =  Sim::find($id_sim);
       $phone_sim = $info_sim->number_sim;
       $price = $info_sim->price;
         $data = array(
            'id_sim'=>$id_sim,
            'price'=>$price,
            'phone_sim'=>$phone_sim,
            'note_customer' => $note_customer,
            'address_customer' => $address_customer,
            'phone_customer'=>$phone_customer,
            'email_customer' => $email_customer,
            'name_customer' => $name_customer,
            'type'=>1,
            'status'=>1
        );
        $respons =SimOrder::firstOrNew($data);
        $respons->save();
        return redirect(URL::previous())->with('notify', sprintf('Thêm thành công %s ', ''));
    }
    public function category_detail1slug($slug1){
    	// truong hop la genre
    	$info_category_network = DB::table('sim_category_network')->where('slug',$slug1)->first();
        //
        $dauso_id = 0;
        $slug_cat = '';
        $type_sidebar = 1;
        $filter_according = '';
        $info_price = DB::table('sim_price_range')->where('slug',$slug1)->first();
    		//truong hop la nha mang
    	$info_genre = DB::table('sim_genre')->where('slug',$slug1)->first();
    	if($info_category_network || !empty($info_category_network)){
            // order by
            if(@($_GET['order'])){
                 $items = Sim::category_network($slug1,'order',$_GET['order']);
                 // order theo gia va string la the loai
            }else if(@($_GET['price'])){
                 $items = Sim::category_network($slug1,'price',$_GET['price']);
                 // string la the loai
            }else if($slug1){
                $items = Sim::category_network($slug1);
            }
            $type = 'category_network';
            $category = $info_category_network;
            $name_cat = $category->name_network;
            // dau so chi di theo nha mang
            $dauso_id = $category->id;
             $slug_cat = $category->slug;

             $filter_according = 'category_network';
            // category theo gia
    	}else if($info_price || !empty($info_price)){
            // order by
            if(@($_GET['order'])){
                 $items = Sim::category_price_range($slug1,'order',$_GET['order']);
                 // order theo gia va string la the loai
            }else if(@($_GET['price'])){
                 $items = Sim::category_price_range($slug1,'price',$_GET['price']);
                 // string la the loai
            }else if($slug1){
                $items = Sim::category_price_range($slug1);
            }
            $type = 'category_price_range';
            $category = $info_price;
            $name_cat = $category->name_price_range;
            $filter_according = 'price';
            // category theo the loai
        }else if ($info_genre || !empty($info_genre)){
            // order by
            if(@($_GET['order'])){
                 $items = Sim::category_genre($slug1,'order',$_GET['order']);
                 // order theo gia va string la the loai
            }else if(@($_GET['price'])){
                 $items = Sim::category_genre($slug1,'price',$_GET['price']);
                 // string la the loai
            }else if($slug1){
                $items = Sim::category_genre($slug1);
            }
           $type = 'category_genre';
           $category = $info_genre;
           $name_cat = $category->name_genre;
    	}else{
            return view('frontend.404');
        }
    	
    	// truong hop la gia
    	// truong hop la
    	return view('frontend.category.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'filter_according'=>$filter_according,
            'slug1'=>$slug1,
            'category'=>$category,
            'name_cat'=>$name_cat]);
	}
	public function category_detail2slug($slug1,$slug2){
        // truong hop la genre
        $info_category_network = DB::table('sim_category_network')->where('slug',$slug1)->first();
        //
        $dauso_id = 0;
        $slug_cat = '';
        $type_sidebar = 1;
        $filter_according = '';
        $info_price = DB::table('sim_price_range')->where('slug',$slug1)->first();
            //truong hop la nha mang
        $info_genre = DB::table('sim_genre')->where('slug',$slug1)->first();
        if($info_category_network || !empty($info_category_network)){
            // order by
            if(@($_GET['order'])){
                 $items = Sim::category_network_filter($slug1,$slug2,'order',$_GET['order']);
                 // order theo gia va string la the loai
            }else if(@($_GET['price'])){
                 $items = Sim::category_network_filter($slug1,$slug2,'price',$_GET['price']);
                 // string la the loai
            }else if($slug1){
                $items = Sim::category_network_filter($slug1,$slug2);
            }
            $type = 'category_network';
            $category = $info_category_network;
            $name_cat = $category->name_network;
            // dau so chi di theo nha mang
            $dauso_id = $category->id;
             $slug_cat = $category->slug;
             $filter_according = 'category_network';
            // category theo gia
        }else if($info_price || !empty($info_price)){
             // order by
            if(@($_GET['order'])){
                 $items = Sim::category_price_range_filter($slug1,$slug2,'order',$_GET['order']);
                 // order theo gia va string la the loai
            }else if(@($_GET['price'])){
                 $items = Sim::category_price_range_filter($slug1,$slug2,'price',$_GET['price']);
                 // string la the loai
            }else if($slug1){
                $items = Sim::category_price_range_filter($slug1,$slug2);
            }
            $type = 'category_price_range';
            $category = $info_price;
            $name_cat = $category->name_price_range;
            $filter_according = 'price';
            // category theo the loai
        }else if ($info_genre || !empty($info_genre)){
           // order by
            if(@($_GET['order'])){
                 $items = Sim::category_genre_filter($slug1,$slug2,'order',$_GET['order']);
                 // order theo gia va string la the loai
            }else if(@($_GET['price'])){
                 $items = Sim::category_genre_filter($slug1,$slug2,'price',$_GET['price']);
                 // string la the loai
            }else if($slug1){
                $items = Sim::category_genre_filter($slug1,$slug2);
            }
           $type = 'category_genre';
           $category = $info_genre;
           $name_cat = $category->name_genre;
        }else{
            return view('frontend.404');
        }
        // truong hop la gia
        // truong hop la
        return view('frontend.category.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'filter_according'=>$filter_according,
            'slug1'=>$slug1,
            'slug2'=>$slug2,
            'category'=>$category,
            'name_cat'=>$name_cat]);
	}
	public function category_detail3slug($slug1,$slug2,$slug3,$slug4){
// truong hop la genre
        $info_category_network = DB::table('sim_category_network')->where('slug',$slug1)->first();
        //
        $dauso_id = 0;
        $slug_cat = '';
        $type_sidebar = 1;
        $filter_according = '';
        $info_price = DB::table('sim_price_range')->where('slug',$slug1)->first();
            //truong hop la nha mang
        $info_genre = DB::table('sim_genre')->where('slug',$slug1)->first();
        if($info_category_network || !empty($info_category_network)){
            $items = Sim::category_network($slug1);
            $type = 'category_network';
            $category = $info_category_network;
            $name_cat = $category->name_network;
            // dau so chi di theo nha mang
            $dauso_id = $category->id;
             $slug_cat = $category->slug;

             $filter_according = 'category_network';
            // category theo gia
        }else if($info_price || !empty($info_price)){
            $items = Sim::category_price_range($slug1);
            $type = 'category_price_range';
            $category = $info_price;
            $name_cat = $category->name_price_range;
            $filter_according = 'price';
            // category theo the loai
        }else if ($info_genre || !empty($info_genre)){
           $items = Sim::category_genre($slug1);
           $type = 'category_genre';
           $category = $info_genre;
           $name_cat = $category->name_genre;
        }else{
            return view('frontend.404');
        }
        
        // truong hop la gia
        // truong hop la
        return view('frontend.category.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'filter_according'=>$filter_according,
            'slug1'=>$slug1,
            'category'=>$category,
            'name_cat'=>$name_cat]);
	}
	public function category_detail4slug($slug1,$slug2,$slug3,$slug4){
// truong hop la genre
        $info_category_network = DB::table('sim_category_network')->where('slug',$slug1)->first();
        //
        $dauso_id = 0;
        $slug_cat = '';
        $type_sidebar = 1;
        $filter_according = '';
        $info_price = DB::table('sim_price_range')->where('slug',$slug1)->first();
            //truong hop la nha mang
        $info_genre = DB::table('sim_genre')->where('slug',$slug1)->first();
        if($info_category_network || !empty($info_category_network)){
            $items = Sim::category_network($slug1);
            $type = 'category_network';
            $category = $info_category_network;
            $name_cat = $category->name_network;
            // dau so chi di theo nha mang
            $dauso_id = $category->id;
             $slug_cat = $category->slug;

             $filter_according = 'category_network';
            // category theo gia
        }else if($info_price || !empty($info_price)){
            $items = Sim::category_price_range($slug1);
            $type = 'category_price_range';
            $category = $info_price;
            $name_cat = $category->name_price_range;
            $filter_according = 'price';
            // category theo the loai
        }else if ($info_genre || !empty($info_genre)){
           $items = Sim::category_genre($slug1);
           $type = 'category_genre';
           $category = $info_genre;
           $name_cat = $category->name_genre;
        }else{
            return view('frontend.404');
        }
        
        // truong hop la gia
        // truong hop la
        return view('frontend.category.index')->with([
            'data_sim'=>$items,
            'type'=>$type,
            'dauso_id'=>$dauso_id,
            'type_sidebar'=>$type_sidebar,
            'slug_cat'=>$slug_cat,
            'filter_according'=>$filter_according,
            'slug1'=>$slug1,
            'category'=>$category,
            'name_cat'=>$name_cat]);
	}
     
	
}