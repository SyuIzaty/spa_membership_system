@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        {{-- <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i>
                ({{ $event->id }}) {{ $event->name }}
            </h1>
        </div> --}}
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
                                <li class="nav-item active">
                                    <a data-toggle="tab" class="nav-link" href="#general" role="tab">General</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#specific" role="tab">Specific</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#setting" role="tab">Setting</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane active" id="general" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <form action="{{ url('/events/update/' . $event->id) }}" method="post"
                                                    name="form">
                                                    @csrf
                                                    <table class="table table-bordered table-hover table-striped">
                                                        <thead class="thead bg-primary-50">
                                                            <tr class=" bg-primary-50" scope="row">
                                                                <th colspan="2">
                                                                    <b>Basic Information</b>
                                                                    <a href="#" class="btn btn-sm btn-info float-right mr-2"
                                                                        name="edit-basic" id="edit-basic">
                                                                        <i class="fal fa-pencil"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger float-right mr-2"
                                                                        name="edit-basic-close" id="edit-basic-close"
                                                                        style="display: none">
                                                                        <i class="fal fa-window-close"></i>
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-success float-right mr-2"
                                                                        name="save-basic" id="save-basic"
                                                                        style="display: none">
                                                                        <i class="fal fa-save"></i>
                                                                    </button>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:plum">Name</td>
                                                                <td name="name_show" id="name_show">
                                                                    {{ $event->name }}
                                                                </td>
                                                                <td name="name_edit" id="name_edit" style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="name" name="name" type="text"
                                                                            value="{{ $event->name }}"
                                                                            class="form-control">
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
                                                                <td style="background-color:plum">Date Start</td>
                                                                <td name="datetime_start_show" id="datetime_start_show">
                                                                    {{ date('d/m/Y h:i A', strtotime($event->datetime_start)) }}
                                                                </td>
                                                                {{-- <input class="form-control" type="datetime-local" value="2023-07-23T11:25:00" id="example-datetime-local-input"> --}}
                                                                <td name="datetime_start_edit" id="datetime_start_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="datetime_start" name="datetime_start"
                                                                            type="datetime-local"
                                                                            value="{{ substr(date('c', strtotime($event->datetime_start)), 0, -6) }}"
                                                                            class="form-control">
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
                                                                <td style="background-color:plum">Date End</td>
                                                                <td name="datetime_end_show" id="datetime_end_show">
                                                                    {{ date('d/m/Y h:i A', strtotime($event->datetime_end)) }}
                                                                </td>
                                                                <td name="datetime_end_edit" id="datetime_end_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="datetime_end" name="datetime_end"
                                                                            type="datetime-local"
                                                                            value="{{ substr(date('c', strtotime($event->datetime_end)), 0, -6) }}"
                                                                            class="form-control">
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
                                                                <td style="background-color:plum">Venue</td>
                                                                <td name="venue_show" id="venue_show">
                                                                    {{ $event->venue->name }}
                                                                </td>
                                                                <td name="venue_edit" id="venue_edit" style="display: none">
                                                                    {{-- <div class="form-group">
                                                                        <input id="venue.name" name="venue.name"
                                                                            value="{{$event->venue->name}}"
                                                                            class="form-control">
                                                                        @error('venue.name')>
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div> --}}
                                                                    <div class="form-group">
                                                                        <select class="form-control venue " name="venue"
                                                                            id="venue" data-select2-id="venue" tabindex="-1"
                                                                            aria-hidden="true">
                                                                            <option
                                                                                value={{ $event->venue ? $event->venue->id : '' }}>
                                                                                {{ $event->venue ? $event->venue->name : 'Choose a venue' }}
                                                                            </option>
                                                                            @foreach ($venues as $venue)
                                                                                @if ($event->venue ? $venue->id != $event->venue->id : false)
                                                                                    <option value="{{ $venue->id }}">
                                                                                        {{ $venue->name }}
                                                                                    </option>
                                                                                @endif
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
                                                        @foreach ($event->fees as $fee)
                                                            <tr scope="row">
                                                                <td>
                                                                    {{ $fee->name }}
                                                                </td>
                                                                <td>{{ $fee->amount }}</td>
                                                                <td>{{ $fee->is_base_fee }}</td>
                                                                <td>{{ $fee->promo_code ? $fee->promo_code : 'N\A' }}
                                                                </td>
                                                                <td>
                                                                    <form method="post"
                                                                        action="/event/fee/delete/{{ $fee->id }}"
                                                                        @php
                                                                            if ($fee->is_base_fee === 1) {
                                                                                echo 'disabled hidden';
                                                                            }
                                                                        @endphp>
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger float-right mr-2">
                                                                            <i class="ni ni-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                    <a href="#" class="btn btn-sm btn-info float-right mr-2"
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
                                                        @endforeach
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
                                                                    {{-- {!! Form::open(['action' => 'ShortCourseManagement\EventManagement\EventController@storeFee', 'method' => 'POST']) !!} --}}
                                                                    <form
                                                                        action="{{ url('/event/fee/create/' . $event->id) }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <p><span class="text-danger">*</span>
                                                                            Vital Information</p>
                                                                        <hr class="mt-1 mb-2">
                                                                        <div id="form-fee">
                                                                            <div class="form-group">
                                                                                <label class="form-label" for="name"><span
                                                                                        class="text-danger">*</span>name</label>
                                                                                <input class="form-control"
                                                                                    id="name-fee-add" name="name">
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
                                                                                <input type="number" step=".01"
                                                                                    class="form-control" id="amount_add"
                                                                                    name="amount_add">
                                                                                @error('amount_add')
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
                                                                                <input type="hidden"
                                                                                    name="is_base_fee_select_add_input"
                                                                                    id="is_base_fee_select_add_input"
                                                                                    value=0>
                                                                                <select
                                                                                    class="form-control is_base_fee_select_add"
                                                                                    name="is_base_fee_select_add"
                                                                                    id="is_base_fee_select_add"
                                                                                    tabindex="-1" aria-hidden="true"
                                                                                    disabled>
                                                                                    <option value=1>Normal Price</option>
                                                                                    <option value=0 selected>Discounted
                                                                                        Price
                                                                                    </option>
                                                                                </select>
                                                                                @error('is_base_fee_select_add')
                                                                                    <p style="color: red">
                                                                                        <strong> *
                                                                                            {{ $message }}
                                                                                        </strong>
                                                                                    </p>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group"
                                                                                id="form_group-promo_code_add"
                                                                                name="form_group-promo_code_add">
                                                                                <label class="form-label"
                                                                                    for="promo_code"><span
                                                                                        class="text-danger">*</span>Promo
                                                                                    Code</label>
                                                                                <input class="form-control"
                                                                                    id="promo_code_add"
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
                                                                                class="btn btn-danger ml-auto float-right mr-2"
                                                                                data-dismiss="modal" id="close-new-fee"><i
                                                                                    class="fal fa-window-close"></i>
                                                                                Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary ml-auto float-right mr-2"><i
                                                                                    class="ni ni-plus"></i>
                                                                                Apply</button>
                                                                        </div>
                                                                    </form>
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
                                                                <form
                                                                    action="{{ url('/events/fee/update/' . $event->id) }}"
                                                                    method="post" name="form">
                                                                    @csrf
                                                                    {{-- {!! Form::open(['action' => 'EventParticipantController@store', 'method' => 'POST']) !!} --}}

                                                                    <p><span class="text-danger">*</span>
                                                                        Vital Information</p>
                                                                    <hr class="mt-1 mb-2">
                                                                    <div id="form-fee">

                                                                        <input type="number" name="fee_id" id="fee_id"
                                                                            style="display:none">
                                                                        <div class="form-group">
                                                                            <label class="form-label" for="name"><span
                                                                                    class="text-danger">*</span>name</label>
                                                                            <input type="text" class="form-control"
                                                                                id="name_fee_edit" name="name_fee_edit">
                                                                            {{-- <div class="form-group">
                                                                            <input id="name" name="name" type="text"
                                                                                value="{{ $event->name }}"
                                                                                class="form-control">
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
                                                                            <input type="number" step=".01"
                                                                                class="form-control" id="amount_edit"
                                                                                name="amount_edit">
                                                                            @error('amount_edit')
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
                                                                            <input type="number"
                                                                                name="is_base_fee_select_edit_input"
                                                                                id="is_base_fee_select_edit_input"
                                                                                style="display:none">

                                                                            <select
                                                                                class="form-control is_base_fee_select_edit"
                                                                                name="is_base_fee_select_edit"
                                                                                id="is_base_fee_select_edit"
                                                                                data-select2-id="is_base_fee_select_edit"
                                                                                tabindex="-1" aria-hidden="true"
                                                                                disabled="true">
                                                                                <option value=1>Normal Price</option>
                                                                                <option value=0>Discounted Price</option>
                                                                            </select>
                                                                            @error('is_base_fee_select_edit')
                                                                                <p style="color: red">
                                                                                    <strong> *
                                                                                        {{ $message }}
                                                                                    </strong>
                                                                                </p>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group"
                                                                            id="form_group-promo_code-edit"
                                                                            name="form_group-promo_code-edit"
                                                                            style="display: none">
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
                                                                            class="btn btn-danger ml-auto float-right mr-2"
                                                                            data-dismiss="modal" id="close-edit-fee"><i
                                                                                class="fal fa-window-close"></i>
                                                                            Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary ml-auto float-right mr-2"><i
                                                                                class="ni ni-plus"></i>
                                                                            Apply</button>
                                                                    </div>

                                                                    {{-- {!! Form::close() !!} --}}
                                                                </form>
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
                                                                <td>
                                                                    <a href="#"
                                                                        class="btn btn-sm btn-danger float-right mr-2">
                                                                        <i class="ni ni-close"></i>
                                                                    </a>
                                                                    <form method="post"
                                                                    action="/event/trainer/detached/{{ $fee->id }}">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger float-right mr-2">
                                                                        <i class="ni ni-close"></i>
                                                                    </button>
                                                                </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach --}}

                                                        @foreach ($event->events_trainers as $event_trainer)
                                                            <tr>
                                                                <td>{{ $event_trainer->trainer->user->id }}</td>
                                                                <td>{{ $event_trainer->trainer->user->name }}</td>
                                                                <td>
                                                                    <form method="post"
                                                                        action="/event/trainer/detached/{{ $event_trainer->id }}">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger float-right mr-2">
                                                                            <i class="ni ni-close"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
                                                                    <form
                                                                        action="{{ url('/event/trainer/attached/' . $event->id) }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        {{-- {!! Form::open(['action' => 'ShortCourseManagement\EventManagement\EventController@storeTrainer\ '.$event->id, 'method' => 'POST']) !!} --}}
                                                                        <input type="hidden" name="id_4" id="id_4">
                                                                        <p><span class="text-danger">*</span>
                                                                            Vital Information</p>
                                                                        <hr class="mt-1 mb-2">
                                                                        <div class="form-group">
                                                                            <label for="trainer_ic"><span
                                                                                    class="text-danger">*</span>
                                                                                Trainer's IC</label>
                                                                            <div class="form-inline" style="width:100%">
                                                                                <div class="form-group mr-2 mb-2"
                                                                                    style="width:85%"
                                                                                    id="search-by-trainer_ic-div">
                                                                                    <input class="form-control w-100"
                                                                                        id="trainer_ic_input"
                                                                                        name="trainer_ic_input">
                                                                                </div>
                                                                                <a href="javascript:;" data-toggle="#"
                                                                                    id="search-by-trainer_ic"
                                                                                    class="btn btn-primary mb-2"
                                                                                    style="width:10%"><i
                                                                                        class="ni ni-magnifier"></i></a>
                                                                            </div>
                                                                            @error('trainer_ic_input')
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

                                                                            {{-- <div class="form-group">
                                                                                <label for="user_id"><span
                                                                                        class="text-danger">*</span>
                                                                                    Trainer's User ID</label>
                                                                                <div class="form-inline" style="width:100%">
                                                                                    <div class="form-group mr-2 mb-2"
                                                                                        style="width:85%">
                                                                                        <input class="form-control w-100"
                                                                                            id="user_id" name="user_id">
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
                                                                            </div> --}}
                                                                            <div class="form-group">
                                                                                <label for="user_id"><span
                                                                                        class="text-danger">*</span>
                                                                                    Trainer's User ID</label>
                                                                                {{ Form::text('trainer_user_id_text', '', ['class' => 'form-control', 'placeholder' => "Trainer's User ID", 'id' => 'trainer_user_id_text', 'disabled', 'style' => 'display:none', 'readonly']) }}
                                                                                <select class="form-control user"
                                                                                    name="trainer_user_id"
                                                                                    id="trainer_user_id" disabled
                                                                                    style="display:none">
                                                                                    <option disabled>Select User ID</option>
                                                                                    <option value='-1' name="create_new">
                                                                                        Create
                                                                                        New</option>
                                                                                    @foreach ($users as $user)
                                                                                        <option value='{{ $user->id }}'
                                                                                            name="{{ $user->name }}">
                                                                                            {{ $user->id }} -
                                                                                            {{ $user->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('trainer_user_id')
                                                                                    <p style="color: red">{{ $message }}
                                                                                    </p>
                                                                                @enderror
                                                                            </div>
                                                                            <hr class="mt-1 mb-2">

                                                                            <input class="form-control-plaintext"
                                                                                id="trainer_id" name="trainer_id" hidden>
                                                                            <div class="form-group">
                                                                                <label class="form-label"
                                                                                    for="trainer_fullname"><span
                                                                                        class="text-danger">*</span>Fullname</label>
                                                                                <input class="form-control"
                                                                                    id="trainer_fullname"
                                                                                    name="trainer_fullname">
                                                                                @error('trainer_fullname')
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
                                                                                    for="trainer_phone"><span
                                                                                        class="text-danger">*</span>Phone</label>
                                                                                <input class="form-control"
                                                                                    id="trainer_phone" name="trainer_phone">
                                                                                @error('trainer_phone')
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
                                                                                    for="trainer_email"><span
                                                                                        class="text-danger">*</span>Email</label>
                                                                                <input class="form-control"
                                                                                    id="trainer_email" name="trainer_email">
                                                                                @error('trainer_email')
                                                                                    <p style="color: red">
                                                                                        <strong> *
                                                                                            {{ $message }}
                                                                                        </strong>
                                                                                    </p>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <hr class="mt-1 mb-2">
                                                                        <div class="footer" id="add_trainer_footer"
                                                                            style="display:none">
                                                                            <button type="button"
                                                                                class="btn btn-danger ml-auto float-right mr-2"
                                                                                data-dismiss="modal"
                                                                                id="close-add-trainer"><i
                                                                                    class="fal fa-window-close"></i>
                                                                                Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary ml-auto float-right mr-2"><i
                                                                                    class="ni ni-plus"></i>
                                                                                Add</button>
                                                                        </div>

                                                                        {{-- {!! Form::close() !!} --}}
                                                                    </form>
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
                                                        @foreach ($event->events_shortcourses as $events_shortcourses)
                                                            <tr>
                                                                <td>{{ $events_shortcourses->shortcourse->id }}
                                                                </td>
                                                                <td>{{ $events_shortcourses->shortcourse->name }}
                                                                </td>
                                                                <td>
                                                                    {{-- <a href="#"
                                                                        class="btn btn-sm btn-danger float-right mr-2">
                                                                        <i class="ni ni-close"></i>
                                                                    </a> --}}

                                                                    <form method="post"
                                                                        action="/event/shortcourse/detached/{{ $events_shortcourses->id }}">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger float-right mr-2">
                                                                            <i class="ni ni-close"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                    style="content-align:right">
                                                    <a href="javascript:;" data-toggle="modal" id="add-shortcourse"
                                                        class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                                            class="ni ni-plus"> </i> Add Short Course</a>

                                                    <div class="modal fade" id="crud-modal-add-shortcourse"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="card-header">
                                                                    <h5 class="card-title w-150">Add Short Course</h5>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <form
                                                                        action="{{ url('/event/shortcourse/attached/' . $event->id) }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <input type="hidden" name="id_5" id="id_5">
                                                                        <p><span class="text-danger">*</span>
                                                                            Vital Information</p>
                                                                        <hr class="mt-1 mb-2">
                                                                        <div class="form-group">
                                                                            <label for="user_id"><span
                                                                                    class="text-danger">*</span>
                                                                                Short Course Name</label>
                                                                            <div class="form-inline" style="width:100%">
                                                                                <div class="form-group mr-2 mb-2"
                                                                                    style="width:85%">
                                                                                    <div class="form-group">
                                                                                        <select
                                                                                            class="form-control shortcourse"
                                                                                            name="shortcourse_id"
                                                                                            id="shortcourse_id"
                                                                                            data-select2-id="shortcourse_id"
                                                                                            tabindex="-1"
                                                                                            aria-hidden="true">
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
                                                                            @error('shortcourse_id')
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
                                                                                <label class="form-label"
                                                                                    for="objective"><span
                                                                                        class="text-danger">*</span>Objective</label>
                                                                                <textarea class="form-control-plaintext"
                                                                                    rows="5" id="objective" name="objective"
                                                                                    disabled>
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
                                                                                <label class="form-label"
                                                                                    for="description"><span
                                                                                        class="text-danger">*</span>Description</label>
                                                                                <textarea class="form-control-plaintext"
                                                                                    rows="5" id="description"
                                                                                    name="description" disabled>
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
                                                                                data-dismiss="modal"
                                                                                id="close-add-shortcourse"><i
                                                                                    class="fal fa-window-close"></i>
                                                                                Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary ml-auto float-right mr-2"><i
                                                                                    class="ni ni-plus"></i>
                                                                                Add</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-3">
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-3">
                                        <div class="card">
                                            <div class="card-header bg-primary-50"><b>Participation Statistics</b></div>
                                            <div class="card-body">
                                                {{-- <table class="table table-striped table-bordered m-0">
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
                                                    </table> --}}
                                                <div class="row d-flex align-items-center justify-content-center">
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-primary-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['wait_for_application_approval'] }}
                                                                    <small class="m-0 l-h-n">Wait for Applic.
                                                                        Approv.</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                                                                style="font-size:6rem"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-warning-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['wait_for_applicant_making_payment'] }}
                                                                    <small class="m-0 l-h-n">In progress of Make.
                                                                        Pay.</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-briefcase position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                                                                style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-success-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">

                                                                    {{ $statistics['wait_for_payment_verification'] }}
                                                                    <small class="m-0 l-h-n">Wait for Pay. Confirm.</small>
                                                                </h3>
                                                            </div>
                                                            <i class="ni ni-doc position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6"
                                                                style="font-size: 8rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-info-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['ready_for_event'] }}
                                                                    <small class="m-0 l-h-n">Ready for Event</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-calendar position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-primary-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['attended_participant'] }}
                                                                    <small class="m-0 l-h-n">Attend</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-danger-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['not_attended_participant'] }}
                                                                    <small class="m-0 l-h-n">Not Attend</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-times position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-danger-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['cancelled_application'] }}
                                                                    <small class="m-0 l-h-n">Cancelled Applic.</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-ban position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                                                                style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-danger-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['not_completed_feedback'] }}
                                                                    <small class="m-0 l-h-n">Not Completed Feedback</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-clock position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-xl-3">
                                                        <div
                                                            class="p-3 bg-primary-500 rounded overflow-hidden position-relative text-white mb-g">
                                                            <div class="">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{ $statistics['completed_participation_process'] }}
                                                                    <small class="m-0 l-h-n">Completed</small>
                                                                </h3>
                                                            </div>
                                                            <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                style="font-size: 6rem;"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="specific" role="tabpanel">
                                        <hr class="mt-2 mb-2">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">

                                                @if (Session::has('success'))
                                                    <div class="alert alert-success"
                                                        style="color: #3b6324; background-color: #d3fabc;">
                                                        <i class="icon fal fa-check-circle"></i>
                                                        {{ Session::get('success') }}
                                                    </div>
                                                @endif

                                                <div class="panel-container show">
                                                    <div class="panel-content">
                                                        <ul class="nav nav-pills" role="tablist">
                                                            <li class="nav-item active">
                                                                <a data-toggle="tab" class="nav-link"
                                                                    href="#objective_specific_tab" role="tab">Objective</a>

                                                            </li>
                                                            <li class="nav-item">
                                                                <a data-toggle="tab" class="nav-link"
                                                                    href="#outline_specific_tab" role="tab">Outline</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a data-toggle="tab" class="nav-link"
                                                                    href="#tentative_specific_tab" role="tab">Tentative</a>
                                                            </li>
                                                        </ul>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <form action="{{ route('store.specific.editors') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="number" name="event_id"
                                                                        value="{{ $event->id }}" hidden />
                                                                    <div class="tab-content col-md-12">
                                                                        <div class="tab-pane active"
                                                                            id="objective_specific_tab" role="tabpanel">
                                                                            <textarea id="editor_objective"
                                                                                name="editor_objective">
                                                                                                                {{ $event->objective }}
                                                                                                            </textarea>
                                                                        </div>
                                                                        <div class="tab-pane" id="outline_specific_tab"
                                                                            role="tabpanel">
                                                                            <textarea id="editor_outline"
                                                                                name="editor_outline">
                                                                                                {{ $event->outline }}
                                                                                                            </textarea>
                                                                        </div>
                                                                        <div class="tab-pane" id="tentative_specific_tab"
                                                                            role="tabpanel">
                                                                            <textarea id="editor_tentative"
                                                                                name="editor_tentative">
                                                                                                {{ $event->tentative }}
                                                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-footer text-muted">
                                                                        <button type="submit"
                                                                            class="btn btn-primary ml-auto float-right mr-2"><i
                                                                                class="fal fa-save"></i>
                                                                            Save</button>
                                                                    </div>

                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-2">
                                                <div class="row row-md-12">
                                                    <div class="col-sm-6">
                                                        <div class="d-flex justify-content-center">
                                                            @if (!$event->thumbnail_path)
                                                                <img src="{{ asset('storage/shortcourse/poster/default/intec_poster.jpg') }}"
                                                                    class="card-img" style="object-fit: fill;">
                                                            @else
                                                                <img src="{{ asset($event->thumbnail_path) }}"
                                                                    class="card-img" style="object-fit: fill;">
                                                            @endif
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="card">
                                                            <div class="card-body">

                                                                <div class="row px-2 d-flex flex-column">
                                                                    @if (session()->has('message'))
                                                                        <div class="alert alert-success">
                                                                            {{ session()->get('message') }}
                                                                        </div>
                                                                    @endif
                                                                    {{-- {!! Form::open(['action' => ['ShortCourseManagement\EventManagement\EventController@updatePoster'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!} --}}
                                                                    <form action="{{ route('store.poster') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="number" value={{ $event->id }}
                                                                            name="event_id" id="event_id" hidden />
                                                                        <div class="form-group">
                                                                            <label class="form-label mx-2"
                                                                                for="inputGroupFile01">Upload New</label>
                                                                            <div class="input-group" style="width:100%">
                                                                                {{-- <div class="custom-file">
                                                                                    <input type="file"
                                                                                        class="custom-file-input"
                                                                                        id="poster_input">
                                                                                    <label class="custom-file-label"
                                                                                        for="inputGroupFile02"
                                                                                        aria-describedby="inputGroupFileAddon02">Choose
                                                                                        file</label>
                                                                                </div> --}}
                                                                                <div class="custom-file">
                                                                                    <input type="file"
                                                                                        class="custom-file-label"
                                                                                        name="poster_input"
                                                                                        accept="image/png, image/jpeg"
                                                                                        style="width:100%" />
                                                                                </div>
                                                                            </div>
                                                                            @error('poster_input')
                                                                                <p style="color: red">{{ $message }}</p>
                                                                            @enderror
                                                                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                                style="content-align:right">
                                                                                {{-- <a href="javascript:;" data-toggle="modal" id="add-shortcourse"
                                                                                class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                                                                    class="ni ni-plus"> </i> Add Short Course</a> --}}
                                                                                <button type="submit"
                                                                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed">Upload</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    {{-- {!! Form::close() !!} --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="setting" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">

                                                <div class="card">
                                                    <div class="card-body">
                                                        <table class="table table-striped table-bordered">
                                                            <thead class="table-primary">
                                                                <tr>
                                                                    <th class="text-center" scope="col" style="width:20%">
                                                                        <h3>Title</h3>
                                                                    </th>
                                                                    <th class="text-center" scope="col">
                                                                        <h3>Value</h3>
                                                                    </th>
                                                                    <th class="text-center" scope="col" style="width:20%">
                                                                        <h3>Action</h3>

                                                                    </th>
                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">Status</td>
                                                                    <td class="text-center" id="event_status_category_name"
                                                                        name="event_status_category_name">
                                                                        {{ $event->event_status_category->name }}</td>
                                                                    <td class="text-center">


                                                                        <a id="status_move_forward"
                                                                            name="status_move_forward" href="javascript:;"
                                                                            @php
                                                                                if ($event->event_status_category->id === 2 || $event->event_status_category->id === 3) {
                                                                                    echo "style='display: none'";
                                                                                }
                                                                            @endphp
                                                                            class="btn btn-primary mr-auto ml-2 waves-effect waves-themed font-weight-bold">{{ isset($eventStatusCategories->where('id', $event->event_status_category->id + 1)->first()->name) ? $eventStatusCategories->where('id', $event->event_status_category->id + 1)->first()->name : 'ERROR' }}</a>

                                                                        <a id="status_move_backward"
                                                                            name="status_move_backward" href="javascript:;"
                                                                            @php
                                                                                if ($event->event_status_category->id === 1) {
                                                                                    echo "style='display: none'";
                                                                                }
                                                                            @endphp
                                                                            class="btn btn-danger mr-auto ml-2 waves-effect waves-themed font-weight-bold">
                                                                            {{ isset($eventStatusCategories->where('id', $event->event_status_category->id - 1)->first()->name) ? $eventStatusCategories->where('id', $event->event_status_category->id - 1)->first()->name : 'ERROR' }}</a>

                                                                        {{-- <a id="status_cancel"
                                                                            name="status_move_backward" href="javascript:;"
                                                                            @php
                                                                                if ($event->event_status_category->id === 3) {
                                                                                    echo "style='display: none'";
                                                                                }
                                                                            @endphp
                                                                            class="btn btn-danger mr-auto ml-2 waves-effect waves-themed font-weight-bold">
                                                                            {{ isset($eventStatusCategories->where('id', 3)->first()->name) ? $eventStatusCategories->where('id', 3)->first()->name : 'ERROR' }}</a> --}}


                                                                    </td>
                                                                </tr>
                                                            </tbody>
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
        var event_id = '<?php echo $event->id; ?>';
        var event_status_category_id = '<?php echo $event->event_status_category_id; ?>';

        // General
        {
            // Basic Information
            {
                $("#edit-basic").click(function(e) {
                    $("#name_show").hide();
                    $("#name_edit").show();

                    $("#datetime_start_show").hide();
                    $("#datetime_start_edit").show();


                    $("#datetime_end_show").hide();
                    $("#datetime_end_edit").show();

                    $("#venue_show").hide();
                    $("#venue_edit").show();


                    $("#edit-basic").hide();
                    $("#save-basic").show();
                    $("#edit-basic-close").show();
                });

                $("#edit-basic-close").click(function(e) {
                    $("#name_show").show();
                    $("#name_edit").hide();

                    $("#datetime_start_show").show();
                    $("#datetime_start_edit").hide();

                    $("#datetime_end_show").show();
                    $("#datetime_end_edit").hide();

                    $("#venue_show").show();
                    $("#venue_edit").hide();


                    $("#edit-basic").show();
                    $("#save-basic").hide();
                    $("#edit-basic-close").hide();
                });

                $(document).ready(function() {
                    // $('.venue, .is_base_fee_select_add, .is_base_fee_select_edit').select2();

                    $('.venue').select2();

                });

            }

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
                        $('.modal-body #amount_add').val(amount);
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
                    var fee_id = button.data('id');
                    var name = button.data('name');
                    var amount = button.data('amount');
                    var is_base_fee = button.data('is_base_fee');
                    var promo_code = button.data('promo_code');

                    var selected = $("select[name=is_base_fee_select_edit]").val(is_base_fee);
                    $('#is_base_fee_select_edit_input').val(is_base_fee);
                    selected.prop('selected', true);

                    if (is_base_fee === 0) {
                        $("#form_group-promo_code-edit").show();

                    } else {
                        $("#form_group-promo_code-edit").hide();
                    }

                    $('.modal-body #fee_id').val(fee_id);
                    $('.modal-body #name_fee_edit').val(name);
                    $('.modal-body #amount_edit').val(amount);
                    $('.modal-body #is_base_fee').val(is_base_fee);
                    $('.modal-body #promo_code-edit').val(promo_code);
                });

                // fee type modification
                $(function() {
                    $("select[name=is_base_fee_select_add]").change(function(event) {
                        var is_base_fee = $("#is_base_fee_select_add option:selected").val();
                        $('#is_base_fee_select_add_input').val(is_base_fee);
                        if (is_base_fee == 0) {
                            $("div[name=form_group-promo_code_add]").show();
                        } else {
                            $("div[name=form_group-promo_code_add]").hide();
                            // $('.modal-body #hasKolejNew').val(false);
                        }
                    });

                    $("select[name=is_base_fee_select_edit]").change(function(event) {
                        var is_base_fee = $("#is_base_fee_select_edit option:selected").val();
                        $('is_base_fee_select_edit_input').val(is_base_fee);
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
                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);
                    $('.modal-body #fullname').val(null);
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('#crud-modal-add-trainer').modal('show');
                    $("div[id=form-add-trainer-second-part]").hide();
                });

                $('#crud-modal-add-trainer').on('show.bs.modal', function(event) {
                    // var button = $(event.relatedTarget)
                    // var id = button.data('id');
                    // var user_id = button.data('user_id');

                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);


                    $("div[id=form-add-trainer-second-part]").hide();
                    $('#add_trainer_footer').hide();
                    $("#search-by-trainer_ic-div").css({
                        "width": "85%"
                    });
                    $('#search-by-trainer_ic').show();
                });

                // search by trainer ic
                $('#search-by-trainer_ic').click(function() {
                    var trainer_ic = $('#trainer_ic_input').val();
                    $.get("/trainer/search-by-trainer_ic/" + trainer_ic, function(data) {
                        $("#trainer_user_id option[value='" + data.id + "']").attr("selected", "true");
                        $("#trainer_user_id_text").show();
                        $("#trainer_user_id_text").removeAttr('disabled');

                        $("#trainer_user_id").hide();
                        $("#trainer_user_id").attr('style', 'display: none');
                        $("#trainer_user_id").removeClass('user');

                        $("#trainer_user_id_text").val(data.id);
                        $('#trainer_fullname').val(data.name);
                        $('#trainer_phone').val(data.trainer.phone);
                        $('#trainer_email').val(data.email);


                    }).fail(
                        function() {
                            $('#trainer_ic').val(null);
                            $("#trainer_user_id_text").hide();
                            $("#trainer_user_id_text").attr('disabled');

                            $("#trainer_user_id").show();
                            $("#trainer_user_id").removeAttr('disabled');
                            $("#trainer_user_id").addClass('user');

                            $("#trainer_user_id option[value='-1']").attr("selected", "true");
                            $('#trainer_fullname').val(null);
                            $('#trainer_phone').val(null);
                            $('#trainer_email').val(null);
                        }).always(
                        function() {
                            $("div[id=form-add-trainer-second-part]").show();
                            $('#add_trainer_footer').show();
                            // $('#search-by-trainer_ic').hide();
                            // $("#search-by-trainer_ic-div").css({
                            //     "width": "100%"
                            // });
                        });

                });

                $('#trainer_ic_input').change(function() {

                    // $("#trainer_user_id").select2().val(-1).trigger("change");
                    $("#trainer_user_id_text").hide();
                    $("#trainer_user_id_text").attr('disabled');

                    $("#trainer_user_id_text").val(null);
                    $('#trainer_fullname').val(null);
                    $('#trainer_phone').val(null);
                    $('#trainer_email').val(null);

                    $('#add_trainer_footer').hide();

                    $("div[id=form-add-trainer-second-part]").hide();
                    $('#search-by-trainer_ic').trigger("click");


                });

                // User_ID information
                $('#trainer_user_id').change(function(event) {
                    var trainer_fullname = $('#trainer_user_id').find(":selected").attr('name');
                    var trainer_user_id = $('#trainer_user_id').find(":selected").val();

                    var users = @json($users);

                    var selected_user = users.find((x) => {
                        return x.id == trainer_user_id;
                    });
                    if (selected_user) {
                        $('#trainer_fullname').val(selected_user.name);
                        $('#trainer_email').val(selected_user.email);
                    } else {
                        $('#trainer_fullname').val(null);
                        $('#trainer_email').val(null);
                    }
                });

                // search by trainer user_id
                $('#search-by-user_id').click(function() {
                    var user_id = $('.modal-body #user_id').val();
                    $.get("/trainer/search-by-user_id/" + user_id, function(data) {
                        $('.modal-body #trainer_id').val(data.trainer.id);
                        $('.modal-body #fullname').val(data.name);
                        $('.modal-body #phone').val(data.trainer.phone);
                        $('.modal-body #email').val(data.email);

                    }).fail(
                        function() {
                            $('.modal-body #trainer_id').val(null);
                            $('.modal-body #fullname').val(null);
                            $('.modal-body #phone').val(null);
                            $('.modal-body #email').val(null);
                        }).always(
                        function() {
                            $("div[id=form-add-trainer-second-part]").show();
                        });

                });
            }

            // List of Shortcourses
            {
                // Add shortcourse
                // crud-modal-add-shortcourse
                $('#add-shortcourse').click(function() {
                    var id = null;
                    var shortcourse_id = null;
                    $('.modal-body #id').val(id);
                    $('.modal-body #shortcourse_id').val(shortcourse_id);
                    $('.modal-body #objective').val(null);
                    $('.modal-body #description').val(null);
                    $("div[id=form-add-shortcourse-second-part]").hide();
                    $('#crud-modal-add-shortcourse').modal('show');
                });

                $('#crud-modal-add-shortcourse').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id');
                    var shortcourse_id = button.data('shortcourse_id');

                    $('.modal-body #id').val(id);
                    $('.modal-body #shortcourse_id').val(shortcourse_id);
                });

                // search by id
                $('#shortcourse_id').change(function() {
                    var id = $('.modal-body #shortcourse_id').val();
                    $.get("/event/shortcourse/search-by-id/" + id, function(data) {
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

        }

        // Specific
        {

            ClassicEditor
                .create(document.querySelector('#editor_objective'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#editor_outline'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#editor_tentative'))
                .catch(error => {
                    console.error(error);
                });

            var desc = CKEDITOR.instances['DSC'].getData();

        }

        // Setting
        {
            $('#status_move_forward').click(function() {
                $.get("/event/" + event_id + "/update-event-status-category/" + (parseInt(
                        event_status_category_id) + 1),
                    function(data) {
                        window.location.reload()
                    }).fail(
                    function() {
                        // TODO: Notify Users
                        console.log('fail');
                    });
            });

            $('#status_move_backward').click(function() {
                $.get("/event/" + event_id + "/update-event-status-category/" + (parseInt(
                        event_status_category_id) - 1),
                    function(data) {
                        window.location.reload()

                    }).fail(
                    function() {
                        // TODO: Notify Users
                        console.log('fail');
                    });
            });

            // $('#status_cancel').click(function() {
            //     $.get("/event/" + event_id + "/update-event-status-category/" + 3,
            //         function(data) {
            //             window.location.reload()

            //         }).fail(
            //         function() {
            //             // TODO: Notify Users
            //             console.log('fail');
            //         });
            // });

        }
    </script>
@endsection
