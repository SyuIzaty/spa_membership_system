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
                            <table class="table table-bordered">
                                <div class="card-body">
                                    {!! Form::open(['action' => 'ApplicantController@store', 'method' => 'POST']) !!}
                                    <input type="hidden" name="applicant_id" value="{{ $applicant['id'] }}">
                                        <div class="form-group">
                                            {{Form::label('title', 'Intake Code')}}
                                            <select class="form-control" name="applicant_status">
                                                @foreach ($status as $statuses)
                                                <option value="{{ $statuses->status_code }}" {{ $applicant->applicant_status == $statuses->status_code ? 'selected="selected"' : ''}}>{{ $statuses->status_description }}</option>
                                                @endforeach
                                            </select>
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
