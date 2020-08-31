<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class SimOrder extends Model{
	protected $table = 'sim_order';

    protected $fillable = [
        'name_customer',
        'phone_customer',
        'address_customer',
        'email_customer',
        'note_customer',
        'phone_sim',
        'id_sim',
        'price',
        'status',
        'type',
        'created_at',
        'updated_at'
    ];
     public static function all($filters = [])
    {
        $items = DB::table('sim_order as a')
        
            ->leftJoin('sim as b', 'a.id_sim', '=', 'b.id')
            ->groupBy('a.id')
            ->select('a.*');
        $items = myHelper::buildSQL($items, $filters, 'a.id', 'desc');
        return DataTables::of($items)
        ->editColumn('updated_at', function ($item) {
            return myHelper::time_elapsed($item->updated_at); 
        })
        ->editColumn('status', function ($item) {
            return config('simsogiare.status_order')[$item->status]; 
        })
        ->rawColumns(['updated_at'])
        ->make(true);

    }
    
    public static function getAll()
    {
        return DB::table('sim_order as s')->select('s.*')->get();
    }

    public static function search($params = ''){
        $items = DB::table('sim_order as a')
            ->leftJoin('sim as b', 'a.id_sim', '=', 'b.id')
            ->select('a.*')
            ->where('a.name_customer', 'like', '%' . $params . '%')
            ->orWhere('a.phone_customer', 'like', '%' . $params . '%')
            ->groupBy('a.id')
            ->orderBy('a.id', 'desc');
        return DataTables::of($items)
        ->editColumn('updated_at', function ($item) {
            return myHelper::time_elapsed($item->updated_at); 
        })
        ->editColumn('status', function ($item) {
            return config('simsogiare.status_order')[$item->status]; 
        })
        ->rawColumns(['updated_at'])
        ->make(true);

    }

    public static function removeAll(){
        return DB::table('sim_order')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('sim_order')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}