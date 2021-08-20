@extends('layouts.covid')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    {{-- <div class="card-header" style="background-image: url({{asset('img/coronavirus.png')}}); background-size: cover"> --}}
                    <div class="card-header">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo.png') }}" style="max-width: 100%"
                                        class="responsive" /></center><br>
                                <h4 style="text-align: center">
                                    <b>INTEC EDUCATION COLLEGE EVENT EVALUATION FORM</b>
                                </h4>
                                {{-- <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : All staff, student and visitor are required to make a daily declaration of COVID-19 risk screening on every working day (whether working in the office or from home) as prevention measures.
                                However, you are encouraged to make a declaration on a daily basis including public holidays and other holidays.
                            </p> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'CovidController@storeOpenForm', 'method' => 'POST']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" class="form-control participant_id" id="participant_id"
                                    name="participant_id">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i
                                            class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('notification'))
                                    <div class="alert alert-success" style="color: #5b0303; background-color: #ff6c6cc9;">
                                        <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}
                                    </div>
                                @endif
                                <div>
                                    <div class="table-responsive">
                                        <p><span class="text-danger">*</span> Required fields</p>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr class="all">
                                                    <td width="20%"><label class="form-label" for="user_name"><span
                                                                class="text-danger">*</span> Event Name </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control intec" id="user_name" name="user_name"
                                                            readonly>
                                                        @error('user_name')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="all">
                                                    <td width="20%"><label class="form-label" for="user_name"><span
                                                                class="text-danger">*</span> Date </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control intec" id="user_name" name="user_name"
                                                            readonly>
                                                        @error('user_name')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <th style="text-align: center" width="4%"><label class="form-label"
                                                            for="qHeader">NO.</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">FEEDBACK LIST</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">1</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">2</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">3</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">4</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">5</label></th>
                                                </div>
                                            </tr>
                                            @foreach ($sections as $section)
                                                <tr class="bg-primary text-white">
                                                    <td colspan="7">{{ $section->name }}</td>
                                                </tr>
                                                @foreach ($section->questions as $question)
                                                    <tr class="q1">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label
                                                                    for="q1">{{ $loop->index + 1 }}.</label>
                                                            </td>
                                                            <td width="60%;"><label for="q1">{{ $question->question }}
                                                                </label>@error('q1')<b style="color: red"><strong> required
                                                                    </strong></b>@enderror
                                                            </td>
                                                            @if ($question->question_type == 'RATE')
                                                                <td style="text-align: center"><input type="radio" name="q1"
                                                                        id="q1" value="1"
                                                                        {{ old('q1') && old('q1') == '1' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio" name="q1"
                                                                        id="q1" value="2"
                                                                        {{ old('q1') && old('q1') == '2' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio" name="q1"
                                                                        id="q1" value="3"
                                                                        {{ old('q1') && old('q1') == '3' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio" name="q1"
                                                                        id="q1" value="4"
                                                                        {{ old('q1') && old('q1') == '4' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio" name="q1"
                                                                        id="q1" value="5"
                                                                        {{ old('q1') && old('q1') == '5' ? 'checked' : '' }}>
                                                                </td>
                                                            @elseif($question->question_type == 'TEXT')
                                                                <td colspan="6">{!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Answer', 'id' => 'description']) !!}</td>
                                                            @endif
                                                        </div>
                                                    </tr>
                                                @endforeach

                                            @endforeach
                                            {{-- <tr>
                                                <div class="form-group">
                                                    <td colspan="7"><label class="form-label" for="confirmation">
                                                    <button style="margin-top: 5px;" class="btn btn-primary float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Submit Feedback</button></td>
                                                </div>
                                            </tr> --}}

                                        </thead>
                                    </table>

                                    <button style="margin-top: 5px;" class="btn btn-primary float-right mb-2 mr-2" id="submit" name="submit"><i class="fal fa-check"></i> Submit Feedback</button>
                                </div>

                                {!! Form::close() !!}
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
        $(document).ready(function() {

            if ($('.user_id').val() != '') {
                updateCr($('.user_id'));
            }
            $(document).on('change', '.user_id', function() {
                updateCr($(this));
            });

            function updateCr(elem) {
                var user_id = elem.val();

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('findUser') !!}',
                    data: {
                        'id': user_id
                    },
                    success: function(data) {
                        $('#user_id').html(data.id);
                        $('#user_name').val(data.name);
                        $('#name').val(data.name);
                        $('#user_email').val(data.email);
                        $('#email').val(data.email);
                    }
                });
            }

            $("input[name=q1]").change(function() {
                if ($(this).val() == "Y") {
                    $(".q2").hide();
                    $(".q3").hide();
                    $(".q4").hide();
                    $(".declare_date2").hide();
                    $(".declare_date1").show();
                } else {
                    $(".q2").show();
                    $(".declare_date1").hide();
                }
            });

            $("input[name=q2]").change(function() {
                if ($(this).val() == "Y") {
                    $(".q3").hide();
                    $(".q4").hide();
                    $(".declare_date1").hide();
                    $(".declare_date2").show();
                } else {
                    $(".q3").show();
                    $(".declare_date2").hide();
                }
            });

            $("input[name=q3]").change(function() {
                if ($(this).val() == "Y") {
                    $(".q4").hide();
                } else {
                    $(".q4").show();
                }
            });


            $(".select-depart").hide();

            $("#user_category").change(function() {
                var val = $("#user_category").val();
                if (val == "WFO") {
                    $(".select-depart").show();
                } else {
                    $(".select-depart").hide();
                }
            });


            $(".intec").hide();

            $("#user_position").change(function() {
                var val = $("#user_position").val();
                if (val == "STF" || val == "STD") {
                    $(".intec").show();
                } else {
                    $(".intec").hide();
                }
            });

            $(".visitor").hide();

            $("#user_position").change(function() {
                var val = $("#user_position").val();
                if (val == "VSR") {
                    $(".visitor").show();
                } else {
                    $(".visitor").hide();
                }
            });

            $(".intecStf").hide();

            $("#user_position").change(function() {
                var val = $("#user_position").val();
                if (val == "STF") {
                    $(".intecStf").show();
                } else {
                    $(".intecStf").hide();
                }
            });

            $(".intecStd").hide();

            $("#user_position").change(function() {
                var val = $("#user_position").val();
                if (val == "STD") {
                    $(".intecStd").show();
                } else {
                    $(".intecStd").hide();
                }
            });

            $(".intecVsr").hide();

            $("#user_position").change(function() {
                var val = $("#user_position").val();
                if (val == "VSR") {
                    $(".intecVsr").show();
                } else {
                    $(".intecVsr").hide();
                }
            });

            $(".stdVsr").hide();

            $("#user_position").change(function() {
                var val = $("#user_position").val();
                if (val == "STD" || val == "VSR") {
                    $(".stdVsr").show();
                } else {
                    $(".stdVsr").hide();
                }
            });



            $("#user_position").change(function() {
                var val = $("#user_position").val();
                if (val == "STD" || val == "STF" || val == "VSR") {
                    $(".all").show();
                } else {
                    $(".all").hide();
                }
            });

            $("#user_position").change(function() {
                $("#user_name").val("");
                $("#user_email").val("");
                $("#vsr_name").val("");
                $("#vsr_email").val("");
                $("#user_id").val("");
                $("#user_phone").val("");
                $("#department_id").val("");
                $("#department_stf").val("");
                $("#temperature").val("");
                $("#temperature_stf").val("");
            });

            $('.user_position').val('{{ old('user_position') }}');
            $(".user_position").change();
            $('.user_id').val('{{ old('user_id') }}');
            $(".user_id").change();
            $('.user_category').val('{{ old('user_category') }}');
            $(".user_category").change();
            $('.user_phone').val('{{ old('user_phone') }}');
            $('.department_id').val('{{ old('department_id') }}');
            $('.temperature').val('{{ old('temperature') }}');
            $('.department_stf').val('{{ old('department_stf') }}');
            $('.temperature_stf').val('{{ old('temperature_stf') }}');
            $('#vsr_name').val('{{ old('vsr_name') }}');
            $('#vsr_email').val('{{ old('vsr_email') }}');

            $('input[name="q1"]:checked').val('{{ old('q1') }}');
            $('input[name="q1"]:checked').change();
            $('#declare_date1').val('{{ old('declare_date1') }}');
            $('input[name="q2"]:checked').val('{{ old('q2') }}');
            $('input[name="q2"]:checked').change();
            $('#declare_date2').val('{{ old('declare_date2') }}');
            $('input[name="q3"]:checked').val('{{ old('q3') }}');
            $('input[name="q3"]:checked').change();
            $('input[name="q4a"]:checked').val('{{ old('q4a') }}');
            $('input[name="q4a"]:checked').change();
            $('input[name="q4b"]:checked').val('{{ old('q4b') }}');
            $('input[name="q4b"]:checked').change();
            $('input[name="q4c"]:checked').val('{{ old('q4c') }}');
            $('input[name="q4c"]:checked').change();
            $('input[name="q4d"]:checked').val('{{ old('q4d') }}');
            $('input[name="q4d"]:checked').change();
        });

        function btn() {
            var chk = document.getElementById("chk")
            var submit = document.getElementById("submit");
            submit.disabled = chk.checked ? false : true;
            if (!submit.disabled) {
                submit.focus();
            }
        }
    </script>
@endsection
