@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-book'></i> Arkib
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Arkib <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if($arkib->category_id == 1)
                        <table class="table table-bordered">
                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                <li>
                                    <a href="#" disabled style="pointer-events: none">
                                        <i class="fal fa-caret-right"></i>
                                        <span class="">Student Detail</span>
                                    </a>
                                </li>
                                <p></p>
                            </ol>
                            <tr>
                                <td style="width: 15%">Student Name</td>
                                <td colspan="3" style="width: 85%">
                                    {{ isset($stud->students_name) ? $stud->students_name : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Student ID</td>
                                <td style="width: 35%">{{ isset($stud->students_id) ? $stud->students_id : '' }}</td>
                                <td style="width: 15%">Student IC</td>
                                <td style="width: 35%">{{ isset($stud->students_ic) ? $stud->students_ic : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Intake Code</td>
                                <td style="width: 35%">{{ isset($stud->intake_code) ? $stud->intake_code : '' }}</td>
                                <td style="width: 15%">Batch Code</td>
                                <td style="width: 35%">{{ isset($stud->batch_code) ? $stud->batch_code : '' }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Programme</td>
                                <td style="width: 85%" colspan="3">
                                    {{ isset($stud->programmes->programme_name) ? $stud->programmes->programme_name : '' }}
                                    ({{ isset($stud->students_programme) ? $stud->students_programme : '' }})
                                </td>
                            </tr>
                        </table>
                        @endif
                        <table class="table table-bordered">
                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                <li>
                                    <a href="#" disabled style="pointer-events: none">
                                        <i class="fal fa-caret-right"></i>
                                        <span class="">Arkib</span>
                                    </a>
                                </li>
                                <p></p>
                            </ol>
                            <tr>
                                <td style="width: 15%">Department</td>
                                <td style="width: 35%">
                                  {{ isset($arkib->department->name) ? $arkib->department->name : '' }}
                                </td>
                                <td style="width: 15%">File Classification No</td>
                                <td style="width: 35%">{{ $arkib->file_classification_no }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Title</td>
                                <td style="width: 85%" colspan="3">{{ $arkib->title }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%">Description</td>
                                <td style="width: 85%" colspan="3">{{ $arkib->description }}</td>
                            </tr>
                        </table>

                        <table id="attach_table" class="table table-bordered table-hover table-striped w-100 mb-1">
                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                <li class="mt-5">
                                    <a href="#" disabled style="pointer-events: none">
                                        <i class="fal fa-caret-right"></i>
                                        <span class="">Attachment(s)</span>
                                    </a>
                                </li>
                                <p></p>
                            </ol>
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                  <td>File</td>
                                  <td>File Size</td>
                                  <td>Action</td>
                                </tr>
                                @foreach($attach as $attachs)
                                <tr>
                                  <td>{{ substr($attachs->file_name,12) }}</td>
                                  <td>{{ $attachs->file_size }}</td>
                                  <td>
                                    <a class="btn btn-sm btn-primary" href="/library/arkib/{{ $attachs->file_name }}" target="_blank"><i class="fal fa-search text-white"></i></a>
                                  </td>
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                        <a href="/library/arkib" class="btn btn-secondary btn-sm float-right mt-2 mb-2">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $('#department_code, #status').select2();

    $('#attach_table').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = $(this).data('remote');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    location.reload();
                });
            }
        })
    });
</script>
@endsection
