
<?php


use App\Models\Post;
use App\Position;
use App\HPosition;
use App\Incumbent;
use App\HIncumbent;
use App\Report;
use App\ReportQueries;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// below are related to Nayjest Data Grid
use App\User;
use Illuminate\Support\Facades\Config;
use Nayjest\Grids\Components\Base\RenderableRegistry;
use Nayjest\Grids\Components\ColumnHeadersRow;
use Nayjest\Grids\Components\ColumnsHider;
use Nayjest\Grids\Components\CsvExport;
use Nayjest\Grids\Components\ExcelExport;
use Nayjest\Grids\Components\Filters\DateRangePicker;
use Nayjest\Grids\Components\FiltersRow;
use Nayjest\Grids\Components\HtmlTag;
use Nayjest\Grids\Components\Laravel5\Pager;
use Nayjest\Grids\Components\OneCellRow;
use Nayjest\Grids\Components\RecordsPerPage;
use Nayjest\Grids\Components\RenderFunc;
use Nayjest\Grids\Components\ShowingRecords;
use Nayjest\Grids\Components\TFoot;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\Components\TotalsRow;
use Nayjest\Grids\DbalDataProvider;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

// leave namespace out so that functions are global
//namespace App\Http\Middleware;

//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//
//  BUILD MAIN GRID
//
// build the REPORT.SHOW.BLADE main report grid
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
if (!function_exists('BuildReport')) {
    function BuildReport($reportId,$reportType,$input,$report)

    {

// dump('ReportFunctions.BuildReport() $input');
// dump($input);

// foreach ($input as $queryParameters){
//   dump($queryParameters);
//
//   // $key = array_search ($queryParameters, $input);
//   $key = key($input);
//   dump($key);
//
// }


      //######################################
      // build $query
      //######################################
      switch ($reportType) {
        case "POS":
          $query = (new Position)
            ->newQuery()
            ->select('*');
          break;

        case "POSH":
        $query = (new Position)
          ->newQuery()
          ->select('*')
          ->join('hpositions', 'positions.posno', '=', 'hpositions.posno');
        break;

          break;

        case "INC":
          // code
          $query = (new Incumbent)
            ->newQuery()
            ->select('incumbents.company as inccomp'
                ,'positions.company as poscomp'
                ,'incumbents.posno'
                ,'incumbents.lname'
                ,'unitrate'
                ,DB::raw('(unitrate + 1) as newrate')
                ,'positions.descr'
                ,'positions.level1')
            ->join('positions', 'incumbents.posno', '=', 'positions.posno')
            ->where('positions.Active', '=', 'A');



          break;

        case "INCH":
          // code

          break;

        case "BUDG":
          // code
          $query = (new Position)
            ->newQuery()
            ->select('positions.company as poscomp'
                ,'positions.posno'
                ,'positions.descr'
                ,DB::raw('sum(positions.budgsal) as budgsal')
                ,DB::raw('sum(positions.fulltimeequiv) as budgfte')
                ,DB::raw('sum(incumbents.annual) as actsal')
                ,DB::raw('sum(incumbents.fulltimeequiv) as actfte')
                ,DB::raw('sum(positions.fulltimeequiv-incumbents.fulltimeequiv) as ftevar')
                ,DB::raw('sum(positions.budgsal-incumbents.annual) as salvar')
                )
            ->leftjoin('incumbents', 'positions.posno', '=', 'incumbents.posno')
            ->groupBy('positions.company','positions.posno','positions.descr')
            ->where('incumbents.active', '<>', 'xA');

          break;

        case "VAC":
          // code

          break;

        case "RECR":
          // code

          break;

        default:

      }


AddFilters($input,$query);

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

      // instantiate grid configuration object, set data provider
      $config = new GridConfig();
      $dp = new EloquentDataProvider($query);
      $config->setDataProvider($dp);
      $config->setPageSize(20);


      $config->setComponents([


        (new THead)
          ->setComponents([
            // (new ColumnHeadersRow),

            // (new FiltersRow)
            //     ->addComponents([]),

             (new OneCellRow)
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setComponents([
                  (new CsvExport)->setFileName($report->descr . date(' Y-m-d H-i-s')),
                  (new HtmlTag)
                     ->setAttributes(['class' => 'pull-right'])
                     ->addComponent(new ShowingRecords)
                  ]), //end ->setComponenets

              (new OneCellRow)
               ->setRenderSection(RenderableRegistry::SECTION_END)
               ->setComponents([
                   new Pager,
                 ]), //end ->setComponenets
                 (new ColumnHeadersRow),
          ]) //end ->setComponents
        ]); //end $config->setComponents

      // add columns from the AddColumns() custom function
      AddColumns($config,$reportId);
      // dump($config);

      // render the grid, and send it to the HTML
      $grid = new Grid($config);
      $grid = $grid->render();

      return $grid;
    }
}

