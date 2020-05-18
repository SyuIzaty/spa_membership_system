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
            <i class='subheader-icon fal fa-plus-circle'></i> Campus Registration
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
                        Register <span class="fw-300"><i>Campus</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label class="form-label" for="code">Code</label>
                                    <input class="form-control" id="code" name="code">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input class="form-control" id="name" name="name">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="address1">Address 1</label>
                                    <input class="form-control" id="address1" name="address1">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="address2">Address 2</label>
                                    <input class="form-control" id="address2" name="address2">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="postcode">Postcode</label>
                                    <input class="form-control" id="postcode" name="postcode">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="city">City</label>
                                    <input class="form-control" id="city" name="city">
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="state">State</label>
                                    <select class="form-control" id="state" name="state" required>
                                        <option value="">Please Select</option>
                                        <option value="01">Johor</option>
                                        <option value="02">Kedah</option>
                                        <option value="03">Kelantan</option>
                                        <option value="04">Melaka</option>
                                        <option value="05">Negeri Sembilan</option>
                                        <option value="06">Pahang</option>
                                        <option value="07">Pulau Pinang</option>
                                        <option value="08">Perak</option>
                                        <option value="09">Perlis</option>
                                        <option value="10">Selangor</option>
                                        <option value="11">Terengganu</option>
                                        <option value="12">Sabah</option>
                                        <option value="13">Sarawak</option>
                                        <option value="14">Wilayah Persekutuan Kuala Lumpur</option>
                                        <option value="15">Wilayah Persekutuan Labuan</option>
                                        <option value="16">Wilayah Persekutuan Putrajaya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="active">Active</label>
                                    <select class="form-control" id="active" name="active" required>
                                        <option value="">Please Select</option>
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
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
