<?php

namespace App\Http\Controllers;

// require("vendor/autoload.php");

use Cartalyst\DataGrid\DataHandlers\CollectionHandler;
use Cartalyst\DataGrid\Environment;

use Illuminate\Http\Request;
use App\Position;
use App\HPosition;
use App\Incumbent;
use App\Report;
use App\ReportQueries;
use Session;
use Auth;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;

// below are related to Nayjest Data Grid
use App\User;
use Grids;
use HTML;
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


class ReportController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');

      // $this->middleware('subscribed');

      // $this->middleware('verified');
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //***************************************************
     //***************************************************
     //***************************************************
     //**   I N D E X
     //***************************************************
     //***************************************************
     //***************************************************
    public function index(Request $request)
    {
//        the requests below work ok...JLB 20190930
//        $url = $request->fullUrl();
//        $input = $request->all();

        // $company = $request->input('company');
        // $posno = $request->input('posno');
        // $descr = $request->input('descr');
//      dd($company);
//      dd($posno);
 dump('ReportController.index');

        $positions = Position::all();
        //$positionsnavbar = Position::all();
//        $positionsnavbar = GetPositions('company','=','SAMPLE');
        $reports = Report::all();

        $company = $request->input('company');
        $report = $request->input('posno');
        $descr = $request->input('descr');
        $reportsnavbar = Position::where('company','like',"%$company%")
                            ->where('posno','like',"%$posno%")
                            ->where('descr','like',"%$descr%")
                            ->get();

//dd($positions);
//dd($positionsnavbar);
        //return view('positions.index', compact('positions'));
//        ! @isset($company)
//          $company=""
//        @endisset
//        $company = company;
//        return view("positions.index")->withCompany($company);
//$test = "test message";
//$company = "ZSI";
//dd($test);
        return view("reports.index",
          compact('reports'),
          compact('reportsnavbar'));

        // return view("reports.index");

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //***************************************************
     //***************************************************
     //***************************************************
     //**   C R E A T E
     //**   This works together with STORE to add a new record
     //***************************************************
     //***************************************************
     //***************************************************
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //***************************************************
     //***************************************************
     //***************************************************
     //**   S T O R E
     //**   This works together with CREATE to add a new record
     //***************************************************
     //***************************************************
     //***************************************************
    public function store(Request $request)
    {
      dump('positioncontroller.store');

        $request->validate([
            'company'=>'required',
            'posno'=>'required',
            'descr'=>'required'
        ]);

        $position = new Position([
            'company' => $request->get('company'),
            'posno' => $request->get('posno'),
            'descr' => $request->get('descr')
        ]);
        $position->save();
        return redirect('/positions')->with('success', 'Position saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //***************************************************
    //***************************************************
    //***************************************************
    //**   S H O W
    //***************************************************
    //***************************************************
    //***************************************************
    public function show($id,Request $request)
    {

      if (is_null($id)) {
        $id=1;
      }

      $report = Report::find($id);
      // $reportid = $report->id;
      // find the report type, i.e. POS, from $report.group1
      $reporttype = $report->group1;


      // include all queries for this reporttype (all standard POS or POSH or INC queries), and for this specific report
      $reportqueries = \DB::table('reportqueries')
        ->where(function ($query) use ($id,$reporttype) {
            $query->where('reportid','=',$id)
              ->orwhere('reportid','=',$reporttype);
            })
        ->where('active','=',"A")
        ->orderby("sortorder","asc")
        ->get();

      $availablereportsPOS = \DB::table('reports')
        ->where('active','=',"A")
        ->where('group1','=',"POS")
        ->orderby("group1","asc")
        ->orderby("group2","asc")
        ->orderby("sortorder","asc")
        ->get();

      $availablereportsPOSH = \DB::table('reports')
        ->where('active','=',"A")
        ->where('group1','=',"POSH")
        ->orderby("group1","asc")
        ->orderby("group2","asc")
        ->orderby("sortorder","asc")
        ->get();

      $availablereportsINC = \DB::table('reports')
        ->where('active','=',"A")
        ->where('group1','=',"INC")
        ->orderby("group1","asc")
        ->orderby("group2","asc")
        ->orderby("sortorder","asc")
        ->get();

      $availablereportsINCH = \DB::table('reports')
        ->where('active','=',"A")
        ->where('group1','=',"INCH")
        ->orderby("group1","asc")
        ->orderby("group2","asc")
        ->orderby("sortorder","asc")
        ->get();

      $reportdata = \DB::table('positions')
        ->where('active','=',"A")
        ->get();




        // $cfg = [
        //     'src' => 'App\User',
        //     'columns' => [
        //             'id',
        //             'name',
        //             'email',
        //             'country'
        //     ]
        // ];
        // echo \Grids::make($cfg);


//######################################
// This block returns a useable grid to Reports.Blade.Show
// Nayjest Data Grids
// JLB 2020-09-04
//######################################
        // $cfg = [
        //     'src' => 'App\User',
        //     'columns' => [
        //         'id',
        //         'name',
        //         'email',
        //         'country'
        //     ]
        // ];
        // $grid = Grids::make($cfg);
        // $text = "<h1>Basic grid example</h1>";
//######################################

//######################################
// This block returns a Position Listing grid to Reports.Blade.Show
// Nayjest Data Grids
// JLB 2020-09-04
//######################################
$cfg = [
    'src' => 'App\Position',
    'columns' => [
        'company',
        'posno',
        'descr',
        'level1'
    ]
];
$grid = Grids::make($cfg);
$text = "<h1>Basic grid example</h1>";
//######################################





//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

$grid = new Grid(
            (new GridConfig)
                ->setDataProvider(
                    new EloquentDataProvider(Position::query())
                )
                ->setName('example_grid4')
                ->setPageSize(15)
                ->setColumns([
                    (new FieldConfig)
                        ->setName('company')
                        ->setLabel('company')
                        ->setSortable(true)
                        ->setSorting(Grid::SORT_ASC)
                    ,
                    (new FieldConfig)
                        ->setName('posno')
                        ->setLabel('posno')
                        ->setCallback(function ($val) {
                            return "<span class='glyphicon glyphicon-user'></span>{$val}";
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    (new FieldConfig)
                        ->setName('descr')
                        ->setLabel('descr')
                        ->setCallback(function ($val) {
                            return "<span class='glyphicon glyphicon-user'></span>{$val}";
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)
                                ->setOperator(FilterConfig::OPERATOR_LIKE)
                        )
                    ,
                    // (new FieldConfig)
                    //     ->setName('descr`')
                    //     ->setLabel('descr')
                    //     ->setSortable(true)
                    //     ->setCallback(function ($val) {
                    //         $icon = '<span class="glyphicon glyphicon-envelope"></span>&nbsp;';
                    //         return
                    //             '<small>'
                    //             . $icon
                    //             . HTML::link("mailto:$val", $val)
                    //             . '</small>';
                    //     })
                    //     ->addFilter(
                    //         (new FilterConfig)
                    //             ->setOperator(FilterConfig::OPERATOR_LIKE)
                    //     )
                    // ,
                    // (new FieldConfig)
                    //     ->setName('phone_number')
                    //     ->setLabel('Phone')
                    //     ->setSortable(true)
                    //     ->addFilter(
                    //         (new FilterConfig)
                    //             ->setOperator(FilterConfig::OPERATOR_LIKE)
                    //     )
                    // ,
                    // (new FieldConfig)
                    //     ->setName('country')
                    //     ->setLabel('Country')
                    //     ->setSortable(true)
                    // ,
                    // (new FieldConfig)
                    //     ->setName('company')
                    //     ->setLabel('Company')
                    //     ->setSortable(true)
                    //     ->addFilter(
                    //         (new FilterConfig)
                    //             ->setOperator(FilterConfig::OPERATOR_LIKE)
                    //     )
                    // ,
                    // (new FieldConfig)
                    //     ->setName('birthday')
                    //     ->setLabel('Birthday')
                    //     ->setSortable(true)
                    // ,
                    // (new FieldConfig)
                    //     ->setName('posts_count')
                    //     ->setLabel('Posts')
                    //     ->setSortable(true)
                    // ,
                    // (new FieldConfig)
                    //     ->setName('comments_count')
                    //     ->setLabel('Comments')
                    //     ->setSortable(true)
                    // ,
                ])
                ->setComponents([
                    (new THead)
                        ->setComponents([
                            (new ColumnHeadersRow),
                            (new FiltersRow)
                                ->addComponents([
                                    // (new RenderFunc(function () {
                                    //     return HTML::style('js/daterangepicker/daterangepicker-bs3.css')
                                    //     . HTML::script('js/moment/moment-with-locales.js')
                                    //     . HTML::script('js/daterangepicker/daterangepicker.js')
                                    //     . "<style>
                                    //             .daterangepicker td.available.active,
                                    //             .daterangepicker li.active,
                                    //             .daterangepicker li:hover {
                                    //                 color:black !important;
                                    //                 font-weight: bold;
                                    //             }
                                    //        </style>";
                                    // }))
                                    // ->setRenderSection('filters_row_column_birthday'),
                                    // (new DateRangePicker)
                                    //     ->setName('birthday')
                                    //     ->setRenderSection('filters_row_column_birthday')
                                    //     ->setDefaultValue(['1990-01-01', date('Y-m-d')])
                                ])
                            ,
                            (new OneCellRow)
                                ->setRenderSection(RenderableRegistry::SECTION_END)
                                ->setComponents([
                                    new RecordsPerPage,
                                    new ColumnsHider,
                                    (new CsvExport)
                                        ->setFileName('my_report' . date('Y-m-d'))
                                    ,
                                    new ExcelExport(),
                                    (new HtmlTag)
                                        ->setContent('<span class="glyphicon glyphicon-refresh"></span> Filter')
                                        ->setTagName('button')
                                        ->setRenderSection(RenderableRegistry::SECTION_END)
                                        ->setAttributes([
                                            'class' => 'btn btn-success btn-sm'
                                        ])
                                ])

                        ])
                    ,
                    // (new TFoot)
                    //     ->setComponents([
                    //         (new TotalsRow(['posts_count', 'comments_count'])),
                    //         (new TotalsRow(['posts_count', 'comments_count']))
                    //             ->setFieldOperations([
                    //                 'posts_count' => TotalsRow::OPERATION_AVG,
                    //                 'comments_count' => TotalsRow::OPERATION_AVG,
                    //             ])
                    //         ,
                    //         (new OneCellRow)
                    //             ->setComponents([
                    //                 new Pager,
                    //                 (new HtmlTag)
                    //                     ->setAttributes(['class' => 'pull-right'])
                    //                     ->addComponent(new ShowingRecords)
                    //                 ,
                    //             ])
                    //     ])
                    // ,
                ])
        );
        $grid = $grid->render();
        // return view('demo.default', compact('grid'));
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^



















// // trying to get cartalyst data grid to work, 2020-09-01
//         $object = new \StdClass;
//         $object->title = 'foo';
//         $object->age = 20;
//
//         $data = [
//             [
//                 'title' => 'bar',
//                 'age'   => 34,
//             ],
//             $object,
//         ];
//
//         $settings = [
//             'columns' => [
//                 'title',
//                 'age',
//             ]
//         ];
//
//         $handler = new CollectionHandler($data, $settings);
//         // the line below throws an error
//         $dataGrid = \DataGrid::make($handler);
//
// dump($grid);


      //****************************
      // R E T U R N   T O   positions.show
      return View('reports.show')
        // ->with(compact('dataGrid'))
        ->with(compact('grid'))
        ->with(compact('text'))
        ->with(compact('report'))
        ->with(compact('reportqueries'))
        ->with(compact('reportdata'))
        ->with(compact('availablereportsPOS'))
        ->with(compact('availablereportsPOSH'))
        ->with(compact('availablereportsINC'))
        ->with(compact('availablereportsINCH'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //***************************************************
     //***************************************************
     //***************************************************
     //**   E D I T
     //**   this works together with UPDATE to edit a single record
     //***************************************************
     //***************************************************
     //***************************************************
         public function edit($id)
    {
      // dump('positioncontroller.edit');
      if (is_null($id)) {
        $id=1;
      }

      $position = Position::find($id);

      return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //***************************************************
     //***************************************************
     //***************************************************
     //**   U P D A T E
     //**   this works together with EDIT to edit a single record
     //***************************************************
     //***************************************************
     //***************************************************
    public function update(Request $request, $id)
    {

      if (is_null($id)) {
        $id=1;
      }

      // dump('positioncontroller.update');
      UpdatePosition($id, $request);

      return redirect('/positions')->with('success', 'Position updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //***************************************************
     //***************************************************
     //***************************************************
     //**   D E S T R O Y
     //***************************************************
     //***************************************************
     //***************************************************
    public function destroy($id)
    {
      dump('positioncontroller.destroy');

      $position = Position::find($id);
      $position->delete();

      return redirect('/positions')->with('success', 'Position deleted!');
    }
}
