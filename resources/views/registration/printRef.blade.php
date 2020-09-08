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
                                    {{Form::text('applicant_name', $detail->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'IC Number') }}
                                    {{ Form::text('applicant_ic', $detail->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number']) }}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Phone Number') }}
                                    {{ Form::text('applicant_phone', $detail->applicant_phone, ['class' => 'form-control', 'placeholder' => 'Applicant Phone']) }}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Email') }}
                                    {{ Form::text('applicant_email', $detail->applicant_email, ['class' => 'form-control', 'placeholder' => 'Applicant Phone']) }}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Nationality') }}
                                    {{ Form::text('applicant_email', $applicant_detail->country->country_name, ['class' => 'form-control', 'placeholder' => 'Applicant Phone']) }}
                                </div>
                                <div class="col-md-12">
                                    <h4>Preffered Programme</h4>
                                </div>
                                <div class="col-md-8 form-group">
                                    {{ Form::label('title', '1st Preferred Programme (Required)') }}
                                    <p>{{ $applicant_detail->programme->programme_name }}</p>
                                </div>
                                <div class="col-md-8 form-group">
                                    {{ Form::label('title', '2nd Preferred Programme (Optional)') }}
                                    @if(isset($applicant_detail->programmeTwo->programme_name))@endif
                                </div>
                                {{-- <div class="col-md-8 form-group">
                                    {{ Form::label('title', '3rd Preferred Programme (Optional)') }}
                                    <p>{{ $applicant_detail->programmeThree->programme_name }}</p>
                                </div> --}}
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
