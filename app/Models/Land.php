<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $table = 'lands';

    public $timestamps = false;

    protected $fillable = ['for_sale','location_id', 'price', 'surface', 'predial_cost'];

    public function land(){
    	return $this->belongsTo('App\Models\Land');
    }
}
