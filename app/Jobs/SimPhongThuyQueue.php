<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Model\Sim;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler,Storage;

class SimPhongThuyQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $id_sim;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id_sim)
    {
        //
        $this->id_sim = $id_sim;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $id_sim = $this->id_sim;
            $info = Sim::find($id_sim);
            $client = new Client();
            $client->setClient(new GuzzleClient(array(
                  // DISABLE SSL CERTIFICATE CHECK
                  'verify' => false,
            )));
            $number_sim = $info->number_sim;

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
