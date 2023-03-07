@extends('layouts.admin')

@section('content')
    <style>
        #buttons {
            display: none;
        }

        li:hover #buttons {
            display: inline;
        }

        #edit {
            display: none;
        }

        li:hover #edit {
            display: inline;
        }
    </style>

    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-folder'></i> eDocument Management
            </h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Folder: {{ $folder->title }}</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <form id="form-id">
                        @csrf
                        <input type="hidden" id="id" name="id" value="{{ $folder->id }}" required>
                        <button type="submit" class="btn btn-danger ml-auto float-right waves-effect waves-themed"
                            id="deleteFol" style="margin-top:10px; margin-right: 20px;"><i class="fal fa-times-circle"></i>
                            Delete
                            Folder</button>
                    </form>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="col-md-12">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;">
                                        <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row mt-5">
                                        <div class="col-md-12">
                                            <div class="card card-success card-outline">
                                                <div class="card-header bg-info text-white">
                                                    <h5 class="card-title w-100"><i
                                                            class="fal fa-upload width-2 fs-xl"></i>UPLOAD FILE</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form method="post" action="{{ url('store-file-folder') }}"
                                                        enctype="multipart/form-data"
                                                        class="dropzone needsclick dz-clickable" id="dropzone">
                                                        @csrf
                                                        <input type="hidden" name="dept_id"
                                                            value="{{ $folder->department_id }}">
                                                        <input type="hidden" name="fol_id" value="{{ $folder->id }}">

                                                        <div class="dz-message needsclick">
                                                            <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                                                            <span class="text-uppercase">Drop files here or click to
                                                                upload.</span>
                                                            <br>
                                                            <span class="fs-sm text-muted">This is a dropzone. Selected
                                                                files <strong>.pdf,.doc,.docx,.jpeg,.jpg,.png</strong>
                                                                are actually uploaded.</span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="card card-success card-outline">
                                                <div class="card-header bg-info text-white">
                                                    <h5 class="card-title w-100"><i
                                                            class="fal fa-file width-2 fs-xl"></i>FILE LIST</h5>
                                                </div>
                                                @if ($file->isNotEmpty())
                                                    @php $i = 1; @endphp
                                                    <div class="card-body">
                                                        <table class="table table-bordered editable" id="editable">
                                                            <thead class="bg-info-50">
                                                                <tr class="text-center">
                                                                    <td>No.</td>
                                                                    <td>File</td>
                                                                    <td>File Ext.</td>
                                                                    <td>Category</td>
                                                                    <td>View</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($file as $f)
                                                                    <tr>
                                                                        <td class="text-center">{{ $i }}</td>
                                                                        <td style="display:none"><input
                                                                                name="id">{{ $f->id }}</td>
                                                                        <td class='title'>{{ $f->title }}</td>
                                                                        <td class="text-center">{{ $f->file_ext }}
                                                                        </td>
                                                                        <td class="category"
                                                                            data-selected="{{ $f->category }}"></td>
                                                                        <td class="text-center">
                                                                            <a target="_blank"
                                                                                href="/get-doc/{{ $f->id }}"
                                                                                class="btn btn-info btn-xs"><i
                                                                                    class="fal fa-eye"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    @php $i++; @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="card-body">
                                                        <p class="text-center"><b>NO FILE UPLOADED</b></p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="addModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="card-header">
                                            <h5 class="card-title w-100">Edit Title</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form-title">
                                                @csrf
                                                <input type="hidden" name="id" id="id" />

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Title</span>
                                                        </div>
                                                        <input class="form-control" name="title" id="title">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Category</span>
                                                        </div>
                                                        <select class="custom-select form-control" name="category"
                                                            id="category">
                                                            <option disabled selected value="">Select Category
                                                            </option>
                                                            @foreach ($category as $c)
                                                                <option value="{{ $c->id }}">{{ $c->description }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="footer">
                                                    <button type="submit" id="saves"
                                                        class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i
                                                            class="fal fa-save"></i> Save</button>
                                                    <button type="button"
                                                        class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed"
                                                        data-dismiss="modal"><i class="fal fa-window-close"></i>
                                                        Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
        Dropzone.autoDiscover = false;

        $(document).ready(function() {

            $(".nofile").click(function() {
                Swal.fire({
                    title: 'File not found!',
                    text: 'Please contact IITU for further assistance.',
                })
            });

            $("#dropzone").dropzone({
                addRemoveLinks: true,
                maxFiles: 10, //change limit as per your requirements
                dictMaxFilesExceeded: "Maximum upload limit reached",
                init: function() {
                    this.on("queuecomplete", function(file) {
                        location.reload();
                    });
                },
            });

            $(".editTitle").on('click', function(e) {

                var id = $(this).data('id');
                var title = $(this).data('title');
                var category = $(this).data('category');


                $(".modal-body #id").val(id);
                $(".modal-body #title").val(title);
                $(".modal-body #category").val(category);


                $('#addModal').modal('show');
            });

            $(".delete-alert").on('click', function(e) {

                let id = $(this).data('path');

                Swal.fire({
                    title: 'Delete?',
                    text: "Data cannot be restored!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Delete!',
                    cancelButtonText: 'No'
                }).then(function(e) {
                    if (e.value === true) {
                        $.ajax({
                            type: "DELETE",
                            url: "/delete-doc/" + id,
                            data: id,
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response);
                                if (response) {
                                    Swal.fire(response.success);
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        e.dismiss;
                    }
                }, function(dismiss) {
                    return false;
                })
            });

            //edit

            $("#addModal").submit(function(e) {

                e.preventDefault();

                var datas = $('#form-title').serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ url('update-title') }}",
                    data: datas,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $('#addModal').modal('hide');
                            Swal.fire(response.success);
                            location.reload();
                        }
                    },
                    error: function(error) {
                        console.log(error)
                        alert("Error");
                    }
                });

            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });

            // Start: Edit title & category

            $('.editable').Tabledit({
                url: '{{ url('update-title') }}',
                dataType: "json",
                columns: {
                    identifier: [1, 'id'],
                    editable: [
                        [2, 'title'],
                        [4, 'category']
                    ]
                },
                restoreButton: false,

                onSuccess: function(data, textStatus, jqXHR) {
                    if (data.action == 'delete') {
                        $('#' + data.id).remove();
                    }
                }
            });

            $('.category').each(function() {
                var selected = $(this).data('selected');
                var select = $(
                    `<input type="hidden" name="category" data-type="changed" class="select" value="${selected}"><select class="categories form-control"></select>`
                )
                select.append('<option disabled selected value="">Select Category</option>');
                @foreach ($category as $c)
                    select.append(
                        '<option value="{{ $c['id'] }}" >{{ $c['description'] }}</option>');
                @endforeach
                $(this).html(select);
                $(this).children('select').val(selected).change();
            });

            $('.categories').on('change', function() {
                var selected = $(this).val();
                $(this).siblings('.select').val(selected);
            });

            $('.tabledit-edit-button').on('click', function() {
                $('input[data-type="changed"]').each(function() {
                    if ($(this).hasClass('tabledit-input')) {
                        $(this).removeClass('tabledit-input');
                    }
                });
                $(this).closest('tr').find('.select').addClass('tabledit-input');
            });

            $('.tabledit-view-mode').find('select').each(function() {
                $(this).attr('disabled', 'disabled');
            });

            $('.tabledit-edit-button').on('click', function() {
                if ($(this).hasClass('active')) {
                    $(this).parents('tr').find('select').attr('disabled', 'disabled');
                } else {
                    $(this).parents('tr').find('select').removeAttr('disabled');
                }
            });

            $('.tabledit-save-button').on('click', function() {
                $(this).parents('tr').find('select').attr('disabled', 'disabled');
            })

            // End: Edit title & category
        });

        $("#deleteFol").on('click', function(e) {
            e.preventDefault();

            var datas = $('#form-id').serialize();

            Swal.fire({
                title: 'Are you sure you want to delete this folder?',
                text: "All files cannot be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'No'
            }).then((result) => {

                if (result.value) {
                    Swal.fire({
                        title: 'Loading..',
                        text: 'Please wait..',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        onOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ url('delete-folder') }}",
                        data: datas,
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            if (response) {
                                Swal.fire(response.success);
                                window.location = "/upload";
                            }
                        }
                    });
                }
            })
        });
    </script>
@endsection
