@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-book'></i> New File
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
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        {!! Form::open(['action' => ['Library\Arkib\ArkibMainController@update', $arkib['id']], 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
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
                                <td>Department <span class="text-danger">*</span></td>
                                <td>
                                    <select class="form-control" name="department_code" id="department_code">
                                        <option disabled selected>Please Select</option>
                                        @foreach($department as $departments)
                                        <option value="{{ $departments->department_code }}" {{ $arkib->department_code == $departments->department_code ? 'selected="selected"' : ''}}>
                                            {{ $departments->department_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>File Classification No <span class="text-danger">*</span></td>
                                <td><input type="text" class="form-control" name="file_classification_no" value="{{ $arkib->file_classification_no }}"></td>
                            </tr>
                            <tr>
                                <td>Title <span class="text-danger">*</span></td>
                                <td><input type="text" class="form-control" name="title" value="{{ $arkib->title }}"></td>
                            </tr>
                            <tr>
                                <td>Description <span class="text-danger">*</span></td>
                                <td><input type="text" class="form-control" name="description" value="{{ $arkib->description }}"></td>
                            </tr>
                            <tr>
                                <td>Status <span class="text-danger">*</span></td>
                                <td>
                                    <select class="form-control" name="status" id="status">
                                        @foreach($status as $statuses)
                                        <option value="{{ $statuses->arkib_status }}" {{ $arkib->status == $statuses->arkib_status ? 'selected="selected"' : ''}}>
                                            {{ $statuses->arkib_description }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Attachment(s)</td>
                                <td>
                                    <input type="file" name="arkib_attachment[]" multiple>
                                </td>
                            </tr>
                        </table>
                        <button class="btn btn-success btn-sm float-right mb-2">Submit</button>
                        {!! Form::close() !!}

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
                                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/library/arkib/{{ $attachs->id }}"> <i class="fal fa-trash"></i></button>
                                  </td>
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                        <a href="/library/arkib-main" class="btn btn-secondary btn-sm float-right mt-2 mb-2">Back</a>
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
