@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-car'></i> e-Kenderaan
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of Feedback Questions</h2>
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

                            @error('sequence')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                        class="icon fal fa-check-circle"></i> {{ $message }}</div>
                            @enderror

                            <div class="table-responsive">
                                <table id="question" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Question</th>
                                            <th class="text-center">Sequence</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Edit</th>
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
                            </div>
                        </div>
                    </div>
                    <div
                        class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href="#" data-target="#add" data-toggle="modal"
                            class="btn btn-danger waves-effect waves-themed float-right" style="margin-right:7px;"><i
                                class="fal fa-plus-square"></i> Add Question</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="add" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Add Question</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'EKenderaanController@addQuestion', 'method' => 'POST']) !!}
                        <a href="#" class="btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed">
                            <i class="fal fa-info"></i>
                        </a>
                        <b style="color:red">&ensp;Only Finalize Question will be displayed on the Feedback Section in the
                            &emsp;&emsp; e-Kenderaan application form.
                        </b>
                        <div class="form-group mt-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Question</span>
                                </div>
                                <textarea class="form-control" rows="3" name="question" required>{{ Request::old('question') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Sequence</span>
                                </div>
                                <input type="text" class="form-control" name="sequence" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="custom-select form-control" name="status" id="status" required>
                                <option value="Y">Finalize</option>
                                <option value="N">Not Finalize</option>
                            </select>
                            <span style="color:red"><b><i>The question can not be edited once it's finalize.</i></b></span>
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
                        <h5 class="card-title w-100">Edit Question</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'EKenderaanController@editQuestion', 'method' => 'POST']) !!}
                        <input type="hidden" name="id" id="id">
                        <a href="#" class="btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed">
                            <i class="fal fa-info"></i>
                        </a>
                        <b style="color:red">&ensp;Only Finalize Question will be displayed on the Feedback Section in the
                            &emsp;&emsp; e-Kenderaan application form.
                        </b>
                        <div class="form-group mt-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Name</span>
                                </div>
                                <textarea class="form-control" rows="3" name="question" id="question" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Sequence</span>
                                </div>
                                <input type="text" class="form-control" name="sequence" id="sequence" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="custom-select form-control" name="status" id="status" required>
                                <option value="Y">Finalize</option>
                                <option value="N">Not Finalize</option>
                            </select>
                            <span style="color:red"><b><i>The question can not be edited once it's finalize.</i></b></span>
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

            $('#edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id') // data-id
                var question = button.data('question') // data-question
                var sequence = button.data('sequence') // data-sequence
                var status = button.data('status') // data-status

                $('.modal-body #id').val(id);
                $('.modal-body #question').val(question);
                $('.modal-body #sequence').val(sequence);
                $('.modal-body #status').val(status);

            });

            var table = $('#question').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/feedback-questions",
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
                        data: 'question',
                        name: 'question'
                    },
                    {
                        className: 'text-center',
                        data: 'sequence',
                        name: 'sequence'
                    },
                    {
                        className: 'text-center',
                        data: 'status',
                        name: 'status'
                    },
                    {
                        className: 'text-center',
                        data: 'edit',
                        name: 'edit',
                        orderable: false,
                        searchable: false
                    },
                ],
                orderCellsTop: true,
                "order": [
                    [0, "asc"]
                ],
                "initComplete": function(settings, json) {

                }
            });
        });
    </script>
@endsection
