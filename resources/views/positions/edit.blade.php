@extends('base2')
@section('main')
<div class="row">
    <div class="col-sm-8 offset-sm-2">
        <h1 class="display-3">Update a Position</h1>

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
        <form method="post" action="{{ route('positions.update', $position->id) }}">
            @method('PATCH')
            @csrf

            <div class="form-group">

                <label for="company">Company:</label>
                <input type="text" class="form-control" name="company" value="{{ $position->company }}" />
            </div>

            <div class="form-group">
                <label for="posno">Posno:</label>
                <input type="text" class="form-control" name="posno" value="{{ $position->posno }}" />
            </div>

            <div class="form-group">
                <label for="descr">Descr:</label>
                <input type="text" class="form-control" name="descr" value="{{ $position->descr }}" />
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
