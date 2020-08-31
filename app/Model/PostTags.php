<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class PostTags extends Model{
	protected $table = 'post_tags';

    protected $fillable = [
        'id_news',
        'id_tag',
        'datetime',
    ];
}