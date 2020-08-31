<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class Category extends Model{
	protected $table = 'category';

    protected $fillable = [
        'name',
        'slug',
        'image_banner',
        'image_link',
        'site_title',
        'meta_desc',
        'meta_key',
        'intro',
        'parent_id',
        'status'
    ];
     public static function all($filters = [])
    {
        $q = DB::table('category as s')
            // ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*');

        $q = myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        return Datatables::queryBuilder($q)->make(true);

    }

    public static function getAll()
    {
        return DB::table('category as s')->select('s.*')->get();
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('category as s')
            ->select('s.*')
            ->where('s.name', 'like', '%' . $params . '%')
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('category')->truncate();
    }

    public static function batchRemove($params){
        return DB::table('category')
            ->whereIn('id', $params)
            ->delete();
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}