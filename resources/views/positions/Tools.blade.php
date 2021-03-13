@extends('layout')

@section('bodysection')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css"></script>

  <style>

  </style>

</head>

<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <div class="row">
        <div class="col-md-12">
          <a data-toggle="collapse" href="#collapseImport">Import Incumbent Files</a>
        </div>

      </div>
    </h4>
  </div>
  <div id="collapseImport" class="panel-collapse collapse">
    <div class="panel-body">


      <div>
        <!-- https://blog.quickadminpanel.com/file-upload-in-laravel-the-ultimate-guide/ -->
        <!-- <form action={{ route('uploadfile') }} method="PUT" enctype="multipart/form-data"> -->
        <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}

            File to Upload:
            <br />
            <input type="file" name="importFileName" accept=".csv"/>
            <br /><br />
            <input type="submit" value=" Save " />
        </form>
      </div>
    </div>
  </div>
</div>



<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <div class="row">
        <div class="col-md-12">
          <a data-toggle="collapse" href="#collapseSetup">Initial Setup</a>
        </div>

      </div>
    </h4>
  </div>
  <div id="collapseSetup" class="panel-collapse collapse">
    <div class="panel-body">


      <div>

        <h1>Import Files</h1>
        <ul>
        <li>Initial Setup - Positions</li>
        <?php sessionSet("uploadType","setupPositions") ?>
        <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <br />
            <input type="file" name="importFileName1" accept=".csv"/>
            <br />
            <input type="submit" value=" Save " />
        </form>
        <br /><br />


        <li>Initial Setup - Position history</li>
        <?php sessionSet("uploadType","setupPositionHistory") ?>
        <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <br />
            <input type="file" name="importFileName2" accept=".csv"/>
            <br />
            <input type="submit" value=" Save " />
        </form>
        <br /><br />

        <li>Initial Setup - Incumbents</li>
        <?php sessionSet("uploadType","setupIncumbents") ?>
        <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <br />
            <input type="file" name="importFileName3" accept=".csv"/>
            <br />
            <input type="submit" value=" Save " />
        </form>
        <br /><br />

        <li>Initial Setup - Incumbent history</li>
        <?php sessionSet("uploadType","setupIncumbentHistory") ?>
        <form action="{{ route('uploadfile') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <br />
            <input type="file" name="importFileName4" accept=".csv"/>
            <br />
            <input type="submit" value=" Save " />
        </form>
        <br /><br />

        </ul>
        <!-- https://blog.quickadminpanel.com/file-upload-in-laravel-the-ultimate-guide/ -->
        <!-- <form action={{ route('uploadfile') }} method="PUT" enctype="multipart/form-data"> -->

      </div>
    </div>
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <div class="row">
        <div class="col-md-12">
          <a data-toggle="collapse" href="#collapseUtilities">Utilities</a>
        </div>

      </div>
    </h4>
  </div>
  <div id="collapseUtilities" class="panel-collapse collapse">
    <div class="panel-body">


      <div>
        <h1>Data Repair</h1>
        <ul>
        <li>Add position descriptions to "Reports To" assignments</li>
        <li>Replace sample data with new sample data (old sample data will be deleted)</li>
        <li>Change position numbers</li>
        </ul>
      </div>
    </div>
  </div>
</div>


@endsection
@extends('navbartools')
@section('main')
<style>
  .uper {
    margin-top: 40px;
  }
</style>

@endsection
