@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                        <h4 style="text-align: center">
                            <b>ROOM & SPACE REQUEST FORM</b>
                        </h4>

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
                              {!! Form::open(['action' => ['Space\BookingManagementController@update',$main->id], 'method' => 'PATCH']) !!}
                                  <div>
                                      <div class="table-responsive">
                                        <p style="font-style: italic"><span class="text-danger">*</span> Required Fields</p>
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Full Name :</label></td>
                                                        <td colspan="3">
                                                            {{ $main->spaceBookingMain->staff->staff_name ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Staff ID :</label></td>
                                                        <td colspan="3">
                                                            {{ $main->spaceBookingMain->staff_id ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Position :</label></td>
                                                        <td colspan="3">
                                                            {{ $main->spaceBookingMain->staff->staff_position ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Department :</label></td>
                                                        <td colspan="3">
                                                            {{ $main->spaceBookingMain->staff->staff_dept ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Purpose :</label></td>
                                                        <td colspan="6">
                                                          <input type="text" class="form-control" name="purpose" 
                                                          value="{{ isset($main->spaceBookingMain->purpose) ? $main->spaceBookingMain->purpose : '' }}" disabled>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                                            value="{{ isset($main->spaceBookingMain->start_date) ? $main->spaceBookingMain->start_date : '' }}" disabled>
                                                          
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                                            value="{{ isset($main->spaceBookingMain->end_date) ? $main->spaceBookingMain->end_date : '' }}" disabled>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="start_time" name="start_time" 
                                                            value="{{ isset($main->spaceBookingMain->start_time) ? $main->spaceBookingMain->start_time : '' }}" disabled>
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="end_time" name="end_time" 
                                                            value="{{ isset($main->spaceBookingMain->end_time) ? $main->spaceBookingMain->end_time : '' }}" disabled>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Venue :</label></td>
                                                        <td colspan="5">{{ $main->spaceVenue->name }}</td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Requirement :</label></td>
                                                        <td colspan="5">
                                                          @foreach($main->spaceBookingItems as $item)
                                                          <ul>
                                                            <li>{{ isset($item->spaceItem->name) ? $item->spaceItem->name : '' }} <span class="text-danger font-weight-bold">({{ $item->unit }} UNIT)</span></li>
                                                          </ul>
                                                          @endforeach
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                  <div class="form-group">
                                                      <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Status :</label></td>
                                                      <td colspan="6">
                                                        <select class="form-control" name="application_status" id="application_status">
                                                          <option disabled selected>Please Select</option>
                                                          @foreach($status as $statuses)
                                                          <option value="{{ $statuses->id }}" {{ ($main->application_status == $statuses->id) ? 'selected' : '' }}>{{ $statuses->name }}</option>
                                                          @endforeach
                                                        </select>
                                                      </td>
                                                  </div>
                                              </tr>
                                            </thead>
                                        </table>                          
                                      </div>
                                  </div>
                                  <div class="footer">
                                      <button type="submit" id="btnSubmit" class="btn btn-success ml-auto float-right mb-3"><i class="fal fa-location-arrow"></i> Submit</button>
                                  </div>
                              {!! Form::close() !!}
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
<script>
  $('#application_status').select2();
</script>
@endsection

