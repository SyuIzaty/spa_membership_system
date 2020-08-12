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
                            <table class="table table-bordered">
                                <div class="card-body">
                                    <div class="form-group">
                                        {{Form::label('title', 'Intake Program Info')}}
                                        <a class="btn btn-info pull-right" href="javascript:;" data-toggle="modal" id="new">Add Program Info</a>
                                    </div>
                                    <div class="form-group">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Program Code</th>
                                                <th>Description</th>
                                                <th>Intake Type</th>
                                                <th>Intake Date</th>
                                                <th>Intake Time</th>
                                                <th>Intake Venue</th>
                                                <th>Batch Code</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            @if($intakedetail->count() > 0)
                                                @foreach($intakedetail as $data)
                                                    <tbody>
                                                    <td>{{$data->intake_programme}}</td>
                                                    <td>{{$data->intake_programme_description}}</td>
                                                    <td>{{$data->intake_type}}</td>
                                                    <td>{{$data->intake_date}}</td>
                                                    <td>{{$data->intake_time}}</td>
                                                    <td>{{$data->intake_venue}}</td>
                                                    <td>{{$data->batch_code}}</td>
                                                    <td>
                                                        {{-- <a class="btn btn-danger delete" href="javascript:;">Delete</a> --}}
                                                    </td>
                                                    </tbody>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn btn-primary" href="{{ route('intake.index') }}"> Save</a>
                                    </div>
                                </div>
                            </table>
                            <div class="modal fade" id="crud-modal" aria-hidden="true" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"> Add Program Info</h4>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['action' => 'IntakeController@createProgramInfo', 'method' => 'POST']) !!}
                                            <input name="intake_code" value="{{$intake_code}}" hidden>
                                            <div class="form-group">
                                                {{Form::label('title', 'Program Code')}}
                                                {{Form::text('intake_programme', '', ['class' => 'form-control', 'placeholder' => 'Program Code', 'required'])}}
                                            </div>
                                            <div class="form-group">
                                                {{Form::label('title', 'Intake Description')}}
                                                {{Form::text('intake_programme_description', '', ['class' => 'form-control', 'placeholder' => 'Intake Description', 'required'])}}
                                            </div>
                                            <div class="form-group">
                                                {{Form::label('title', 'Batch Code')}}
                                                {{Form::text('batch_code', '', ['class' => 'form-control', 'placeholder' => 'Batch Code', 'required'])}}
                                            </div>
                                            <div class="form-group">
                                                {{Form::label('title', 'Intake Type')}}
                                                {{Form::text('intake_type', '', ['class' => 'form-control', 'placeholder' => 'Intake Type', 'required'])}}
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-6">
                                                    {{Form::label('title', 'Intake Date')}}
                                                    {{Form::date('intake_date', '', ['class' => 'form-control', 'placeholder' => 'Intake Date', 'required'])}}
                                                </div>
                                                <div class="col-md-6">
                                                    {{Form::label('title', 'Intake Time')}}
                                                    {{Form::time('intake_time', '', ['class' => 'form-control', 'placeholder' => 'Intake Time', 'required'])}}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                {{Form::label('title', 'Intake Venue')}}
                                                {{Form::text('intake_venue', '', ['class' => 'form-control', 'placeholder' => 'Intake Venue', 'required'])}}
                                            </div>
                                            <div class="pull-right">
                                                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script type="text/javascript">
        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });
    </script>
@endsection