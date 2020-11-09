@extends('layouts.applicant')
@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center">
                    <div class="p-2">
                        <img src="{{ asset('img/intec_logo.png') }}" class="responsive"/>
                    </div>
                </div>
            </div>
            <hr class="mb-2 mt-3">
            <div class="card-body">
                {!! Form::open(['action' => 'RegistrationController@store', 'method' => 'POST']) !!}
                <div class="row">
                    <input type="hidden" name="applicant_status" value="00">
                    <div class="form-group col-md-8">
                        {{-- @foreach ($intake as $intakes)
                            <input type="hidden" value="{{ $intakes->id }}" name="intake_id">
                        @endforeach --}}
                        <input type="hidden" value="{{ $intake->first()->id }}" name="intake_id">
                        <input type="hidden" value="Private" name="sponsor_code">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                        {{Form::label('title', 'Name')}}
                        {{Form::text('applicant_name', '', ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                        @error('applicant_name')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('title', 'IC Number / Passport') }}
                        {{ Form::text('applicant_ic', '', ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'placeholder' => 'Eg: 991023106960']) }}
                        @error('applicant_ic')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('title', 'Phone Number') }}
                        {{ Form::text('applicant_phone', '', ['class' => 'form-control', 'placeholder' => 'Applicant Phone']) }}
                        @error('applicant_phone')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('title', 'Email') }}
                        {{ Form::email('applicant_email', '', ['class' => 'form-control', 'placeholder' => 'Applicant Email']) }}
                        @error('applicant_email')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        {{ Form::label('title', 'Nationality') }}
                        <select class="form-control nationality" name="applicant_nationality" id="applicant_nationality" >
                            @foreach($country as $countries)
                            <option value="{{ $countries->country_code }}" {{ $countries->isDefault == 1 ? 'selected="Selected"' : ''}}>{{ $countries->country_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <h4>Preferred Programme</h4>
                    </div>
                    <div class="col-md-6 form-group">
                        {{ Form::label('title', '1st Preferred Programme (Required)') }}
                        <select class="form-control programme1" name="applicant_programme" id="applicant_programme">
                            <option value="">Select Programme</option>
                            {{-- @foreach($programme->intakeDetails as $programmes)
                                <option value="{{$programmes->programme->programme_code}}">{{$programmes->programme->programme_name}}</option>
                            @endforeach --}}
                            {{-- @foreach ($all_programme as $programmes)
                                @foreach ($programmes->intakeDetails as $prog_list)
                                    <option value="{{ $prog_list->programme->programme_code }}">{{ $prog_list->programme->programme_code }}</option>
                                @endforeach
                            @endforeach --}}
                            @foreach ($all_programme as $key => $programmes)
                                <option value="{{ $programmes['Code'] }}">{{ $programmes['Name'] }} ({{ $programmes['Code'] }})</option>
                            @endforeach
                        </select>
                        @error('applicant_programme')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        {{ Form::label('Major', 'Major') }}
                        <select class="form-control major1" name="applicant_major" id="applicant_major">
                        </select>
                        @error('applicant_major')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        {{ Form::label('Study Mode', 'Study Mode') }}
                        <select class="form-control mode1" name="applicant_mode" id="applicant_mode">
                        </select>
                        @error('applicant_mode')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        {{ Form::label('title', '2nd Preferred Programme (Optional)') }}
                        <select class="form-control programme2" name="applicant_programme_2" id="applicant_programme_2">
                            <option value="">Select Programme</option>
                            @foreach ($all_programme as $key => $programmes)
                                <option value="{{ $programmes['Code'] }}">{{ $programmes['Name'] }} ({{ $programmes['Code'] }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        {{ Form::label('Major', 'Major') }}
                        <select class="form-control major2" name="applicant_major_2" id="applicant_major_2">
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        {{ Form::label('Study Mode', 'Study Mode') }}
                        <select class="form-control mode2" name="applicant_mode_2" id="applicant_mode_2">
                        </select>
                        @error('applicant_mode_2')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        {{ Form::label('title', '3rd Preferred Programme (Optional)') }}
                        <select class="form-control programme3" name="applicant_programme_3" id="applicant_programme_3">
                            <option value="">Select Programme</option>
                            @foreach ($all_programme as $key => $programmes)
                                <option value="{{ $programmes['Code'] }}">{{ $programmes['Name'] }} ({{ $programmes['Code'] }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        {{ Form::label('Major', 'Major') }}
                        <select class="form-control major3" name="applicant_major_3" id="applicant_major_3">
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        {{ Form::label('Study Mode', 'Study Mode') }}
                        <select class="form-control mode3" name="applicant_mode_3" id="applicant_mode_3">
                        </select>
                        @error('applicant_mode_3')
                            <p style="color: red">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary float-right"><i class="fal fa-check"></i> Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.nationality, .programme1, .major1, .programme2, .major2, .major3, .programme3, .mode1, .mode2, .mode3').select2();
        });

        $(document).ready(function() {
            $('#applicant_programme').on('change', function() {
                var programme_1 = $(this).val();
                if(programme_1) {
                    $.ajax({
                        url: '/registration-data/'+programme_1,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#applicant_major').empty();
                                $('#applicant_major').focus;
                                $.each(data, function(key, value){
                                    $('select[name="applicant_major"]').append('<option value="'+ value.major_code +'">' + value.major_name + '</option>');
                                });
                            }else{
                                $('#applicant_major').empty();
                            }
                        }
                    });
                }else{
                $('#applicant_major').empty();
                }
            });

            $('#applicant_programme').on('change', function() {
                var programme_1 = $(this).val();
                if(programme_1) {
                    $.ajax({
                        url: '/registration-mode/'+programme_1,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#applicant_mode').empty();
                                $('#applicant_mode').focus;
                                $.each(data, function(key, value){
                                    $('select[name="applicant_mode"]').append('<option value="'+ value.id +'">' + value.mode_name + '</option>');
                                });
                            }else{
                                $('#applicant_mode').empty();
                            }
                        }
                    });
                }else{
                $('#applicant_mode').empty();
                }
            });

            $('#applicant_programme_2').on('change', function() {
                var programme_2 = $(this).val();
                if(programme_2) {
                    $.ajax({
                        url: '/registration-data/'+programme_2,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#applicant_major_2').empty();
                                $('#applicant_major_2').focus;
                                // $('#applicant_major_2').append('<option value="">Select Major</option>');
                                $.each(data, function(key, value){
                                    $('select[name="applicant_major_2"]').append('<option value="'+ value.major_code +'">' + value.major_name + '</option>');
                                });
                            }else{
                                $('#applicant_major_2').empty();
                            }
                        }
                    });
                }else{
                $('#applicant_major_2').empty();
                }
            });

            $('#applicant_programme_2').on('change', function() {
                var programme_1 = $(this).val();
                if(programme_1) {
                    $.ajax({
                        url: '/registration-mode/'+programme_1,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#applicant_mode_2').empty();
                                $('#applicant_mode_2').focus;
                                $.each(data, function(key, value){
                                    $('select[name="applicant_mode_2"]').append('<option value="'+ value.id +'">' + value.mode_name + '</option>');
                                });
                            }else{
                                $('#applicant_mode_2').empty();
                            }
                        }
                    });
                }else{
                $('#applicant_mode_2').empty();
                }
            });

            $('#applicant_programme_3').on('change', function() {
                var programme_3 = $(this).val();
                if(programme_3) {
                    $.ajax({
                        url: '/registration-data/'+programme_3,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#applicant_major_3').empty();
                                $('#applicant_major_3').focus;
                                $.each(data, function(key, value){
                                    $('select[name="applicant_major_3"]').append('<option value="'+ value.major_code +'">' + value.major_name + '</option>');
                                });
                            }else{
                                $('#applicant_major_3').empty();
                            }
                        }
                    });
                }else{
                $('#applicant_major_3').empty();
                }
            });

            $('#applicant_programme_3').on('change', function() {
                var programme_1 = $(this).val();
                if(programme_1) {
                    $.ajax({
                        url: '/registration-mode/'+programme_1,
                        type: "GET",
                        data : {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data) {
                            console.log(data);
                            if(data){
                                $('#applicant_mode_3').empty();
                                $('#applicant_mode_3').focus;
                                $.each(data, function(key, value){
                                    $('select[name="applicant_mode_3"]').append('<option value="'+ value.id +'">' + value.mode_name + '</option>');
                                });
                            }else{
                                $('#applicant_mode_3').empty();
                            }
                        }
                    });
                }else{
                $('#applicant_mode_3').empty();
                }
            });
        });
    </script>
@endsection
