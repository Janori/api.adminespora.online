<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{

    protected $table = 'buildings';

    protected $fillable = ['land_id','warehouse_id','office_id','house_id',
                           'extra_data', 'owner_id','price','maintenance_cost',
                           'maintenance_period','com_percent','minimum_rent_period',
                           'deposit_number', 'kind', 'cadastral_key', 'facturable'];

    //protected $appends = ['lands', 'warehouses', 'offices', 'houses', 'image'];

    //protected $hidden = ['land', 'warehouse', 'office', 'house', 'images'];

    public function images(){
    	return $this->hasMany('App\Models\BuildingImages');
    }

    public function land(){
    	return $this->belongsTo('App\Models\Land');
    }
    public function warehouse(){
    	return $this->belongsTo('App\Models\Warehouse');
    }
    public function office(){
    	return $this->belongsTo('App\Models\Office');
    }
    public function housing(){
    	return $this->belongsTo('App\Models\Housing', 'house_id', 'id');
    }
    public function owner(){
    	return $this->belongsTo('App\Models\Housing');
    }

    public function debts(){
      return $this->hasMany('App\Models\Payment', 'building_id', 'id');
    }

    public function rents(){
      return $this->hasMany('App\Models\Rents', 'building_id', 'id');
    }

    public function tickets(){
      return $this->hasMany('App\Models\Ticket', 'building_id', 'id');
    }


}
