<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class Setting extends Model{
    protected $table = 'settings';

    protected $fillable = [
        'name_setting',
        'value_setting',
        'image',
        'status',
    ];
     public static function all($filters = [])
    {
        $q = DB::table('settings as s')
            ->select('s.*');
        $q = myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        return Datatables::queryBuilder($q)->make(true);

    }

    public static function getAll()
    {
        return DB::table('settings as s')->select('s.*')->get();
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('settings as s')
            ->select('s.*')
            ->where('s.name_setting', 'like', '%' . $params . '%')
            ->orWhere('u.value_setting', 'like', '%' . $params . '%')
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('settings')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('settings')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}