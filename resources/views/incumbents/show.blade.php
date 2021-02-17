@extends('navbarincumbents')
@section('main')

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>


<body>
  Incumbent.Show.Blade.Php

  <!-- ************************** -->
  <!-- ************************** -->
  <!-- Incumbent details -->
  <!-- ************************** -->
  <!-- ************************** -->



    <!-- To Collapse:   <div class="panel-collapse collapse" id="collapse1" >
    To keep open:  <div class="panel-collapse" id="collapse1" >   -->
    <!-- <div class='panel-collapse collapse' id='collapse1' > -->

    <div class="row">
      <div class="col-md-4">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th width="96%">History on File</th>
              <th width="1%"></th>
              <th width="1%"></th>
              <th width="1%"></th>
              <th width="1%"></th>
            </tr>
          </thead>

          <table>
            <th><a href={{route('incumbents.show',$incumbent->id)}}>View Current Status</th>
          </table>
          <br>
          <table>
            <th></th>
          </table>




        </table>
        <table>
          <th>History Records on File</th>
@foreach($IncumbentHistory as $vih)
        <tr>
          <td>{{$vih->lname}}</td>
          <td></td>

        </tr>

        <tr>
          <td>(((List history records here)))</td>
          <td></td>

        </tr>

        <tr>
          <td>12/31/2000         CEO         1.00FTE          $135,000 </td>
          <td></td>

        </tr>
@endforeach
        </table>




      </table>
      </div>

      <!-- *************************** -->
      <!-- Right div contains xxxxxxxxxxxxxxxxxxxxxx -->
      <div class="col-md-8">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th width="45%">Details</th>
              <th width="10%"></th>
              <th width="40%"></th>
              <th width="4%"></th>
              <th width="1%"></th>
            </tr>
          </thead>
          <tr>
            <td>Active Status</td>
            <td></td>

          </tr>

          <tr>
            <td>Allow Multiple Incumbents:</td>
            <td></td>

          </tr>

          <tr>
            <td>Position Funded</td>
            <td></td>

          </tr>


        </table>
      </div>
    </div>






</body>


@endsection
