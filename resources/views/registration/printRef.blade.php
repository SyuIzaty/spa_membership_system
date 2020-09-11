@extends('layouts.applicant')
@section('content')
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="panel-hdr">
                <h2>Registration</h2>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    {{Form::label('title', 'Name')}}
                                    {{Form::text('applicant_name', $applicant_detail->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'required', 'readonly' => 'true'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'IC Number') }}
                                    {{ Form::text('applicant_ic', $applicant_detail->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'required', 'readonly' => 'true']) }}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Phone Number') }}
                                    {{ Form::text('applicant_phone', $applicant_detail->applicant_phone, ['class' => 'form-control', 'placeholder' => 'Applicant Phone', 'required', 'readonly' => 'true']) }}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Email') }}
                                    {{ Form::text('applicant_email', $applicant_detail->applicant_email, ['class' => 'form-control', 'placeholder' => 'Applicant Email', 'required', 'readonly' => 'true']) }}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Nationality') }}
                                    {{ Form::text('applicant_nationality', $applicant_detail->country->country_name, ['class' => 'form-control', 'readonly' => 'true']) }}
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
                                <a class="btn btn-primary" href="{{ URL('/registration/'.$applicant_detail->id.'/edit' )}}">Proceed with Application</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
