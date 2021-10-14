@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
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
                            <hr class="mt-2 mb-3">
                            <div class="row">
                                <div class="col-md-12 grid-margin stretch-card">
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
                                                            >
                                                            <i class="fal fa-window-close"></i>
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success float-right mr-2"
                                                            name="save-basic" id="save-basic"
                                                            >
                                                            <i class="fal fa-save"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Name</td>
                                                    <td name="name_edit" id="name_edit" >
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
                                                    <td>Short Course Type</td>
                                                    <td name="shortcourse_type_edit" id="shortcourse_type_edit"
                                                        >
                                                        <div class="form-group">
                                                            <select class="form-control shortcourse_type "
                                                                name="shortcourse_type" id="shortcourse_type"
                                                                data-select2-id="shortcourse_type" tabindex="-1"
                                                                aria-hidden="true">
                                                                <option value="0"
                                                                    {{ $shortcourse->is_modular == 0 ? 'Selected' : '' }}>
                                                                    Regular Short Course
                                                                </option>
                                                                <option value="1"
                                                                    {{ $shortcourse->is_modular == 1 ? 'Selected' : '' }}>
                                                                    Modular Short Course
                                                                </option>
                                                            </select>
                                                            @error('shortcourse_type')
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
                                                    <td>Objective</td>
                                                    <td name="objective_edit" id="objective_edit"
                                                        >
                                                        <div class="form-group">
                                                            <textarea id="objective" name="objective"
                                                                type="text" rows="10"
                                                                class="form-control ck-editor__editable ck-editor__editable_inline">{{ $shortcourse->objective }}</textarea>
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
                                                    <td>Description</td>
                                                    <td name="description_edit" id="description_edit"
                                                        >
                                                        <div class="form-group">
                                                            <textarea id="description" name="description"
                                                                type="text" rows="10"
                                                                class="form-control ck-editor__editable ck-editor__editable_inline">{{ $shortcourse->description }}</textarea>
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
                                </div>
                            </div>
                            <hr class="mt-2 mb-3">
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
                $(`.shortcourse_type`).select2();
            });
        }
    </script>
@endsection
