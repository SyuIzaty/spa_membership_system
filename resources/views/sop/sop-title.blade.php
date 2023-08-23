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
                        <h2>List of SOP Title</h2>
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
                                <select class="selectfilter form-control" name="department" id="department">
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
                                            <th class="text-center">SOP Title</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Cross Department</th>
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
                                            <td class="hasinput"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" data-target="#add" data-toggle="modal"
                                    class="btn btn-primary waves-effect waves-themed float-right mt-2"><i
                                        class="fal fa-plus-square"></i> Add SOP Title</a>
                            </div>
                        </div>
                    </div>
                    {{-- <div
                        class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href="#" data-target="#add" data-toggle="modal"
                            class="btn btn-primary waves-effect waves-themed float-right" style="margin-right:7px;"><i
                                class="fal fa-plus-square"></i> Add SOP Title</a>
                    </div> --}}
                    {{-- {!! Form::open([
                        'action' => 'SOPController@add',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div
                        class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <input type="file" name="import_file" accept=".xlsx" class="form-control mb-3">
                    </div>

                    <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit"><i
                            class="fal fa-check"></i>
                        Submit</button>
                    {!! Form::close() !!} --}}
                </div>
            </div>
        </div>
        <div class="modal fade" id="add" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Add SOP Title</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'SOPController@addSOPTitle', 'method' => 'POST']) !!}

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Department</span>
                                </div>
                                <select class="form-control department" name="department" id="department">
                                    <option selected disabled value="">Select Department</option>
                                    @foreach ($department as $d)
                                        <option value="{{ $d->id }}">
                                            {{ $d->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Title</span>
                                </div>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Cross Department (if any)</label>
                            <select class="form-control departments" id="crossdept" name="crossdept[]" multiple>
                                @foreach ($department as $d)
                                    <option value="{{ $d->id }}">{{ $d->department_name }}
                                    </option>
                                @endforeach
                            </select>
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
                        <h5 class="card-title w-100">Edit SOP Title</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'SOPController@editSOPTitle', 'method' => 'POST']) !!}
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label class="form-label">Department</label>
                            <select class="form-control department" name="department" id="department">
                                <option selected disabled value="">Select Department</option>
                                @foreach ($department as $d)
                                    <option value="{{ $d->id }}">{{ $d->department_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Title</span>
                                </div>
                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Cross Department (if any)</label>
                            <select class="form-control departments" id="crossDept" name="crossdept[]" multiple>
                                @foreach ($department as $d)
                                    <option value="{{ $d->id }}">
                                        {{ $d->department_name }}
                                    </option>
                                @endforeach
                            </select>
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
            // $('.department').select2({
            //     dropdownParent: ('#add')
            // });

            // $('.department').select2({
            //     dropdownParent: ('#edit')
            // });

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

            // $('#department').select2();

            $('#edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id') // data-id
                var department = button.data('department') // data-department
                var title = button.data('title') // data-title
                var status = button.data('status') // data-status

                $('.modal-body #id').val(id);
                $('.modal-body #department').val(department);
                $('.modal-body #title').val(title);
                $('.modal-body #crossDept').val(crossDept);
                $('.modal-body #status').val(status);
            });

            var table = $('#sop').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/get-sop-title",
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
                        data: 'sop',
                        name: 'sop'
                    },
                    {
                        className: 'text-left',
                        data: 'department',
                        name: 'department'
                    },
                    {
                        className: 'text-left',
                        data: 'cross_department',
                        name: 'cross_department'
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
                        url: "/get-sop-titles",
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
                            data: 'sop',
                            name: 'sop'
                        },
                        {
                            className: 'text-left',
                            data: 'department',
                            name: 'department'
                        },
                        {
                            className: 'text-left',
                            data: 'cross_department',
                            name: 'cross_department'
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
