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
                        {!! Form::open(['action' => 'Library\Arkib\ArkibMainController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <table class="table table-bordered">
                            <tr>
                                <td>Department</td>
                                <td>
                                    <select class="form-control" name="department_code" id="department_code">
                                        <option disabled selected>Please Select</option>
                                        @foreach($department as $departments)
                                        <option value="{{ $departments->department_code }}" {{ old('department_code') ? 'selected' : '' }}>
                                            {{ $departments->department_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td><input type="text" class="form-control" name="title" value="{{ old('title') }}"></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td><input type="text" class="form-control" name="description" value="{{ old('description') }}"></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <select class="form-control" name="status" id="status">
                                        <option disabled selected>Please Select</option>
                                        @foreach($status as $statuses)
                                        <option value="{{ $statuses->arkib_status }}" {{ old('status') ? 'selected' : '' }}>
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
</script>
@endsection
