@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Batch
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Batch <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <a class="btn btn-primary" href="{{ route('batch.create') }}"> Create Batch</a>
                        <table id="batch" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-highlight">
                                    <th>Batch Code</th>
                                    <th>Batch Name</th>
                                    <th>Batch Description</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Batch Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Batch Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Batch Description"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Status"></td>
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

        $('#batch thead tr .hasinput').each(function(i)
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


        var table = $('#batch').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-allbatch",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'batch_code', name: 'batch_code' },
                    { data: 'batch_name', name: 'batch_name' },
                    { data: 'batch_description', name: 'batch_description'},
                    { data: 'batch_status', name: 'batch_status'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#batch').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#batch').DataTable().draw(false);
                    });
                }
            })
        });


    });

</script>

@endsection
