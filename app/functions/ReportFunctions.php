
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


if (!function_exists('BuildReport')) {
    function BuildReport($reportId,$reportType)
    {

      //######################################
      // build $query
      //######################################
      switch ($reportType) {
        case "POS":
          // code for pos
          $query = (new Position)
            ->newQuery()
            ->select('*')
            ->where('positions.Active', '=', 'A');

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
            ->selectRaw('count(*) as curstatus, positions.company, positions.level1,positions.level2')
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
      AddColumns($configSummary,$reportId);
      // dump($config);

      // render the grid, and send it to the HTML
      $gridSummary = new Grid($configSummary);
      $gridSummary = $gridSummary->render();

      return $gridSummary;
    }
}

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
            // next line adds filter boxes, but doesn't work.  Clicking FILTER button returns "input file not specified"
            // ->addFilter((new FilterConfig)->setOperator(FilterConfig::OPERATOR_LIKE))
          );







          // $config->addColumn((new FieldConfig())->setName("inccomp")->setLabel('Inc Company')->setSortable(true));
          // $config->addColumn((new FieldConfig())->setName("posno")->setSortable(true));
          // $config->addColumn((new FieldConfig())->setName("level1")->setSortable(true));
          // $config->addColumn((new FieldConfig())->setName("unitrate")->setSortable(true));
          // $config->addColumn((new FieldConfig())->setName("newrate")->setSortable(true));
        }


    }
}
