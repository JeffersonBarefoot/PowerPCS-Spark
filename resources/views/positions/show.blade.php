@extends('navbar')
@section('main')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<style media="screen">
table {
font-family: arial, sans-serif;
border-collapse: collapse;
width: 100%;
}

td, th {
border: 10px solid #dddddd;
text-align: left;
padding: 2px;
}

tr {
   height: 50px;
}

tr:nth-child(even) {
background-color: #EBF5FB;
}
tr:nth-child(odd) {
background-color: #EBF5FB;
}
</style>

<div class="row">
    <!-- <div class="col-sm-8 offset-sm-0"> -->
    <div class="col-md-auto">
        <h1 class="display-5">&nbsp;&nbsp;&nbsp;{{$position->descr}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small>{{$position->company}} / {{$position->posno}}</small></h1>

        <form action={{route('positions.show',$position->id)}} method="get">

        <!-- <input type="checkbox" name="mycheckbox" value="myvalue" onclick={{route('positions.show',$position->id)}}>TestCheckBox</input><br>
        <input type="checkbox" name="mycheckbox" value="myvalue" onclick=“this.form.submit()”>TestCheckBox</input><br> -->

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br />
        @endif
    </div>
</div>

<!-- set this to readonly to make this a show screen, or something else (blank, notreadonly, etc) to allow editing -->
<?php $readonly='readonly' ?>

<body>
<div class="container">
  <div class="panel-group">


<!-- ************************** -->
<!-- ************************** -->
<!-- Position Summary Data -->
<!-- ************************** -->
<!-- ************************** -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            <table>
              <tr>
                <td width="20%" height="20"><a data-toggle="collapse" href="#collapse1">Dates, Status</a></td>
                <td width="70%" height="20">
                  &nbsp&nbsp&nbsp Currently &nbsp
                  @if ($position->Active=="A")
                    Active,&nbsp
                  @else
                    Inactive,&nbsp
                  @endif
                    {{ ucwords(strtolower($position->curstatus)) }}
                </td>
              </tr>
            </table>
        </h4>
      </div>
      <!-- <div id="collapse1" class="panel-collapse collapse"> =====collapsed -->
      <!-- <div id="collapse1" class="panel-collapse collapse in"> ==open (i.e. not collapsed) -->

      <div id="collapse1" class="panel-collapse collapse">
        <!-- <div class="panel-body">Panel Body #1a -->
        	<table style="width:90%">
            <tr>
              <td colspan="2"><span style="font-weight: bold;">General</span></td>
              <td></td>
              <td colspan="2"></td>
            </tr>

            <tr>


              <td width="24%">Position Status:</td>
              <td width="24%">
                @if ($position->active=="A")
                  <input type=radio id=radio11 name=active value="A" checked=checked/> Active&nbsp;&nbsp;&nbsp;
                  <input type=radio id=radio12 name=active value="I"/> Inactive
                @else
                  <input type=radio id=radio11 name=active value="A"/> Active&nbsp;&nbsp;&nbsp;
                  <input type=radio id=radio12 name=active value="I" checked=checked/> Inactive
                @endif
              </td>
              <td width="4%"></td>
              <td width="24%">Established</td>
              <td width="24%"><input type="text" class="form-control" name="annftehour" value="{{$position->startdate}}" {{$readonly}}></td>
            </tr>

            <tr>

              <td>Allow multiple incumbents:</td>
              <td>
                @if ($position->multincumb==1)
                  <input type=radio id=radio2 name=multincumb value=1 checked=checked/> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type=radio id=radio2 name=multincumb value=0/> No
                @else
                  <input type=radio id=radio2 name=multincumb value=1/> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type=radio id=radio2 name=multincumb value=0 checked=checked /> No
                @endif
              </td>
              <td></td>
              <td>Available</td>
              <td><input type="text" class="form-control" name="annftehour" value="{{$position->avail_date}}" {{$readonly}}></td>
            </tr>

            <tr>

              <td>Position is Funded:</td>
              <td>
                @if ($position->Funded==1)
                  <input type=radio id=radio2 name=Funded value=1 checked=checked/> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type=radio id=radio2 name=Funded value=0/> No
                @else
                  <input type=radio id=radio2 name=Funded value=1/> Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type=radio id=radio2 name=Funded value=0 checked=checked /> No
                @endif
              </td>
              <td></td>
              <td>End Date</td>
              <td><input type="text" class="form-control" name="annftehour" value="{{$position->enddate}}" {{$readonly}}></td>
            </tr>

            <tr>
              <td>.</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

            <tr>
              <td>.</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

            <tr>
              <td colspan="2"><span style="font-weight: bold;">Status Changes</span></td>
              <td></td>
              <td colspan="2"></td>
            </tr>

            <tr>
              <td>Last Became Vacant</td>
              <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_vac}}" {{$readonly}}></td>
              <td></td>
              <td>@if ($position->curstatus=='VACANT') *** Current Status:  Vacant @endif</td>
              <td></td>
            </tr>

            <tr>
              <td>Last Became Partially Filled</td>
              <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_par}}" {{$readonly}}></td>
              <td></td>
              <td>@if ($position->curstatus=='PARTIALLYFILLED') *** Current Status:  Partially Filled @endif</td>
              <td></td>
            </tr>

            <tr>
              <td>Last Became Filled</td>
              <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_fil}}" {{$readonly}}></td>
              <td></td>
              <td>@if (trim($position->curstatus)=='FILLED') *** Current Status:  Filled @endif</td>
              <td></td>
            </tr>

            <tr>
              <td>Last Became Overfilled</td>
              <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_fpl}}"></td>
              <td></td>
              <td>@if ($position->curstatus=='OVERFILLED') *** Current Status:  Overfilled @endif</td>
              <td></td>
            </tr>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            </table>
          <!-- </div> -->
        <!-- <div class="panel-footer">Panel Footer</div> -->
      </div>
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- Budgets and FTEs -->
    <!-- ************************** -->
    <!-- ************************** -->

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <table>
            <tr>
              <td width="50%"><a data-toggle="collapse" href="#collapse2">Budgets and FTEs</a></td>
              <td>{{$position->fulltimeequiv}} FTEs / $ {{$position->budgsal}} </td>
            </tr>
          </table>

        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <!-- <div class="panel-body">Full Time Equivalent Calculation -->
          <table>
              <tr>
                <td colspan="2"><span style="font-weight: bold;">Full Time Equivalent Calculation</span></td>
                <td></td>
                <td colspan="2"><span style="font-weight: bold;">Budgeted Salary Calculation</span></td>
              </tr>
              <tr>
                  <td width="20%">Annual FTE Basis</td>
                  <td width="20%"><input type="text" class="form-control" name="annftehour" value="{{$position->annftehour}}"></td>
                  <td width="5%"></td>
                  <td width="20%"></td>
                  <td width="20%"></td>

              </tr>
              <tr>
                <td width="20%">Pay Frequency</td>
                  <td width="20%"><input type="text" class="form-control" name="annftehour" value="{{$position->ftefreq}}"></td>
                  <td></td>
                  <td>Pay Frequency</td>
                  <td></td>

              </tr>
              <tr>
                <td width="20%">Pay Period Hours</td>
                  <td width="20%"><input type="text" class="form-control" name="annftehour" value="{{$position->ftehours}}"></td>
                  <td></td>
                  <td>Pay Rate</td>
                  <td></td>

              </tr>
              <tr>
                <td width="20%">Calculated FTE</td>
                  <td width="20%"><input type="text" class="form-control" name="annftehour" value="{{$position->fulltimeequiv}}"></td>
                  <td></td>
                  <td>Budgeted Annual Cost</td>
                  <td></td>

              </tr>
            </table>


        <!-- </div> -->
        <!-- <div class="panel-footer">Panel Footer</div> -->
      </div>
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- incumbents -->
    <!-- ************************** -->
    <!-- ************************** -->

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse3" aria-expanded="true">Incumbents</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
          <!-- *************************** -->
          <!-- *************************** -->
          <!-- Left div contains list of all incumbents -->
          <!-- *************************** -->
          <!-- *************************** -->
          <div class="column">
            <table>
              @foreach($incumbentsinposition as $incumbent)
                <tr>
                    <td>{{$incumbent->active_pos}}"></td>
                    <td height="20"><a href={{route('positions.show',$position->id)}}?viewincid={{$incumbent->id}}>{{$incumbent->lname}}"></td>
                    <td>{{$incumbent->posstart}}"></td>

                </tr>
              @endforeach

            </table>
          </div>

          <!-- *************************** -->
          <!-- *************************** -->
          <!-- Right div contains details of selected incumbent -->
          <!-- *************************** -->
          <!-- *************************** -->
          <div class="column">

              @foreach ($viewincumbent as $incumbent)
              <table>
              <tr>
                <td>incumbent that i am viewing</td>
                  <td>{{$incumbent->active_pos}}"></td>
                  <td>{{$incumbent->lname}}"></td>
                  <td>{{$incumbent->posstart}}"></td>
                  <td>{{$incumbent->posstop}}"></td>
              </tr>
            </table>
            @endforeach




          </div>


        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapse7">Reports To</a>
          </h4>
        </div>
        <div id="collapse7" class="panel-collapse collapse">
          <div class="panel-body">Panel Body
            <table>
                <tr>
                    <td>one</td>
                      <td>two</td>
                      <td>three</td>
                  </tr>
                  <tr>
                    <td>one</td>
                      <td>two</td>
                      <td>three</td>
                  </tr>
                  <tr>
                    <td>one</td>
                      <td>two</td>
                      <td>three</td>
                  </tr>
                  <tr>
                    <td>one</td>
                      <td>two</td>
                      <td>three</td>
                  </tr>
              </table>
          </div>
        </div>
      </div>


    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse4">History</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
        <div class="panel-body">Panel Body
          <table>
              <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
                <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
                <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
                <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
            </table>
        </div>
      </div>
    </div>




    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse5">User Defined</a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
        <div class="panel-body">Panel Body
          <table>
              <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
                <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
                <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
                <tr>
                  <td>one</td>
                    <td>two</td>
                    <td>three</td>
                </tr>
            </table>


        </div>
        <div class="panel-footer">Panel Footer</div>
      </div>
    </div>




    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse6">Funding</a>
        </h4>
      </div>
      <div id="collapse6" class="panel-collapse collapse">
        <div class="panel-body">Reserved for future functionality

        </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse8">Succession Planning</a>
        </h4>
      </div>
      <div id="collapse8" class="panel-collapse collapse">
        <div class="panel-body">Reserved for future functionality

        </div>
      </div>
    </div>


  </div>
</div>

</body>

@endsection
