@extends('navbarincumbents')
@section('main')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="row">
      <!-- <div class="col-sm-8 offset-sm-0"> -->
      <div class="col-md-12">
          <h1 class="display-5">&nbsp;&nbsp;&nbsp;{{$incumbent->fname}}&nbsp{{$incumbent->lname}};<small>{{$incumbent->company}} / {{$incumbent->empno}}</small></h1>

        <!-- SAVE EDIT CHANGES -->
        <!-- Not working as of 2020-12-11 -->

        <br>
        <br>
        <button type="submit" class="btn btn-primary">Update</button>
        <br>
        <br>
      </div>
  </div>

  <!-- ************************** -->
  <!-- ************************** -->
  <!-- Incumbent details -->
  <!-- ************************** -->
  <!-- ************************** -->
    <!-- To Collapse:   <div class="panel-collapse collapse" id="collapse1" >
    To keep open:  <div class="panel-collapse" id="collapse1" >   -->
    <!-- <div class='panel-collapse collapse' id='collapse1' > -->


        <!-- *************************** -->
        <!-- Left div contains list of all incumbents -->
        <div class="row">
          <div class="col-md-3">Positions that {{$incumbent->fname}} {{$incumbent->lname}} has occupied:
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="10%"></th>
                  <th width="60%">Position</th>
                  <th width="30%">Last Active</th>
                  <!-- <th width="15%"></th>
                  <th width="30%"></th> -->
                </tr>
              </thead>

              <tr>
                @foreach($viewPositionsOccupied as $VPO)
                  <tr>
                    <td>
                      @if ($VPO->active_pos=='I')<span class="glyphicon glyphicon-remove" style="color:grey" data-toggle="tooltip" title="Inactive"></span>@endif
                    </td>
                    <td>
                      <a href={{route('incumbents.show',$VPO->incumbentempno)}}?reqcompany={{$VPO->incumbentcompany}}&reqpositioncompany={{$VPO->positioncompany}}&reqpositionposno={{$VPO->positionposno}}>
                      {{$VPO->descr}}
                    </td>
                    <td>{{date_format(date_create($VPO->posstop),"M Y")}}</td>
                  </tr>
                @endforeach
              </tr>

            </table>
          </div>

          <!-- *************************** -->
          <!-- Middle div contains list of all history records for the selected incumbent -->
          <?php $selectedPositionText=SessionGet('selectedincumbentposition') ?>
          <div class="col-md-3">
            {{$incumbent->fname}} {{$incumbent->lname}}
            &nbsp;&#11044;&nbsp;
            {{$selectedPositionText}}<br>
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="40%">Effective</th>
                  <th width="20%">FTEs</th>
                  <th width="40%">Ann Cost</th>
                </tr>
              </thead>


              <tr>
                @foreach($viewIncumbentPositionHistory as $VIPH)
                  <tr>
                    <td>
                      <a href={{route('incumbents.show',$VPO->incumbentempno)}}?reqcompany={{$VPO->incumbentcompany}}&reqpositioncompany={{$VPO->positioncompany}}&reqpositionposno={{$VPO->positionposno}}&reqincumbenthistoryid={{$VIPH->incumbentid}}>>
                      {{date_format(date_create($VIPH->posstart),"m/y")." to ".date_format(date_create($VIPH->posstop),"m/y")}}
                    </td>
                    <td>{{round($VIPH->fulltimeequiv,5)}}</td>
                    <td>{{FormatMoney($VIPH->ann_cost)}}</td>
                  </tr>
                @endforeach
              </tr>
            </table>
          </div>

          <!-- *************************** -->
          <!-- Right div contains details of selected incumbent -->
          <div class="col-md-6">
            @if (! empty($IncHistRec))
              @foreach($IncHistRec as $IHR)
              {{$IHR->fname}} {{$IHR->lname}}
                &nbsp;&#11044;&nbsp;
                {{$IHR->poscompany}} / {{$IHR->posno}} / {{$selectedPositionText}}
                &nbsp;&#11044;&nbsp;
                {{date_format(date_create($IHR->posstart),"m/d/Y")}}

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
                      <td>Status in Pos:</td>
                      <td>{{$IHR->active_pos}}</td>
                      <td></td>
                      <td>Employment Status:</td>
                      <td>{{$IHR->active}}</td>
                    </tr>

                    <tr>
                      <td>Started in Pos:</td>
                      <td style="text-align:left">{{$IHR->posstart}}</td>
                      <td></td>
                      <td>Ended in Pos:</td>
                      <td>{{$IHR->posstop}}</td>
                    </tr>

                    <tr>
                      <td>Last Hire Date:</td>
                      <td>{{$IHR->lasthire}}</td>
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
                      <td>{{FormatMoney($IHR->unitrate)}}</td>
                      <td></td>
                      <td>Annualized Rate</td>
                      <td>{{FormatDollars($IHR->annual)}}</td>
                    </tr>

                    <tr>
                      <td>Pay Frequency</td>
                      <td>{{$IHR->payfreq}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                    <tr>
                      <td>FTEs in this Pos:</td>
                      <td>{{round($IHR->fulltimeequiv,3)}}</td>
                      <td></td>
                      <td>Annual Cost</td>
                      <td>{{FormatDollars($IHR->ann_cost)}}</td>
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
                      <td>{{$IHR->level1}}</td>
                      <td></td>
                      <td>Org Level 4</td>
                      <td>{{$IHR->level4}}</td>
                    </tr>

                    <tr>
                      <td>Org Level 2</td>
                      <td>{{$IHR->level2}}</td>
                      <td></td>
                      <td>Org Level 5</td>
                      <td>{{$IHR->level5}}</td>
                    </tr>

                    <tr>
                      <td>Org Level 3</td>
                      <td>{{$IHR->level3}}</td>
                      <td></td>
                      <td>Primary Job</td>
                      <td>{{$IHR->jobtitle}}</td>
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
                        <td>{{$IHR->hrmsdate}}</td>
                        <td></td>
                        <td>Update Reason</td>
                        <td>{{$IHR->hrmsreas}}</td>
                      </tr>

                      <tr>
                        <td>Update Actual Date</td>
                        <td>{{$IHR->trans_date}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>

                    </table>


              @endforeach
            @endif
          </div>
        </div>

</body>
@endsection
