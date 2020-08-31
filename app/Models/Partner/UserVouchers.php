<?php

namespace App\Models\Partner;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;

class UserVouchers extends Model
{
    protected $table = 'user_vouchers';

    protected $fillable = ['id', 'partner_id', 'user_vouchers_id'];

    public static function all($filters = [])
    {
        $q = DB::table('user_vouchers as s')
            ->join('partners as p', 's.partner_id', '=', 'p.id')
            ->join('bride_and_groom as bg', 's.bride_and_groom_id', '=', 'bg.id')
            ->select('bg.*');

        $q = \App\myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        $q = $q->where('s.partner_id', auth()->user()->id);

        return Datatables::queryBuilder($q)->make(true);

    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('user_vouchers as s')
            ->join('bride_and_groom as bg', 's.bride_and_groom_id', '=', 'bg.id')
            ->select('bg.*')
            ->where('s.partner_id', auth()->user()->id)
            ->where(function($query) use ($params) {
                $query->where('bg.name', 'like', '%' . $params . '%')
                    ->orWhere('bg.email', 'like', '%' . $params . '%')
                    ->orWhere('bg.phone', 'like', '%' . $params . '%')
                    ->orWhere('bg.address', 'like', '%' . $params . '%');
            })
            ->orderBy('bg.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('user_vouchers')
            ->where('partner_id', auth()->user()->id)
            ->delete();
    }

    public static function batchRemove($params){
        return DB::table('user_vouchers')
            ->where('partner_id', auth()->user()->id)
            ->whereIn('bride_and_groom_id', $params['IDs'])
            ->delete();
    }

}
