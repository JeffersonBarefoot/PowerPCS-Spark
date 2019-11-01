<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use Illuminate\Support\Facades\Schema\columns;
use Illuminate\Support\Facades\DB;


class PositionController extends Controller
{
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
dump('positioncontroller.index');

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

      if (is_null($id)) {
        $id=1;
      }
      $position = Position::find($id);

//dd($id);
      $company = $request->input('company');
      $posno = $request->input('posno');
      $descr = $request->input('descr');
      $viewincid = $request->input('viewincid');
//      dd($request);

      $positionsnavbar = Position::where('company','like',"$company%")
                          ->where('posno','like',"$posno%")
                          ->where('descr','like',"%$descr%")
                          ->orderby("posno")
                          ->get();

      $posno = $position->posno;
      $incumbentsinposition = \DB::table('incumbents')
        ->where('posno','=',$posno)
        ->orderby("posstart","desc")
        ->get();



      $viewincumbent = \DB::table('incumbents')
        ->where('id','=',$viewincid)
        ->get();

      // return View('positions.show')
      //   ->with(compact('position'))
      //   ->with(compact('viewincumbent'))
      //   ->with(compact('positionsnavbar'))
      //   ->with(compact('incumbentsinposition'));

      return View('positions.show')
        ->with(compact('position'))
        ->with(compact('viewincumbent'))
        ->with(compact('positionsnavbar'))
        ->with(compact('incumbentsinposition'));

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
