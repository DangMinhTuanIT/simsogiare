<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class Tags extends Model{
	protected $table = 'tags';

    protected $fillable = [
        'title',
        'slug',
        'intro',
        'site_title',
        'meta_desc',
        'meta_key',
        'image_link',
        'status',
    ];
     public static function all($filters = [])
    {
        $q = DB::table('tags as s')
            // ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*');

        $q = myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        return Datatables::queryBuilder($q)->make(true);

    }

    public static function getAll()
    {
        return DB::table('tags as s')->select('s.*')->get();
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('tags as s')
            ->select('s.*')
            ->where('s.title', 'like', '%' . $params . '%')
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('tags')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('tags')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}