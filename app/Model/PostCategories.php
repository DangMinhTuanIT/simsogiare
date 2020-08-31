<?php

namespace App\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Facades\Datatables;
use App\Options;
use App\myHelper;

class PostCategories extends Model{
	protected $table = 'post_categories';

    protected $fillable = [
        'id_news',
        'id_category',
        'datetime',
    ];
}