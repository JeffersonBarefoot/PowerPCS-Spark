@extends('navbar')
@section('main')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <style>

  </style>

</head>

<!-- set this to readonly to make this a show screen, or something else (blank, notreadonly, etc) to allow editing -->
<!-- note that for UNCHECKED radio buttons you have to use [disabled] instead of [readonly].  CHECKED radio buttons remain active-->
<?php $readonly=Session::get('readOnlyText') ?>
<?php $disabled=Session::get('disabledText') ?>
<?php $expandPositionHistory=Session::get('ExpandPositionHistory') ?>
<?php $expandIncumbentHistory=Session::get('ExpandIncumbentHistory') ?>


<body>
  {{ Form::model($position, array('route' => array('positions.update', $position->id), 'method' => 'PUT')) }}

  <!-- <button onclick="expandStatus()"  id="p2" aria-expanded="false">Try it</button>
  <p id="demo"></p>

  <input type="hidden" id="testArial" name="testArial" value="3487"> -->

  <!-- ************************** -->
  <!-- ************************** -->
  <!-- ************************** -->
  <script>

  $(function(){
     $('[data-toggle="tooltip"]').tooltip();
    })

    function initExpands() {
      sessionStorage.setItem("initialized","expandStatus");
    }

    function expandStatus() {
    var x = document.getElementById("p2").getAttribute("aria-expanded");
    if (x == " class='panel-collapse collapse' id='collapse1' ")  {
      x = " class='panel-collapse' id='collapse1' ";
    } else {
      x = " class='panel-collapse collapse' id='collapse1' ";
    }


      if (typeof(Storage) !== "undefined") {
        if (sessionStorage.expandStatus) {
          // sessionStorage.expandStatus = Number(sessionStorage.clickcount)+2;
          sessionStorage.expandStatus = x;
        }
        // } else {
        //   sessionStorage.expandStatus = 1;
        // }
        document.getElementById("demo123").innerHTML = x ;
      } else {
        document.getElementById("result").innerHTML = "Sorry, your browser does not support web storage...";
      }
    }

    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[0];
          if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
      }
    }

    // This function runs when the value of one of the Budget fields is changed by the user
    function updateBudgetValues() {

      var nAnnFteHour, cFteFreq, nFteHours, nFullTimeEquiv, cPayFreq, nPayRate, nDummyFullTimeEquiv, nBudgSal, nPayPeriods,nFtePeriods;

      // Gather values that user has input
      // from the left column:
      nAnnFteHour = document.getElementById('annftehour').value;
      cFteFreq = document.getElementById('ftefreq').value;
        cFteFreq = cFteFreq.substring(0,1);
        cFteFreq = cFteFreq.toUpperCase();
      nFteHours = document.getElementById('ftehours').value;
      nFullTimeEquiv = document.getElementById('fulltimeequiv').value;
      // from the right column
      cPayFreq = document.getElementById('payfreq').value;
        cPayFreq = cPayFreq.substring(0,1);
        cPayFreq = cPayFreq.toUpperCase();
      nPayRate = document.getElementById('payrate').value;
          nPayRate = nPayRate.replace('$','');
          nPayRate = nPayRate.replace(',','');
      nDummyFullTimeEquiv = document.getElementById('dummyfulltimeequiv').value;
      nBudgSal = document.getElementById('budgsal').value;

      // validate data
      // FTEFreq fields should only be W, B, S, M or A
      // PayFreq fields should only be H, W, B, S, M or A


      // calc # of pay periods
      switch(cFteFreq) {
        case 'W':
          nFtePeriods = 52;
          break;

        case 'B':
          nFtePeriods = 26;
          break;

        case 'S':
          nFtePeriods = 24;
          break;

        case 'M':
          nFtePeriods = 12;
          break;

        case 'A':
          nFtePeriods = 1;
          break;
      }

      // calc # of pay periods
      switch(cPayFreq) {
        case 'H':
          nPayPeriods = nAnnFteHour;
          break;

        case 'W':
          nPayPeriods = 52;
          break;

        case 'B':
          nPayPeriods = 26;
          break;

        case 'S':
          nPayPeriods = 24;
          break;

        case 'M':
          nPayPeriods = 12;
          break;

        case 'A':
          nPayPeriods = 1;
          break;
      }


      // Calc # of FTEs
      nFullTimeEquiv = (nFteHours * nFtePeriods)/nAnnFteHour

      //Calc Budgeted Salary
      nBudgSal = nPayRate * nPayPeriods * nFullTimeEquiv

      // update all fields
      document.getElementById("fulltimeequiv").setAttribute('value', nFullTimeEquiv );
      document.getElementById("dummyfulltimeequiv").setAttribute('value', nFullTimeEquiv );
      document.getElementById("budgsal").setAttribute('value', nBudgSal );
    }


  </script>
  <!-- ************************** -->
  <!-- ************************** -->
  <!-- ************************** -->
  <div class="row">
      <!-- <div class="col-sm-8 offset-sm-0"> -->
      <div class="col-md-12">
          <h1 class="display-5">
            &nbsp;&nbsp;&nbsp;
            @if ($readonly=='readonly')
              {{$position->descr}}
            @else
              <input type="text" class="form-control" name="descr" value="{{$position->descr}}">
            @endif
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <small>{{$position->company}} / {{$position->posno}}</small></h1>
          <a href={{route('positions.show',$position->id)}}?editmode=switch>{{Session::get('editModeButtonText')}} test</a><br>
          <a href={{route('positions.create')}}>Add New Position </a><br>
          <a href={{ route('verifydestroy') }}?positiontodelete={{$position->id}}>Delete This Position </a><br>
          <button type="Save Changes" class="btn btn-primary">Update</button>
          <br><br>

      </div>
  </div>



