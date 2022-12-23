@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}

    <style>
        .hide{
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

                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;">
                                    <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}
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

                            @if($errors->any())
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-exclamation-circle"></i> {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="panel-container show">
                                <div class="panel-content">
                                    {!! Form::open([
                                        'action' => 'EKenderaanController@review',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <div class="table-responsive">
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
                                                        <input class="form-control border border-danger" id="hp_no" name="hp_no"
                                                            value="{{ old('hp_no') }}"
                                                            placeholder="Please insert phone no. eg: 0123456789" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Departure Date</th>
                                                    <td>
                                                        <input type="text" class="form-control border border-danger" id="departdate"
                                                            name="departdate" placeholder="Please insert departure date"
                                                            autocomplete="off" value="{{ old('departdate') }}" required>
                                                    </td>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Departure Time</th>
                                                    <td colspan="2">
                                                        <input class="form-control border border-danger" type="text" id="departtime"
                                                            name="departtime" placeholder="Please insert departure time"
                                                            autocomplete="off" value="{{ old('departtime') }}" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Return Date</th>
                                                    <td>
                                                        <input type="text" class="form-control border border-danger" id="returndate" name="returndate"
                                                         placeholder="Please insert return date" autocomplete="off" value="{{ old('returndate') }}" required>
                                                    </td>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Return Time</th>
                                                    <td colspan="2">
                                                        <input class="form-control border border-danger" type="text" id="returntime" name="returntime"
                                                            placeholder="Please insert return time" autocomplete="off" value="{{ old('returntime') }}" required>
                                                        </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Destination (Full Address)</th>
                                                    <td colspan="5" style="vertical-align: middle">
                                                        <textarea class="form-control border border-danger" id="example-textarea" rows="3" name="destination" required>{{Request::old('destination')}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Waiting Area</th>
                                                    <td colspan="5">
                                                        <select class="form-control border border-danger waitingArea" name="waitingarea"
                                                            id="waiting_area" required>
                                                            <option disabled selected>Choose Waiting Area</option>
                                                            @foreach ($waitingArea as $w)
                                                                <option value="{{ $w->id }}"
                                                                    {{ old('waitingarea') == $w->id ? 'selected' : '' }}>
                                                                    {{ $w->department_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span>
                                                        Purpose</th>
                                                    <td colspan="5" style="vertical-align: middle">
                                                        <textarea class="form-control border border-danger" id="example-textarea" rows="3" name="purpose" required>{{Request::old('purpose')}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle"><span class="text-danger">*</span> Attachment (PDF format only)</th>
                                                    <td colspan="5">
                                                        @if ($user->category == "STD")
                                                            <input type="file" class="form-control" accept=".pdf" id="attachment" name="attachment" required>
                                                            <span style="color: red">*Students are required to upload an approval letter from student affairs. </span>
                                                        @else
                                                            <input type="file" class="form-control" accept=".pdf" id="attachment" name="attachment">
                                                            <span style="color: red">*Students are required to upload an approval letter from student affairs. </span>
                                                        @endif
                                                        @error('attachment')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
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
                                                <tr>
                                                    <th style="vertical-align: middle">Bulk Upload (for Student passenger only. Please refer the excel format)
                                                        <span style="margin-left: 10px">
                                                            <a href="/student-list-excel-format" target="_blank" class="btn btn-warning btn-sm waves-effect waves-themed" style="box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);">
                                                                <i class="fal fa-eye"> Excel Format</i>
                                                            </a>
                                                        </span>
                                                    </th>

                                                    <td colspan="5">
                                                        <input type="file" name="import_file" accept=".xlsx" class="form-control mb-3">
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <br>
                                        <table id="staff"
                                            class="table table-bordered table-hover table-striped w-100 tablestaff">
                                            <thead>
                                                <th colspan="6" class="bg-primary-50 text-center">STAFF
                                                </th>
                                                <tr class="bg-info-50">
                                                    <td colspan="6">Click plus button on the right to add staff id. Total of passenger including staff & student limited to 24 persons only.
                                                        <button type="button" id="btnstf"
                                                            class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed float-right"><i
                                                                class="fal fa-plus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>IC</th>
                                                    <th>NAME</th>
                                                    <th>DEPARTMENT</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table id="student"
                                            class="table table-bordered table-hover table-striped w-100 tablestudent">
                                            <thead>
                                                <th colspan="6" class="bg-primary-50 text-center">
                                                    STUDENT
                                                </th>
                                                <tr class="bg-info-50">
                                                    <td colspan="6">Click plus button on the right to add student id. Total of passenger including staff & student limited to 24 persons only.
                                                        <button type="button" id="btnstd"
                                                            class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed float-right"><i
                                                                class="fal fa-plus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>IC</th>
                                                    <th>NAME</th>
                                                    <th>PROGRAMME</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="form-group">
                                            <button style="margin-top: 5px;" class="btn btn-danger float-right"
                                                id="submit" name="submit"><i class="fal fa-check"></i>
                                                Submit</button></td>
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

   $(document).ready(function()
   {
    $('#waiting_area').select2();

    if($('.staff_id').val()!=''){
                findID($('.staff_id'));
            }
            $(document).on('change','.staff_id',function(){
                var a = $(this).attr("id");
                findID($(this), a);
            });

            function findID(elem, a){
                var staffID=elem.val();

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findStaffID')!!}',
                    data:{'id':staffID},
                    success:function(data)
                    {
                        console.log(a)
                        $('.staff_ic'+a).val(data.staff_ic);
                        $('.staff_name'+a).val(data.staff_name);
                        $('.staff_dept'+a).val(data.staff_dept);

                    },
                });
            }
       //table staff
        $('#btnstf').click(function()
        {
            i++;
            if (i<25)
            {
                $('#staff').append(`
            <tr id="row${i}">
                <div class="form-group">
                    <td>
                        <select class="form-control staff_id" id="${i}" name="staff_id[]" required>
                            <option value="" selected disabled>Please Select</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staff_id }}">{{ $s->staff_id }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" id="staff_ic" name="staff_ic[]" class="form-control staff_ic${i}" disabled>
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

        var i=0;

        $(document).on('click', '.btn_remove', function()
        {
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $('input[name="stf"]').change(function () {
        if($("#stf").is(':checked')) {
            var val = $("#stf").val();
            $(".tablestaff").show();
        }
        });

        //table student
        if($('.stud_id').val()!=''){
                findStudID($('.stud_id'));
            }
            $(document).on('change','.stud_id',function(){
                var b = $(this).attr("id");
                findStudID($(this), b);
            });

            function findStudID(elem, b){
                var studID=elem.val();

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findStudendID')!!}',
                    data:{'id':studID},
                    success:function(data)
                    {
                        $('.stud_ic'+b).val(data.students_ic);
                        $('.stud_name'+b).val(data.students_name);
                        $('.stud_dept'+b).val(data.programmes.programme_name);

                    },
                });
            }
        $('#btnstd').click(function()
        {
            s++;
            if (s<25)
            {
                $('#student').append(`
                <tr id="rowStudent${s}" name="rowStudent${s}">
                <div class="form-group">
                    <td>
                        <select class="form-control stud_id" id="${s}" name="student_id[]" required>
                            <option value="" selected disabled>Please Select</option>
                            @foreach ($student as $s)
                                <option value="{{ $s->students_id }}">{{ $s->students_id }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" id="stud_ic" name="stud_ic[]" class="form-control stud_ic${s}" disabled>
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

        var s=0;

        $(document).on('click', '.btn_remove_stud', function()
        {
            var button_stud = $(this).attr("id");
            $("[name='rowStudent"+button_stud+"']").remove();
        });

        $('input[name="std"]').change(function () {
            if($("#std").is(':checked')) {
                $(".tablestudent").show();
            }
        });

   });



    // $(document).on('click', '.btn_remove_staff', function()
    //     {
    //         var button_id = $(this).attr("id");
    //         $('#staff').hide();
    //     });


    // $(document).on('click', '.btn_remove_student', function()
    //     {
    //         $(".tablestudent").hide();
    //     });


    //datepicker & timepicker
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
            minTime: '6',
            maxTime: '11:55pm',
            startTime: '6:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#returntime').timepicker({
            timeFormat: 'h:mm p',
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
    </script>
@endsection
