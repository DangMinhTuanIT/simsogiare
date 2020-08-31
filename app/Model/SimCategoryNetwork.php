<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class SimCategoryNetwork extends Model{
	protected $table = 'sim_category_network';

    protected $fillable = [
        'name_network',
        'slug',
        'weight',
        'description',
        'content',
        'image',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'status',
        'type',
    ];
     public static function all($filters = [])
    {
        $items = DB::table('sim_category_network as s')
        ->orderBy('s.weight','asc')
            ->select('s.*');

        $items = myHelper::buildSQL($items, $filters, 's.id', 'desc');

         return DataTables::of($items)
        ->editColumn('updated_at', function ($item) {
            return myHelper::convert_time_order($item->updated_at); 
        })
        ->editColumn('status', function ($item) {
            $class=$item->status==1 ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs';
            return '<span class="'.$class.'">'.config('simsogiare.status_category_network')[$item->status].'</span>'; 
        })
        ->rawColumns(['updated_at','status'])
        ->make(true);
    }
    
    public static function getAll()
    {
        return DB::table('sim_category_network as s')->select('s.*')->get();
    }

    public static function search($params = ''){
        $filters = [];
        $items = DB::table('sim_category_network as s')
        ->where('s.name_network', 'like', '%' . $params . '%')
        ->orderBy('s.weight','asc')
            ->select('s.*');

        $items = myHelper::buildSQL($items, $filters, 's.id', 'desc');

         return DataTables::of($items)
        ->editColumn('updated_at', function ($item) {
            return myHelper::convert_time_order($item->updated_at); 
        })
        ->editColumn('status', function ($item) {
            $class=$item->status==1 ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs';
            return '<span class="'.$class.'">'.config('simsogiare.status_category_network')[$item->status].'</span>'; 
        })
        ->rawColumns(['updated_at','status'])
        ->make(true);

    }

    public static function removeAll(){
        return DB::table('sim_category_network')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('sim_category_network')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}