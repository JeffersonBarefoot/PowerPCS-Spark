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
      // file name is passed in $request as importFileName
      // storeAs([folder],[saveAsName]) is specifying then subfolder to save the upload in...so storage\app\importFiles\*.*
      $user = auth()->user();
      $teamId=$user->currentTeam->id;
      $newFileName = 'uploadImportFile_Team='.$teamId.'_'.getTimestamp().'.csv';
      $request->importFileName->storeAs('importFiles',$newFileName);

      return view('positions.Tools');
    }
}
