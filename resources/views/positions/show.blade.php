@extends('navbar')
@section('main')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <style>

  </style>

</head>

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
            <table id="teststyle" >
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
                        <label><input type="radio" name="multincumb" value="1" checked>Yes</label>
                      </td>
                      <td>
                        <label><input type="radio" name="multincumb" value="0">No</label>
                      </td>
                      @else
                      <td>
                        <label><input type="radio" name="multincumb" value="1">Yes</label>
                      </td>
                      <td>
                        <label><input type="radio" name="multincumb" value="0" checked>No</label>
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
                  <th width="45%">Table Header Goes Here</th>
                  <th width="10%"></th>
                  <th width="40%"></th>
                  <th width="4%"></th>
                  <th width="1%"></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
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
            <table id="teststyle">
              <tr>
                <td width="100%" height="20"><a data-toggle="collapse" href="#collapse19999">Incumbents,&nbsp{{$activeincumbentcount}} Active:&nbsp&nbsp{{$activeincumbentlist}}</a></td>
              </tr>
            </table>
        </h4>
      </div>
      <!-- <div id="collapse1" class="panel-collapse collapse"> =====collapsed -->
      <!-- <div id="collapse1" class="panel-collapse collapse in"> ==open (i.e. not collapsed) -->

      <div id="collapse19999" class="panel-collapse collapse">
        <div class="panel-body">
          <!-- *************************** -->
          <!-- Left div contains list of all incumbents -->
          <div class="row">
            <div class="col-md-4">Incumbents that have been in this position
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="30%">Started</th>
                    <th width="10%">Status</th>
                    <th width="10%">FTE</th>
                    <th width="50%">Name</th>
                    <!-- <th width="15%"></th>
                    <th width="30%"></th> -->
                  </tr>
                </thead>

                <tr>
                  @foreach($incumbentsinposition as $incumbent)
                    <tr>
                      <td>{{$incumbent->posstart}}</td>
                      <td>{{$incumbent->active_pos}}</td>
                      <td>{{$incumbent->fulltimeequiv}}</td>
                      <td><a href={{route('positions.show',$position->id)}}?viewincid={{$incumbent->id}}>{{$incumbent->lname.', '.$incumbent->fname}}</td>

                    </tr>
                  @endforeach
                </tr>

              </table>
            </div>

            <!-- *************************** -->
            <!-- Middle div contains list of all history records for the selected incumbent -->
            <div class="col-md-3">Records on file for
              @foreach($viewincumbent as $vi)
                {{$vi->fname.' '.$vi->lname}}
              @endforeach

              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="30%">Started</th>
                    <th width="15%">Status</th>
                    <th width="15%">FTE</th>
                    <th width="40%">Ann Cost</th>
                  </tr>
                </thead>
                  <tr>
                    @foreach($viewincumbent as $viewinc)
                    @foreach($viewIncumbentHistory as $incHistory)
                      <tr>
                        <td><a href={{route('positions.show',$position->id)}}?viewincid={{$viewinc->id}}&viewinchistid={{$incHistory->id}}>{{$incHistory->posstart}}</td>
                        <td>{{$incHistory->active_pos}}</td>
                        <td>{{$incHistory->fulltimeequiv}}</td>
                        <td>{{$incHistory->ann_cost}}</td>
                      </tr>
                    @endforeach
                    @endforeach
                  </tr>


              </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains details of selected incumbent -->
            <div class="col-md-5">Details, Selected History Record
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="30%">History</th>
                    <th width="20%"></th>
                    <th width="0%"></th>
                    <th width="30%"></th>
                    <th width="20%"></th>
                  </tr>
                </thead>
                @foreach($viewIncumbentDetails as $IncDet)
                  <tr>
                    <td>DATES:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>This record effective as of:</td>
                    <td>{{$IncDet->trans_date}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>Pos Start Date</td>
                    <td>{{$IncDet->posstart}}</td>
                    <td></td>
                    <td>Pos End Date</td>
                    <td>{{$IncDet->posstop}}</td>
                  </tr>

                  <tr>
                    <td>Last Hire Date</td>
                    <td>{{$IncDet->lasthire}}</td>
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

                  <tr>
                    <td>ORGANIZATION</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>Org Level 1</td>
                    <td>{{$IncDet->level1}}</td>
                    <td></td>
                    <td>Org Level 4</td>
                    <td>{{$IncDet->level4}}</td>
                  </tr>

                  <tr>
                    <td>Org Level 2</td>
                    <td>{{$IncDet->level2}}</td>
                    <td></td>
                    <td>Org Level 5</td>
                    <td>{{$IncDet->level5}}</td>
                  </tr>

                  <tr>
                    <td>Org Level 3</td>
                    <td>{{$IncDet->level3}}</td>
                    <td></td>
                    <td>Primary Job</td>
                    <td>{{$IncDet->jobtitle}}</td>
                  </tr>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>


                @endforeach
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
          <div class="row">
            <!-- *************************** -->
            <!-- "THIS POSITION REPORTS TO" -->
            <div class="col-md-5"  style="border: 1px solid blue;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%"></th>
                    <th width="50%">This Position Reports Directly To:</th>
                    <th width="25%"></th>
                  </tr>
                </thead>
                  <tr>
                    <td>test</td>
                  </tr>
              </table>
            </div>
            <div class="col-md-1"></div>

          <div class="col-md-5"  style="border: 1px solid blue;">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="100%">This Position Reports Indirectly To:</th>
                </tr>
              </thead>
                <tr>
                  <td>test</td>
                </tr>
            </table>
          </div>
          <div class="col-md-1"></div>
        </div>

          <div class="row">
            <!-- *************************** -->
            <!-- "divider section with lines" -->
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <table class="table table-condensed">
                  <tr>
                    <td></td>
                  </tr>
              </table>
            </div>
            <div class="col-md-4"></div>
          </div>

          <div class="row">
            <!-- *************************** -->
            <!-- "THIS POSITION" -->
            <div class="col-md-5"  style="border: 1px solid blue;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%"></th>
                    <th width="50%">This Position</th>
                    <th width="25%"></th>
                  </tr>
                </thead>
                  <tr>
                    <td>test</td>
                  </tr>
              </table>
            </div>
            <div class="col-md-7"></div>
          </div>

          <div class="row">
            <!-- *************************** -->
            <!-- "divider section with lines" -->
            <div class="col-md-4"></div>
            <div class="col-md-4">
              <table class="table table-condensed">
                  <tr>
                    <td></td>
                  </tr>
              </table>
            </div>
            <div class="col-md-4"></div>
          </div>

          <div class="row">
            <!-- *************************** -->
            <!-- "REPORTS TO THIS POSITION" -->
            <div class="col-md-5"  style="border: 1px solid blue;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="1%"></th>
                    <th width="98%">Direct Reports</th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                  <tr>
                    @foreach($directReports as $dirrep)
                      <tr>
                          <td></td>
                          <td>{{$dirrep->company.'/'.$dirrep->posno.', '.$dirrep->descr}}</td>
                          <td></td>
                      </tr>
                    @endforeach
                  </tr>
              </table>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5"  style="border: 1px solid blue;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%"></th>
                    <th width="50%">Indirect/Dotted Line Reports</th>
                    <th width="25%"></th>
                  </tr>
                </thead>
                  <tr>
                    <td>test</td>
                  </tr>
              </table>
            </div>
            <div class="col-md-1"></div>
          </div>
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
      <div id="collapse4" class="panel-collapse collapse">
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
