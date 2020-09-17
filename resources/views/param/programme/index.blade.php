@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Programme
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Programme <span class="fw-300"><i>List</i></span>
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
                            {{-- <a class="btn btn-primary pull-right" href="javascript:;" data-toggle="modal" id="new">Add Programme</a> --}}
                            <a href="/param/programme/create" class="btn btn-primary ml-auto"><i class="fal fa-search-plus"></i> Add New Programme</a>
                        </div>
                        <table id="programme" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-highlight">
                                    <th>Programme Code</th>
                                    <th>Programme Name</th>
                                    <th>Programme Duration</th>
                                    <th>Programme Created</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Description"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Duration"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Created"></td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                        <!-- datatable end -->
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        {{-- <a href="/param/programme/create" class="btn btn-primary ml-auto"><i class="fal fa-search-plus"></i> Add New Programme</a> --}}
                    </div>

                    {{-- <div class="modal fade" id="crud-modal" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Add Programme</h4>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'ProgrammeController@store', 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{Form::label('title', 'Programme Code')}}
                                        {{Form::text('id', '', ['class' => 'form-control', 'placeholder' => 'Programme Code'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Programme Name')}}
                                        {{Form::text('programme_name', '', ['class' => 'form-control', 'placeholder' => 'Programme Name', 'required'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Programme Description')}}
                                        {{Form::text('programme_duration', '', ['class' => 'form-control', 'placeholder' => 'Programme Duration', 'required'])}}
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>
    // $('#new').click(function () {
    //     $('#crud-modal').modal('show');
    // });

    $(document).ready(function()
    {
        $('#programme thead tr .hasinput').each(function(i)
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


        var table = $('#programme').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-allProgramme",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'programme_name', name: 'programme_name' },
                    { data: 'programme_duration', name: 'programme_duration' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#programme').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#programme').DataTable().draw(false);
                    });
                }
            })
        });


    });

</script>

@endsection
