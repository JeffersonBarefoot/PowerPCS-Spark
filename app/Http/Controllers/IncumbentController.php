<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\incumbent;
use App\hincumbent;
use Session;
use Auth;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;

class IncumbentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
   //***************************************************
   //***************************************************
   //***************************************************
   //**   I N D E X
   //***************************************************
   //***************************************************
   //***************************************************
  public function index()
  {
      //
      //echo 'hello world';
      $incumbents = Incumbent::all();
      return view('incumbents.index', compact('incumbents'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
   //***************************************************
   //***************************************************
   //***************************************************
   //**  C R E A T E
   //**   This works together with STORE to add a new record
   //***************************************************
   //***************************************************
   //***************************************************
  public function create()
  {
      //
    //  require_once(public_path() ."/phpGrid_Lite/conf.php");
    //  $dg = new C_DataGrid("SELECT * from orders","orderNumber","orders");
    //  $dg -> display();


      return view('incumbents.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
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
      $request->validate([
        'fname'=>'required',
        'lname'=>'required'
      ]);

      $incumbent = new Incumbent([
        'fname' => $request->get('fname'),
        'lname' => $request->get('lname')
      ]);
$incumbent->save();
return redirect('/incumbents')->with('success', 'Incumbent saved!');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
   //***************************************************
   //***************************************************
   //***************************************************
   //**   S H O W
   //***************************************************
   //***************************************************
   //***************************************************
  public function show($empno, Request $request)
  {
    $request->flash();

  // dd($user->currentTeam->id);
    $user = auth()->user();
    $team = $user->currentTeam->id;

    $reqcompany = $request->input('reqcompany');
    $reqempno = $empno;
    $reqpositioncompany = $request->input('reqpositioncompany');
    // $reqpositionposno = $request->input('reqpositionposno');
    $reqpositionposno = $request->input('reqpositionposno');
    $reqincumbenthistoryid = $request->input('reqincumbenthistoryid');
    // if(empty($reqincumbenthistoryid)) {
    //   $reqincumbenthistoryid=1;
    // }

    $selectedposition = DB::table('positions')
      ->where('posno', '=', $reqpositionposno)
      ->where('company', '=', $reqpositioncompany)
      ->pluck('descr');  // "5"
    $badChars=array('[',']','"');
    $selectedposition=str_replace($badChars,'',$selectedposition);
    SessionSet('selectedincumbentposition',$selectedposition);


    // dump($reqcompany.$empno.$team);

    //Determine which incumbent will populate the SHOW screen
    // find record with this company/empno that's in this team
    // if doesn't exist, then find the lowest ID on this team and go there
    $incumbent = Incumbent::where('empno', '=' , $empno)
      ->where('company', '=', $reqcompany)
      ->where('teamid' , '=' , $team)
      ->firstOr(function(){

    $user = auth()->user();
    $team = $user->currentTeam->id;
    $id=DB::table('incumbents')->where('teamid' , '=' , $team)->min('id');
    return $incumbent = Incumbent::find($id);
    });

    //****************************
    // N A V B A R
    // these variables are used to populate the NavBar, not the main portion of Positions.Show
    // $navbarcompany = $request->input('company');
    // $navbarposno = $request->input('posno');
    // $navbardescr = $request->input('descr');
    // $navbarcompany = $request->input('company');
    // $navbarposno = $request->input('posno');
    // $navbardescr = $request->input('descr');
    // the next IFs check to see if a search parameter has been passed via request-inputs from NavBar.
    // if specific parameters have been passed then remember them.
    // if nothing has been passed, do nothing so that the session variables don't change and Navbar remembers the last search when you go back to the position.show.blade
    if (request()->has('company')) {
      if (empty(request()->input('company'))) {
        Session::put('posNavbarCompanyQuery','');
      } else {
        Session::put('posNavbarCompanyQuery',request()->input('company'));
      }
    }

    if (request()->has('lname')) {
      if (empty(request()->input('lname'))) {
        Session::put('posNavbarLnameQuery','');
      } else {
        Session::put('posNavbarLnameQuery',request()->input('lname'));
      }
    }

    if (request()->has('empno')) {
      if (empty(request()->input('empno'))) {
        Session::put('posNavbarEmpnoQuery','');
      } else {
        Session::put('posNavbarEmpnoQuery',request()->input('empno'));
      }
    }

    if (request()->has('level1')) {
      if (empty(request()->input('level1'))) {
        Session::put('posNavbarLevel1Query','');
      } else {
        Session::put('posNavbarLevel1Query',request()->input('level1'));
      }
    }

    if (request()->has('level2')) {
      if (empty(request()->input('level2'))) {
        Session::put('posNavbarLevel2Query','');
      } else {
        Session::put('posNavbarLevel2Query',request()->input('level2'));
      }
    }

    if (request()->has('level3')) {
      if (empty(request()->input('level3'))) {
        Session::put('posNavbarLevel3Query','');
      } else {
        Session::put('posNavbarLevel3Query',request()->input('level3'));
      }
    }

    if (request()->has('level4')) {
      if (empty(request()->input('level4'))) {
        Session::put('posNavbarLevel4Query','');
      } else {
        Session::put('posNavbarLevel4Query',request()->input('level4'));
      }
    }

    if (request()->has('level5')) {
      if (empty(request()->input('level5'))) {
        Session::put('posNavbarLevel5Query','');
      } else {
        Session::put('posNavbarLevel5Query',request()->input('level5'));
      }
    }

    $navbarcompany =  Session::get('posNavbarCompanyQuery');
    $navbarempno =    Session::get('posNavbarEmpnoQuery');
    $navbarlname =    Session::get('posNavbarLnameQuery');
    $navbarlevel1 =   Session::get('posNavbarLevel1Query');
    $navbarlevel2 =   Session::get('posNavbarLevel2Query');
    $navbarlevel3 =   Session::get('posNavbarLevel3Query');
    $navbarlevel4 =   Session::get('posNavbarLevel4Query');
    $navbarlevel5 =   Session::get('posNavbarLevel5Query');

    // determine which incumbents will show up in the navbar
    $incumbentsnavbar = Incumbent::where('company','like',"$navbarcompany%")
      ->where('empno','like',"%$navbarempno%")
      ->where('lname','like',"%$navbarlname%")
      ->where('level1','like',"$navbarlevel1%")
      ->where('level2','like',"$navbarlevel2%")
      ->where('level3','like',"$navbarlevel3%")
      ->where('level4','like',"$navbarlevel4%")
      ->where('level5','like',"$navbarlevel5%")
      ->select('company','empno','fname','lname','active')
      ->distinct()
      ->orderby("company")
      ->orderby("lname")
      ->get();

    //****************************
    // I N C U M B E N T   H I S T O R Y
    // pull all history records for the selected incumbent
    // this will populate the left column of incumbent show
    $viewPositionsOccupied = \DB::table('incumbents')
      ->join('positions','posid','=','positions.id')
      ->where('incumbents.empno','=',$empno)
      ->where('incumbents.company','=',$reqcompany)
      ->orderby('incumbents.trans_date','desc')
      ->select(DB::raw('incumbents.*, positions.*
        , incumbents.id as incumbentid
        , incumbents.company as incumbentcompany
        , incumbents.empno as incumbentempno
        , positions.id as positionid
        , positions.posno as positionposno
        , positions.company as positioncompany'))
      ->get();

      // dd($viewPositionsOccupied);

    // viewHPositionRecords
    $viewIncumbentPositionHistory = \DB::table('hincumbents')
      ->join('positions','posid','=','positions.id')
      ->where('poscompany','=',$reqpositioncompany)
      ->where('hincumbents.posno','=',$reqpositionposno)
      ->where('hincumbents.company','=',$reqcompany)
      ->where('empno','=',$reqempno)
      ->orderby('hincumbents.trans_date','desc')
      ->select(DB::raw('hincumbents.*, positions.*
        , hincumbents.id as incumbentid
        , hincumbents.company as incumbentcompany
        , hincumbents.empno as incumbentempno
        , positions.id as positionid
        , positions.posno as positionposno
        , positions.company as positioncompany'))
      ->get();

    // view HPositionDetails
    // dd($reqincumbenthistoryid);
    if (!empty($reqincumbenthistoryid)){
      $IncHistRec = \DB::table('hincumbents')
        ->where('id','=',$reqincumbenthistoryid)
        ->get();
      } else{
        // $IncHistRec = \DB::table('hincumbents')
        //   ->where('id','=','blanktable')
        //   ->get();
        $IncHistRec = null;
      }
// dump($viewIncumbentPositionHistory);
// dump($reqincumbenthistoryid);
// dd($IncHistRec);
// if(empty($IncHistRec)) {
//   dd('empty');
// } else {
//   dd('not empty');
// }

    return View('incumbents.show')
      ->with(compact('incumbent'))
      ->with(compact('incumbentsnavbar'))
      ->with(compact('viewPositionsOccupied'))
      ->with(compact('viewIncumbentPositionHistory'))
      ->with(compact('IncHistRec'));

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
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
    $incumbent = Incumbent::find($id);
    return view('incumbents.edit', compact('incumbent'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
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
    $request->validate([
          'fname'=>'required',
          'lname'=>'required'
      ]);

      $incumbent = Incumbent::find($id);
      $incumbent->fname = $request->get('fname');
      $incumbent->lname = $request->get('lname');
      $incumbent->save();

      return redirect('/incumbents')->with('success', 'Incumbent updated!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
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
    $incumbent = Incumbent::find($id);
    $incumbent->delete();

    return redirect('/incumbents')->with('success', 'Incumbent deleted!');
  }
}
