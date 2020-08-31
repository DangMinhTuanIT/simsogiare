<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'type'
    ];

	public function existed($params)
    {
        return DB::table('users as s')
            ->select('*')
            ->where('email', '=', $params['email'])
            ->get()->first();
    }

    public static function getAll()
    {
        return DB::table('users as s')
            ->select('id', 'name')
            ->get()->toArray();
    }

    public static function getCustomers()
    {
        return DB::table('users as s')
            ->select('provider_id as id', 'name')
            ->where('type', config('simsogiare.user_type.customer'))
            ->get()->toArray();
    }

    public static function all($filters = [])
    {
        $q = DB::table('users as s')
            ->join('users as u', 'u.id', '=', 's.editor')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.id', '<>', myHelper::$admins);

        $q = myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        return Datatables::queryBuilder($q)->make(true);
    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('users as s')
            ->join('users as u', 'u.id', '=', 's.editor')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.id', '<>', myHelper::$admins)
            ->where(function($query) use ($params){
                $query->where('s.name', 'like', '%'. $params . '%')
                    ->orWhere('s.email', 'like', '%'. $params . '%')
                    ->orWhere('s.role_name', 'like', '%'. $params . '%')
                    ->orWhere('u.name', 'like', '%'. $params . '%');
            })
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('users')
                ->where('id', '<>', myHelper::$admins)
                ->delete();
    }

    public static function batchRemove($params){
        return DB::table('users')
            ->where('id', '<>', myHelper::$admins)
            ->whereIn('id', $params)
            ->delete();
    }
}
