@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr bg-primary">
                        <h2 class="text-white">
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
                            <div class="row">
                                <div class="col-md-12">
                                    <hr class="mt-2 mb-3">
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            {{-- <form action="{{ url('/events/update/' . $event->id) }}" method="post"
                                                    name="form"> --}}
                                            @csrf
                                            <center><img src="http://iids.test/img/intec_logo.png"
                                                    style="height: 120px; width: 270px;"></center>
                                            <br />
                                            <h4 style="text-align: center">
                                                <b>EVENT REGISTRATION INTEC EDUCATION COLLEGE</b>
                                            </h4>
                                            <br />
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead class="thead bg-primary-50">
                                                    <tr>
                                                        <th colspan="2"><b>Basic Information</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th style="background-color:plum">Name</th>
                                                        <td name="name_edit" id="name_edit">
                                                            <div class="form-group">
                                                                <input id="name" name="name" type="text" value=""
                                                                    class="form-control font-weight-bold">
                                                                @error('name')
                                                                    <p style="color: red">
                                                                        <strong> *
                                                                            {{ $message }}
                                                                        </strong>
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:plum">Date Start</th>
                                                        {{-- <input class="form-control" type="datetime-local" value="2023-07-23T11:25:00" id="example-datetime-local-input"> --}}
                                                        <td name="datetime_start_edit" id="datetime_start_edit">
                                                            <div class="form-group">
                                                                <input id="datetime_start" name="datetime_start"
                                                                    type="datetime-local" value=""
                                                                    class="form-control font-weight-bold">
                                                                @error('datetime_start')>
                                                                    <p style="color: red">
                                                                        <strong> *
                                                                            {{ $message }}
                                                                        </strong>
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:plum">Date End</th>
                                                        <td name="datetime_end_edit" id="datetime_end_edit">
                                                            <div class="form-group">
                                                                <input id="datetime_end" name="datetime_end"
                                                                    type="datetime-local" value=""
                                                                    class="form-control font-weight-bold">
                                                                @error('datetime_end')>
                                                                    <p style="color: red">
                                                                        <strong> *
                                                                            {{ $message }}
                                                                        </strong>
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:plum">Venue</th>
                                                        <td name="venue_edit" id="venue_edit">
                                                            {{-- <div class="form-group">
                                                                        <input id="venue.name" name="venue.name"
                                                                            value="{{$event->venue->name}}"
                                                                            class="form-control font-weight-bold">
                                                                        @error('venue.name')>
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div> --}}
                                                            <div class="form-group">
                                                                <select class="form-control venue  font-weight-bold"
                                                                    name="venue" id="venue" data-select2-id="venue"
                                                                    tabindex="-1" aria-hidden="true">
                                                                    <option value="0" data-select2-id="0">
                                                                        Choose a venue
                                                                    </option>
                                                                    @foreach ($venues as $venue)
                                                                        <option value="{{ $venue->id }}"
                                                                            data-select2-id="{{ $venue->id }}">
                                                                            {{ $venue->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <tbody>
                                            </table>
                                            </form>

                                            <table class="table table-striped table-bordered m-0">
                                                <thead class="thead">
                                                    <tr class=" bg-primary-50" scope="row">
                                                        <th colspan="5"><b>List of Fees</b></th>
                                                    </tr>
                                                    <tr style="background-color:plum" scope="row">
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Fee Type</th>
                                                        <th scope="col">Promo Code</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @foreach ($event->fees as $fee)
                                                            <tr scope="row">
                                                                <td>
                                                                    <b>{{ $fee->name }}</b>
                                                                </td>
                                                                <td><b>{{ $fee->amount }}</b></td>
                                                                <td><b>{{ $fee->is_base_fee }}</b></td>
                                                                <td><b>{{ $fee->promo_code }}</b></td>
                                                                <td>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-danger float-right mr-2">
                                                                        <i class="ni ni-trash"></i>
                                                                    </a><a href="#"
                                                                        class="btn btn-sm btn-info float-right mr-2"
                                                                        name="edit-fee" id="edit-fee"
                                                                        data-target="#edit-fee-modal" data-toggle="modal"
                                                                        data-id={{ $fee->id }}
                                                                        data-name='{{ $fee->name }}'
                                                                        data-amount={{ $fee->amount }}
                                                                        data-is_base_fee={{ $fee->is_base_fee }}
                                                                        data-promo_code='{{ $fee->promo_code }}'>
                                                                        <i class="fal fa-pencil"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach --}}
                                                </tbody>
                                            </table>
                                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                style="content-align:right">
                                                <a href="javascript:;" data-toggle="modal" id="new-fee"
                                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                                        class="ni ni-plus"> </i> Create New Fee</a>
                                                <div class="modal fade" id="crud-modal-new-fee" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="card-header">
                                                                <h5 class="card-title w-150">Add New
                                                                    Fee</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{-- {!! Form::open(['action' => 'EventParticipantController@store', 'method' => 'POST']) !!} --}}
                                                                <input type="hidden" name="id" id="id">
                                                                <p><span class="text-danger">*</span>
                                                                    Vital Information</p>
                                                                <hr class="mt-1 mb-2">
                                                                <div id="form-fee">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="name"><span
                                                                                class="text-danger">*</span>name</label>
                                                                        <input class="form-control" id="name-fee-add"
                                                                            name="name">
                                                                        @error('name')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="amount"><span
                                                                                class="text-danger">*</span>amount</label>
                                                                        <input type="number" step=".01" class="form-control"
                                                                            id="amount" name="amount">
                                                                        @error('amount')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                            for="is_base_fee_select_add"><span
                                                                                class="text-danger">*</span>Fee
                                                                            Type</label>
                                                                        {{-- <input class="form-control" id="is_base_fee_select_add"
                                                                                name="is_base_fee_select_add"> --}}
                                                                        <select
                                                                            class="form-control is_base_fee_select_add font-weight-bold"
                                                                            name="is_base_fee_select_add"
                                                                            id="is_base_fee_select_add"
                                                                            data-select2-id="is_base_fee_select_add"
                                                                            tabindex="-1" aria-hidden="true">
                                                                            <option value=1>Basic Fee</option>
                                                                            <option value=0>Non-Basic Fee</option>
                                                                        </select>
                                                                        @error('is_base_fee_select_add')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group" id="form_group-promo_code_add"
                                                                        name="form_group-promo_code_add"
                                                                        style="display: none">
                                                                        <label class="form-label" for="promo_code"><span
                                                                                class="text-danger">*</span>Promo
                                                                            Code</label>
                                                                        <input class="form-control" id="promo_code_add"
                                                                            name="promo_code_add">
                                                                        @error('promo_code')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="footer">
                                                                    <button type="button"
                                                                        class="btn btn-success ml-auto float-right mr-2"
                                                                        data-dismiss="modal" id="close-new-fee"><i
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
                                            <div class="modal fade" id="edit-fee-modal" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="card-header">
                                                            <h5 class="card-title w-150">Edit Current
                                                                Fee</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- {!! Form::open(['action' => 'EventParticipantController@store', 'method' => 'POST']) !!} --}}
                                                            <input type="hidden" name="id" id="id">
                                                            <p><span class="text-danger">*</span>
                                                                Vital Information</p>
                                                            <hr class="mt-1 mb-2">
                                                            <div id="form-fee">
                                                                <input type="hidden" name="id" id="id">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="name"><span
                                                                            class="text-danger">*</span>name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="name_fee_edit" name="name_fee_edit">
                                                                    {{-- <div class="form-group">
                                                                            <input id="name" name="name" type="text"
                                                                                value="{{ $event->name }}"
                                                                                class="form-control font-weight-bold">
                                                                            @error('name')
                                                                                <p style="color: red">
                                                                                    <strong> *
                                                                                        {{ $message }}
                                                                                    </strong>
                                                                                </p>
                                                                            @enderror
                                                                        </div> --}}
                                                                    @error('name')
                                                                        <p style="color: red">
                                                                            <strong> *
                                                                                {{ $message }}
                                                                            </strong>
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="amount"><span
                                                                            class="text-danger">*</span>amount</label>
                                                                    <input type="number" step=".01" class="form-control"
                                                                        id="amount" name="amount">
                                                                    @error('amount')
                                                                        <p style="color: red">
                                                                            <strong> *
                                                                                {{ $message }}
                                                                            </strong>
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="is_base_fee_select_edit"><span
                                                                            class="text-danger">*</span>Fee
                                                                        Type</label>
                                                                    <select
                                                                        class="form-control is_base_fee_select_edit font-weight-bold"
                                                                        name="is_base_fee_select_edit"
                                                                        id="is_base_fee_select_edit"
                                                                        data-select2-id="is_base_fee_select_edit"
                                                                        tabindex="-1" aria-hidden="true">
                                                                        <option value=1>Basic Fee</option>
                                                                        <option value=0>Non-Basic Fee</option>
                                                                    </select>
                                                                    @error('is_base_fee_select_edit')
                                                                        <p style="color: red">
                                                                            <strong> *
                                                                                {{ $message }}
                                                                            </strong>
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group" id="form_group-promo_code-edit"
                                                                    name="form_group-promo_code-edit" style="display: none">
                                                                    <label class="form-label" for="promo_code"><span
                                                                            class="text-danger">*</span>promo_code</label>
                                                                    <input class="form-control" id="promo_code-edit"
                                                                        name="promo_code">
                                                                    @error('promo_code')
                                                                        <p style="color: red">
                                                                            <strong> *
                                                                                {{ $message }}
                                                                            </strong>
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <hr class="mt-1 mb-2">
                                                            <div class="footer">
                                                                <button type="button"
                                                                    class="btn btn-success ml-auto float-right mr-2"
                                                                    data-dismiss="modal" id="close-new-fee"><i
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
                                            <hr class="mt-2 mb-3">
                                            <table class="table table-striped table-bordered m-0">
                                                <thead class="thead">
                                                    <tr class=" bg-primary-50">
                                                        <th colspan="3"><b>List of Trainers</b></th>
                                                    </tr>
                                                    <tr style="background-color:plum">
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @foreach ($trainers as $trainer)
                                                        <tr>
                                                            <td><b>{{ $trainer->id }}</b></td>
                                                            <td><b>{{ $trainer->name }}</b></td>
                                                            <td><a href="#" class="btn btn-sm btn-danger float-right mr-2">
                                                                    <i class="ni ni-close"></i>
                                                                </a></td>
                                                        </tr>
                                                    @endforeach --}}
                                                </tbody>
                                            </table>
                                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                style="content-align:right">
                                                <a href="javascript:;" data-toggle="modal" id="add-trainer"
                                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                                        class="ni ni-plus"> </i> Add Trainer</a>
                                                <div class="modal fade" id="crud-modal-add-trainer" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="card-header">
                                                                <h5 class="card-title w-150">Add Trainer</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{-- {!! Form::open(['action' => 'EventParticipantController@store', 'method' => 'POST']) !!} --}}
                                                                <input type="hidden" name="id" id="id">
                                                                <p><span class="text-danger">*</span>
                                                                    Vital Information</p>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label for="user_id"><span class="text-danger">*</span>
                                                                        Trainer's User ID</label>
                                                                    <div class="form-inline" style="width:100%">
                                                                        <div class="form-group mr-2 mb-2" style="width:85%">
                                                                            <input class="form-control w-100" id="user_id"
                                                                                name="user_id">
                                                                        </div>
                                                                        <a href="javascript:;" data-toggle="#"
                                                                            id="search-by-user_id"
                                                                            class="btn btn-primary mb-2"><i
                                                                                class="ni ni-magnifier"></i></a>
                                                                    </div>
                                                                    @error('user_id')
                                                                        <p style="color: red">
                                                                            <strong> *
                                                                                {{ $message }}
                                                                            </strong>
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div id="form-add-trainer-second-part"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="fullname"><span
                                                                                class="text-danger">*</span>Fullname</label>
                                                                        <input class="form-control-plaintext" id="fullname"
                                                                            name="fullname" disabled>
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
                                                                        <label class="form-label" for="phone"><span
                                                                                class="text-danger">*</span>Phone</label>
                                                                        <input class="form-control-plaintext" id="phone"
                                                                            name="phone" disabled>
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
                                                                        <label class="form-label" for="email"><span
                                                                                class="text-danger">*</span>Email</label>
                                                                        <input class="form-control-plaintext" id="email"
                                                                            name="email" disabled>
                                                                        @error('email')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="footer">
                                                                    <button type="button"
                                                                        class="btn btn-success ml-auto float-right mr-2"
                                                                        data-dismiss="modal" id="close-add-trainer"><i
                                                                            class="fal fa-window-close"></i>
                                                                        Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary ml-auto float-right mr-2"><i
                                                                            class="ni ni-plus"></i>
                                                                        Add</button>
                                                                </div>

                                                                {{-- {!! Form::close() !!} --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr class="mt-2 mb-3">
                                            <table class="table table-striped table-bordered m-0">
                                                <thead class="thead">
                                                    <tr class=" bg-primary-50">
                                                        <th colspan="3"><b>List of Short Courses</b></th>
                                                    </tr>
                                                    <tr style="background-color:plum">
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @foreach ($event->events_shortcourses as $events_shortcourses)
                                                            <tr>
                                                                <td><b>{{ $events_shortcourses->shortcourse->id }}</b>
                                                                </td>
                                                                <td><b>{{ $events_shortcourses->shortcourse->name }}</b>
                                                                </td>
                                                                <td><a href="#"
                                                                        class="btn btn-sm btn-danger float-right mr-2">
                                                                        <i class="ni ni-close"></i>
                                                                    </a></td>
                                                            </tr>
                                                        @endforeach --}}
                                                </tbody>
                                            </table>

                                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                style="content-align:right">
                                                <a href="javascript:;" data-toggle="modal" id="add-shortcourse"
                                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                                        class="ni ni-plus"> </i> Add Short Course</a>

                                                <div class="modal fade" id="crud-modal-add-shortcourse" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="card-header">
                                                                <h5 class="card-title w-150">Add Short Course</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" id="id">
                                                                <p><span class="text-danger">*</span>
                                                                    Vital Information</p>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label for="user_id"><span class="text-danger">*</span>
                                                                        Short Course Name</label>
                                                                    <div class="form-inline" style="width:100%">
                                                                        <div class="form-group mr-2 mb-2" style="width:85%">
                                                                            <div class="form-group">
                                                                                <select
                                                                                    class="form-control shortcourse font-weight-bold"
                                                                                    name="shortcourse_name"
                                                                                    id="shortcourse_name"
                                                                                    data-select2-id="shortcourse_name"
                                                                                    tabindex="-1" aria-hidden="true">
                                                                                    <option value=''>Choose a Short
                                                                                        Course
                                                                                    </option>
                                                                                    @foreach ($shortcourses as $shortcourse)
                                                                                        <option
                                                                                            value="{{ $shortcourse->id }}"
                                                                                            data-select2-id="{{ $shortcourse->id }}">
                                                                                            {{ $shortcourse->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @error('shortcourse_name')
                                                                        <p style="color: red">
                                                                            <strong> *
                                                                                {{ $message }}
                                                                            </strong>
                                                                        </p>
                                                                    @enderror
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div id="form-add-shortcourse-second-part"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="objective"><span
                                                                                class="text-danger">*</span>Objective</label>
                                                                        <textarea class="form-control-plaintext" rows="5"
                                                                            id="objective" name="objective" disabled>
                                                                                                                                </textarea>
                                                                        @error('objective')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="form-label" for="description"><span
                                                                                class="text-danger">*</span>Description</label>
                                                                        <textarea class="form-control-plaintext" rows="5"
                                                                            id="description" name="description" disabled>
                                                                                                                                    </textarea>
                                                                        @error('description')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <hr class="mt-1 mb-2">
                                                                <div class="footer">
                                                                    <button type="button"
                                                                        class="btn btn-success ml-auto float-right mr-2"
                                                                        data-dismiss="modal" id="close-add-trainer"><i
                                                                            class="fal fa-window-close"></i>
                                                                        Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary ml-auto float-right mr-2"><i
                                                                            class="ni ni-plus"></i>
                                                                        Add</button>
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

                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                style="content-align:right">
                                <button type="submit"
                                    class="btn btn-danger ml-auto mr-2 waves-effect waves-themed font-weight-bold"><i
                                        class="ni ni-check"></i> Register</button>
                            </div>

                            <hr class="mt-2 mb-3">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        // Editor
        {

            // List of fees
            {
                // new fee
                {
                    $('#new-fee').click(function() {
                        var id = null;
                        var name = null;
                        var amount = null;
                        var is_base_fee = 0;
                        var promo_code = null;

                        $('.modal-body #id').val(id);
                        $('.modal-body #name-fee-add').val(name);
                        $('.modal-body #amount').val(amount);
                        $('.modal-body #is_base_fee').val(is_base_fee);
                        $('.modal-body #promo_code_add').val(promo_code);
                        $('#crud-modal-new-fee').modal('show');
                    });

                    $('#crud-modal-new-fee').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget)
                        // var id = button.data('id');
                        // var name = button.data('name');
                        // var amount = button.data('amount');
                        // var is_base_fee = button.data('is_base_fee');
                        // var promo_code = button.data('promo_code');

                        // $('.modal-body #id').val(id);
                        // $('.modal-body #name').val(name);
                        // $('.modal-body #amount').val(amount);
                        // $('.modal-body #is_base_fee').val(is_base_fee);
                        // $('.modal-body #promo_code').val(promo_code);
                    });
                }


                // edit fee
                $('#edit-fee-modal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id');
                    var name = button.data('name');
                    var amount = button.data('amount');
                    var is_base_fee = button.data('is_base_fee');
                    var promo_code = button.data('promo_code');

                    var selected = $("select[name=is_base_fee_select_edit]").val(is_base_fee);
                    selected.prop('selected', true);

                    if (is_base_fee === 0) {
                        $("#form_group-promo_code-edit").show();

                    } else {
                        $("#form_group-promo_code-edit").hide();
                    }

                    $('.modal-body #id').val(id);
                    $('.modal-body #name_fee_edit').val(name);
                    $('.modal-body #amount').val(amount);
                    $('.modal-body #is_base_fee').val(is_base_fee);
                    $('.modal-body #promo_code-edit').val(promo_code);
                });

                // fee type modification
                $(function() {
                    $("select[name=is_base_fee_select_add]").change(function(event) {
                        var is_base_fee = $("#is_base_fee_select_add option:selected").val();
                        if (is_base_fee == 0) {
                            $("div[name=form_group-promo_code_add]").show();
                        } else {
                            $("div[name=form_group-promo_code_add]").hide();
                            // $('.modal-body #hasKolejNew').val(false);
                        }
                    });

                    $("select[name=is_base_fee_select_edit]").change(function(event) {
                        var is_base_fee = $("#is_base_fee_select_edit option:selected").val();
                        console.log(is_base_fee);
                        if (is_base_fee == 0) {
                            $("div[name=form_group-promo_code-edit]").show();

                        } else {
                            $("div[name=form_group-promo_code-edit]").hide();
                            $('.modal-body #promo_code').val(null);
                        }
                    });
                })

            }

            // List of Trainers
            {
                // Add trainer
                // crud-modal-add-trainer
                $('#add-trainer').click(function() {
                    var id = null;
                    var user_id = null;
                    $('.modal-body #id').val(id);
                    $('.modal-body #user_id').val(user_id);
                    $('.modal-body #fullname').val(null);
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('#crud-modal-add-trainer').modal('show');
                    $("div[id=form-add-trainer-second-part]").hide();
                });

                $('#crud-modal-add-trainer').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id');
                    var user_id = button.data('user_id');

                    $('.modal-body #id').val(id);
                    $('.modal-body #user_id').val(user_id);
                });

                // search by trainer user_id
                $('#search-by-user_id').click(function() {
                    var user_id = $('.modal-body #user_id').val();
                    $.get("/trainer/search-by-user_id/" + user_id, function(data) {
                        $('.modal-body #fullname').val(data.name);
                        $('.modal-body #phone').val(data.trainer.phone);
                        $('.modal-body #email').val(data.email);

                    }).fail(
                        function() {
                            $('.modal-body #fullname').val(null);
                            $('.modal-body #phone').val(null);
                            $('.modal-body #email').val(null);
                        }).always(
                        function() {
                            $("div[id=form-add-trainer-second-part]").show();
                        });

                });
            }

            $(document).ready(function() {
                // $('.venue, .is_base_fee_select_add, .is_base_fee_select_edit').select2();

                $('.venue').select2();
            });

        }


        // List of Shortcourses
        {
            // Add shortcourse
            // crud-modal-add-shortcourse
            $('#add-shortcourse').click(function() {
                var id = null;
                var shortcourse_name = null;
                $('.modal-body #id').val(id);
                $('.modal-body #shortcourse_name').val(shortcourse_name);
                $('.modal-body #objective').val(null);
                $('.modal-body #description').val(null);
                $("div[id=form-add-shortcourse-second-part]").hide();
                $('#crud-modal-add-shortcourse').modal('show');
            });

            $('#crud-modal-add-shortcourse').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id');
                var shortcourse_name = button.data('shortcourse_name');

                $('.modal-body #id').val(id);
                $('.modal-body #shortcourse_name').val(shortcourse_name);
            });

            // search by id
            $('#shortcourse_name').change(function() {
                var id = $('.modal-body #shortcourse_name').val();
                $.get("/shortcourse/search-by-id/" + id, function(data) {
                    $('.modal-body #objective').val(data.objective);
                    $('.modal-body #description').val(data.description);

                }).fail(
                    function() {
                        $('.modal-body #objective').val(null);
                        $('.modal-body #description').val(null);
                    }).always(
                    function() {
                        $("div[id=form-add-shortcourse-second-part]").show();
                    });

            });
        }
    </script>
@endsection
