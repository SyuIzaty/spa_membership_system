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
                            <div class="row">
                                <div class="tab-content col-md-12">
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
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-header">{{ $data->code }} ({{ $data->file }}) >
                                                    <b>{{ $mainSub->code }} ({{ $mainSub->file }})</b>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="fileClass"
                                                            class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr class="bg-primary-50 text-center">
                                                                    <th class="text-center">Code</th>
                                                                    <th class="text-center">File Title</th>
                                                                    <th class="text-center">Remark</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="hasinput"></td>
                                                                    <td class="hasinput"></td>
                                                                    <td class="hasinput"></td>
                                                                    <td class="hasinput"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <a href="javascript:;" data-toggle="modal" id="new-sub"
                                                            class="btn btn-primary ml-auto float-right mt-4"><i
                                                                class="fal fa-plus"></i>
                                                            Add File</a>

                                                        <a href="/file-classification/{{ $id }}"
                                                            class="btn btn-success ml-auto float-left mt-4 waves-effect waves-themed"><i
                                                                class="fal fa-arrow-alt-left"></i> Back
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="crud-modal-sub" aria-hidden="true" data-keyboard="false"
                        data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-info fs-xl"></i> NEW FILE</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open([
                                        'action' => 'FCSController@storeNewSubActivity',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}

                                    <input type="hidden" name="id" value="{{ $ids }}">

                                    <p><span class="text-danger">*</span> Required Fields</p>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="code"><span
                                                    class="text-danger">*</span> Code :</label></td>
                                        <td colspan="4">
                                            <input value="{{ old('code') }}" class="form-control" id="code"
                                                name="code"
                                                placeholder="[INTEC] . [DEP] . [UNIT] . [FUNCTION NO] - [ACTIVITY NO] / [SUB-ACTIVITY NO] / [FILE NO]"
                                                required>

                                            @error('code')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="fileName"><span
                                                    class="text-danger">*</span> File Title :</label></td>
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
                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i
                                                class="fal fa-save"></i> Save</button>
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2"
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
                                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT FILE</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open([
                                        'action' => 'FCSController@updateSubActivity',
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
                                            @error('code')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="fileName"><span
                                                    class="text-danger">*</span> File Title :</label></td>
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
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2"
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

            $('#new-sub').click(function() {
                $('#crud-modal-sub').modal('show');
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

            var id = @json($ids);

            var table = $('#fileClass').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/sub-activity-list/" + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
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
        });
    </script>
@endsection
