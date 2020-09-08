@extends('layouts.applicant')
@section('content')
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="panel-hdr">
                <h2>Registration</h2>
            </div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#personal" role="tab">Personal Profile</a>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#parent" role="tab">Parent / Guardian Contact Info</a>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" class="nav-link" href="#emergency" role="tab">Emergency Contact</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="personal" role="tabpanel">
                    {!! Form::model($applicant, ['method' => 'PATCH', 'route' => ['registration.update', $applicant->id]]) !!}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Applicant Name')}}
                                    {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'readonly' => 'true'])}}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Applicant IC Number') }}
                                    {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'readonly' => 'true']) }}
                                </div>
                            </div>
                            <hr class="mt-2 mb-3">
                            <div class="col-md-12"><h4>Personal Profile</h4></div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    {{Form::label('title', 'Applicant Name')}}
                                    {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Applicant IC Number') }}
                                    {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'readonly' => 'true']) }}
                                </div>
                                <div class="form-group col-md-8">
                                    {{Form::label('title', 'Applicant Email')}}
                                    {{Form::email('applicant_email', $applicant->applicant_email, ['class' => 'form-control', 'placeholder' => 'Applicant Name'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Applicant Phone Number') }}
                                    {{ Form::text('applicant_phone', $applicant->applicant_phone, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{Form::label('title', 'Nationality')}}
                                    <select class="form-control" name="applicant_nationality">
                                        @foreach($country as $countries)
                                            <option value="{{ $countries->country_code }}" {{ $applicant->applicant_nationality == $countries->country_code ? 'selected="selected"' : ''}}>{{ $countries->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    {{ Form::label('title', 'Gender') }}
                                    <select class="form-control" name="applicant_gender">
                                        @foreach($gender as $genders)
                                            <option value="{{ $genders->gender_code }}" {{ $applicant->applicant_gender == $genders->gender_code ? 'selected="selected"' : ''}}>{{ $genders->gender_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Date of Birth') }}
                                    {{ Form::date('applicant_dob', '', ['class' => 'form-control']) }}
                                </div>
                                <div class="col-md-12 form-group">
                                    {{ Form::label('title', 'Address Line 1') }}
                                    {{ Form::text('applicant_address_1', '', ['class' => 'form-control', 'placeholder' => 'Address Line 1']) }}
                                </div>
                                <div class="col-md-12 form-group">
                                    {{ Form::label('title', 'Address Line 2') }}
                                    {{ Form::text('applicant_address_2', '', ['class' => 'form-control', 'placeholder' => 'Address Line 2']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Postcode') }}
                                    {{ Form::text('applicant_poscode', '', ['class' => 'form-control', 'placeholder' => 'Postcode']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'City') }}
                                    {{ Form::text('applicant_city', '', ['class' => 'form-control', 'placeholder' => 'City']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'State') }}
                                    {{ Form::text('applicant_state', '', ['class' => 'form-control', 'placeholder' => 'State']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'State') }}
                                    <select class="form-control" name="applicant_country">
                                        @foreach($country as $countries)
                                        <option value="{{ $countries->country_code }}">{{ $countries->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"> <a data-toggle="tab" class="nav-link" href="#parent" role="tab" class="btn btn-primary">Next</a></div>
                    </div>
                </div>
                <div class="tab-pane" id="parent" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Applicant Name')}}
                                    {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'readonly' => 'true'])}}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Applicant IC Number') }}
                                    {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'readonly' => 'true']) }}
                                </div>
                            </div>
                            <hr class="mt-2 mb-3">
                            <div class="col-md-12"><h4>Guardian Contact Info</h4></div>
                            <div class="row">
                                {{Form::hidden('id', $applicant->id)}}
                                <div class="form-group col-md-8">
                                    {{Form::label('title', 'Father / Guardian I Name')}}
                                    {{Form::text('guardian_one_name', '', ['class' => 'form-control', 'placeholder' => 'Guardian Name'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Father / Guardian I Relation') }}
                                    {{ Form::text('guardian_one_relationship', '', ['class' => 'form-control', 'placeholder' => 'Guardian Relation']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{Form::label('title', 'Father / Guardian I IC Number')}}
                                    {{Form::text('guardian_one_ic', '', ['class' => 'form-control', 'placeholder' => 'Guardian IC Number'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Father / Guardian I Phone Number') }}
                                    {{ Form::text('guardian_one_mobile', '', ['class' => 'form-control', 'placeholder' => 'Guardian Phone Number']) }}
                                </div>
                                <div class="form-group col-md-12">
                                    {{Form::label('title', 'Father / Guardian I Address')}}
                                    {{Form::text('guardian_one_address', '', ['class' => 'form-control', 'placeholder' => 'Guardian Address'])}}
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Father / Guardian I Occupation')}}
                                    {{Form::text('guardian_one_occupation', '', ['class' => 'form-control', 'placeholder' => 'Guardian Occupation'])}}
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Nationality')}}
                                    <select class="form-control" name="guardian_one_nationality">
                                        @foreach($country as $countries)
                                            <option value="{{ $countries->country_code }}" >{{ $countries->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    {{Form::label('title', 'Mother / Guardian II Name')}}
                                    {{Form::text('guardian_two_name', '', ['class' => 'form-control', 'placeholder' => 'Guardian Name'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Mother / Guardian II Relation') }}
                                    {{ Form::text('guardian_two_relationship', '', ['class' => 'form-control', 'placeholder' => 'Guardian Relation']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    {{Form::label('title', 'Mother / Guardian II IC Number')}}
                                    {{Form::text('guardian_two_ic', '', ['class' => 'form-control', 'placeholder' => 'Guardian IC Number'])}}
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Mother / Guardian II Phone Number') }}
                                    {{ Form::text('guardian_two_mobile', '', ['class' => 'form-control', 'placeholder' => 'Guardian Phone Number']) }}
                                </div>
                                <div class="form-group col-md-12">
                                    {{Form::label('title', 'Mother / Guardian II Address')}}
                                    {{Form::text('guardian_two_address', '', ['class' => 'form-control', 'placeholder' => 'Guardian Address'])}}
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Mother / Guardian II Occupation')}}
                                    {{Form::text('guardian_two_occupation', '', ['class' => 'form-control', 'placeholder' => 'Guardian Occupation'])}}
                                </div>
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Nationality')}}
                                    <select class="form-control" name="guardian_two_nationality">
                                        @foreach($country as $countries)
                                            <option value="{{ $countries->country_code }}" >{{ $countries->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer"> <a data-toggle="tab" class="nav-link" href="#emergency" role="tab">Next</a></div>
                    </div>
                </div>
                <div class="tab-pane" id="emergency" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Applicant Name')}}
                                    {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'readonly' => 'true'])}}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Applicant IC Number') }}
                                    {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'readonly' => 'true']) }}
                                </div>
                            </div>
                            <hr class="mt-2 mb-3">
                            <div class="col-md-12"><h4>Emergency Contact Info</h4></div>
                            <div class="row">
                                {{Form::hidden('applicant_id', $applicant->id)}}
                                <div class="form-group col-md-12">
                                    {{Form::label('title', 'Emergency Name')}}
                                    {{Form::text('emergency_name', '', ['class' => 'form-control', 'placeholder' => 'Emergency Name'])}}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Emergency Relation') }}
                                    {{ Form::text('emergency_relationship', '', ['class' => 'form-control', 'placeholder' => 'Emergency Relation']) }}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Emergency Phone Number') }}
                                    {{ Form::text('emergency_phone', '', ['class' => 'form-control', 'placeholder' => 'Emergency Phone Number']) }}
                                </div>
                                <div class="form-group col-md-12">
                                    {{Form::label('title', 'Emergency Address')}}
                                    {{Form::text('emergency_address', '', ['class' => 'form-control', 'placeholder' => 'Guardian Address'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Submit</button>
                         {!! Form::close() !!}
                    </div>
                </div>
                {{-- <div class="tab-pane" id="academic" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {{Form::label('title', 'Applicant Name')}}
                                    {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'readonly' => 'true'])}}
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Applicant IC Number') }}
                                    {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'readonly' => 'true']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
