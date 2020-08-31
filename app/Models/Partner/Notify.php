<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class Notify extends Model
{
    protected $table = 'notify';

    protected $fillable = ['name', 'url', 'type', 'to', 'author', 'editor', 'created_at', 'updated_at'];

    public static function all($filters = [])
    {
        $q = DB::table('notify as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*', 'u.name as editor_name');

        $q = \App\myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        $q = $q->where('s.to', auth()->user()->id);

        return Datatables::queryBuilder($q)->make(true);

    }

    public static function allData()
    {
        return DB::table('notify as s')
            ->select('s.*', 'u.name as editor_name')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->where('s.to', auth()->user()->id)
            ->get();
    }

    public static function getDataLimit($length = 10)
    {
        return DB::table('notify as s')
            ->select('s.*', 'u.name as editor_name')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->where('s.to', auth()->user()->id)
            ->where('s.is_read', 0)
            ->limit($length)->get();
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('notify as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.to', auth()->user()->id)
            ->where('s.name', 'like', '%' . $params . '%')
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('notify')
            ->where('to', auth()->user()->id)
            ->delete();
    }

    public static function batchRemove($params){
        return DB::table('notify')
            ->where('to', auth()->user()->id)
            ->whereIn('id', $params)
            ->delete();
    }
}
