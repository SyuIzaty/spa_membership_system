@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-laptop'></i> Computer Grant Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of FAQ</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="faq" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">Question</th>
                                            <th class="text-center">Answer</th>
                                            <th class="text-center">Edit</th>
                                            <th class="text-center">Delete</th>
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
                            </div>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href= "#" data-target="#add" data-toggle="modal" class="btn btn-danger waves-effect waves-themed float-right" style="margin-right:7px;"><i class="fal fa-plus-square"></i> Add New FAQ</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="add" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Add FAQ </h5>
                    </div>
                    <div class="modal-body">
                    {!! Form::open(['action' => 'ComputerGrantController@addFAQ', 'method' => 'POST']) !!}
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Question</span>
                                </div>
                                <textarea class="form-control max" aria-label="With textarea" name="question" id="question" required></textarea>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*Limit to 500 characters only</i></span>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Answer</span>
                                </div>
                                <textarea class="form-control max" aria-label="With textarea" name="answer" id="answer" required></textarea>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*Limit to 500 characters only</i></span>
                        </div>

                        <div class="footer">
                            <button type="submit" id="btn_search" class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i class="fal fa-save"></i> Add</button>
                            <button type="button" class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Edit FAQ </h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'ComputerGrantController@editFAQ', 'method' => 'POST']) !!}
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Question</span>
                                </div>
                                <textarea class="form-control max" aria-label="With textarea" name="question" id="question" required></textarea>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*Limit to 500 characters only</i></span>
                        </div>


                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Answer</span>
                                </div>
                                <textarea class="form-control max" aria-label="With textarea" name="answer" id="answer" required></textarea>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*Limit to 500 characters only</i></span>
                        </div>

                        <div class="footer">
                            <button type="submit" id="btn_search" class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i class="fal fa-save"></i> Update</button>
                            <button type="button" class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
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

        $('#edit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') // data-id
        var question = button.data('question') // data-question
        var answer = button.data('answer') // data-answer

        $('.modal-body #id').val(id);
        $('.modal-body #question').val(question);
        $('.modal-body #answer').val(answer);

        });

        var table = $('#faq').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/getFAQ",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'question', name: 'question' },
                    { className: 'text-center', data: 'answer', name: 'answer' },
                    { className: 'text-center', data: 'edit', name: 'edit', orderable: false, searchable: false},
                    { className: 'text-center', data: 'delete', name: 'delete', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#faq').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Delete?',
                text: "Data cannot be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!',
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
                        $('#faq').DataTable().draw(false);
                    });
                }
            })
        });
    });

    //limit word in textarea
    jQuery(document).ready(function($) {
        var max = 500;
        $('textarea.max').keypress(function(e) {
            if (e.which < 0x20) {
                // e.which < 0x20, then it's not a printable character
                // e.which === 0 - Not a character
                return;     // Do nothing
            }
            if (this.value.length == max) {
                e.preventDefault();
            } else if (this.value.length > max) {
                // Maximum exceeded
                this.value = this.value.substring(0, max);
            }
        });
    }); //end if ready(fn)
    

</script>
@endsection
