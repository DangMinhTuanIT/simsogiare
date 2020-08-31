<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = ['name', 'code', 'content', 'partner_id', 'status'];

    public static function all($filters = [])
    {
        $q = DB::table('vouchers as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*', 'u.name as editor_name');

        $q = \App\myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        $q = $q->where('s.partner_id', '=', auth()->user()->id);

        return Datatables::queryBuilder($q)->make(true);

    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('vouchers as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.partner_id', '=', auth()->user()->id)
            ->where('s.name', 'like', '%' . $params . '%')
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function removeAll(){
        return DB::table('vouchers')
            ->where('partner_id', '=', auth()->user()->id)
            ->delete();
    }

    public static function batchRemove($params){
        return DB::table('vouchers')
            ->where('partner_id', '=', auth()->user()->id)
            ->whereIn('id', $params)
            ->delete();
    }

    public static function batchRemoveByPartner($params){
        return DB::table('vouchers')
            ->where('partner_id', '=', auth()->user()->id)
            ->whereIn('id', $params['ids'])
            ->delete();
    }

    public static function getItemByPartner(){

        return Datatables::queryBuilder(DB::table('vouchers as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*', 'u.name as editor_name')
            ->where('s.partner_id', '=', auth()->user()->id)
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where(['status' => $status, 'partner_id' => auth()->user()->id]);
    }
}
