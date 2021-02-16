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
  <!-- Position Status -->
  <!-- ************************** -->
  <!-- ************************** -->



    <!-- To Collapse:   <div class="panel-collapse collapse" id="collapse1" >
    To keep open:  <div class="panel-collapse" id="collapse1" >   -->
    <!-- <div class='panel-collapse collapse' id='collapse1' > -->

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
<td> test </td>
<td> {{$incumbent->lname}}{{$incumbent->fname}} </td>
              </tr>

              <tr>

              </tr>

              <tr>

              </tr>
            </table>





</body>


@endsection
