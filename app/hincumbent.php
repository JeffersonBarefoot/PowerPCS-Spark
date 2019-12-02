<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hincumbent extends Model
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
