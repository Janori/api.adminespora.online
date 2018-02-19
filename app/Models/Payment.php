<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model{
  protected $table = 'payments';

  protected $fillable = [
    'charge_to',
    'pay_to',
    'building_id',
    'ticket_id',
    'charge',
    'charge_payment',
    'paying',
    'paying_payment',
    'due_date',
    'paid_out',
    'kind',
  ];

  public function charge(){
      return $this->hasOne('App\Models\Customer');
  }
  public function pay(){
      return $this->hasOne('App\Models\Customer');
  }
  public function building(){
      return $this->hasOne('App\Models\Building');
  }
  public function ticket(){
      return $this->hasOne('App\Models\Ticket');
  }
}
