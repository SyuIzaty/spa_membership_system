@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    {{-- <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
        <li class="breadcrumb-item">Page Views</li>
        <li class="breadcrumb-item active">Profile</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol> --}}
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Semester Registration
            {{-- <small>
                Register Supervisor, Co-Supervisor & Advisor
            </small> --}}
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>Semester</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('supervisor.store') }}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label class="form-label" for="id">IC Number / Passport</label>
                                    <input class="form-control" id="id" name="id">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="fullname">Fullname</label>
                                    <input class="form-control" id="fullname" name="fullname">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="institution">Institution</label>
                                    <input class="form-control" id="institution" name="institution">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="department">Department</label>
                                    <input class="form-control" id="department" name="department">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control" id="email" name="email">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="office_phone">Office Phone</label>
                                    <input class="form-control" id="office_phone" name="office_phone">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="mobile_phone">Mobile Phone</label>
                                    <input class="form-control" id="mobile_phone" name="mobile_phone">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="mobile_phone">Type</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="1">Internal</option>
                                        <option value="1">External</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>




    </div>
</main>
@endsection

@section('script')



@endsection
