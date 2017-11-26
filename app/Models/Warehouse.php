<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model{
    protected $table = 'warehouses';

    public $timestamps = false;

    protected $fillable = ['is_new', 'build_surface', 'building_date'];
}
