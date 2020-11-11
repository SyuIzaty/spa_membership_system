@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Source Management
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Source <span class="fw-300"><i>List</i></span>
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
                        <table id="source" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                    <th>Source Name</th>
                                    <th>Source Created</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Source Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date Created"></td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Source</a>
                    </div>
                </div>

                <div class="modal fade" id="crud-modal" aria-hidden="true" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header">
                                <h5 class="card-title w-100">NEW SOURCE</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'SourceController@createSources', 'method' => 'POST']) !!}
                                {{-- {{Form::hidden('id', $source->id)}} --}}

                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="source_name">Source Name :</label></td>
                                        <td colspan="4"><input value="{{ old('source_name') }}" class="form-control" id="source_name" name="source_name">
                                            @error('source_name')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                 
                                <div class="footer">
                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                    <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="crud-modals" aria-hidden="true" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header">
                                <h5 class="card-title w-100">EDIT SOURCE</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'SourceController@updateSources', 'method' => 'POST']) !!}
                                {{-- {{Form::hidden('id', $source->id)}} --}}
                                <input type="hidden" name="source_id" id="source">
                                
                                <td width="15%"><label class="form-label" for="source_name">Source Name :</label></td>
                                {{-- @dd($source) --}}
                                <td colspan="5"><input class="form-control" id="name" name="source_name">
                                    @error('source_name')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                                
                                <div class="footer">
                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                    <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                </div>

                                {!! Form::close() !!}
                            </div>
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
        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var source = button.data('source') 
            var name = button.data('name')

            $('.modal-body #source').val(source); // # for id in form 
            $('.modal-body #name').val(name); 
        });

        $('#source thead tr .hasinput').each(function(i)
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


        var table = $('#source').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-allSource",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'source_name', name: 'source_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#source').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#source').DataTable().draw(false);
                    });
                }
            })
        });


    });

</script>

@endsection
