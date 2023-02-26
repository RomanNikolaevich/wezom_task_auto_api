<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $fillable = ['make_id', 'model_id', 'model_name',];

    protected $hidden = ['created_at', 'updated_at',];
}
