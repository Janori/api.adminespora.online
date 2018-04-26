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
    'email_sended',
    'facturable'
  ];

  public function building(){
      return $this->belongsTo('App\Models\Building');
  }
  public function agent(){
      return $this->belongsTo('App\User');
  }
  public function provider(){
      return $this->belongsTo('App\Models\Customer');
  }
  public function requester(){
      return $this->belongsTo('App\Models\Customer');
  }

}
