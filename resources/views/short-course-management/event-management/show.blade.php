@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i>
                {{ $event->id }} - {{ $event->name }}
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Event Information
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
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#general" role="tab">General</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#participant-pre-event"
                                        role="tab">Participants (Pre-Event)</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#participant-during-event"
                                        role="tab">Participants (During Event)</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#participant-post-event"
                                        role="tab">Participants (Post-Event)</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane active" id="general" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <table class="table">
                                                    <thead class="thead bg-primary-50">
                                                        <tr>
                                                            <th colspan="2"><b>Basic Information</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th style="background-color:plum">Name</th>
                                                            <td>: <b>{{ $event->name }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background-color:plum">Date Start</th>
                                                            <td>: <b>{{ $event->datetime_start }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background-color:plum">Date End</th>
                                                            <td>: <b>{{ $event->datetime_end }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <th style="background-color:plum">Venue</th>
                                                            <td>: <b>{{ $event->venue->name }}</b></td>
                                                        </tr>
                                                    <tbody>
                                                </table>
                                                <table class="table table-striped table-bordered m-0">
                                                    <thead class="thead">
                                                        <tr class=" bg-primary-50" scope="row">
                                                            <th colspan="4"><b>List of Fees</b></th>
                                                        </tr>
                                                        <tr style="background-color:plum" scope="row">
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col">Fee Type</th>
                                                            <th scope="col">Promo Code</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($event->fees as $fee)
                                                            <tr scope="row">
                                                                <td><b>{{ $fee->name }}</b></td>
                                                                <td><b>{{ $fee->amount }}</b></td>
                                                                <td><b>{{ $fee->is_base_fee }}</b></td>
                                                                <td><b>{{ $fee->promo_code }}</b></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <hr class="mt-2 mb-3">
                                                <table class="table table-striped table-bordered m-0">
                                                    <thead class="thead">
                                                        <tr class=" bg-primary-50">
                                                            <th colspan="2"><b>List of Trainers</b></th>
                                                        </tr>
                                                        <tr style="background-color:plum">
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($trainers as $trainer)
                                                            <tr>
                                                                <td><b>{{ $trainer->id }}</b></td>
                                                                <td><b>{{ $trainer->name }}</b></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <hr class="mt-2 mb-3">
                                                <table class="table table-striped table-bordered m-0">
                                                    <thead class="thead">
                                                        <tr class=" bg-primary-50">
                                                            <th colspan="2"><b>List of Short Courses</b></th>
                                                        </tr>
                                                        <tr style="background-color:plum">
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($event->events_shortcourses as $events_shortcourses)
                                                            <tr>
                                                                <td><b>{{ $events_shortcourses->shortcourse->id }}</b>
                                                                </td>
                                                                <td><b>{{ $events_shortcourses->shortcourse->name }}</b>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <hr class="mt-2 mb-3">

                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-primary-50"><b>Participant Statistics</b></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="5"><b>Pre-Event</b></th>
                                                            </tr>
                                                            <tr style="background-color:plum">
                                                                <th>Wait for Applic. Approv.</th>
                                                                <th>In progress of Make. Pay.</th>
                                                                <th>Wait for Pay. Confirm.</th>
                                                                <th>Ready for Event</th>
                                                                <th>Cancelled Applic.</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <td><b>0</b></td>
                                                            <td><b>0</b></td>
                                                            <td><b>0</b></td>
                                                            <td><b>0</b></td>
                                                            <td><b>0</b></td>
                                                        </tbody>
                                                    </table>
                                                    <hr class="mt-2 mb-3">
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="5"><b>During Event</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th style="background-color:plum; width:50%">Attend</th>
                                                                <td style="width:50%"><b>0</b></td>
                                                            </tr>
                                                            <tr>
                                                                <th style="background-color:plum; width:50%">Not Attend</th>
                                                                <td style="width:50%"><b>0</b></td>
                                                            </tr>
                                                        <tbody>
                                                    </table>
                                                    <hr class="mt-2 mb-3">
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="5"><b>Post-Event</b></th>
                                                            </tr>
                                                            <tr style="background-color:plum">
                                                                <th>Not Done Feedback</th>
                                                                <th>Done Feedback</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <td><b>0</b></td>
                                                            <td><b>0</b></td>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="participant-pre-event" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Step 1 - </span> Make Application
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
                                                                    <a href="javascript:;" data-toggle="modal"
                                                                        id="new-application"
                                                                        class="btn btn-primary px-5 mx-5 waves-effect waves-themed align-middle">
                                                                        Apply by INTEC</a>
                                                                    <div class="modal fade" id="crud-modal-new-application"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="card-header">
                                                                                    <h5 class="card-title w-150">Add New
                                                                                        Applicant</h5>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    {{-- {!! Form::open(['action' => 'EventParticipantController@store', 'method' => 'POST']) !!} --}}
                                                                                    <input type="hidden" name="id" id="id">
                                                                                    <p><span class="text-danger">*</span>
                                                                                        Vital Information</p>
                                                                                    <hr class="mt-1 mb-2">
                                                                                    <div class="form-group">
                                                                                        <label for="ic"><span
                                                                                                class="text-danger">*</span>
                                                                                            IC</label>
                                                                                        <div class="form-inline"
                                                                                            style="width:100%">
                                                                                            <div class="form-group mr-2 mb-2"
                                                                                                style="width:85%">
                                                                                                <input
                                                                                                    class="form-control w-100"
                                                                                                    id="ic" name="ic">
                                                                                            </div>
                                                                                            <a href="javascript:;"
                                                                                                data-toggle="#"
                                                                                                id="search-by-ic"
                                                                                                class="btn btn-primary mb-2"><i
                                                                                                    class="ni ni-magnifier"></i></a>
                                                                                        </div>
                                                                                        @error('ic')
                                                                                            <p style="color: red">
                                                                                                <strong> *
                                                                                                    {{ $message }}
                                                                                                </strong>
                                                                                            </p>
                                                                                        @enderror
                                                                                    </div>
                                                                                    <hr class="mt-1 mb-2">
                                                                                    <div id="form-application-second-part"
                                                                                        style="display: none">
                                                                                        <div class="form-group">
                                                                                            <label class="form-label"
                                                                                                for="fullname"><span
                                                                                                    class="text-danger">*</span>Fullname</label>
                                                                                            <input class="form-control"
                                                                                                id="fullname"
                                                                                                name="fullname">
                                                                                            @error('name')
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
                                                                                        <div
                                                                                            class="custom-control custom-checkbox">
                                                                                            <input type="checkbox"
                                                                                                class="custom-control-input"
                                                                                                id="represent-by-himself">
                                                                                            <label
                                                                                                class="custom-control-label"
                                                                                                for="represent-by-himself">Represent
                                                                                                By Himself</label>
                                                                                        </div>
                                                                                        <hr class="mt-1 mb-2">
                                                                                        <div id="representative">
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
                                                                                                            id="representative-ic"
                                                                                                            name="representative-ic">
                                                                                                    </div>
                                                                                                    <a href="javascript:;"
                                                                                                        data-toggle="#"
                                                                                                        id="search-by-representative-ic"
                                                                                                        class="btn btn-primary mb-2"><i
                                                                                                            class="ni ni-magnifier"></i></a>
                                                                                                </div>
                                                                                                @error('representative-ic')
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
                                                                                                    representative doesn't
                                                                                                    exist
                                                                                                </strong>
                                                                                            </p>
                                                                                            <p id="representative-doesnt-valid"
                                                                                                style="color: red; display:none;">
                                                                                                <strong> * The choosen
                                                                                                    participant is not valid
                                                                                                    to represent others
                                                                                                </strong>
                                                                                            </p>
                                                                                            <div id="form-application-third-part"
                                                                                                style="display: none">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        class="form-label"
                                                                                                        for="representative-fullname"><span
                                                                                                            class="text-danger">*</span>Representative
                                                                                                        Fullname</label>
                                                                                                    <input
                                                                                                        id="representative-fullname"
                                                                                                        name="representative-fullname"
                                                                                                        class="form-control"
                                                                                                        readonly>
                                                                                                    @error('representative-name')
                                                                                                        <p style="color: red">
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
                                                                                    <div class="footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-success ml-auto float-right mr-2"
                                                                                            data-dismiss="modal"
                                                                                            id="close-new-application"><i
                                                                                                class="fal fa-window-close"></i>
                                                                                            Close</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-primary ml-auto float-right mr-2"><i
                                                                                                class="ni ni-plus"></i>
                                                                                            Apply</button>
                                                                                    </div>

                                                                                    {{-- {!! Form::close() !!} --}}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- <button type="button" class="btn btn-success ml-auto mr-2 waves-effect waves-themed" onclick="window.location='http://sims.test/checkrequirements'"><i class="fal fa-check-circle"></i> Run All</button> --}}
                                                                {{-- </form> --}}
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
                                                                    <span class="fw-300">Step 2 - </span> Approved
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
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Step 3 - </span> Wait for this List
                                                                    of Applicant to Make Payments
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

                                                                        <div class="table-responsive">
                                                                            <table id="table-all-no-payment-yet"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-all-no-payment-yet">
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
                                                                            class="btn btn-danger ml-auto mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Disqualified All
                                                                            Ticked</button>
                                                                    </div>
                                                                </form>
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
                                                                    <span class="fw-300">Step 4 - </span> Verify Payment
                                                                    from this List of Applicants
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

                                                                        <div class="table-responsive">
                                                                            <table id="table-payment-wait-for-verification"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-payment-wait-for-verification">
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
                                                                                class="ni ni-close"></i> Verify All
                                                                            Ticked</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Reject All
                                                                            Ticked</button>
                                                                    </div>
                                                                </form>
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
                                                                    <span class="fw-300">Succeed - </span> Ready for
                                                                    Event
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
                                                                        @if (Session::has('messageReadyForEvent'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('messageReadyForEvent') }}
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
                                                                            <table id="table-ready-for-event"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        {{-- <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-ready-for-event">
                                                                                        </th> --}}
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
                                                                                        <th>Date Apply</th>
                                                                                        {{-- <th>Action</th> --}}
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>

                                                                    </div>
                                                                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                        style="content-align:right">
                                                                        {{-- <button type="submit"
                                                                            class="btn btn-success ml-auto mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Verify All
                                                                            Ticked</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Reject All
                                                                            Ticked</button> --}}
                                                                    </div>
                                                                </form>
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
                                                                    <span class="fw-300">Failed - </span> Disqualified
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
                                                                {{-- <form action="{{ url('/senarai_kolej/student/bundle/into/' . $event->id) }}" method="post"
                                                                    name="form"> --}}
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
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        {{-- <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-disqualified">
                                                                                        </th> --}}
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
                                                                                        <th>Date Apply</th>
                                                                                        {{-- <th>Action</th> --}}
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>

                                                                    </div>
                                                                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                        style="content-align:right">
                                                                        {{-- <button type="submit"
                                                                            class="btn btn-success ml-auto mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Verify All
                                                                            Ticked</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Reject All
                                                                            Ticked</button> --}}
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="participant-during-event" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Step 1 - </span> Verify Attendance
                                                                    from this List of Expected Attendances
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

                                                                        <div class="table-responsive">
                                                                            <table id="table-expected-attendances"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:10px"><input
                                                                                                type="checkbox"
                                                                                                id="check-all-expected-attendances">
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
                                                                                class="ni ni-check"></i> All
                                                                            Ticked Are Attend</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> All
                                                                            Ticked Are Not Attend</button>
                                                                    </div>
                                                                    {{-- <button type="button" class="btn btn-success ml-auto mr-2 waves-effect waves-themed" onclick="window.location='http://sims.test/checkrequirements'"><i class="fal fa-check-circle"></i> Run All</button> --}}
                                                                </form>
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
                                                                    <span class="fw-300">Succeed - </span> Attended Participant
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
                                                                        @if (Session::has('messageAllAttendedParticipant'))
                                                                            <div class="alert alert-success"
                                                                                style="color: #3b6324; background-color: #d3fabc;">
                                                                                <i class="icon fal fa-check-circle"></i>
                                                                                {{ Session::get('messageAllAttendedParticipant') }}
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
                                                                            <table id="table-attended-participants"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
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
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Failed - </span> Not Attended Participant
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
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
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
                                    <div class="tab-pane" id="participant-post-event" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Step 1 - </span> Send Feedback Questionaire
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

                                                                        <div class="table-responsive">
                                                                            <table id="table-participant-post-event"
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
                                                                                class="ni ni-check"></i> Send Questionaire to All
                                                                            Ticked</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger float-right mr-2 waves-effect waves-themed"><i
                                                                                class="ni ni-close"></i> Ignore Questionaire to All
                                                                                Ticked</button>
                                                                    </div>
                                                                    {{-- <button type="button" class="btn btn-success ml-auto mr-2 waves-effect waves-themed" onclick="window.location='http://sims.test/checkrequirements'"><i class="fal fa-check-circle"></i> Run All</button> --}}
                                                                </form>
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
                                                                    <span class="fw-300">Succeed - </span> Completed Participation Process
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
                                                                            <table id="table-completed-participation-process"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
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
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Failed - </span> Not Completed Participation Process
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
                                                                            <table id="table-not-completed-participation-process"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        {{-- <th>Representative Name</th>
                                                                                        <th>Representative Phone</th>
                                                                                        <th>Representative Email</th> --}}
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

        // new application

        $('#new-application').click(function() {
            var id = null;
            var ic = null;
            $('.modal-body #id').val(id);
            $('.modal-body #ic').val(ic);
            $('#crud-modal-new-application').modal('show');
        });

        $('#crud-modal-new-application').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var ic = button.data('ic');

            $('.modal-body #id').val(id);
            $('.modal-body #ic').val(ic);
        });

        $('#search-by-ic').click(function() {
            var ic = $('.modal-body #ic').val();
            $.get("/participant/search-by-ic/" + ic, function(data) {
                $('.modal-body #fullname').val(data.name);
                $('.modal-body #phone').val(data.phone);
                $('.modal-body #email').val(data.email);

            }).fail(
                function() {
                $('.modal-body #fullname').val(null);
                $('.modal-body #phone').val(null);
                $('.modal-body #email').val(null);
                }).always(
                function() {
                    $("div[id=form-application-second-part]").show();
                });

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


        // search-by-representative-ic
        $('#search-by-representative-ic').click(function() {
            var representativeIc = $('.modal-body #representative-ic').val();
            $.get("/participant/search-by-representative-ic/" + representativeIc, function(data) {
                $('.modal-body #representative-fullname').val(data.name);
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

        // all applicants
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

        // all no payment yet
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

        $('#table-all-no-payment-yet').on('click', '.btn-delete[data-remote]', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Disqualify this applicant?',
                text: "This applicant will be disqualified!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, disqualify this applicant!',
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
                        $('#table-all-no-payment-yet').DataTable().draw(false);
                    });


                    // var delayInMilliseconds = 5000; //5 second

                    // setTimeout(function() {
                    //     //your code to be executed after 5 second
                    //     $('#studentWithoutKolej').DataTable().ajax.reload();
                    // }, delayInMilliseconds);

                }
            })
        });

        // all payment waiting for verification
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
                        $('#table-payment-wait-for-verification').DataTable().draw(false);
                    });


                    // var delayInMilliseconds = 5000; //5 second

                    // setTimeout(function() {
                    //     //your code to be executed after 5 second
                    //     $('#studentWithoutKolej').DataTable().ajax.reload();
                    // }, delayInMilliseconds);

                }
            })
        });

        // all ready for event
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

        // all disqualified
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

        // all expected attendances
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

        // all attended participant
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

        // all not attended participant
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

        // all participants post event
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

       // all completed participation process
       var tableCompletedParticipationProcess = $('#table-completed-participation-process').DataTable({
            columnDefs: [{
                targets: [2],
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

        // all not completed participation process
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
                url: "/event/" + event_id + "/events-participants/data-not-completed-participation-process",
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
    </script>
@endsection
