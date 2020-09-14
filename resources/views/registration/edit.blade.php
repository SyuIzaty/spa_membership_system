@extends('layouts.applicant')
@section('content')
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="panel-hdr">
            <h2>Registration</h2>
        </div>
            {!! Form::model($applicant, ['method' => 'PATCH', 'route' => ['registration.update', $applicant->id]]) !!}
                @csrf
                <div class="card">
                    <div class="card-header">Personal Profile</div>
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
                        <div class="alert alert-danger" role="alert">
                            * Mandatory Field
                            </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                {{Form::label('title', 'Applicant Name')}} *
                                {{ Form::hidden('applicant_id',$applicant->id) }}
                                {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name'])}}
                                @error('applicant_name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Applicant IC Number') }} *
                                {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'readonly' => 'true']) }}
                                @error('applicant_ic')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-8">
                                {{Form::label('title', 'Applicant Email')}} *
                                {{Form::email('applicant_email', $applicant->applicant_email, ['class' => 'form-control', 'placeholder' => 'Applicant Name'])}}
                                @error('applicant_email')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Applicant Phone Number') }} *
                                {{ Form::text('applicant_phone', $applicant->applicant_phone, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number']) }}
                                @error('applicant_phone')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                {{Form::label('title', 'Nationality')}} *
                                <select class="form-control" name="applicant_nationality">
                                    @foreach($country as $countries)
                                        <option value="{{ $countries->country_code }}" {{ $applicant->applicant_nationality == $countries->country_code ? 'selected="selected"' : ''}}>{{ $countries->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('applicant_nationality')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
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
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Marital Status') }}
                                <select class="form-control" name="applicant_marital">
                                    @foreach ($marital as $maritals)
                                        <option value="{{ $maritals->marital_code }}" {{ $applicant->applicant_marital == $maritals->marital_code ? 'selected="Selected"' : ''}}>{{ $maritals->marital_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Race') }}
                                <select class="form-control" name="applicant_race">
                                    @foreach ($race as $races)
                                        <option value="{{ $races->race_code }}" {{ $applicant->applicant_race == $races->race_code ? 'selected="Selected"' : ''}}>{{ $races->race_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                {{ Form::label('title', 'Religion') }}
                                <select class="form-control" name="applicant_religion">
                                    @foreach ($religion as $religions)
                                        <option value="{{ $religions->religion_code }}" {{ $applicant->applicant_religion == $religions->religion_code ? 'selected="Selected"' : ''}}>{{ $religions->religion_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('title', 'Address Line 1') }} *
                                {{ Form::text('applicant_address_1', '', ['class' => 'form-control', 'placeholder' => 'Address Line 1']) }}
                                @error('applicant_phone')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                {{ Form::label('title', 'Address Line 2') }}
                                {{ Form::text('applicant_address_2', '', ['class' => 'form-control', 'placeholder' => 'Address Line 2']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Postcode') }}
                                {{ Form::number('applicant_poscode', '', ['class' => 'form-control', 'placeholder' => 'Postcode']) }}
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'City') }} *
                                {{ Form::text('applicant_city', '', ['class' => 'form-control', 'placeholder' => 'City']) }}
                                @error('applicant_city')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'State') }} *
                                {{ Form::text('applicant_state', '', ['class' => 'form-control', 'placeholder' => 'State']) }}
                                @error('applicant_state')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Country') }}
                                <select class="form-control" name="applicant_country">
                                    @foreach($country as $countries)
                                    <option value="{{ $countries->country_code }}">{{ $countries->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('applicant_country')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-2 mb-3">
                <div class="card">
                    <div class="card-header">Guardian Contact Info</div>
                    <div class="card-body">
                        <div class="row">
                            {{Form::hidden('applicant_id', $applicant->id)}}
                            <div class="form-group col-md-12">
                                {{Form::label('title', 'Father / Guardian I Name')}} *
                                {{Form::text('guardian_one_name', '', ['class' => 'form-control', 'placeholder' => 'Guardian Name'])}}
                                @error('guardian_one_name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Father / Guardian I Relation') }} *
                                {{ Form::text('guardian_one_relationship', '', ['class' => 'form-control', 'placeholder' => 'Guardian Relation']) }}
                                @error('guardian_one_relationship')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Father / Guardian I Phone Number') }} *
                                {{ Form::number('guardian_one_mobile', '', ['class' => 'form-control', 'placeholder' => 'Guardian Phone Number']) }}
                                @error('guardian_one_mobile')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                {{Form::label('title', 'Father / Guardian I Address')}} *
                                {{Form::text('guardian_one_address', '', ['class' => 'form-control', 'placeholder' => 'Guardian Address'])}}
                                @error('guardian_one_address')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="form-group col-md-12">
                                {{Form::label('title', 'Mother / Guardian II Name')}} *
                                {{Form::text('guardian_two_name', '', ['class' => 'form-control', 'placeholder' => 'Guardian Name'])}}
                                @error('guardian_two_name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Mother / Guardian II Relation') }} *
                                {{ Form::text('guardian_two_relationship', '', ['class' => 'form-control', 'placeholder' => 'Guardian Relation']) }}
                                @error('guardian_two_relationship')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Mother / Guardian II Phone Number') }} *
                                {{ Form::number('guardian_two_mobile', '', ['class' => 'form-control', 'placeholder' => 'Guardian Phone Number']) }}
                                @error('guardian_two_mobile')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                {{Form::label('title', 'Mother / Guardian II Address')}}
                                {{Form::text('guardian_two_address', '', ['class' => 'form-control', 'placeholder' => 'Guardian Address'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-2 mb-3">
                <div class="card">
                    <div class="card-header">Emergency Contact Info</div>
                    <div class="card-body">
                        <div class="row">
                            {{Form::hidden('applicant_id', $applicant->id)}}
                            <div class="form-group col-md-12">
                                {{Form::label('title', 'Emergency Name')}} *
                                {{Form::text('emergency_name', '', ['class' => 'form-control', 'placeholder' => 'Emergency Name'])}}
                                @error('emergency_name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Emergency Relation') }} *
                                {{ Form::text('emergency_relationship', '', ['class' => 'form-control', 'placeholder' => 'Emergency Relation']) }}
                                @error('emergency_relationship')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Emergency Phone Number') }} *
                                {{ Form::number('emergency_phone', '', ['class' => 'form-control', 'placeholder' => 'Emergency Phone Number']) }}
                                @error('emergency_phone')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                {{Form::label('title', 'Emergency Address')}}
                                {{Form::text('emergency_address', '', ['class' => 'form-control', 'placeholder' => 'Guardian Address'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-2 mb-3">
                <div class="card">
                    <div class="card-header">Qualification</div>
                    <div class="card-body">
                        <div class="row qualification-row">
                            <div class="col-md-6 form-group">
                                {{ Form::label('title', 'Qualification Type') }}
                                <select class="form-control qualification" id="qualification">
                                    @foreach($qualification as $qualifications)
                                    <option value="{{ $qualifications->id }}">{{ $qualifications->qualification_code }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary tambah-qualification">Add Qualification</button>
                            </div>
                        </div>
                        <div class="row mt-2 mb-3">
                            <hr>
                            <div class="col-12">
                                <div class="content"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>

            {!! Form::close() !!}
    </div>
</div>
@endsection
@section('script')
<script>
    window.history.forward();
        function noBack() {
            window.history.forward();
    }
    var listSPM = {!! $subjectSpmStr !!};
    var listGradeSPM = {!! $gradeSpmStr !!};
    var listSTAM = {!! $subjectStamStr !!};
    var listGradeSTAM = {!! $gradeStamStr !!};
    var listUEC = {!! $subjectUecStr !!};
    var listGradeUEC = {!! $gradeUecStr !!};
    var listSTPM = {!! $subjectStpmStr !!};
    var listGradeSTPM = {!! $gradeStpmStr !!};
    var listALEVEL = {!! $subjectAlevelStr !!};
    var listGradeALEVEL = {!! $gradeAlevelStr !!};
    var listOLEVEL = {!! $subjectOlevelStr !!};
    var listGradeOLEVEL = {!! $gradeOlevelStr !!};
</script>
<script src="{{ asset('/js/applicant.js')}}" type="text/javascript"></script>
@endsection
