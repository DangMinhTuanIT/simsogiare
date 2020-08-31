<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class Role extends \Spatie\Permission\Models\Role
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function allItems(){
        return DB::table('roles as s')
            ->select('*')
            ->get();
    }

    public static function all($filters = [])
    {
        $q = DB::table('roles as s')
            ->join('users as u', 'u.id', '=', 's.editor')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.name', '<>', 'super-admin');

        $q = myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        return Datatables::queryBuilder($q)->make(true);
    }

    public static function getAll()
    {
        return DB::table('roles as s')
            ->join('users as u', 'u.id', '=', 's.editor')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.name', '<>', 'super-admin')
            ->orderBy('s.updated_at', 'desc')
            ->get();
    }

    public static function permissions_all(){
        return DB::table('permissions as s')
            ->select('s.*')
            ->get();
    }

    public static function user_has_permissions(){
        return DB::table('user_has_permissions as s')
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function user_has_roles(){
        return DB::table('user_has_roles as s')
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function role_has_permissions(){
        return DB::table('role_has_permissions as s')
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function search($params){
        return Datatables::queryBuilder(DB::table('roles as s')
            ->join('users as u', 'u.id', '=', 's.editor')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.name', '<>', 'super-admin')
            ->where(function($query) use ($params){
                $query->where('s.name', 'like', '%'. $params . '%')
                    ->orWhere('u.name', 'like', '%'. $params . '%');
            })
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('roles')
            ->where('is_system', '=', 0)
            ->delete();
    }

    public static function batchRemove($params){
        return DB::table('roles')
            ->where('is_system', '=', 0)
            ->whereIn('id', $params)
            ->delete();
    }
}
