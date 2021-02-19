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
          <div class="col-md-4">Positions that {{$incumbent->fname}}{{$incumbent->lname}} has occupied:
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="10%"></th>
                  <th width="25%">From </th>
                  <th width="25%">To</th>
                  <th width="40%">Position</th>
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
                    <td>{{$VPO->posstart}}</td>
                    <td>{{$VPO->posstop}}</td>
                    <td><a href={{route('incumbents.show',$VPO->incumbentempno)}}?reqcompany={{$VPO->incumbentcompany}}&reqpositioncompany={{$VPO->positioncompany}}&reqpositionposno={{$VPO->positionposno}}>{{$VPO->descr}}</td>

                  </tr>
                @endforeach
              </tr>

            </table>
          </div>

          <!-- *************************** -->
          <!-- Middle div contains list of all history records for the selected incumbent -->
          <?php $selectedPositionText=SessionGet('selectedincumbentposition') ?>
          <div class="col-md-3">History in {{$selectedPositionText}}
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="40%">Starting</th>
                  <th width="20%">FTEs</th>
                  <th width="40%">Ann Cost</th>
                </tr>
              </thead>


              <tr>
                @foreach($viewIncumbentPositionHistory as $VIPH)
                  <tr>
                    <td>{{$VIPH->posstart}}</td>
                    <td>{{$VIPH->fulltimeequiv}}</td>
                    <td>{{FormatMoney($VIPH->ann_cost)}}</td>
                  </tr>
                @endforeach
              </tr>
            </table>
          </div>

          <!-- *************************** -->
          <!-- Right div contains details of selected incumbent -->
          <div class="col-md-5">Details:
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th width="40%">Starting</th>
                  <th width="20%">FTEs</th>
                  <th width="40%">Ann Cost</th>
                </tr>
              </thead>


              <tr>
                @foreach($viewIncumbentPositionHistory as $VIPH)
                  <tr>
                    <td>{{$VIPH->posstart}}</td>
                    <td>{{$VIPH->fulltimeequiv}}</td>
                    <td>{{FormatMoney($VIPH->ann_cost)}}</td>
                  </tr>
                @endforeach
              </tr>
            </table>
          </div>
        </div>

</body>
@endsection
