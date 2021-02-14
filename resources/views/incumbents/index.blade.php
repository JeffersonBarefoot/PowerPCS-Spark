@extends('navbar')

@section('main')
<div class="row">
<div class="col-sm-12">
    <h1 class="display-3">Positions Index.Blade.php</h1>

    <div>
        <a style="margin: 19px;" href="{{ route('positions.create')}}" class="btn btn-primary">New position</a>
    </div>
<div>



      <div class="column">
  <table class="table table-striped">
    <thead>
        <tr>
          <td>Company</td>
          <td>Position Number</td>
          <td>Position Description/Name</td>
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($positions as $position)
        <tr>
            <td>{{$position->company}}</td>
            <td>{{$position->posno}}</td>
            <td>{{$position->descr}}</td>
            <td>
                <a href="{{ route('positions.edit',$position->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('positions.destroy', $position->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>

</div>

<div class="col-sm-12">

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
  @endif
</div>

@endsection
