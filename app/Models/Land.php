<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $table = 'lands';

    public $timestamps = false;

    protected $fillable = ['location', 'price', 'surface', 'predial_cost', 'predial_date'];

    public function land(){
    	return $this->belongsTo('App\Models\Land');
    }
}
