<!--
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

// use App\Models\Post;
// use App\Position;
// use App\HPosition;
// use App\Incumbent;
// use App\HIncumbent;
// use Illuminate\Support\Facades\Schema\columns;
// use Illuminate\Support\Facades\DB;

// leave namespace out so that functions are global
//namespace App\Http\Middleware;

// if (!function_exists('GetPositionField')) {
//     function GetPositionField($employer, $posno, $fieldname)
//     {
//         return DB::table('positions')
//           ->where('company', '=', $employer)
//           ->where('posno', '=', $posno)
//           ->value($fieldname);
//     }
// }
//
// if (!function_exists('GetPosition')) {
//     function GetPosition($employer, $posno)
//     {
//         return DB::table('positions')
//           ->where('company', '=', $employer)
//           ->where('posno', '=', $posno);
//     }
// }
//
// if (!function_exists('GetPositions')) {
//   function GetPositions($employer, $descr, $posno)
//   {
//       return DB::table('positions')
//         ->where('company', '=', $employer );
//       //  ->where('posno', '=', $posno);
//
//   }
// }
//
// if (!function_exists('GetIncumbent')) {
//     function GetIncumbent($employer, $empno, $poscompany, $posno)
//     {
//         return DB::table('incumbents')
//           ->where('company', '=', $employer)
//           ->where('empno', '=', $empno)
//           ->where('poscompany', '=', $poscompany)
//           ->where('posno', '=', $posno);
//     }
// }
//
// if (!function_exists('GetIncumbentById')) {
//     function GetIncumbentById($ID)
//     {
//         return DB::table('incumbents')
//           ->where('id', '=', $ID)
//           ->get();
//     }
// }
//
// if (!function_exists('GetIncumbents')) {
//     function GetIncumbents($poscompany, $posno)
//     {
//         return DB::table('incumbents')
//           ->where('poscompany', '=', $poscompany)
//           ->where('posno', '=', $posno)
//           ->get();
//     }
// }
//
// if (!function_exists('GetActiveIncumbents')) {
//     function GetActiveIncumbents($poscompany, $posno)
//     {
//         return DB::table('incumbents')
//           ->where('poscompany', '=', $poscompany)
//           ->where('posno', '=', $posno)
//           ->where ('active_pos','=','A')
//           ->get();
//     }
// }
//
// if (!function_exists('GetHIncumbent')) {
//     function GetHIncumbent($employer, $empno, $poscompany, $posno)
//     {
//         return DB::table('hincumbents')
//           ->where('company', '=', $employer)
//           ->where('empno', '=', $empno)
//           ->where('poscompany', '=', $poscompany)
//           ->where('posno', '=', $posno)
//           ->orderby('trans_date','desc')
//           ->get();
//     }
// }
//
// if (!function_exists('GetHIncumbentRecordById')) {
//     function GetHIncumbentRecordById($ID)
//     {
//         return DB::table('hincumbents')
//           ->where('id', '=', $ID)
//           ->get();
//     }
// }
//
// // DON"T RELY ON THIS.  Need to include poscompany and posno to be complete
// if (!function_exists('GetIncumbentField')) {
//     function GetIncumbentField($employer, $empno, $fieldname)
//     {
//         return DB::table('incumbents')
//           ->where('company', '=', $employer)
//           ->where('empno', '=', $empno)
//           ->value($fieldname);
//     }
// }
//
// if (!function_exists('GetIncumbentFieldById')) {
//     function GetIncumbentFieldById($ID,$fieldname)
//     {
//         return DB::table('incumbents')
//         ->where('id', '=', $ID)
//         ->value($fieldname);
//     }
// }
//
// if (!function_exists('GetFriendlyColumnName')) {
//   function GetFriendlyColumnName($table, $column)
//   {
//
//     $friendlyName = DB::table('Information_Schema.Columns')
//       ->select('COLUMN_COMMENT')
//       ->where('TABLE_NAME', '=', $table)
//       ->where('COLUMN_NAME', '=', $column)
//       ->value('user_id');
//
//     if (trim($friendlyName) == '') {
//       return $column;
//     } else {
//       return $friendlyName;
//     }
//   }
// }
//
// if (!function_exists('GetColumnType')) {
//   function GetColumnType($table, $column)
//   {
//     $dataType = DB::table('Information_Schema.Columns')
//       ->select('DATA_TYPE')
//       ->where('TABLE_NAME', '=', strtolower($table))
//       ->where('COLUMN_NAME', '=', strtolower($column))
//       ->value('user_id');
//
//     if (($dataType) == '') {
//       return 'Error - Column Does Not Exist';
//     } else {
//       return $dataType;
//     }
//   }
// }
//
// if (!function_exists('GetColumnLength')) {
//   function GetColumnLength($table, $column)
//   {
//     $columnLength = DB::table('Information_Schema.Columns')
//       ->select('CHARACTER_MAXIMUM_LENGTH')
//       ->where('TABLE_NAME', '=', strtolower($table))
//       ->where('COLUMN_NAME', '=', strtolower($column))
//       ->value('user_id');
//
//     if (($columnLength) == '') {
//       dump('Problem determining column width for '.$column.'.');
//       return '0';
//     } else {
//       return $columnLength;
//     }
//   }
// }
//
// if (!function_exists('validateData')) {
//   function validateData($tablename,$fieldname,$fielddata)
//   {
//   $columntype = GetColumnType($tablename,$fieldname);
//
//   // text:  if too long.  Truncate
//   if ($columntype=='varchar') {
//
//     $ColumnLength = GetColumnLength($tablename,$fieldname);
//     //dump('|'.$columntype.'|'.$fieldname.'-'.$ColumnLength);
//     if (strlen($fielddata)>$ColumnLength) {
//       $fielddata=substr($fielddata,0,$ColumnLength);
//     }
//   }
//
//   //date:  wrong Format.  convert mm/dd/yyyy to yyyy-mm-dd.  blank should be 2999-12-31
//   if ($columntype=='date') {
//     // mm/dd/yyyy - convert
//     if (is_numeric(substr($fielddata,0,2).substr($fielddata,3,2).substr($fielddata,6,4)) and substr($fielddata,2,1)=='/' and substr($fielddata,5,1)=='/') {
//         $fielddata=substr($fielddata,6,4).'-'.substr($fielddata,0,2).'-'.substr($fielddata,3,2);
//     // yyyy-mm-dd - nothing to do
//   } elseif (is_numeric(substr($fielddata,0,4).substr($fielddata,5,2).substr($fielddata,8,2)) and substr($fielddata,4,1)=='-' and substr($fielddata,7,1)=='-') {
//       // already in correct format, nothing to do
//     } else {
//       $fielddata='2999-12-31';
//     }
//   }
//
//   //decimal:  contains only numbers.  If anything else, make it zero
//   if ($columntype=='decimal') {
//     if (! is_numeric($fielddata)) {
//       $fielddata=0;
//     }
//   }
//
//   //boolean/tinyint:  convert N,F,0
//   if ($columntype=='tinyint') {
//     if (substr($fielddata,0,1)=='0' or substr($fielddata,0,1)=='N' or substr($fielddata,0,1)=='F')  {
//       $fielddata=0;
//     } else {
//       $fielddata=1 ;
//     }
//
//   }
//
//   return $fielddata ;
//   }
// }
//
// if (!function_exists('FormatMoney')) {
//   function FormatMoney($value)
//   {
//     setlocale(LC_MONETARY, 'en_US.UTF-8'); // proper locale code for US Dollar
//
//     // return money_format('%i', $value); //returns "  USD 999,999.99  "
//     return money_format('%.2n', $value); //returns "  $999,999.99 "
//
//   }
// }
//
// if (!function_exists('FormatDollars')) {
//   function FormatDollars($value)
//   {
//     // setlocale(LC_MONETARY, 'en_US.UTF-8'); // proper locale code for US Dollar
//
//     // return money_format('%i', $value); //returns "  USD 999,999.99  "
//     // return money_format('%.0n', $value); //returns "  $999,999.99 "
//     return money_format('%.2n', $value);
//
//   }
// }
//
// if (!function_exists('UpdatePosition')) {
//
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   //**  U P D A T E   P O S I T I O N
//   //**
//   //**  After editing position data in the Position Edit screen,
//   //**  cycle through each field in POSITIONS.
//   //**
//   //**  1 - check to see if the field is included in the Return String.
//   //**    If not, then it wasn't editable on the Position Edit Screen
//   //**  2 - If it's in the Return String, Update the value in the Position Model
//   //**  3 - Once Updated, check for changed fields via IsDirty()
//   //**    If dirty fields are found, we can notify the user and ask for
//   //**    confirmation to save.
//   //**
//   //***************************************************
//   //***************************************************
//   //***************************************************
//
//   function UpdatePosition($id, $request)
//   {
//
//     // dump("UpdatePosition just fired");
//     // dd($request);
//
//     // grab a copy of all Position.Fields, and locate the current position
//     $columnList = \Schema::getColumnListing('positions');
//     $position = Position::find($id);
//     $poscomp = $position->company;
//     $posno = $position->posno;
//     $posid = $position->id;
//
//
//
//     // not exactly sure what this does as of Oct 2019
//     // $request->validate([
//     //  'company'=>'required',
//     //  'posno'=>'required',
//     //  'descr'=>'required'
//     // ]);
//
//     // dump("made it through validate");
//
//     // cycle through each columnlist as columnName to try and save changes
//     foreach($columnList as $columnName) {
//       // attempt to get a return value.  if doesn't exist will return null
//       $returnStringValue = $request->get($columnName);
//
//
//
//       // make sure that this field is included in the return string (so not null)
//       // if so, update the column
//       if (! is_null($returnStringValue)) {
//         // dump("ReturnStringValue:".$returnStringValue);
//         $position->$columnName = $request->get($columnName);
//       }
//     }
//
//     // check model to see if any changes at all have been made.  If not, nothing to do
// // dump(1);
//     if ($position->IsDirty()) {
// // dump($position->getdirty());
//       //MODEL IS DIRTY
//       // if we determine that the model is dirty cycle through columns one by one to see which ones have changes
//       $user = auth()->user();
//       $userConfirmMessage = $user->name . ': ' . date('Y-m-d H:i:s') . "\n" ;
//       foreach($columnList as $columnName) {
//
//         // make sure that this field is included in the return string.
//         // if so, see if it's dirty so that we can log as needed
//         $returnStringValue = $request->get($columnName);
//         if (!is_null($returnStringValue)) {
// // dump($columnName);
//
//           //$columnName = $column->COLUMN_NAME;
//           // dd($column);
//           //$position.$columnName = $request->get($columnName);
//           $columnValue = $request->get($columnName);
//           $columnType = GetColumnType('positions',$columnName);
// // dump($columnValue);
//
//           // if using FORMATMONEY() function then a leading $ will be in the data.  Strip it fann_descale_output
//           // validate the incoming data, based on the table.field data type
//           if (strToUpper($columnType) == "DECIMAL") {
//             // dd('decimal type found');
//             // dump("ColumnValue".$columnValue);
//             $columnValue = str_replace('$','',$columnValue);
//             $columnValue = str_replace(',','',$columnValue);
//             // dump("ColumnValueNoDollarSign".$columnValue);
//           }
//
//           // dump('1:  ' . $columnName);
//           //dd($columnList);
//           // dump('2:  ' . $request->get($columnValue));
//
//           // if ($position->IsDirty($columnName)) {
//           if ($position->IsDirty($columnName)) {
//
//             // build the User Confirmation Message
//             // if we save changes, we should store this message with the history record for easy id of changes that were made
//             $originalValue = $position->getOriginal($columnName);
//
//             if ($columnValue != $originalValue) {
// // dump($originalValue);
// // dump($columnValue);
//               $friendlyName = GetFriendlyColumnName('positions',$columnName);
//               $fieldChange = '  - ' . $friendlyName . ' has changed from ' . $originalValue . ' to ' . $columnValue . " \n" ;
//               $userConfirmMessage = $userConfirmMessage . $fieldChange ;
//
//
//               // update the field in the new positions records
//               // import will look like:  $position->active="A"
//               $position->$columnName=$columnValue;
//             } else {
//               $position->$columnName=$originalValue;
//             }
//           }
//         }
//       }
//
//       // dd($userConfirmMessage);
//
//       //Can do something useful here.  "These changes were made.  Would you like to save them?"
//       //Oct 2019 for now, just save them.
//       //Add modal message requesting save validation.
//       //Also, we can create a history record here.
//       //May need to grab a copy of the original record at the very beginning of this function
//
// //***************************************************
//       // see if a history record is needed
//       $posHistRecs = \DB::table('hpositions')
//         ->where('posid','=',$posid)
//         ->where('trans_date','=',date('Y-m-d'))
//         ->get();
//       $positionhistorycount = $posHistRecs->count();
// // dd($positionhistorycount);
//       // if no records with today's date need to add a new history record
//       if ($positionhistorycount==0) {
//
//
// // dd('trying to insert record into hpositions');
//         $user = auth()->user();
//
//         $posHist = new HPosition();
//         $posHist->posid = $posid;
//         $posHist->teamid = $user->currentTeam->id;
//         $posHist->company = $poscomp;
//         $posHist->posno = $posno;
//         $posHist->descr = $position->descr;
//         $posHist->trans_date=date('Y-m-d');
//
//         $posHist->active = $position->active;
//         $posHist->annftehour = $position->annftehour;
//         $posHist->avail_date = $position->avail_date;
//         $posHist->budgsal = $position->budgsal;
//         $posHist->eeoclass = $position->eeoclass;
//         $posHist->enddate = $position->enddate;
//         $posHist->exempt = $position->exempt;
//         $posHist->ftefreq = $position->ftefreq;
//         $posHist->ftehours = $position->ftehours;
//         $posHist->fulltimeequiv = $position->fulltimeequiv;
//         $posHist->funded = $position->funded;
//         $posHist->group1 = $position->group1;
//         $posHist->group2 = $position->group2;
//         $posHist->group3 = $position->group3;
//         $posHist->jobdesc = $position->jobdesc;
//         $posHist->lastactdate = $position->lastactdate;
//         $posHist->last_fil = $position->last_fil;
//         $posHist->last_ove = $position->last_ove;
//         $posHist->last_par = $position->last_par;
//         $posHist->last_vac = $position->last_vac;
//         $posHist->level1 = $position->level1;
//         $posHist->level2 = $position->level2;
//         $posHist->level3 = $position->level3;
//         $posHist->level4 = $position->level4;
//         $posHist->level5 = $position->level5;
//         $posHist->linktoabra = $position->linktoabra;
//         $posHist->multincumb = $position->multincumb;
//         $posHist->payfreq = $position->payfreq;
//         $posHist->payrate = $position->payrate;
//         $posHist->paytype = $position->paytype;
//         $posHist->reason = $position->reason;
//         $posHist->reptocomp = $position->reptocomp;
//         $posHist->reptodesc = $position->reptodesc;
//         $posHist->reptoposno = $position->reptoposno;
//         $posHist->salgrade = $position->salgrade;
//         $posHist->salupper = $position->salupper;
//         $posHist->sallower = $position->sallower;
//         $posHist->salfreq = $position->salfreq;
//         $posHist->curstatus = $position->curstatus;
//         $posHist->startdate = $position->startdate;
//         $posHist->supcompany = $position->supcompany;
//         $posHist->supempno = $position->supempno;
//         $posHist->supname = $position->supname;
//         $posHist->userdef1 = $position->userdef1;
//         $posHist->userdef2 = $position->userdef2;
//         $posHist->userdef3 = $position->userdef3;
//         $posHist->userdef4 = $position->userdef4;
//         $posHist->userdef5 = $position->userdef5;
//         $posHist->userdef6 = $position->userdef6;
//         $posHist->vac_times = $position->vac_times;
//         $posHist->vac_months = $position->vac_months;
//         $posHist->reptocom2 = $position->reptocom2;
//         $posHist->reptopos2 = $position->reptopos2;
//         $posHist->reptodesc2 = $position->reptodesc2;
//         $posHist->historyreason = $position->historyreason;
//         $posHist->historystart = $position->historystart;
//         $posHist->historyend = getTodaysDate();
//
//         $posHist->save();
//
//         // if need history record then position.historyreason is JUST the userConfirmMessage
//         // $originalHistoryReason = $position->historyreason;
//         // $newHistoryReason =   $originalHistoryReason . $userConfirmMessage;
//         // $newHistoryReason = $userConfirmMessage;
//         $position->historyreason=$userConfirmMessage;
//         $position->historystart=date('Y-m-d');
//         $position->save();
//
//       } else { // if don't need history record then the history reason is existing PLUS new userConfirmMessage.  DON'T update historystart date
//
//         $originalHistoryReason = $position->historyreason;
//         $newHistoryReason =   $originalHistoryReason . $userConfirmMessage;
//         // $newHistoryReason = $userConfirmMessage;
//         $position->historyreason=$newHistoryReason;
//         // $position->historystart=date('Y-m-d');
//         $position->save();
//
//       }
//
//
//
//
//
//       // dd($userConfirmMessage);
//
//     } else {
//       // what to do if nothing is dirty?  Probably nothing
//       // dd('Nothing is dirty!!')  ;
//     }
//
//     // sleep(10);
//
//     // dd('end');
//   }
// }
//
// if (!function_exists('ImportPositions')) {
//
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   //**  I M P O R T   P O S I T I O N S
//   //**
//   //**  Import from a CSV file
//   //**  Pull column name from header row
//   //**
//   //**  Validate data, etc.  and then create a new record in POSITIONS table
//   //**
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   function ImportPositions($incomingfile)
//   {
//     // if (($handle = fopen ( public_path () . '/ImportFiles/samplepositions.csv', 'r' )) !== FALSE) {
//     if (($handle = fopen ( public_path () . '/ImportFiles/brmpositions.csv', 'r' )) !== FALSE) {
//
//       // extract headers so we can see what fields are being imported
//       $header = fgetcsv($handle, 2000, ',');
//       $headercount = count($header);
//
//       // scan remaining CSV records, and put each into an array named $data
//       while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {
//
//         //add a new record to positions table
//         $position = new Position();
//         $i = 0;
//
//         // scan through all fields in the current record
//         while ($i<$headercount):
//
//             // grab the fieldname from $header and the imported data from $data
//             $fieldname=$header[$i];
//             $fielddata=$data[$i];
//
//             // validate the incoming data, based on the table.field data type
//             $fielddata=validateData('positions',$fieldname,$fielddata);
//
//             // update the field in the new positions records
//             // import will look like:  $position->active="A"
//             $position->$fieldname=$fielddata;
//             $i++;
//         endwhile;
//
//         // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE
//
//         $position->save();
//       }
//
//       fclose ( $handle );
//
//       rename('/ImportFiles/brmpositions.csv.imported','/ImportFiles/brmpositions.csv');
//
//
//     }
//   }
// }
//
// if (!function_exists('ImportHPositions')) {
//
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   //**  I M P O R T   H P O S I T I O N S
//   //**
//   //**  Import from a CSV file
//   //**  Pull column name from header row
//   //**
//   //**  Validate data, etc.  and then create a new record in POSITIONS table
//   //**
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   function ImportHPositions($incomingfile)
//   {    if (($handle = fopen ( public_path () . '/ImportFiles/samplehpositions.csv', 'r' )) !== FALSE) {
//
//       // extract headers so we can see what fields are being imported
//       $header = fgetcsv($handle, 2000, ',');
//       $headercount = count($header);
//
//       // scan remaining CSV records, and put each into an array named $data
//       while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {
//
//         //add a new record to positions table
//         $hposition = new HPosition();
//         $i = 0;
//
//         // scan through all fields in the current record
//         while ($i<$headercount):
//
//             // grab the fieldname from $header and the imported data from $data
//             $fieldname=$header[$i];
//             $fielddata=$data[$i];
//
//             if ($fieldname=="company") {
//               $companyvalue = $fielddata;
//             }
//
//             if ($fieldname=="posno") {
//               $posnovalue = $fielddata;
//             }
//
//             // validate the incoming data, based on the table.field data type
//             $fielddata=validateData('hpositions',$fieldname,$fielddata);
//
//             // find the related position, and capture the position ID
//
//             // update the field in the new positions records
//             // import will look like:  $position->active="A"
//             $hposition->$fieldname=$fielddata;
//             $i++;
//         endwhile;
//
//         // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE
//         // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE
//         $positionid = GetPositionField($companyvalue, $posnovalue, "id");
//
//         if (! is_null($positionid)) {
//           $hposition->posid=$positionid;
//         }
//
//         // add correct team ID
//         $user = auth()->user();
//         $hposition->teamid=$user->currentTeam->id;
//
//         $hposition->save();
//         }
//       fclose ( $handle );
//     }
//   }
//
// }
//
//
// if (!function_exists('ImportIncumbents')) {
//
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   //**  I M P O R T   I N C U M B E N T S
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   function ImportIncumbents($incomingfile)
//   {
//     if (($handle = fopen ( public_path () . '/ImportFiles/sampleincums.csv', 'r' )) !== FALSE) {
//
//       // extract headers so we can see what fields are being imported
//       $header = fgetcsv($handle, 2000, ',');
//       $headercount = count($header);
//
//       // scan remaining CSV records, and put each into an array named $data
//       while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {
//
//         //add a new record to positions table
//         $incumbent = new Incumbent() ;
//         $i = 0;
//
//         // scan through all fields in the current record
//         while ($i<$headercount):
//
//             // grab the fieldname from $header and the imported data from $data
//             $fieldname=$header[$i];
//             $fielddata=$data[$i];
//
//             if ($fieldname=="company") {
//               $companyvalue = $fielddata;
//             }
//
//             if ($fieldname=="posno") {
//               $posnovalue = $fielddata;
//             }
//
//
//             // validate the incoming data, based on the table.field data type
//             $fielddata=validateData('incumbents',$fieldname,$fielddata);
//
//             // update the field in the new positions records
//             // import will look like:  $position->active="A"
//             $incumbent->$fieldname=$fielddata;
//             $i++;
//         endwhile;
//
//         // MAKE SURE THAT THERE'S A COMPANY AND POSNO, AND THEY ARE UNIQUE
//         $positionid = GetPositionField($companyvalue, $posnovalue, "id");
//
//         if (! is_null($positionid)) {
//           $incumbent->posid=$positionid;
//           }
//
//         $incumbent->save();
//       }
//       fclose ( $handle );
//     }
//   }
// }
//
// if (!function_exists('ImportHIncumbents')) {
//
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   //**  I M P O R T   H I S T O R I C A L   I N C U M B E N T S
//   //***************************************************
//   //***************************************************
//   //***************************************************
//   function ImportHIncumbents($incomingfile)
//   {
//     if (($handle = fopen ( public_path () . '/ImportFiles/samplehincums.csv', 'r' )) !== FALSE) {
//
//       // extract headers so we can see what fields are being imported
//       $header = fgetcsv($handle, 2000, ',');
//       $headercount = count($header);
//
//       // scan remaining CSV records, and put each into an array named $data
//       while ( ($data = fgetcsv ( $handle, 2000, ',' )) !== FALSE ) {
//
//         //add a new record to positions table
//         $hincumbent = new HIncumbent() ;
//         $i = 0;
//
//         // scan through all fields in the current record
//         while ($i<$headercount):
//
//             // grab the fieldname from $header and the imported data from $data
//             $fieldname=$header[$i];
//             $fielddata=$data[$i];
//
//             if ($fieldname=="company") {
//               $companyvalue = $fielddata;
//             }
//
//             if ($fieldname=="poscompany") {
//               $poscompanyvalue = $fielddata;
//             }
//
//             if ($fieldname=="posno") {
//               $posnovalue = $fielddata;
//             }
//
//             if ($fieldname=="empno") {
//               $empnovalue = $fielddata;
//             }
//
//             // validate the incoming data, based on the table.field data type
//             $fielddata=validateData('hincumbents',$fieldname,$fielddata);
//
//             // update the field in the new positions records
//             // import will look like:  $position->active="A"
//             // dump();
//             $hincumbent->$fieldname=$fielddata;
//             $i++;
//         endwhile;
//
//         // MAKE SURE THAT THERE'S A POSCOMPANY AND POSNO, AND THEY ARE UNIQUE
//         $positionid = GetPositionField($poscompanyvalue, $posnovalue, "id");
//         if (! is_null($positionid)) {
//           $hincumbent->posid=$positionid;
//         }
//
//         // MAKE SURE THAT THERE'S A COMPANY AND EMPNO, AND THEY ARE UNIQUE
//         $incumbentid = GetIncumbentField($companyvalue, $empnovalue, "id");
//         if (! is_null($incumbentid)) {
//           $hincumbent->incid=$incumbentid;
//         }
//
//         // add correct team ID
//         $user = auth()->user();
//         $hincumbent->teamid=$user->currentTeam->id;
//
//         $hincumbent->save();
//       }
//
//       fclose ( $handle );
//     }
//   }
// }
//
// if (!function_exists('getTimestamp')) {
//   function getTimestamp()
//   {
//     // this works, but the HOUR is 7 hours off from EST
//     // $timestamp = date("Ymdhis");
//     // return $timestamp;
//
//     // this works, and defaults to EST (new york time)
//     $tz = 'America/New_York';
//     $dt = new DateTime();
//     $dt->setTimezone(new DateTimeZone($tz));
//     $timestamp = $dt->format('Ymd-his');
//     return $timestamp;
//
//   }
// }
//
// if (!function_exists('getTodaysDate')) {
//   function getTodaysDate()
//   {
//
//     $tz = 'America/New_York';
//     $date = new DateTime("now", new DateTimeZone($tz) );
//     return $date->format('Y-m-d');
//
//   }
// }
//
// if (!function_exists('sessionSet')) {
//   function sessionSet($key,$value)
//   {
//     // example:  Session::put($key,$value);
//     Session::put($key,$value);
//     return true;
//   }
// }
//
// if (!function_exists('sessionGet')) {
//   function sessionGet($key)
//   {
//     // example:  Session::put($key,$value);
//     $getSessionValue = Session::get($key);
//     return $getSessionValue;
//   }
// }
//
// if (!function_exists('sessionForgetOne')) {
//   function sessionForgetOne($key)
//   {
//     // example:  Session::put($key,$value);
//     Session::forget($key);
//     return true;
//   }
// }
//
// //***************************************************
// //***************************************************
// //***************************************************
// //**  SEED SAMPLE POSITION HISTORY RECORDS
// //**
// //**  Build a reasonable set of history records based on sample *BRM position records
// //**
// //***************************************************
// //***************************************************
// //***************************************************
//
// function SeedPositionHistory($teamId,$newRecords)
// {
//   $positionsToSeed = \DB::table('positions')
//     ->where('TeamID','=',$teamId)
//     ->get();
//
//   // delete existing sample history records for this team
//   \DB::table('hpositions')
//     ->where('TeamID','=',$teamId)
//     ->delete();
// // dump(1);
//
//   Foreach ($positionsToSeed as $PTS){
//
//     $count = 0 ;
//     do {
// // dump(2);
//       // set a starting point...a HPOSITION record that is identical to the POSITION record
//       $posHist = new HPosition();
//       $posHist->posid = $PTS->id;
//       $posHist->teamid = $PTS->teamid;
//       $posHist->company = $PTS->company;
//       $posHist->posno = $PTS->posno;
//       $posHist->descr = $PTS->descr;
//       $posHist->trans_date=date('Y-m-d');
//       $posHist->active = $PTS->active;
//       $posHist->annftehour = $PTS->annftehour;
//       $posHist->avail_date = $PTS->avail_date;
//       $posHist->budgsal = $PTS->budgsal;
//       $posHist->eeoclass = $PTS->eeoclass;
//       $posHist->enddate = $PTS->enddate;
//       $posHist->exempt = $PTS->exempt;
//       $posHist->ftefreq = $PTS->ftefreq;
//       $posHist->ftehours = $PTS->ftehours;
//       $posHist->fulltimeequiv = $PTS->fulltimeequiv;
//       $posHist->funded = $PTS->funded;
//       $posHist->group1 = $PTS->group1;
//       $posHist->group2 = $PTS->group2;
//       $posHist->group3 = $PTS->group3;
//       $posHist->jobdesc = $PTS->jobdesc;
//       $posHist->lastactdate = $PTS->lastactdate;
//       $posHist->last_fil = $PTS->last_fil;
//       $posHist->last_ove = $PTS->last_ove;
//       $posHist->last_par = $PTS->last_par;
//       $posHist->last_vac = $PTS->last_vac;
//       $posHist->level1 = $PTS->level1;
//       $posHist->level2 = $PTS->level2;
//       $posHist->level3 = $PTS->level3;
//       $posHist->level4 = $PTS->level4;
//       $posHist->level5 = $PTS->level5;
//       $posHist->linktoabra = $PTS->linktoabra;
//       $posHist->multincumb = $PTS->multincumb;
//       $posHist->payfreq = $PTS->payfreq;
//       $posHist->payrate = $PTS->payrate;
//       $posHist->paytype = $PTS->paytype;
//       $posHist->reason = $PTS->reason;
//       $posHist->reptocomp = $PTS->reptocomp;
//       $posHist->reptodesc = $PTS->reptodesc;
//       $posHist->reptoposno = $PTS->reptoposno;
//       $posHist->salgrade = $PTS->salgrade;
//       $posHist->salupper = $PTS->salupper;
//       $posHist->sallower = $PTS->sallower;
//       $posHist->salfreq = $PTS->salfreq;
//       $posHist->curstatus = $PTS->curstatus;
//       $posHist->startdate = $PTS->startdate;
//       $posHist->supcompany = $PTS->supcompany;
//       $posHist->supempno = $PTS->supempno;
//       $posHist->supname = $PTS->supname;
//       $posHist->userdef1 = $PTS->userdef1;
//       $posHist->userdef2 = $PTS->userdef2;
//       $posHist->userdef3 = $PTS->userdef3;
//       $posHist->userdef4 = $PTS->userdef4;
//       $posHist->userdef5 = $PTS->userdef5;
//       $posHist->userdef6 = $PTS->userdef6;
//       $posHist->vac_times = $PTS->vac_times;
//       $posHist->vac_months = $PTS->vac_months;
//       $posHist->reptocom2 = $PTS->reptocom2;
//       $posHist->reptopos2 = $PTS->reptopos2;
//       $posHist->reptodesc2 = $PTS->reptodesc2;
//       $posHist->historyreason = $PTS->historyreason;
//       $posHist->historystart = $PTS->historystart;
//       $posHist->historyend = getTodaysDate();
//
//       // make changes that will determine the differences that exist within the history record
//
//       // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//       // random number of days since last history records
//       if ($count == 0) {
//         // if this is the first seeding loop for this position then use the POSITIONS history date
//         $lastStart = $posHist->historystart;
//
//         if (is_null($lastStart)) {
//           $lastStart = getTodaysDate();
//           dump('ughhhhhh');
//         }
//
//       } else {
//         // otherwise just use the date from the last loop through, so we continue iterating backwards chronologically
//       }
//
//       // last day of this history record is the first day of the "next" record
//       $thisEnd = $lastStart;
//
//       // thisStart = thisEnd - random # of days
//       $dthisEnd = date_create($thisEnd);
//       $elapsedDays = rand(400,800);
//       $updateString = sprintf("%u days",$elapsedDays);
//       $dthisStart = date_sub($dthisEnd,date_interval_create_from_date_string($updateString));
//       $thisStart = $dthisStart->format('Y-m-d');
//
//       $posHist->historystart  = $dthisStart;
//       $posHist->historyend    = $thisEnd;
//
//       // set the start date so that it's available for the next record being created for this position
//       $lastStart = $thisStart;
//
//       // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//       // some percent pay increase
//       if ($count == 0) {
//         // if this is the first seeding loop for this position then use the POSITIONS data
//         $BudgSal = $posHist->budgsal;
//         $PayRate = $posHist->payrate;
//         }
//
//       $percentIncrease = round(rand(2,8),0);
//       $newPayRate = $PayRate/(1+($percentIncrease/100));
//       $newBudgSal = $BudgSal/(1+($percentIncrease/100));
//
//       $posHist->payrate = $newPayRate;
//       $posHist->budgsal = $newBudgSal;
//
//       // set variables so they're available next imagesetinterpolation
//       $BudgSal = $newBudgSal;
//       $PayRate = $newPayRate;
//
//       // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//       // occasional change in ftehours
//
//       // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//       // occasional change in active status
//
//       // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//       // occasional change in Capacity status
//
//       // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//       // occasional change in location
//
//
//
//       $posHist->save();
//       $count = $count + 1;
//
//     } while ($count < $newRecords);
//
//   }
//
// } -->
