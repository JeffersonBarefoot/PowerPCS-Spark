<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class incumbent extends Model
{
  protected $fillable = [
      'fname',
      'lname',
      'annual',
      'salary',
      'Company',
      'posno'
  ];
}
