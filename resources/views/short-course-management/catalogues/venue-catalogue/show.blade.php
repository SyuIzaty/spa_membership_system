@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        {{-- <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i>
                ({{ $shortcourse->id }}) {{ $shortcourse->name }}
            </h1>
        </div> --}}
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Short Course Information
                        </h2>
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
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a data-toggle="tab" class="nav-link" href="#general" role="tab">General</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#setting" role="tab">Setting</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane active" id="general" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <form action="{{ url('/shortcourses/update/' . $shortcourse->id) }}"
                                                    method="post" name="form">
                                                    @csrf
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead class="thead bg-primary-50">
                                                            <tr class=" bg-primary-50" scope="row">
                                                                <th colspan="2">
                                                                    <b>Basic Information</b>
                                                                    <a href="#" class="btn btn-sm btn-info float-right mr-2"
                                                                        name="edit-basic" id="edit-basic">
                                                                        <i class="fal fa-pencil"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger float-right mr-2"
                                                                        name="edit-basic-close" id="edit-basic-close"
                                                                        style="display: none">
                                                                        <i class="fal fa-window-close"></i>
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-success float-right mr-2"
                                                                        name="save-basic" id="save-basic"
                                                                        style="display: none">
                                                                        <i class="fal fa-save"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:plum">Name</td>
                                                                <td name="name_show" id="name_show">
                                                                    {{ $shortcourse->name }}
                                                                </td>
                                                                <td name="name_edit" id="name_edit" style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="name" name="name" type="text"
                                                                            value="{{ $shortcourse->name }}"
                                                                            class="form-control">
                                                                        @error('name')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="background-color:plum">Objective</td>
                                                                <td name="objective_show" id="objective_show">
                                                                    {!! $shortcourse->objective !!}
                                                                </td>
                                                                <td name="objective_edit" id="objective_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <textarea id="objective" name="objective"
                                                                            type="text"
                                                                            class="form-control">{{ $shortcourse->objective }}</textarea>
                                                                        @error('objective')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="background-color:plum">Description</td>
                                                                <td name="description_show" id="description_show">
                                                                    {!! $shortcourse->description !!}
                                                                </td>
                                                                <td name="description_edit" id="description_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <textarea id="description" name="description"
                                                                            type="text"
                                                                            class="form-control">{{ $shortcourse->description }}</textarea>
                                                                        @error('description')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <tbody>
                                                    </table>
                                                </form>
                                                <hr class="mt-2 mb-3">
                                                <table class="table table-striped table-bordered m-0" id="topic_field">
                                                    <thead class="thead">
                                                        <tr class=" bg-primary-50">
                                                            <th colspan="3"><b>List of Short Courses</b></th>
                                                        </tr>
                                                        <tr style="background-color:plum">
                                                            <th>Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($shortcourse->topics_shortcourses as $topic_shortcourse)
                                                            <tr>
                                                                <td>{{ $topic_shortcourse->topic->name }}
                                                                </td>
                                                                <td>
                                                                    <form method="post"
                                                                        action="/shortcourse/topic/detached/{{ $topic_shortcourse->id }}">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger float-right mr-2">
                                                                            <i class="ni ni-close"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <a href="javascript:;" name="addTopic" id="addTopic"
                                                    class="btn btn-primary btn-sm ml-auto float-right my-2">Add
                                                    More Topic</a>
                                                <hr class="mt-2 mb-3">
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-3">
                                    </div>

                                    <div class="tab-pane" id="setting" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">

                                                <div class="card">
                                                    <div class="card-body">
                                                        <table class="table table-striped table-bordered">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th class="text-center" scope="col" style="width:20%">
                                                                        <h3>Title</h3>
                                                                    </th>
                                                                    <th class="text-center" scope="col">
                                                                        <h3>Value</h3>
                                                                    </th>
                                                                    <th class="text-center" scope="col" style="width:20%">
                                                                        <h3>Action</h3>

                                                                    </th>
                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">Status</td>
                                                                    <td class="text-center"
                                                                        id="shortcourse_status_category_name"
                                                                        name="shortcourse_status_category_name">
                                                                        Active
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button {{$shortcourse->totalEvents ==0? null : 'disabled'}} href="javascript:;" id="delete_shortcourse"
                                                                            class="btn btn-danger mr-auto ml-2 waves-effect waves-themed font-weight-bold">DELETE</button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
            </div>
    </main>
