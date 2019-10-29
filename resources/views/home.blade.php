@extends('spark::layouts.app')

@section('content')
<!-- Include a navbar with auth user features-->
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{__('Dashboardxx')}}</div>

                    <div class="card-body">
                        {{__('Your application\'s dashboardxx.')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>
@endsection
