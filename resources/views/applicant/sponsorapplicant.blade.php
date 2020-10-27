@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-upload'></i> Upload Applicant
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Upload Applicant</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif

                            <form action={{ url('import-excel') }} method="post" name="importform" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-md-6">
                                        <p>Intake Session</p>
                                        <select name="intake_id" class="form-control" id="intake_id">
                                            @foreach ($intake as $intakes)
                                                <option value="{{ $intakes->id }}">{{ $intakes->intake_code }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <p>Upload Applicant</p>
                                        <input type="file" name="import_file" class="form-control">
                                        <br>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm float-right mb-3">Import File</button>
                                <a href="/sponsorTemplate" class="btn btn-primary btn-sm float-right mr-2 mb-3">Download Template</a>
                            </form>
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
        $('#intake_id').select2();
    });
</script>
@endsection
