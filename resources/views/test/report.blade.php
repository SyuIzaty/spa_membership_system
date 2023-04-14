@extends('layouts.admin')

@section('content')
    <style>
        .swal2-container {
            z-index: 10000;
        }

        .dataTables_wrapper .dt-buttons {
            float: right;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-clipboard-list'></i> ICT Equipment Rental Form
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Full Report by Year and Month</h2>
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
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label>Year</label>
                                    <select class="form-control year selectYear" name="year" id="year">
                                        <option disabled selected>Please Select</option>
                                        @foreach ($year as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Month</label>
                                    <select class="form-control selectfilter month" name="months" id="month">
                                    </select>
                                </div>
                            </div>
                            <table id="report" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                        <th>id</th>
                                        <th>Staff id:</th>
                                        <th>Staff Name:</th>
                                        <th>No. Phone:</th>
                                        <th>Rent Date:</th>
                                        <th>Return Date:</th>
                                        <th>Status:</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Staff ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Staff Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="No. phone"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Rent Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Return Date"></td>
                                        <td class="hasinput"><input type="text"  class="form-control" placeholder="Status"></td>

                                    </tr>
                                </thead>

                            </table>
                            <a href="/ICTRental-Reports" id="buttonfull" class="btn btn-success float-right"
                            style="color: rgb(0, 0, 0); margin-top: 15px; margin-bottom: 15px;">
                            <i class="fal fa-file-excel"></i> Report
                        </a>
                        <button class="btn btn-success float-right" id="buttonyear"
                            style="color: rgb(0, 0, 0); margin-top: 15px; margin-bottom: 15px; display:none">
                            <i class="fal fa-file-excel"></i> Report
                        </button>
                        <button class="btn btn-success float-right" id="buttonyearmonth"
                            style="color: rgb(0, 0, 0); margin-top: 15px; margin-bottom: 15px; display:none">
                            <i class="fal fa-file-excel"></i> Report
                        </button>
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
            $('#year').on('change', function() {
                var year = $(this).val();
                if (year) {
                    $.ajax({
                        url: '/getYear/' + year,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#month').empty();
                                $('#month').focus();
                                $('select[name="months"]').append(
                                    `<option value="" selected disabled>Please Choose</option>`
                                );
                                $.each(data, function(key, value) {
                                    $('select[name="months"]').append(
                                        '<option value="' + value + '">' + value +
                                        '</option>');
                                });
                                $("#buttonfull").hide();
                                $("#buttonyearmonth").hide();
                                $("#buttonyear").show();
                                $('#buttonyear').click(function() {
                                    window.location = "/ICTRental-Report-Year/" + year;
                                });
                            } else {
                                $('#month').empty();
                            }
                        }
                    });
                } else {
                    $('#month').empty();
                }
            });
        });

        $(document).ready(function() {

            var table = $('#report').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/allReport", //update into allReport
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'sid', name: 'id' },
                        { className: 'text-center', data: 'staff', name: 'staff_id' }, 
                        { className: 'text-center', data: 'name', name: 'name' }, //call the data from equipmentStaff table(declare in TestController@data_rental)
                        { className: 'text-center', data: 'phone', name: 'hp_no' },
                        { className: 'text-center', data: 'renDate', name: 'rent_date' },
                        { className: 'text-center', data: 'retDate', name: 'return_date' },
                        { className: 'text-center', data: 'sta', name: 'status' }
                    ],
                    orderCellsTop: true,
                    "order": [[ 5, "desc" ], [ 2, "asc"]],
                    "initComplete": function(settings, json) {

                    }
        }); 
        function createDatatableYear(year = null) {
                $('#report').dataTable().fnDestroy();

                var table = $('#report').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    ajax: {
                        url: "/year-report-ICTRental",
                        data: {
                            year: year
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { className: 'text-center', data: 'sid', name: 'id' },
                        { className: 'text-center', data: 'staff', name: 'staff_id' }, 
                        { className: 'text-center', data: 'name', name: 'name' }, //call the data from equipmentStaff table(declare in TestController@data_rental)
                        { className: 'text-center', data: 'phone', name: 'hp_no' },
                        { className: 'text-center', data: 'renDate', name: 'rent_date' },
                        { className: 'text-center', data: 'retDate', name: 'return_date' },
                        { className: 'text-center', data: 'sta', name: 'status' }
                    ],
                    "initComplete": function(settings, json) {},
                });
            }

            function createDatatable(year = null, month = null) {
                $('#report').dataTable().fnDestroy();

                var table = $('#report').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    ajax: {
                        url: "/month-year-report-ICTRental",
                        data: {
                            year: year,
                            month: month
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                    { className: 'text-center', data: 'sid', name: 'id' },
                    { className: 'text-center', data: 'staff', name: 'staff_id' }, 
                    { className: 'text-center', data: 'name', name: 'name' }, //call the data from equipmentStaff table(declare in TestController@data_rental)
                    { className: 'text-center', data: 'phone', name: 'hp_no' },
                    { className: 'text-center', data: 'renDate', name: 'rent_date' },
                    { className: 'text-center', data: 'retDate', name: 'return_date' },
                    { className: 'text-center', data: 'sta', name: 'status' },
                ],
                    orderCellsTop: true,
                    "order": [
                        [0, "asc"]
                    ],
                    "initComplete": function(settings, json) {},
                    dom: 'frtipB',

                    buttons: [{
                        extend: 'excel',
                        text: 'Report',
                        className: 'btn btn-danger',
                        title: 'ICT Rental Form Report'
                    }, ]
                });
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });

            $('#year').on('change', function() {
                $('#month').val('').change();
            });

            $('.selectYear').on('change', function() {
                var year = $('#year').val();

                if (year) {
                    createDatatableYear(year);
                }
            });


            $('.selectfilter').on('change', function() {
                var year = $('#year').val();
                var month = $('#month').val();

                if (year && month) {
                    createDatatable(year, month);
                    $("#buttonfull").hide();
                    $("#buttonyear").hide();
                    $("#buttonyearmonth").show();
                    $('#buttonyearmonth').click(function() {
                        window.location = "/ICTRental-Report-Year-Month/" + year + "/" + month;
                    });

                }
            });

        });
    </script>
@endsection