<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model{
  protected $table = 'tickets';

  protected $fillable = [
    'requester_id',
    'data',
    'provider_id',
    'provider_cost',
    'building_id',
    'extra',
    'status',
    'price',
    'request_hash',
    'email_sended'
  ];

  public function building(){
      return $this->hasOne('App\Models\Building');
  }
  public function agent(){
      return $this->hasOne('App\User');
  }
  public function provider(){
      return $this->hasOne('App\Models\Customer');
  }
  public function requester(){
      return $this->hasOne('App\Models\Customer');
  }

}
