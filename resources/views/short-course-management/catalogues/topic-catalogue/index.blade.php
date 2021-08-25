@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Topic
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Topics</h2>
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
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped w-100" id="topic">
                                                <thead>
                                                    <tr class="bg-primary-50 text-center">
                                                        <th>ID</th>
                                                        <th>NAME</th>
                                                        <th>DATES</th>
                                                        <th>SHORTCOURSES</th>
                                                        <th>MANAGE. DETAILS</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                            style="content-align:right">
                                            <a href="javascript:;" id="createTopic"
                                                class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                                    class="ni ni-plus"> </i> Create New Topic</a>

                                            <div class="modal fade" id="crud-modal-topic" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="card-header">
                                                            <h5 class="card-title w-150">Add Topic</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ url('/topic') }}" method="post" name="form">
                                                                @csrf
                                                                <p><span class="text-danger">*</span>
                                                                    Vital Information</p>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label for="topic_name"><span
                                                                            class="text-danger">*</span>
                                                                        Topic Name</label>
                                                                    {{ Form::text('topic_name', '', ['class' => 'form-control', 'placeholder' => 'Topic Name', 'id' => 'topic_name']) }}
                                                                    @error('topic_name')
                                                                        <p style="color: red">{{ $message }}
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label for="subcategory_id"><span
                                                                            class="text-danger">*</span>
                                                                        Subcategory</label>
                                                                    <select class="form-control subcategory"
                                                                        name="subcategory_id" id="subcategory_id">
                                                                        <option disabled selected>Choose a Subcategory
                                                                        </option>
                                                                        @foreach ($subcategories as $subcategory)
                                                                            <option value='{{ $subcategory->id }}'
                                                                                name="{{ $subcategory->name }}">
                                                                                {{ $subcategory->id }} -
                                                                                {{ $subcategory->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('subcategory_id')
                                                                        <p style="color: red">{{ $message }}
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label for="category_id"><span
                                                                            class="text-danger">*</span>
                                                                        Category</label>
                                                                    <select class="form-control category" name="category_id"
                                                                        id="category_id" disabled>
                                                                        <option disabled selected>Choose a Category</option>
                                                                        @foreach ($categories as $category)
                                                                            <option value='{{ $category->id }}'
                                                                                name="{{ $category->name }}">
                                                                                {{ $category->id }} -
                                                                                {{ $category->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('category_id')
                                                                        <p style="color: red">{{ $message }}
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="footer" id="add_contact_person_footer">
                                                                    <button type="button"
                                                                        class="btn btn-danger ml-auto float-right mr-2"
                                                                        data-dismiss="modal"
                                                                        id="close-add-contact_person"><i
                                                                            class="fal fa-window-close"></i>
                                                                        Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success ml-auto float-right mr-2"
                                                                        id="registration_update_submit">Create</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="crud-modal-topic-edit" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="card-header">
                                                            <h5 class="card-title w-150">Edit Topic</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ url('/topic/update') }}" method="post"
                                                                name="form">
                                                                @csrf
                                                                <p><span class="text-danger">*</span>
                                                                    Vital Information</p>
                                                                <hr class="mt-1 mb-2">
                                                                <input type="text" name="topic_id_edit" id="topic_id_edit"
                                                                    hidden />
                                                                <div class="form-group">
                                                                    <label for="topic_name_edit"><span
                                                                            class="text-danger">*</span>
                                                                        Topic Name</label>
                                                                    {{ Form::text('topic_name_edit', '', ['class' => 'form-control', 'placeholder' => 'Topic Name', 'id' => 'topic_name_edit']) }}
                                                                    @error('topic_name_edit')
                                                                        <p style="color: red">{{ $message }}
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label for="subcategory_id_edit"><span
                                                                            class="text-danger">*</span>
                                                                        Subcategory</label>
                                                                    <select class="form-control subcategory"
                                                                        name="subcategory_id_edit" id="subcategory_id_edit">
                                                                        <option disabled selected>Choose a Subcategory
                                                                        </option>
                                                                        @foreach ($subcategories as $subcategory)
                                                                            <option value='{{ $subcategory->id }}'
                                                                                name="{{ $subcategory->name }}">
                                                                                {{ $subcategory->id }} -
                                                                                {{ $subcategory->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('subcategory_id_edit')
                                                                        <p style="color: red">{{ $message }}
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label for="category_id_edit"><span
                                                                            class="text-danger">*</span>
                                                                        Category</label>
                                                                    <select class="form-control category_edit"
                                                                        name="category_id_edit" id="category_id_edit"
                                                                        disabled>
                                                                        <option disabled selected>Choose a Category</option>
                                                                        @foreach ($categories as $category)
                                                                            <option value='{{ $category->id }}'
                                                                                name="{{ $category->name }}">
                                                                                {{ $category->id }} -
                                                                                {{ $category->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('category_id')
                                                                        <p style="color: red">{{ $message }}
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="footer" id="add_contact_person_footer_edit">
                                                                    <button type="button"
                                                                        class="btn btn-danger ml-auto float-right mr-2"
                                                                        data-dismiss="modal"
                                                                        id="close-add-contact_person_edit"><i
                                                                            class="fal fa-window-close"></i>
                                                                        Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-success ml-auto float-right mr-2"
                                                                        id="registration_update_submit_edit">Edit</button>
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
        </div>
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#topic thead tr .hasinput').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

                $('select', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });


            var table = $('#topic').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/topics/data",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'dates',
                        name: 'dates'
                    },
                    {
                        data: 'total_shortcourses',
                        name: 'total_shortcourses'
                    },
                    {
                        data: 'management_details',
                        name: 'management_details'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                orderCellsTop: true,
                "order": [
                    [0, "desc"]
                ],
                "initComplete": function(settings, json) {


                }
            });



            // Create Topic
            {
                $('#createTopic').click(function() {
                    $('#crud-modal-topic').modal('show');
                });

                $('#crud-modal-topic').on('show.bs.modal', function(event) {});

                $('#subcategory_id').change(function(event) {
                    console.log(this.value);
                    var subcategory = this.value;
                    var subcategories = @json($subcategories);


                    var selected_subcategory = subcategories.find((x) => {
                        return x.id == subcategory;
                    });
                    $('#category_id').val('');
                    $('#category_id').val(selected_subcategory.category_id);
                });
            }

            // Edit Topic
            {
                $('#editTopic').click(function() {
                    var id = null;
                    var name = null;
                    var subcategory_id = null;
                    $('.modal-body #topic_id_edit').val(id);
                    $('.modal-body #topic_name_edit').val(name);
                    $('.modal-body #subcategory_id_edit').val(subcategory_id);
                    $('#crud-modal-topic-edit').modal('show');
                });

                $('#crud-modal-topic-edit').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id');
                    var name = button.data('name');
                    var subcategory_id = button.data('subcategory_id');

                    $('.modal-body #topic_id_edit').val(id);
                    $('.modal-body #topic_name_edit').val(name);
                    $('.modal-body #subcategory_id_edit').val(subcategory_id);
                    $('#subcategory_id_edit').trigger('change');
                });

                $('#subcategory_id_edit').change(function(event) {
                    var subcategory = this.value;
                    var subcategories = @json($subcategories);

                    var selected_subcategory = subcategories.find((x) => {
                        return x.id == subcategory;
                    });
                    $('#category_id_edit').val('');
                    $('#category_id_edit').val(selected_subcategory.category_id);
                });
            }

            // Delete Topic
            {
                $('#topic').on('click', '.btn-delete[data-remote]', function(e) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var url = $(this).data('remote');

                    Swal.fire({
                        title: 'Delete Topic?',
                        text: "This topic will be deleted!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete this topic!',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: url,
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    method: '_DELETE',
                                    submit: true
                                }
                            }).always(function(data) {
                                $('#topic').DataTable().draw(false);
                            });

                            var delayInMilliseconds = 5000; //5 second

                            setTimeout(function() {
                                //your code to be executed after 5 second
                                // $('#student').DataTable().ajax.reload();
                                window.location.reload(true);
                            }, delayInMilliseconds);
                        }
                    })

                });
            }
        });
    </script>
@endsection
