@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon ni ni-briefcase'></i> SOP Management
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
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item mr-2" style="background-color:#95BFBC;">
                                    <a data-toggle="tab" style="background-color:#95BFBC;" class="nav-link" href="#one"
                                        role="tab">Part A</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#B99FC9;">
                                    <a data-toggle="tab" style="background-color:#B99FC9;" class="nav-link" href="#two"
                                        role="tab">Part B</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#EBCEDE;">
                                    <a data-toggle="tab" style="background-color:#EBCEDE;" class="nav-link" href="#four"
                                        role="tab">Part C</a>
                                </li>
                            </ul>
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
                                    <div class="tab-pane active" id="one" role="tabpanel">
                                        {!! Form::open(['action' => ['SOPController@storeDetails'], 'method' => 'POST']) !!}
                                        <input type="hidden" value="{{ $id }}" name="id">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header" style="background-color:#ede9e9;">Cover/Front
                                                        Page</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr class="text-center"
                                                                            style="background-color:#95BFBC;">
                                                                            <th>Department Name</th>
                                                                            <th>Department Code</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($department as $d)
                                                                            <tr>
                                                                                <td class="text-left">
                                                                                    {{ $d->department_name }}</td>
                                                                                <td class="text-center">
                                                                                    {{ $d->abbreviation }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr class="card-header text-center">
                                                                            <th style="background-color:#95BFBC; vertical-align: middle;"
                                                                                rowspan="2">SOP Code</th>
                                                                            <td class="text-center"
                                                                                style="background-color:#ffffff;">
                                                                                (Work Process)/(INTEC Code)/(Department
                                                                                Code)/(Unit Code)/(No. of Documents)
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                i.e: <b>WP/INTEC/QA/RC/01</b>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr class="card-header text-center">
                                                                            <th style="background-color:#95BFBC; vertical-align: middle;"
                                                                                rowspan="9">Reminder</th>
                                                                            <td class="text-left"
                                                                                style="background-color:#ffffff;">
                                                                                Each of SOPs must have the following details
                                                                                on:
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Purpose</b> (to briefly explain
                                                                                the
                                                                                purpose of SOP).</td>
                                                                        <tr>
                                                                            <td><b>Scope</b> (who would be affected/
                                                                                involved with the SOP).</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Reference</b> (any references
                                                                                would be
                                                                                used in the SOP process).</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Definition</b> (an abbreviation
                                                                                formed
                                                                                from the initial letters used in the
                                                                                SOP).</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Procedure</b> (main process as
                                                                                stated in
                                                                                the flow-chart need to briefly
                                                                                explain about the process).</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Review Record</b> in <b>Part
                                                                                    B</b> (information to be
                                                                                inserted if there is review,
                                                                                revision or amendment been done with
                                                                                the SOP).</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Forms</b> in <b>Part B</b> (to
                                                                                list-down all the related forms used
                                                                                in the SOP).</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Work Flow</b> in <b>Part C</b>
                                                                                (to list/ draw flow-chart of the
                                                                                process involved).</td>
                                                                        </tr>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr class="card-header text-center">
                                                                            <th style="background-color:#95BFBC; vertical-align: middle;"
                                                                                rowspan="9">Reference</th>
                                                                            <td class="text-left"
                                                                                style="background-color:#ffffff;">
                                                                                <a href="/sop-reference" title="Reference"
                                                                                    data-filter-tags="Reference"
                                                                                    target="_blank"
                                                                                    style="text-decoration: none!important">
                                                                                    <i class="fal fa-info-circle"></i>
                                                                                    <span class="nav-link-text"
                                                                                        data-i18n="nav.SOP-Reference">SOP
                                                                                        Sample</span>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        </div>

                                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                                        <div class="row mt-2">
                                                            <div class="form-group col-md-12">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">SOP Title
                                                                    </span>
                                                                </div>
                                                                <input type="text" id="title" name="title"
                                                                    value="{{ $data->sop }}" class="form-control"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-4">
                                                            <div class="form-group col-md-6">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Department
                                                                    </span>
                                                                </div>
                                                                <input type="text" id="department" name="department"
                                                                    value="{{ $data->department->department_name }}"
                                                                    class="form-control" disabled>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <div>
                                                                    <span class="input-group-text">SOP Code
                                                                    </span>
                                                                </div>
                                                                <input type="text" id="code" name="code"
                                                                    value="{{ old('code') }}" class="form-control"
                                                                    placeholder="Please key-in SOP Code" required>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="form-group col-md-4">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Prepared
                                                                        By</span>
                                                                </div>
                                                                <select class="form-control" name="prepared_by"
                                                                    id="prepared_by" required>
                                                                    <option disabled selected>Choose Staff</option>
                                                                    @foreach ($staff as $s)
                                                                        <option value="{{ $s->staff_id }}"
                                                                            {{ old('prepared_by') == $s->staff_id ? 'selected' : '' }}>
                                                                            {{ $s->staff_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Reviewed
                                                                        By</span>
                                                                </div>
                                                                <select class="form-control" name="reviewed_by"
                                                                    id="reviewed_by" required>
                                                                    <option disabled selected>Choose Staff</option>
                                                                    @foreach ($staff as $s)
                                                                        <option value="{{ $s->staff_id }}"
                                                                            {{ old('reviewed_by') == $s->staff_id ? 'selected' : '' }}>
                                                                            {{ $s->staff_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Approved
                                                                        By</span>
                                                                </div>
                                                                <select class="form-control" name="approved_by"
                                                                    id="approved_by" required>
                                                                    <option disabled selected>Choose Staff</option>
                                                                    @foreach ($staff as $s)
                                                                        <option value="{{ $s->staff_id }}"
                                                                            {{ old('approved_by') == $s->staff_id ? 'selected' : '' }}>
                                                                            {{ $s->staff_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top: 15px;">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header" style="background-color:#ede9e9;">SOP Details
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Purpose
                                                                    </span>
                                                                </div>
                                                                <textarea class="form-control" id="example-textarea" rows="8" name="purpose"
                                                                    placeholder="Please key-in the purpose" required>{{ old('purpose') }}</textarea>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Scope
                                                                    </span>
                                                                </div>
                                                                <textarea class="form-control" id="example-textarea" rows="8" name="scope"
                                                                    placeholder="Please key-in the scope" required>{{ old('scope') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="form-group col-md-6">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Reference
                                                                    </span>
                                                                </div>
                                                                <textarea value="" class="form-control summernoteRef" id="reference" name="reference">{{ old('reference') }}</textarea>

                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Definitions
                                                                    </span>
                                                                </div>
                                                                <textarea value="" class="form-control summernoteDef" id="definition" name="definition">{{ old('definition') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="form-group col-md-12">
                                                                <div>
                                                                    <span class="input-group-text"
                                                                        style="background-color:#f3f3f37a;">Procedures
                                                                    </span>
                                                                </div>
                                                                <textarea value="" class="form-control summernotePro" id="procedure" name="procedure" required>{{ old('procedure') }}</textarea>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary ml-auto float-right"
                                            style="margin-top:10px;"><i class="fal fa-save"></i>
                                            Save</button>

                                        {!! Form::close() !!}
                                    </div>
                                    <div class="tab-pane" id="two" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Record</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                {!! Form::open([
                                                                    'action' => 'SOPController@storeReviewRecord',
                                                                    'method' => 'POST',
                                                                    'enctype' => 'multipart/form-data',
                                                                ]) !!}

                                                                <input type="hidden" name="id"
                                                                    value="{{ $data->id }}">

                                                                <table class="table table-bordered" id="addReview">
                                                                    <thead>
                                                                        <tr class="card-header text-center"
                                                                            style="background-color:#F7E4EB;">
                                                                            <th colspan="3">REVIEW</th>
                                                                        </tr>
                                                                        <tr class="card-header text-center"
                                                                            style="background-color:#F7E4EB;">
                                                                            <th>Date</th>
                                                                            <th>Details</th>
                                                                            <th>
                                                                                <button type="button" id="add"
                                                                                    class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed">
                                                                                    <i class="fal fa-plus"></i>
                                                                                </button>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <button type="submit" style="margin-bottom: 10px;"
                                                                    class="btn btn-sm btn-primary float-right"><i
                                                                        class="fal fa-save"></i> Save
                                                                </button>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                {!! Form::open([
                                                                    'action' => 'SOPController@storeFormRecord',
                                                                    'method' => 'POST',
                                                                    'enctype' => 'multipart/form-data',
                                                                ]) !!}

                                                                <input type="hidden" name="id"
                                                                    value="{{ $data->id }}">

                                                                <table class="table table-bordered" id="addForm">
                                                                    <thead>
                                                                        <tr class="card-header text-center"
                                                                            style="background-color:#F7E4EB;">
                                                                            <th colspan="3">FORMS</th>
                                                                        </tr>
                                                                        <tr class="card-header text-center"
                                                                            style="background-color:#F7E4EB;">
                                                                            <th>Code</th>
                                                                            <th>Details</th>
                                                                            <th>
                                                                                <button type="button" id="add"
                                                                                    class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed">
                                                                                    <i class="fal fa-plus"></i>
                                                                                </button>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <button type="submit" style="margin-bottom: 10px;"
                                                                    class="btn btn-sm btn-primary float-right"><i
                                                                        class="fal fa-save"></i> Save
                                                                </button>
                                                                {!! Form::close() !!}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="four" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Work Flow (Flow Chart)</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <input type="file" class="form-control"
                                                                    style="margin-bottom: 10px;"
                                                                    accept="image/png, image/jpeg" name="attachment"
                                                                    required multiple>
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
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#prepared_by,#reviewed_by,#approved_by').select2();

            $('.summernoteRef').summernote({
                spellCheck: true,
                placeholder: 'Please key-in the reference (if any)',
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['fullscreen']
                ]
            });
            $('.summernoteDef').summernote({
                spellCheck: true,
                placeholder: 'Please key-in the definition (if any)',
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['paragraph']],
                    ['fullscreen']
                ]
            });
            $('.summernotePro').summernote({
                height: 500,
                spellCheck: true,
                placeholder: 'Please key-in the procedure',
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['fullscreen']
                ]
            });

            $('#review').click(function() {
                s++;
                $('#addReview').append(`
                <tr id="rowReview${s}" name="rowReview${s}">
                    <div class="form-group">
                        <td>
                            <input type="text" class="form-control reviewDate" id="reviewDates${s}"
                            name="reviewDate[]" required>{{ $dateNow }}
                        </td>
                        <td>
                            <textarea class="form-control details${s}" id="example-textarea" rows="2" name="details[]" required></textarea>
                        </td>
                        <td class="text-center" style="width: 10%;">
                            <button type="button" id="${s}" class="remove_review btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i class="fal fa-times"></i></button>
                        </td>
                    </div>
                </tr>`);
            });

            var s = 0;

            $(document).on('click', '.remove_review', function() {
                var buttonReview = $(this).attr("id");
                $("[name='rowReview" + buttonReview + "']").remove();
            });

            $('#form').click(function() {
                f++;
                $('#addForm').append(`
                <tr id="rowForm${f}" name="rowForm${f}">
                    <div class="form-group">
                        <td>
                            <input type="text" class="form-control code" id="codes${f}"
                            name="code[]" required>
                        </td>
                        <td>
                            <textarea class="form-control details${f}" id="example-textarea" rows="2" name="details[]" required></textarea>
                        </td>
                        <td class="text-center" style="width: 10%;">
                            <button type="button" id="${f}" class="remove_form btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed"><i class="fal fa-times"></i></button>
                        </td>
                    </div>
                </tr>`);
            });

            var f = 0;

            $(document).on('click', '.remove_form', function() {
                var buttonForm = $(this).attr("id");
                $("[name='rowForm" + buttonForm + "']").remove();
            });
        });
    </script>
@endsection
