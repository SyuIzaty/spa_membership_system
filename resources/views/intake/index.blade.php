@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Intake
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Intake <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <a class="btn btn-primary" href="{{ route('intake.create') }}"> Create Intake Info</a>
                        <table id="intake" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-highlight">
                                    <th>Intake Code</th>
                                    <th>Intake Description</th>
                                    <th>Application Start Date</th>
                                    <th>Application End Date</th>
                                    <th>Check Status Start Date</th>
                                    <th>Check Status End Date</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake Description"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                        <!-- datatable end -->
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">


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

        $('#intake thead tr .hasinput').each(function(i)
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


        var table = $('#intake').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-allintake",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'intake_code', name: 'intake_code' },
                    { data: 'intake_description', name: 'intake_description' },
                    { data: 'intake_app_open', name: 'intake_app_open' },
                    { data: 'intake_app_close', name: 'intake_app_close'},
                    { data: 'intake_check_open', name: 'intake_check_open'},
                    { data: 'intake_check_close', name: 'intake_check_close'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#intake').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#intake').DataTable().draw(false);
                    });
                }
            })
        });


    });

</script>

@endsection
