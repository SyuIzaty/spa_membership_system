@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i> STATIONERY APPLICATION
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        APPLICATION <span class="fw-300"><i>LIST</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            </button>
                            <div class="d-flex align-items-center">
                                <div class="alert-icon width-8">
                                    <span class="icon-stack icon-stack-md">
                                        <i class="base-2 icon-stack-3x color-danger-400"></i>
                                        <i class="base-10 text-white icon-stack-1x"></i>
                                        <i class="fal fa-info-circle color-danger-800 icon-stack-2x"></i>
                                    </span>
                                </div>
                                <div class="flex-1 pl-1">
                                    <ul class="mb-0 pb-0">
                                        <li>The application can only be deleted if its status is still <b style="text-transform: uppercase">"New Application"</b>.</li>
                                        <li>Please make confirmation once the stationery has been collected, especially when the status changes to <b style="text-transform: uppercase">"Awaiting Confirmation"</b>.</li>
                                        <li>For further inquiries regarding application or collection, please directly contact <b>PUAN NORZALILATUL AKMA</b> at <b>0386037085.</b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="list" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th>APPLICATION ID</th>
                                        <th>APPLICATION DATE</th>
                                        <th>CURRENT STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Id"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Status"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="/stationery-application-form" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Application Form</a>
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
        $('#list thead tr .hasinput').each(function(i)
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

        var table = $('#list').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-application-form",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'created_at', name: 'created_at' },
                    { className: 'text-center', data: 'current_status', name: 'status.status_name' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#list').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Delete Application?',
                text: "Data cannot be recovered back after deletion process!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#list').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
