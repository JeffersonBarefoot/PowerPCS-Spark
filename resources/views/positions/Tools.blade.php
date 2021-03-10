@extends('layout')

@section('bodysection')


<h1>Import Files</h1>
<ul>
<li>Initial Setup - Positions</li>
<li>Initial Setup - Position history</li>
<li>Initial Setup - incumbents</li>
</ul>

<h1>Data Repair</h1>
<ul>
<li>Add position descriptions to "Reports To" assignments</li>
<li>Replace sample data with new sample data (old sample data will be deleted)</li>
<li>Change position numbers</li>
</ul>






<!-- https://blog.quickadminpanel.com/file-upload-in-laravel-the-ultimate-guide/ -->
<!-- <form action={{ route('uploadfile') }} method="POST" enctype="multipart/form-data"> -->
<form method = "POST" action= "/positions/uploadfile" enctype="multipart/form-data">
    {{ csrf_field() }}

    File to Upload:
    <br />
    <input type="file" name="logo" />
    <br /><br />
    <input type="submit" value=" Save " />
</form>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select Excel or PDF file to upload:<br>
    <input type="file" value="Optional Name, don't need this value parameter" name="fileToUpload" id="fileToUpload" style="height: 30px; width: 500px;"><br>
    <input type="submit" value="Upload"  name="submit" style="height: 22px; width: 88px;">
</form>





@endsection
@extends('navbartools')
@section('main')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

@endsection
