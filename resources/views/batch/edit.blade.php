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
                        <h2>Edit Batch</h2>
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
                                {!! Form::open(['action' => ['BatchController@update', $batch['id']], 'method' => 'POST'])!!}
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Batch Code')}}
                                            {{Form::text('batch_code', $batch->batch_code, ['class' => 'form-control', 'placeholder' => 'Batch Code'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('title', 'Batch Name') }}
                                            {{ Form::text('batch_name', $batch->batch_name, ['class' => 'form-control', 'placeholder' => 'Batch Name']) }}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Batch Description')}}
                                            {{Form::text('batch_description', $batch->batch_description, ['class' => 'form-control', 'placeholder' => 'Batch Description'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{ Form::label('title', 'Batch Status') }}
                                            <select class="form-control status" name="status" id="status">
                                                @if ($batch->status == '1')
                                                    <option value="{{ $batch->status }}">Active</option>
                                                    <option value="0">Inactive</option>
                                                @else
                                                    <option value="{{ $batch->status }}">Inactive</option>
                                                    <option value="1">Active</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            {{ Form::label('title', 'Program') }}
                                            <select class="form-control programme" name="programme_code" id="programme_code" >
                                                @foreach($programme as $programmes)
                                                    <option value="{{$programmes->programme_code}}"  {{ $batch->programme_code == $programmes->programme_code ? 'selected="selected"' : '' }}>{{$programmes->programme_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{Form::hidden('_method', 'PUT')}}
                                    <button class="btn btn-primary mt-3">Submit</button>
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
        $('.status, .programme').select2();
    });

</script>
@endsection
