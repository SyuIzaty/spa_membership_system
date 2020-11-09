@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-upload'></i> Upload Sponsor Applicant
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Upload Sponsor Applicant</h2>
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
                                <div class="col-md-12">
                                    <div class="panel-content">
                                        <input type="file" name="import_file" class="form-control mb-3">
                                        <label>Select Sponsor *</label>
                                        <select class="form-control" id="sponsor" name="sponsor_id">
                                            <option disabled selected>Select Sponsor</option>
                                            @foreach ($sponsor as $sponsors)
                                                <option value="{{ $sponsors->sponsor_code }}">{{ $sponsors->sponsor_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="panel-content">
                                        <br>
                                        <button class="btn btn-success btn-sm float-right mb-3">Upload File</button>
                                        <a href="/sponsorTemplate" class="btn btn-primary btn-sm float-right mr-2 mb-3">Download Template</a>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12">
                                <div class="panel-content text-danger">** Reminder: The uploaded data will be saved in {{ $intake['intake_code'] }} session</div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="panel-content">
                                    <div class="panel-tag">Code List</div>
                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#program" aria-expanded="false">
                                                    <i class="fal fa-list-ol width-2 fs-xl"></i>
                                                    Program
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="program" class="collapse" data-parent="#program" style="">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>PROGRAMME CODE</td>
                                                            <td>PROGRAMME NAME</td>
                                                        </tr>
                                                        @foreach ($programme as $programmes)
                                                            <tr>
                                                                <td>{{ $programmes->id }}</td>
                                                                <td>{{ $programmes->programme_name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#major" aria-expanded="false">
                                                    <i class="fal fa-list-ul width-2 fs-xl"></i>
                                                    Major
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="major" class="collapse" data-parent="#major">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>MAJOR CODE</td>
                                                            <td>MAJOR NAME</td>
                                                        </tr>
                                                        @foreach ($major as $majors)
                                                            <tr>
                                                                <td>{{ $majors->id }}</td>
                                                                <td>{{ $majors->major_name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#gender" aria-expanded="false">
                                                    <i class="fal fa-user width-2 fs-xl"></i>
                                                    Gender
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="gender" class="collapse" data-parent="#gender">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>GENDER CODE</td>
                                                            <td>GENDER NAME</td>
                                                        </tr>
                                                        @foreach ($gender as $genders)
                                                            <tr>
                                                                <td>{{ $genders->gender_code }}</td>
                                                                <td>{{ $genders->gender_name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#race" aria-expanded="false">
                                                    <i class="fal fa-check width-2 fs-xl"></i>
                                                    Race
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="race" class="collapse" data-parent="#race">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>RACE CODE</td>
                                                            <td>RACE NAME</td>
                                                        </tr>
                                                        @foreach ($race as $races)
                                                            <tr>
                                                                <td>{{ $races->race_code }}</td>
                                                                <td>{{ $races->race_name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#religion" aria-expanded="false">
                                                    <i class="fal fa-check width-2 fs-xl"></i>
                                                    Religion
                                                    <span class="ml-auto">
                                                        <span class="collapsed-reveal">
                                                            <i class="fal fa-minus fs-xl"></i>
                                                        </span>
                                                        <span class="collapsed-hidden">
                                                            <i class="fal fa-plus fs-xl"></i>
                                                        </span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div id="religion" class="collapse" data-parent="#religion">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>RELIGION CODE</td>
                                                            <td>RELIGION NAME</td>
                                                        </tr>
                                                        @foreach ($religion as $religions)
                                                            <tr>
                                                                <td>{{ $religions->religion_code }}</td>
                                                                <td>{{ $religions->religion_name }}</td>
                                                            </tr>
                                                        @endforeach
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
    $(document).ready(function() {
        $('#sponsor').select2();
    });
</script>
@endsection
