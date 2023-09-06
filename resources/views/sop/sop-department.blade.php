@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon ni ni-briefcase'></i> SOP Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of Department</h2>
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
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="col-md-6" style="margin-bottom: 10px;">
                                <label>Department</label>
                                <select class="selectfilter form-control chooseDept" name="department" id="department">
                                    <option value="">Select Department</option>
                                    @foreach ($department as $d)
                                        <option value="{{ $d->id }}"
                                            {{ $selectedDepartment == $d->id ? "echo 'selected'" : '' }}>
                                            {{ $d->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table id="sop" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Abbreviation</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" data-target="#add" data-toggle="modal"
                                    class="btn btn-primary waves-effect waves-themed float-right mt-2"><i
                                        class="fal fa-plus-square"></i> Add Department</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Add Department</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'SOPController@addSOPDepartment', 'method' => 'POST']) !!}

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Department</span>
                                </div>
                                <input type="text" name="department" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Abbreviation</span>
                                </div>
                                <input type="text" name="abbreviation" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="custom-select form-control" name="status" id="status" required>
                                <option value="Y">Active</option>
                                <option value="N">Inactive</option>
                            </select>
                        </div>

                        <div class="footer">
                            <button type="submit" id="btn_search"
                                class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i
                                    class="fal fa-save"></i> Add</button>
                            <button type="button"
                                class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed"
                                data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Edit Department</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'SOPController@editSOPDepartment', 'method' => 'POST']) !!}
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Department</span>
                                </div>
                                <input type="text" id="department" name="department" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Abbreviation</span>
                                </div>
                                <input type="text" id="abbreviation" name="abbreviation" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="custom-select form-control" name="status" id="status" required>
                                <option value="Y">Active</option>
                                <option value="N">Inactive</option>
                            </select>
                        </div>

                        <div class="footer">
                            <button type="submit" id="btn_search"
                                class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i
                                    class="fal fa-save"></i> Update</button>
                            <button type="button"
                                class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed"
                                data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
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
        $(document).ready(function() {

            $('#add').on('shown.bs.modal', function() {
                $('.departments').select2({
                    dropdownParent: $('#add')
                });
            });

            $('#edit').on('shown.bs.modal', function() {
                $('.departments').select2({
                    dropdownParent: $('#edit')
                });
            });

            $('#edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id') // data-id
                var department = button.data('department') // data-id
                var abbreviation = button.data('abbreviation') // data-abbreviation
                var status = button.data('status') // data-status

                $('.modal-body #id').val(id);
                $('.modal-body #department').val(department);
                $('.modal-body #abbreviation').val(abbreviation);
                $('.modal-body #status').val(status);
            });

            var table = $('#sop').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-sop-department",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        className: 'text-center',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        className: 'text-left',
                        data: 'department',
                        name: 'department'
                    },
                    {
                        className: 'text-center',
                        data: 'abbreviation',
                        name: 'abbreviation'
                    },
                    {
                        className: 'text-center',
                        data: 'status',
                        name: 'status'
                    },
                    {
                        className: 'text-center',
                        data: 'action',
                        name: 'action'
                    },
                ],
                orderCellsTop: true,
                "order": [
                    [0, "asc"]
                ],
                "initComplete": function(settings, json) {}
            });

            function createDatatable(department = null) {
                $('#sop').DataTable().destroy();
                var table = $('#sop').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    deferRender: true,
                    ajax: {
                        url: "/get-sop-departments",
                        data: {
                            department: department
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    iDisplayLength: 10,
                    columns: [{
                            className: 'text-center',
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            className: 'text-left',
                            data: 'department',
                            name: 'department'
                        },
                        {
                            className: 'text-center',
                            data: 'abbreviation',
                            name: 'abbreviation'
                        },
                        {
                            className: 'text-center',
                            data: 'status',
                            name: 'status'
                        },
                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action'
                        },
                    ],
                    orderCellsTop: true,
                    "order": [
                        [1, "asc"]
                    ],
                    "initComplete": function(settings, json) {},
                    "fnDrawCallback": function() {
                        $('.total_record').text(this.fnSettings().fnRecordsTotal());
                    },
                    select: true,
                });
            }

            $('.selectfilter').on('change', function() {
                var department = $('#department').val();
                createDatatable(department);
            });
        });
    </script>
@endsection
