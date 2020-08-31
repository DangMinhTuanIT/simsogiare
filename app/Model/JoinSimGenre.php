<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class JoinSimGenre extends Model{
    public $timestamps = false;
	protected $table = 'join_sim_genre';

    protected $fillable = [
        'id_sim',
        'id_genre',
        
    ];
   
}