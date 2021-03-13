
<?php

/**
* Class and Function List:
* Function list:
* - GetPositionField()
* - GetPosition()
* - GetPositions()
* - GetFriendlyColumnName()
* - GetColumnType()
* - GetColumnLength()
* - validateData()
* - FormatMoney()
* - FormatDollars()
* - UpdatePosition()
* - ImportPositions()
* - ImportHPositions()
* - ImportIncumbents()
* - ImportHIncumbents()
* - getTimestamp()
* - sessionSet()
* - sessionGet()
* - sessionForgetOne()
* Classes list:
*/

use App\Models\Post;
use App\Position;
use App\HPosition;
use App\Incumbent;
use App\HIncumbent;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;

// leave namespace out so that functions are global
//namespace App\Http\Middleware;



if (!function_exists('getTimestamp')) {
  function getTimestamp()
  {
    // this works, but the HOUR is 7 hours off from EST
    // $timestamp = date("Ymdhis");
    // return $timestamp;

    // this works, and defaults to EST (new york time)
    $tz = 'America/New_York';
    $dt = new DateTime();
    $dt->setTimezone(new DateTimeZone($tz));
    $timestamp = $dt->format('Ymd-his');
    return $timestamp;

  }
}

if (!function_exists('getTodaysDate')) {
  function getTodaysDate()
  {

    $tz = 'America/New_York';
    $date = new DateTime("now", new DateTimeZone($tz) );
    return $date->format('Y-m-d');

  }
}

if (!function_exists('sessionSet')) {
  function sessionSet($key,$value)
  {
    // example:  Session::put($key,$value);
    Session::put($key,$value);
    return true;
  }
}

if (!function_exists('sessionGet')) {
  function sessionGet($key)
  {
    // example:  Session::put($key,$value);
    $getSessionValue = Session::get($key);
    return $getSessionValue;
  }
}

if (!function_exists('sessionForgetOne')) {
  function sessionForgetOne($key)
  {
    // example:  Session::put($key,$value);
    Session::forget($key);
    return true;
  }
}
