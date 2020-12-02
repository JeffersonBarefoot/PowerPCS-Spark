<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\HPosition;
use App\Incumbent;
use Session;
use Auth;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;


class PositionController extends Controller
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
 dump('xxpositioncontroller.index');

        $positions = Position::all();
        //$positionsnavbar = Position::all();
//        $positionsnavbar = GetPositions('company','=','SAMPLE');

        $company = $request->input('company');
        $posno = $request->input('posno');
        $descr = $request->input('descr');
        $positionsnavbar = Position::where('company','like',"%$company%")
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
        return view("positions.index",
          compact('positions'),
          compact('positionsnavbar'));
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
      // dump('positioncontroller.show');
      // dump($id);
      // dump("end");
      dump($request);


      if (is_null($id)) {
        $id=1;
      }
      $position = Position::find($id);

dump('id');
dump($id);

      // if sess var positionID is null, then this is a fresh launch.  Save the current ID to the session variable
      $sessionPositionID = Session::get('positionID');
      if (is_null($sessionPositionID)) {
        $sessionPositionID = $id;
        Session::put('positionID', $id);
      }

      //\/\/\/\/\/\/\/\/\/\/\
      // Restore all variables as they were on last SHOW. could be NULL if first time
      //\/\/\/\/\/\/\/\/\/\/\

      //\/\/\/\/\/\/\/\/\/\/\
      // if we just selected a new position, then clear out position specific session variables
      //\/\/\/\/\/\/\/\/\/\/\
      // reports to
      // incumbents, incumbent history
      // position history
      //
      //newly selected position


      if ($sessionPositionID <> $id) { // not on the same position as last time
        // code...
        Session::put('positionID', $id);
        $viewincid = '' ;
        //dump('New position!!');
        //dump($sessionPositionID);
        //dump($id);
        // clear out all session variables.  If applicable, reset to the current position
        Session::put('reportsDirTo', '');
        Session::put('reportsIndirTo', '');
        Session::put('viewincid', '');
        Session::put('viewinchistid', '');
        $viewinchistid='';
        Session::put('viewPosHistId', '');

      } else {
        //dump('Same Position');
        $viewincid = Session::get('viewincid') ;
        $viewinchistid = Session::get('viewinchistid') ;
        $reportsDirTo = Session::get('reportsDirTo');
        $reportsIndirTo = Session::get('reportsIndirTo');

      }
      //dump('checking whether session variable was set ... ' . $viewincid);





      //gather general info
      $posno = $position->posno;
      $company = $position->company;


      //****************************
      // N A V B A R
      // these variables are used to populate the NavBar, not the main portion of Positions.Show
      $navbarcompany = $request->input('company');
      $navbarposno = $request->input('posno');
      $navbardescr = $request->input('descr');

      dump($request);
      dump($navbarcompany);

      $testAriaCollapse = $request->input('testArial');
//dump($testAriaCollapse);
//dump($navbarposno);

      $positionsnavbar = Position::where('company','like',"$navbarcompany%")
                          ->where('posno','like',"$navbarposno%")
                          ->where('descr','like',"%$navbardescr%")
                          ->orderby("company")
                          ->orderby("descr")
                          ->get();

      //****************************
      // I N C U M B E N T S
      // gather all incumbents related to this position



      if (!empty($request->input('viewinchistid'))) {
        $viewinchistid = $request->input('viewinchistid');

      //what if this is a new incHistId?  Do we blank out the details, or return first record?
      //jlb 20200225

      }



      // see if we passed a new viewincid, so need to update the variable
      // otherwise keep the one that we have been using
      if (!empty($request->input('viewincid'))) {
        $viewincid = $request->input('viewincid');
        $viewinchistid = '';
      }
      //dump('$viewincid = '.$viewincid);
      //dump('$viewinchistid = '.$viewinchistid);


      $incumbentsinposition = \DB::table('incumbents')
        ->where('posno','=',$posno)
        ->orderby("active_pos","asc")
        ->orderby("posstart","desc")
        ->get();

      // determine all ACTIVE incumbents related to this position
      $activeincumbentsinposition = \DB::table('incumbents')
        ->where('posno','=',$posno)
        ->where('active_pos','=','A')
        ->orderby("posstart","desc")
        ->get();


      // build a text element that can be displayed on the incumbents tab
      $activeincumbentlist = '';
      foreach ($activeincumbentsinposition as $ActInc){
        $activeincumbentlist = $activeincumbentlist.substr($ActInc->fname,0,1).' '.$ActInc->lname.', ' ;
      }

      $activeincumbentcount = $activeincumbentsinposition->count();

      // pull all details for a selected incumbent.
      // this is used to identify the empno and company, for the history query
      $viewincumbent = \DB::table('incumbents')
        ->where('id','=',$viewincid)
        ->get();
      $incumbentCompany='';
      $incumbentEmpno='';
      foreach ($viewincumbent as $vi){
        $incumbentCompany=$vi->company;
        $incumbentEmpno=$vi->empno;
      }

      // pull all history records for a selected incumbents
      // this will populate the middle column of incumbent history, showing all hist records
      $viewIncumbentHistory = \DB::table('hincumbents')
        ->where('poscompany','=',$company)
        ->where('posno','=',$posno)
        ->where('company','=',$incumbentCompany)
        ->where('empno','=',$incumbentEmpno)
        ->orderby('trans_date','desc')
        ->get();

      // pull the specific history record that we are currently dealing wih
      // IMPORTANT:  need a way to incorporate the CURRENT record into the SHOW blade
        $viewIncumbentDetails = \DB::table('hincumbents')
          ->where('id','=',$viewinchistid)
          ->get();

