@extends('layouts.applicant')
@section('content')
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            <img src="{{ asset('img/intec_logo.png') }}" class="ml-5"/>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @isset($intake)
                    <div class="d-flex justify-content-center">
                        <div class="p-2"><h3>NEW APPLICATION</h3></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="p-2"><a href="{{ route('registration.index') }}" class="btn btn-primary">NEW APPLICATION</a></div>
                    </div>
                    @endisset
                    <hr class="mt-2 mb-3">
                    <div class="d-flex justify-content-center">
                        <div class="p-2"><h3 style="text-align: center">CONTINUE WITH EXISTING APPLICATION <br> OR CHECK APPLICATION</h3></div>
                    </div>
                    {!! Form::open(['action' => 'RegistrationController@search', 'method' => 'GET']) !!}
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            {{Form::label('title', 'IC Number / Passport')}}
                            {{Form::text('applicant_ic', '', ['class' => 'form-control', 'placeholder' => 'Applicant IC', 'onkeyup' => 'this.value = this.value.toUpperCase()', 'placeholder' => 'Eg: 991023106960'])}}
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            <button type="submit" class="btn btn-primary mt-4">CONTINUE APPLICATION / CHECK APPLICATION</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
