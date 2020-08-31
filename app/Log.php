<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;

class Log extends Model
{
    protected $table = 'logs';

    public static function all($filters = [])
    {
        $q = DB::table('logs as s')
            ->select('*');

        $q = myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        return Datatables::queryBuilder($q)->make(true);
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('logs as s')
            ->select('*')
            ->where('s.code', 'like', '%' . $params . '%')
            ->orWhere('s.name', 'like', '%' . $params . '%')
            ->orWhere('s.message', 'like', '%' . $params . '%')
            ->orWhere('s.module', 'like', '%' . $params . '%')
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('logs')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('logs')
            ->whereIn('id', $params)
            ->delete();
    }
}
