<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\DB;

class PartnerServices extends Model
{
    protected $table = 'partner_services';

    protected $fillable = ['partner_id', 'service_id'];

    public static function all($filters = [])
    {

        $q = DB::table('partner_services as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->join('partners as p', 's.partner_id', '=', 'p.id')
            ->join('services as sv', 's.service_id', '=', 'sv.id')
            ->select('s.*', 'sv.name as service_name', 'p.name as partner_name', 'u.name as editor_name')
            ->where('s.partner_id', '=', auth()->user()->id);

        $q = \App\myHelper::buildSQL($q, $filters, 's.updated_at', 'desc');

        return Datatables::queryBuilder($q)->make(true);

    }

    public static function search($params = ''){
        return Datatables::queryBuilder(DB::table('partner_services as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->join('partners as p', 's.partner_id', '=', 'p.id')
            ->join('services as sv', 'sv.service_id', '=', 'sv.id')
            ->select('s.*', 'sv.name as service_name', 'p.name as partner_name', 'u.name as editor_name')
            ->where('s.partner_id', '=', auth()->user()->id)
            ->where(function($query) use ($params) {
                $query->orWhere('u.name', 'like', '%' . $params . '%')
                    ->orWhere('c.name', 'like', '%' . $params . '%')
                    ->orWhere('sv.name', 'like', '%' . $params . '%');
            })
            ->orderBy('s.updated_at', 'desc')
        )->make(true);
    }

    public static function allData(){
        return DB::table('partner_services as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->join('services as sv', 's.service_id', '=', 'sv.id')
            ->select('s.*', 'sv.name as service_name', 'u.name as editor_name')
            ->where('s.partner_id', '=', auth()->user()->id)
            ->get();
    }

    public static function getItemByPartner(){
        return DB::table('partner_services as s')
            ->join('partners as p', 's.partner_id', '=', 'p.id')
            ->join('services as sv', 's.service_id', '=', 'sv.id')
            ->select('sv.name as service', 'p.name as partner')
            ->where('s.partner_id', '=', auth()->user()->id)
            ->get()->first();
    }

    public static function removeAll(){
        return DB::table('partner_services')
            ->where('partner_id', '=', auth()->user()->id)
            ->delete();
    }

    public static function batchRemove($params){
        return DB::table('partner_services')
            ->where('partner_id', '=', auth()->user()->id)
            ->whereIn('id', $params)
            ->delete();
    }
}
