@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i> VOTING INFO MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        VOTE <span class="fw-300"><i>LIST</i></span>
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
                                        <th style="width:30px">#ID</th>
                                        <th>NAME</th>
                                        <th>START DATE</th>
                                        <th>END DATE</th>
                                        <th>STATUS</th>
                                        <th>SETTING</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Start Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="End Date"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Voting</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> NEW VOTING INFO</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Voting\VotingManagementController@store', 'method' => 'POST']) !!}
                        <p><span class="text-danger">*</span> Required Field</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="name"><span class="text-danger">*</span> Name :</label></td>
                            <td colspan="4">
                                <input class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="description"> Description :</label></td>
                            <td colspan="4">
                                <textarea rows="3" id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                                @error('description')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="start_date"><span class="text-danger">*</span> Start Date :</label></td>
                            <td colspan="4">
                                <input class="form-control" type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="end_date"><span class="text-danger">*</span> End Date :</label></td>
                            <td colspan="4">
                                <input class="form-control" type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <p style="color: red">{{ $message }}</p>
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

    <div class="modal fade" id="crud-modals" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT VOTING INFO</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['voting-manage.update', '__ID__'], 'method' => 'PATCH', 'id' => 'update-form']) !!}
                        <input type="hidden" id="ids" name="ids">
                        <p><span class="text-danger">*</span> Required Field</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="name"><span class="text-danger">*</span> Name :</label></td>
                            <td colspan="4">
                                <input class="form-control" id="names" name="names" required>
                                @error('name')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="description"> Description :</label></td>
                            <td colspan="4">
                                <textarea rows="3" id="descriptions" name="descriptions" class="form-control"></textarea>
                                @error('description')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="start_date"><span class="text-danger">*</span> Start Date :</label></td>
                            <td colspan="4">
                                <input class="form-control" type="datetime-local" id="start_dates" name="start_dates" required>
                                @error('start_date')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="end_date"><span class="text-danger">*</span> End Date :</label></td>
                            <td colspan="4">
                                <input class="form-control" type="datetime-local" id="end_dates" name="end_dates" required>
                                @error('end_date')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="footer">
                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                            <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                        </div>
                    {!! Form::close() !!}
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
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var description = button.data('description');
            var start_date = button.data('start_date');
            var end_date = button.data('end_date');

            $('.modal-body #ids').val(id);
            $('.modal-body #names').val(name);
            $('.modal-body #descriptions').val(description);
            $('.modal-body #start_dates').val(start_date);
            $('.modal-body #end_dates').val(end_date);

            var form = $('#update-form'); // Use the form's ID here
            var actionUrl = form.attr('action');
            form.prop('action', actionUrl.replace('__ID__', id));
        });

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
                url: "/data-voting-list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'name', name: 'name' },
                    { className: 'text-center', data: 'start_date', name: 'start_date' },
                    { className: 'text-center', data: 'end_date', name: 'end_date' },
                    { className: 'text-center', data: 'status', name: 'status', orderable: false, searchable: false},
                    { className: 'text-center', data: 'setting', name: 'setting', orderable: false, searchable: false},
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "desc" ]],
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
                title: 'Delete Vote Info?',
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
