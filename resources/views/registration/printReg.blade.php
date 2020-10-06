@extends('layouts.applicant')
@section('content')
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5>Successfull Application</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($applicant as $applicant_detail)
                        <div class="form-group col-md-12">
                            <h5>Congratulation {{ $applicant_detail->applicant_name }}!! Your application is being processed</h5>
                        </div>
                        <div class="form-group col-md-8">
                            {{ Form::label('title','Name') }}
                            {{ Form::text('',$applicant_detail->applicant_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('title','IC Number') }}
                            {{ Form::text('', $applicant_detail->applicant_ic, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="form-group col-md-8">
                            {{ Form::label('title', 'Phone Number') }}
                            {{ Form::text('', $applicant_detail->applicant_phone, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('title', 'Email') }}
                            {{ Form::text('', $applicant_detail->applicant_email, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-4 form-group">
                            {{ Form::label('title', 'Nationality') }}
                            {{ Form::text('', $applicant_detail->country->country_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="form-group col-md-4">
                            {{ Form::label('title','Religion') }}
                            {{ Form::text('', $applicant_detail->religion->religion_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-4 form-group">
                            {{ Form::label('title', 'Race') }}
                            {{ Form::text('', $applicant_detail->race->race_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::Label('title', 'Gender') }}
                            {{ Form::text('',$applicant_detail->gender->gender_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="form-group col-md-6">
                            {{ Form::label('text', 'Marital Status') }}
                            {{ Form::text('',$applicant_detail->marital->marital_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-12 form-group">
                            {{ Form::label('title', 'Address Line 1') }}
                            {{ Form::text('', $applicant_detail->applicantContactInfo->applicant_address_1, ['class' => 'form-control', 'placeholder' => 'Address Line 1', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-12 form-group">
                            {{ Form::label('title', 'Address Line 2') }}
                            {{ Form::text('', $applicant_detail->applicantContactInfo->applicant_address_2, ['class' => 'form-control', 'placeholder' => 'Address Line 2', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-6 form-group">
                            {{ Form::label('title', 'Postcode') }}
                            {{ Form::text('', $applicant_detail->applicantContactInfo->applicant_poscode, ['class' => 'form-control', 'placeholder' => 'Postcode', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-6 form-group">
                            {{ Form::label('title', 'City') }} *
                            {{ Form::text('applicant_city', $applicant_detail->applicantContactInfo->applicant_city, ['class' => 'form-control', 'placeholder' => 'City', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-6 form-group">
                            {{ Form::label('title', 'State') }} *
                            {{ Form::text('applicant_state', $applicant_detail->applicantContactInfo->applicant_state, ['class' => 'form-control', 'placeholder' => 'State', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-6 form-group">
                            {{ Form::label('title', 'Country') }}
                            {{ Form::text('', $applicant_detail->applicantContactInfo->country->country_name, ['class' => 'form-control', 'placeholder' => 'Country', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-12">
                            <h4>Preffered Programme</h4>
                        </div>
                        <div class="col-md-6 form-group">
                            {{ Form::label('title', '1st Preferred Programme (Required)') }}
                            {{ Form::text('', $applicant_detail->programme->programme_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        <div class="col-md-6 form-group">
                            {{ Form::label('title', '1st Preferred Major (Required)') }}
                            {{ Form::text('', $applicant_detail->majorOne->major_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                        </div>
                        @if(isset($applicant_detail->applicant_programme_2))
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', '2nd Preffered Programme') }}
                                {{ Form::text('', $applicant_detail->programmeTwo->programme_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', '2nd Preferred Major') }}
                                {{ Form::text('', $applicant_detail->majorTwo->major_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                            </div>
                        @endif
                        @if(isset($applicant_detail->applicant_programme_3))
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', '3rd Preffered Programme') }}
                                {{ Form::text('', $applicant_detail->programmeThree->programme_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', '3rd Preferred Major') }}
                                {{ Form::text('', $applicant_detail->majorThree->major_name, ['class' => 'form-control', 'readonly' => 'true']) }}
                            </div>
                        @endif
                    @endforeach
                    <a class="btn btn-primary btn-block" href="{{ URL('/registration' )}}">Exit</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
