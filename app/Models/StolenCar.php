<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StolenCar extends Model
{
    protected $fillable = ['name', 'number', 'color', 'vin', 'make', 'model', 'model_year'];

    protected $hidden = ['created_at', 'updated_at',];

}
