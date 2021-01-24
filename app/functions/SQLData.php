
<?php
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

if (!function_exists('UpdatePosition')) {

  //***************************************************
  //***************************************************
  //***************************************************
  //**  U P D A T E   P O S I T I O N
  //**
  //**  After editing position data in the Position Edit screen,
  //**  cycle through each field in POSITIONS.
  //**
  //**  1 - check to see if the field is included in the Return String.
  //**    If not, then it wasn't editable on the Position Edit Screen
  //**  2 - If it's in the Return String, Update the value in the Position Model
  //**  3 - Once Updated, check for changed fields via IsDirty()
  //**    If dirty fields are found, we can notify the user and ask for
  //**    confirmation to save.
  //**
  //***************************************************
  //***************************************************
  //***************************************************

  function UpdatePosition($id, $request)
  {

    // dump("UpdatePosition just fired");
    // dd($request);

    // grab a copy of all Position.Fields, and locate the current position
    $columnList = \Schema::getColumnListing('positions');
    $position = Position::find($id);



    // not exactly sure what this does as of Oct 2019
    // $request->validate([
    //  'company'=>'required',
    //  'posno'=>'required',
    //  'descr'=>'required'
    // ]);

    // dump("made it through validate");

    // cycle through each columnlist as columnName to try and save changes
    foreach($columnList as $columnName) {
      // attempt to get a return value.  if doesn't exist will return null
      $returnStringValue = $request->get($columnName);



      // make sure that this field is included in the return string (so not null)
      // if so, update the column
      if (! is_null($returnStringValue)) {
        // dump("ReturnStringValue:".$returnStringValue);
        $position->$columnName = $request->get($columnName);
      }
    }

    // check model to see if any changes at all have been made.  If not, nothing to do
    if ($position->IsDirty()) {

      //MODEL IS DIRTY
      // if we determine that the model is dirty cycle through columns one by one to see which ones have changes
      $userConfirmMessage = "Changes were made:\r\n";
      foreach($columnList as $columnName) {

        // make sure that this field is included in the return string.
        // if so, see if it's dirty so that we can log as needed
        $returnStringValue = $request->get($columnName);
        if (!is_null($returnStringValue)) {

          //$columnName = $column->COLUMN_NAME;
          // dd($column);
          //$position.$columnName = $request->get($columnName);
          $columnValue = $request->get($columnName);
          $columnType = GetColumnType('positions',$columnName);
          // dump("ColumnType".$columnType);

          // if using FORMATMONEY() function then a leading $ will be in the data.  Strip it fann_descale_output
          // validate the incoming data, based on the table.field data type
          if (strToUpper($columnType) == "DECIMAL") {
            // dd('decimal type found');
            // dump("ColumnValue".$columnValue);
            $columnValue = str_replace('$','',$columnValue);
            $columnValue = str_replace(',','',$columnValue);
            // dump("ColumnValueNoDollarSign".$columnValue);
          }

          // dump('1:  ' . $columnName);
          //dd($columnList);
          // dump('2:  ' . $request->get($columnValue));

          // if ($position->IsDirty($columnName)) {
          if ($position->IsDirty($columnName)) {

            // build the User Confirmation Message
            // if we save changes, we should store this message with the history record for easy id of changes that were made
            $originalValue = $position->getOriginal($columnName);
            $friendlyName = GetFriendlyColumnName('positions',$columnName);
            $fieldChange = '  - ' . $friendlyName . ' has changed from ' . $originalValue . ' to ' . $columnValue ."\r\n" ;
            $userConfirmMessage = $userConfirmMessage . $fieldChange ;


            // update the field in the new positions records
            // import will look like:  $position->active="A"
            $position->$columnName=$columnValue;

          }
        }
      }

      // dd($userConfirmMessage);

      //Can do something useful here.  "These changes were made.  Would you like to save them?"
      //Oct 2019 for now, just save them.
      //Add modal message requesting save validation.
      //Also, we can create a history record here.
      //May need to grab a copy of the original record at the very beginning of this function
      $position->save();

    } else {
      // what to do if nothing is dirty?  Probably nothing
      // dd('Nothing is dirty!!')  ;
    }

    // sleep(10);

    // dd('end');
  }
}

if (!function_exists('ImportPositions')) {

  //***************************************************
  //***************************************************
  //***************************************************
  //**  I M P O R T   P O S I T I O N S
  //**
  //**  Import from a CSV file
  //**  Pull column name from header row
  //**
  //**  Validate data, etc.  and then create a new record in POSITIONS table
  //**
  //***************************************************
  //***************************************************
  //***************************************************
  function ImportPositions($incomingfile)
  {
    if (($handle = fopen ( public_path () . '/ImportFiles/samplepositions.csv', 'r' )) !== FALSE) {

      // extract headers so we can see what fields are being imported
      $header = fgetcsv($handle, 2000, ',');
      $headercount = count($header);

      // scan remaining CSV records, and put each into an array named $data
      while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {

        //add a new record to positions table
        $position = new Position();
        $i = 0;

        // scan through all fields in the current record
        while ($i<$headercount):

            // grab the fieldname from $header and the imported data from $data
            $fieldname=$header[$i];
            $fielddata=$data[$i];

            // validate the incoming data, based on the table.field data type
            $fielddata=validateData('positions',$fieldname,$fielddata);

            // update the field in the new positions records
            // import will look like:  $position->active="A"
            $position->$fieldname=$fielddata;
            $i++;
        endwhile;

        // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE

        $position->save();
      }

      fclose ( $handle );
    }
  }
}

