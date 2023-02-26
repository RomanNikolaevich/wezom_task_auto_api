<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarMake extends Model
{
    protected $fillable = ['make_id', 'make_name',];

    protected $hidden = ['created_at', 'updated_at',];
}
