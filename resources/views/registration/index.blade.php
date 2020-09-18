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
                            {!! Form::open(['action' => 'RegistrationController@store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="form-group col-md-8">
                                    @foreach ($intake as $intakes)
                                        <input type="hidden" value="{{ $intakes->id }}" name="intake_id">
                                    @endforeach
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                    {{Form::label('title', 'Name')}}
                                    {{Form::text('applicant_name', '', ['class' => 'form-control', 'placeholder' => 'Applicant Name'])}}
                                    @error('applicant_name')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'IC Number') }}
                                    {{ Form::number('applicant_ic', '', ['class' => 'form-control', 'placeholder' => 'Applicant IC Number']) }}
                                    @error('applicant_ic')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Phone Number') }}
                                    {{ Form::number('applicant_phone', '', ['class' => 'form-control', 'placeholder' => 'Applicant Phone']) }}
                                    @error('applicant_phone')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Email') }}
                                    {{ Form::email('applicant_email', '', ['class' => 'form-control', 'placeholder' => 'Applicant Email']) }}
                                    @error('applicant_email')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('title', 'Nationality') }}
                                    <select class="form-control" name="applicant_nationality" id="applicant_nationality" >
                                        @foreach($country as $countries)
                                            <option value="{{$countries->country_code}}">{{$countries->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <h4>Preffered Programme</h4>
                                </div>
                                <div class="col-md-8 form-group">
                                    {{ Form::label('title', '1st Preferred Programme (Required)') }}
                                    <select class="form-control" name="applicant_programme" >
                                        @foreach($programme as $programmes)
                                            <option value="{{$programmes->programme_code}}">{{$programmes->programme_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('applicant_programme')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('Major', 'Major') }}
                                    <select class="form-control" name="applicant_major" >
                                        @foreach($major as $majors)
                                            <option value="{{$majors->id}}">{{$majors->major_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('applicant_major')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-8 form-group">
                                    {{ Form::label('title', '2nd Preferred Programme (Optional)') }}
                                    <select class="form-control" name="applicant_programme_2" >
                                        <option value="">Select Programme</option>
                                        {{-- @foreach($progs as $programmes)
                                            <option value="{{$programmes->programme->programme_code}}">{{$programmes->programme->programme_name}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('Major', 'Major') }}
                                    <select class="form-control" name="applicant_major_2" >
                                        <option value="">Select Major</option>
                                        @foreach($major as $majors)
                                            <option value="{{$majors->id}}">{{$majors->major_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-8 form-group">
                                    {{ Form::label('title', '3rd Preferred Programme (Optional)') }}
                                    <select class="form-control" name="applicant_programme_3" >
                                        <option value="">Select Programme</option>
                                        {{-- @foreach($progs as $programmes)
                                            <option value="{{$programmes->programme->programme_code}}">{{$programmes->programme->programme_name}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    {{ Form::label('Major', 'Major') }}
                                    <select class="form-control" name="applicant_major_3" >
                                        <option value="">Select Major</option>
                                        @foreach($major as $majors)
                                            <option value="{{$majors->id}}">{{$majors->major_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary">Submit</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
