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
                <i class='subheader-icon fal fa-file'></i> ASSET REPORT MANAGEMENT
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
                                        <option value="" selected>All</option>
                                        @foreach ($department as $departments)
                                            <option value="{{ $departments->id }}">{{ $departments->department_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Asset : </label>
                                    <select class="form-control asset selectAsset" name="asset[]" id="asset" multiple="multiple">
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Asset Type : </label>
                                    <select class="form-control type selectType" name="type" id="type">
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label>Custodian : </label>
                                    <select class="form-control custodian selectCustodian" name="custodian" id="custodian">
                                    </select>
                                </div>
                            </div>
                            <table class="table table-bordered" id="report">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>ID</th>
                                        <th>DEPARTMENT</th>
                                        <th>CODE TYPE</th>
                                        <th>FINANCE CODE</th>
                                        <th>ASSET CODE</th>
                                        <th>ASSET NAME</th>
                                        <th>ASSET TYPE</th>
                                        <th>ASSET CLASS</th>
                                        <th>SERIAL NO.</th>
                                        <th>STATUS</th>
                                        <th>AVAILABILITY</th>
                                        <th>CUSTODIAN</th>
                                    </tr>
                                </thead>
                            </table>
                            <a href="/asset-report-excel/null/null/null/null" id="buttonfull" class="btn btn-primary float-right" style="margin-top: 15px; margin-bottom: 15px;">
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

            function initializeDataTable(department, asset, type, custodian) {
                table = $('#report').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    searching: false,
                    ajax: {
                        url: "/data-asset-report",
                        type: 'POST',
                        data: {
                            department: department,
                            asset: asset,
                            type: type,
                            custodian: custodian
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { className: 'text-center', data: 'id', name: 'id' },
                        { className: 'text-center', data: 'department_id', name: 'department_id' },
                        { className: 'text-center', data: 'asset_code_type', name: 'asset_code_type' },
                        { className: 'text-center', data: 'finance_code', name: 'finance_code' },
                        { className: 'text-center', data: 'asset_code', name: 'asset_code' },
                        { className: 'text-center', data: 'asset_name', name: 'asset_name' },
                        { className: 'text-center', data: 'asset_type', name: 'asset_type' },
                        { className: 'text-center', data: 'asset_class', name: 'asset_class' },
                        { className: 'text-center', data: 'serial_no', name: 'serial_no' },
                        { className: 'text-center', data: 'status', name: 'status' },
                        { className: 'text-center', data: 'availability', name: 'availability' },
                        { className: 'text-center', data: 'custodian_id', name: 'custodian_id' }
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
                        title: 'Asset Report'
                    }],
                });
            }

            initializeDataTable('', '', '', '');

            function updateDataTable(department, asset, type, custodian) {
                table.destroy();
                initializeDataTable(department, asset, type, custodian);
            }

            // $('#department, #asset, #type, #custodian').on('change', function () {
            //     var department = $('#department').val();
            //     var asset = $('#asset').val();
            //     var type = $('#type').val();
            //     var custodian = $('#custodian').val();

            //     if (department || asset || type || custodian) {
            //         $('#buttonfull').removeAttr('disabled');
            //         $('#buttonfull').attr('href', "/asset-report-excel/" + (department || 'null') + "/" + (asset.join(',') || 'null') + "/" + (type || 'null') + "/" + (custodian || 'null'));
            //     } else {
            //         $('#buttonfull').attr('disabled', 'disabled');
            //         $('#buttonfull').removeAttr('href');
            //     }

            //     updateDataTable(department, asset, type, custodian);
            // });

            $('#department, #asset, #type, #custodian').on('change', function () {
                var department = $('#department').val();
                var asset = $('#asset').val();
                var type = $('#type').val();
                var custodian = $('#custodian').val();

                if (department || asset || type || custodian) {
                    $('#buttonfull').removeAttr('disabled');
                    $('#buttonfull').attr('href', "/asset-report-excel/" + (department || 'null') + "/" + (asset.join(',') || 'null') + "/" + (type || 'null') + "/" + (custodian || 'null'));
                } else {
                    $('#buttonfull').removeAttr('disabled');
                    $('#buttonfull').attr('href', "/asset-report-excel/null/null/null/null");
                }

                updateDataTable(department, asset, type, custodian);
            });


        });

        $('#department, #type, #custodian, #class, #code, #asset').select2();

        // Dependent function

        $(document).ready(function () {
            var selectDepartment = $('.selectDepartment');
            var selectAsset = $('.selectAsset');

            selectDepartment.on('change', function () {
                var departmentCode = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/get-asset-by-department',
                    data: { department_code: departmentCode },
                    success: function (data) {
                        selectAsset.empty();
                        // selectAsset.append($('<option></option>').attr('value', '').text('Please Select'));

                        $.each(data, function (key, value) {
                            selectAsset.append($('<option></option>').attr('value', value.id).text(value.asset_name));
                        });

                        if (departmentCode) {
                            selectAsset.prop('disabled', false);
                        } else {
                            selectAsset.prop('disabled', true);
                        }
                    }
                });
            });

            selectAsset.prop('disabled', true);
        });

        $(document).ready(function () {
            var selectDepartment = $('.selectDepartment');
            var selectType = $('.selectType');

            selectDepartment.on('change', function () {
                var departmentCode = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/get-type-by-department',
                    data: { department_code: departmentCode },
                    success: function (data) {
                        selectType.empty();
                        selectType.append($('<option></option>').attr('value', '').text('All'));

                        $.each(data, function (key, value) {
                            selectType.append($('<option></option>').attr('value', value.id).text(value.asset_type));
                        });

                        if (departmentCode) {
                            selectType.prop('disabled', false);
                        } else {
                            selectType.prop('disabled', true);
                        }
                    }
                });
            });

            selectType.prop('disabled', true);
        });

        $(document).ready(function () {
            var selectDepartment = $('.selectDepartment');
            var selectCustodian = $('.selectCustodian');

            selectDepartment.on('change', function () {
                var departmentCode = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/get-custodian-by-department',
                    data: { department_code: departmentCode },
                    success: function (data) {
                        selectCustodian.empty();
                        selectCustodian.append($('<option></option>').attr('value', '').text('All'));

                        $.each(data, function (key, value) {
                            selectCustodian.append($('<option></option>').attr('value', value.custodian_id).text(value.custodian.name));
                        });

                        if (departmentCode) {
                            selectCustodian.prop('disabled', false);
                        } else {
                            selectCustodian.prop('disabled', true);
                        }
                    }
                });
            });

            selectCustodian.prop('disabled', true);
        });

    </script>
@endsection
