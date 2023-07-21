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
                              @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                              @endif
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
                              @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                              @endif
                              {!! Form::open(['action' => ['Space\BookingController@update',$main->id], 'method' => 'PATCH']) !!}
                                  <div>
                                      <div class="table-responsive">
                                        <p style="font-style: italic"><span class="text-danger">*</span> Required Fields</p>
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Full Name :</label></td>
                                                        <td colspan="3">
                                                            {{ $user->name ?? '--'}}
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Staff / Student ID :</label></td>
                                                        <td colspan="3">
                                                            {{ $user->id ?? '--'}}
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Department :</label></td>
                                                        <td colspan="5">
                                                            @if($user->category == 'STF')
                                                              {{ isset($user->staff->staff_dept) ? $user->staff->staff_dept : '--' }}
                                                            @endif
                                                            @if($user->category == 'STD')
                                                              {{ isset($user->student->students_programme) ? $user->student->students_programme : '--' }}
                                                            @endif
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Office No :</label></td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control" name="office_no" value="{{ isset($main->spaceBookingMain->user_office) ? $main->spaceBookingMain->user_office : '' }}">
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><span class="text-danger">*</span> <label class="form-label"> H/P :</label></td>
                                                        <td colspan="3">
                                                            <input type="text" class="form-control" name="phone_number" value="{{ isset($main->spaceBookingMain->user_phone) ? $main->spaceBookingMain->user_phone : '' }}">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Purpose :</label></td>
                                                        <td colspan="6">
                                                          <input type="text" class="form-control" name="purpose" value="{{ isset($main->spaceBookingMain->purpose) ? $main->spaceBookingMain->purpose : '' }}">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                                            value="{{ isset($main->spaceBookingMain->start_date) ? $main->spaceBookingMain->start_date : '' }}" required>
                                                          
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                                            value="{{ isset($main->spaceBookingMain->end_date) ? $main->spaceBookingMain->end_date : '' }}" required>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="start_time" name="start_time" 
                                                            value="{{ isset($main->spaceBookingMain->start_time) ? $main->spaceBookingMain->start_time : '' }}" required>
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="end_time" name="end_time" 
                                                            value="{{ isset($main->spaceBookingMain->end_time) ? $main->spaceBookingMain->end_time : '' }}" required>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Venue :</label></td>
                                                        <td colspan="5">
                                                          <div class="frame-wrap">
                                                            @php
                                                              $input_per_line = 3;
                                                              $venue_array = $venue->toArray();
                                                              $venue_count = count($venue_array);
                                                            @endphp
                                                          
                                                            @for ($i = 0; $i < $venue_count; $i += $input_per_line)
                                                            <div class="row mb-2">
                                                              @foreach(array_slice($venue_array, $i, $input_per_line) as $venues)
                                                                  <div class="col">
                                                                      <div class="custom-control custom-radio custom-control-inline custom-checkbox-circle">
                                                                          <input type="radio" class="custom-control-input" id="defaultInline{{ $venues['id'] }}" name="venue" value="{{ $venues['id'] }}"
                                                                          {{ ($venues['id'] == $main->venue_id) ? 'checked' : '' }}>
                                                                          <label class="custom-control-label" for="defaultInline{{ $venues['id'] }}">
                                                                              {{ $venues['name'] }} <span class="text-danger font-weight-bold">({{ $venues['maximum'] }} MAX)</span>
                                                                          </label>
                                                                      </div>
                                                                  </div>
                                                              @endforeach
                                                            </div>
                                                            @endfor
                                                          </div>
                                                          
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label">Requirement :</label></td>
                                                        <td colspan="5">
                                                          <div class="frame-wrap">
                                                            @php
                                                              $item_per_line = 1;
                                                              $item_array = $item->toArray();
                                                              $item_count = count($item_array);
                                                            @endphp
                                                          
                                                            @for ($i = 0; $i < $item_count; $i += $item_per_line)
                                                              <div class="row mb-2">
                                                                @foreach(array_slice($item_array, $i, $item_per_line) as $items)
                                                                  <div class="col-md-4">
                                                                    <label>{{ $items['name'] }}</label>
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                    <input type="text" class="form-control" name="unit[{{ $items['id'] }}]" value="{{ isset($main->spaceBookingItems->where('item_id',$items['id'])->first()->unit) ? $main->spaceBookingItems->where('item_id',$items['id'])->first()->unit : '' }}">
                                                                  </div>
                                                                  <div class="col-md-4">
                                                                    <span class="text-danger font-weight-bold">UNITS</span>
                                                                  </div>
                                                                @endforeach
                                                              </div>
                                                            @endfor
                                                          </div>
                                                          
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
@endsection

