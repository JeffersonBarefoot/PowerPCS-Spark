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
  {
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

<form action={{route('incumbents.show',$incumbent->id)}} method="get">

Navbarincumbents.blade.php

    <div class="row">
        <div class="col-md-3" style="background-color:WhiteSmoke">


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
                    <a data-toggle="collapse" href="#collapseRep01">Filter list to include:</a>
                  </div>
                </div>
              </h4>
            </div>
            <div id="collapseRep01" class="panel-collapse collapse">
              <div class="panel-body">

                <?php $posNavbarCompanyQuery=Session::get('posNavbarCompanyQuery') ?>
                <?php $posNavbarEmpnoQuery=Session::get('posNavbarEmpnoQuery') ?>
                <?php $posNavbarLnameQuery=Session::get('posNavbarLnameQuery') ?>
                <?php $posNavbarLevel1Query=Session::get('posNavbarLevel1Query') ?>
                <?php $posNavbarLevel2Query=Session::get('posNavbarLevel2Query') ?>
                <?php $posNavbarLevel3Query=Session::get('posNavbarLevel3Query') ?>
                <?php $posNavbarLevel4Query=Session::get('posNavbarLevel4Query') ?>
                <?php $posNavbarLevel5Query=Session::get('posNavbarLevel5Query') ?>

                <?php $posNavbarLevel1Desc=Session::get('level1Desc') ?>
                <?php $posNavbarLevel2Desc=Session::get('level2Desc') ?>
                <?php $posNavbarLevel3Desc=Session::get('level3Desc') ?>
                <?php $posNavbarLevel4Desc=Session::get('level4Desc') ?>
                <?php $posNavbarLevel5Desc=Session::get('level5Desc') ?>

                <table class="table table-condensed">
                  <col>
                  <col>
                  <tr>
                    <td>Companies starting with:</td>
                    <td><input type="text" class="form-control" style="font-size:11pt;" name="company" value={{ $posNavbarCompanyQuery }}></td>
                  </tr>

                  <tr>
                    <td>Employee Numbers starting with:</td>
                    <td><input type="text" class="form-control" name="empno" value={{ $posNavbarEmpnoQuery }}></td>
                  </tr>

                  <tr>
                    <td>Last Names starting with:</td>
                    <td><input type="text" class="form-control" name="lname" value={{ $posNavbarLnameQuery }}></td>
                  </tr>

                  <tr>
                    @if ( $posNavbarLevel1Desc <> "" )
                      <td>{{$posNavbarLevel1Desc}}s starting with:</td>
                      <td><input type="text" class="form-control" style="font-size:11pt;" name="level1" value={{ $posNavbarLevel1Query }}></td>
                    @endif
                  </tr>

                  <tr>
                    @if ( $posNavbarLevel2Desc <> "" )
                      <td>{{$posNavbarLevel2Desc}}s starting with:</td>
                      <td><input type="text" class="form-control" style="font-size:11pt;" name="level2" value={{ $posNavbarLevel2Query }}></td>
                    @endif
                  </tr>


                  <tr>
                    @if ( $posNavbarLevel3Desc <> "" )
                      <td>{{$posNavbarLevel3Desc}}s starting with:</td>
                      <td><input type="text" class="form-control" style="font-size:11pt;" name="level3" value={{ $posNavbarLevel3Query }}></td>
                    @endif
                  </tr>

                  <tr>
                    @if ( $posNavbarLevel4Desc <> "" )
                      <td>{{$posNavbarLevel4Desc}}s starting with:</td>
                      <td><input type="text" class="form-control" style="font-size:11pt;" name="level4" value={{ $posNavbarLevel4Query }}></td>
                    @endif
                  </tr>

                  <tr>
                    @if ( $posNavbarLevel5Desc <> "" )
                      <td>{{$posNavbarLevel5Desc}}s starting with:</td>
                      <td><input type="text" class="form-control" style="font-size:11pt;" name="level5" value={{ $posNavbarLevel5Query }}></td>
                    @endif
                  </tr>




                </table>

                <!-- <input type="submit" name="submit" value="Submit (blank queries return all records)"> -->
                <button type="submit" class="btn btn-primary btn-sm">Submit (blank fields return all positions)</button>
                <!-- <button type="reset" class="btn btn-primary btn-sm">Reset Queries</button> -->
                {{ csrf_field() }}

                </form>
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
            @foreach($incumbentsnavbar as $incumbent)

            <tr>
              <td>
                @if ($incumbent->active=='I')<span class="glyphicon glyphicon-remove" style="color:grey" data-toggle="tooltip" title="Inactive"></span>@endif
              </td>



              <td height="25"><a href={{route('incumbents.show',$incumbent->id)}}>{{$incumbent->company}}</td>
              <td height="25"><a href={{route('incumbents.show',$incumbent->id)}}>{{$incumbent->empno}}</td>
              <td height="25"><a href={{route('incumbents.show',$incumbent->id)}}>{{$incumbent->lname}}</td>
            </tr>

            @endforeach
          </table>
        </div>

        <!-- <div class="col-xs-4"> -->
        <div class="col-md-9">
          @yield('main')
        </div>






    </div>
  <script src="{{ asset('js/app.js') }}" type="text/js"></script>

</body>
@endsection
</html>
