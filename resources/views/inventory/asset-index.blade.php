@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-dolly-flatbed'></i>ASSET LISTS
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        List <span class="fw-300"><i>Of Asset</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="assets" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>#ID</th>
                                        <th>FINANCE CODE</th>
                                        <th>CODE</th>
                                        <th>NAME</th>
                                        <th>TYPE</th>
                                        <th>DEPARTMENT</th>
                                        <th>SERIAL NO.</th>
                                        <th>MODEL</th>
                                        <th>BRAND</th>
                                        <th>CUSTODIAN</th>
                                        <th style="width: 110px">PURCHASE DATE</th>
                                        <th style="width: 150px">STATUS</th>
                                        <th style="width: 150px">AVAILABILITY</th>
                                        <th>CREATED BY</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Finance Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Type"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Serial No."></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Model"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Brand"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Custodian"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Purchase Date"></td>
                                        <td class="hasinput">
                                            <select id="status" name="status" class="form-control">
                                                <option value="">ALL</option>
                                                <option value="1">ACTIVE</option>
                                                <option value="0">INACTIVE</option>
                                            </select>
                                        </td>
                                        <td class="hasinput">
                                            <select id="availability" name="availability" class="form-control">
                                                <option value="">ALL</option>
                                                <option value="1">UNAVAILABLE</option>
                                                <option value="2">AVAILABLE</option>
                                            </select>
                                        </td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Created By"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a class="btn btn-primary ml-auto" href="/asset-new"><i class="fal fa-plus-square"></i> Add New Asset</a><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('script')

<script>
    $(document).ready(function()
    {
        $('#status, #availability').select2();

        $('#assets thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#assets').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/assetList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'finance_code', name: 'finance_code' },
                    { className: 'text-center', data: 'asset_code', name: 'asset_code' },
                    { className: 'text-center', data: 'asset_name', name: 'asset_name' },
                    { className: 'text-center', data: 'asset_type', name: 'asset_type' },
                    { className: 'text-center', data: 'department_id', name: 'department_id' },
                    { className: 'text-center', data: 'serial_no', name: 'serial_no' },
                    { className: 'text-center', data: 'model', name: 'model' },
                    { className: 'text-center', data: 'brand', name: 'brand'},
                    { className: 'text-center', data: 'custodian_id', name: 'custodian_id'},
                    { className: 'text-center', data: 'purchase_date', name: 'purchase_date'},
                    { className: 'text-center', data: 'status', name: 'status'},
                    { className: 'text-center', data: 'availability', name: 'availability'},
                    { className: 'text-center', data: 'created_by', name: 'created_by'},
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#assets').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#assets').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
