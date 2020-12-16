@extends('layout')

@section('bodysection')
this is a test

<form method="post" action="{{ route('positions.store') }}">
    <div class="form-group">
        @csrf
        <label for="company">Company:</label>
        <input type="text" class="form-control" name="company"/>
    </div>
    <div class="form-group">
        <label for="posno">Position Number</label>
        <input type="text" class="form-control" name="posno"/>
    </div>
    <div class="form-group">
        <label for="descr">Position Name / Description:</label>
        <input type="text" class="form-control" name="descr"/>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>


@endsection

@section('content')
Test the Content Section
<!-- @extends('navbarcreate')
@section('main') -->

<style>
  .uper {
    margin-top: 40px;
  }
</style>
<body>
  <div>
    test
  </div>

  <div class="card uper">
    <div class="card-header">
      Add Position xxxyyyzzz
    </div>
    <div class="card-body">
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div><br />
      @endif
        <form method="post" action="{{ route('positions.store') }}">
            <div class="form-group">
                @csrf
                <label for="company">Company:</label>
                <input type="text" class="form-control" name="company"/>
            </div>
            <div class="form-group">
                <label for="posno">Position Number</label>
                <input type="text" class="form-control" name="posno"/>
            </div>
            <div class="form-group">
                <label for="descr">Position Name / Description:</label>
                <input type="text" class="form-control" name="descr"/>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
  </div>
</body>
@endsection