@endsection
@section('script')
    <script>
        var shortcourse_id = '<?php echo $shortcourse->id; ?>';
        var shortcourse_name = '<?php echo $shortcourse->name; ?>';

        // General
        {
            // Basic Information
            {
                $("#edit-basic").click(function(e) {
                    $("#name_show").hide();
                    $("#name_edit").show();

                    $("#objective_show").hide();
                    $("#objective_edit").show();


                    $("#description_show").hide();
                    $("#description_edit").show();


                    $("#edit-basic").hide();
                    $("#save-basic").show();
                    $("#edit-basic-close").show();
                });

                $("#edit-basic-close").click(function(e) {
                    $("#name_show").show();
                    $("#name_edit").hide();

                    $("#max_participant_show").show();
                    $("#max_participant_edit").hide();

                    $("#objective_show").show();
                    $("#objective_edit").hide();

                    $("#description_show").show();
                    $("#description_edit").hide();


                    $("#edit-basic").show();
                    $("#save-basic").hide();
                    $("#edit-basic-close").hide();
                });

            }

            // Specific
            {
                ClassicEditor
                    .create(document.querySelector('#description'))
                    .catch(error => {
                        console.error(error);
                    });
                ClassicEditor
                    .create(document.querySelector('#objective'))
                    .catch(error => {
                        console.error(error);
                    });

            }

            $(document).ready(function() {

                var i = 1;
                $('#addTopic').click(function() {
                    i++;
                    $('#topic_field tbody').after(`
                            <tr id="new-row">
                                    <td>
                                        <select class="form-control topic${i}" name="shortcourse_topic"
                                        id="add_topic">
                                            <option value="-1" disabled selected>Select Topic
                                            </option>
                                            @foreach ($topics as $topic)
                                                <option value="{{ $topic->id }}">
                                                    {{ $topic->id }} -
                                                    {{ $topic->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="d-flex flex-row-reverse ">
                                        <a href="javascript:;" name="cancel-topic" id="cancel-topic" class="btn btn-sm btn-danger btn_remove mx-1">X</a>
                                        <a
                                            href="javascript:;"
                                            class="btn btn-sm btn-success mx-1"
                                            name="save-topic" id="save-topic">
                                            <i class="fal fa-save"></i>
                                        </a>
                                    </td>
                            </tr>
                    `);
                    $(`.topic${i}`).select2();
                    $('#addTopic').hide();

                    $(document).on('click', '#cancel-topic', function() {
                        $('#new-row').remove();
                        $("#addTopic").show();
                    });


                    $(document).on('click', '#save-topic', function() {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var $shortcourse_topic = $('#add_topic').val();
                        var data = {
                            shortcourse_topic: $shortcourse_topic
                        }
                        var url = '/shortcourse/topic/attached/' + shortcourse_id;

                        $.post(url, data).done(function() {
                                window.location.reload();
                            })
                            .fail(function() {
                                $('#new-row').show();
                                $("#addTopic").remove();
                                alert('Unable to add topic');
                            });
                    });
                });


                // Update Progress
                {
                    $('#delete_shortcourse').on('click',
                        function(e) {

                            const tag = $(e.currentTarget);

                            const title = "Delete Short Course";
                            const text = `Are you sure you want to delete '${shortcourse_name}'?`;
                            const confirmButtonText = "Delete";
                            const cancelButtonText = "Cancel";
                            const url = "/shortcourse/delete/"+shortcourse_id;
                            const urlRedirect = "/shortcourses";

                            e.preventDefault();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            Swal.fire({
                                title: title,
                                text: text,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: confirmButtonText,
                                cancelButtonText: cancelButtonText
                            }).then((result) => {
                                if (result.value) {
                                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            method: 'POST',
                                            submit: true
                                        }
                                    }).then((result) => {
                                        $(location).prop('href', urlRedirect);
                                    });

                                }
                            })
                        });
                }



            });


            // $(document).ready(function() {
            //     $('#save-topic').click(function() {
            //         $('#addTopic').show();

            //     });
            //     $('#cancel-topic').click(function() {
            //         $('#addTopic').show();

            //     });
            // });

        }
    </script>
@endsection
