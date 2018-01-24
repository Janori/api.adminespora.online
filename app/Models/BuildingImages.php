<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildingImages extends Model{
  protected $table = 'building_images';

  protected $fillable = ['building_id','path'];

  public $timestamps = false;
  //protected $appends = ['lands', 'warehouses', 'offices', 'houses', 'image'];

  //protected $hidden = ['land', 'warehouse', 'office', 'house', 'images'];

  public function building(){
    return $this->belongsTo('App\Models\Building');
  }
}
