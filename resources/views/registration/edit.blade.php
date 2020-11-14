@extends('layouts.applicant')
@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel-hdr">
            <h2>Registration</h2>
        </div>
        @if($applicant->applicant_status == '0' || $applicant->applicant_status == '2')

            {!! Form::model($applicant, ['method' => 'PATCH',  'enctype' => "multipart/form-data", 'route' => ['registration.update', $applicant->id], 'id' => "upload_form"]) !!}
                @csrf
                <div class="card">
                    <div class="panel-container show">
                        <div class="panel-content mt-3">
                            <ul class="nav nav-tabs" role="tablist" id="app">
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#details" role="tab">Applicant Details</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#qualification" role="tab">Qualification</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="tabs">
                                <div class="tab-pane active" id="details" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">Personal Profile</div>
                                        <div class="card-body m-3">
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
                                                    {{ Form::hidden('applicant_id',$applicant->id), ['id' => 'applicant_id'] }}
                                                    {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
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
                                                    <select class="form-control country" name="applicant_nationality">
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
                                                    <select class="form-control gender" name="applicant_gender">
                                                        <option disabled selected>Please select</option>
                                                        @foreach ($gender as $genders)
                                                            <option value="{{ $genders->gender_code }}" {{ $applicant->applicant_gender == $genders->gender_code ? 'selected="Selected"' : ''}}>{{ $genders->gender_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    {{ Form::label('title', 'Date of Birth') }}
                                                    {{ Form::date('applicant_dob', isset($applicant->applicant_dob) ? $applicant->applicant_dob : '', ['id' => 'applicant_dob', 'class' => 'form-control']) }}
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    {{ Form::label('title', 'Marital Status') }}
                                                    <select class="form-control marital" name="applicant_marital">
                                                        <option disabled selected>Please select</option>
                                                        @foreach ($marital as $maritals)
                                                            <option value="{{ $maritals->marital_code }}" {{ $applicant->applicant_marital == $maritals->marital_code ? 'selected="Selected"' : ''}}>{{ $maritals->marital_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    {{ Form::label('title', 'Race') }}
                                                    <select class="form-control race" name="applicant_race" id="applicant_race">
                                                        <option disabled selected>Please select</option>
                                                        @foreach ($race as $races)
                                                            <option value="{{ $races->race_code }}" {{ $applicant->applicant_race == $races->race_code ? 'selected="Selected"' : ''}}>{{ $races->race_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    {{ Form::text('other_race', isset($applicant->other_race) ? $applicant->other_race : '', ['id' => 'other_race', 'class' => 'form-control', 'placeholder' => 'Race', 'readonly' => 'true' ,'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    {{ Form::label('title', 'Religion') }}
                                                    <select class="form-control religion" name="applicant_religion" id="applicant_religion">
                                                        <option disabled selected>Please select</option>
                                                        @foreach ($religion as $religions)
                                                            <option value="{{ $religions->religion_code }}" {{ $applicant->applicant_religion == $religions->religion_code ? 'selected="Selected"' : ''}}>{{ $religions->religion_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    {{ Form::text('other_religion', isset($applicant->other_religion) ? $applicant->other_religion : '', ['id' => 'other_religion', 'class' => 'form-control', 'placeholder' => 'Religion', 'readonly' => 'readonly' ,'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    {{ Form::label('title', 'Address Line 1') }} *
                                                    {{ Form::text('applicant_address_1', isset($applicant->applicantContactInfo->applicant_address_1) ? $applicant->applicantContactInfo->applicant_address_1 : '', ['id' => 'applicant_address_1', 'class' => 'form-control', 'id' => 'applicant_address_1', 'placeholder' => 'Address Line 1','onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                    @error('applicant_address_1')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    {{ Form::label('title', 'Address Line 2') }} *
                                                    {{ Form::text('applicant_address_2', isset($applicant->applicantContactInfo->applicant_address_2) ? $applicant->applicantContactInfo->applicant_address_2 : '', ['id' => 'applicant_address_2', 'class' => 'form-control', 'placeholder' => 'Address Line 2', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                    @error('applicant_address_2')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Postcode') }} *
                                                    {{ Form::text('applicant_poscode', isset($applicant->applicantContactInfo->applicant_poscode) ? $applicant->applicantContactInfo->applicant_poscode : '', ['class' => 'form-control', 'placeholder' => 'Postcode']) }}
                                                    @error('applicant_poscode')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'City') }} *
                                                    {{ Form::text('applicant_city', isset($applicant->applicantContactInfo->applicant_city) ? $applicant->applicantContactInfo->applicant_city : '', ['class' => 'form-control', 'placeholder' => 'City', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                    @error('applicant_city')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'State') }} *
                                                    {{ Form::text('applicant_state', isset($applicant->applicantContactInfo->applicant_state) ? $applicant->applicantContactInfo->applicant_state : '', ['class' => 'form-control', 'placeholder' => 'State', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                    @error('applicant_state')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Country') }}
                                                    <select class="form-control country" name="applicant_country">
                                                        @if (isset($applicant->applicantContactInfo->applicant_country))
                                                            <option value="{{ $applicant->applicantContactInfo->applicant_country }}">{{ $applicant->applicantContactInfoapplicant_country }}</option>
                                                        @endif
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
                                    <div class="card">
                                        <div class="card-header">Guardian Contact Info</div>
                                        <div class="card-body m-3">
                                            <div class="row">
                                                {{Form::hidden('applicant_id', $applicant->id)}}
                                                <div class="form-group col-md-12">
                                                    {{Form::label('title', 'Father / Guardian I Name')}} *
                                                    {{Form::text('guardian_one_name', isset($applicant->applicantGuardian->guardian_one_name) ? $applicant->applicantGuardian->guardian_one_name : '', ['class' => 'form-control', 'placeholder' => 'Guardian Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                    @error('guardian_one_name')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Father / Guardian I Relation') }} *
                                                    <select class="form-control relation" name="guardian_one_relationship">
                                                        @if (isset($applicant->applicantGuardian->guardian_one_relationship))
                                                            <option value="{{ $applicant->applicantGuardian->guardian_one_relationship }}">{{ $applicant->applicantGuardian->familyOne->family_name }}</option>
                                                        @endif
                                                        @foreach($family as $families)
                                                            <option value="{{ $families->family_code }}">{{ $families->family_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('guardian_one_relationship')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Father / Guardian I Phone Number') }} *
                                                    {{ Form::text('guardian_one_mobile', isset($applicant->applicantGuardian->guardian_one_mobile) ? $applicant->applicantGuardian->guardian_one_mobile : '', ['class' => 'form-control', 'placeholder' => 'Guardian Phone Number']) }}
                                                    @error('guardian_one_mobile')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    {{Form::label('title', 'Father / Guardian I Address')}} *
                                                    <input type="checkbox" id="same_one" name="same_one" onchange= "addressFunction('one')"/>
                                                    <label for = "same">Same as applicant address.</label><br>
                                                    {{Form::text('guardian_one_address', isset($applicant->applicantGuardian->guardian_one_address) ? $applicant->applicantGuardian->guardian_one_address : '', ['id' => 'guardian_one_address', 'class' => 'form-control', 'placeholder' => 'Guardian Address', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                    @error('guardian_one_address')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="form-group col-md-12">
                                                    {{Form::label('title', 'Mother / Guardian II Name')}} *
                                                    {{Form::text('guardian_two_name', isset($applicant->applicantGuardian->guardian_two_name) ? $applicant->applicantGuardian->guardian_two_name : '', ['class' => 'form-control', 'placeholder' => 'Guardian II Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                    @error('guardian_two_name')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Mother / Guardian II Relation') }} *
                                                    <select class="form-control relation" name="guardian_two_relationship">
                                                        @if (isset($applicant->applicantGuardian->guardian_two_relationship))
                                                        <option value="{{ $applicant->applicantGuardian->guardian_two_relationship }}">{{ $applicant->applicantGuardian->familyTwo->family_name }}</option>
                                                        @endif
                                                        @foreach($family as $families)
                                                        <option value="{{ $families->family_code }}">{{ $families->family_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('guardian_two_relationship')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Mother / Guardian II Phone Number') }} *
                                                    {{ Form::text('guardian_two_mobile', isset($applicant->applicantGuardian->guardian_two_mobile) ? $applicant->applicantGuardian->guardian_two_mobile : '', ['class' => 'form-control', 'placeholder' => 'Guardian Phone Number']) }}
                                                    @error('guardian_two_mobile')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <input type="checkbox" id="same2" name="same2" onchange= "address2Function()"/>
                                                    <label for = "same2">Same as applicant address.</label><br>
                                                    {{Form::label('title', 'Mother / Guardian II Address')}}
                                                    {{Form::text('guardian_two_address', isset($applicant->applicantGuardian->guardian_two_address) ? $applicant->applicantGuardian->guardian_two_address : '', ['id' => 'guardian_two_address', 'class' => 'form-control', 'placeholder' => 'Guardian Address', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">Emergency Contact Info</div>
                                        <div class="card-body m-3">
                                            <div class="row">
                                                <label for="chkEmergency" class="form-group col-md-12">
                                                    <input type="checkbox" id="chkEmergency" name="chkEmergency" onclick="EnableEmergency()" />
                                                    Fill in if other than guardian
                                                </label>
                                                <input type="hidden" name="applicant_id" id="em_applicant_id" disabled="disabled" value="{{ $applicant->id }}">
                                                <div class="form-group col-md-12">
                                                    {{Form::label('title', 'Emergency Name')}} *
                                                    {{Form::text('emergency_name', isset($applicant->applicantEmergency->emergency_name) ? $applicant->applicantEmergency->emergency_name : '', ['id' => 'emergency_name', 'class' => 'form-control', 'placeholder' => 'Emergency Name', 'onkeyup' => 'this.value = this.value.toUpperCase()', 'disabled' => 'disabled'])}}
                                                    @error('emergency_name')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Emergency Relation') }} *
                                                    <select class="form-control relation" name="emergency_relationship" id="emergency_relationship" disabled="disabled">
                                                        @if (isset($applicant->applicantEmergency->emergency_relationship))
                                                        <option value="{{ $applicant->applicantEmergency->emergency_relationship }}">{{ $applicant->applicantEmergency->emergencyOne->family_name }}</option>
                                                        @else
                                                        <option disabled selected>Please select</option>
                                                        @foreach($family as $families)
                                                        <option value="{{ $families->family_code }}">{{ $families->family_name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    @error('emergency_relationship')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Emergency Phone Number') }} *
                                                    {{ Form::number('emergency_phone', isset($applicant->applicantEmergency->emergency_phone) ? $applicant->applicantEmergency->emergency_phone : '', ['id' => 'emergency_phone', 'class' => 'form-control', 'placeholder' => 'Emergency Phone Number', 'disabled' => 'disabled']) }}
                                                    @error('emergency_phone')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-12">
                                                    {{Form::label('title', 'Emergency Address')}}
                                                    {{Form::text('emergency_address', isset($applicant->applicantEmergency->emergency_address) ? $applicant->applicantEmergency->emergency_address : '', ['id' => 'emergency_address', 'class' => 'form-control', 'placeholder' => 'Guardian Address', 'onkeyup' => 'this.value = this.value.toUpperCase()', 'disabled' => 'disabled'])}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">Highest Qualification</div>
                                        <div class="card-body">
                                            <div class="col-md-12 form-group">
                                                {{ Form::label('title', 'Highest Qualification') }} *
                                                <select class="form-control qua" name="highest_qualification" required>
                                                    <option disabled selected value="">Please select</option>
                                                    @foreach($qualification as $qualifications)
                                                    <option value="{{ $qualifications->id }}" {{ $applicant->applicant_qualification == $qualifications->id ? 'selected="selected"' : ''}}>{{ $qualifications->qualification_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('highest_qualification')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="#qualification" class="btn btn-primary btn-sm float-right" onclick="navigate('Next')"><i class="fal fa-arrow-alt-from-left"></i> Next</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="qualification" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">Qualification</div>
                                        <div class="card-body m-3">
                                            <div class="col-md-12" style="color: red">** Note: Please keyin all your qualification</div>
                                            <div class="row qualification-row">
                                                <div class="col-md-6 form-group">
                                                    {{ Form::label('title', 'Qualification Type') }}
                                                    <select class="form-control qualification" id="qualificationselect">
                                                        <option disabled selected value="">Please select</option>
                                                        @foreach($qualification as $qualifications)
                                                        <option value="{{ $qualifications->id }}">{{ $qualifications->qualification_code }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-primary btn-sm mt-3 tambah-qualification"><i class="fal fa-plus"></i> Add Qualification</button>
                                                </div>
                                            </div>
                                            <div class="row mt-2 mb-3">
                                                <hr>
                                                <div class="col-12">
                                                    <div class="content"></div>
                                                    @error('bachelor_cgpa')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                    @error('diploma_cgpa')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                    @error('matriculation_cgpa')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                    @error('foundation_cgpa')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                    @error('muet_cgpa')
                                                        <p style="color: red">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <h5>Declaration</h5>
                                            <input type="checkbox" name="declaration"> I agree to the term and conditions
                                            @error('declaration')
                                                <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="card-footer">
                                            <a href="#details" class="btn btn-primary btn-sm mr-2" onclick="navigate('Previous')"><i class="fal fa-arrow-alt-from-right"></i> Previous</a>
                                            <button class="btn btn-success btn-sm float-right" id="submit"><i class="fal fa-check"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}
        @else
        <div class="card h-100">
            <div class="d-flex justify-content-lg-center">
                <div class="p-2">
                    <div class="card">
                        <div class="card-body">
                            Your application is being processed. You are not allowed to edit you details. Thank you
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')
<script>
    var existing = {!! $existing !!};
    var existingcgpa = {!! $existingcgpa !!};
    var myfiles = {!! json_encode($groupedfiles) !!};
    var publicpath = "{{url('/')}}";
    var spmdefault = true;
    var mandatorySub = ["1103","1119","1449"];

    window.history.forward();
        function noBack() {
            window.history.forward();
    }

    $(document).ready(function() {
        $('.country, .gender, .marital, .race, .religion, .relation, .qualification, .qua').select2();
    });

    function addressFunction(type)
    {
        var address = "";
        if($('#same_'+type).is(':checked'))
        {
            address = $('#applicant_address_1').val() + "," + $('#applicant_address_2').val() + "," + $('input[name=applicant_poscode]').val() + "," + $('input[name=applicant_city]').val() + "," + $('input[name=applicant_state]').val() + "," + $('select[name=applicant_country] option:selected').text()
        }

        $('#guardian_'+type+'_address').val(address);
    }


    function address2Function()
    {
        if (document.getElementById('same2').checked)
        {
            document.getElementById('guardian_two_address').value=document.getElementById('guardian_one_address').value;
        }
        else
        {
            document.getElementById('guardian_two_address').value="";
        }
    }

    function EnableEmergency()
    {
        var chkEmergency = document.getElementById("chkEmergency")
        var em_applicant_id = document.getElementById("em_applicant_id");
        var emergency_name = document.getElementById("emergency_name");
        var emergency_relationship = document.getElementById("emergency_relationship");
        var emergency_phone = document.getElementById("emergency_phone");
        var emergency_address = document.getElementById("emergency_address");
        emergency_name.disabled = chkEmergency.checked ? false : true;
        emergency_relationship.disabled = chkEmergency.checked ? false : true;
        emergency_address.disabled = chkEmergency.checked ? false : true;
        emergency_phone.disabled = chkEmergency.checked ? false : true;
        em_applicant_id.disabled = chkEmergency.checked ? false : true;
        if(!em_applicant_id.disabled && !emergency_name.disabled && !emergency_relationship.disabled && !emergency_address.disabled && !emergency_phone.disabled){
            em_applicant_id.focus();
            emergency_name.focus();
            emergency_relationship.focus();
            emergency_address.focus();
            emergency_phone.focus();
        }
    }

    $(function () {
        $("#applicant_race").change(function () {
            if ($(this).val() == '0000') {
                $("#other_race").removeAttr("readonly");
                $("#other_race").focus();
            } else {
                $('#other_race').val('');
                $("#other_race").attr("readonly", "true");
            }
        });

        $("#applicant_religion").change(function () {
            if ($(this).val() == 'O') {
                $("#other_religion").removeAttr("readonly");
                $("#other_religion").focus();
            } else {
                $('#other_religion').val('');
                $("#other_religion").attr("readonly", "true");
            }
        });
    });

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
    var apelGrades = {!!  $gradeApel !!};

    $(document).ready(function(){

        var currenturl = window.location.href;
        if(currenturl.indexOf('#') !== -1)
        {
            console.log('im #')
            $('#app a[href="#' + currenturl.split('#')[1] + '"]').tab('show');
        }
        else
        {
            console.log('nth')
            $('#app a[href="#details"]').tab('show');
        }

        setInterval(function(){autoSave()},20000);

    });

    function Delete(button,id=null)
    {
        var type = $(button).data('type');

        var quaId = type == "qualification" ? id : $(button).closest('.col-md-12').find('.qualificationtype').val();
        var subId = type == "qualification" ? 0 : $(button).parent().parent().find('select').first().val();

        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $.ajax({
            url: "{{url('/applicant/delete')}}",
            type: 'post',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                id : id,
                typeid : quaId,
                subject : subId,
                type : type,
                userid : "{{ $id }}",
            },
            success: function(response){

            }
        })

        if(type == "result")
        {
            $(button).parent().parent().remove();
        }
        else
        {
            $(button).parent().parent().parent().remove();
        }
    }

    function navigate(type)
    {
        if(type == "Previous")
        {
            $('#app a[href="#details"]').tab('show');
        }
        else
        {
            $('#app a[href="#qualification"]').tab('show');
        }
    }

    function autoSave()
    {
        var formdata = new FormData($("#upload_form")[0]);
        formdata.append('autoSave','1');
      $.ajax({
          url: '{{url("update")."/".$applicant->id}}/auto',
          method: "POST",
          contentType: false,
          processData: false,
          data:formdata,
          success: function(response){

          },
          error : function(err)
          {
            var errors = err.responseJSON;
             console.log(errors);
            for(var error in errors.errors)
            {
                $.each(errors[error], function( index,value )
                {
                    console.log(value,index);
                })

            }
          }
        });
    }
</script>
<script src="{{ asset('/js/applicant.js')}}" type="text/javascript"></script>
@endsection
