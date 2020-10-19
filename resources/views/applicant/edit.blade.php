@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Applicant Status
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Update Status</h2>
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
                                {!! Form::open(['action' => 'ApplicantController@store', 'method' => 'POST']) !!}
                                <input type="hidden" name="applicant_id" value="{{ $applicant['id'] }}">
                                    <div class="form-group">
                                        {{Form::label('title', 'Applicant Status')}}
                                        <select class="form-control" name="applicant_status">
                                            @foreach ($status as $statuses)
                                            <option value="{{ $statuses->status_code }}" {{ $applicant->applicant_status == $statuses->status_code ? 'selected="selected"' : ''}}>{{ $statuses->status_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-primary">Submit</button>
                                {!! Form::close() !!}
                                <hr class="mt-3 mb-2">
                                <div class="alert alert-primary" role="alert">
                                    <strong>Applicant Detail</strong>
                                </div>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Applicant Name</td>
                                        <td colspan="3">{{ Form::text('applicant_name', $applicant->applicant_name ,['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Applicant IC</td>
                                        <td>{{ Form::text('applicant_ic', $applicant->applicant_ic, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                        <td>Date of Birth</td>
                                        <td>{{ Form::date('applicant_dob', $applicant->applicant_dob, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number</td>
                                        <td>{{ Form::text('applicant_phone', $applicant->applicant_phone, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                        <td>Email</td>
                                        <td>{{ Form::email('applicant_email', $applicant->applicant_email, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>{{ Form::text('applicant_gender', $applicant->gender->gender_name, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                        <td>Marital</td>
                                        <td>{{ Form::text('applicant_marital', $applicant->marital->marital_name, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Race</td>
                                        <td>{{ Form::text('applicant_race', $applicant->race->race_name, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                        <td>Religion</td>
                                        <td>{{ Form::text('applicant_religion', $applicant->religion->religion_name, ['class'=>'form-control', 'readonly'=>'true']) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
