<!DOCTYPE html>
<html lang="en">

@extends('home')
@section('navbarsection')
@parent

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel 5.8 & MySQL CRUD Tutorial</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
  <script>$(document).ready(function(){$('[data-toggle="tooltip"]').tooltip();});</script>

  <style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;

  padding: 30px;
  /*height: 300px;  Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
</head>
<body>


    <div class="row">
        <div class="col-md-3" style="background-color:WhiteSmoke">
          <form action={{route('positions.show',$position->id)}} method="get">

          <!-- ************************** -->
          <!-- ************************** -->
          <!-- Query:  Find a position -->
          <!-- ************************** -->
          <!-- ************************** -->
          <div>
            <br>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep01">Search:</a>
                  </div>
                </div>
              </h4>
            </div>
            <div id="collapseRep01" class="panel-collapse collapse">
              <div class="panel-body">



                <table class="table table-condensed">
                  <col>
                  <col>
                  <tr>
                    <td>Company:</td>
                    <td><input type="text" class="form-control" style="font-size:11pt;" name="company"/></td>
                  </tr>

                  <tr>
                    <td>Position Number:</td>
                    <td><input type="text" class="form-control" name="posno"/></td>
                  </tr>

                  <tr>
                    <td>Description:</td>
                    <td><input type="text" class="form-control" name="descr"/></td>
                  </tr>


                </table>

                <!-- <input type="submit" name="submit" value="Submit (blank queries return all records)"> -->
                <button type="submit" class="btn btn-primary btn-sm">Submit (blank queries return all records)</button>
                <br>


              </div>
            </div>
          </div>


          <table class="table table-condensed">
            <col width="3">
            <col width="3">
            <col width="80">
            <col width="80">
            <col width="200">
            @foreach($positionsnavbar as $position)

            <tr>
              <td>
                @if ($position->active=='I')<span class="glyphicon glyphicon-remove" style="color:grey" data-toggle="tooltip" title="Inactive"></span>@endif
              </td>

              <td>
                @if ($position->curstatus=='VACANT')<span class="glyphicon glyphicon-stop" style="color:gainsboro" data-toggle="tooltip" title="Vacant"></span>@endif
                @if ($position->curstatus=='PARTIALLY FILLED')<span class="glyphicon glyphicon-stop" style="color:gold" data-toggle="tooltip" title="Paritally Filled"></span>@endif
                @if ($position->curstatus=='FILLED')<span class="glyphicon glyphicon-stop" style="color:lime" data-toggle="tooltip" title="Filled"></span>@endif
                @if ($position->curstatus=='OVERFILLED')<span class="glyphicon glyphicon-stop" style="color:crimson" data-toggle="tooltip" title="Overfilled"></span>@endif
              </td>

              <td height="25"><a href={{route('positions.show',$position->id)}}>{{$position->company}}</td>
              <td height="25"><a href={{route('positions.show',$position->id)}}>{{$position->posno}}</td>
              <td height="25"><a href={{route('positions.show',$position->id)}}>{{$position->descr}}</td>
            </tr>

            @endforeach
          </table>
        </div>

        <!-- <div class="col-xs-4"> -->
        <div class="col-md-9">
          @yield('main')
        </div>
      </form>





    </div>
  <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
@endsection
</html>
