<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class SimGetData extends Model{
	protected $table = 'sim_get_data';

    protected $fillable = [
        'price_range',
        'sim_section',
        'sim_genre',
        'sim_birth',
        'sim_category_network',
    ];
     
}