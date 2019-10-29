@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
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
@endsection
