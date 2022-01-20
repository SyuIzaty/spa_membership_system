@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file-alt'></i> i-Complaint
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of User Category</h2>
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
                                <table id="categorylist" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-success-50 text-center">
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Code</th>
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
                                            <td class="hasinput"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href= "#" data-target="#add" data-toggle="modal" class="btn btn-danger waves-effect waves-themed float-right" style="margin-right:7px;"><i class="fal fa-plus-square"></i> Add New User Category</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="add" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Add New User Category </h5>
                    </div>
                    <div class="modal-body">
                    {!! Form::open(['action' => 'AduanKorporatController@addUserCategory', 'method' => 'POST']) !!}
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Category</span>
                                </div>
                                <input type="text" name="category" class="form-control max" required>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*Limit to 50 characters only</i></span>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Code</span>
                                </div>
                                <input type="text" name="code" class="form-control maxCode" required>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*3 characters only</i></span>
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
                        <h5 class="card-title w-100">Edit User Category </h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'AduanKorporatController@updateUserCategory', 'method' => 'POST']) !!}
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Category</span>
                                </div>
                                <input type="text" id="category" name="category" class="form-control maxCode" required>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*Limit to 50 characters only</i></span>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Code</span>
                                </div>
                                <input type="text" id="code" name="code" class="form-control max" required>
                            </div>
                            <span style="font-size: 10px; color: red;"><i>*3 characters only</i></span>
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
        var category = button.data('category') // data-category
        var code = button.data('code') // data-code

        $('.modal-body #id').val(id);
        $('.modal-body #category').val(category);
        $('.modal-body #code').val(code);

        });

        var table = $('#categorylist').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/get-usercategory-list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'description', name: 'description' },
                    { className: 'text-center', data: 'code', name: 'code' },
                    { className: 'text-center', data: 'edit', name: 'edit', orderable: false, searchable: false},
                    { className: 'text-center', data: 'delete', name: 'delete', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#categorylist').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#categorylist').DataTable().draw(false);
                    });
                }
            })
        });
    });

    //limit word in textarea
    jQuery(document).ready(function($) {
        var max = 50;
        $('.max').keypress(function(e) {
            if (e.which < 0x20) {
                return;     // Do nothing
            }
            if (this.value.length == max) {
                e.preventDefault();
            } else if (this.value.length > max) {
                // Maximum exceeded
                this.value = this.value.substring(0, max);
            }
        });
    });

    jQuery(document).ready(function($) {
        var maxCode = 3;
        $('.maxCode').keypress(function(e) {
            if (e.which < 0x20) {
                return;     // Do nothing
            }
            if (this.value.length == maxCode) {
                e.preventDefault();
            } else if (this.value.length > maxCode) {
                // Maximum exceeded
                this.value = this.value.substring(0, maxCode);
            }
        });
    });

</script>
@endsection