//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//
//  BUILD SUMMARY GRID
//
// build the REPORT.SHOW.BLADE summary report grid
// this is the grid that shows subtotals and counts, between the report parameters and the main report grid
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
if (!function_exists('BuildReportSummary')) {
    function BuildReportSummary($reportId,$reportType,$input)
    {

      //######################################
      // build $query
      //######################################
      switch ($reportType) {
        case "POS":
          // code for pos
          $querySummary = (new Position)
            ->newQuery()
            ->selectRaw('count(*) as count, sum(budgsal) as sumbudgsal, positions.company, positions.level1,positions.level2')
            ->groupBy('positions.company','positions.level1','positions.level2');
            // ->where('positions.Active', '=', 'A');

          break;

        case "POSH":
        $querySummary = (new Position)
          ->newQuery()
          ->select('*')
          ->join('hpositions', 'positions.posno', '=', 'hpositions.posno');

          break;

        case "INC":
          // code
          $querySummary = (new Incumbent)
            ->newQuery()
            ->selectRaw('count(*) as curstatus, positions.company, positions.level1,positions.level2')
            ->groupBy('positions.company','positions.level1','positions.level2')
            ->join('positions', 'incumbents.posno', '=', 'positions.posno')
            ->where('positions.Active', '=', 'A');

          break;

        case "INCH":
          // code

          break;

          case "BUDG":
            // code
            $querySummary = (new Incumbent)
              ->newQuery()
              ->selectRaw('count(*) as curstatus, positions.company, positions.level1,positions.level2')
              ->groupBy('positions.company','positions.level1','positions.level2')
              ->join('positions', 'incumbents.posno', '=', 'positions.posno')
              ->where('positions.Active', '=', 'A');

            break;

          default:
      }

      AddFilters($input,$querySummary);

      // instantiate grid configuration object, set data provider
      $configSummary = new GridConfig();
      $dp = new EloquentDataProvider($querySummary);
      $configSummary->setDataProvider($dp);
      $configSummary->setPageSize(50);

      $configSummary->setComponents([

        (new THead)
          ->setComponents([
            // (new ColumnHeadersRow),

            // (new FiltersRow)
            //     ->addComponents([]),

             (new OneCellRow)
              ->setRenderSection(RenderableRegistry::SECTION_END)
              ->setComponents([
                  (new CsvExport)->setFileName('my_report' . date('Y-m-d')),
                  (new HtmlTag)
                     ->setAttributes(['class' => 'pull-right'])
                     ->addComponent(new ShowingRecords)
                  ]), //end ->setComponenets

              (new OneCellRow)
               ->setRenderSection(RenderableRegistry::SECTION_END)
               ->setComponents([
                   new Pager,
                 ]), //end ->setComponenets
                 (new ColumnHeadersRow),
          ]) //end ->setComponents
        ]); //end $config->setComponents

      // add columns from the AddColumns() custom function
      AddColumnSubs($configSummary,$reportId);
      // dump($config);

      // render the grid, and send it to the HTML
      $gridSummary = new Grid($configSummary);
      $gridSummary = $gridSummary->render();

      return $gridSummary;
    }
}

//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
// iterate through columns from REPORTCOLUMNS and add the columns into the main report grid, in BUILDREPORT()
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
if (!function_exists('AddColumns')) {
  function AddColumns($config,$reportId)
  {
    $availablereportcolumns = \DB::table('reportcolumns')
      ->where('reportid','=',$reportId)
      ->orderby("columnorder","asc")
      ->orderby("header","asc")
      ->get();

    foreach ($availablereportcolumns as $repcols){
      $colField       =$repcols->field;
      $colHeader      =$repcols->header;
      $colSortable    =$repcols->sortable;
      $colSortOrder   =$repcols->sortorder;
      $colGroupOrder  =$repcols->grouporder;
      $colSubtotal    =$repcols->subtotal;
      $colTotal       =$repcols->total;
      $colCount       =$repcols->count;
      $colHidden      =$repcols->hidden;
      $colFormat      =$repcols->format;

      if ($ColSortable = "Y") {
        $colSortable = "TRUE";
      } else {
        $colSortable = "FALSE";
      }

      if (strlen($colFormat) <> 0) {
        $formatColumn = "TRUE";
          } else {
        $formatColumn = "FALSE";
      }


      if ($formatColumn == "TRUE") {
      $config->addColumn((new FieldConfig())
        ->setName($colField)
        ->setLabel($colHeader)
        ->setSortable($colSortable)
        ->setCallback(function ($val,$formatDecimals) {return "$".(number_format($val, 2, '.', ','));})
        );
      } else {

      $config->addColumn((new FieldConfig())
        ->setName($colField)
        ->setLabel($colHeader)
        ->setSortable($colSortable)
      );
    }
  }
  }
}

