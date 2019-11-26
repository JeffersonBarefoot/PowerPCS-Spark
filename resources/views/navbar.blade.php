<!DOCTYPE html>
<html lang="en">

@extends('home')
@section('navbarsection')
@parent

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel 5.8 & MySQL CRUD Tutorial</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />

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
        <div class="col-md-3" style="background-color:#aaa;">


          <h2>Navigation</h2>

          <form action={{route('positions.show',$position->id)}} method="get">

          <table>
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

          <table>
            <tr>
              <td></td>
            </tr>
          </table>


          <!-- <input type="submit" name="submit" value="Submit (blank queries return all records)"> -->
          <br>
          <button type="submit" class="btn btn-primary btn-sm">Submit (blank queries return all records)</button>
          <br>

          <br>
          <table>
            <col width="100">
            <col width="100">
            <col width="200">
            @foreach($positionsnavbar as $position)

            <tr>
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
