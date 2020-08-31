<?php

namespace App\Listeners;

use App\Events\SimSoGiaRe;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Log;
use Illuminate\Support\Facades\Auth;

class StoreActivity implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SimSoGiaRe  $event
     * @return void
     */
    public function handle(SimSoGiaRe $event)
    {
       
        $knotModules = config('simsogiare.modules');
        $knotActions = config('simsogiare.actions');
        $module_name = $knotModules[$event->obj->module];
        $log = new Log();
        $log->name = $event->obj->action;
        $name = isset($event->obj->name) ? $event->obj->name : '';
        if(Auth::check() && auth()->user()->id != 1) {
            $author = auth()->user()->name;
            $id = auth()->user()->id;
        }else{
            $author = 'Hệ thống';
            $id = 1;
        }


        switch ($event->obj->action){
            case $knotActions['store'] :
                $log->message = $author . ' đã thêm '. $module_name .': ' . $name;
                break;
            case $knotActions['update']:
                $log->message = $author . ' đã cập nhật '. $module_name .': ' . $name;
                break;
            case $knotActions['destroy']:
                $log->message = $author . ' đã xóa '. $module_name .': ' . $name;
                break;
            case $knotActions['removeAll']:
                $log->message = $author . ' đã xóa tất cả '. $module_name;
                break;
            case $knotActions['changeList']:
                $log->message = $author . ' thay đổi danh sách '. $module_name;
                break;
            case $knotActions['approved']:
                $log->message = $author . ' đã phê duyệt ' . $name;
                break;
            case $knotActions['not_approved']:
                $log->message = $author . ' không phê duyệt '. $name;
                break;
            case $knotActions['send']:
                $log->message = $author . ' đã gửi tin nhắn đến '. $name;
                break;
            case $knotActions['import']:
                $num = isset($event->obj->num) ? $event->obj->num : 0;
                $log->message = $author . ' đã import thành công: ' . number_format($num) . ' ' . $module_name;
                break;
            default: return;
        }

        $log->module = $module_name;
        $log->author = $id;
        $log->save();
    }

    public function failed(SimSoGiaRe $event, $exception)
    {
        //
    }
}
