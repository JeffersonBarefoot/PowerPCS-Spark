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
 // dump('ReportController.index');

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

    //****************************************************
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

//$viewinchistid = $request->input('viewinchistid');
//$navbarcompany = $request->input('company');
$begcompany = $request->input('beg|positions||company|||');
//dump($begcompany);
$input = $request->all();

//dump('$input');
//dump($input);


//dump('$request');
//dump($request);

      $report = Report::find($id);
      // $reportid = $report->id;
      // find the report type, i.e. POS, from $report.group1
      $reporttype = $report->group1;
      $reportid = $report->reportid;

      // dump($reporttype);


      // include all queries for this reporttype (all standard POS or POSH or INC queries), and for this specific report
      $reportqueries = \DB::table('reportqueries')
        ->where(function ($query) use ($reportid,$reporttype) {
            $query->where('reportid','=',$reportid)
              ->orwhere('reportid','=',$reporttype);
            })
        ->where('active','=',"A")
        ->orderby("sortorder","asc")
        ->get();

        //dump('$reportqueries');
        //dump($reportqueries);

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

      $availablereportsBUDG = \DB::table('reports')
        ->where('active','=',"A")
        ->where('group1','=',"BUDG")
        ->orderby("group1","asc")
        ->orderby("group2","asc")
        ->orderby("sortorder","asc")
        ->get();

      $availablereportsVAC = \DB::table('reports')
        ->where('active','=',"A")
        ->where('group1','=',"VAC")
        ->orderby("group1","asc")
        ->orderby("group2","asc")
        ->orderby("sortorder","asc")
        ->get();

      $availablereportsRECR = \DB::table('reports')
        ->where('active','=',"A")
        ->where('group1','=',"RECR")
        ->orderby("group1","asc")
        ->orderby("group2","asc")
        ->orderby("sortorder","asc")
        ->get();

      $reportdata = \DB::table('positions')
        ->where('active','=',"A")
        ->get();



$grid = "";
$gridSummary = "";

$query = BuildQuery($reportid,$reporttype,$input,$report);
$querySummary = "";

$CSVData = $query->get()->toArray();
sessionSet('CSVDataFromGrid',$CSVData);

$grid = BuildReport($reportid,$reporttype,$input,$report,$query);
// $gridSummary = BuildReportSummary($reportid,$reporttype,$input);

// dump('reportcontroller line 307');
// dump(session()->all());


      //****************************
      // R E T U R N   T O   positions.show
      return View('reports.show')
        // ->with(compact('dataGrid'))
        ->with(compact('grid'))
        ->with(compact('gridSummary'))
        // ->with(compact('text'))
        ->with(compact('report'))
        ->with(compact('reportqueries'))
        ->with(compact('reportdata'))
        ->with(compact('availablereportsPOS'))
        ->with(compact('availablereportsPOSH'))
        ->with(compact('availablereportsINC'))
        ->with(compact('availablereportsINCH'))
        ->with(compact('availablereportsBUDG'))
        ->with(compact('availablereportsVAC'))
        ->with(compact('availablereportsRECR'));
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

    //***************************************************
    //***************************************************
    //***************************************************
    //**   dumpGridToCsv
    //***************************************************
    //***************************************************
    //***************************************************
   public function dumpGridToCsv()
   {

     $fileCreated = fopen('../FileExports/TEAM00001/wxyzfile.' . getTimestamp() .  '.csv', 'w');
     // $fp = fopen('xxxfile.csv', 'w');

     $CSVData = sessionGet('CSVDataFromGrid');

     foreach ($CSVData as $exportRecord) {
       // dd($pos);
         fputcsv($fileCreated, $exportRecord);
     }
     fclose($fileCreated);

     return redirect('/reports/2')->with('success', 'CSV Export File Created');

   }
}
