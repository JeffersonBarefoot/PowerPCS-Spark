
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;

use App\Models\Post;
use App\Position;
use App\HPosition;
use App\Incumbent;
use App\HIncumbent;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;

// leave namespace out so that functions are global
//namespace App\Http\Middleware;

if (!function_exists('BuildPositionList')) {
    function BuildPositionList()
    {
      $grid = new Grid(
                  (new GridConfig)
                      ->setDataProvider(
                          new EloquentDataProvider(Position::query())
                      )
                      ->setName('example_grid4')
                      ->setPageSize(5)
                      ->setColumns([
                          (new FieldConfig) ->setName('company')  ->setLabel('Company'),
                          (new FieldConfig) ->setName('posno')    ->setLabel('posno'),
                          (new FieldConfig) ->setName('descr')    ->setLabel('descr')
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
              return $grid
    }
}
