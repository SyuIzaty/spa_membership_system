@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Intake
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Create Intake</h2>
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
                            <table class="table table-bordered">
                                <div class="card-body">
                                    {!! Form::open(['action' => 'IntakeController@store', 'method' => 'POST']) !!}
                                        <div class="form-group">
                                            {{Form::label('title', 'Intake Code')}}
                                            {{Form::text('intake_type_code', '', ['class' => 'form-control', 'placeholder' => 'Intake Code', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('title', 'Intake Description')}}
                                            {{Form::text('intake_type_description', '', ['class' => 'form-control', 'placeholder' => 'Intake Description', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-6">
                                                {{Form::label('title', 'Application Start Date')}}
                                                {{Form::date('intake_app_open', '', ['class' => 'form-control', 'placeholder' => 'Application Start Date'])}}
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('title', 'Application End Date')}}
                                                {{Form::date('intake_app_close', '', ['class' => 'form-control', 'placeholder' => 'Application End Date'])}}
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-6">
                                                {{Form::label('title', 'Application Status Start Date')}}
                                                {{Form::date('intake_check_open', '', ['class' => 'form-control', 'placeholder' => 'Application Status Start Date'])}}
                                            </div>
                                            <div class="col-md-6">
                                                {{Form::label('title', 'Application Status End Date')}}
                                                {{Form::date('intake_check_close', '', ['class' => 'form-control', 'placeholder' => 'Application Status End Date'])}}
                                            </div>
                                        </div>
                                        <button class="btn btn-primary">Submit</button>
                                    {!! Form::close() !!}
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
