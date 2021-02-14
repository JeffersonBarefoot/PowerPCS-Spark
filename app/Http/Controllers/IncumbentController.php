<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\incumbent;
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
  public function show($id)
  {
    // dd("Incumbents.Show");

    if (is_null($id)) {
      $id=1;
    }
    $position = Incumbent::find($id);

    //
    return View('incumbents.show');
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
