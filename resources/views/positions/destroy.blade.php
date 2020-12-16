@extends('layout')

@section('bodysection')
Destroy this position?

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

@extends('navbarcreate')
@section('main')

<style>
  .uper {
    margin-top: 40px;
  }
</style>

@endsection
