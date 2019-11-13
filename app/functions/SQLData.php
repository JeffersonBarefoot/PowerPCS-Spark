
<?php
use App\Models\Post;
use App\Position;
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
      ->select('COLUMN_TYPE')
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

if (!function_exists('FormatMoney')) {
  function FormatMoney($value)
  {
    setlocale(LC_MONETARY, 'en_US.UTF-8'); // proper locale code for US Dollar

    // return money_format('%i', $value); //returns "  USD 999,999.99  "
    return money_format('%.2n', $value); //returns "  $999,999.99 "

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

    // grab a copy of all Position.Fields, and locate the current position
    $columnList = \Schema::getColumnListing('positions');
    $position = Position::find($id);

    // not exactly sure what this does as of Oct 2019
    $request->validate([
     'company'=>'required',
     'posno'=>'required',
     'descr'=>'required'
    ]);

    // cycle through each columnlist as columnName to try and save changes
    foreach($columnList as $columnName) {
      // attempt to get a return value.  if doesn't exist will return null
      $returnStringValue = $request->get($columnName);

      // make sure that this field is included in the return string (so not null)
      // if so, update the column
      if (! is_null($returnStringValue)) {
        dump($returnStringValue);
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
          }
        }
      }

      dump($userConfirmMessage);

      //Can do something useful here.  "These changes were made.  Would you like to save them?"
      //Oct 2019 for now, just save them.
      //Add modal message requesting save validation.
      //Also, we can create a history record here.
      //May need to grab a copy of the original record at the very beginning of this function
      $position->save();

    } else {
      // what to do if nothing is dirty?  Probably nothing
      dump('Nothing is dirty!!')  ;
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

      $header = fgetcsv($handle, 2000, ',');
      $headercount = count($header);

      while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {

        $position = new Position ();
        $i = 0;
        while ($i<$headercount):
            $fieldname=$header[$i];
            $fielddata=$data[$i];
            $position->$fieldname=$fielddata;
            $i++;
        endwhile;

        $positionxx->save();
      }

      fclose ( $handle );
    }
  }
}
