@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file'></i> File Classification
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of File Classification</h2>
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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your
                                    input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @can('Manage File Classification')
                                <div class="col-md-6" style="margin-bottom: 10px;">
                                    <label>Department</label>
                                    <select class="selectfilter form-control" name="department" id="department">
                                        <option value="">Select Department</option>
                                        @foreach ($department as $d)
                                            <option value="{{ $d->id }}" <?php if ($selectedDepartment == $d->id) {
                                                echo 'selected';
                                            } ?>>
                                                {{ $d->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan
                            <div class="table-responsive">
                                <table id="fileClass" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Code</th>
                                            <th class="text-center">Activity</th>
                                            <th class="text-center">Remark</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Action</th>
                                            <th class="text-center">Activity Log</th>
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
                                            <td class="hasinput"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                @if (isset($owner))
                                    <a href="javascript:;" data-toggle="modal" id="new-file"
                                        class="btn btn-primary ml-auto float-right mt-4"><i class="fal fa-plus"></i>
                                        Add Activity
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="crud-modal-file" aria-hidden="true" data-keyboard="false"
                        data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-info fs-xl"></i> NEW ACTIVITY
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open([
                                        'action' => 'FCSController@storeNewActivity',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <p><span class="text-danger">*</span> Required Fields</p>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="code"><span
                                                    class="text-danger">*</span> Code :</label>
                                        </td>
                                        <td colspan="4">
                                            <input value="{{ old('code') }}" class="form-control" id="code"
                                                name="code" required>
                                            <span style="color: red; font-size:11px">Format: [FUNCTION NO] - [ACTIVITY
                                                NO]</span>
                                            @error('code')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="fileName"><span
                                                    class="text-danger">*</span> Activity :</label></td>
                                        <td colspan="4">
                                            <input value="{{ old('fileName') }}" class="form-control" id="fileName"
                                                name="fileName" required>
                                            @error('fileName')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="remark">Remark :</label></td>
                                        <td colspan="4">
                                            <input value="{{ old('remark') }}" class="form-control" id="remark"
                                                name="remark">
                                            @error('remark')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><span class="text-danger">*</span> Department</label>
                                        <select class="form-control department" name="department" id="dept"
                                            required>
                                            <option disabled selected>Choose Department</option>
                                            @if (isset($owner))
                                                @foreach ($department->whereIn('id', $owner->dept_id) as $d)
                                                    <option value="{{ $d->id }}">
                                                        {{ $d->department_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i
                                                class="fal fa-save"></i> Save</button>
                                        <button type="button" class="btn btn-secondary ml-auto float-right mr-2"
                                            data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="edit-modal-sub" aria-hidden="true" data-keyboard="false"
                        data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT ACTIVITY
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open([
                                        'action' => 'FCSController@updateActivity',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <p><span class="text-danger">*</span> Required Fields</p>
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="code"><span
                                                    class="text-danger">*</span> Code :</label></td>
                                        <td colspan="4">
                                            <input class="form-control" id="code" name="code" required>
                                            <span style="color: red; font-size:11px">Format: [FUNCTION NO] - [ACTIVITY
                                                NO]</span>
                                            @error('code')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="fileName"><span
                                                    class="text-danger">*</span> Activity :</label></td>
                                        <td colspan="4">
                                            <input class="form-control" id="fileName" name="fileName" required>
                                            @error('fileName')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="remark">Remark :</label></td>
                                        <td colspan="4">
                                            <input class="form-control" id="remark" name="remark">
                                            @error('remark')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i
                                                class="fal fa-save"></i> Update</button>
                                        <button type="button" class="btn btn-secondary ml-auto float-right mr-2"
                                            data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
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
        $(document).ready(function() {
            $('#department').select2();

            $('#crud-modal-file').on('shown.bs.modal', function() {
                $('.department').select2({
                    dropdownParent: $('#crud-modal-file')
                });
            });

            $('#new-file').click(function() {
                $('#crud-modal-file').modal('show');
            });

            $('#edit-modal-sub').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var code = button.data('code')
                var file = button.data('file')
                var remark = button.data('remark')

                $('.modal-body #id').val(id);
                $('.modal-body #code').val(code);
                $('.modal-body #fileName').val(file);
                $('.modal-body #remark').val(remark);
            });


            var table = $('#fileClass').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/file-main-list",
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
                        data: 'code',
                        name: 'code'
                    },
                    {
                        className: 'text-left',
                        data: 'file',
                        name: 'file'
                    },
                    {
                        className: 'text-center',
                        data: 'remark',
                        name: 'remark'
                    },
                    {
                        className: 'text-left',
                        data: 'department',
                        name: 'department.department_name'
                    },
                    {
                        className: 'text-center',
                        data: 'action',
                        name: 'action'
                    },
                    {
                        className: 'text-center',
                        data: 'log',
                        name: 'log'
                    },
                ],
                orderCellsTop: true,
                "order": [
                    [0, "asc"]
                ],
                "initComplete": function(settings, json) {}
            });

            function createDatatable(department = null) {
                $('#fileClass').DataTable().destroy();
                var table = $('#fileClass').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    deferRender: true,
                    ajax: {
                        url: "/file-main-lists",
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
                            data: 'code',
                            name: 'code'
                        },
                        {
                            className: 'text-left',
                            data: 'file',
                            name: 'file'
                        },
                        {
                            className: 'text-center',
                            data: 'remark',
                            name: 'remark'
                        },
                        {
                            className: 'text-left',
                            data: 'department',
                            name: 'department.department_name'
                        },
                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action'
                        },
                        {
                            className: 'text-center',
                            data: 'log',
                            name: 'log'
                        },
                    ],
                    orderCellsTop: true,
                    "order": [
                        [0, "asc"]
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

            $('#fileClass').on('click', '.btn-delete[data-remote]', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');
                Swal.fire({
                    title: 'Are you sure you want to delete this activity?',
                    text: "All the sub-activity and file will be deleted too. You won't be able to revert this!",
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
                            data: {
                                method: '_DELETE',
                                submit: true
                            }
                        }).always(function(data) {
                            $('#fileClass').DataTable().draw(false);
                        });
                    }
                })
            });

        });
    </script>
@endsection
