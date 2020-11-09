@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Physical Registration
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Physical Registration</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="card-body">
                                {!! Form::open(['action' => ['PhysicalRegistrationController@update', $applicant['id']], 'method' => 'POST'])!!}
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Applicant Name</td>
                                            <td colspan="3">{{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>Applicant IC</td>
                                            <td>{{Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC'])}}</td>
                                            <td>Sponsor</td>
                                            <td>
                                                <select class="form-control" name="sponsor_code" id="sponsor">
                                                    @foreach ($sponsor as $sponsors)
                                                        <option value="{{ $sponsors->sponsor_code }}" {{ $applicant->sponsor_code == $sponsors->sponsor_code ? 'selected="selected"' : ''}}>{{ $sponsors->sponsor_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>{{Form::text('applicant_phone', $applicant->applicant_phone, ['class' => 'form-control', 'placeholder' => 'Phone Number'])}}</td>
                                            <td>Email</td>
                                            <td>{{Form::email('applicant_email', $applicant->applicant_email, ['class' => 'form-control', 'placeholder' => 'Email'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>
                                                <select class="form-control gender" name="applicant_gender" id="applicant_gender" >
                                                    @foreach($gender as $genders)
                                                        <option value="{{$genders->gender_code}}"  {{ $applicant->applicant_gender == $genders->gender_code ? 'selected="selected"' : '' }}>{{$genders->gender_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>Marital</td>
                                            <td>
                                                <select class="form-control marital" name="applicant_marital" id="applicant_marital">
                                                    @foreach($marital as $maritals)
                                                        <option value="{{ $maritals->marital_code }}" {{ $applicant->applicant_marital == $maritals->marital_code ? 'selected="selected"' : ''}}>{{ $maritals->marital_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Race</td>
                                            <td>
                                                <select class="form-control race" name="applicant_race" id="applicant_race">
                                                    @foreach ($race as $races)
                                                        <option value="{{ $races->race_code }}" {{ $applicant->applicant_race == $races->race_code ? 'selected="Selected"' : ''}}>{{ $races->race_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>Religion</td>
                                            <td>
                                                <select class="form-control religion" name="applicant_religion" id="applicant_religion">
                                                    @foreach ($religion as $religions)
                                                        <option value="{{ $religions->religion_code }}" {{ $applicant->applicant_religion == $religions->religion_code ? 'selected="selected"' : ''}}>{{ $religions->religion_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address I</td>
                                            <td colspan="3">{{ Form::text('applicant_address_1', $applicant->applicantContactInfo->applicant_address_1, ['class' => 'form-control', 'placeholder' => 'Address 1', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address II</td>
                                            <td colspan="3">{{ Form::text('applicant_address_2', $applicant->applicantContactInfo->applicant_address_2, ['class' => 'form-control', 'placeholder' => 'Address 2', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Postcode</td>
                                            <td>{{ Form::text('applicant_poscode', $applicant->applicantContactInfo->applicant_poscode, ['class' => 'form-control', 'placeholder' => 'Postcode', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}</td>
                                            <td>City</td>
                                            <td>{{ Form::text('applicant_city', $applicant->applicantContactInfo->applicant_city, ['class' => 'form-control', 'placeholder' => 'Applicant City', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td>{{ Form::text('applicant_state', $applicant->applicantContactInfo->applicant_state, ['class' => 'form-control', 'placeholder' => 'State', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}</td>
                                            <td>Country</td>
                                            <td>
                                                <select class="form-control country" name="applicant_country" id="applicant_country" >
                                                    @foreach($country as $countries)
                                                        <option value="{{$countries->country_code}}"  {{ $applicant->applicantContactInfo->applicant_country == $countries->country_code ? 'selected="selected"' : '' }}>{{$countries->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="applicant_status" value="7A">
                                        <input type="hidden" name="student_id" value="{{ $applicant->student_id }}">
                                    </table>
                                    {{Form::hidden('_method', 'PUT')}}
                                    <button class="btn btn-primary btn-sm float-right mb-3">Submit</button>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#sponsor, #applicant_race, #applicant_religion, #applicant_marital, #applicant_gender, #applicant_country').select2();
    });
</script>
@endsection
