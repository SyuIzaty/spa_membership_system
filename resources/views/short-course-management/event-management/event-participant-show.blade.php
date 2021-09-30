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
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item active">
                                    <a data-toggle="tab" class="nav-link" href="#all-applicant" role="tab">All Application</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#pending-payments" role="tab">Pending
                                        Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#verify-payments" role="tab">Verify
                                        Payments</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#application-status"
                                        role="tab">Application
                                        Status</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#feedback-status" role="tab">Feedback
                                        Status</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane" id="applications" role="tabpanel" hidden>
                                        <div class="row">

                                            <div class="col-md-12 grid-margin">
                                                @if (Session::has('messageNewApplication'))
                                                    <div class="alert alert-success"
                                                        style="color: #3b6324; background-color: #d3fabc;width:100%;">
                                                        <i class="icon fal fa-check-circle"></i>
                                                        {{ Session::get('messageNewApplication') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Step 1 (Pre-Event) -
                                                                    </span> Make
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
                                                                    <span class="fw-300">Step 2 (Pre-Event) -
                                                                    </span>
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
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane active" id="all-applicant" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin">
                                            </div>
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span> List of Applicants
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
                                                                    @if (Session::has('successPaymentProofUpdate'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('successPaymentProofUpdate') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('failedPaymentProofUpdate'))
                                                                        <div class="alert alert-danger"
                                                                            style="color: #5b0303; background-color: #ff6c6cc9;">
                                                                            <i class="icon fal fa-times-circle"></i>
                                                                            {{ Session::get('failedPaymentProofUpdate') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('successNewApplication'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;width:100%;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('successNewApplication') }}
                                                                        </div>
                                                                    @endif

                                                                    @if (Session::has('failedNewApplication'))
                                                                        <div class="alert alert-danger"
                                                                            style="color: #5b0303; background-color: #ff6c6cc9;">
                                                                            <i class="icon fal fa-times-circle"></i>
                                                                            {{ Session::get('failedNewApplication') }}
                                                                        </div>
                                                                    @endif

                                                                    @if ($errors->any())
                                                                        <div class="alert alert-danger">
                                                                            <strong>Whoops!</strong> There were some
                                                                            problems with your
                                                                            input.<br><br>
                                                                            <ul>
                                                                                @foreach ($errors->all() as $error)
                                                                                    <li>{{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endif

                                                                    <form action="{{ url('/update-progress/bundle') }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <div class="table-responsive">
                                                                            <table id="table-all-applicant"
                                                                                name="table-update-progress-1-1"
                                                                                class="table table-bordered table-hover table-striped w-100">
                                                                                <thead>
                                                                                    <tr class="bg-primary-50 text-center">
                                                                                        <th style="width:30px">Id</th>
                                                                                        <th>Organisation</th>
                                                                                        <th>IC</th>
                                                                                        <th>Name</th>
                                                                                        <th>Phone</th>
                                                                                        <th>Email</th>
                                                                                        <th>Status</th>
                                                                                        <th {{$event->is_modular==1? '':"hidden"}}>Module</th>
                                                                                        <th>Date Apply</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                            style="content-align:right">
                                                                            <button href="javascript:;" id="new-application"
                                                                                class="btn btn-primary ml-auto mr-2 waves-effect waves-themed"
                                                                                {{ $event->total_seat_available <= 0 ? 'disabled' : null }}>
                                                                                <i class="ni ni-check"></i>
                                                                                New
                                                                                Application ({{$event->total_seat_available}} out of {{$event->max_participant}} Available Seat Left)</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                    style="content-align:right">
                                                                    <x-ShortCourseManagement.AddParticipant :event=$event edit={{true}}/>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pending-payments" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin">
                                            </div>
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span> List of Not Make
                                                                    Payment
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
                                                                    @if (Session::has('successPaymentProofUpdate'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('successPaymentProofUpdate') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('failedPaymentProofUpdate'))
                                                                        <div class="alert alert-danger"
                                                                            style="color: #5b0303; background-color: #ff6c6cc9;">
                                                                            <i class="icon fal fa-times-circle"></i>
                                                                            {{ Session::get('failedPaymentProofUpdate') }}
                                                                        </div>
                                                                    @endif
                                                                    @if (Session::has('successNewApplication'))
                                                                        <div class="alert alert-success"
                                                                            style="color: #3b6324; background-color: #d3fabc;width:100%;">
                                                                            <i class="icon fal fa-check-circle"></i>
                                                                            {{ Session::get('successNewApplication') }}
                                                                        </div>
                                                                    @endif

                                                                    @if (Session::has('failedNewApplication'))
                                                                        <div class="alert alert-danger"
                                                                            style="color: #5b0303; background-color: #ff6c6cc9;">
                                                                            <i class="icon fal fa-times-circle"></i>
                                                                            {{ Session::get('failedNewApplication') }}
                                                                        </div>
                                                                    @endif

                                                                    @if ($errors->any())
                                                                        <div class="alert alert-danger">
                                                                            <strong>Whoops!</strong> There were some
                                                                            problems with your
                                                                            input.<br><br>
                                                                            <ul>
                                                                                @foreach ($errors->all() as $error)
                                                                                    <li>{{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
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
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                    style="content-align:right">
                                                                </div>
                                                                </form>
                                                                <x-ShortCourseManagement.UpdatePaymentProof />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="verify-payments" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300"></span> Already Make
                                                                    Payment, Need
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
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-close" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
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
                                                                                                <label
                                                                                                    class="form-label"
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
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-close" data-toggle="tooltip"
                                                                        data-offset="0,10"
                                                                        data-original-title="Close"></button>
                                                                </div>
                                                            </div>
                                                            <div class="panel-container show">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="attendance-status" role="tabpanel" hidden>
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div id="panel-1" class="panel">
                                                            <div class="panel-hdr">
                                                                <h2>
                                                                    <span class="fw-300">Succeed Attendance -
                                                                    </span>
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
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-close" data-toggle="tooltip"
                                                                        data-offset="0,10"
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
                                                                    <span class="fw-300">Failed Attendance -
                                                                    </span> (Not
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
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-close" data-toggle="tooltip"
                                                                        data-offset="0,10"
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
                                                                    <button class="btn btn-panel"
                                                                        data-action="panel-close" data-toggle="tooltip"
                                                                        data-offset="0,10"
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
        var eventJson=@json($event);

        // Processes
        { // Pre-Event
            {
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

                            }
                        })
                    });
                }

                // all applicants

                {
                    if(eventJson.is_modular==0){
                        var tableAllApplicant = $('#table-all-applicant').DataTable({
                        columnDefs: [{
                            targets: [1],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-all-applicant",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
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
                            {
                                className: 'text-center',
                                data: 'currentStatus',
                                name: 'currentStatus'
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
                            [0, "desc"]
                        ],
                    });
                    }else{
                        var tableAllApplicant = $('#table-all-applicant').DataTable({
                        columnDefs: [{
                            targets: [1],
                            render: function(data, type, row) {
                                return !data ? 'N/A' : data;
                            }
                        }],
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "/event/" + event_id + "/events-participants/data-all-applicant",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        },
                        columns: [
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
                            {
                                className: 'text-center',
                                data: 'currentStatus',
                                name: 'currentStatus'
                            },
                            {
                                className: 'text-center',
                                data: 'selected_modules',
                                name: 'selected_modules',
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
                            [0, "desc"]
                        ],
                    });
                    }


                    $('#table-all-applicant thead tr .hasinput').each(function(i) {
                        $('input', this).on('keyup change', function() {
                            if (tableAllApplicant.column(i).search() !== this.value) {
                                tableAllApplicant
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });

                        $('select', this).on('keyup change', function() {
                            if (tableAllApplicant.column(i).search() !== this.value) {
                                tableAllApplicant
                                    .column(i)
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }

                // all no payment yet
                {

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
                            $('#carousel-view-proof').hide();

                            $.get("/event-participant/" + event_participant_id + "/payment_proof",
                                function(data) {
                                    // TODO: Insert result into couresol
                                    data.forEach(function(img, index) {
                                        var src = img.name;
                                        var id = img.id;
                                        $('#carousel-indicators-view-proof').append(
                                            `<li data-target="#multi-item-example" data-slide-to="${index}" ${index==0?"class='active'":null}></li>`
                                        );

                                        $('#carousel-slides-view-proof').append(
                                            `<div class="carousel-item ${index==0?"active":null}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card mb-5">
                                                            <img class="card-img-top"
                                                                src="/get-payment-proof-image/${id}/${src}"
                                                                alt="Card image cap">
                                                            <div
                                                                class="card-body d-flex justify-content-between">
                                                                <h4 class="card-title">${img.created_at_diffForHumans}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`
                                        );
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
                        columns: [{
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
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
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
                        columns: [{
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
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
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
                        columns: [{
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
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            },
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
                        columns: [{
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
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            }
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
                        }, {
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
                        columns: [{
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
                        columns: [{
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
                            {
                                className: 'text-center',
                                data: 'created_at_diffForHumans',
                                name: 'created_at_diffForHumans',
                            }
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
                        case 'delete-application':
                            title = 'Delete this application?';
                            text = "This application will be deleted and can't be retrieved forever!";
                            confirmButtonText = 'Yes, delete this application!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-all-applicant';
                            nextTableId = '#table-all-no-payment-yet';
                            break;
                        case 'restore-application':
                            title = 'Restore this application?';
                            text = "This application will be restored!";
                            confirmButtonText = 'Yes, restore this application!';
                            cancelButtonText = 'No';
                            currentTableId = '#table-all-applicant';
                            nextTableId = '#table-all-no-payment-yet';
                            break;
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
                            nextTableId = '#table-all-applicant';
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
                            var delayInMilliseconds = 3000; //3 second

                            setTimeout(function() {
                                //your code to be executed after 3 second
                                $(nextTableId).DataTable().ajax.reload();
                            }, delayInMilliseconds);

                        }
                    })
                });
            }
        }
    </script>
@endsection
