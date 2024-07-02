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
                              {!! Form::open(['action' => 'Space\BookingManagementController@store', 'method' => 'POST']) !!}
                                  <div>
                                      <div class="table-responsive">
                                        <p style="font-style: italic"><span class="text-danger">*</span> Required Fields</p>
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"> Staff / Student :</label></td>
                                                        <td colspan="6">
                                                          <select class="form-control" name="user_id" id="user_id">
                                                            <option disabled selected>Please Select</option>
                                                            @foreach($user as $users)
                                                            <option value="{{ $users->id }}" {{ old('user_id') ==  $users->id  ? 'selected' : '' }}>[{{ $users->id }}] {{ $users->name }}</option>
                                                            @endforeach
                                                          </select>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                  <div class="form-group">
                                                      <td width="20%" style="vertical-align: middle"><label class="form-label"> Office No :</label></td>
                                                      <td colspan="3">
                                                          <input type="text" class="form-control" name="office_no" value="{{ old('office_no') }}">
                                                      </td>
                                                      <td width="20%" style="vertical-align: middle"><span class="text-danger">*</span> <label class="form-label"> H/P :</label></td>
                                                      <td colspan="3">
                                                        <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                                                      </td>
                                                  </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Purpose :</label></td>
                                                        <td colspan="6">
                                                          <input type="text" class="form-control" name="purpose" value="{{ old('purpose') }}">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Number of User :</label></td>
                                                        <td colspan="6">
                                                          <input type="number" class="form-control" name="no_user" value="{{ old('no_user') }}">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                                                          
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Date :</label></td>
                                                        <td colspan="3">
                                                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> Start Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}">
                                                        </td>
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label"><span class="text-danger">*</span> End Time :</label></td>
                                                        <td colspan="3">
                                                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}">
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
                                                                    <div class="custom-control custom-checkbox custom-control-inline custom-checkbox-circle">
                                                                      <input type="checkbox" class="custom-control-input" id="defaultInline{{ $venues['id'] }}" name="venue[{{ $venues['id'] }}]">
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
                                                          <div class="alert alert-info" role="alert">
                                                            <strong>Note:</strong>
                                                            <ul>
                                                              <li><strong>Lab B: </strong> PA System, LCD(1), Microphone (2)</li>
                                                              <li><strong>Lab C: </strong> LCD, Microphone Portable</li>
                                                              <li><strong>Dewan Seminar: </strong> PA System, Microphone (2), LCD</li>
                                                              <li><strong>Discussion Room: </strong> TV</li>
                                                              <li><strong>Gallery & Reading Room: </strong>TV. The use of PA systems, LCD, microphone can be requested at Unit Majlis INTEC</li>
                                                            </ul>
                                                            <b>
                                                              Additional PA systems or changing the layout of the space can be requested at Unit Majlis INTEC.
                                                            </b>
                                                          </div>
                                                          <div class="frame-wrap">
                                                            @php
                                                              $item_per_line = 1;
                                                              $item_array = $item->toArray();
                                                              $item_count = count($item_array);
                                                            @endphp
                                                          
                                                            @for ($i = 0; $i < $item_count; $i += $item_per_line)
                                                              <div class="row mb-2">
                                                                @foreach(array_slice($item_array, $i, $item_per_line) as $items)
                                                                  <div class="col-md-12">
                                                                    <label>
                                                                        <input type="checkbox" name="checks[{{ $items['id'] }}]" onchange="toggleInput(this)">
                                                                    </label>
                                                                    <label>{{ $items['name'] }}</label>
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
                                                        <td width="20%" style="vertical-align: middle"><label class="form-label">Remark :</label></td>
                                                        <td colspan="5">
                                                          <input type="text" class="form-control" id="remark" name="remark" value="{{ old('remark') }}">
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
  $('#user_id').select2();
  function checkLimit(ele)
  {
      var max = parseFloat($(ele).data('max'));
      var input = parseFloat($(ele).val());

      if(input > max)
      {
          alert('More than limit');
          $(ele).val(0);
      }
  }
  function toggleInput(checkbox) 
  {
    var inputField = checkbox.parentNode.parentNode.nextElementSibling.querySelector('input[type="number"]');
    
    if (checkbox.checked) {
        inputField.removeAttribute('disabled');
    } else {
        inputField.setAttribute('disabled', 'disabled');
        inputField.value = '';
    }
  }
</script>
@endsection

