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
                            <img src="{{ asset('img/intec_logo.png') }}" class="responsive"/>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @isset($intake)
                    <div class="d-flex justify-content-center">
                        <div class="p-2"><h3>NEW APPLICATION</h3><p>If you wish to apply for any INTEC programme, click on the button below.</p></div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="p-2"><a href="{{ route('registration.index') }}" class="btn btn-success"><i class="fal fa-pencil-alt"></i> NEW APPLICATION</a></div>
                    </div>
                    @endisset
                    <hr class="mt-2 mb-3" style="border: 1px solid #ececec">
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            <h3>CONTINUE WITH EXISTING APPLICATION <br> OR CHECK APPLICATION</h3>
                            <br>
                            <p>If you have made application for any INTEC programme before and wish <br>to continue with your application or you wish to check your status for any <br>application , kindly login below.</p>
                        </div>
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
                            <button type="submit" class="btn btn-primary mt-4"><i class="fal fa-search"></i> CONTINUE APPLICATION / CHECK APPLICATION</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
