@extends('navbar')
@section('main')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<style>

#teststyle {
  height: 550px;
  vertical-align: bottom;
}

</style>

<div class="row">
    <!-- <div class="col-sm-8 offset-sm-0"> -->
    <div class="col-md-12">
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
<?php $readonly='xxreadonly' ?>


<body>
  <div class="col-sm-12">
    <div class="panel-group">


    <!-- ************************** -->
    <!-- ************************** -->
    <!-- Position Summary Data -->
    <!-- ************************** -->
    <!-- ************************** -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            <table id="teststyle">
              <tr>
                <td width="20%" height="20"><a data-toggle="collapse" href="#collapse1">Dates, Status</a></td>
                <td width="70%" height="20">
                  &nbsp&nbsp&nbsp Currently
                  @if ($position->Active=="A")
                    Active,
                  @else
                    Inactive,
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
        <div class="panel-body">
          <!-- *************************** -->
          <!-- Left div contains list of all incumbents -->
          <div class="row">
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="35%">Settings</th>
                    <th width="5%"></th>
                    <th width="15%"></th>
                    <th width="15%"></th>
                    <th width="30%"></th>
                  </tr>
                </thead>

                <tr>
                  <td>Position Status</td>
                  <td></td>
                  <div class="radio">

                      @if ($position->active=="A")
                      <td>
                        <label><input type="radio" name="active" value="A"checked>Active</label>
                      </td>
                      <td>
                        <label><input type="radio" name="active" value="I">Inactive</label>
                      </td>
                      @else
                      <td>
                        <label><input type="radio" name="active" value="A">Active</label>
                      </td>
                      <td>
                        <label><input type="radio" name="active" value="I" checked>Inactive</label>
                      </td>
                      @endif

                  </div>
                </tr>

                <tr>
                  <td>Allow Multiple Incumbents:</td>
                  <td></td>
                  <div class="radio">
                      @if ($position->multincumb==1)
                      <td>
                        <label><input type="radio" name="xmultincumb" value="1" checked>Yes</label>
                      </td>
                      <td>
                        <label><input type="radio" name="xmultincumb" value="0">No</label>
                      </td>
                      @else
                      <td>
                        <label><input type="radio" name="xmultincumb" value="1">Yes</label>
                      </td>
                      <td>
                        <label><input type="radio" name="xmultincumb" value="0" checked>No</label>
                      </td>
                      @endif

                  </div>
                </tr>

                <tr>
                  <td>Position Status</td>
                  <td></td>
                  <div class="radio">

                    @if ($position->multincumb==1)
                    <td>
                      <label><input type="radio" name="Funded" value="1" checked>Yes</label>
                    </td>
                    <td>
                      <label><input type="radio" name="Funded" value="0">No</label>
                    </td>
                    @else
                    <td>
                      <label><input type="radio" name="Funded" value="1">Yes</label>
                    </td>
                    <td>
                      <label><input type="radio" name="Funded" value="0" checked>No</label>
                    </td>
                    @endif
                  </div>
                </tr>
              </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains details of selected incumbent -->
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="45%">Dates</th>
                    <th width="10%"></th>
                    <th width="40%"></th>
                    <th width="4%"></th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                  <tr>
                    <td>Established</td>
                    <td></td>
                    <td><input type="text" class="form-control" name="annftehour" value="{{$position->startdate}}" {{$readonly}}></td>
                  </tr>
                  <tr>
                    <td>Available</td>
                    <td></td>
                    <td><input type="text" class="form-control" name="annftehour" value="{{$position->avail_date}}" {{$readonly}}></td>
                  </tr>
                  <tr>
                    <td>End Date</td>
                    <td></td>
                    <td><input type="text" class="form-control" name="annftehour" value="{{$position->enddate}}" {{$readonly}}></td>
                  </tr>


              </table>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="30%">Status Changes</th>
                  <th width="30%"></th>
                  <th width="38%"></th>
                  <th width="1%"></th>
                  <th width="1%"></th>
                </tr>
              </thead>

              <tr>
                <td>Last Became Vacant</td>
                <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_vac}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='VACANT') *** Current Status:  Vacant   @endif</td>
              </tr>
              <tr>
                <td>Last Became Partially Filled</td>
                <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_par}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='PARTIALLYFILLED') *** Current Status:  Partially Filled   @endif</td>
              </tr>
              <tr>
                <td>Last Became Filled</td>
                <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_fil}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='FILLED') *** Current Status:  Filled  @endif</td>
              </tr>
              <tr>
                <td>Last Became Overfilled</td>
                <td><input type="text" class="form-control" name="annftehour" value="{{$position->last_fpl}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='OVERFILLED') *** Current Status:  Overfilled  @endif</td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="45%"></th>
                  <th width="10%"></th>
                  <th width="40%"></th>
                  <th width="4%"></th>
                  <th width="1%"></th>
                </tr>
              </thead>

              <tr>

              </tr>
              <tr>

              </tr>
              <tr>

              </tr>
              <tr>

              </tr>


            </table>
          </div>
        </div>

            <!-- <tr>
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
            </table> -->
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
              <td>{{round($position->fulltimeequiv,3)}} FTEs / {{FormatMoney($position->budgsal)}} </td>
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
          <a data-toggle="collapse" href="#collapse3" aria-expanded="true">Incumbents,&nbsp{{$activeincumbentcount}} Active:&nbsp&nbsp{{$activeincumbentlist}}</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse show">
        <div class="panel-body">
          <!-- *************************** -->
          <!-- *************************** -->
          <!-- Left div contains list of all incumbents -->
          <!-- *************************** -->
          <!-- *************************** -->
          <div class="row">
            <div class="col-md-4">Incumbents related to this position
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="20%">Status</th>
                    <th width="50%">name</th>
                    <th width="30%">Start Date</th>
                  </tr>

                  <tr>
                    @foreach($incumbentsinposition as $incumbent)
                      <tr>
                        <td>{{$incumbent->active_pos}}</td>
                        <td><a href={{route('positions.show',$position->id)}}?viewincid={{$incumbent->id}}>{{$incumbent->lname.', '.$incumbent->fname}}</td>
                        <td>{{$incumbent->posstart}}</td>
                      </tr>
                    @endforeach
                  </tr>
                </thead>
              </table>
            </div>

            <!-- *************************** -->
            <!-- *************************** -->
            <!-- Right div contains details of selected incumbent -->
            <!-- *************************** -->
            <!-- *************************** -->
            <div class="col-md-8">Details
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="20%">Name</th>
                    <th width="20%">Start Date</th>
                    <th width="20%">End Date</th>
                    <th width="20%">Col 4</th>
                    <th width="20%">Col 5</th>
                  </tr>

                  @foreach($viewincumbent as $viewinc)
                    <tr>
                      <td>{{$viewinc->lname}}</td>
                      <td>{{$viewinc->posstart}}</td>
                      <td>{{$viewinc->posstop}}</td>
                    </tr>
                  @endforeach
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- ************************** -->
    <!-- ************************** -->
    <!-- Reports To -->
    <!-- ************************** -->
    <!-- ************************** -->
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
                <td width="40%">Direct Reports</td>
                <td width="40%">Indirect Reports</td>
              </tr>

              @foreach($directReports as $dirrep)
                <tr>
                    <td>{{$dirrep->company.'/'.$dirrep->posno.', '.$dirrep->descr}}</td>
                </tr>
              @endforeach

            </table>
        </div>
      </div>
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- position history -->
    <!-- ************************** -->
    <!-- ************************** -->

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse4">History</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse in">
        <div class="panel-body">text1
          <!-- <div class="row"><h4>Panel Body</h4></div> -->
          text2
          <div class="row">
            <div class="col-md-6">this is a test
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="20%">Col 1</th>
                    <th width="20%">Col 2</th>
                    <th width="20%">Col 3</th>
                    <th width="20%">Col 4</th>
                    <th width="20%">Col 5</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="col-md-6">this is a test
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="20%">Col 1</th>
                    <th width="20%">Col 2</th>
                    <th width="20%">Col 3</th>
                    <th width="20%">Col 4</th>
                    <th width="20%">Col 5</th>
                  </tr>
                </thead>
              </table>
            </div>
            <!-- <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div>
            <div class="col-md-1">this is a test</div> -->
          </div>
        </div>
      </div>
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- user defined fields -->
    <!-- ************************** -->
    <!-- ************************** -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse5">User Defined</a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
        <div class="panel-body">Reserved for future functionality

        </div>
      </div>
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- funding sources -->
    <!-- ************************** -->
    <!-- ************************** -->
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

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- succession planning -->
    <!-- ************************** -->
    <!-- ************************** -->
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
