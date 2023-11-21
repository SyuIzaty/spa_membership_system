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
                <i class='subheader-icon fal fa-file'></i> APPLICATION REPORT MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2> Application List</h2>
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
                             <div class="row mb-2">
                                <div class="col-md-6 mb-4">
                                    <label> Department : </label>
                                    <select class="form-control department selectDepartment" name="department" id="department">
                                        <option value="" selected >Please Select</option>
                                        @foreach ($department as $departments)
                                            <option value="{{ $departments->department_code }}">{{ $departments->department_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Month:</label>
                                    <select class="form-control month selectMonth" name="month" id="month">
                                        <option value="" selected >Please Select</option>
                                        @php
                                            $uniqueMonths = [];
                                            foreach ($date as $item) {
                                                $month = $item->created_at->format('m');
                                                if (!in_array($month, $uniqueMonths)) {
                                                    $uniqueMonths[] = $month;
                                                }
                                            }
                                        @endphp
                                        @foreach ($uniqueMonths as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Year:</label>
                                    <select class="form-control year selectYear" name="year" id="year">
                                        <option value="" selected >Please Select</option>
                                        @php
                                            $uniqueYears = [];
                                            foreach ($date as $item) {
                                                $year = $item->created_at->format('Y');
                                                if (!in_array($year, $uniqueYears)) {
                                                    $uniqueYears[] = $year;
                                                }
                                            }
                                        @endphp
                                        @foreach ($uniqueYears as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label> Status : </label>
                                    <select class="form-control status selectStatus" name="status" id="status">
                                        <option value="" selected >Please Select</option>
                                        @foreach ($status as $statuses)
                                            <option value="{{ $statuses->status_code }}">{{ strtoupper($statuses->status_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <table class="table table-bordered" id="report">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>APPLICATION ID</th>
                                        <th>APPLICANT NAME</th>
                                        <th>APPLICATION DATE</th>
                                        <th>DEPARTMENT</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                            </table>
                            <a href="#" id="buttonfull" class="btn btn-primary float-right ml-2" style="margin-top: 15px; margin-bottom: 15px;">
                                <i class="fal fa-file-excel"></i> Full Report
                            </a>
                            <a href="#" id="buttonsummary" class="btn btn-info float-right" style="margin-top: 15px; margin-bottom: 15px;">
                                <i class="fal fa-file-excel"></i> Summary Report
                            </a>
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

            var table;

            function initializeDataTable(department, month, year, status) {
                table = $('#report').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    searching: false,
                    ajax: {
                        url: "/data-stationery-report",
                        type: 'POST',
                        data: {
                            department: department,
                            month: month,
                            year: year,
                            status: status
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { className: 'text-center', data: 'id', name: 'id' },
                        { className: 'text-center', data: 'applicant_id', name: 'applicant_id' },
                        { className: 'text-center', data: 'created_at', name: 'created_at' },
                        { className: 'text-center', data: 'applicant_dept', name: 'applicant_dept' },
                        { className: 'text-center', data: 'current_status', name: 'current_status' }
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
                        title: 'Stationery Report'
                    }],
                });
            }

            initializeDataTable('', '', '','');

            function updateDataTable(department, month, year, status) {
                table.destroy();
                initializeDataTable(department, month, year, status);
            }

            $('#department, #year, #month, #status').on('change', function () {
                var department = $('#department').val();
                var month = $('#month').val();
                var year = $('#year').val();
                var status = $('#status').val();

                if (department || month || year || status) {
                    $('#buttonfull, #buttonsummary').prop('disabled', false);
                    $('#buttonfull').attr('href', "/stationery-report-excel/" + (department || 'null') + "/" + (month || 'null') + "/" + (year || 'null')  + "/" + (status || 'null') + "/" + ('F' || 'null'));
                    $('#buttonsummary').attr('href', "/stationery-report-excel/" + (department || 'null') + "/" + (month || 'null') + "/" + (year || 'null')  + "/" + (status || 'null') + "/" + ('S' || 'null'));
                } else {
                    $('#buttonfull, #buttonsummary').prop('disabled', true);
                    $('#buttonfull, #buttonsummary').removeAttr('href');
                }

                updateDataTable(department, month, year, status);
            });

        });

        $('#department, #year, #month, #status').select2();

    </script>
@endsection
