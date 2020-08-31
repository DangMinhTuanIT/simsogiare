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
   public function sim_phong_thuy_filter(Request $request,$string){
        $arr_string = explode('-', $string);
       echo $day = $arr_string[0];
      echo  $month = $arr_string[1];
      echo  $year = $arr_string[2];
      echo  $gender = $arr_string[3];
       echo $giosinh = $arr_string[4];
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