@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i> STATIONERY APPLICATION MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        @if($status == 'RV')
                            REJECTED
                        @else
                            {{ strtoupper(\App\IsmStatus::where('status_code', $status)->first()->status_name) }}
                        @endif
                        <span class="fw-300"><i>LIST</i></span>
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
                            <div class="alert alert-success" style="color: #3b6324;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="list" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th>APPLICATION ID</th>
                                        <th>APPLICANT ID</th>
                                        <th>APPLICANT NAME</th>
                                        <th>APPLICATION DATE</th>
                                        @if($status == 'NA')
                                            <th>PENDING DURATION</th>
                                        @endif
                                        @if($status == 'RV')
                                            <th>STATUS</th>
                                            <th>REMARK</th>
                                        @endif
                                        @if($status == 'AC')
                                            <th>REMINDER</th>
                                        @endif
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Application Id"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Applicant Id"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Applicant Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Application Date"></td>
                                        @if($status == 'NA')
                                            <td class="hasinput"></td>
                                        @endif
                                        @if($status == 'RV')
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Status"></td>
                                            <td class="hasinput"></td>
                                        @endif
                                        @if($status == 'AC')
                                            <td class="hasinput"></td>
                                        @endif
                                        <td class="hasinput"></td>
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

        var status = "<?php echo $status; ?>";
        var table = $('#list').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-stationery-manage/"+ status,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'applicant_id', name: 'applicant_id' },
                    { className: 'text-center', data: 'applicant_name', name: 'staff.staff_name' },
                    { className: 'text-center', data: 'created_at', name: 'created_at' },
                    @if($status == 'NA')
                        { className: 'text-center', data: 'duration', name: 'duration', orderable: false},
                    @endif
                    @if($status == 'RV')
                        { className: 'text-center', data: 'current_status', name: 'status.status_name' },
                        { className: 'text-center', data: 'remark', name: 'remark', orderable: false},
                    @endif
                    @if($status == 'AC')
                        { className: 'text-center', data: 'reminder', name: 'reminder', orderable: false},
                    @endif
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 3, "desc" ]],
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
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
