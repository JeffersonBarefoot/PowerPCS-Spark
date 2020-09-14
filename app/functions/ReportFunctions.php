
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



if (!function_exists('BuildPositionListxxxxx')) {
    function BuildPositionListxxxxx()
    {
      $grid = new Grid(
        (new GridConfig)
          ->setDataProvider(
              new EloquentDataProvider(Position::query())
          )
          ->setName('example_grid44')
          ->setPageSize(5)
          ->setColumns([
              (new FieldConfig) ->setName('company')  ->setLabel('xCompany'),
              (new FieldConfig) ->setName('posno')    ->setLabel('Pos #'),
              (new FieldConfig) ->setName('descr')    ->setLabel('Descr')
          ])

          ->setComponents([
            (new THead)
              ->setComponents([
                (new ColumnHeadersRow),
                (new OneCellRow)
                  ->setRenderSection(RenderableRegistry::SECTION_END)
                  ->setComponents([
                     new RecordsPerPage,
                    (new CsvExport) ->setFileName('my_report' . date('Y-m-d')),
                    new ExcelExport(),
                  ])
              ])
            ,
          ])
        );
      $grid = $grid->render();
      return $grid;
    }
}



// if (!function_exists('zzzzxxxxxBuildPositionList')) {
//     function BuildPositionList()
//     {
//       $grid = new Grid(
//         (new GridConfig)
//           ->setDataProvider(
//               new EloquentDataProvider(Position::query())
//           )
//           ->setName('example_grid44')
//           ->setPageSize(5)
//           ->setColumns([
//               (new FieldConfig) ->setName('company')  ->setLabel('xCompany'),
//               (new FieldConfig) ->setName('posno')    ->setLabel('Pos #'),
//               (new FieldConfig) ->setName('descr')    ->setLabel('Descr')
//           ])
//
//           ->setComponents([
//             (new THead)
//               ->setComponents([
//                 (new ColumnHeadersRow),
//                 (new OneCellRow)
//                   // ->setRenderSection(RenderableRegistry::SECTION_END)
//                   ->setComponents([
//                      new RecordsPerPage,
//                     (new CsvExport) ->setFileName('my_report' . date('Y-m-d')),
//                      new ExcelExport(),
//                   ])
//               ])
//             ,
//
// // (new TFoot)
// //     ->setComponents([
// //         (new TotalsRow(['posno_count', 'company_count'])),
// //         (new TotalsRow(['posno_count', 'company_count']))
//             // ->setFieldOperations([
//             //     'posno_count' => TotalsRow::OPERATION_AVG,
//             //     'company_count' => TotalsRow::OPERATION_AVG,
//             // ])
//         ,
//         // (new OneCellRow)
//         //     ->setComponents([
//         //         new Pager,
//         //         (new HtmlTag)
//         //             ->setAttributes(['class' => 'pull-right'])
//         //             ->addComponent(new ShowingRecords)
//         //         ,
//         //     ])
//             ])
//             // ])
//             ,
//         );
//
//       $grid = $grid->render();
//
//       return $grid;
//     }
// }

if (!function_exists('BuildPositionList')) {
    function BuildPositionList()
    {
      $grid = new Grid(
        (new GridConfig)
          ->setDataProvider(
              new EloquentDataProvider(Position::query())
          )
          ->setName('example_grid44')
          ->setPageSize(5)
          ->setColumns([
              (new FieldConfig) ->setName('company')  ->setLabel('xCompany'),
              (new FieldConfig) ->setName('posno')    ->setLabel('Pos #'),
              (new FieldConfig) ->setName('descr')    ->setLabel('Descr')
          ])

          ->setComponents([
            (new THead)
              ->setComponents([
                (new ColumnHeadersRow),
                (new OneCellRow)
                  ->setRenderSection(RenderableRegistry::SECTION_END)
                  ->setComponents([
                     new RecordsPerPage,
                    (new CsvExport) ->setFileName('my_report' . date('Y-m-d')),
                     new ExcelExport(),
                  ])
              ])
            ,
          ])
        );

      // $grid = $grid->render();
      // $grid->getConfig()->getDataProvider()->setPageSize(4);
      $grid = $grid->render();

      return $grid;
    }
}
