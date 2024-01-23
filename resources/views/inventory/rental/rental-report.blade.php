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
                <i class='subheader-icon fal fa-file'></i> RENTAL REPORT MANAGEMENT
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
                                    <label>Renter : </label>
                                    <select class="form-control renter selectRenter" name="renter" id="renter">
                                        <option value="" selected>All</option>
                                        @foreach ($user as $users)
                                            <option value="{{ $users->id }}">{{ $users->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <table class="table table-bordered" id="report">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>ID</th>
                                        <th>STAFF NAME</th>
                                        <th>ASSET NAME</th>
                                        <th>CHECKOUT DATE</th>
                                        <th>RETURN DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                            </table>
                            <a href="/rental-report-excel/null/null/null" id="buttonfull" class="btn btn-primary float-right" style="margin-top: 15px; margin-bottom: 15px;">
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

            function initializeDataTable(department, asset, renter) {
                table = $('#report').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    searching: false,
                    ajax: {
                        url: "/data-rental-report",
                        type: 'POST',
                        data: {
                            department: department,
                            asset: asset,
                            renter: renter
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { className: 'text-center', data: 'id', name: 'id' },
                        { className: 'text-center', data: 'staff_id', name: 'staff_id' },
                        { className: 'text-center', data: 'asset_id', name: 'asset.asset_name' },
                        { className: 'text-center', data: 'checkout_date', name: 'checkout_date' },
                        { className: 'text-center', data: 'return_date', name: 'return_date' },
                        { className: 'text-center', data: 'status', name: 'status' }
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
                        title: 'Rental Report'
                    }],
                });
            }

            initializeDataTable('', '', '');

            function updateDataTable(department, asset, renter) {
                table.destroy();
                initializeDataTable(department, asset, renter);
            }

            $('#department, #asset, #renter').on('change', function () {
                var department = $('#department').val();
                var asset = $('#asset').val();
                var renter = $('#renter').val();

                if (department || asset || renter) {
                    $('#buttonfull').removeAttr('disabled');
                    $('#buttonfull').attr('href', "/rental-report-excel/" + (department || 'null') + "/" + (asset.join(',') || 'null') + "/" + (renter || 'null'));
                } else {
                    $('#buttonfull').removeAttr('disabled');
                    $('#buttonfull').attr('href', "/rental-report-excel/null/null/null");
                }

                updateDataTable(department, asset, renter);
            });


        });

        $('#department, #renter, #asset').select2();

        // Dependent function

        $(document).ready(function () {
            var selectDepartment = $('.selectDepartment');
            var selectAsset = $('.selectAsset');
            var selectRenter = $('.selectRenter');

            selectDepartment.on('change', function () {
                var departmentCode = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/get-asset-by-department',
                    data: { department_code: departmentCode },
                    success: function (data) {
                        selectAsset.empty();
                        $.each(data, function (key, value) {
                            selectAsset.append($('<option></option>').attr('value', value.id).text(value.asset_name));
                        });

                        if (departmentCode) {
                            selectAsset.prop('disabled', false);
                            selectRenter.prop('disabled', false);
                        } else {
                            selectAsset.prop('disabled', true);
                            selectRenter.prop('disabled', true);
                        }
                    }
                });
            });

            selectAsset.prop('disabled', true);
            selectRenter.prop('disabled', true);
        });

    </script>
@endsection
