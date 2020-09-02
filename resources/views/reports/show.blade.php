@extends('navbarreports')
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
        <h1 class="display-5">&nbsp;&nbsp;&nbsp;Report:  {{$report->descr}}</small></h1>





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


    <!-- $object = new StdClass;
    $object->title = 'foo';
    $object->age = 20;

    $data = [
        [
            'title' => 'bar',
            'age'   => 34,
        ],
        $object,
    ];

    $settings = [
        'columns' => [
            'title',
            'age',
        ]
    ];

    $handler = new CollectionHandler($data, $settings);
    $dataGrid = DataGrid::make($handler); -->



    <div class="grid__wrapper">
        {{-- Loader --}}
        <div class="progress__wrapper">
            <div class="progress">
              <div class="indeterminate"></div>
            </div>
        </div>

        {{-- Results container --}}
        <section data-grid-layout="results"></section>
        <form action="/action_page.php">



          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <div class="row">
                  <div class="col-md-12">
                    <a data-toggle="collapse" href="#collapseRep07">Report Parameters</a>
                  </div>

                </div>
              </h4>
            </div>
            <div id="collapseRep07" class="panel-collapse collapse">
              <div class="panel-body">
                {{$report->notes}}<br>



                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th width="20%">Field</th>
                      <th width="10%">Start</th>
                      <th width="5%"></th>
                      <th width="10%">End</th>
                      <th width="55%"></th>

                    </tr>
                  </thead>
                  @foreach($reportqueries as $query)
                    <tr>

                      <td>{{$query->descr}}</td>

                      @if ($query->datatype=="DATE")
                        <td><input type="date" id=beg|{{$query->table}}||{{$query->field}}||| name=beg|{{$query->table}}||{{$query->field}}|||></td>
                      @else
                        <td><input id=beg|{{$query->table}}||{{$query->field}}||| name=beg|{{$query->table}}||{{$query->field}}|||></td>
                      @endif

                      <td>to</td>

                      @if ($query->datatype=="DATE")
                        <td><input type="date" id=end|{{$query->table}}||{{$query->field}}||| name=end|{{$query->table}}||{{$query->field}}|||></td>
                      @else
                        <td><input id=end|{{$query->table}}||{{$query->field}}||| name=end|{{$query->table}}||{{$query->field}}|||></td>
                      @endif

                      <td>{{$query->options}}</td>
                      <!-- <td>{{$query->table}}</td>
                      <td>{{$query->field}}</td>
                      <td>{{$query->datatype}}</td>
                      <td>{{$query->descr}}</td> -->

                    </tr>
                  @endforeach
                </table>



              </div>
            </div>
          </div>






        </form>
        {{-- Pagination container --}}
        <footer data-grid-layout="pagination"></footer>
    </div>

  <!-- </div> -->
</div>

</body>

@endsection
