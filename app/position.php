<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    protected $fillable = [
      'company',
      'posno',
      'descr'
    ];
}