//var_dump("$viewIncumbentDetails");
      // pull all details for the selected incumbent-history record.
      // this can be used to show details of a "selected incumbent"

      //****************************
      // P O S I T I O N   H I S T O R Y
      $posHistRecs = \DB::table('hpositions')
        ->where('posno','=',$posno)
        ->where('company','=',$company)
        ->orderby('trans_date','desc')
        ->get();

      //****************************
      // REPORTS TO data
      // "reports to" position is directly available in the positions table

      // check to see if reportsdirto was included in the request string.  If so, reset the Reports To Fields
      if (!empty($request->input('reportsdirto'))) {
        //dump('requested a new reports to');
        $reportsdirtoid = $request->input('reportsdirto');

        $reportsdirtocursor = \DB::table('positions')
          ->where('id','=',$reportsdirtoid)
          ->get();

        foreach ($reportsdirtocursor as $rdt){
          $rdtcompany=$rdt->company;
          $rdtposno=$rdt->posno;
          $rdtdescr=$rdt->descr;

        $position->reptocomp=$rdtcompany;
        $position->reptoposno=$rdtposno;
        $position->reptodesc=$rdtdescr;
        $position->save();
        }
      }

      // check to see if reportsdirto was included in the request string.  If so, reset the Reports To Fields
      if (!empty($request->input('reportsindirto'))) {
        //dump('requested a new reports to');
        $reportsindirtoid = $request->input('reportsindirto');

        $reportsindirtocursor = \DB::table('positions')
          ->where('id','=',$reportsindirtoid)
          ->get();

        foreach ($reportsindirtocursor as $rit){
          $ritcompany=$rit->company;
          $ritposno=$rit->posno;
          $ritdescr=$rit->descr;

        $position->reptocom2=$ritcompany;
        $position->reptopos2=$ritposno;
        $position->reptodesc2=$ritdescr;
        $position->save();
        }
      }


      // Direct Reports will reference this position in their positions.reptocomp / reptoposno
      // Dotted lines will have this position number in reptocom2 / reptopos2
      $directReports = \DB::table('positions')
        ->where('reptoposno','=',$posno)
        ->where('reptocomp','=',$company)
        ->orderby("posno")
        ->get();

      $indirectReports = \DB::table('positions')
        ->where('reptopos2','=',$posno)
        ->where('reptocom2','=',$company)
        ->orderby("posno")
        ->get();

      $dirRepCount = count($directReports);
      $indirRepCount = count($indirectReports);

      // get a collection of position names to use as a list to select "reports to" positions
      // will only need this in "editable" queries
      $reportsToSource = \DB::table('positions')
        ->select('id','company','posno','descr')
        ->where('company','=',$company)
        ->orderby("descr")
        ->get();



//dump($dirRepCount);
// dump("$posno");
// dump("$company");
// dump($directReports);
// dump($viewincumbent);
// $user = Auth::user();
// $id = Auth::id();
// dump($id);
// dump($user->currentTeam->name);
// dump($user->currentTeam->id);

//experiment with session variables, 2020-01-01
Session::put('mykey', '12345');
Session::put('expandIncumbents', 'xHere is how you return a session variable into a blade...JLB 200113');
//TestOnclickFunction();

//######################
// IMPORT Data
// execute these lines to import sample data
//######################
// importpositions('');
// importhpositions('');
// importincumbents('');
// importhincumbents('');

      // save all session variables prior to returning to the blade
      Session::put('reportsDirTo', '');
      Session::put('reportsIndirTo', '');
      Session::put('viewincid', $viewincid);
      Session::put('viewinchistid', $viewinchistid);
      Session::put('viewPosHistId', '');

      //****************************
      // R E T U R N   T O   positions.show
      return View('positions.show')
        ->with(compact('position'))
        ->with(compact('viewincumbent'))
        ->with(compact('viewIncumbentHistory'))
        ->with(compact('viewIncumbentDetails'))
        ->with(compact('positionsnavbar'))
        ->with(compact('incumbentsinposition'))
        ->with(compact('directReports'))
        ->with(compact('indirectReports'))
        ->with(compact('posHistRecs'))
        ->with(compact('reportsToSource'))
        ->with('dirRepCount',$dirRepCount)
        ->with('indirRepCount',$indirRepCount)
        ->with('activeincumbentcount',$activeincumbentcount)
        ->with('activeincumbentlist',$activeincumbentlist);

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
