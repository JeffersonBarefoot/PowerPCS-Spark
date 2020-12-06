
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
// build the REPORT.SHOW.BLADE main report grid
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
if (!function_exists('BuildReport')) {
    function BuildReport($reportId,$reportType,$input)

    {

dump('ReportFunctions.BuildReport() $input');
dump($input);

// foreach ($input as $queryParameters){
//   dump($queryParameters);
//
//   // $key = array_search ($queryParameters, $input);
//   $key = key($input);
//   dump($key);
//
// }

// create an empty temp table to hold report parameters
DB::insert(
  DB::raw( "CREATE TEMPORARY TABLE tempQueries as (
    Select 000 as id
      ,space(100) as tablename
      , space(100) as fieldname
      , space(100) as BegValue
      , space(100) as EndValue
      , space(300) as whereClause
      from positions
      where company = 'DontIncludeAnyRecords'
    )"
  )
);

$id = 0;

foreach ($input as $key => $value){

  $value = Arr::get($input,$key);
  //dump($key);
  //dump($value);




  // we have the key (beg/end, table, field) and the user's input value
  // first item in array is key = "_token."  Ignore this element
  // parse out data from $key and update tablename, fieldname, begvalue, endvalue
  if ($key <> "_token") {
    // parse out the key's contents
    // format is like:  beg|positions||company|||
    $break1 = strpos($key,"|");
    $break2 = strpos($key,"||");
    $break3 = strpos($key,"|||");
    $begEnd = strtoupper(Substr($key,0,$break1));
    //$begEnd2 = substr($key,1,3);
    $tableName = substr($key,$break1+1,$break2-$break1-1);
    $fieldName = substr($key,$break2+2,$break3-$break3-3);
    $nullField = NULL;

    // dump($begEnd);

    // if BEG record, then add new record
    if ($begEnd == "BEG") {
      $id = $id + 1;
      DB::insert('insert into tempQueries (id, tablename, fieldname, BegValue) values (?, ?, ?, ?)', [$id, $tableName, $fieldName, $value]);
    }

    // if END record then put value in record with corresponding BEG
    if ($begEnd == "END") {
      DB::update('update tempQueries set EndValue = ? where tablename = ? and fieldname = ?', [$value, $tableName, $fieldName] );
      //DB::update('update tempQueries set EndValue = ? where fieldname = $fieldName', [$value] );
    }
  }

  // - if null skip
  // - if not null, parse out
  // - see if there is a corresponding end Record
  //    - if there is a corresponding record, create ->where record using BETWEEN
  //    - if no corresponding record, create ->where record using LIKE

}

// Build report query for each query record, and put into temp mysql_list_tables
// DB::update('update tempQueries set whereClause = ? where BegValue <> ? and tablename = ? and fieldname = ?', ["TEST WHERE CLAUSE", "xxxx", $tableName, $fieldName] );
DB::update('update tempQueries set whereClause = ? where BegValue is null ', [""] );
// DB::update('update tempQueries set whereClause = ? where BegValue is not null and EndValue is null ',["->where('".fieldname."', '=', ".BegValue."'"   ] );
// DB::insert('update tempQueries set whereClause = ? where BegValue is not null and EndValue is null ',[DB::raw("fieldname")] );
DB::update('update tempQueries set whereClause = ? where BegValue is not null and EndValue is null ',["tempQueries.fieldname"]);

// DB::update(DB::RAW('update tempQueries set whereClause = tempQueries.fieldname  where BegValue is not null and EndValue is null' ,['1']));
// DB::update(DB::RAW('update tempQueries set whereClause = concat('->where(',tempQueries.fieldname)  where BegValue is not null and EndValue is null' ));
// DB::update(DB::RAW('update tempQueries set whereClause = concat("abc",tempQueries.fieldname)  where BegValue is not null and EndValue is null' ));
// ->where('active','=',"A")



$exportQueryList = \DB::table('tempQueries')
  ->get();
dump ('Temporary Table');
dump ($exportQueryList);

// drop the temp table...don't need it any more
DB::update(DB::RAW('drop temporary table tempQueries'));

// $begcompany = $request->input('beg|positions||company|||');
// dump($begcompany);

      //######################################
      // build $query
      //######################################
      switch ($reportType) {
        case "POS":
          // code for pos

          $query1 = "Y"
          $testQuery1 = 'positions.Company' ;
          $testQuery2 = 'like';
          $testQuery3 = 'Z%';
          $testQuery4 = "where";

          $query2 = "Y"
          $testQuery10 = 'positions.posno' ;
          $testQuery20 = '[100,200]';
          $testQuery30 = '';
          $testQuery40 = "wherebetween";

          // $testQuery1 = 'positions.StartDate' ;
          // $testQuery2 = '<';
          // $testQuery3 = '2000-01-01';
          // $testQuery4 = "where";

          // $test5 = ""->where('positions.Active', '=', 'A')";

          // $query = (new Position)
          //   ->newQuery()
          //   ->select('*')
          //   ->where('positions.Active', '=', 'A');
          $query = (new Position)
            ->newQuery()
            ->select('*');

            if (!empty($query1)){
              $query = $query->where('positions.Active', '=', 'A');
            };

            if (!empty($query2)){
              $query = $query->where('positions.company', 'like', 'S%');
            };



          // see new bookmark in laravel\eloquent on Jeff's computer
          // 2020-12-04 JLB

          break;

        case "POSH":
          // code

          break;

        case "INC":
          // code
          $query = (new Incumbent)
            ->newQuery()
            ->select('incumbents.company as inccomp'
                ,'positions.company as poscomp'
                ,'incumbents.posno'
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

          default:

      }

      // instantiate grid configuration object, set data provider
      $config = new GridConfig();
      $dp = new EloquentDataProvider($query);
      $config->setDataProvider($dp);
      $config->setPageSize(50);


      $config->setComponents([


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
// build the REPORT.SHOW.BLADE summary report grid
// this is the grid that shows subtotals and counts, between the report parameters and the main report grid
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
//><><><><><><><><><><><><><><><><><><><><><><><><><><><><><><
if (!function_exists('BuildReportSummary')) {
    function BuildReportSummary($reportId,$reportType)
    {

      //######################################
      // build $query
      //######################################
      switch ($reportType) {
        case "POS":
          // code for pos
          $querySummary = (new Incumbent)
            ->newQuery()
            ->selectRaw('count(*) as count, sum(budgsal) as sumbudgsal, positions.company, positions.level1,positions.level2')
            ->groupBy('positions.company','positions.level1','positions.level2')
            ->join('positions', 'incumbents.posno', '=', 'positions.posno')
            ->where('positions.Active', '=', 'A');

          break;

        case "POSH":
          // code

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

          default:
      }

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

      if ($ColSortable = "Y") {
        $colSortable = "TRUE";
      } else {
        $colSortable = "FALSE";
      }

      $config->addColumn((new FieldConfig())
        ->setName($colField)
        ->setLabel($colHeader)
        ->setSortable($colSortable)
      );
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

      if ($ColSortable = "Y") {
        $colSortable = "TRUE";
      } else {
        $colSortable = "FALSE";
      }

      $config->addColumn((new FieldConfig())
        ->setName($colField)
        ->setLabel($colHeader)
        ->setSortable($colSortable)
      );
    }
  }
}
