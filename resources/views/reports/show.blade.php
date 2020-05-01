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

<div class="row">
    <!-- <div class="col-sm-8 offset-sm-0"> -->
    <div class="col-md-12">
        <h1 class="display-5">&nbsp;&nbsp;&nbsp;Reports</small></h1>

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
<?php $readonly='xreadonly' ?>


<body>

  <!-- <button onclick="expandStatus()"  id="p2" aria-expanded="false">Try it</button>
  <p id="demo"></p>

  <input type="hidden" id="testArial" name="testArial" value="3487"> -->



  <script>
    function initExpands() {

      sessionStorage.setItem("initialized","expandStatus");

    }


    function expandStatus() {
    var x = document.getElementById("p2").getAttribute("aria-expanded");
    if (x == " class='panel-collapse collapse' id='collapse1' ")
      {
        x = " class='panel-collapse' id='collapse1' ";
      } else {
        x = " class='panel-collapse collapse' id='collapse1' ";
      }

      // document.getElementById("p2").setAttribute("aria-expanded", x);
      // document.getElementById("p2").innerHTML = "aria-expanded =" + x;

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

  </script>


<!-- {{ Session::get('expandIncumbents')}}
sessionStorage.getItem("expandStatus")
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
              <a href="#collapse1" data-toggle="collapse" >REPORTS::::::Status</a>
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
                  <td>Position Funded</td>
                  <td></td>
                  <div class="radio">

                    @if ($position->funded=="Y")
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
                    <td><input type="text" class="form-control" name="startdate" value="{{$position->startdate}}" {{$readonly}}></td>
                  </tr>
                  <tr>
                    <td>Available</td>
                    <td></td>
                    <td><input type="text" class="form-control" name="avail_date" value="{{$position->avail_date}}" {{$readonly}}></td>
                  </tr>
                  <tr>
                    <td>End Date</td>
                    <td></td>
                    <td><input type="text" class="form-control" name="enddate" value="{{$position->enddate}}" {{$readonly}}></td>
                  </tr>


              </table>
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
                <td><input type="text" class="form-control" name="last_vac" value="{{$position->last_vac}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='VACANT') *** Current Status:  Vacant   @endif</td>
              </tr>
              <tr>
                <td>Last Became Partially Filled</td>
                <td><input type="text" class="form-control" name="last_par" value="{{$position->last_par}}" {{$readonly}}></td>
                <!-- <td><input type="text" class="form-control" name="last_par" value="{{$position->last_par}}" {{$readonly}}></td> -->
                <td>@if ($position->curstatus=='PARTIALLYFILLED') *** Current Status:  Partially Filled   @endif</td>
              </tr>
              <tr>
                <td>Last Became Filled</td>
                <td><input type="text" class="form-control" name="last_fil" value="{{$position->last_fil}}" {{$readonly}}></td>
                <td>@if ($position->curstatus=='FILLED') *** Current Status:  Filled  @endif</td>
              </tr>
              <tr>
                <td>Last Became Overfilled</td>
                <td><input type="text" class="form-control" name="last_fpl" value="{{$position->last_fpl}}" {{$readonly}}></td>
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
                    <th width="35%">FTEs</th>
                    <th width="35%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                  </tr>
                </thead>

                <tr>
                  <td>Annual FTE Basis</td>
                  <td><input type="text" class="form-control" name="annftehour" value="{{$position->annftehour}}"></td>

                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="35%">Costs</th>
                    <th width="35%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <table class="table table-condensed">
                <tr>
                  <td width="35%">Pay Frequency</td>
                  <td width="35%"><input type="text" class="form-control" name="annftehour" value="{{$position->ftefreq}}"></td>
                  <td width="10%">
                  <td width="10%">
                  <td width="10%">

                </tr>

                <tr>
                  <td>x Budgeted Hours</td>
                  <td><input type="text" class="form-control" name="annftehour" value="{{round($position->ftehours,3)}}"></td>

                </tr>

                <tr>
                  <td>/ Basis ) = FTEs</td>
                  <td><input type="text" class="form-control" name="annftehour" value="{{round($position->fulltimeequiv,3)}}"></td>
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
                    <td width="35%">Pay Frequency</td>
                    <td width="35%"><input type="text" class="form-control" name="payfreq" value="{{$position->payfreq}}"></td>
                    <td width="10%"></td>
                    <td width="10%"></td>
                    <td width="10%"></td>
                  </tr>
                  <!-- <tr>
                    <td>Pay Frequency</td>
                    <td></td>
                    <td></td>
                  </tr> -->
                  <tr>
                    <td>x Budgeted Pay Rate</td>
                    <td><input type="text" class="form-control" name="payrate" value="{{FormatDollars($position->payrate)}}"></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>x Budgeted FTEs</td>
                    <td><input type="text" class="form-control" name="dummyfulltimeequiv" value="{{round($position->fulltimeequiv,3)}}"></td>
                    <td></td>
                  </tr>

                  <tr>
                    <td>= Budgeted Annual Cost</td>
                    <td><input type="text" class="form-control" name="budgsal" value="{{FormatDollars($position->budgsal)}}"></td>
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

      <div id="collapse19999">
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
            </div>
          </div>
        </h4>
      </div>

      <div id="collapse4" class="panel-collapse">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th width="20%">Started</th>
                    <th width="20%">Status</th>
                    <th width="20%">FTEs</th>
                    <th width="20%">Budg Sal</th>
                    <th width="20%">Reason</th>
                  </tr>
                </thead>
                @foreach($posHistRecs as $posHistRecs)
                  <tr>
                      <td>{{$posHistRecs->trans_date}}</td>
                      <td>{{$posHistRecs->active}}</td>
                      <td>{{$posHistRecs->fulltimeequiv}}</td>
                      <td>{{$posHistRecs->budgsal}}</td>
                      <td>{{$posHistRecs->reason}}</td>
                  </tr>
                @endforeach
              </table>
            </div>
            <div class="col-md-6">
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

</body>

@endsection
