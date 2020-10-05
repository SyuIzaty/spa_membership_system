@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Batch
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Create Batch</h2>
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
                                    <div class="row">
                                        {!! Form::open(['action' => 'BatchController@store', 'method' => 'POST']) !!}
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Batch Code')}}
                                            {{Form::text('batch_code', '', ['class' => 'form-control', 'placeholder' => 'Batch Code'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('title', 'Batch Name') }}
                                            {{ Form::text('batch_name', '', ['class' => 'form-control', 'placeholder' => 'Batch Name']) }}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Batch Description')}}
                                            {{Form::text('batch_description', '', ['class' => 'form-control', 'placeholder' => 'Batch Description'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('title', 'Status') }}
                                            <select class="form-control status" name="status" id="status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            {{ Form::label('title', 'Programme') }}
                                            <select class="form-control programme" name="programme_code" id="programme_code">
                                                @foreach ($programme as $programmes)
                                                    <option value="{{ $programmes->programme_code }}">{{ $programmes->programme_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="btn btn-primary">Submit</button>
                                    {!! Form::close() !!}
                                    </div>
                                </div>
                            </table>
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
            $('.status, .programme').select2();
        });
    </script>
@endsection
