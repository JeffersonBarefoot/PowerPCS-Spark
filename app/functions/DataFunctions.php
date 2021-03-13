
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

if (!function_exists('GetPositionField')) {
    function GetPositionField($employer, $posno, $fieldname)
    {
        return DB::table('positions')
          ->where('company', '=', $employer)
          ->where('posno', '=', $posno)
          ->value($fieldname);
    }
}

if (!function_exists('GetPosition')) {
    function GetPosition($employer, $posno)
    {
        return DB::table('positions')
          ->where('company', '=', $employer)
          ->where('posno', '=', $posno);
    }
}

if (!function_exists('GetPositions')) {
  function GetPositions($employer, $descr, $posno)
  {
      return DB::table('positions')
        ->where('company', '=', $employer );
      //  ->where('posno', '=', $posno);

  }
}

if (!function_exists('GetIncumbent')) {
    function GetIncumbent($employer, $empno, $poscompany, $posno)
    {
        return DB::table('incumbents')
          ->where('company', '=', $employer)
          ->where('empno', '=', $empno)
          ->where('poscompany', '=', $poscompany)
          ->where('posno', '=', $posno);
    }
}

if (!function_exists('GetIncumbentById')) {
    function GetIncumbentById($ID)
    {
        return DB::table('incumbents')
          ->where('id', '=', $ID)
          ->get();
    }
}

if (!function_exists('GetIncumbents')) {
    function GetIncumbents($poscompany, $posno)
    {
        return DB::table('incumbents')
          ->where('poscompany', '=', $poscompany)
          ->where('posno', '=', $posno)
          ->get();
    }
}

if (!function_exists('GetActiveIncumbents')) {
    function GetActiveIncumbents($poscompany, $posno)
    {
        return DB::table('incumbents')
          ->where('poscompany', '=', $poscompany)
          ->where('posno', '=', $posno)
          ->where ('active_pos','=','A')
          ->get();
    }
}

if (!function_exists('GetHIncumbent')) {
    function GetHIncumbent($employer, $empno, $poscompany, $posno)
    {
        return DB::table('hincumbents')
          ->where('company', '=', $employer)
          ->where('empno', '=', $empno)
          ->where('poscompany', '=', $poscompany)
          ->where('posno', '=', $posno)
          ->orderby('trans_date','desc')
          ->get();
    }
}

if (!function_exists('GetHIncumbentRecordById')) {
    function GetHIncumbentRecordById($ID)
    {
        return DB::table('hincumbents')
          ->where('id', '=', $ID)
          ->get();
    }
}

// DON"T RELY ON THIS.  Need to include poscompany and posno to be complete
if (!function_exists('GetIncumbentField')) {
    function GetIncumbentField($employer, $empno, $fieldname)
    {
        return DB::table('incumbents')
          ->where('company', '=', $employer)
          ->where('empno', '=', $empno)
          ->value($fieldname);
    }
}

if (!function_exists('GetIncumbentFieldById')) {
    function GetIncumbentFieldById($ID,$fieldname)
    {
        return DB::table('incumbents')
        ->where('id', '=', $ID)
        ->value($fieldname);
    }
}

if (!function_exists('GetFriendlyColumnName')) {
  function GetFriendlyColumnName($table, $column)
  {

    $friendlyName = DB::table('Information_Schema.Columns')
      ->select('COLUMN_COMMENT')
      ->where('TABLE_NAME', '=', $table)
      ->where('COLUMN_NAME', '=', $column)
      ->value('user_id');

    if (trim($friendlyName) == '') {
      return $column;
    } else {
      return $friendlyName;
    }
  }
}

if (!function_exists('GetColumnType')) {
  function GetColumnType($table, $column)
  {
    $dataType = DB::table('Information_Schema.Columns')
      ->select('DATA_TYPE')
      ->where('TABLE_NAME', '=', strtolower($table))
      ->where('COLUMN_NAME', '=', strtolower($column))
      ->value('user_id');

    if (($dataType) == '') {
      return 'Error - Column Does Not Exist';
    } else {
      return $dataType;
    }
  }
}

if (!function_exists('GetColumnLength')) {
  function GetColumnLength($table, $column)
  {
    $columnLength = DB::table('Information_Schema.Columns')
      ->select('CHARACTER_MAXIMUM_LENGTH')
      ->where('TABLE_NAME', '=', strtolower($table))
      ->where('COLUMN_NAME', '=', strtolower($column))
      ->value('user_id');

    if (($columnLength) == '') {
      dump('Problem determining column width for '.$column.'.');
      return '0';
    } else {
      return $columnLength;
    }
  }
}

if (!function_exists('validateData')) {
  function validateData($tablename,$fieldname,$fielddata)
  {
  $columntype = GetColumnType($tablename,$fieldname);

  // text:  if too long.  Truncate
  if ($columntype=='varchar') {

    $ColumnLength = GetColumnLength($tablename,$fieldname);
    //dump('|'.$columntype.'|'.$fieldname.'-'.$ColumnLength);
    if (strlen($fielddata)>$ColumnLength) {
      $fielddata=substr($fielddata,0,$ColumnLength);
    }
  }

  //date:  wrong Format.  convert mm/dd/yyyy to yyyy-mm-dd.  blank should be 2999-12-31
  if ($columntype=='date') {
    // mm/dd/yyyy - convert
    if (is_numeric(substr($fielddata,0,2).substr($fielddata,3,2).substr($fielddata,6,4)) and substr($fielddata,2,1)=='/' and substr($fielddata,5,1)=='/') {
        $fielddata=substr($fielddata,6,4).'-'.substr($fielddata,0,2).'-'.substr($fielddata,3,2);
    // yyyy-mm-dd - nothing to do
  } elseif (is_numeric(substr($fielddata,0,4).substr($fielddata,5,2).substr($fielddata,8,2)) and substr($fielddata,4,1)=='-' and substr($fielddata,7,1)=='-') {
      // already in correct format, nothing to do
    } else {
      $fielddata='2999-12-31';
    }
  }

  //decimal:  contains only numbers.  If anything else, make it zero
  if ($columntype=='decimal') {
    if (! is_numeric($fielddata)) {
      $fielddata=0;
    }
  }

  //boolean/tinyint:  convert N,F,0
  if ($columntype=='tinyint') {
    if (substr($fielddata,0,1)=='0' or substr($fielddata,0,1)=='N' or substr($fielddata,0,1)=='F')  {
      $fielddata=0;
    } else {
      $fielddata=1 ;
    }

  }

  return $fielddata ;
  }
}

if (!function_exists('FormatMoney')) {
  function FormatMoney($value)
  {
    setlocale(LC_MONETARY, 'en_US.UTF-8'); // proper locale code for US Dollar

    // return money_format('%i', $value); //returns "  USD 999,999.99  "
    return money_format('%.2n', $value); //returns "  $999,999.99 "

  }
}

if (!function_exists('FormatDollars')) {
  function FormatDollars($value)
  {
    // setlocale(LC_MONETARY, 'en_US.UTF-8'); // proper locale code for US Dollar

    // return money_format('%i', $value); //returns "  USD 999,999.99  "
    // return money_format('%.0n', $value); //returns "  $999,999.99 "
    return money_format('%.2n', $value);

  }
}
