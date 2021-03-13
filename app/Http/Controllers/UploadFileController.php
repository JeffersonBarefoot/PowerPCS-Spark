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
          $request->importFileName1->storeAs('importFiles',$newFileName);
      }

      //***** Position History Data being uploaded
      if (request()->has('importFileName2')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupPosH_Team='.$teamId.'_'.getTimestamp().'.csv';
          $request->importFileName2->storeAs('importFiles',$newFileName);
      }

      //***** Incumbent Data being uploaded
      if (request()->has('importFileName3')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupIncu_Team='.$teamId.'_'.getTimestamp().'.csv';
          $request->importFileName3->storeAs('importFiles',$newFileName);
      }

      //***** Incumbent History Data being uploaded
      if (request()->has('importFileName4')) {
          // file name is passed in $request as importFileName
          // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
          $user = auth()->user();
          $teamId=$user->currentTeam->id;
          $newFileName = 'setupIncH_Team='.$teamId.'_'.getTimestamp().'.csv';
          $request->importFileName4->storeAs('importFiles',$newFileName);
      }

      return view('positions.Tools');
    }
}
