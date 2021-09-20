@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Feedback Set Information
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
                                    <a data-toggle="tab" class="nav-link" style="display:none" href="#setting"
                                        role="tab">Setting</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane active" id="general" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">

                                                @if (Session::has('successUpdate'))
                                                    <div class="alert alert-success"
                                                        style="color: #3b6324; background-color: #d3fabc;">
                                                        <i class="icon fal fa-check-circle"></i>
                                                        {{ Session::get('successUpdate') }}
                                                    </div>
                                                @endif
                                                <form
                                                    action="{{ url('/event_feedback_sets/update/' . $event_feedback_set->id) }}"
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
                                                                <td class="col-md-3">Name</td>
                                                                <td name="name_show" id="name_show">
                                                                    {{ $event_feedback_set->name }}
                                                                </td>
                                                                <td name="name_edit" id="name_edit" style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="name" name="name" type="text"
                                                                            value="{{ $event_feedback_set->name }}"
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
                                                                <td class="col-md-3">Feedback Set Description</td>
                                                                <td name="description_show" id="description_show">
                                                                    {{ $event_feedback_set->description }}
                                                                </td>
                                                                <td name="description_edit" id="description_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="description" name="description"
                                                                            type="text"
                                                                            value="{{ $event_feedback_set->description }}"
                                                                            class="form-control">
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

                                                <table class="table table-striped table-bordered">
                                                    <thead class="table-primary">
                                                        <tr class=" bg-primary-50">
                                                            <th colspan="3"><b>Settings</b></th>
                                                        </tr>
                                                        <tr>
                                                        <tr>
                                                            <th class="text-center" scope="col">
                                                                Value
                                                            </th>
                                                            <th class="text-center" scope="col" style="width:20%">
                                                                Action

                                                            </th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center"
                                                                id="event_feedback_set_status_category_name"
                                                                name="event_feedback_set_status_category_name">
                                                                Active
                                                            </td>
                                                            <td class="text-center">
                                                                <button
                                                                    {{ $event_feedback_set->totalEvents == 0 ? null : 'disabled' }}
                                                                    href="javascript:;" id="delete_event_feedback_set"
                                                                    class="btn btn-danger mr-auto ml-2 waves-effect waves-themed font-weight-bold">DELETE</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-3">
                                    </div>

                                    <div class="tab-pane" id="setting" role="tabpanel" style="display:none">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <table class="table table-striped table-bordered">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th class="text-center" scope="col">
                                                                        <h3>Value</h3>
                                                                    </th>
                                                                    <th class="text-center" scope="col"
                                                                        style="width:20%">
                                                                        <h3>Action</h3>

                                                                    </th>
                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center"
                                                                        id="event_feedback_set_status_category_name"
                                                                        name="event_feedback_set_status_category_name">
                                                                        Active
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button
                                                                            {{ $event_feedback_set->totalEvents == 0 ? null : 'disabled' }}
                                                                            href="javascript:;"
                                                                            id="delete_event_feedback_set"
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
        var event_feedback_set_id = '<?php echo $event_feedback_set->id; ?>';
        var event_feedback_set_name = '<?php echo $event_feedback_set->name; ?>';

        // General
        {
            // Basic Information
            {
                $("#edit-basic").click(function(e) {
                    $("#name_show").hide();
                    $("#name_edit").show();

                    $("#description_show").hide();
                    $("#description_edit").show();

                    $("#edit-basic").hide();
                    $("#save-basic").show();

                    $("#edit-basic-close").show();
                });

                $("#edit-basic-close").click(function(e) {
                    $("#name_show").show();
                    $("#name_edit").hide();

                    $("#description_edit").hide();
                    $("#description_show").show();

                    $("#edit-basic").show();
                    $("#save-basic").hide();

                    $("#edit-basic-close").hide();
                });

            }

            $('.event_feedback_set_type').select2();

            // Delete Feedback Set
            {
                $('#delete_event_feedback_set').on('click',
                    function(e) {

                        const tag = $(e.currentTarget);

                        const title = "Delete Feedback Set";
                        const text = `Are you sure you want to delete '${event_feedback_set_name}'?`;
                        const confirmButtonText = "Delete";
                        const cancelButtonText = "Cancel";
                        const url = "/event_feedback_set/delete/" + event_feedback_set_id;
                        const urlRedirect = "/event_feedback_sets";

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
        }
    </script>
@endsection
