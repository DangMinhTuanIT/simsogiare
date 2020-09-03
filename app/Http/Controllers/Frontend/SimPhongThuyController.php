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
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler,Storage;

class SimPhongThuyController extends Controller
{
    
   public function simphongthuy(Request $request){
    $items = '';
    return view('frontend.simphongthuy.index')->with([
            'data_sim'=>$items,
        ]);
   }  
   // dien giai sim phong thuy
   public function diengiai_simphongthuy(Request $request,$number,$string){
        $info =  DB::table('sim')->where('number_sim',$number)->first();
       if($info){
            return view('frontend.simphongthuy.diengiaisim.index')->with([
                'info'=>$info,
                'phone'=>$number
            ]);
       }else{
            return view('frontend.404');
       }
   }
   public function sim_phong_thuy_filter(Request $request,$string){
       
       // sim hop tuoi
      $sim_age_info =  DB::table('sim_age')->where('slug',$string)->first();
        $sim_year_info =  DB::table('sim_year')->where('slug',$string)->first();
        $info_sim_fate = DB::table('sim_fate')->where('slug',$string)->first();
        $arr_string = explode('-', $string);
      if($sim_age_info){
        $type = '';
        $items = Sim::simphongthuy_hoptuoi();
        return view('frontend.simphongthuy.hoptuoi.index')->with([
            'info'=>$sim_age_info,
            'data_sim'=>$items,
            'type'=>$type
        ]);
      }else if($sim_year_info){
       $items = Sim::simphongthuy_hopnamsinh();
       $type = 'nam-sinh-'.$sim_year_info->number_sim_year;
        return view('frontend.simphongthuy.hopnamsinh.index')->with([
            'info'=>$sim_year_info,
            'data_sim'=>$items,
            'type'=>$type
        ]);
      }else if($info_sim_fate){
        $slug = $info_sim_fate->slug;
        $type = str_replace('sim-hop-', '', $slug);
        $items = Sim::simphongthuy_hopmenh();
        return view('frontend.simphongthuy.hopmenh.index')->with([
            'info'=>$info_sim_fate,
            'data_sim'=>$items,
            'type'=>$type
        ]);
      }else if(count($arr_string)>0){
         // check du lieu
        $day = $arr_string[0];
        $month = $arr_string[1];
        $year = $arr_string[2];
        $gender = $arr_string[3];
        $giosinh = $arr_string[4];
        // get dữ liệu về
        $client = new Client();
        $client->setClient(new GuzzleClient(array(
                // DISABLE SSL CERTIFICATE CHECK
                'verify' => false,
            )));
        $link = 'https://muasim.com.vn/sim-phong-thuy/'.$day.'-'.$month.'-'.$year.'-'.$gender.'-'.$giosinh.'.html';
        $crawler = $client->request('GET',$link);
        $client->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
        $client->setHeader('Referer', 'https://muasim.com.vn/sim-phong-thuy/01-01-1959-nam-0.html');
        $client->setHeader('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9');
          $detail_replace = $crawler->filter('.ngu_hanh')->eq('0')->html();
            $simslist_block_title = $crawler->filter('.simslist_block_title')->eq('0')->html();
        return view('frontend.simphongthuy.search.index')->with([
                'ngu_hanh'=>$detail_replace,
                'day'=>$day,
                'month'=>$month,
                'year'=>$year,
                'gender'=>$gender,
                'giosinh'=>$giosinh,
                'simslist_block_title'=>$simslist_block_title,
            ]);
      } else{
        return view('frontend.404');
      }
   }
   public function check_sim_phong_thuy(Request $request){
        if(!Storage::disk('public')->exists('/upload')){
                Storage::disk('public')->makeDirectory('upload/');
            }
        $items = DB::table('sim')->whereNull('content')->limit(5000)->get();
        foreach ($items as $item_sim) {
            try {
            $info = Sim::find($item_sim->id);

            $client = new Client();
            $client->setClient(new GuzzleClient(array(
                    // DISABLE SSL CERTIFICATE CHECK
                    'verify' => false,
                )));
              $number_sim = $item_sim->number_sim;

            $link = 'https://muasim.com.vn/sim-phong-thuy/dien-giai-'.$number_sim.'/1-1-1959-nam-0.html';
            $crawler = $client->request('GET',$link);
            $client->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
            $client->setHeader('Referer', 'https://muasim.com.vn/sim-phong-thuy/01-01-1959-nam-0.html');
            $client->setHeader('Accept', 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9');
            if($crawler->filter('.content_result')->count()>0){
                $detail_replace = $crawler->filter('.content_result')->eq('0')->html();
                $detail_replace = preg_replace('/<div class="point_center">([\s\S]*?)<\/div>/', '', $detail_replace);
                preg_match_all('/src\=\"([^\"]+)/', $detail_replace, $content_image);
                $count_img = count($content_image[1]);
                // replace hinh anh
                for ($k=0; $k < $count_img; $k++) { 
                    $url =  @$content_image[1][$k];
                    $arr_image = explode('/',$url);
                    // lay ten anh
                    preg_match_all('/[^\/]+.(gif|jpe?g|tiff|png|webp|bmp)/', $content_image[1][$k], $output_array);
                    $images = @$output_array[0][0];
                    Storage::disk('public')->put('upload/'.$images, file_get_contents(@$url));
                    $image_current = ('storage/app/public/upload/'.$images);
                    $patterns = '('.$content_image[1][$k].')';
                    if($k==0){
                        $detail_replace = str_replace($content_image[1][$k],'/'.$image_current,$detail_replace);
                        $detail_replace_current = preg_replace($patterns, '/'.$image_current, $detail_replace);
                    }else{
                        $detail_replace = str_replace($content_image[1][$k],'/'.$image_current,$detail_replace);
                        $detail_replace_current = preg_replace($patterns, '/'.$image_current, $detail_replace);
                    }

                    
                    
                }
                
                // diem so cua sim theo nam
                $point_center = $crawler->filter('.point_center .text-back-d')->eq('0')->html();
                $info->update([
                    'content'=>$detail_replace_current,
                    'point_sim'=>$point_center,
                ]);
            }
            }catch (\Exception $e) {
echo    $e->getMessage();   
}
        }
   }
	
}