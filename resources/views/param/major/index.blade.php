@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Major
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Major <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="pull-right mb-4">
                            
                        </div>
                        <table id="major" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                    <th>Major Code</th>
                                    <th>Major Name</th>
                                    <th>Major Created</th>
                                    {{-- <th>Major Status</th> --}}
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Major Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Major Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Major Created"></td>
                                    {{-- <td class="hasinput">
                                        <select id="major_status" name="major_status" class="form-control">
                                            <option value="">All</option>
                                            <option value="1">Active</option>
                                            <option value="0">Unactive</option>
                                        </select>
                                    </td> --}}
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="/param/major/create" class="btn btn-primary ml-auto"><i class="fal fa-search-plus"></i> Add New Major</a>
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
        $('#major thead tr .hasinput').each(function(i)
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


        var table = $('#major').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-allMajor",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'major_code', name: 'major_code' },
                    { data: 'major_name', name: 'major_name' },
                    { data: 'created_at', name: 'created_at' },
                    // { data: 'major_status', name: 'major_status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#major').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#major').DataTable().draw(false);
                    });
                }
            })
        });


    });

</script>

@endsection
