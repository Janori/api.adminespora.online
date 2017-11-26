<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
      'email','name','first_surname','last_surname','gender','mariage_status','kind',
      'calle','colonia','cp','municipio','estado','pais',
    ];

}
