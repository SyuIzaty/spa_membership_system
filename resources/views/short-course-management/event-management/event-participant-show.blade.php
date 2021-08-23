@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i>
                ({{ $event->id }}) {{ $event->name }}
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Participants Information
                        </h2>
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
                                {{-- <li class="nav-item active">
                                    <a data-toggle="tab" class="nav-link" href="#applications" role="tab">Verify
                                        Applications</a>
                                </li> --}}
                                <li class="nav-item active">
                                    <a data-toggle="tab" class="nav-link" href="#pending-payments" role="tab">Pending
                                        Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#verify-payments" role="tab">Verify
                                        Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#application-status" role="tab">Application
                                        Status</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#attendance-status" role="tab">Attendance
                                        Status</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#feedback-status" role="tab">Feedback
                                        Status</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane" id="applications" role="tabpanel" hidden>
                                        <hr class="mt-2 mb-3">
                                        <div class="row">

                                            <div class="col-md-12 grid-margin">
                                                @if (Session::has('messageNewApplication'))
                                                    <div class="alert alert-success"
                                                        style="color: #3b6324; background-color: #d3fabc;width:100%;">
                                                        <i class="icon fal fa-check-circle"></i>
                                                        {{ Session::get('messageNewApplication') }}
                                                    </div>
                                                @endif
                                                @if (Session::has('messageAlreadyApplied'))
                                                    <div class="alert alert-danger  text-white"
                                                        style="color:rgb(105, 0, 0); background-color: rgb(255, 51, 51);width:100%;">
                                                        <i class="icon fal fa-times-circle" style="color:white"></i>
                                                        {{ Session::get('messageAlreadyApplied') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Step 1 (Pre-Event) - </span> Make
                                                                    Application
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container">
                                                                {{-- <form action="{{ url('/senarai_kolej/student/bundle/into/' . $event->id) }}" method="post"
                                                                        name="form"> --}}
                                                                {{-- <form name="form"> --}}
                                                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex justify-content-center"
                                                                    style="content-align:center">
                                                                    <div class="justify-content-center text-center"
                                                                        style="content-align:center">
                                                                        <h1> <b>Apply by the<br>participant
                                                                                himself</b></h1>
                                                                    </div>
                                                                    <hr class="ml-1 mr-1">
                                                                    <div class="align-middle">
                                                                        <h1> or</h1>
                                                                    </div>
                                                                    <hr class="ml-1 mr-1">
                                                                    {{-- <button type="submit"
                                                                            class="btn btn-primary px-5 mx-5 waves-effect waves-themed">Apply
                                                                            by
                                                                            INTEC</button> --}}
                                                                    {{-- <a href="javascript:;" data-toggle="modal"
                                                                        id="new-application"
                                                                        class="btn btn-primary px-5 mx-5 waves-effect waves-themed align-middle">
                                                                        Apply by INTEC</a> --}}
                                                                    {{-- <div class="modal fade" id="crud-modal-new-application"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="card-header">
                                                                                    <h5 class="card-title w-150">Add New
                                                                                        Applicant</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form
                                                                                        action="{{ url('/event/' . $event->id . '/events-participants/store') }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        <p><span
                                                                                                class="text-danger">*</span>
                                                                                            Vital Information</p>
                                                                                        <hr class="mt-1 mb-2">
                                                                                        <div class="form-group">
                                                                                            <label for="ic"><span
                                                                                                    class="text-danger">*</span>
                                                                                                IC</label>
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        id="ic_input"
                                                                                                        name="ic_input">
                                                                                                </div>
                                                                                                <td class="col col-sm-1">
                                                                                                    <a href="javascript:;"
                                                                                                        data-toggle="#"
                                                                                                        id="search-by-ic"
                                                                                                        class="btn btn-primary mb-2"><i
                                                                                                            class="ni ni-magnifier"></i></a>

                                                                                                </td>
                                                                                            </div>
                                                                                            @error('ic_input')
                                                                                                <p style="color: red">
                                                                                                    <strong> *
                                                                                                        {{ $message }}
                                                                                                    </strong>
                                                                                                </p>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div id="form-application-second-part"
                                                                                            style="display: none">

                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="fullname"><span
                                                                                                        class="text-danger">*</span>Fullname</label>
                                                                                                <input class="form-control"
                                                                                                    id="fullname"
                                                                                                    name="fullname">
                                                                                                @error('fullname')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>
                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="phone"><span
                                                                                                        class="text-danger">*</span>Phone</label>
                                                                                                <input class="form-control"
                                                                                                    id="phone" name="phone">
                                                                                                @error('phone')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>

                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="email"><span
                                                                                                        class="text-danger">*</span>Email</label>
                                                                                                <input class="form-control"
                                                                                                    id="email" name="email">
                                                                                                @error('email')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>
                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="is_base_fee_select_add"><span
                                                                                                        class="text-danger">*</span>Fee</label>
                                                                                                <select
                                                                                                    class="form-control fee_id font-weight-bold"
                                                                                                    name="fee_id"
                                                                                                    id="fee_id"
                                                                                                    tabindex="-1"
                                                                                                    aria-hidden="true">
                                                                                                    <option disabled
                                                                                                        selected>Select Fee
                                                                                                        Applied</option>
                                                                                                    @foreach ($event->fees as $fee)
                                                                                                        <option
                                                                                                            value="{{ $fee->id }}">
                                                                                                            {{ $fee->is_base_fee }}
                                                                                                            -
                                                                                                            {{ $fee->name }}
                                                                                                            (RM{{ $fee->amount }})
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-5">
                                                                                                        <div class="input-group flex-nowrap"
                                                                                                            id="fee_id_show"
                                                                                                            name="fee_id_show"
                                                                                                            style="display:none; width:auto">
                                                                                                            <div
                                                                                                                class="input-group-prepend">
                                                                                                                <span
                                                                                                                    class="input-group-text"
                                                                                                                    style="background-color:white; border-style: none;"
                                                                                                                    id="addon-wrapping">RM</span>
                                                                                                            </div>
                                                                                                            <input
                                                                                                                class="form-control-plaintext"
                                                                                                                id="fee_id_input"
                                                                                                                name="fee_id_input"
                                                                                                                readonly>
                                                                                                            <div
                                                                                                                class="input-group-append">
                                                                                                                <span
                                                                                                                    style="background-color:white; border-style: none;"
                                                                                                                    class="input-group-text">/
                                                                                                                    person</span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-7">
                                                                                                        <div class="row">
                                                                                                            <div
                                                                                                                class="col">
                                                                                                                <input
                                                                                                                    class="form-control"
                                                                                                                    id="promo_code"
                                                                                                                    name="promo_code"
                                                                                                                    placeholder="Promo Code (Only if applicable)">
                                                                                                            </div>
                                                                                                            <td
                                                                                                                class="col col-sm-1">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    name="remove"
                                                                                                                    id="promo_code_edit_remove"
                                                                                                                    class="btn btn-danger btn_remove"
                                                                                                                    style="display:none">
                                                                                                                    <i
                                                                                                                        class="ni ni-close"></i>
                                                                                                                </button>
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    name="add"
                                                                                                                    id="promo_code_edit_add"
                                                                                                                    class="btn btn-primary btn_add">
                                                                                                                    <i
                                                                                                                        class="ni ni-check"></i>
                                                                                                                </button>
                                                                                                            </td>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>

                                                                                                @error('fee_id')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>
                                                                                            <div
                                                                                                class="custom-control custom-checkbox">

                                                                                                <input type="checkbox"
                                                                                                    class="custom-control-input"
                                                                                                    id="represent-by-himself"
                                                                                                    checked="checked"
                                                                                                    type="hidden">
                                                                                            </div>
                                                                                            <div id="representative"
                                                                                                style="display:none">
                                                                                                <hr class="mt-1 mb-2">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="representative-ic"><span
                                                                                                            class="text-danger">*</span>
                                                                                                        Representative
                                                                                                        IC</label>
                                                                                                    <div class="form-inline"
                                                                                                        style="width:100%">
                                                                                                        <div class="form-group mr-2 mb-2"
                                                                                                            style="width:85%">
                                                                                                            <input
                                                                                                                class="form-control w-100"
                                                                                                                id="representative_ic_input"
                                                                                                                name="representative_ic_input">
                                                                                                        </div>
                                                                                                        <a href="javascript:;"
                                                                                                            data-toggle="#"
                                                                                                            id="search-by-representative-ic"
                                                                                                            class="btn btn-primary mb-2"><i
                                                                                                                class="ni ni-magnifier"></i></a>
                                                                                                    </div>
                                                                                                    @error('representative_ic_input')
                                                                                                        <p style="color: red">
                                                                                                            <strong> *
                                                                                                                {{ $message }}
                                                                                                            </strong>
                                                                                                        </p>
                                                                                                    @enderror
                                                                                                </div>
                                                                                                <p id="representative-doesnt-exist"
                                                                                                    style="color: red; display:none;">
                                                                                                    <strong> * The
                                                                                                        representative
                                                                                                        doesn't
                                                                                                        exist
                                                                                                    </strong>
                                                                                                </p>
                                                                                                <p id="representative-doesnt-valid"
                                                                                                    style="color: red; display:none;">
                                                                                                    <strong> * The choosen
                                                                                                        participant is not
                                                                                                        valid
                                                                                                        to represent others
                                                                                                    </strong>
                                                                                                </p>
                                                                                                <div id="form-application-third-part"
                                                                                                    style="display: none">
                                                                                                    <div class="form-group">
                                                                                                        <label
                                                                                                            class="form-label"
                                                                                                            for="representative_fullname"><span
                                                                                                                class="text-danger">*</span>Representative
                                                                                                            Fullname</label>
                                                                                                        <input
                                                                                                            id="representative_fullname"
                                                                                                            name="representative_fullname"
                                                                                                            class="form-control"
                                                                                                            readonly>
                                                                                                        @error('representative_fullname')
                                                                                                            <p
                                                                                                                style="color: red">
                                                                                                                <strong> *
                                                                                                                    {{ $message }}
                                                                                                                </strong>
                                                                                                            </p>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr class="mt-1 mb-2">
                                                                                        <div class="footer"
                                                                                            id="new_application_footer"
                                                                                            style="display:none">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger ml-auto float-right mr-2"
                                                                                                data-dismiss="modal"
                                                                                                id="close-new-application"><i
                                                                                                    class="fal fa-window-close"></i>
                                                                                                Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-success ml-auto float-right mr-2"><i
                                                                                                    class="ni ni-plus"></i>
                                                                                                Apply</button>
                                                                                        </div>
                                                                                    </form>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Step 2 (Pre-Event) - </span>
                                                                    (List of New Applicants) Approve
                                                                    Application from this List of Applications
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                {{-- <form action="{{ url('/senarai_kolej/student/bundle/into/' . $event->id) }}" method="post"
                                                                    name="form"> --}}
                                                                <form name="form">
                                                                    @csrf
                                                                    <div class="panel-content">
                                                                        @if (Session::has('messageAllApplicants'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('messageAllApplicants') }}
                                                                            </div>
                                                                        @endif
                                                                        @if (Session::has('notification'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('notification') }}
                                                                            </div>
                                                                        @endif

                                                                        <div class="table-responsive">
                                                                            <table id="table-applicants"
                                                                                name="table-update-progress-1"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-all-applicants">
                                                                                        </th>
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
                                                                                        <th>Date Apply</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>

                                                                    </div>
                                                                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                        style="content-align:right">
                                                                        <button type="submit"
                                                                            class="btn btn-success ml-auto mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-check"></i> Approve All
                                                                            Ticked</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Reject All
                                                                            Ticked</button>
                                                                    </div>
                                                                    {{-- <button type="button" class="btn btn-success ml-auto mr-2 waves-effect waves-themed" onclick="window.location='http://sims.test/checkrequirements'"><i class="fal fa-check-circle"></i> Run All</button> --}}
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane active" id="pending-payments" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span> List of Not Make Payment
                                                                    Yet
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                <div class="panel-content">
                                                                    @if (Session::has('messageAllNoPaymentYet'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('messageAllNoPaymentYet') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('notification'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('notification') }}
                                                                        </div>
                                                                    @endif

                                                                    <form action="{{ url('/update-progress/bundle') }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <div class="table-responsive">
                                                                            <table id="table-all-no-payment-yet"
                                                                                name="table-update-progress-2"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-all-no-payment-yet">
                                                                                        </th>
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>IC</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
                                                                                        <th>Date Apply</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                            style="content-align:right">
                                                                            <button type="submit" name="update-progress"
                                                                                value="disqualified-application-no-payment"
                                                                                class="btn btn-danger ml-auto mr-2 waves-effect waves-themed"><i
                                                                                    class="ni ni-close"></i> Disqualified
                                                                                All
                                                                                Ticked</button>
                                                                            <a href="javascript:;" data-toggle="modal"
                                                                                id="new-application"
                                                                                class="btn btn-primary px-5 mx-5 waves-effect waves-themed align-middle">
                                                                                <i class="ni ni-check"></i> New
                                                                                Application</a>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                    style="content-align:right">
                                                                    <div class="modal fade" id="crud-modal-new-application"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="card-header">
                                                                                    <h5 class="card-title w-150">
                                                                                        Application
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form
                                                                                        action="{{ url('/event/' . $event->id . '/events-participants/store') }}"
                                                                                        method="post">
                                                                                        @csrf
                                                                                        {{-- {!! Form::open(['action' => 'ShortCourseManagement\EventManagement\EventParticipantController@store', 'method' => 'POST']) !!} --}}
                                                                                        {{-- <input type="hidden" name="id"
                                                                                                    id="id"> --}}
                                                                                        <p><span
                                                                                                class="text-danger">*</span>
                                                                                            Vital Information</p>
                                                                                        <hr class="mt-1 mb-2">
                                                                                        <div class="form-group">
                                                                                            <label for="ic"><span
                                                                                                    class="text-danger">*</span>
                                                                                                IC</label>
                                                                                            <div class="row">
                                                                                                <div class="col">
                                                                                                    <input
                                                                                                        class="form-control"
                                                                                                        id="ic_input"
                                                                                                        name="ic_input">
                                                                                                </div>
                                                                                                <td class="col col-sm-1">
                                                                                                    <a href="javascript:;"
                                                                                                        data-toggle="#"
                                                                                                        id="search-by-ic"
                                                                                                        class="btn btn-primary mb-2"><i
                                                                                                            class="ni ni-magnifier"></i></a>

                                                                                                </td>
                                                                                            </div>
                                                                                            @error('ic_input')
                                                                                                <p style="color: red">
                                                                                                    <strong> *
                                                                                                        {{ $message }}
                                                                                                    </strong>
                                                                                                </p>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div id="form-application-second-part"
                                                                                            style="display: none">

                                                                                            <div class="alert alert-primary d-flex justify-content-center"
                                                                                                style="color: #ffffff; background-color: #2c0549;width:100%;"
                                                                                                id="application_message">

                                                                                            </div>

                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="fullname"><span
                                                                                                        class="text-danger">*</span>Fullname</label>
                                                                                                <input class="form-control"
                                                                                                    id="fullname"
                                                                                                    name="fullname">
                                                                                                @error('fullname')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>
                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="phone"><span
                                                                                                        class="text-danger">*</span>Phone</label>
                                                                                                <input class="form-control"
                                                                                                    id="phone" name="phone">
                                                                                                @error('phone')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>

                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="email"><span
                                                                                                        class="text-danger">*</span>Email</label>
                                                                                                <input class="form-control"
                                                                                                    id="email" name="email">
                                                                                                @error('email')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>
                                                                                            <hr class="mt-1 mb-2">
                                                                                            <div class="form-group">
                                                                                                <label class="form-label"
                                                                                                    for="is_base_fee_select_add"><span
                                                                                                        class="text-danger">*</span>Fee</label>
                                                                                                {{-- <input class="form-control" id="is_base_fee_select_add"
                                                                                                        name="is_base_fee_select_add"> --}}
                                                                                                <select
                                                                                                    class="form-control fee_id font-weight-bold"
                                                                                                    name="fee_id"
                                                                                                    id="fee_id"
                                                                                                    tabindex="-1"
                                                                                                    aria-hidden="true">
                                                                                                    <option disabled
                                                                                                        selected>Select
                                                                                                        Fee
                                                                                                        Applied</option>
                                                                                                    @foreach ($event->fees as $fee)
                                                                                                        <option
                                                                                                            value="{{ $fee->id }}">
                                                                                                            {{ $fee->is_base_fee }}
                                                                                                            -
                                                                                                            {{ $fee->name }}
                                                                                                            (RM{{ $fee->amount }})
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-5">
                                                                                                        <div class="input-group flex-nowrap"
                                                                                                            id="fee_id_show"
                                                                                                            name="fee_id_show"
                                                                                                            style="display:none; width:auto">
                                                                                                            <div
                                                                                                                class="input-group-prepend">
                                                                                                                <span
                                                                                                                    class="input-group-text"
                                                                                                                    style="background-color:white; border-style: none;"
                                                                                                                    id="addon-wrapping">RM</span>
                                                                                                            </div>
                                                                                                            <input
                                                                                                                class="form-control-plaintext"
                                                                                                                id="fee_id_input"
                                                                                                                name="fee_id_input"
                                                                                                                readonly>
                                                                                                            <div
                                                                                                                class="input-group-append">
                                                                                                                <span
                                                                                                                    style="background-color:white; border-style: none;"
                                                                                                                    class="input-group-text">/
                                                                                                                    person</span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-7"
                                                                                                        id="promo_code_col"
                                                                                                        style="display:none">
                                                                                                        <div class="row">
                                                                                                            <div
                                                                                                                class="col">
                                                                                                                <input
                                                                                                                    class="form-control"
                                                                                                                    id="promo_code"
                                                                                                                    name="promo_code"
                                                                                                                    placeholder="Promo Code (Only if applicable)">
                                                                                                            </div>
                                                                                                            <td
                                                                                                                class="col col-sm-1">
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    name="remove"
                                                                                                                    id="promo_code_edit_remove"
                                                                                                                    class="btn btn-danger btn_remove"
                                                                                                                    style="display:none">
                                                                                                                    <i
                                                                                                                        class="ni ni-close"></i>
                                                                                                                </button>
                                                                                                                <button
                                                                                                                    type="button"
                                                                                                                    name="add"
                                                                                                                    id="promo_code_edit_add"
                                                                                                                    class="btn btn-primary btn_add">
                                                                                                                    <i
                                                                                                                        class="ni ni-check"></i>
                                                                                                                </button>
                                                                                                            </td>

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>

                                                                                                @error('fee_id')
                                                                                                    <p style="color: red">
                                                                                                        <strong> *
                                                                                                            {{ $message }}
                                                                                                        </strong>
                                                                                                    </p>
                                                                                                @enderror
                                                                                            </div>
                                                                                            {{-- <hr class="mt-1 mb-2"> --}}
                                                                                            <div
                                                                                                class="custom-control custom-checkbox">
                                                                                                {{-- <input type="checkbox"
                                                                                                            class="custom-control-input"
                                                                                                            id="represent-by-himself_show"
                                                                                                            checked="checked"
                                                                                                            disabled> --}}
                                                                                                <input type="checkbox"
                                                                                                    class="custom-control-input"
                                                                                                    id="represent-by-himself"
                                                                                                    checked="checked"
                                                                                                    type="hidden">
                                                                                                {{-- <label
                                                                                                            class="custom-control-label"
                                                                                                            for="represent-by-himself">Represent
                                                                                                            By Himself</label> --}}
                                                                                            </div>
                                                                                            <div id="representative"
                                                                                                style="display:none">
                                                                                                <hr class="mt-1 mb-2">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="representative-ic"><span
                                                                                                            class="text-danger">*</span>
                                                                                                        Representative
                                                                                                        IC</label>
                                                                                                    <div class="form-inline"
                                                                                                        style="width:100%">
                                                                                                        <div class="form-group mr-2 mb-2"
                                                                                                            style="width:85%">
                                                                                                            <input
                                                                                                                class="form-control w-100"
                                                                                                                id="representative_ic_input"
                                                                                                                name="representative_ic_input">
                                                                                                        </div>
                                                                                                        <a href="javascript:;"
                                                                                                            data-toggle="#"
                                                                                                            id="search-by-representative-ic"
                                                                                                            class="btn btn-primary mb-2"><i
                                                                                                                class="ni ni-magnifier"></i></a>
                                                                                                    </div>
                                                                                                    @error('representative_ic_input')
                                                                                                        <p style="color: red">
                                                                                                            <strong> *
                                                                                                                {{ $message }}
                                                                                                            </strong>
                                                                                                        </p>
                                                                                                    @enderror
                                                                                                </div>
                                                                                                <p id="representative-doesnt-exist"
                                                                                                    style="color: red; display:none;">
                                                                                                    <strong> * The
                                                                                                        representative
                                                                                                        doesn't
                                                                                                        exist
                                                                                                    </strong>
                                                                                                </p>
                                                                                                <p id="representative-doesnt-valid"
                                                                                                    style="color: red; display:none;">
                                                                                                    <strong> * The
                                                                                                        choosen
                                                                                                        participant is
                                                                                                        not
                                                                                                        valid
                                                                                                        to represent
                                                                                                        others
                                                                                                    </strong>
                                                                                                </p>
                                                                                                <div id="form-application-third-part"
                                                                                                    style="display: none">
                                                                                                    <div class="form-group">
                                                                                                        <label
                                                                                                            class="form-label"
                                                                                                            for="representative_fullname"><span
                                                                                                                class="text-danger">*</span>Representative
                                                                                                            Fullname</label>
                                                                                                        <input
                                                                                                            id="representative_fullname"
                                                                                                            name="representative_fullname"
                                                                                                            class="form-control"
                                                                                                            readonly>
                                                                                                        @error('representative_fullname')
                                                                                                            <p
                                                                                                                style="color: red">
                                                                                                                <strong> *
                                                                                                                    {{ $message }}
                                                                                                                </strong>
                                                                                                            </p>
                                                                                                        @enderror
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <hr class="mt-1 mb-2">
                                                                                        <div class="footer"
                                                                                            id="new_application_footer"
                                                                                            style="display:none">
                                                                                            <button type="button"
                                                                                                class="btn btn-danger ml-auto float-right mr-2"
                                                                                                data-dismiss="modal"
                                                                                                id="close-new-application"><i
                                                                                                    class="fal fa-window-close"></i>
                                                                                                Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-success ml-auto float-right mr-2"
                                                                                                id="application_update_submit"></button>
                                                                                        </div>
                                                                                    </form>

                                                                                    {{-- {!! Form::close() !!} --}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                </form>

                                                                <div class="modal fade" id="crud-modals" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="card-header">
                                                                                <h5 class="card-title w-100">Payment Proof
                                                                                </h5>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form
                                                                                    action="{{ route('store.payment_proof') }}"
                                                                                    method="POST"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf

                                                                                    <div class="form-group col"
                                                                                        id="carousel" style="display:none">

                                                                                        <!--Carousel Wrapper-->
                                                                                        <div id="multi-item-example"
                                                                                            class="carousel slide carousel-multi-item"
                                                                                            data-ride="carousel">

                                                                                            <!--Controls-->
                                                                                            <div class="controls-top">
                                                                                                <a class="btn-floating"
                                                                                                    href="#multi-item-example"
                                                                                                    data-slide="prev"><i
                                                                                                        class="ni ni-arrow-left"></i></a>

                                                                                                <a class="btn-floating"
                                                                                                    href="#multi-item-example"
                                                                                                    data-slide="next"><i
                                                                                                        class="ni ni-arrow-right"></i></a>
                                                                                            </div>
                                                                                            <!--/.Controls-->

                                                                                            <!--Indicators-->
                                                                                            <ol class="carousel-indicators mb-0"
                                                                                                id="carousel-indicators">
                                                                                            </ol>
                                                                                            <!--/.Indicators-->

                                                                                            <!--Slides-->
                                                                                            <div class="carousel-inner"
                                                                                                role="listbox"
                                                                                                id="carousel-slides">
                                                                                            </div>
                                                                                            <!--/.Slides-->

                                                                                        </div>
                                                                                        <!--/.Carousel Wrapper-->
                                                                                    </div>

                                                                                    <div
                                                                                        class="custom-file px-2 d-flex flex-column">
                                                                                        <input type="file"
                                                                                            class="custom-file-label"
                                                                                            name="payment_proof_input[]"
                                                                                            accept="image/png, image/jpeg"
                                                                                            multiple="" />
                                                                                    </div>
                                                                                    <hr class="mt-1 mb-1">
                                                                                    <div class="form-group col col-sm-5">
                                                                                        <label class="form-label"
                                                                                            for="amount">Fee Amount</label>
                                                                                        <div class="input-group flex-nowrap"
                                                                                            id="fee_id_show"
                                                                                            name="fee_id_show"
                                                                                            style="width:auto">
                                                                                            <div
                                                                                                class="input-group-prepend">
                                                                                                <span
                                                                                                    class="input-group-text"
                                                                                                    style="background-color:white; border-style: none;"
                                                                                                    id="addon-wrapping">RM</span>
                                                                                            </div>
                                                                                            <input
                                                                                                class="form-control-plaintext"
                                                                                                id="amount" name="amount"
                                                                                                readonly>
                                                                                            <div class="input-group-append">
                                                                                                <span
                                                                                                    style="background-color:white; border-style: none;"
                                                                                                    class="input-group-text">/
                                                                                                    person</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr class="mt-1 mb-1">
                                                                                    <div class="form-group col">
                                                                                        <label class="form-label"
                                                                                            for="fullname">Status</label>
                                                                                        <div class="row">
                                                                                            <input type="number"
                                                                                                name="event_participant_id"
                                                                                                value=0
                                                                                                id="event_participant_id"
                                                                                                hidden />
                                                                                            <input type="number"
                                                                                                name="event_id" value=0
                                                                                                id="event_id" hidden />
                                                                                            <input type="number"
                                                                                                name="participant_id"
                                                                                                id="participant_id"
                                                                                                hidden />
                                                                                            <input
                                                                                                class="form-control-plaintext"
                                                                                                id="is_verified_payment_proof_id"
                                                                                                name="is_verified_payment_proof_id"
                                                                                                hidden>
                                                                                            <div
                                                                                                class="col d-flex justify-content-start">
                                                                                                <input
                                                                                                    class="form-control-plaintext"
                                                                                                    id="is_verified_payment_proof"
                                                                                                    name="is_verified_payment_proof"
                                                                                                    disabled>
                                                                                            </div>
                                                                                            <div
                                                                                                class="col d-flex justify-content-end">
                                                                                                <div
                                                                                                    class="row d-flex justify-content-end">
                                                                                                    <td
                                                                                                        class="col col-sm-1">
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            name="request_verification"
                                                                                                            id="request_verification"
                                                                                                            class="btn btn-primary btn_add"
                                                                                                            style="display:none">
                                                                                                            Request
                                                                                                            Verification
                                                                                                        </button>
                                                                                                    </td>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr class="mt-1 mb-1">


                                                                                    {{-- <div class="invalid-feedback">Example invalid custom file feedback</div> --}}
                                                                                    <div class="footer">
                                                                                        <button type="submit"
                                                                                            class="btn btn-primary ml-auto float-right"
                                                                                            id="submit_payment_proof"><i
                                                                                                class="fal fa-save"></i>
                                                                                            Save & Request
                                                                                            Verification</button>
                                                                                        <button type="button"
                                                                                            class="btn btn-danger ml-auto float-right mr-2"
                                                                                            data-dismiss="modal"><i
                                                                                                class="fal fa-window-close"></i>
                                                                                            Close</button>
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

                                    <div class="tab-pane" id="verify-payments" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span> Already Make Payment, Need
                                                                    Verification
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                {{-- <form action="{{ url('/senarai_kolej/student/bundle/into/' . $event->id) }}" method="post"
                                                                    name="form"> --}}
                                                                <div class="panel-content">
                                                                    @if (Session::has('messagePaymentWaitForVerification'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('messagePaymentWaitForVerification') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('notification'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('notification') }}
                                                                        </div>
                                                                    @endif
                                                                    <form action="{{ url('/update-progress/bundle') }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <div class="table-responsive">
                                                                            <table id="table-payment-wait-for-verification"
                                                                                name="table-update-progress-3"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-payment-wait-for-verification">
                                                                                        </th>
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>IC</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
                                                                                        <th>Proof</th>
                                                                                        <th>Date Apply</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>

                                                                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                            style="content-align:right">
                                                                            <button type="submit"
                                                                                class="btn btn-success ml-auto mr-2 waves-effect waves-themed"
                                                                                name="update-progress"
                                                                                value="verify-payment-proof"><i
                                                                                    class="ni ni-check"></i> Verify All
                                                                                Ticked</button>
                                                                            <button type="submit" name="update-progress"
                                                                                value="reject-payment-proof"
                                                                                class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                    class="ni ni-close"></i> Reject All
                                                                                Ticked</button>

                                                                            <div class="modal fade"
                                                                                id="crud-modals-view-proof"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="card-header">
                                                                                            <h5 class="card-title w-100">
                                                                                                Payment
                                                                                                Proof
                                                                                            </h5>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="form-group col"
                                                                                                id="carousel-view-proof"
                                                                                                style="display:none">

                                                                                                <!--Carousel Wrapper-->
                                                                                                <div id="multi-item-example"
                                                                                                    class="carousel slide carousel-multi-item"
                                                                                                    data-ride="carousel">

                                                                                                    <!--Controls-->
                                                                                                    <div
                                                                                                        class="controls-top">
                                                                                                        <a class="btn-floating"
                                                                                                            href="#multi-item-example"
                                                                                                            data-slide="prev"><i
                                                                                                                class="ni ni-arrow-left"></i></a>

                                                                                                        <a class="btn-floating"
                                                                                                            href="#multi-item-example"
                                                                                                            data-slide="next"><i
                                                                                                                class="ni ni-arrow-right"></i></a>
                                                                                                    </div>
                                                                                                    <!--/.Controls-->

                                                                                                    <!--Indicators-->
                                                                                                    <ol class="carousel-indicators mb-0"
                                                                                                        id="carousel-indicators-view-proof">
                                                                                                    </ol>
                                                                                                    <!--/.Indicators-->

                                                                                                    <!--Slides-->
                                                                                                    <div class="carousel-inner"
                                                                                                        role="listbox"
                                                                                                        id="carousel-slides-view-proof">
                                                                                                    </div>
                                                                                                    <!--/.Slides-->

                                                                                                </div>
                                                                                                <!--/.Carousel Wrapper-->
                                                                                            </div>
                                                                                            <hr class="mt-1 mb-1">
                                                                                            <div
                                                                                                class="form-group col col-sm-5">
                                                                                                <label class="form-label"
                                                                                                    for="amount_to_be_verified">Fee
                                                                                                    Amount</label>
                                                                                                <div class="input-group flex-nowrap"
                                                                                                    id="fee_id_show_to_be_verified"
                                                                                                    name="fee_id_show_to_be_verified"
                                                                                                    style="width:auto">
                                                                                                    <div
                                                                                                        class="input-group-prepend">
                                                                                                        <span
                                                                                                            class="input-group-text"
                                                                                                            style="background-color:white; border-style: none;"
                                                                                                            id="addon-wrapping">RM</span>
                                                                                                    </div>
                                                                                                    <input
                                                                                                        class="form-control-plaintext"
                                                                                                        id="amount_to_be_verified"
                                                                                                        name="amount_to_be_verified"
                                                                                                        readonly>
                                                                                                    <div
                                                                                                        class="input-group-append">
                                                                                                        <span
                                                                                                            style="background-color:white; border-style: none;"
                                                                                                            class="input-group-text">/
                                                                                                            person</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <hr class="mt-1 mb-1">
                                                                                            {{-- <div class="invalid-feedback">Example invalid custom file feedback</div> --}}
                                                                                            <div class="footer">
                                                                                                <button type="button"
                                                                                                    class="btn btn-danger ml-auto float-right mr-2"
                                                                                                    data-dismiss="modal"><i
                                                                                                        class="fal fa-window-close"></i>
                                                                                                    Close</button>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
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
                                    <div class="tab-pane" id="application-status" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span>
                                                                    List of Ready for Event
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                {{-- <form action="{{ url('/senarai_kolej/student/bundle/into/' . $event->id) }}" method="post"
                                                                    name="form"> --}}
                                                                <div class="panel-content">
                                                                    @if (Session::has('messageAllExpectedAttendances'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('messageAllExpectedAttendances') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('notification'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('notification') }}
                                                                        </div>
                                                                    @endif
                                                                    <form action="{{ url('/update-progress/bundle') }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <div class="table-responsive">
                                                                            <table id="table-expected-attendances"
                                                                                name="table-update-progress-4"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-all-expected-attendances">
                                                                                        </th>
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>IC</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}

                                                                                        <th>Attendance Status</th>
                                                                                        <th>Feedback Status</th>
                                                                                        <th>Date Apply</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>

                                                                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                            style="content-align:right">
                                                                            <button type="submit" name="update-progress"
                                                                                value="verify-attendance-attend"
                                                                                class="btn btn-success ml-auto mr-2 waves-effect waves-themed"><i
                                                                                    class="ni ni-check"></i> All
                                                                                Ticked Are Attend</button>
                                                                            <button type="submit" name="update-progress"
                                                                                value="verify-attendance-not-attend"
                                                                                class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                    class="ni ni-close"></i> All
                                                                                Ticked Are Not Attend</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                                {{-- <button type="button" class="btn btn-success ml-auto mr-2 waves-effect waves-themed" onclick="window.location='http://sims.test/checkrequirements'"><i class="fal fa-check-circle"></i> Run All</button> --}}

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span> List of Disqualified
                                                                    Application
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                <form name="form">
                                                                    @csrf
                                                                    <div class="panel-content">
                                                                        @if (Session::has('messageDisqualified'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('messageDisqualified') }}
                                                                            </div>
                                                                        @endif
                                                                        @if (Session::has('notification'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('notification') }}
                                                                            </div>
                                                                        @endif

                                                                        <div class="table-responsive">
                                                                            <table id="table-disqualified"
                                                                                name="table-update-progress-5"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">

                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        <th>Date Apply</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>

                                                                    </div>
                                                                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                        style="content-align:right">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="attendance-status" role="tabpanel" hidden>
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Succeed Attendance - </span>
                                                                    (Attended Participants) Send Feedback
                                                                    Questionaire
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                <div class="panel-content">
                                                                    @if (Session::has('messageAllPartcipantPostEvent'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('messageAllPartcipantPostEvent') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('notification'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('notification') }}
                                                                        </div>
                                                                    @endif

                                                                    <form action="{{ url('/update-progress/bundle') }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <div class="table-responsive">

                                                                            <table id="table-participant-post-event"
                                                                                name="table-update-progress-6"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-all-participants-post-event">
                                                                                        </th>
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        <th>Date Apply</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                            style="content-align:right">
                                                                            <button type="submit" name="update-progress"
                                                                                value="send-question"
                                                                                class="btn btn-success ml-auto mr-2 waves-effect waves-themed"><i
                                                                                    class="ni ni-check"></i> Send
                                                                                Questionaire
                                                                                to All
                                                                                Ticked</button>
                                                                            <button type="submit" style="display:none"
                                                                                class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                    class="ni ni-close"></i> Ignore
                                                                                Questionaire
                                                                                to All
                                                                                Ticked</button>
                                                                        </div>
                                                                    </form>

                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Failed Attendance - </span> (Not
                                                                    Attended
                                                                    Participants)
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                <form name="form">
                                                                    @csrf
                                                                    <div class="panel-content">
                                                                        @if (Session::has('messageAllNotAttendedParticipant'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('messageAllNotAttendedParticipant') }}
                                                                            </div>
                                                                        @endif
                                                                        @if (Session::has('notification'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('notification') }}
                                                                            </div>
                                                                        @endif

                                                                        <div class="table-responsive">
                                                                            <table id="table-not-attended-participants"
                                                                                name="table-update-progress-7"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        <th>Date Apply</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="feedback-status" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span>Feedback Status
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                <form name="form">
                                                                    @csrf
                                                                    <div class="panel-content">
                                                                        @if (Session::has('messageCompletedParticipationProcess'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('messageCompletedParticipationProcess') }}
                                                                            </div>
                                                                        @endif
                                                                        @if (Session::has('notification'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('notification') }}
                                                                            </div>
                                                                        @endif

                                                                        <div class="table-responsive">
                                                                            <table
                                                                                id="table-completed-participation-process"
                                                                                name="table-update-progress-8"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>IC</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        <th>Feedback Done Datetime</th>
                                                                                        <th>Date Apply</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Failed Participants - </span> (Not
                                                                    Returned Feedback Yet) Not
                                                                    Completed
                                                                    Participation Process Yet
                                                                </h2>
                                                                <div class="panel-toolbar">
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-collapse" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Collapse"></button>
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-fullscreen" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Fullscreen"></button>
                                                                    <button class="btn btn-panel" data-action="panel-close"
                                                                        data-toggle="tooltip" data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
                                                                <form name="form">
                                                                    @csrf
                                                                    <div class="panel-content">
                                                                        @if (Session::has('messageAllNotCompletedParticipationProcess'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('messageAllNotCompletedParticipationProcess') }}
                                                                            </div>
                                                                        @endif
                                                                        @if (Session::has('notification'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('notification') }}
                                                                            </div>
                                                                        @endif

                                                                        <div class="table-responsive">
                                                                            <table
                                                                                id="table-not-completed-participation-process"
                                                                                name="table-update-progress-9"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        <th>Date Apply</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
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
        var event_id = '<?php echo $event->id; ?>';


        // $(document).ready(function() {

        //     $('.fee_id').select2();
        // });

        // Processes
        { // Pre-Event
            {
                //New Application
                {
                    $('#new-application').click(function() {
                        var ic = null;
                        $('.modal-body #ic_input').val(ic);

                        $("div[id=form-application-second-part]").hide();
                        $('#crud-modal-new-application').modal('show');
                    });

                    $('#crud-modal-new-application').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget)
                        var ic = button.data('ic');

                        $('.modal-body #ic_input').val(ic);
                    });

                    $('#search-by-ic').click(function() {
                        var ic = $('.modal-body #ic_input').val();
                        $.get("/participant/search-by-ic/" + ic + "/event/" + event_id, function(data) {
                            $('.modal-body #application_update_submit').empty();
                            $('.modal-body #application_message').empty();
                            if (data.id) {
                                // TODO: Already Applied
                                $('.modal-body #fullname').attr('readonly', true);
                                $('.modal-body #phone').attr('readonly', true);
                                $('.modal-body #email').attr('readonly', true);

                                $('.modal-body #application_update_submit').append(
                                    '<i class = "fal fa-save"></i> Update');

                                // $('.modal-body #application_update_submit').hide();

                                $('.modal-body #application_message').append(
                                    'Already Apply');

                            } else {
                                // TODO: Not Apply Yet

                                $('.modal-body #fullname').removeAttr('readonly', true);
                                $('.modal-body #phone').removeAttr('readonly', true);
                                $('.modal-body #email').removeAttr('readonly', true);
                                $('.modal-body #application_update_submit').append(
                                    '<i class = "ni ni-plus"></i> Apply');
                                $('.modal-body #application_message').append(
                                    'Make New Application');
                            }

                            if (data.participant) {
                                $('.modal-body #fullname').val(data.participant.name);
                                $('.modal-body #phone').val(data.participant.phone);
                                $('.modal-body #email').val(data.participant.email);
                            } else {
                                $('.modal-body #fullname').val(null);
                                $('.modal-body #phone').val(null);
                                $('.modal-body #email').val(null);

                            }
                            var fees = @json($event->fees);
                            if (fees.length > 1) {
                                $('#promo_code_col').show();
                            } else {
                                $('#promo_code_col').hide();
                            }
                            if (data.fee_id) {
                                $("select[id=fee_id]").val(data.fee_id);
                                $('.modal-body #promo_code').val(data.fee.promo_code);
                                $("input[id=fee_id_input]").val(data.fee.amount);
                                $("select[id=fee_id]").hide();
                                $("div[id=fee_id_show]").show();
                                if (data.fee.promo_code) {
                                    $('.modal-body #promo_code').attr('readonly', true);
                                    $('#promo_code_edit_add').hide();
                                    $('#promo_code_edit_remove').show();
                                }

                            } else {
                                $("select[id=fee_id]").val(null);
                                $('.modal-body #promo_code').val(null);
                                $("input[id=fee_id_input]").val(0);
                                $("select[id=fee_id]").hide();
                                $("div[id=fee_id_show]").show();
                            }
                            if ($('#represent-by-himself:checked').length > 0) {
                                $('.modal-body #representative_ic_input').val(ic);
                                if (data.participant) {
                                    $('.modal-body #representative_fullname').val(data.participant.name);
                                }
                            }

                        }).fail(
                            function() {
                                $('.modal-body #fullname').val(null);
                                $('.modal-body #phone').val(null);
                                $('.modal-body #email').val(null);


                                $("select[id=fee_id]").hide();
                                $("div[id=fee_id_show]").show();

                                if ($('#represent-by-himself:checked').length > 0) {
                                    $('.modal-body #representative_ic_input').val(ic);
                                    $('.modal-body #representative_fullname').val(null);
                                }
                            }).always(
                            function() {
                                $("div[id=form-application-second-part]").show();
                                $("#new_application_footer").show();

                            });
                    });

                    // promo_code_edit_add
                    $('#promo_code_edit_add').click(function() {
                        var promo_code = $('.modal-body #promo_code').val();
                        $.get("/event/" + event_id + "/promo-code/" + promo_code + "/participant", function(data) {
                            if (data.fee_id) {
                                $("input[id=fee_id_input]").val(data.fee.amount);
                                $("select[id=fee_id]").hide();
                                $("div[id=fee_id_show]").show();
                                $('#promo_code_edit_add').hide();
                                $('#promo_code_edit_remove').show();
                                $('.modal-body #promo_code').attr('readonly', true);
                                $("select[id=fee_id]").val(data.fee_id);

                            } else {
                                $('.modal-body #promo_code').val(null);
                            }
                        }).fail(
                            function() {
                                // TODO: The code is not valid
                            });

                    });

                    // promo_code_edit_remove
                    $('#promo_code_edit_remove').click(function() {
                        $.get("/event/" + event_id + "/base-fee", function(data) {
                            var promo_code = $('.modal-body #promo_code').val(null);
                            if (data.fee_id) {
                                $("input[id=fee_id_input]").val(data.fee.amount);
                                $("select[id=fee_id]").hide();
                                $("div[id=fee_id_show]").show();
                                $('#promo_code_edit_add').show();
                                $('#promo_code_edit_remove').hide();
                                $('.modal-body #promo_code').removeAttr('readonly');
                                $("select[id=fee_id]").val(data.fee_id);

                            }
                        });

                    });

                    $('#ic_input').change(function() {
                        // var id = null;
                        var ic_input = $('.modal-body #ic_input').val();
                        $('.modal-body #fullname').val(null);
                        $('.modal-body #phone').val(null);
                        $('.modal-body #email').val(null);
                        $('.modal-body #representative_ic_input').val(ic_input);
                        $('.modal-body #representative_fullname').val(null);
                        $("div[id=form-application-second-part]").hide();
                        $("#new_application_footer").hide();

                        $('#search-by-ic').trigger("click");

                    });

                    $('.modal-body #fullname').change(function() {
                        // var id = null;
                        var fullname = $('.modal-body #fullname').val();
                        $('.modal-body #representative_fullname').val(fullname);

                    });


                    $("input[id=represent-by-himself]").change(function() {
                        var representByHimself = '';

                        $('.modal-body #representative-ic').val(null);
                        $('.modal-body #representative-email').val(null);
                        $("p[id=representative-doesnt-exist]").hide();
                        $("div[id=form-application-third-part]").hide();
                        $('.modal-body #represent-by-himself').val(representByHimself);
                        if ($(this)[0].checked) {
                            $("div[id=representative]").hide();
                        } else {
                            $("div[id=representative]").show();
                        }
                    });
                }

                // search-by-representative-ic
                {
                    $('#search-by-representative-ic').click(function() {
                        var representativeIc = $('.modal-body #representative-ic').val();
                        $.get("/participant/search-by-representative-ic/" + representativeIc, function(data) {
                            $('.modal-body #representative_fullname').val(data.name);
                        }).fail(
                            function() {
                                $("p[id=representative-doesnt-exist]").show();
                            }).done(
                            function() {
                                $("div[id=form-application-third-part]").show();
                            });

                    });

                    $('#close-new-application').click(function() {
                        $('.modal-body #ic').val(null);
                        $('.modal-body #fullname').val(null);
                        $('.modal-body #phone').val(null);
                        $('.modal-body #email').val(null);
                    });
                }

                // all applicants
                {
                    $(document).ready(function() {
                        $("#check-all-applicants").click(function() {
                            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                        });

                        $("input[type=checkbox]").click(function() {
                            if (!$(this).prop("checked")) {
                                $('#check-all-applicants').prop("checked", false);
                            }
                        });
                    })

                    var tableApplicants = $('#table-applicants').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-applicants",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [{
                                data: 'checkApplicant',
                                name: 'checkApplicant',
                                orderable: false,
                                searchable: false
                            }, {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            {
                                className: 'text-center',
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [1, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-applicants thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableApplicants.column(i).search() !== this.value) {
                                tableApplicants
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableApplicants.column(i).search() !== this.value) {
                                tableApplicants
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    $('#table-applicants').on('click', '.btn-delete[data-remote]', function(e) {
                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var url = $(this).data('remote');

                        Swal.fire({
                            title: 'Approved this applicant?',
                            text: "This applicant will be approved!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, approve this applicant!',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.value) {
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        method: 'POST',
                                        submit: true
                                    }
                                }).always(function(data) {
                                    $('#table-applicants').DataTable().draw(false);
                                });


                                // var delayInMilliseconds = 5000; //5 second

                                // setTimeout(function() {
                                //     //your code to be executed after 5 second
                                //     $('#studentWithoutKolej').DataTable().ajax.reload();
                                // }, delayInMilliseconds);

                            }
                        })
                    });
                }

                // all no payment yet
                {
                    $(document).ready(function() {
                        $("#check-all-no-payment-yet").click(function() {
                            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                        });

                        $("input[type=checkbox]").click(function() {
                            if (!$(this).prop("checked")) {
                                $('#check-all-no-payment-yet').prop("checked", false);
                            }
                        });
                    })

                    var tableAllNoPaymentYet = $('#table-all-no-payment-yet').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-no-payment-yet",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [{
                                data: 'checkNoPaymentYet',
                                name: 'checkNoPaymentYet',
                                orderable: false,
                                searchable: false
                            }, {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.ic',
                                name: 'participant.ic'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            {
                                className: 'text-center',
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [1, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-all-no-payment-yet thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableAllNoPaymentYet.column(i).search() !== this.value) {
                                tableAllNoPaymentYet
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableAllNoPaymentYet.column(i).search() !== this.value) {
                                tableAllNoPaymentYet
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    // request_verification
                    $('#request_verification').click(function() {
                        var is_verified_payment_proof = $("#is_verified_payment_proof_id").val();
                        var event_id = $("#event_id").val();
                        var participant_id = $("#participant_id").val();
                        if (!is_verified_payment_proof) {
                            $.get("/shortcourse/participant/request-verification/event/" + event_id +
                                "/participant_id/" + participant_id,
                                function(data) {
                                    var stringStatus = '';
                                    if (typeof(data.is_verified_payment_proof) !== "number") {
                                        stringStatus = "No request for verification yet"
                                        $("#request_verification").attr("disabled", "false");
                                        style = 'text-danger';
                                    } else if (data.is_verified_payment_proof == 0) {
                                        stringStatus = "In verification Process"
                                        $("#request_verification").attr("disabled", "true");
                                        style = 'text-primary';
                                    } else if (data.is_verified_payment_proof == 1) {
                                        stringStatus = "Verified!"
                                        $("#request_verification").attr("disabled", "true");
                                        style = 'text-success';
                                    }
                                    $("#is_verified_payment_proof_id").val(data.is_verified_payment_proof);
                                    $('.modal-body #is_verified_payment_proof').val(stringStatus);
                                    $('.modal-body #is_verified_payment_proof').addClass(style);
                                    console.log('masuk');
                                    setTimeout(function() {
                                        //your code to be executed after 10 second
                                        tableAllNoPaymentYet.ajax.reload();
                                    }, 5000);
                                    setTimeout(function() {
                                        //your code to be executed after 10 second
                                        tablePaymentWaitForVerification.ajax.reload();
                                    }, 10000);
                                }).fail(
                                function() {
                                    // TODO: The code is not valid
                                });
                        }
                    });

                    //Update Payment Proof
                    {

                        $('#crud-modals').on('show.bs.modal', function(event) {
                            var button = $(event.relatedTarget);
                            var is_verified_payment_proof_id = button.data('is_verified_payment_proof');
                            $("#is_verified_payment_proof_id").val(is_verified_payment_proof_id);
                            var event_id = button.data('event_id');
                            $("#event_id").val(event_id);
                            var participant_id = button.data('participant_id');
                            $("#participant_id").val(participant_id);
                            var event_participant_id = button.data('event_participant_id');
                            $("#event_participant_id").val(event_participant_id);
                            var amount = button.data('amount');
                            $("#amount").val(amount);
                            var stringStatus;
                            var style;
                            if (typeof(is_verified_payment_proof_id) !== "number") {
                                stringStatus = "No request for verification yet"
                                style = 'text-danger';
                                // $("#request_verification").attr("disabled", "false");
                            } else if (is_verified_payment_proof_id == 0) {
                                stringStatus = "In verification Process"
                                $("#request_verification").attr("disabled", "true");
                                style = 'text-primary';
                            } else if (is_verified_payment_proof_id == 1) {
                                stringStatus = "Verified!"
                                $("#request_verification").attr("disabled", "true");
                                style = 'text-success';
                                $("#submit_payment_proof").attr("disabled", "true");
                            }
                            // var payment_proof_path = button.data('payment_proof_path');
                            // if (!payment_proof_path) {
                            //     $("#payment_proof_path").hide();
                            // } else {
                            //     $("#payment_proof_path").show();
                            //     var src = `{{ asset('${payment_proof_path}') }}`;
                            //     $("#payment_proof_path").attr("src", src);
                            // }

                            $('#carousel').hide();

                            $.get("/event-participant/" + event_participant_id + "/payment_proof",
                                function(data) {
                                    // TODO: Insert result into couresol

                                    data.forEach(function(img, index) {
                                        var src = `{{ asset('${img.payment_proof_path}') }}`;
                                        $('#carousel-indicators').append(
                                            `<li data-target="#multi-item-example" data-slide-to="${index}" ${index==0?"class='active'":null}></li>`
                                        );

                                        $('#carousel-slides').append(
                                            `<div class="carousel-item ${index==0?"active":null}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card mb-5">
                                                            <img class="card-img-top"
                                                                src="${src}"
                                                                alt="Card image cap">
                                                            <div
                                                                class="card-body d-flex justify-content-between">
                                                                <h4 class="card-title">${img.created_at_diffForHumans}</h4>
                                                                    <form method="post"
                                                                        action="/event-participant-payment_proof/delete/${img.id}">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger float-right mr-2" ${is_verified_payment_proof_id==1?'disabled':null}>
                                                                            <i class="ni ni-close"></i>
                                                                        </button>
                                                                    </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`);
                                    });
                                    if (data.length > 0) {
                                        $('#carousel').show();
                                    } else {
                                        $('#carousel').hide();
                                    }
                                }).fail(
                                function() {
                                    // TODO: Notify Users
                                    console.log('fail');
                                });

                            $('.modal-body #is_verified_payment_proof').val(stringStatus);
                            $('.modal-body #is_verified_payment_proof').addClass(style);
                        });
                    }

                    //View Payment Proof
                    {

                        $('#crud-modals-view-proof').on('show.bs.modal', function(event) {
                            var button = $(event.relatedTarget);
                            var is_verified_payment_proof_id = button.data('is_verified_payment_proof');
                            $("#is_verified_payment_proof_id").val(is_verified_payment_proof_id);
                            var event_id = button.data('event_id');
                            $("#event_id").val(event_id);
                            var participant_id = button.data('participant_id');
                            $("#participant_id").val(participant_id);
                            var event_participant_id = button.data('event_participant_id');
                            $("#event_participant_id").val(event_participant_id);
                            var amount = button.data('amount');
                            $("#amount_to_be_verified").val(amount);
                            var stringStatus;
                            var style;
                            if (typeof(is_verified_payment_proof_id) !== "number") {
                                stringStatus = "No request for verification yet"
                                style = 'text-danger';
                                // $("#request_verification").attr("disabled", "false");
                            } else if (is_verified_payment_proof_id == 0) {
                                stringStatus = "In verification Process"
                                $("#request_verification").attr("disabled", "true");
                                style = 'text-primary';
                            } else if (is_verified_payment_proof_id == 1) {
                                stringStatus = "Verified!"
                                $("#request_verification").attr("disabled", "true");
                                style = 'text-success';
                                $("#submit_payment_proof").attr("disabled", "true");
                            }
                            // var payment_proof_path = button.data('payment_proof_path');
                            // if (!payment_proof_path) {
                            //     $("#payment_proof_path").hide();
                            // } else {
                            //     $("#payment_proof_path").show();
                            //     var src = `{{ asset('${payment_proof_path}') }}`;
                            //     $("#payment_proof_path").attr("src", src);
                            // }

                            $('#carousel-view-proof').hide();

                            $.get("/event-participant/" + event_participant_id + "/payment_proof",
                                function(data) {
                                    // TODO: Insert result into couresol

                                    data.forEach(function(img, index) {
                                        var src = `{{ asset('${img.payment_proof_path}') }}`;
                                        $('#carousel-indicators-view-proof').append(
                                            `<li data-target="#multi-item-example" data-slide-to="${index}" ${index==0?"class='active'":null}></li>`
                                        );

                                        $('#carousel-slides-view-proof').append(
                                            `<div class="carousel-item ${index==0?"active":null}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card mb-5">
                                                            <img class="card-img-top"
                                                                src="${src}"
                                                                alt="Card image cap">
                                                            <div
                                                                class="card-body d-flex justify-content-between">
                                                                <h4 class="card-title">${img.created_at_diffForHumans}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`);
                                    });
                                    if (data.length > 0) {
                                        $('#carousel-view-proof').show();
                                    } else {
                                        $('#carousel-view-proof').hide();
                                    }
                                }).fail(
                                function() {
                                    // TODO: Notify Users
                                    console.log('fail');
                                });
                        });
                    }
                }

                // all payment waiting for verification
                {
                    $(document).ready(function() {
                        $("#check-payment-wait-for-verification").click(function() {
                            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                        });

                        $("input[type=checkbox]").click(function() {
                            if (!$(this).prop("checked")) {
                                $('#check-payment-wait-for-verification').prop("checked", false);
                            }
                        });
                    })

                    var tablePaymentWaitForVerification = $('#table-payment-wait-for-verification').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-payment-wait-for-verification",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [{
                                data: 'checkPaymentWaitForVerification',
                                name: 'checkPaymentWaitForVerification',
                                orderable: false,
                                searchable: false
                            }, {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.ic',
                                name: 'participant.ic'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },

                            {
                                className: 'text-center',
                                data: 'proof',
                                name: 'proof',
                            },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            {
                                className: 'text-center',
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [1, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-payment-wait-for-verification thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tablePaymentWaitForVerification.column(i).search() !== this.value) {
                                tablePaymentWaitForVerification
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tablePaymentWaitForVerification.column(i).search() !== this.value) {
                                tablePaymentWaitForVerification
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    $('#table-payment-wait-for-verification').on('click', '.btn-delete[data-remote]', function(e) {
                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var url = $(this).data('remote');

                        Swal.fire({
                            title: 'Verify this payment?',
                            text: "This payment will be verified!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, verify this payment!',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.value) {
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        method: 'POST',
                                        submit: true
                                    }
                                }).always(function(data) {
                                    $('#table-payment-wait-for-verification').DataTable().draw(
                                        false);
                                });


                                // var delayInMilliseconds = 5000; //5 second

                                // setTimeout(function() {
                                //     //your code to be executed after 5 second
                                //     $('#studentWithoutKolej').DataTable().ajax.reload();
                                // }, delayInMilliseconds);

                            }
                        })
                    });
                }

                // all ready for event
                {
                    var tableReadyForEvent = $('#table-ready-for-event').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-ready-for-event",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
                            // {
                            //     data: 'checkReadyForEvent',
                            //     name: 'checkReadyForEvent',
                            //     orderable: false,
                            //     searchable: false
                            // },
                            {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'action',
                            //     name: 'action',
                            //     orderable: false,
                            //     searchable: false
                            // }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [0, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-ready-for-event thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableReadyForEvent.column(i).search() !== this.value) {
                                tableReadyForEvent
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableReadyForEvent.column(i).search() !== this.value) {
                                tableReadyForEvent
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }

                // all disqualified
                {
                    var tableDisqualified = $('#table-disqualified').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-disqualified",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
                            // {
                            //     data: 'checkDisqualified',
                            //     name: 'checkDisqualified',
                            //     orderable: false,
                            //     searchable: false
                            // },
                            {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'action',
                            //     name: 'action',
                            //     orderable: false,
                            //     searchable: false
                            // }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [0, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-disqualified thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableDisqualified.column(i).search() !== this.value) {
                                tableDisqualified
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableDisqualified.column(i).search() !== this.value) {
                                tableDisqualified
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
            }

            // During Event
            { // all expected attendances
                {
                    $(document).ready(function() {
                        $("#check-all-expected-attendances").click(function() {
                            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                        });

                        $("input[type=checkbox]").click(function() {
                            if (!$(this).prop("checked")) {
                                $('#check-all-expected-attendances').prop("checked", false);
                            }
                        });
                    })

                    var tableExpectedAttendances = $('#table-expected-attendances').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-expected-attendances",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [{
                                data: 'checkExpectedAttendace',
                                name: 'checkExpectedAttendace',
                                orderable: false,
                                searchable: false
                            }, {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.ic',
                                name: 'participant.ic'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'attendance_status',
                                name: 'attendance_status',
                            },

                            {
                                className: 'text-center',
                                data: 'send_question',
                                name: 'send_question',
                            },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            {
                                className: 'text-center',
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [1, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-expected-attendances thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableExpectedAttendances.column(i).search() !== this.value) {
                                tableExpectedAttendances
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableExpectedAttendances.column(i).search() !== this.value) {
                                tableExpectedAttendances
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    $('#table-expected-attendances').on('click', '.btn-delete[data-remote]', function(e) {
                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var url = $(this).data('remote');

                        Swal.fire({
                            title: 'Verify attendance for this attendant?',
                            text: "This attendant attendance will be verified!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, this attendant attand this event!',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.value) {
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        method: 'POST',
                                        submit: true
                                    }
                                }).always(function(data) {
                                    $('#table-expected-attendances').DataTable().draw(false);
                                });


                                // var delayInMilliseconds = 5000; //5 second

                                // setTimeout(function() {
                                //     //your code to be executed after 5 second
                                //     $('#studentWithoutKolej').DataTable().ajax.reload();
                                // }, delayInMilliseconds);

                            }
                        })
                    });
                }

                // all attended participant
                {
                    var tableAttendedParticipants = $('#table-attended-participants').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-attended-participants",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },

                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-expected-attendances",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
                            // {
                            //     data: 'checkAttendedParticipants',
                            //     name: 'checkAttendedParticipants',
                            //     orderable: false,
                            //     searchable: false
                            // },
                            {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'action',
                            //     name: 'action',
                            //     orderable: false,
                            //     searchable: false
                            // }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [0, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-attended-participants thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableAttendedParticipants.column(i).search() !== this.value) {
                                tableAttendedParticipants
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableAttendedParticipants.column(i).search() !== this.value) {
                                tableAttendedParticipants
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }

                // all not attended participant
                {
                    var tableNotAttendedParticipants = $('#table-not-attended-participants').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-not-attended-participants",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
                            // {
                            //     data: 'checkAttendedParticipants',
                            //     name: 'checkAttendedParticipants',
                            //     orderable: false,
                            //     searchable: false
                            // },
                            {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'action',
                            //     name: 'action',
                            //     orderable: false,
                            //     searchable: false
                            // }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [0, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-not-attended-participants thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableNotAttendedParticipants.column(i).search() !== this.value) {
                                tableNotAttendedParticipants
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableNotAttendedParticipants.column(i).search() !== this.value) {
                                tableNotAttendedParticipants
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
            }

            // Post-Event
            { // all participants post event
                {
                    $(document).ready(function() {
                        $("#check-all-participants-post-event").click(function() {
                            $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
                        });

                        $("input[type=checkbox]").click(function() {
                            if (!$(this).prop("checked")) {
                                $('#check-all-participants-post-event').prop("checked", false);
                            }
                        });
                    })

                    var tableParticipantPostEvent = $('#table-participant-post-event').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-participant-post-event",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [{
                                data: 'checkParticipantPostEvent',
                                name: 'checkParticipantPostEvent',
                                orderable: false,
                                searchable: false
                            }, {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            {
                                className: 'text-center',
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [1, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-participant-post-event thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableParticipantPostEvent.column(i).search() !== this.value) {
                                tableParticipantPostEvent
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableParticipantPostEvent.column(i).search() !== this.value) {
                                tableParticipantPostEvent
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    $('#table-participant-post-event').on('click', '.btn-delete[data-remote]', function(e) {
                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        var url = $(this).data('remote');

                        Swal.fire({
                            title: 'Verify attendance for this attendant?',
                            text: "This attendant attendance will be verified!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, this attendant attand this event!',
                            cancelButtonText: 'No'
                        }).then((result) => {
                            if (result.value) {
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        method: 'POST',
                                        submit: true
                                    }
                                }).always(function(data) {
                                    $('#table-participant-post-event').DataTable().draw(false);
                                });


                                // var delayInMilliseconds = 5000; //5 second

                                // setTimeout(function() {
                                //     //your code to be executed after 5 second
                                //     $('#studentWithoutKolej').DataTable().ajax.reload();
                                // }, delayInMilliseconds);

                            }
                        })
                    });
                }

                // all completed participation process
                {
                    var tableCompletedParticipationProcess = $('#table-completed-participation-process').DataTable({
                        columnDefs: [{
                            targets: [1],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        },{
                            targets: [6],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-completed-participation-process",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
                            // {
                            //     data: 'checkCompletedParticipationProcess',
                            //     name: 'checkCompletedParticipationProcess',
                            //     orderable: false,
                            //     searchable: false
                            // },
                            {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.ic',
                                name: 'participant.ic'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },

                            {
                                className: 'text-center',
                                data: 'done_email_completed_datetime_diffForHumans',
                                name: 'done_email_completed_datetime_diffForHumans',
                            },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'action',
                            //     name: 'action',
                            //     orderable: false,
                            //     searchable: false
                            // }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [0, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-completed-participation-process thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableCompletedParticipationProcess.column(i).search() !== this.value) {
                                tableCompletedParticipationProcess
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableCompletedParticipationProcess.column(i).search() !== this.value) {
                                tableCompletedParticipationProcess
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }

                // all not completed participation process
                {
                    var tableNotCompletedParticipationProcess = $('#table-not-completed-participation-process').DataTable({
                        columnDefs: [{
                            targets: [2],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id +
                                "/events-participants/data-not-completed-participation-process",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
                            // {
                            //     data: 'checkCompletedParticipationProcess',
                            //     name: 'checkCompletedParticipationProcess',
                            //     orderable: false,
                            //     searchable: false
                            // },
                            {
                                className: 'text-center',
                                data: 'id',
                                name: 'id',
                            },
                            {
                                className: 'text-center',
                                data: 'organisationsString',
                                name: 'organisationsString'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.name',
                                name: 'participant.name'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.phone',
                                name: 'participant.phone'
                            },
                            {
                                className: 'text-center',
                                data: 'participant.email',
                                name: 'participant.email'
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.name',
                            //     name: 'organization_representative.participant.name'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.phone',
                            //     name: 'organization_representative.participant.phone'
                            // },
                            // {
                            //     className: 'text-center',
                            //     data: 'organization_representative.participant.email',
                            //     name: 'organization_representative.participant.email'
                            // },
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
                            // {
                            //     className: 'text-center',
                            //     data: 'action',
                            //     name: 'action',
                            //     orderable: false,
                            //     searchable: false
                            // }
                        ],
                        orderCellsTop: true,
                        "order": [
                            [0, "desc"]
                        ],
                        "initComplete": function(settings, json) {}
                    });

                    $('#table-not-completed-participation-process thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableNotCompletedParticipationProcess.column(i).search() !== this.value) {
                                tableNotCompletedParticipationProcess
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableNotCompletedParticipationProcess.column(i).search() !== this.value) {
                                tableNotCompletedParticipationProcess
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
            }

            // Update Progress
            {
                $('table[name*="table-update-progress"]').on('click', '.btn-update-progress[data-remote]', function(e) {

                    var tag = $(e.currentTarget);

                    var title = null;
                    var text = null;
                    var confirmButtonText = null;
                    var cancelButtonText = null;
                    var currentTableId = null;
                    var nextTableId = null;

                    switch (tag[0].id) {
                        case 'approve-application':
                            title = 'Approved this application?';
                            text = "This applicant will be asked to pay for the participation fee!";
                            confirmButtonText = 'Yes, approve this application!';
                            cancelButtonText = 'Not Yet';
                            currentTableId = '#table-applicants';
                            nextTableId = '#table-all-no-payment-yet';
                            break;
                        case ('reject-application'):
                            title = 'Reject this application?';
                            text = "This applicant will be rejected (deleted)!";
                            confirmButtonText = 'Yes, reject this application!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-applicants';
                            nextTableId = '#table-disqualified';
                            break;
                        case ('disqualified-application-no-payment'):
                            title = 'Disqualify this application?';
                            text = "This applicant will be disqualified!";
                            confirmButtonText = 'Yes, disqualify this application!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-all-no-payment-yet';
                            nextTableId = '#table-disqualified';
                            break;
                        case 'verify-payment-proof':
                            title = 'Verify this payment proof?';
                            text = "This payment will be verified!";
                            confirmButtonText = 'Yes, verify this payment!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-payment-wait-for-verification';
                            nextTableId = '#table-expected-attendances';
                            break;
                        case 'reject-payment-proof':
                            title = 'Reject this payment proof?';
                            text =
                                "This payment will be rejected! The participant will be asked to insert other proof";
                            confirmButtonText = 'Yes, reject this payment!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-payment-wait-for-verification';
                            nextTableId = '#table-all-no-payment-yet';
                            break;
                        case 'verify-attendance-attend':
                            title = 'This participant attend the event?';
                            text = "This participant attendance will be verified!";
                            confirmButtonText = 'Yes, the participant attend the event!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-expected-attendances';
                            nextTableId = '#table-participant-post-event';
                            break;
                        case 'verify-attendance-not-attend':
                            title = 'This participant not attend the event?';
                            text = "This participant will be verified to not attend the event!";
                            confirmButtonText = 'Yes, the participant not attend the event!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-expected-attendances';
                            nextTableId = '#table-not-attended-participants';
                            break;
                        case 'send-question':
                            title = 'Send feedback form to these participants?';
                            text = "This participant will be sent a feedback form!";
                            confirmButtonText = 'Yes, send the feedback form!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-participant-post-event';
                            nextTableId = '#table-not-completed-participation-process';
                            break;
                        default:
                            break;
                    }
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    console.log();
                    var url = $(this).data('remote');
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: confirmButtonText,
                        cancelButtonText: cancelButtonText
                    }).then((result) => {
                        if (result.value) {
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: url,
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    method: 'POST',
                                    submit: true
                                }
                            }).always(function(data) {
                                $(currentTableId).DataTable().draw(false);
                            });
                            var delayInMilliseconds = 10000; //10 second

                            setTimeout(function() {
                                //your code to be executed after 10 second
                                $(nextTableId).DataTable().ajax.reload();
                            }, delayInMilliseconds);

                        }
                    })
                });
            }
        }
    </script>
@endsection
