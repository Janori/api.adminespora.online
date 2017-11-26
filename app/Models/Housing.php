<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Housing extends Model
{
    protected $table = 'housings';

    public $timestamps = false;

    protected $fillable = ['rooms', 'kind'];

}
