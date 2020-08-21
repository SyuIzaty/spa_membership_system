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
                        <h2>Edit Intake</h2>
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
                            <div class="card-body">
                                {!! Form::open(['action' => ['IntakeController@update', $intake['id']], 'method' => 'POST'])!!}
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Intake Code')}}
                                            {{Form::text('intake_code', $intake->intake_code, ['class' => 'form-control', 'placeholder' => 'Intake Code'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Intake Description')}}
                                            {{Form::text('intake_description', $intake->intake_description, ['class' => 'form-control', 'placeholder' => 'Intake Description'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Start Application Date')}}
                                            {{Form::date('intake_app_open', $intake->intake_app_open, ['class' => 'form-control', 'placeholder' => 'Start Application Date'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Close Application Date')}}
                                            {{Form::date('intake_app_close', $intake->intake_app_close, ['class' => 'form-control', 'placeholder' => 'Close Application Date'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Application Status Start Date')}}
                                            {{Form::date('intake_check_open', $intake->intake_app_open, ['class' => 'form-control', 'placeholder' => 'Start Application Date'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Application Status End Date')}}
                                            {{Form::date('intake_check_close', $intake->intake_app_close, ['class' => 'form-control', 'placeholder' => 'Close Application Date'])}}
                                        </div>
                                    </div>
                                    {{Form::hidden('_method', 'PUT')}}
                                    {{Form::submit('Submit')}}
                                {!! Form::close() !!}
                            <div class="card-body">
                            <div class="form-group">
                                <a class="btn btn-info pull-right" href="javascript:;" data-toggle="modal" id="new">Add Program Info</a>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Programme Code</td>
                                        <td>Programme Name</td>
                                        <td>Intake Date</td>
                                        <td>Intake Time</td>
                                        <td>Intake Venue</td>
                                        <td>Intake Type</td>
                                        <td>Batch Code</td>
                                        <td>Status</td>
                                        <td>Action</td>
                                    </tr>
                                    @foreach($intake_detail as $intake_del)
                                    <tr>
                                        <td>{{$intake_del->programme->programme_code}}</td>
                                        <td>{{$intake_del->programme->programme_name}}</td>
                                        <td>{{$intake_del->intake_date}}</td>
                                        <td>{{$intake_del->intake_time}}</td>
                                        <td>{{$intake_del->intake_venue}}</td>
                                        <td>{{$intake_del->intakeType->intake_type_code}}</td>
                                        <td>{{$intake_del->batch_code}}</td>
                                        <td>@if($intake_del->status== '1')
                                                <p>Active</p>
                                            @else
                                                <p>Inactive</p>
                                            @endif</td>
                                        <td>
                                            <button class="btn btn-danger deleteProgram" data-id="{{$intake_del->id}}" data-action="{{route('deleteProgramInfo', $intake_del->id)}}">Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="crud-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Add Program Info</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'IntakeController@createProgramInfo', 'method' => 'POST']) !!}
                        <input name="intake_code" value="{{$intake->id}}" hidden>
                        <div class="form-group">
                            {{Form::label('title', 'Program Code')}}
                            <select name="intake_programme" id="intake_code" class="form-control">
                                @foreach($programme as $programmes)
                                  <option value="{{ $programmes->id }}">{{ $programmes->programme_code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Intake Description')}}
                            {{Form::text('intake_programme_description', '', ['class' => 'form-control', 'placeholder' => 'Intake Description'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Batch Code')}}
                            {{Form::text('batch_code', '', ['class' => 'form-control', 'placeholder' => 'Batch Code', 'required'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Intake Type')}}
                            <select name="intake_type" id="intake_type" class="form-control">
                                @foreach($intake_type as $intaketype)
                                  <option value="{{ $intaketype->id }}">{{ $intaketype->intake_type_code }}</option>
                                @endforeach
                            </select>
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
    </main>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
         $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $(document).on('click', '.deleteProgram', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = '{{route("deleteProgramInfo", "id")}}';
            url = url.replace('id', id );
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function () {
                            Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            })
        });
    </script>
@endsection
