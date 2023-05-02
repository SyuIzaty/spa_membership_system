@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-paperclip'></i>ICT EQUIPMENT RENTAL
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Equipment Rental <span class="fw-300"><i>List</i></span>
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
                            <div class="table-responsive">
                                <table id="rental" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                            <th>id</th>
                                            <th>Staff ID:</th>
                                            <th>Staff Name:</th>
                                            <th>No. Phone:</th>
                                            <th>Rent Date:</th>
                                            <th>Return Date:</th>
                                            <th>Status:</th>
                                            <th>Action:</th>
                                        </tr>
                                        <tr>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="ID"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Staff ID"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Staff Name"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="No. phone"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Rent Date"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Return Date"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Status"></td>
                                            <td class="hasinput"><input type="text" class="form-control"
                                                    placeholder="Action"></td>

                                        </tr>
                                    </thead>

                                </table>
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
            var table = $('#rental').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/own_data",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                    className: 'text-center',
                            data: 'sid',
                            name: 'id'
                        },
                        {
                            className: 'text-center',
                            data: 'staff',
                            name: 'staff_id'
                        },
                        {
                            className: 'text-center',
                            data: 'name',
                            name: 'name'
                        }, 
                        {
                            className: 'text-center',
                            data: 'phone',
                            name: 'hp_no'
                        },
                        {
                            className: 'text-center',
                            data: 'renDate',
                            name: 'rent_date'
                        },
                        {
                            className: 'text-center',
                            data: 'retDate',
                            name: 'return_date'
                        },
                        {
                            className: 'text-center',
                            data: 'sta',
                            name: 'status'
                        },
                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                ],
                orderCellsTop: true,
                "order": [
                    [4, "asc"]
                ],
                "initComplete": function(settings, json) {}
            });
        });
    </script>
@endsection
