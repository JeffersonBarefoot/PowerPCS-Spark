<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hposition extends Model
{
  protected $fillable = [
    'active',
    'company',
    'posno',
    'descr'
  ];
}
