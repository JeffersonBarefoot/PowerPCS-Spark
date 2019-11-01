@extends('spark::layouts.app')

@section('content')
@parent
<!-- Include a navbar with auth user features-->
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- <div class="card card-default"> -->

test verbiage
  @yield("navbarsection","didn't find the navbarsection")

                <!-- </div> -->

            </div>

        </div>

    </div>

</home>
@endsection
