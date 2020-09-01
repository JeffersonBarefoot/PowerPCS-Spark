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
        <div class="col-md-2" style="background-color:#aaa;">

          <h2>Available Reports:</h2>

          <br>

          <!-- ************************** -->
          <!-- ************************** -->
          <!-- Positions -->
          <!-- ************************** -->
          <!-- ************************** -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep01">Positions - Current</a>
                  </div>
                </div>
              </h4>
            </div>
            <div id="collapseRep01" class="panel-collapse collapse">
              <div class="panel-body">
                <table class="table table-condensed">
                  <tr>
                    @foreach($availablereportsPOS as $rep)
                      <tr>

                        <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>

                        <!-- <td>{{$rep->descr}}</td> -->

                      </tr>
                    @endforeach
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <!-- ************************** -->
          <!-- ************************** -->
          <!-- Position History -->
          <!-- ************************** -->
          <!-- ************************** -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep02">Positions - History</a>
                  </div>

                </div>
              </h4>
            </div>
            <div id="collapseRep02" class="panel-collapse collapse">
              <div class="panel-body">
                <table class="table table-condensed">
                  <tr>
                    @foreach($availablereportsPOSH as $rep)
                      <tr>

                        <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>
                        <!-- <td>{{$rep->descr}}</td> -->
                      </tr>
                    @endforeach
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <!-- ************************** -->
          <!-- ************************** -->
          <!-- Incumbents -->
          <!-- ************************** -->
          <!-- ************************** -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep03">Incumbents - Current</a>
                  </div>

                </div>
              </h4>
            </div>
            <div id="collapseRep03" class="panel-collapse collapse">
              <div class="panel-body">
                <table class="table table-condensed">
                  <tr>
                    @foreach($availablereportsINC as $rep)
                      <tr>

                        <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>
                        <!-- <td>{{$rep->descr}}</td> -->
                      </tr>
                    @endforeach
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <!-- ************************** -->
          <!-- ************************** -->
          <!-- Incumbents - History -->
          <!-- ************************** -->
          <!-- ************************** -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep04">Incumbents - History</a>
                  </div>

                </div>
              </h4>
            </div>
            <div id="collapseRep04" class="panel-collapse collapse">
              <div class="panel-body">
                <table class="table table-condensed">
                  <tr>
                    @foreach($availablereportsINCH as $rep)
                      <tr>
                        
                        <td height="25"><a href={{route('reports.show',$rep->id)}}>{{$rep->descr}}</td>
                        <!-- <td>{{$rep->descr}}</td> -->
                      </tr>
                    @endforeach
                  </tr>
                </table>
              </div>
            </div>
          </div>

          <!-- ************************** -->
          <!-- ************************** -->
          <!-- Budgets -->
          <!-- ************************** -->
          <!-- ************************** -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep05">Budgets</a>
                  </div>

                </div>
              </h4>
            </div>
            <div id="collapseRep05" class="panel-collapse collapse">
              <div class="panel-body">Reserved for future functionality

              </div>
            </div>
          </div>

          <!-- ************************** -->
          <!-- ************************** -->
          <!-- Vacancies -->
          <!-- ************************** -->
          <!-- ************************** -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep06">Vacancies</a>
                  </div>

                </div>
              </h4>
            </div>
            <div id="collapseRep06" class="panel-collapse collapse">
              <div class="panel-body">Reserved for future functionality

              </div>
            </div>
          </div>


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
