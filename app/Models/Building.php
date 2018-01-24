<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{

    protected $table = 'buildings';

    protected $fillable = ['land_id','warehouse_id','office_id','house_id',
                           'extra_data', 'owner_id','price','maintenance_cost',
                           'maintenance_period','com_percent','minimum_rent_period',
                           'deposit_number', 'kind'];

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


}
