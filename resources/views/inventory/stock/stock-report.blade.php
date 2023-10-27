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
                <i class='subheader-icon fal fa-file'></i> STOCK REPORT MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Full Report</h2>
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
                            <p><span class="text-danger">*</span> Required fields</p>
                            <div class="row mb-2">
                                <div class="col-md-6 mb-4">
                                    <label><span class="text-danger">*</span> Department : </label>
                                    <select class="form-control department selectDepartment" name="department" id="department">
                                        <option selected disabled>Please Select</option>
                                        @foreach ($department as $departments)
                                            <option value="{{ $departments->department_code }}">{{ $departments->department_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Stock : </label>
                                    <select class="form-control stock selectStock" name="stock" id="stock">
                                    </select>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label>Current Owner : </label>
                                    <select class="form-control owner selectOwner" name="owner" id="owner">
                                    </select>
                                </div>
                            </div>
                            <table class="table table-bordered" id="report">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>#ID</th>
                                        <th>DEPARTMENT</th>
                                        <th>CODE</th>
                                        <th>NAME</th>
                                        <th>STATUS</th>
                                        <th>CURRENT OWNER</th>
                                    </tr>
                                </thead>
                            </table>
                            <a href="#" id="buttonfull" class="btn btn-primary float-right" style="margin-top: 15px; margin-bottom: 15px;">
                                <i class="fal fa-file-excel"></i> Report
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

            function initializeDataTable(department, stock, owner) {
                table = $('#report').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    ajax: {
                        url: "/data-stock-report",
                        type: 'POST',
                        data: {
                            department: department,
                            stock: stock,
                            owner: owner
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { className: 'text-center', data: 'id', name: 'id' },
                        { className: 'text-center', data: 'department_id', name: 'department_id' },
                        { className: 'text-center', data: 'stock_code', name: 'stock_code' },
                        { className: 'text-center', data: 'stock_name', name: 'stock_name' },
                        { className: 'text-center', data: 'status', name: 'status' },
                        { className: 'text-center', data: 'current_owner', name: 'current_owner' }
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
                        title: 'Stock Report'
                    }],
                });
            }

            initializeDataTable('', '', '');

            function updateDataTable(department, stock, owner) {
                table.destroy();
                initializeDataTable(department, stock, owner);
            }

            $('#department, #stock, #owner').on('change', function () {
                var department = $('#department').val();
                var stock = $('#stock').val();
                var owner = $('#owner').val();

                // Enable the button only if any combination of department, stock, or owner is selected
                if (department || stock || owner) {
                    $('#buttonfull').removeAttr('disabled');
                    $('#buttonfull').attr('href', "/stock-report-excel/" + (department || 'null') + "/" + (stock || 'null') + "/" + (owner || 'null'));
                } else {
                    $('#buttonfull').attr('disabled', 'disabled');
                    $('#buttonfull').removeAttr('href');
                }

                updateDataTable(department, stock, owner);
            });

        });

        $('#department, #stock, #owner').select2();

        $(document).ready(function () {
            var selectDepartment = $('.selectDepartment');
            var selectStock = $('.selectStock');

            selectDepartment.on('change', function () {
                var departmentCode = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/get-stock-by-department',
                    data: { department_code: departmentCode },
                    success: function (data) {
                        selectStock.empty();
                        selectStock.append($('<option></option>').attr('value', '').text('Please Select'));

                        $.each(data, function (key, value) {
                            selectStock.append($('<option></option>').attr('value', value.id).text(value.stock_name));
                        });

                        // Enable or disable "Please Select" based on the department selection
                        if (departmentCode) {
                            selectStock.prop('disabled', false);
                        } else {
                            selectStock.prop('disabled', true);
                        }
                    }
                });
            });

            // Initially, disable "Please Select" as no department is selected
            selectStock.prop('disabled', true);
        });

        $(document).ready(function () {
            var selectDepartment = $('.selectDepartment');
            var selectOwner = $('.selectOwner');

            selectDepartment.on('change', function () {
                var departmentCode = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/get-owner-by-department',
                    data: { department_code: departmentCode },
                    success: function (data) {
                        selectOwner.empty();
                        selectOwner.append($('<option></option>').attr('value', '').text('Please Select'));

                        $.each(data, function (key, value) {
                            selectOwner.append($('<option></option>').attr('value', value.staff_id).text(value.staff_name));
                        });

                        // Enable or disable "Please Select" based on the department selection
                        if (departmentCode) {
                            selectOwner.prop('disabled', false);
                        } else {
                            selectOwner.prop('disabled', true);
                        }
                    }
                });
            });

            // Initially, disable "Please Select" as no department is selected
            selectOwner.prop('disabled', true);
        });


    </script>
@endsection
