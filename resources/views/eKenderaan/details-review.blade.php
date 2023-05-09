@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}

    <style>
        .hide {
            display: none;
        }
    </style>

    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-car'></i> e-Kenderaan
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr bg-primary">
                        <h2 style="color: white;">
                            e-KENDERAAN APPLICATION</b>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                            <center><img src="{{ asset('img/INTEC_PRIMARY_LOGO.png') }}" style="width: 300px;"></center>
                            <br>

                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            @error('hp_no')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                        class="icon fal fa-check-circle"></i> {{ $message }}</div>
                            @enderror

                            @error('waitingarea')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                        class="icon fal fa-check-circle"></i> The Waiting Area field is required.</div>
                            @enderror

                            <div class="panel-container show">
                                <div class="panel-content">

                                    {!! Form::open([
                                        'action' => 'EKenderaanController@store',
                                        'method' => 'POST',
                                        'id' => 'data',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="bg-warning text-center">
                                                        <h5>
                                                            <b>REVIEW APPLICATION</b>
                                                        </h5>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table id="applicant" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="bg-success-50"><label class="form-label">
                                                            <i class="fal fa-file"></i> APPLICANT INFORMATION</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">Name</th>
                                                    <td style="vertical-align: middle">
                                                        <input class="form-control" value="{{ strtoupper($name) }}"
                                                            readonly>
                                                    </td>
                                                    <th style="vertical-align: middle">ID</th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        <input class="form-control" value="{{ $id }}" readonly>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th style="vertical-align: middle">Department/Programme
                                                    </th>
                                                    <td style="vertical-align: middle">
                                                        <input class="form-control" value="{{ $deptProg }}" readonly>
                                                    </td>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        H/P No.</th>
                                                    <td colspan="2">
                                                        <input class="form-control" id="hp_no" name="hp_no"
                                                            value="{{ $user_hp }}"
                                                            placeholder="Please insert phone no. eg: 0123456789" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Departure Date</th>
                                                    <td>
                                                        @if ($user->hasAnyRole(['eKenderaan Admin']) || $user->id == '14020099')
                                                            <input type="text" class="form-control" id="departdateAdmin"
                                                                name="departdate" placeholder="Please insert departure date"
                                                                autocomplete="off" value="{{ $departdate }}" required>
                                                        @else
                                                            <input type="text" class="form-control" id="departdate"
                                                                name="departdate" placeholder="Please insert departure date"
                                                                autocomplete="off" value="{{ $departdate }}" required>
                                                        @endif
                                                    </td>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Departure Time</th>
                                                    <td colspan="2">
                                                        <input class="form-control" type="text" id="departtime"
                                                            name="departtime" placeholder="Please insert departure time"
                                                            autocomplete="off" value="{{ $departtime }}" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Return Date</th>
                                                    <td>
                                                        @if ($user->hasAnyRole(['eKenderaan Admin']) || $user->id == '14020099')
                                                            <input type="text" class="form-control"
                                                                id="returndateAdmin" name="returndate"
                                                                placeholder="Please insert return date" autocomplete="off"
                                                                value="{{ $returndate }}" required>
                                                        @else
                                                            <input type="text" class="form-control" id="returndate"
                                                                name="returndate" placeholder="Please insert return date"
                                                                autocomplete="off" value="{{ $returndate }}" required>
                                                        @endif
                                                    </td>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Return Time</th>
                                                    <td colspan="2">
                                                        <input class="form-control" type="text" id="returntime"
                                                            name="returntime" placeholder="Please insert return time"
                                                            autocomplete="off" value="{{ $returntime }}" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Destination (Full Address)</th>
                                                    <td colspan="5" style="vertical-align: middle">
                                                        <textarea class="form-control" id="example-textarea" rows="3" name="destination" required>{{ $destination }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Waiting Area</th>
                                                    <td colspan="5">
                                                        <span style="color: red">User can select multiple waiting area on
                                                            the below.</span>
                                                        <select class="form-control waitingArea" name="waitingarea[]"
                                                            id="waiting_area" multiple>
                                                            @if (!empty($waiting_area))
                                                                @foreach ($waiting_area as $a)
                                                                    @foreach ($waitingArea as $w)
                                                                        <option value="{{ $w->department_name }}"
                                                                            {{ $a == $w->department_name ? 'selected' : '' }}>
                                                                            {{ $w->department_name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                @foreach ($waitingArea as $w)
                                                                    <option value="{{ $w->department_name }}"
                                                                        {{ old('waitingarea') == $w->department_name ? 'selected' : '' }}>
                                                                        {{ $w->department_name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <span>
                                                            <p style="margin-top: 10px">Other Waiting Area (if any):</p>
                                                            <textarea class="form-control" id="example-textarea" rows="2" name="others">{{ $other_waiting_area }}</textarea>
                                                            <span style="color: red">For other waiting area, please provide
                                                                <b>details location</b>. If you want to cancel, please make
                                                                sure the text field is <b>empty</b>.</span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Purpose</th>
                                                    <td colspan="5" style="vertical-align: middle">
                                                        <textarea class="form-control" id="example-textarea" rows="3" name="purpose" required>{{ $purpose }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Attachment (PDF format only)</th>
                                                    <td colspan="5">
                                                        @if ($image_id != '')
                                                            <a class="btn btn-primary" target="_blank"
                                                                href="/temp-file/{{ $image_id }}">
                                                                <i class="fal fa-download"></i> {{ $originalName }}
                                                            </a>
                                                            <input type="hidden" name="temp_file"
                                                                value="{{ $image_id }}">
                                                        @else
                                                            N/A
                                                            <input type="hidden" name="temp_file"
                                                                value="{{ $image_id }}">
                                                        @endif
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>

                                        <table class="table table-bordered table-hover table-striped w-100 testing">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="bg-success-50"><label class="form-label">
                                                            <i class="fal fa-user"></i> PASSENGER DETAILS</label>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table id="staff"
                                            class="table table-bordered table-hover table-striped w-100 tablestaff">
                                            <thead>
                                                <th colspan="6" class="bg-primary-50 text-center">STAFF
                                                </th>
                                                <tr class="bg-info-50">
                                                    <td colspan="6">Click plus button on the right to add staff id.
                                                        Total of passenger including staff & student limited to 24 persons
                                                        only.
                                                        <button type="button" id="btnstf"
                                                            class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed float-right"><i
                                                                class="fal fa-plus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>NAME</th>
                                                    <th>DEPARTMENT</th>
                                                    <th></th>
                                                </tr>
                                                @if ($passenger_staff != null)
                                                    @foreach ($passenger_staff as $key => $value)
                                                        @php
                                                            $staff = App\Staff::where('staff_id', $passenger_staff[$key])->first();
                                                        @endphp

                                                        <tr id="rowStaff{{ $staff->staff_id }}"
                                                            name="rowStaff{{ $staff->staff_id }}">
                                                            <div class="form-group">
                                                                <td>
                                                                    <input type="text" id="staff_id"
                                                                        name="staff_id[]"
                                                                        class="form-control staff_id{{ $staff->staff_id }}"
                                                                        value="{{ $staff->staff_id }}" disabled>
                                                                    <input type="hidden" name="passenger_staff[]"
                                                                        value="{{ $staff->staff_id }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="staff_name"
                                                                        name="staff_name[]"
                                                                        class="form-control staff_name{{ $staff->staff_name }}"
                                                                        value="{{ $staff->staff_name }}" disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="staff_dept"
                                                                        name="staff_dept[]"
                                                                        class="form-control staff_dept{{ $staff->staff_dept }}"
                                                                        value="{{ $staff->staff_dept }}" disabled>
                                                                </td>
                                                                <td class="text-center" style="width: 10%;">
                                                                    <button type="button" id="{{ $staff->staff_id }}"
                                                                        class="btn_remove_staff btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i
                                                                            class="fal fa-times"></i></button>
                                                                </td>
                                                            </div>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </thead>
                                        </table>
                                        <table id="student"
                                            class="table table-bordered table-hover table-striped w-100 tablestudent">
                                            <thead>
                                                <th colspan="6" class="bg-primary-50 text-center">
                                                    STUDENT
                                                </th>
                                                <tr class="bg-info-50">
                                                    <td colspan="6">Click plus button on the right to add student id.
                                                        Total of passenger including staff & student limited to 24 persons
                                                        only.
                                                        <button type="button" id="btnstd"
                                                            class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed float-right"><i
                                                                class="fal fa-plus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>NAME</th>
                                                    <th>PROGRAMME</th>
                                                    <th></th>
                                                </tr>
                                                @if ($passengerBulk != null)
                                                    @foreach ($passengerBulk as $key => $value)
                                                        @php
                                                            $students = App\Student::where('students_id', $value['ID']);
                                                        @endphp
                                                        @if ($students->exists())
                                                            <tr name="bulk{{ $students->first()->students_id }}">
                                                                <td>
                                                                    <input type="text"
                                                                        id="{{ $students->first()->students_id }}"
                                                                        name="student_id_bulk[]"
                                                                        class="form-control stud_ic{{ $students->first()->students_id }}"
                                                                        value="{{ $students->first()->students_id }}"
                                                                        disabled>
                                                                    <input type="hidden" name="student_id_bulk[]"
                                                                        value="{{ $students->first()->students_id }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="stud_name"
                                                                        name="stud_name[]"
                                                                        class="form-control stud_name{{ $students->first()->students_id }}"
                                                                        value="{{ $students->first()->students_name }}"
                                                                        disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="stud_dept"
                                                                        name="stud_dept[]"
                                                                        class="form-control stud_dept{{ $students->first()->students_id }}"
                                                                        value="{{ $students->first()->programmes->programme_name }}"
                                                                        disabled>
                                                                </td>
                                                                <td class="text-center" style="width: 10%;">
                                                                    <button type="button"
                                                                        id="{{ $students->first()->students_id }}"
                                                                        class="btn_remove_bulk btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i
                                                                            class="fal fa-times"></i></button>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr name="bulk{{ $value['ID'] }}">
                                                                <td>
                                                                    <input type="text" id="{{ $value['ID'] }}"
                                                                        name="student_id_bulk[]"
                                                                        class="form-control stud_ic{{ $value['ID'] }}"
                                                                        value="N/A" disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="stud_name"
                                                                        name="stud_name[]"
                                                                        class="form-control stud_name{{ $value['ID'] }}"
                                                                        value="N/A" disabled>
                                                                </td>
                                                                <td>
                                                                    <input type="text" id="stud_dept"
                                                                        name="stud_dept[]"
                                                                        class="form-control stud_dept{{ $value['ID'] }}"
                                                                        value="N/A" disabled>
                                                                </td>
                                                                <td class="text-center" style="width: 10%;">
                                                                    <button type="button" id="{{ $value['ID'] }}"
                                                                        class="btn_remove_bulk btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i
                                                                            class="fal fa-times"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if ($passenger_student != null)
                                                    @foreach ($passenger_student as $key => $value)
                                                        @php
                                                            $students = App\Student::where('students_id', $passenger_student[$key])->first();
                                                        @endphp
                                                        <tr name="student{{ $students->students_id }}">
                                                            <td>
                                                                <input type="text" id="{{ $students->students_id }}"
                                                                    name="student_id_passenger[]"
                                                                    class="form-control stud_id{{ $students->students_id }}"
                                                                    value="{{ $students->students_id }}" disabled>
                                                                <input type="hidden" name="passenger_student[]"
                                                                    value="{{ $students->students_id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" id="stud_name" name="stud_name[]"
                                                                    class="form-control stud_name{{ $students->students_id }}"
                                                                    value="{{ $students->students_name }}" disabled>
                                                            </td>
                                                            <td>
                                                                <input type="text" id="stud_dept" name="stud_dept[]"
                                                                    class="form-control stud_dept{{ $students->students_id }}"
                                                                    value="{{ $students->programmes->programme_name }}"
                                                                    disabled>
                                                            </td>
                                                            <td class="text-center" style="width: 10%;">
                                                                <button type="button" id="{{ $students->students_id }}"
                                                                    class="btn_remove_student btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i
                                                                        class="fal fa-times"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="form-group">
                                            @if ($image_id != '')
                                                <a href="#" data-path="{{ $image_id }}"
                                                    style="margin-top: 5px;"
                                                    class="btn btn-warning float-left btn_cancel"><i
                                                        class="fal fa-times"></i> Cancel</a>
                                            @else
                                                <a href="#" style="margin-top: 5px;"
                                                    class="btn btn-warning float-left btn_cancel_application"><i
                                                        class="fal fa-times"></i> Cancel</a>
                                            @endif
                                            <button style="margin-top: 5px;" class="btn btn-danger float-right"
                                                id="submit" name="submit"><i class="fal fa-check"></i>
                                                Submit
                                            </button>
                                        </div>
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
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
        integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#waiting_area,#stud,.staff_id').select2();

            if ($('.staff_id').val() != '') {
                findID($('.staff_id'));
            }
            $(document).on('change', '.staff_id', function() {
                var a = $(this).attr("id");
                findID($(this), a);
            });

            function findID(elem, a) {
                var staffID = elem.val();

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('findStaffID') !!}',
                    data: {
                        'id': staffID
                    },
                    success: function(data) {
                        $('.staff_name' + a).val(data.staff_name);
                        $('.staff_dept' + a).val(data.staff_dept);

                    },
                });
            }

            //table staff
            $('#btnstf').click(function() {
                i++;
                if (i < 25) {

                    $('#staff').append(`
            <tr id="row${i}">
                <div class="form-group">
                    <td>
                        <select class="form-control staff_id" id="${i}" name="staff_id[]" required>
                            <option value="" selected disabled>Please Select</option>
                            @foreach ($staffs as $s)
                                <option value="{{ $s->staff_id }}">{{ $s->staff_id }} - {{ $s->staff_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" id="staff_name" name="staff_name[]" class="form-control staff_name${i}" disabled>
                    </td>
                    <td>
                        <input type="text" id="staff_dept" name="staff_dept[]" class="form-control staff_dept${i}" disabled>
                    </td>
                    <td class="text-center" style="width: 10%;">
                        <button type="button" id="${i}" class="btn_remove btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i class="fal fa-times"></i></button>
                    </td>
                </div>
            </tr>`);
                }
                $('.staff_id').select2();
            });

            var i = 0;

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

            $(document).on('click', '.btn_remove_staff', function() {
                var button_staff = $(this).attr("id");
                $("[name='rowStaff" + button_staff + "']").remove();
            });

            $('input[name="stf"]').change(function() {
                if ($("#stf").is(':checked')) {
                    var val = $("#stf").val();
                    $(".tablestaff").show();
                }
            });

            //table student
            if ($('.stud_id').val() != '') {
                findStudID($('.stud_id'));
            }
            $(document).on('change', '.stud_id', function() {
                var b = $(this).attr("id");
                findStudID($(this), b);
            });

            function findStudID(elem, b) {
                var studID = elem.val();

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('findStudendID') !!}',
                    data: {
                        'id': studID
                    },
                    success: function(data) {
                        console.log(b)
                        $('.stud_name' + b).val(data.students_name);
                        $('.stud_dept' + b).val(data.programmes.programme_name);

                    },
                });
            }
            $('#btnstd').click(function() {
                s++;
                if (s < 25) {
                    $('#student').append(`
                <tr id="rowStudent${s}" name="rowStudent${s}">
                <div class="form-group">
                    <td>
                        <select class="form-control stud_id" id="${s}" name="student_id[]" required>
                            <option value="" selected disabled>Please Select</option>
                            @foreach ($pelajar as $s)
                                <option value="{{ $s->students_id }}">{{ $s->students_id }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" id="stud_name" name="stud_name[]" class="form-control stud_name${s}" disabled>
                    </td>
                    <td>
                        <input type="text" id="stud_dept" name="stud_dept[]" class="form-control stud_dept${s}" disabled>
                    </td>
                    <td class="text-center" style="width: 10%;">
                        <button type="button" id="${s}" class="btn_remove_stud btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i class="fal fa-times"></i></button>
                    </td>
                </div>
            </tr>`);
                }
                $('.stud_id').select2();
            });

            var s = 1;

            $(document).on('click', '.btn_remove_stud', function() {
                var button_stud = $(this).attr("id");
                $("[name='rowStudent" + button_stud + "']").remove();
            });

            $('input[name="std"]').change(function() {
                if ($("#std").is(':checked')) {
                    $(".tablestudent").show();
                }
            });

            $(document).on('click', '.btn_remove_bulk', function() {
                var button_bulk = $(this).attr("id");
                $("[name='bulk" + button_bulk + "']").remove();
            });

            $(document).on('click', '.btn_remove_student', function() {
                var button_student = $(this).attr("id");
                $("[name='student" + button_student + "']").remove();
            });

        });

        //datepicker & timepicker for staff & student
        $("#departdate").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            maxDate: "+1y",
            minDate: +4,
        });

        $("#returndate").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            maxDate: "+1y",
            minDate: +4,
        });

        $('#departtime').timepicker({
            timeFormat: 'h:mm p',
            interval: '15',
            minTime: '6',
            maxTime: '11:55pm',
            startTime: '6:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#returntime').timepicker({
            timeFormat: 'h:mm p',
            interval: '15',
            minTime: '6',
            maxTime: '11:55pm',
            startTime: '6:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#departdate').on('change', function() {
            $('#returndate').datepicker("option", "minDate", $('#departdate').datepicker('getDate'));
        });
        $('#returndate').on('change', function() {
            $('#departdate').datepicker("option", "maxDate", $('#returndate').datepicker('getDate'));
        });


        //datepicker & timepicker for admin
        $("#departdateAdmin").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            maxDate: "+1y",
        });

        $("#returndateAdmin").datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            maxDate: "+1y",
        });

        $(".btn_cancel").on('click', function(e) {
            e.preventDefault();

            let id = $(this).data('path');

            Swal.fire({
                title: 'Are you sure you want to cancel this application?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel!',
                cancelButtonText: 'No'
            }).then(function(e) {
                if (e.value === true) {
                    $.ajax({
                        type: "DELETE",
                        url: "/cancel-application/" + id,
                        data: id,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            if (response) {
                                window.location.href = "/ekenderaan-application";
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function(dismiss) {
                return false;
            })
        });

        $(".btn_cancel_application").on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure you want to cancel this application?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel!',
                cancelButtonText: 'No'
            }).then(function(e) {
                if (e.value === true) {
                    window.location.href = "/ekenderaan-application";
                }

            })
        });

        $(document).ready(function() {
            $("#data").submit(function() {
                $("#submit").attr("disabled", true);
                return true;
            });
        });
    </script>
@endsection
