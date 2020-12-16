@extends('layout')

@section('bodysection')
Are you sure that you want to this position?


{{$position->company}} / {{$position->posno}} / {{$position->descr}}


<form method="DELETE" action="{{url('positions', [$position->id])}}" >
    @csrf


    <button type="submit" class="btn btn-primary">Delete</button>
</form>


@endsection

@section('content')
Test the Content Section

@extends('navbardestroy')
@section('main')

<style>
  .uper {
    margin-top: 40px;
  }
</style>

@endsection
