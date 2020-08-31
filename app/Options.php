<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $table = 'options';

    public static function all($filters = [])
    {
        $q = DB::table('options as s')
            ->join('users as u', 's.editor', '=', 'u.id')
            ->select('s.*', 'u.name as editor_name');

        $q = myHelper::buildSQL($q, $filters, 's.group', 'asc', 1);

        return $q->get();
    }

    public static function getSMTP(){
        return DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'like', 'mail_%')
            ->get();
    }
    public static function getEmailContent(){
        return DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'email')
            ->first();
    }

    public static function getThankyou(){
        return DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'thank_you')
            ->first();
    }

    public static function getEmailThankYou(){
        return DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'verify_email')
            ->first();
    }

    public static function getEmailApprove(){
        return DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'approved')
            ->first();
    }

    public static function getEmailVoucher(){
        return DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'get_voucher')
            ->first();
    }
	
	public static function getBrandInfo(){
        $options = DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'like', 'brand_%')
            ->get();
		$conf = [];
		foreach ($options as $option) {
			$k = str_replace('brand_', '', $option->o_key);
			$conf[$k] = $option->o_value;
		}
		return $conf;
    }

    public static function getAPIToken(){
        return DB::table('options as s')
            ->select('s.*')
            ->where('s.o_key', 'api_token')
            ->first();
    }
}