<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->
<!-- ************************** -->



<!-- sessionStorage.getItem("expandStatus")
<p id="demo123"></p> -->


  <div class="col-sm-12">
    <!-- <div class="panel-group"> -->


    <!-- ************************** -->
    <!-- ************************** -->
    <!-- Position Status -->
    <!-- ************************** -->
    <!-- ************************** -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <div class="row">
            <div class="col-md-2">
              <a href="#collapse1" data-toggle="collapse" >Status</a>
              <!-- <a class="btn btn-primary" onclick="expandStatus()" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1"> -->
                <!-- Status
              </a> -->
            </div>
            <div class="col-md-10">
              Currently
              @if ($position->active=="A")
                Active,
              @else
                Inactive,
              @endif
                {{ ucwords(strtolower($position->curstatus)) }}
            </div>
          </div>
        </h4>
      </div>

      <!-- To Collapse:   <div class="panel-collapse collapse" id="collapse1" >
      To keep open:  <div class="panel-collapse" id="collapse1" >   -->
      <!-- <div class='panel-collapse collapse' id='collapse1' > -->
      <div id="collapse1" div class="panel-collapse collapse" >
        <div class="panel-body">
          <!-- *************************** -->
          <!-- Left div contains xxxxxxxxxxxxxxxxxxxxxx -->
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
                  <td>Active Status</td>
                  <td></td>
                  <div class="radio">

                      @if ($position->active=="A")
                        <td>
                          <label><input type="radio" name="active" value="A"checked>Active</label>
                        </td>
                        <td>
                          <label><input type="radio" name="active" value="I" {{$disabled}}>Inactive</label>
                        </td>
                      @else
                        <td>
                          <label><input type="radio" name="active" value="A" {{$disabled}}>Active</label>
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
                        <label><input type="radio" name="multincumb" value="0" {{$disabled}}>No</label>
                      </td>
                      @else
                      <td>
                        <label><input type="radio" name="multincumb" value="1" {{$disabled}}>Yes</label>
                      </td>
                      <td>
                        <label><input type="radio" name="multincumb" value="0" checked>No</label>
                      </td>
                      @endif

                  </div>
                </tr>

                <tr>
                  <td>Position Funded</td>
                  <td></td>
                  <div class="radio">

                    @if ($position->funded=="Y")
                    <td>
                      <label><input type="radio" name="funded" value="Y" checked >Yes</label>
                    </td>
                    <td>
                      <label><input type="radio" name="funded" value="N" {{$disabled}}>No</label>
                    </td>
                    @else
                    <td>
                      <label><input type="radio" name="funded" value="Y" {{$disabled}}>Yes</label>
                    </td>
                    <td>
                      <label><input type="radio" name="funded" value="N" checked>No</label>
                    </td>
                    @endif
                  </div>
                </tr>
              </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains xxxxxxxxxxxxxxxxxxxxxx -->
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="45%">Reference Dates</th>
                    <th width="10%"></th>
                    <th width="40%"></th>
                    <th width="4%"></th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                  <tr>
                    <td>Established</td>
                    <td></td>
                    <td><input type="date" class="form-control" name="startdate" value="{{$position->startdate}}" {{$readonly}}></td>
                  </tr>
                  <tr>
                    <td>Available</td>
                    <td></td>
                    <td><input type="date" class="form-control" name="avail_date" value="{{$position->avail_date}}" {{$readonly}}></td>
                  </tr>
                  <tr>
                    <td>End Date</td>
                    <td></td>
                    <td><input type="date" class="form-control" name="enddate" value="{{$position->enddate}}" {{$readonly}}></td>
                  </tr>


              </table>
            </div>
          </div>


        <div class="row">
          <div class="col-md-6">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="30%">Capacity Status</th>
                  <th width="30%"></th>
                  <th width="38%"></th>
                  <th width="1%"></th>
                  <th width="1%"></th>
                </tr>
              </thead>

              <tr>
                <td>Last Became Vacant</td>
                <td><input type="date" class="form-control" name="last_vac" value="{{$position->last_vac}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='VACANT') *** Current Status:  Vacant   @endif</td>
              </tr>
              <tr>
                <td>Last Became Partially Filled</td>
                <td><input type="date" class="form-control" name="last_par" value="{{$position->last_par}}" {{$readonly}}></td>
                <!-- <td><input type="text" class="form-control" name="last_par" value="{{$position->last_par}}" {{$readonly}}></td> -->
                <td>@if ($position->curstatus=='PARTIALLYFILLED') *** Current Status:  Partially Filled   @endif</td>
              </tr>
              <tr>
                <td>Last Became Filled</td>
                <td><input type="date" class="form-control" name="last_fil" value="{{$position->last_fil}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='FILLED') *** Current Status:  Filled  @endif</td>
              </tr>
              <tr>
                <td>Last Became Overfilled</td>
                <td><input type="date" class="form-control" name="last_ove" value="{{$position->last_ove}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='OVERFILLED') *** Current Status:  Overfilled  @endif</td>
              </tr>
            </table>
          </div>

          <div class="col-md-6">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="45%">Vacancy Statistics</th>
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
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- Budgets and FTEs -->
    <!-- ************************** -->
    <!-- ************************** -->
    <div class="panel panel-default">

      <div class="panel-heading">
        <h4 class="panel-title">
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse2">Budgets</a>
            </div>
            <div class="col-md-10">
              {{round($position->fulltimeequiv,3)}} FTEs / {{FormatMoney($position->budgsal)}}
            </div>
          </div>
        </h4>
      </div>

      <div id="collapse2" class="panel-collapse collapse">
        <!-- <div class="panel-body">Full Time Equivalent Calculation -->
        <div class="panel-body">
          <!-- *************************** -->
          <!-- Left div contains xxxxxxxxxxxxxxxxxxxxxx -->
          <div class="row">
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="30%">Full Time Equivalents</th>
                    <th width="30%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                    <th width="40%"></th>
                  </tr>
                </thead>

                <tr>
                  <td>Annual FTE Basis</td>
                  <td><input type="text" class="form-control" name="annftehour" id="annftehour" value="{{$position->annftehour}}" onChange="updateBudgetValues()" {{$readonly}}></td>
                  <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip" data-placement="top"
                    title="The number of hours per year that would be considered one FTE.  The most common value for this field is 2080, which is 40 hours per week x 52 weeks per year.  For most organizations, every position will have '2080' here."
                  ></span></td>

                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="30%">Costs</th>
                    <th width="30%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                    <th width="40%"></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <table class="table table-condensed">
                <tr>
                  <td width="30%">FTE Calculation Frequency</td>
                  <td width="30%"><input type="text" class="form-control" name="ftefreq" id="ftefreq" value="{{$position->ftefreq}}" onChange="updateBudgetValues()" {{$readonly}}></td>
                  <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip" data-placement="top"
                    title="The frequency that, when combined with the FTE Hours field, calculates the number of hours that this position is expected to work.  Example:  40 hours per week (full time), or 20 hours a month (part time).
                      Options are W(eekly), B(iweekly - every other week), S(emi-Monthly, twice a month), M(onthly), or A(nnually)."
                  ></span></td>

                </tr>

                <tr>
                  <td>FTE Hours</td>
                  <td><input type="text" class="form-control" id="ftehours" name="ftehours" value="{{round($position->ftehours,3)}}" onChange="updateBudgetValues()" {{$readonly}}></td>
                  <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip" data-placement="top"
                    title="The dollar amount that, when combined with the FTE Calculation Frequency field, calculates the number of hours that this position is expected to work.  Example:  40 hours per week (full time), or 20 hours a month (part time)."
                  ></span></td>
                </tr>

                <tr>
                  <td>FTEs for this position</td>
                  <td><input type="text" class="form-control" id="fulltimeequiv" name="fulltimeequiv" value="{{round($position->fulltimeequiv,3)}}" readonly></td>
                  <td></td>
                  <td><img src="/images/ArrowRight.jpg" width="50" height="15"></td>

                </tr>
              </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains xxxxxxxxxxxxxxxxxxxxxx -->
            <div class="col-md-6">
              <table class="table table-condensed">
                  <tr>
                    <td width="30%">Pay Frequency</td>
                    <td width="30%"><input type="text" class="form-control" id="payfreq" name="payfreq" value="{{$position->payfreq}}" onChange="updateBudgetValues()"  {{$readonly}}></td>
                    <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip" data-placement="top"
                      title="The frequency that, when combined with the budgeted pay rate, calculates the annual cost of ONE FULL TIME incumbent in this position.  Example:  $19.00 per hour, or $58,000 annually.
                        Options are H(ourly), W(eekly), B(iweekly - every other week), S(emi-Monthly, twice a month), M(onthly), or A(nnually)."
                    ></span></td>
                    <td width="10%"></td>
                    <td width="40%"></td>
                  </tr>
                  <!-- <tr>
                    <td>Pay Frequency</td>
                    <td></td>
                    <td></td>
                  </tr> -->
                  <tr>
                    <td>x Budgeted Pay Rate</td>
                    <td><input type="text" class="form-control" id="payrate" name="payrate" value="{{FormatDollars($position->payrate)}}" onChange="updateBudgetValues()"  {{$readonly}}></td>
                    <td><span class="glyphicon glyphicon-question-sign fa-20x" data-toggle="tooltip" data-placement="top"
                      title="The dollar amount that, when combined with the Pay Frequency field, calculates the cost of ONE FULL TIME incumbent in this position.  Example:  Example:  $19.00 per hour, or $58,000 annually."
                    ></span></td>
                  </tr>

                  <tr>
                    <td>x Budgeted FTEs</td>
                    <td><input type="text" class="form-control" id="dummyfulltimeequiv" name="dummyfulltimeequiv" value="{{round($position->fulltimeequiv,3)}}" readonly></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>= Budgeted Annual Cost</td>
                    <td><input type="text" class="form-control" id="budgsal" name="budgsal" value="{{FormatDollars($position->budgsal)}}" readonly></td>
                    <td></td>
                  </tr>


              </table>
            </div>
          </div>
          </div>





          <!-- <table>
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
            </table> -->


        <!-- </div> -->
        <!-- <div class="panel-footer">Panel Footer</div> -->
      </div>
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- Org Levels -->
    <!-- ************************** -->
    <!-- ************************** -->
    <div class="panel panel-default">

      <div class="panel-heading">
        <h4 class="panel-title">
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapseOrgLevels">Organization</a>
            </div>

            <div class="col-md-10">
              @if ($position->level1 != '') {{$position->level1}} @endif
              @if ($position->level2 != '') / {{$position->level2}} @endif
              @if ($position->level3 != '') / {{$position->level3}} @endif
              @if ($position->level4 != '') / {{$position->level4}} @endif
              @if ($position->level5 != '') / {{$position->level5}} @endif
          </div>
        </h4>
      </div>

      <div id="collapseOrgLevels" class="panel-collapse collapse">
        <!-- <div class="panel-body">Full Time Equivalent Calculation -->
        <div class="panel-body">

          <?php $level1Description = sessionGet('level1Desc') ?>
          <?php $level2Description = sessionGet('level2Desc') ?>
          <?php $level3Description = sessionGet('level3Desc') ?>
          <?php $level4Description = sessionGet('level4Desc') ?>
          <?php $level5Description = sessionGet('level5Desc') ?>

          <div class="row">
            <div class="col-md-6">
              <table class="table table-condensed">
                <tr>
                  <td>{{$level1Description}}</td>
                  <td><input type="text" class="form-control" name="Level1" value="{{$position->level1}}" {{$readonly}}></td>
                  <td width="10%">
                  <td width="10%">
                  <td width="10%">
                </tr>

                <tr>
                  <td>{{$level2Description}}</td>
                  <td><input type="text" class="form-control" name="Level2" value="{{$position->level2}}" {{$readonly}}></td>
                </tr>

                <tr>
                  <td>{{$level3Description}}</td>
                  <td><input type="text" class="form-control" name="Level3" value="{{$position->level3}}" {{$readonly}}></td>
                </tr>

                <tr>
                  <td>{{$level4Description}}</td>
                  <td><input type="text" class="form-control" name="Level4" value="{{$position->level4}}" {{$readonly}}></td>
                </tr>

                <tr>
                  <td>{{$level5Description}}</td>
                  <td><input type="text" class="form-control" name="Level5" value="{{$position->level5}}" {{$readonly}}></td>
                </tr>
              </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains xxxxxxxxxxxxxxxxxxxxxx -->
            <div class="col-md-6">
              <table class="table table-condensed">
                  <tr>
                    <td width="35%"></td>
                    <td width="35%"></td>
                    <td width="10%"></td>
                    <td width="10%"></td>
                    <td width="10%"></td>
                  </tr>
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
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse7">Reports to</a>
            </div>
            <div class="col-md-5">
              @if ($position->reptoposno=="")
                Not Assigned
              @else
                Directly:  {{$position->reptocomp}} / {{$position->reptoposno}}, {{$position->reptodesc}}
              @endif
            </div>
            <div class="col-md-5">
              @if ($position->reptopos2=="")
                <!-- if not assigned, then just leave the heading blank -->
              @else
                Indirectly:  {{$position->reptocom2}} / {{$position->reptopos2}}, {{$position->reptodesc2}}
              @endif
            </div>
          </div>
        </h4>
      </div>

      <div id="collapse7" class="panel-collapse collapse">
        <div class="panel-body">
          <div class="row">
            <!-- *************************** -->
            <!-- "THIS POSITION REPORTS TO" -->
            <div class="col-md-5"  style="border: 1px solid grey;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="1%"></th>
                    <th width="68%">Reports Directly To:</th>
                    <th width="30%">


                    @if ($readonly == "")
                      <!-- Modal -->
                      <!-- Trigger the modal with a button -->
                      <button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#directReportingModal">Assign</button>
                      <!-- This is the modal istself -->
                      <div class="modal fade" id="directReportingModal" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                              <h2>Directly Reports To:</h2>
                              <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Descr or #" title="Type in a name">
                              <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                <table id="myTable">
                                  <tr class="header">
                                    <th style="width:60%;">Position Company // Number // Description</th>
                                  </tr>


                                  @foreach($reportsToSource as $RTS)
                                    <!-- <tr><td>{{$RTS->posno}}  /  {{$RTS->descr}}</td></tr> -->
                                    <tr>
                                      <td><a href={{route('positions.show',$position->id)}}?reportsdirto={{$RTS->id}}> {{$RTS->company}}  //  {{$RTS->posno}}  //  {{$RTS->descr}}</td>
                                    </tr>
                                  @endforeach
                                </table>
                              </div>
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    @endif


            </div>

                    </th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                  <tr>
                    <td></td>
                    <td>
                      @if ($position->reptoposno=="")
                        Not Assigned
                      @else
                        {{$position->reptocomp}} / {{$position->reptoposno}}, {{$position->reptodesc}}
                      @endif
                    </td>
                    <td></td>
                  </tr>
              </table>
            </div>
            <div class="col-md-1"></div>

          <div class="col-md-5"  style="border: 1px solid grey;">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="1%"></th>
                  <th width="68%">Reports Indirectly To:</th>
                  <th width="30%">


                    @if ($readonly == "")
                    <!-- Modal -->
                    <!-- Trigger the modal with a button -->
                    <button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#directReportingModal2">Assign</button>
                    <!-- This is the modal istself -->
                    <div class="modal fade" id="directReportingModal2" role="dialog">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                          </div>
                          <div class="modal-body">
                            <h2>Indirectly Reports to:</h2>
                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Descr or #" title="Type in a name">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                              <table id="myTable">
                                <tr class="header">
                                  <th style="width:60%;">Name</th>
                                  <th style="width:40%;">Country</th>
                                </tr>


                                @foreach($reportsToSource as $RTS)
                                  <!-- <tr><td>{{$RTS->posno}}  /  {{$RTS->descr}}</td></tr> -->
                                  <tr>
                                    <td><a href={{route('positions.show',$position->id)}}?reportsindirto={{$RTS->id}}> {{$RTS->company}}  //  {{$RTS->posno}}  //  {{$RTS->descr}}</td>
                                  </tr>
                                @endforeach
                              </table>
                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                    @endif


                    </div>

                  </th>
                  <th width="1%"></th>
                </tr>
              </thead>
                <tr>
                  <td></td>
                  <td>
                    @if ($position->reptopos2=="")
                      Not Assigned
                    @else
                      {{$position->reptocom2}} / {{$position->reptopos2}}, {{$position->reptodesc2}}
                    @endif
                  </td>



                  <td></td>
                </tr>
            </table>
          </div>
          <div class="col-md-1"></div>
        </div>


            <!-- *************************** -->
            <!-- "divider section with lines" -->
          <div class="row">
            <div class="col-md-5"  align="center">
              <img src="/images/ArrowUp.jpg" width="15" height="50">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5"></div>
            <div class="col-md-1"></div>
          </div>

          <div class="row">
            <!-- *************************** -->
            <!-- "THIS POSITION" -->
            <div class="col-md-5"  style="border: 1px solid grey;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="1%"></th>
                    <th width="98%">This Position</th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                  <tr>
                    <td></td>
                    <td>{{$position->company}} / {{$position->posno}}, {{$position->descr}}</td>
                    <td></td>
                  </tr>
              </table>
            </div>
            <div class="col-md-7" align="left">
              <img src="/images/ArrowDottedUpUp.jpg" width="50" height="120">
            </div>
          </div>


            <!-- *************************** -->
            <!-- "divider section with lines" -->
            <div class="row">
              <div class="col-md-5"  align="center">
                <img src="/images/ArrowUp.jpg" width="15" height="50">
              </div>
              <div class="col-md-1"></div>
              <div class="col-md-5"></div>
              <div class="col-md-1"></div>
            </div>

          <div class="row">
            <!-- *************************** -->
            <!-- "REPORTS TO THIS POSITION" -->
            <div class="col-md-5"  style="border: 1px solid grey;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="1%"></th>
                    <th width="98%">Direct Reports</th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                    @if ($dirRepCount >= 1)
                      @foreach($directReports as $dirrep)
                        <tr>
                            <td></td>
                            <td>{{$dirrep->company.'/'.$dirrep->posno.', '.$dirrep->descr}}</td>
                            <td></td>
                        </tr>
                      @endforeach

                    @else
                      <tr>
                        <td></td>
                        <td>No direct reports</td>
                        <td></td>
                      </tr>
                    @endif

              </table>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5"  style="border: 1px solid grey;">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="1%"></th>
                    <th width="98%">Indirect Reports</th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                @if ($indirRepCount >= 1)
                  @foreach($indirectReports as $indirrep)
                    <tr>
                        <td></td>
                        <td>{{$indirrep->company.'/'.$indirrep->posno.', '.$indirrep->descr}}</td>
                        <td></td>
                    </tr>
                  @endforeach

                @else
                  <tr>
                    <td></td>
                    <td>No indirect reports</td>
                    <td></td>
                  </tr>
                @endif

                  <!-- <tr>
                    @foreach($indirectReports as $indirrep)
                      <tr>
                          <td></td>
                          <td>{{$indirrep->company.'/'.$indirrep->posno.', '.$indirrep->descr}}</td>
                          <td></td>
                      </tr>
                    @endforeach
                  </tr> -->
              </table>
            </div>
            <div class="col-md-1"></div>
          </div>
        </div>
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
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse19999">Incumbents</a>
            </div>
            <div class="col-md-10">
              {{$activeincumbentcount}} Active:&nbsp&nbsp{{$activeincumbentlist}}
            </div>
          </div>
        </h4>
      </div>

      @if ($expandIncumbentHistory=='Y')
        <div id="collapse19999" class="panel-collapse">
      @else
        <div id="collapse19999" class="panel-collapse collapse">
      @endif
        <div class="panel-body">
          <!-- *************************** -->
          <!-- Left div contains list of all incumbents -->
          <div class="row">
            <div class="col-md-3">Incumbents that have been in this position
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="40%">Started</th>
                    <th width="10%">Status</th>
                    <th width="10%">FTE</th>
                    <th width="40%">Name</th>
                    <!-- <th width="15%"></th>
                    <th width="30%"></th> -->
                  </tr>
                </thead>

                <tr>
                  @foreach($incumbentsinposition as $incumbent)
                    <tr>
                      <td>{{$incumbent->posstart}}</td>
                      <td>{{$incumbent->active_pos}}</td>
                      <td>{{round($incumbent->fulltimeequiv,3)}}</td>
                      <td><a href={{route('positions.show',$position->id)}}?viewincid={{$incumbent->id}}>{{substr($incumbent->fname,0,1).' '.$incumbent->lname}}</td>

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
                    <th width="40%">Record Created</th>
                    <th width="10%">Status</th>
                    <th width="10%">FTE</th>
                    <th width="40%">Ann Cost</th>
                  </tr>
                </thead>
                  <tr>
                    @foreach($viewincumbent as $VI)
                      <td><a href={{route('positions.show',$position->id)}}?viewinchistid={{'CURRENT'.$VI->id}}>Cur Status</td>
                      <td>{{$VI->active_pos}}</td>
                      <td>{{round($VI->fulltimeequiv,3)}}</td>
                      <td>{{FormatDollars($VI->ann_cost)}}</td>
                    @endforeach
                  </tr>
                  <tr>
                    @foreach($viewincumbent as $viewinc)
                      @foreach($viewIncumbentHistory as $incHistory)
                        <tr>
                          <!-- <td><a href={{route('positions.show',$position->id)}}?viewincid={{$viewinc->id}}&viewinchistid={{$incHistory->id}}>{{$incHistory->posstart}}</td> -->
                          <td><a href={{route('positions.show',$position->id)}}?viewinchistid={{$incHistory->id}}>{{$incHistory->trans_date}}</td>
                          <td>{{$incHistory->active_pos}}</td>
                          <td>{{round($incHistory->fulltimeequiv,3)}}</td>
                          <td>{{FormatDollars($incHistory->ann_cost)}}</td>
                        </tr>
                      @endforeach
                    @endforeach
                  </tr>


              </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains details of selected incumbent -->
            <div class="col-md-6">Details:
              @foreach($viewIncumbentDetails as $vd)
                {{$vd->fname.' '.$vd->lname.' @ '.$vd->trans_date.', annual cost '.FormatDollars($vd->ann_cost)}}
              @endforeach
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Status</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>
                @foreach($viewIncumbentDetails as $IncDet)

                  <tr>
                    <td>Status in Pos:</td>
                    <td>{{$IncDet->active_pos}}</td>
                    <td></td>
                    <td>Employment Status:</td>
                    <td>{{$IncDet->active}}</td>
                  </tr>

                  <tr>
                    <td>Started in Pos:</td>
                    <td style="text-align:left">{{$IncDet->posstart}}</td>
                    <td></td>
                    <td>Ended in Pos:</td>
                    <td>{{$IncDet->posstop}}</td>
                  </tr>

                  <tr>
                    <td>Last Hire Date:</td>
                    <td>{{$IncDet->lasthire}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
              </table>

              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Budget</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>

                  <tr>
                    <td>Hourly Rate</td>
                    <td>{{FormatMoney($IncDet->unitrate)}}</td>
                    <td></td>
                    <td>Annualized Rate</td>
                    <td>{{FormatDollars($IncDet->annual)}}</td>
                  </tr>

                  <tr>
                    <td>Pay Frequency</td>
                    <td>{{$IncDet->payfreq}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>FTEs in this Pos:</td>
                    <td>{{round($IncDet->fulltimeequiv,3)}}</td>
                    <td></td>
                    <td>Annual Cost</td>
                    <td>{{FormatDollars($IncDet->ann_cost)}}</td>
                  </tr>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </table>

              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Organization</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>

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
                </table>

                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th width="25%">Data Updates</th>
                      <th width="25%"></th>
                      <th width="0%"></th>
                      <th width="25%"></th>
                      <th width="25%"></th>
                    </tr>
                  </thead>

                    <tr>
                      <td>Update Effective:</td>
                      <td>{{$IncDet->hrmsdate}}</td>
                      <td></td>
                      <td>Update Reason</td>
                      <td>{{$IncDet->hrmsreas}}</td>
                    </tr>

                    <tr>
                      <td>Update Actual Date</td>
                      <td>{{$IncDet->trans_date}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                  </table>


                @endforeach
              </table>
            </div>
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
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse4">History</a>
            </div>
            <div class="col-md-10">
              {{$positionhistorycount}} history records on file
            </div>
          </div>
        </h4>
      </div>

      @if ($expandPositionHistory=='Y')
        <div id="collapse4" class="panel-collapse">
      @else
        <div id="collapse4" class="panel-collapse collapse">
      @endif
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6">

              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Most recent changes</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>
              </table>
              @if(is_null($position->historyreason))
                No changes on file
              @else
                  {!! nl2br($position->historyreason) !!}
              @endif
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="15%">From</th>
                    <th width="8%">Active</th>
                    <th width="8%">Filled?</th>
                    <th width="8%">Budg FTEs</th>
                    <th width="19%">Budg Sal</th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                @foreach($posHistRecs as $posHistRecs)
                  <tr>
                      <!-- <td>{{$posHistRecs->trans_date}}</td> -->
                      @if (is_null($posHistRecs->historystart))
                        <td><a href={{route('positions.show',$position->id)}}?viewposhistid={{$posHistRecs->id}}>
                          {{'Unknown to '.date_format(date_create($posHistRecs->historyend),"m/d/y")}}
                        </td>
                      @else
                        <td><a href={{route('positions.show',$position->id)}}?viewposhistid={{$posHistRecs->id}}>
                          {{date_format(date_create($posHistRecs->historystart),"m/d/y").' to '.date_format(date_create($posHistRecs->historyend),"m/d/y")}}
                        </td>
                      @endif
                      <td>{{$posHistRecs->active}}</td>
                      <td>
                          @switch($posHistRecs->curstatus)
                            @case ('VACANT') Vacant
                            @break
                            @case ('PARTIALLY FILLED') Partially Filled
                            @break
                            @case ('FILLED') Filled
                            @break
                            @case ('OVERFILLED') Overfilled
                            @break
                          @endswitch
                      </td>
                      <td>{{round($posHistRecs->fulltimeequiv,3)}}</td>
                      <td>{{formatdollars($posHistRecs->budgsal)}}</td>
                  </tr>
                @endforeach
              </table>
            </div>

            <!-- *************************** -->
            <!-- Right div contains details of selected position history record -->
            <div class="col-md-6">
              @foreach($viewPositionHistoryDetails as $vphd)
                {{$vphd->company.'/'.$vphd->posno.' '.$vphd->descr}}
                &nbsp;&#11044;&nbsp;
                {{date_format(date_create($vphd->historystart),"m/d/y").' to '.date_format(date_create($vphd->historyend),"m/d/y")}}
                &nbsp;&#11044;&nbsp;
                {{'Annual cost '.FormatDollars($vphd->budgsal)}}

              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Status</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>


                <tr>
                  <td><b>Settings</b></td>
                  <td></td>
                  <td></td>
                  <td><b>Reference Dates</b></td>
                  <td></td>
                </tr>

                <tr>
                  <td>Active Status:</td>
                  <td>{{$vphd->active}}</td>
                  <td></td>
                  <td>Established:</td>
                  <td>{{$vphd->startdate}}</td>
                </tr>

                <tr>
                  <td>Allow Mult Incumbs:</td>
                  @if ($vphd->multincumb=="1")
                    <td>Y</td>
                  @else
                    <td>N</td>
                  @endif
                  <td></td>
                  <td>Available:</td>
                  <td>{{$vphd->avail_date}}</td>
                </tr>

                <tr>
                  <td>Position Funded:</td>
                  <td>{{$vphd->funded}}</td>
                  <td></td>
                  <td>End Date:</td>
                  <td>{{$vphd->enddate}}</td>
                </tr>

                <tr>
                  <td><b>Status Changes</b></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>Last Vacant:</td>
                  <td>{{$vphd->last_vac}}</td>
                  <td style="white-space: nowrap;">@if ($vphd->curstatus=='VACANT') *** Status:  Vacant  @endif</td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>Last Partially Filled:</td>
                  <td>{{$vphd->last_par}}</td>
                  <td style="white-space: nowrap;">@if ($vphd->curstatus=='PARTIALLY FILLED') *** Status:  Partially Filled  @endif</td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>Last Filled:</td>
                  <td>{{$vphd->last_fil}}</td>
                  <td style="white-space: nowrap;">@if ($vphd->curstatus=='FILLED') *** Status:  Filled  @endif  </td>

                </tr>

                <tr>
                  <td>Last Overfilled:</td>
                  <td>{{$vphd->last_ove}}</td>
                  <td style="white-space: nowrap;">@if ($vphd->curstatus=='OVERFILLED') *** Status:  Overfilled  @endif</td>
                  <td></td>
                  <td></td>
                </tr>
              </table>

              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Budget</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>

                <tr>
                  <td><b>Budgeted FTEs</b></td>
                  <td></td>
                  <td></td>
                  <td><b>Budgeted Cost</b></td>
                  <td></td>
                </tr>

                <tr>
                  <td>Annual FTE Basis</td>
                  <td>{{round($vphd->annftehour,3)}}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>

                <tr>
                  <td>FTE Calc Freq</td>
                  <td>{{$vphd->ftefreq}}</td>
                  <td></td>
                  <td>Budg Pay Freq</td>
                  <td>{{$vphd->payfreq}}</td>
                </tr>

                <tr>
                  <td>FTE Hours</td>
                  <td>{{round($vphd->ftehours,3)}}</td>
                  <td></td>
                  <td>Budg Pay Rate</td>
                  <td>{{formatdollars($vphd->payrate)}}</td>
                </tr>

                <tr>
                  <td>FTEs for Position</td>
                  <td>{{round($vphd->fulltimeequiv,3)}}</td>
                  <td><img src="/images/ArrowRight.jpg" width="50" height="15"></td>
                  <td>FTEs for Position</td>
                  <td>{{round($vphd->fulltimeequiv,3)}}</td>
                </tr>

                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>Budg Annual Cost</td>
                  <td>{{formatdollars($vphd->budgsal)}}</td>
                </tr>




              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Organization</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>

                <tr>
                  <td>{{$level1Description}}</td>
                  <td>{{$vphd->level1}}</td>
                  <td width="10%">
                  <td width="10%">
                  <td width="10%">
                </tr>

                <tr>
                  <td>{{$level2Description}}</td>
                  <td>{{$vphd->level2}}</td>
                </tr>

                <tr>
                  <td>{{$level3Description}}</td>
                  <td>{{$vphd->level3}}</td>
                </tr>

                <tr>
                  <td>{{$level4Description}}</td>
                  <td>{{$vphd->level4}}</td>
                </tr>

                <tr>
                  <td>{{$level5Description}}</td>
                  <td>{{$vphd->level5}}</td>
                </tr>

              </table>


              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Reports to</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>

                <tr>
                  <td>Reports Directly to </td>
                  <td  style="white-space: nowrap;">@if ($vphd->reptocomp=='') Not Assigned @else {{$vphd->reptocomp}} / {{$vphd->reptoposno}} / {{$vphd->reptodesc}} @endif</td>
                </tr>

                <tr>
                  <td>Reports Indirectly to </td>
                  <td  style="white-space: nowrap;">@if ($vphd->reptocom2=='') Not Assigned @else {{$vphd->reptocom2}} / {{$vphd->reptopos2}} / {{$vphd->reptodesc2}} @endif</td>
                </tr>
              </table>

              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="25%">Changes made</th>
                    <th width="25%"></th>
                    <th width="0%"></th>
                    <th width="25%"></th>
                    <th width="25%"></th>
                  </tr>
                </thead>
              </table>
              {!! nl2br($vphd->historyreason) !!}
            @endforeach
          </table>


            </div>
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
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse5">User Defined</a>
            </div>
            <div class="col-md-10">
            </div>
          </div>
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
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse6">Funding</a>
            </div>
            <div class="col-md-10">
            </div>
          </div>
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
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse8">Succession Planning</a>
            </div>
            <div class="col-md-10">
            </div>
          </div>
        </h4>
      </div>
      <div id="collapse8" class="panel-collapse collapse">
        <div class="panel-body">Reserved for future functionality

        </div>
      </div>
    </div>

    <!-- ************************** -->
    <!-- ************************** -->
    <!-- allocations -->
    <!-- ************************** -->
    <!-- ************************** -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <div class="row">
            <div class="col-md-2">
              <a data-toggle="collapse" href="#collapse9">Allocations</a>
            </div>
            <div class="col-md-10">
            </div>
          </div>
        </h4>
      </div>
      <div id="collapse9" class="panel-collapse collapse">
        <div class="panel-body">Reserved for future functionality

        </div>
      </div>
    </div>

  <!-- </div> -->
</div>
</form>
</form>
</body>


@endsection