if (!function_exists('ImportHPositions')) {

  //***************************************************
  //***************************************************
  //***************************************************
  //**  I M P O R T   H P O S I T I O N S
  //**
  //**  Import from a CSV file
  //**  Pull column name from header row
  //**
  //**  Validate data, etc.  and then create a new record in POSITIONS table
  //**
  //***************************************************
  //***************************************************
  //***************************************************
  function ImportHPositions($incomingfile)
  {
    if (($handle = fopen ( public_path () . '/ImportFiles/samplehpositions.csv', 'r' )) !== FALSE) {

      // extract headers so we can see what fields are being imported
      $header = fgetcsv($handle, 2000, ',');
      $headercount = count($header);

      // scan remaining CSV records, and put each into an array named $data
      while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {

        //add a new record to positions table
        $hposition = new HPosition();
        $i = 0;

        // scan through all fields in the current record
        while ($i<$headercount):

            // grab the fieldname from $header and the imported data from $data
            $fieldname=$header[$i];
            $fielddata=$data[$i];

            // validate the incoming data, based on the table.field data type
            $fielddata=validateData('hpositions',$fieldname,$fielddata);

            // update the field in the new positions records
            // import will look like:  $position->active="A"
            $hposition->$fieldname=$fielddata;
            $i++;
        endwhile;

        // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE

        $hposition->save();
      }

      fclose ( $handle );
    }
  }
}

if (!function_exists('ImportIncumbents')) {

  //***************************************************
  //***************************************************
  //***************************************************
  //**  I M P O R T   I N C U M B E N T S
  //***************************************************
  //***************************************************
  //***************************************************
  function ImportIncumbents($incomingfile)
  {
    if (($handle = fopen ( public_path () . '/ImportFiles/sampleincums.csv', 'r' )) !== FALSE) {

      // extract headers so we can see what fields are being imported
      $header = fgetcsv($handle, 2000, ',');
      $headercount = count($header);

      // scan remaining CSV records, and put each into an array named $data
      while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {

        //add a new record to positions table
        $incumbent = new Incumbent() ;
        $i = 0;

        // scan through all fields in the current record
        while ($i<$headercount):

            // grab the fieldname from $header and the imported data from $data
            $fieldname=$header[$i];
            $fielddata=$data[$i];

            if ($fieldname=="company") {
              $companyvalue = $fielddata;
            }

            if ($fieldname=="posno") {
              $posnovalue = $fielddata;
            }


            // validate the incoming data, based on the table.field data type
            $fielddata=validateData('incumbents',$fieldname,$fielddata);

            // update the field in the new positions records
            // import will look like:  $position->active="A"
            $incumbent->$fieldname=$fielddata;
            $i++;
        endwhile;

        // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE
        $positionid = GetPositionField($companyvalue, $posnovalue, "id");

        if (! is_null($positionid)) {
          $incumbent->posid=$positionid;
          $incumbent->save();
        }
      }

      fclose ( $handle );
    }
  }
}

if (!function_exists('ImportHIncumbents')) {

  //***************************************************
  //***************************************************
  //***************************************************
  //**  I M P O R T   H I S T O R I C A L   I N C U M B E N T S
  //***************************************************
  //***************************************************
  //***************************************************
  function ImportHIncumbents($incomingfile)
  {
    if (($handle = fopen ( public_path () . '/ImportFiles/samplehincums.csv', 'r' )) !== FALSE) {

      // extract headers so we can see what fields are being imported
      $header = fgetcsv($handle, 2000, ',');
      $headercount = count($header);

      // scan remaining CSV records, and put each into an array named $data
      while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {

        //add a new record to positions table
        $hincumbent = new HIncumbent() ;
        $i = 0;

        // scan through all fields in the current record
        while ($i<$headercount):

            // grab the fieldname from $header and the imported data from $data
            $fieldname=$header[$i];
            $fielddata=$data[$i];

            // validate the incoming data, based on the table.field data type
            $fielddata=validateData('hincumbents',$fieldname,$fielddata);

            // update the field in the new positions records
            // import will look like:  $position->active="A"
            // dump();
            $hincumbent->$fieldname=$fielddata;
            $i++;
        endwhile;

        // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE

        $hincumbent->save();
      }

      fclose ( $handle );
    }
  }
}

if (!function_exists('TestOnclickFunction')) {
  function TestOnclickFunction()
  {
    //    $initialValue = Session::get('expandIncumbents');
    $initialValue = 'ABCDEFG' ;
    dd($initialValue);

    if ($initialValue == 'YES') {
      $finalValue = 'NO' ;
    } else {
      $finalValue = 'YES' ;
    }
  }
}

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

if (!function_exists('posShowInit')) {
  function posShowInit()
  {
    // Extract all session variables to




  }
}
