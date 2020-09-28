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
                    <h2>NEW APPLICATION / CHECK APPLICATION</h2>
                    <p>If you wish to apply for any programme or check your application, click on one of the button below.</p>
                    <div class="d-flex justify-content-center">
                        <div class="p-2"><a href="{{ route('registration.index') }}" class="btn btn-primary">NEW APPLICATION</a></div>
                        <div class="p-2"><a href="/check" class="btn btn-primary">CHECK APPLICATION</a></div>
                    </div>
                    <hr class="mt-2 mb-3">
                    <h2>CONTINUE WITH EXISTING APPLICATION</h2>
                    {!! Form::open(['action' => 'RegistrationController@search', 'method' => 'GET']) !!}
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            {{Form::label('title', 'IC Number')}}
                            {{Form::text('applicant_ic', '', ['class' => 'form-control', 'placeholder' => 'Applicant IC', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                        </div>
                        <div class="p-2">
                            <button type="submit" class="btn btn-primary mt-4">CONTINUE APPLICATION</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
