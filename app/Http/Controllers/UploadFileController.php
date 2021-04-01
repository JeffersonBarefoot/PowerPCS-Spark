<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{

  //***************************************************
  //***************************************************
  //***************************************************
  //**   U P L O A D   F I L E
  //***************************************************
  //***************************************************
  //***************************************************
    public function uploadfile(Request $request)
    {

      //***** Position Data being uploaded
      if (request()->has('importFileName1')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupPosi_Team='.$teamId.'_'.getTimestamp().'.csv';
          $newFileName2 = $newFileName;
          $request->importFileName1->storeAs('importFiles',$newFileName);
          // dump($newFileName);
          ImportPositions($newFileName2);
      }

      //***** Position History Data being uploaded
      if (request()->has('importFileName2')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupPosH_Team='.$teamId.'_'.getTimestamp().'.csv';
          $newFileName2 = $newFileName;
          $request->importFileName2->storeAs('importFiles',$newFileName);
          ImportHPositions($newFileName2);
      }

      //***** Incumbent Data being uploaded
      if (request()->has('importFileName3')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupIncu_Team='.$teamId.'_'.getTimestamp().'.csv';
          $newFileName2 = $newFileName;
          $request->importFileName3->storeAs('importFiles',$newFileName);
          ImportIncumbents($newFileName2);
      }

      //***** Incumbent History Data being uploaded
      if (request()->has('importFileName4')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupIncH_Team='.$teamId.'_'.getTimestamp().'.csv';
          $newFileName2 = $newFileName;
          $request->importFileName4->storeAs('importFiles',$newFileName);
          ImportHIncumbents($newFileName2);
      }

      //***** Incumbent Change File being uploaded
      if (request()->has('importFileName5')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupIncH_Team='.$teamId.'_'.getTimestamp().'.csv';
          $newFileName2 = $newFileName;
          $request->importFileName5->storeAs('importFiles',$newFileName);
          ImportIncumbentChanges($newFileName2);
      }

      return view('positions.Tools');
    }
}
