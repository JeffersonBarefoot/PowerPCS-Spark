<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class report extends Model
{
    protected $fillable = [
      'active',
      'company',
      'posno',
      'descr'
    ];
}