//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
// iterate through columns from REPORTCOLUMNSUBS and add the columns into the summary report grid, in BUILDREPORTSUMMARY()
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
if (!function_exists('AddColumnSubs')) {
  function AddColumnSubs($config,$reportId)
  {
    $availablereportcolumns = \DB::table('reportcolumnsubs')
      ->where('reportid','=',$reportId)
      ->orderby("columnorder","asc")
      ->orderby("header","asc")
      ->get();

    foreach ($availablereportcolumns as $repcols){
      $colField       =$repcols->field;
      $colHeader      =$repcols->header;
      $colSortable    =$repcols->sortable;
      $colSortOrder   =$repcols->sortorder;
      $colGroupOrder  =$repcols->grouporder;
      $colSubtotal    =$repcols->subtotal;
      $colTotal       =$repcols->total;
      $colCount       =$repcols->count;
      $colHidden      =$repcols->hidden;
      $colFormat      =$repcols->format;

      if ($ColSortable = "Y") {
        $colSortable = "TRUE";
      } else {
        $colSortable = "FALSE";
      }

      if (strlen($colFormat) <> 0) {
        $formatColumn = "TRUE";
          } else {
        $formatColumn = "FALSE";
      }

dump("1".$colField);

      if ($formatColumn == "TRUE") {
      $config->addColumn((new FieldConfig())
        ->setName($colField)
        ->setLabel($colHeader)
        ->setSortable($colSortable)
        ->setCallback(function ($val,$formatDecimals) {

              return "$".(number_format($val, 2, '.', ','));

          }
          )
        );
      } else {

        $config->addColumn((new FieldConfig())
          ->setName($colField)
          ->setLabel($colHeader)
          ->setSortable($colSortable)
          );


      }



      }
  }
}



//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//
// Analyze filters, and update $query
//
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><

if (!function_exists('AddFilters')) {
  function AddFilters($input,$query)
  {

// create an empty temp table to hold report parameters
// "where id=-1" is intended to create a table with no records (id would never equal -1)....not sure how to do that otherwise
DB::insert(
  DB::raw( "CREATE TEMPORARY TABLE tempQueries as (
    Select 000 as id
      ,space(100) as tablename
      , space(100) as fieldname
      , space(100) as BegValue
      , space(100) as EndValue
      , space(100) as DataType
      , space(300) as whereClause
      from positions
      where id=-1
    )"
  )
);

$id = 0;

// iterate through the values in the $input array
//
foreach ($input as $key => $value){

  $value = Arr::get($input,$key);

  // dump($key);
  // dump($value);

  // we have the key (beg/end, table, field) and the user's input value
  // first item in array is key = "_token."  Ignore this element
  // parse out data from $key and update tablename, fieldname, begvalue, endvalue
  if ($key <> "_token") {
    // parse out the key's contents
    // format is like:  beg|positions||company|||
    $break1 = strpos($key,"|");
    $break2 = strpos($key,"||");
    $break3 = strpos($key,"|||");
    $break4 = strpos($key,"||||");
    $begEnd = strtoupper(Substr($key,0,$break1));
    $tableName = substr($key,$break1+1,$break2-$break1-1);
    $fieldName = substr($key,$break2+2,$break3-$break2-2);
    $datatype  = substr($key,$break3+3,$break4-$break3-3);
    $nullField = NULL;

    // if this is a BEG record, then add new record
    if ($begEnd == "BEG") {
      $id = $id + 1;
      DB::insert('insert into tempQueries (id, tablename, fieldname, BegValue, DataType) values (?, ?, ?, ?, ?)', [$id, $tableName, $fieldName, $value, $datatype]);
    }

    // if this is an END record then put value in record with corresponding BEG
    if ($begEnd == "END") {
      DB::update('update tempQueries set EndValue = ? where tablename = ? and fieldname = ?', [$value, $tableName, $fieldName] );
      //DB::update('update tempQueries set EndValue = ? where fieldname = $fieldName', [$value] );
    }
  }
}

$exportQueryList = \DB::table('tempQueries')
  ->get();
// dump ('Temporary Table (actually, $exportQueryList)');
// dump ($exportQueryList);

foreach ($exportQueryList as $WhereClause){
  $WCTable=$WhereClause->tablename;
  $WCField=$WhereClause->fieldname;
  $WCBeg=$WhereClause->BegValue;
  $WCEnd=$WhereClause->EndValue;
  $WCType=strtoupper($WhereClause->DataType);

  $WCTableField=$WCTable.'.'.$WCField;
  $WCBegLike=$WCBeg."%";


  // begvalue is null, skip
  if (is_null($WCBeg)){
    // nothing to do...skip
  }

  // begvalue is not null, end value is null
  if (! is_null($WCBeg) and is_null($WCEnd)){
    // options:
    // Beg but no end:
    // string-like / decimal-equals / date-equals / boolean-equals
    if ($WCType=='STRING'){
      $query = $query->where($WCTableField, 'like', $WCBegLike);
      // dump($WCTableField);
      // dump($WCBegLike);
    } else {
      $query = $query->where($WCTableField, '=', $WCBeg);
      // dump($WCTableField);
      // dump($WCBeg);
    }
  }

  // begvalue and end value are not null
  if (! is_null($WCBeg) and ! is_null($WCEnd)){
    // options:
    // Beg and End
    // string-between / decimal-between / date-between / boolean-ignore
    if ($WCType<>'BOOLEAN'){
      $query = $query->wherebetween($WCTableField,[$WCBeg,$WCEnd]);
    } else {
      // no other options
    }
  }
}

// drop the temp table...don't need it any more
DB::update(DB::RAW('drop temporary table tempQueries'));

}
}
