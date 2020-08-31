<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class SimPriceRange extends Model{
	protected $table = 'sim_price_range';

    protected $fillable = [
        'name_price_range',
        'slug',
        'price_start',
        'price_start_int',
        'price_end',
        'price_end_int',
        'description',
        'content',
        'weight',
        'detect',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'status',
        'type',
    ];
     public static function all($filters = [])
    {
        $items = DB::table('sim_price_range as s')
        ->orderBy('s.weight','asc')
            ->select('s.*');

        $items = myHelper::buildSQL($items, $filters, 's.id', 'desc');

         return DataTables::of($items)
        ->editColumn('price_start_int', function ($item) {
            return myHelper::convert_money($item->price_start_int); 
        })
        ->editColumn('price_end_int', function ($item) {
            return myHelper::convert_money($item->price_end_int); 
        })
        ->editColumn('status', function ($item) {
            $class=$item->status==1 ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs';
            return '<span class="'.$class.'">'.config('simsogiare.status_category_network')[$item->status].'</span>'; 
        })
        ->rawColumns(['price_start_int','price_end_int','status'])
        ->make(true);

    }
    
    public static function getAll()
    {
        return DB::table('sim_price_range as s')->select('s.*')->get();
    }

    public static function search($params = ''){
         $filters = [];
        $items = DB::table('sim_price_range as s')
        ->orderBy('s.weight','asc')
        ->where('s.sim_price_range', 'like', '%' . $params . '%')
            ->select('s.*');

        $items = myHelper::buildSQL($items, $filters, 's.id', 'desc');

         return DataTables::of($items)
         ->editColumn('price_start_int', function ($item) {
            return myHelper::convert_money($item->price_start_int); 
        })
        ->editColumn('price_end_int', function ($item) {
            return myHelper::convert_money($item->price_end_int); 
        })
        ->editColumn('status', function ($item) {
            $class=$item->status==1 ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs';
            return '<span class="'.$class.'">'.config('simsogiare.status_category_network')[$item->status].'</span>'; 
        })
        ->rawColumns(['price_start_int','price_end_int','status'])
        ->make(true);
    }

    public static function removeAll(){
        return DB::table('sim_price_range')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('sim_price_range')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}