@extends('layouts.admin')

@section('content')
    <style>
        /* styles.css */

        /* Button style */
        .btn-delete {
            background-color: transparent;
            color: #fd3995;
            transition: background-color 0.3s;
        }

        /* Hover effect */
        .btn-delete:hover {
            background-color: #fd3995;
            /* Change the background color on hover */
        }
    </style>
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
                                <li class="nav-item mr-2" style="background-color:#EEE2C7;">
                                    <a data-toggle="tab" style="background-color:#EEE2C7;" class="nav-link" href="#two"
                                        role="tab">Forms</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#EBCEDE;">
                                    <a data-toggle="tab" style="background-color:#EBCEDE;" class="nav-link" href="#three"
                                        role="tab">Work Flow</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#B99FC9;">
                                    <a data-toggle="tab" style="background-color:#B99FC9;" class="nav-link" href="#four"
                                        role="tab">Review Record</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#9fc6c9;">
                                    <a data-toggle="tab" style="background-color:#9fc6c9;" class="nav-link" href="#five"
                                        role="tab">Generate SOP</a>
                                </li>
                                <li class="nav-item mr-2" style="background-color:#9fc9b2;">
                                    <a data-toggle="tab" style="background-color:#9fc9b2;" class="nav-link" href="#six"
                                        role="tab">Comment</a>
                                </li>
                                @can('Manage SOP')
                                    @if ($data->status != '1')
                                        <li class="nav-item mr-2" style="background-color:#c99f9f;">
                                            <a data-toggle="tab" style="background-color:#c99f9f;" class="nav-link"
                                                href="#seven" role="tab">Verify SOP</a>
                                        </li>
                                    @endif
                                @endcan
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
                                        @include('sop.sop-details')
                                    </div>
                                    <div class="tab-pane" id="two" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Forms</div>
                                                    <div class="card-body">
                                                        @if (!isset($sop))
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <p style="color: red">Please filling out SOP Details
                                                                        section
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @else
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
                                                                                    Code)/(Unit Code)/(No. of
                                                                                    Documents)-(No. of
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
                                                        @endif
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
                                                    <div class="card-header">Work Flow (Flow Chart)</div>
                                                    <div class="card-body">
                                                        @include('sop.sop-work-flow')
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
                                                    <div class="card-header">Review Record</div>
                                                    <div class="card-body">
                                                        @include('sop.sop-review')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="five" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Generate SOP</div>
                                                    <div class="card-body">
                                                        @include('sop.sop-generate')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="six" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Comment</div>
                                                    <div class="card-body">
                                                        @include('sop.sop-comment')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @can('Manage SOP')
                                        <div class="tab-pane" id="seven" role="tabpanel">
                                            <hr class="mt-2 mb-3">
                                            <div class="row">
                                                <div class="col-md-12 grid-margin stretch-card">
                                                    <div class="card">
                                                        <div class="card-header">Verify SOP</div>
                                                        <div class="card-body">
                                                            @include('sop.sop-verify')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
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

        function Print(button) {
            var url = $(button).data('page');
            var printWindow = window.open('{{ url('/') }}' + url + '', 'Print',
                'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            }, true);
        }

        $(document).ready(function() {

            $('#prepared_by,#reviewed_by,#approved_by').select2();

            $("#comments").on('click', function(e) {
                e.preventDefault();
                var datas = $('#form-comment').serialize();

                Swal.fire({
                    title: 'Are you sure you want to submit?',
                    text: "Once submitted, comments cannot be edited.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Submit!',
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
                            url: "{{ url('comment-sop') }}",
                            data: datas,
                            dataType: "json",
                            success: function(response) {
                                console.log(response);
                                if (response) {
                                    Swal.fire(response.success);
                                    location.reload();
                                }
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                Swal.fire(
                                    'The comment field is required!'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
                })
            });

            $("#dropzone").dropzone({
                addRemoveLinks: true,
                // maxFiles: 1, //change limit as per your requirements
                dictMaxFilesExceeded: "Maximum upload limit reached",
                acceptedFiles: "image/jpeg,image/png,image/jpg",
                init: function() {
                    this.on("queuecomplete", function(file) {
                        location.reload();
                    });

                    // Add event listener to display alert message for invalid file types
                    this.on("addedfile", function(file) {
                        if (!file.type.match(/image\/(jpeg|png|jpg)/)) {
                            this.removeFile(file); // Remove the file from the queue
                            alert("You can only upload JPG, JPEG, or PNG images.");
                        }
                    });
                },
            });

            $("#dropzone2").dropzone({
                addRemoveLinks: true,
                // maxFiles: 1, //change limit as per your requirements
                dictMaxFilesExceeded: "Maximum upload limit reached",
                acceptedFiles: "image/jpeg,image/png,image/jpg",
                init: function() {
                    this.on("queuecomplete", function(file) {
                        location.reload();
                    });

                    // Add event listener to display alert message for invalid file types
                    this.on("addedfile", function(file) {
                        if (!file.type.match(/image\/(jpeg|png|jpg)/)) {
                            this.removeFile(file); // Remove the file from the queue
                            alert("You can only upload JPG, JPEG, or PNG images.");
                        }
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

            $(".delete-alert").on('click', function(e) {
                e.preventDefault();

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
                            url: "/delete-sop-owner/" + id,
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

            $(".verify").on('click', function(e) {
                e.preventDefault();

                let id = $(this).data('path');

                Swal.fire({
                    title: 'Are you sure you want to verify this SOP?',
                    text: "Ammendment can't be made once the SOP has been verified",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, verify!',
                    cancelButtonText: 'No'
                }).then(function(e) {
                    if (e.value === true) {
                        $.ajax({
                            type: "POST",
                            url: "/verify-sop/" + id,
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

            $(".approve").on('click', function(e) {
                e.preventDefault();

                let id = $(this).data('path');

                Swal.fire({
                    title: 'Are you sure you want to approve this SOP?',
                    text: "Ammendment can't be made once the SOP has been approved",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve!',
                    cancelButtonText: 'No'
                }).then(function(e) {
                    if (e.value === true) {
                        $.ajax({
                            type: "POST",
                            url: "/approve-sop/" + id,
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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            });

            $('.editable').Tabledit({
                url: '{{ url('update-form') }}',
                dataType: "json",
                columns: {
                    identifier: [1, 'id'],
                    editable: [
                        [2, 'code'],
                        [3, 'details']
                    ]
                },
                restoreButton: false,
                onSuccess: function(data, textStatus, jqXHR) {
                    if (data.action == 'delete') {
                        $('#' + data.id).remove();
                        location.reload();
                    } else {
                        if (data.errors) {
                            var errorMessages = Object.values(data.errors).flat().join('<br>');
                            // Display the custom error message if available
                            var errorMessage = data.message || 'Validation Error';

                            // Ensure that SweetAlert is available and properly included
                            if (typeof Swal === 'function') {
                                Swal.fire({
                                    icon: 'error',
                                    title: errorMessage,
                                    html: errorMessages
                                });
                            } else {
                                // Fallback to alert if Swal is not available
                                alert(errorMessage + '\n' + errorMessages + '\n');
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Saved!'
                            });
                        }
                    }
                }
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

            $(".btn-delete").on('click', function(e) {
                e.preventDefault();

                let id = $(this).data('path');

                Swal.fire({
                    title: 'Are you sure you want to delete this image?',
                    text: "Data cannot be restored!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'No'
                }).then(function(e) {
                    if (e.value === true) {
                        $.ajax({
                            type: "DELETE",
                            url: "/delete-work-flow/" + id,
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



        });
    </script>
@endsection
