@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Task Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Task Calendar</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                          <div class="col-md-12">
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
                            <div id="calendar"></div>

                            <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="eventModalLabel">Unavailable Date</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                        <ul class="nav nav-tabs nav-fill" role="tablist">
                                          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#new_time" role="tab">New Time</a></li>
                                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#list_time" role="tab">List</a></li>
                                        </ul>
                                        <div class="tab-content">
                                          <div class="tab-pane fade show active" id="new_time" role="tabpanel">
                                            {!! Form::open(['action' => 'Task\TaskManagement\TaskCalendarController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden" name="type_store" value="solo">
                                            <input type="hidden" name="unavailable_dates" id="unavailable_dates">
                                            <table class="table table-bordered">
                                              <tr>
                                                <td>Counsellor <span class="text-danger">*</span></td>
                                                <td>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Date</td>
                                                <td><span id="unavailable_date"></span></td>
                                              </tr>
                                              <tr>
                                                <td>Start Time</td>
                                                <td><input type="time" class="form-control" name="start_time"></td>
                                              </tr>
                                              <tr>
                                                <td>End Time</td>
                                                <td><input type="time" class="form-control" name="end_time"></td>
                                              </tr>
                                              <tr>
                                                <td colspan="3">
                                                  <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="all_day">
                                                    <label class="custom-control-label" for="customSwitch1">All Day?</label>
                                                  </div>
                                                </td>
                                              </tr>
                                            </table>
                                            <button type="submit" class="btn btn-success float-right">Submit</button>
                                            {!! Form::close() !!}
                                          </div>
                                          <div class="tab-pane fade" id="list_time" role="tabpanel">
                                            <table class="table table-bordered list-block">
                                          
                                            </table>
                                          </div>
                                        </div>
                                      </div>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
@endsection
