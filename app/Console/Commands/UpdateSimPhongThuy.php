<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App,Pusher;
use App\Model\Sim;
use App\myHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mail;
use WebService,URL;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler,Storage;

class UpdateSimPhongThuy extends Command{

    protected $signature = 'systems:update_sim_phong_thuy';
    protected $description = 'Update Sim Phong Thuy';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
    	if(!Storage::disk('public')->exists('/upload')){
	            Storage::disk('public')->makeDirectory('upload/');
	        }
    	$items = DB::table('sim')->limit(20000)->get();
    	foreach ($items as $item_sim) {
    		try {
    			$start = date('Y-m-d H-i-s');
	    		$info = Sim::find($item_sim->id);

		           $number_sim = $info->number_sim;

		         $link = 'https://muasim.com.vn/sim-phong-thuy/dien-giai-'.$number_sim.'/1-1-1959-nam-0.html';
		         $curl = curl_init();
				curl_setopt_array($curl, array(
				  CURLOPT_URL => $link,
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 0,
				  CURLOPT_FOLLOWLOCATION => true,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "GET",
				));
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				 $response = curl_exec($curl);

				curl_close($curl);
				preg_match('/<div class="content_result">([\s\S]*?)<\/div>/', $response, $output_array);
	             $detail_replace = $output_array[0];
	              $detail_replace = preg_replace('/<div class="point_center">([\s\S]*?)<\/div>/', '', $detail_replace);
	            preg_match_all('/src\=\"([^\"]+)/', $detail_replace, $content_image);
	            preg_match_all('/src\=\ ([^\>]+)/', $detail_replace, $output_array_img);
	            if(count($output_array_img)>0){
	            	foreach ($content_image[1] as $key => $value) {
		            	array_push($output_array_img[1],$value);
		            }
	            }else{
	            	$output_array_img = $content_image[1];
	            }
	             $count_img = count($output_array_img[1]);
	            for ($k=0; $k < $count_img; $k++) { 
	                $url =  $output_array_img[1][$k];
	            	if($url!='https://muasim.com.vn/'):
		                $arr_image = explode('/',$url);
		                // lay ten anh
		                preg_match_all('/[^\/]+.(gif|jpe?g|tiff|png|webp|bmp)/', $output_array_img[1][$k], $output_array);
		                $images = @$output_array[0][0];
		                Storage::disk('public')->put('upload/'.$images, @file_get_contents($url));
		                $image_current = ('storage/app/public/upload/'.$images);
		                $patterns = '('.@$output_array_img[1][$k].')';
		                if($k==0){
		                    $detail_replace = str_replace(@$output_array_img[1][$k],'/'.$image_current,$detail_replace);
		                    $detail_replace_current = preg_replace($patterns, '/'.$image_current, $detail_replace);
		                }else{
		                    $detail_replace = str_replace(@$output_array_img[1][$k],'/'.$image_current,$detail_replace);
		                    $detail_replace_current = preg_replace($patterns, '/'.$image_current, $detail_replace);
		                }
		            else:
		            	$detail_replace_current = $detail_replace;
		            endif;
	            }
	            // diem so cua sim theo nam
	            preg_match('/<div class="point_center">([\s\S]*?)<\/div>/', $response, $output_array);
	            $point_center = strip_tags($output_array[0]);
	            $point_center = str_replace('Tổng điểm: ', '', $point_center);
	            $end = date('Y-m-d H-i-s');
	               $info->update([
		              'content'=>$detail_replace_current,
		              'point_sim'=>$point_center,
		              'seo_description'=>$start.' + '.$end
		          ]);
	        }catch (\Exception $e) {
			echo	$e->getMessage();   
			}
    	}
    } 
}