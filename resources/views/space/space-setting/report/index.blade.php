@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Space Setting
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Room</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                          {!! Form::open(['action' => 'Space\SpaceSetting\ReportController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                          <div class="row">
                            <div class="col-md-4">
                              <p>Block</p>
                              <select class="form-control selectfilter" id="block_id" name="block_id">
                                <option disabled selected>Please Select</option>
                                @foreach($block as $blocks)
                                <option value="{{ $blocks->id }}">{{ $blocks->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4">
                              <p>Open / Closed</p>
                              <select class="form-control selectfilter" id="status_id" name="status_id">
                                <option disabled selected>Please Select</option>
                                <option value="9">Open</option>
                                <option value="10">Closed</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <p>Room Type</p>
                              <select class="form-control selectfilter" id="room_type" name="room_type">
                                <option disabled selected>Please Select</option>
                                @foreach($type as $types)
                                <option value="{{ $types->id }}">{{ $types->name }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                          <button class="btn btn-success btn-sm float-right mt-2 mb-2">Submit</button>
                          {!! Form::close() !!}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script >
  $('.selectfilter').select2();
</script>
@endsection
