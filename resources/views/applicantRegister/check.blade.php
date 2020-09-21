@extends('layouts.applicant')
@section('content')
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <img src="{{ public_path('img/intec_offer.png') }}" style="height: 170px; width: 650px;">
                </div>
                <div class="card-body">
                    <hr class="mt-2 mb-3">
                    <h2>CHECK APPLICATION</h2>
                    {!! Form::open(['action' => 'RegistrationController@check', 'method' => 'GET']) !!}
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            {{Form::label('title', 'IC Number')}}
                            {{Form::text('applicant_ic', '', ['class' => 'form-control', 'placeholder' => 'Applicant IC', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                        </div>
                        <div class="p-2">
                            <button type="submit" class="btn btn-primary">CHECK APPLICATION</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
