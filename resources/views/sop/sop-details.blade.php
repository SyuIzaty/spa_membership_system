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
                                        role="tab">SOP Details</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#B99FC9;">
                                    <a data-toggle="tab" style="background-color:#B99FC9;" class="nav-link" href="#two"
                                        role="tab">Review Record</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#EEE2C7;">
                                    <a data-toggle="tab" style="background-color:#EEE2C7;" class="nav-link" href="#three"
                                        role="tab">Forms</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#EBCEDE;">
                                    <a data-toggle="tab" style="background-color:#EBCEDE;" class="nav-link" href="#four"
                                        role="tab">Work Flow</a>
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
                                        @include('sop.sop-details-1')
                                    </div>
                                    <div class="tab-pane" id="two" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Review Record</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                @include('sop.sop-review')
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="three" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Forms</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr class="card-header text-center">
                                                                            <th style="background-color:#EEE2C7; vertical-align: middle;"
                                                                                rowspan="2">Forms
                                                                                Code</th>
                                                                            <td class="text-center"
                                                                                style="background-color:#ffffff;">
                                                                                (Work Process)/(INTEC Code)/(Department
                                                                                Code)/(Unit Code)/(No. of Documents)-(No. of
                                                                                Forms)
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-center">
                                                                                i.e: <b>WP/INTEC/QA/RC/01-01</b>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                @include('sop.sop-forms')
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
                                                                <form method="post" action="{{ url('store-work-flow') }}"
                                                                    enctype="multipart/form-data"
                                                                    class="dropzone needsclick dz-clickable"
                                                                    id="dropzone">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $id }}">
                                                                    <div class="dz-message needsclick">
                                                                        <i class="fal fa-cloud-upload text-muted mb-3"></i>
                                                                        <br>
                                                                        <span class="text-uppercase">Drop files here or
                                                                            click to
                                                                            upload.</span>
                                                                        <br>
                                                                        <span class="fs-sm text-muted">This is a dropzone.
                                                                            Selected
                                                                            files
                                                                            <strong>.pdf,.doc,.docx,.jpeg,.jpg,.png</strong>
                                                                            are actually uploaded.</span>
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
            $('#prepared_by,#reviewed_by,#approved_by').select2();

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
                            <input type="text" class="form-control reviewDate" value="{{ $dateNow }}" id="reviewDates"
                            name="reviewDate[]" required disabled>
                        </td>
                        <td>
                            <textarea class="form-control details" id="details${s}" rows="2" name="details[]" required></textarea>
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
                            <input type="text" class="form-control formCode" id="formCode${f}"
                            name="formCode[]" required>
                        </td>
                        <td>
                            <textarea class="form-control formDetail${f}" id="example-textarea" rows="2" name="formDetail[]" required></textarea>
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
