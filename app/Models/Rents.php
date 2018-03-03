<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rents extends Model{

  protected $table = 'rents';

  protected $fillable = [
    'renter_id',
    'user_id',
    'building_id',
    'extra_data',
    'price',
    'rent_period',
    'start_date',
    'mantainance_cost',
    'mantainance_period',
    'commission_percent',
    'deposits_number'
  ];

  public function renter(){
      return $this->belongsTo('App\Models\Customer');
  }
  public function agent(){
      return $this->hasOne('App\User');
  }
  public function building(){
      return $this->hasOne('App\Models\Building');
  }

}
