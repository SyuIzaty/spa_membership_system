@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Applicant
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Applicant</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            {!! Form::open(['action' => 'ApplicantController@export', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Intake') }}
                                    <select class="form-control" name="intake" id="intake" >
                                        <option value="">Select Intake</option>
                                        @foreach($intake as $intakes)
                                            <option value="{{$intakes->id}}">{{$intakes->intake_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Batch') }}
                                    <select class="form-control" name="batch" id="batch" >
                                        <option value="">Select Batch</option>
                                        @foreach($batch as $batches)
                                            <option value="{{$batches->batch_code}}">{{$batches->batch_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Programme') }}
                                    <select class="form-control" name="programme" id="programme" >
                                        <option value="">Select Programme</option>
                                        @foreach($programme as $programmes)
                                            <option value="{{$programmes->programme_code}}">{{$programmes->programme_code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    {{ Form::label('title', 'Status') }}
                                    <select class="form-control" name="status" id="status" >
                                        <option value="">Select Status</option>
                                        @foreach($status as $statuses)
                                            <option value="{{$statuses->status_code}}">{{$statuses->status_description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Export</button>
                            </div>
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

</script>
@endsection
