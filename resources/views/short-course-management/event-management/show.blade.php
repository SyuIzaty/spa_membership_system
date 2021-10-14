@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
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
                                    <a data-toggle="tab" class="nav-link" href="#specific" role="tab">Addtitional
                                        Info</a>
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
                                            <div class="col-md-12 grid-margin stretch-card" style="padding-bottom:2rem;">
                                                @if (Session::has('successUpdateGeneral'))
                                                    <div class="alert alert-success"
                                                        style="color: #3b6324; background-color: #d3fabc;">
                                                        <i class="icon fal fa-check-circle"></i>
                                                        {{ Session::get('successUpdateGeneral') }}
                                                    </div>
                                                @endif

                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <strong>Whoops!</strong> There were some problems with your
                                                        input.<br><br>
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
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
                                                                <td>Name</td>
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
                                                                <td>Event Type</td>
                                                                <td name="event_type_show" id="event_type_show">
                                                                    {{ $event->is_modular == 0 ? 'Regular Event' : 'Modular Event' }}
                                                                </td>
                                                                <td name="event_type_edit" id="event_type_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <select class="form-control event_type "
                                                                            name="event_type" id="event_type"
                                                                            data-select2-id="event_type" tabindex="-1"
                                                                            aria-hidden="true">
                                                                            <option value="0"
                                                                                {{ $event->is_modular == 0 ? 'Selected' : '' }}>
                                                                                Regular Event
                                                                            </option>
                                                                            <option value="1"
                                                                                {{ $event->is_modular == 1 ? 'Selected' : '' }}>
                                                                                Modular Event
                                                                            </option>
                                                                        </select>
                                                                        @error('event_type')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr id="is_modular_single_selection_row"
                                                                {{ $event->is_modular == 0 ? 'style=display:none;' : '' }}>
                                                                <td>Module Selection Mode</td>
                                                                <td name="is_modular_single_selection_show"
                                                                    id="is_modular_single_selection_show">
                                                                    {{ $event->is_modular_single_selection == 1 ? 'Single Selection' : 'Multiple Selection' }}
                                                                </td>
                                                                <td name="is_modular_single_selection_edit"
                                                                    id="is_modular_single_selection_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <select
                                                                            class="form-control is_modular_single_selection "
                                                                            name="is_modular_single_selection"
                                                                            id="is_modular_single_selection"
                                                                            data-select2-id="is_modular_single_selection"
                                                                            tabindex="-1" aria-hidden="true">
                                                                            <option value="0"
                                                                                {{ $event->is_modular_single_selection == 0 ? 'Selected' : '' }}>
                                                                                Multiple Selection
                                                                            </option>
                                                                            <option value="1"
                                                                                {{ $event->is_modular_single_selection == 1 ? 'Selected' : '' }}>
                                                                                Single Selection
                                                                            </option>
                                                                        </select>
                                                                        @error('is_modular_single_selection')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr id="modular_num_of_selection_min_row"
                                                                {{ $event->is_modular_single_selection == 1 || is_null($event->is_modular_single_selection) ? 'style=display:none;' : '' }}>
                                                                <td>Minimum Number of Selection</td>
                                                                <td name="modular_num_of_selection_min_show"
                                                                    id="modular_num_of_selection_min_show">
                                                                    {{ $event->modular_num_of_selection_min ? $event->modular_num_of_selection_min : 'Not Specified' }}
                                                                </td>
                                                                <td name="modular_num_of_selection_min_edit"
                                                                    id="modular_num_of_selection_min_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="modular_num_of_selection_min"
                                                                            name="modular_num_of_selection_min"
                                                                            type="number"
                                                                            value="{{ $event->modular_num_of_selection_min ? $event->modular_num_of_selection_min : 0 }}"
                                                                            class="form-control">
                                                                        @error('modular_num_of_selection_min')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr id="modular_num_of_selection_max_row"
                                                                {{ $event->is_modular_single_selection == 1 || is_null($event->is_modular_single_selection) ? 'style=display:none;' : '' }}>
                                                                <td>Maximum Number of Selection</td>
                                                                <td name="modular_num_of_selection_max_show"
                                                                    id="modular_num_of_selection_max_show">
                                                                    {{ $event->modular_num_of_selection_max ? $event->modular_num_of_selection_max : 'Not Specified' }}
                                                                </td>
                                                                <td name="modular_num_of_selection_max_edit"
                                                                    id="modular_num_of_selection_max_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="modular_num_of_selection_max"
                                                                            name="modular_num_of_selection_max"
                                                                            type="number"
                                                                            value="{{ $event->modular_num_of_selection_max ? $event->modular_num_of_selection_max : 0 }}"
                                                                            class="form-control">
                                                                        @error('modular_num_of_selection_max')
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
                                                                <td>Date Start</td>
                                                                <td name="datetime_start_show" id="datetime_start_show">
                                                                    {{ date('d/m/Y h:i A', strtotime($event->datetime_start)) }}
                                                                </td>
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
                                                                <td>Date End</td>
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
                                                                <td>Venue</td>
                                                                <td name="venue_show" id="venue_show">
                                                                    {{ $event->venue->name }}
                                                                </td>
                                                                <td name="venue_edit" id="venue_edit" style="display: none">
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

                                                                        @error('venue')
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
                                                                <td>Venue Description</td>
                                                                <td name="venue_description_show"
                                                                    id="venue_description_show">
                                                                    {{ $event->venue_description }}
                                                                </td>
                                                                <td name="venue_description_edit"
                                                                    id="venue_description_edit" style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="venue_description"
                                                                            name="venue_description" type="text"
                                                                            value="{{ $event->venue_description }}"
                                                                            class="form-control">
                                                                        @error('venue_description')
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
                                                                <td>Feedback Set</td>
                                                                <td name="event_feedback_set_show"
                                                                    id="event_feedback_set_show">
                                                                    {{ $event->event_feedback_set->name }}
                                                                </td>
                                                                <td name="event_feedback_set_edit"
                                                                    id="event_feedback_set_edit" style="display: none">
                                                                    <div class="form-group">
                                                                        <select class="form-control event_feedback_set "
                                                                            name="event_feedback_set"
                                                                            id="event_feedback_set"
                                                                            data-select2-id="event_feedback_set"
                                                                            tabindex="-1" aria-hidden="true">
                                                                            <option
                                                                                value={{ $event->event_feedback_set ? $event->event_feedback_set->id : '' }}>
                                                                                {{ $event->event_feedback_set ? $event->event_feedback_set->name : 'Choose an event feedback set' }}
                                                                            </option>
                                                                            @foreach ($event_feedback_sets as $event_feedback_set)
                                                                                @if ($event->event_feedback_set ? $event_feedback_set->id != $event->event_feedback_set->id : false)
                                                                                    <option
                                                                                        value="{{ $event_feedback_set->id }}">
                                                                                        {{ $event_feedback_set->name }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        @error('event_feedback_set')
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
                                                                <td>Total Seat Open</td>
                                                                <td name="max_participant_show" id="max_participant_show">
                                                                    {{ $event->max_participant }}
                                                                </td>
                                                                <td name="max_participant_edit" id="max_participant_edit"
                                                                    style="display: none">
                                                                    <div class="form-group">
                                                                        <input id="max_participant" name="max_participant"
                                                                            type="number"
                                                                            value="{{ $event->max_participant }}"
                                                                            class="form-control">
                                                                        @error('max_participant')
                                                                            <p style="color: red">
                                                                                <strong> *
                                                                                    {{ $message }}
                                                                                </strong>
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <tbody>
                                                    </table>
                                                </form>

                                                <div style="display:flex; flex-direction:column;">
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50" scope="row">
                                                                <th colspan="5"><b>List of Fees</b></th>
                                                            </tr>
                                                            <tr scope="row">
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Amount (RM)</th>
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
                                                                        <a href="#"
                                                                            class="btn btn-sm btn-info float-right mr-2"
                                                                            name="edit-fee" id="edit-fee"
                                                                            data-target="#edit-fee-modal"
                                                                            data-toggle="modal" data-id={{ $fee->id }}
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
                                                        <div class="modal fade" id="crud-modal-new-fee"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="card-header">
                                                                        <h5 class="card-title w-150">Add New
                                                                            Fee</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ url('/event/fee/create/' . $event->id) }}"
                                                                            method="post" name="form">
                                                                            @csrf
                                                                            <p><span class="text-danger">*</span>
                                                                                Required Field</p>
                                                                            <hr class="mt-1 mb-2">
                                                                            <div id="form-fee">
                                                                                <div class="form-group">
                                                                                    <label class="form-label"
                                                                                        for="name"><span
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
                                                                                    <label class="form-label"
                                                                                        for="amount"><span
                                                                                            class="text-danger">*</span>amount
                                                                                        (RM)</label>
                                                                                    <input type="number" step=".01"
                                                                                        class="form-control"
                                                                                        id="amount_add" name="amount_add">
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
                                                                                        <option value=1>Normal Price
                                                                                        </option>
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
                                                                                    data-dismiss="modal"
                                                                                    id="close-new-fee"><i
                                                                                        class="fal fa-window-close"></i>
                                                                                    Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary ml-auto float-right mr-2"><i
                                                                                        class="ni ni-plus"></i>
                                                                                    Apply</button>
                                                                            </div>
                                                                        </form>
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
                                                                        <p><span class="text-danger">*</span>
                                                                            Required Field</p>
                                                                        <hr class="mt-1 mb-2">
                                                                        <div id="form-fee">

                                                                            <input type="number" name="fee_id" id="fee_id"
                                                                                style="display:none">
                                                                            <div class="form-group">
                                                                                <label class="form-label"
                                                                                    for="name"><span
                                                                                        class="text-danger">*</span>name</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="name_fee_edit" name="name_fee_edit">

                                                                                @error('name')
                                                                                    <p style="color: red">
                                                                                        <strong> *
                                                                                            {{ $message }}
                                                                                        </strong>
                                                                                    </p>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="form-label"
                                                                                    for="amount"><span
                                                                                        class="text-danger">*</span>amount
                                                                                    (RM)</label>
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
                                                                                    <option value=0>Discounted Price
                                                                                    </option>
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
                                                                                <label class="form-label"
                                                                                    for="promo_code"><span
                                                                                        class="text-danger">*</span>promo
                                                                                    code</label>
                                                                                <input class="form-control"
                                                                                    id="promo_code-edit" name="promo_code">
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
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-3">

                                                <div style="display:flex; flex-direction:column;">
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="3"><b>List of Trainers</b></th>
                                                            </tr>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

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
                                                        <div class="modal fade" id="crud-modal-add-trainer"
                                                            aria-hidden="true">
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
                                                                            <p><span class="text-danger">*</span>
                                                                                Required Field</p>
                                                                            <hr class="mt-1 mb-2">
                                                                            <div class="form-group">
                                                                                <label for="trainer_ic"><span
                                                                                        class="text-danger">*</span>
                                                                                    Trainer's IC</label>
                                                                                <div class="form-group"
                                                                                    id="search-by-trainer_ic-div">
                                                                                    <input class="form-control"
                                                                                        id="trainer_ic_input"
                                                                                        name="trainer_ic_input">
                                                                                </div>
                                                                                <a href="javascript:;" data-toggle="#"
                                                                                    id="search-by-trainer_ic"
                                                                                    class="btn btn-primary mb-2" hidden><i
                                                                                        class="ni ni-magnifier"></i></a>
                                                                                @error('trainer_ic_input')
                                                                                    <p style="color: red">
                                                                                        <strong> *
                                                                                            {{ $message }}
                                                                                        </strong>
                                                                                    </p>
                                                                                @enderror
                                                                            </div>
                                                                            <hr class="mt-1 mb-2">
                                                                            <div id="form-add-trainer-second-part">
                                                                                <div class="form-group">
                                                                                    <label for="user_id"><span
                                                                                            class="text-danger">*</span>
                                                                                        Trainer's User ID</label>
                                                                                    {{ Form::text('trainer_user_id_text', '', ['class' => 'form-control', 'placeholder' => "Trainer's User ID", 'id' => 'trainer_user_id_text', 'disabled', 'readonly']) }}
                                                                                    <select class="form-control user"
                                                                                        name="trainer_user_id"
                                                                                        id="trainer_user_id"
                                                                                        style="display:none">
                                                                                        <option disabled>Select User ID
                                                                                        </option>
                                                                                        <option value='-1'
                                                                                            name="create_new">
                                                                                            Create
                                                                                            New</option>
                                                                                        @foreach ($users as $user)
                                                                                            <option
                                                                                                value='{{ $user->id }}'
                                                                                                name="{{ $user->name }}">
                                                                                                {{ $user->id }} -
                                                                                                {{ $user->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('trainer_user_id')
                                                                                        <p style="color: red">
                                                                                            {{ $message }}
                                                                                        </p>
                                                                                    @enderror
                                                                                </div>
                                                                                <hr class="mt-1 mb-2">

                                                                                <input class="form-control-plaintext"
                                                                                    id="trainer_id" name="trainer_id"
                                                                                    hidden>
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
                                                                                            class="text-danger">*</span>Phone
                                                                                        (ex: +60134567891)</label>
                                                                                    <input class="form-control"
                                                                                        id="trainer_phone"
                                                                                        name="trainer_phone">
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
                                                                                        id="trainer_email"
                                                                                        name="trainer_email">
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
                                                                            <div class="footer"
                                                                                id="add_trainer_footer">
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
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-3">

                                                <div style="display:flex; flex-direction:column;">
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="3"><b>List of Contact Persons</b></th>
                                                            </tr>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($event->events_contact_persons as $event_contact_person)
                                                                <tr>
                                                                    <td>{{ $event_contact_person->contact_person->user->id }}
                                                                    </td>
                                                                    <td>{{ $event_contact_person->contact_person->user->name }}
                                                                    </td>
                                                                    <td>
                                                                        <form method="post"
                                                                            action="/event/contact_person/detached/{{ $event_contact_person->id }}">
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
                                                        <a href="javascript:;" data-toggle="modal" id="add-contact_person"
                                                            class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                                                class="ni ni-plus"> </i> Add Contact Person</a>
                                                        <div class="modal fade" id="crud-modal-add-contact_person"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="card-header">
                                                                        <h5 class="card-title w-150">Add Contact Person
                                                                        </h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ url('/event/contact_person/attached/' . $event->id) }}"
                                                                            method="post" name="form">
                                                                            @csrf

                                                                            <p><span class="text-danger">*</span>
                                                                                Required Field</p>
                                                                            <hr class="mt-1 mb-2">
                                                                            <div class="form-group">
                                                                                <label for="contact_person_ic"><span
                                                                                        class="text-danger">*</span>
                                                                                    Contact Person's IC</label>
                                                                                <div class="form-group"
                                                                                    id="search-by-contact_person_ic-div">
                                                                                    <input class="form-control w-100"
                                                                                        id="contact_person_ic_input"
                                                                                        name="contact_person_ic_input">
                                                                                </div>
                                                                                <a href="javascript:;" data-toggle="#"
                                                                                    id="search-by-contact_person_ic"
                                                                                    class="btn btn-primary mb-2"
                                                                                    style="width:10%" hidden><i
                                                                                        class="ni ni-magnifier"></i></a>
                                                                                @error('contact_person_ic_input')
                                                                                    <p style="color: red">
                                                                                        <strong> *
                                                                                            {{ $message }}
                                                                                        </strong>
                                                                                    </p>
                                                                                @enderror
                                                                            </div>
                                                                            <hr class="mt-1 mb-2">
                                                                            <div id="form-add-contact_person-second-part">
                                                                                <div class="form-group">
                                                                                    <label for="user_id"><span
                                                                                            class="text-danger">*</span>
                                                                                        Contact Person's User ID</label>
                                                                                    {{ Form::text('contact_person_user_id_text', '', ['class' => 'form-control', 'placeholder' => "Contact Person's User ID", 'id' => 'contact_person_user_id_text', 'disabled', 'readonly']) }}
                                                                                    <select class="form-control user"
                                                                                        name="contact_person_user_id"
                                                                                        id="contact_person_user_id" disabled
                                                                                        style="display:none">
                                                                                        <option disabled>Select User ID
                                                                                        </option>
                                                                                        <option value='-1'
                                                                                            name="create_new">
                                                                                            Create
                                                                                            New</option>
                                                                                        @foreach ($users as $user)
                                                                                            <option
                                                                                                value='{{ $user->id }}'
                                                                                                name="{{ $user->name }}">
                                                                                                {{ $user->id }} -
                                                                                                {{ $user->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('contact_person_user_id')
                                                                                        <p style="color: red">
                                                                                            {{ $message }}
                                                                                        </p>
                                                                                    @enderror
                                                                                </div>
                                                                                <hr class="mt-1 mb-2">

                                                                                <input class="form-control-plaintext"
                                                                                    id="contact_person_id"
                                                                                    name="contact_person_id" hidden>
                                                                                <div class="form-group">
                                                                                    <label class="form-label"
                                                                                        for="contact_person_fullname"><span
                                                                                            class="text-danger">*</span>Fullname</label>
                                                                                    <input class="form-control"
                                                                                        id="contact_person_fullname"
                                                                                        name="contact_person_fullname">
                                                                                    @error('contact_person_fullname')
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
                                                                                        for="contact_person_phone"><span
                                                                                            class="text-danger">*</span>Phone
                                                                                        (ex: +60134567891)</label>
                                                                                    <input class="form-control"
                                                                                        id="contact_person_phone"
                                                                                        name="contact_person_phone">
                                                                                    @error('contact_person_phone')
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
                                                                                        for="contact_person_email"><span
                                                                                            class="text-danger">*</span>Email</label>
                                                                                    <input class="form-control"
                                                                                        id="contact_person_email"
                                                                                        name="contact_person_email">
                                                                                    @error('contact_person_email')
                                                                                        <p style="color: red">
                                                                                            <strong> *
                                                                                                {{ $message }}
                                                                                            </strong>
                                                                                        </p>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                            <hr class="mt-1 mb-2">
                                                                            <div class="footer"
                                                                                id="add_contact_person_footer">
                                                                                <button type="button"
                                                                                    class="btn btn-danger ml-auto float-right mr-2"
                                                                                    data-dismiss="modal"
                                                                                    id="close-add-contact_person"><i
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
                                                </div>
                                                <hr class="mt-2 mb-3">

                                                <div style="display:flex; flex-direction:column;">
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="4"><b>List of Short Courses</b></th>
                                                            </tr>
                                                            <tr>
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
                                                        <button href="javascript:;" data-toggle="modal" id="add-shortcourse"
                                                            class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"
                                                            {{ count($event->events_shortcourses) == 0 ? null : 'disabled' }}><i
                                                                class="ni ni-plus"> </i> Add Short Course</button>

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
                                                                                Required Field</p>
                                                                            <hr class="mt-1 mb-2">
                                                                            <div class="form-group">
                                                                                <label for="user_id"><span
                                                                                        class="text-danger">*</span>
                                                                                    Short Course Name</label>
                                                                                <div class="form-group">
                                                                                    <select
                                                                                        class="form-control shortcourse"
                                                                                        name="shortcourse_id"
                                                                                        id="shortcourse_id"
                                                                                        data-select2-id="shortcourse_id"
                                                                                        tabindex="-1" aria-hidden="true">
                                                                                        <option value=''>Choose a Short
                                                                                            Course
                                                                                        </option>
                                                                                        @foreach ($shortcourses as $shortcourse)
                                                                                            <option
                                                                                                value="{{ $shortcourse->id }}">
                                                                                                {{ $shortcourse->name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
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
                                                                                    <div class="form-control-plaintext"
                                                                                        rows="10" id="objective"
                                                                                        name="objective">
                                                                                    </div>
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
                                                                                    <div class="form-control-plaintext"
                                                                                        rows="10" id="description"
                                                                                        name="description"></div>
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
                                                                                    class="btn btn-danger ml-auto float-right mr-2"
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
                                                </div>
                                                <div id="module_field" style="display:flex; flex-direction:column;"
                                                    {{ $event->is_modular == 1 ? '' : 'hidden' }}>
                                                    <table class="table table-striped table-bordered m-0">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="4"><b>List of Modules</b></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Fee (RM)</th>
                                                                <th>Total Application</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($event->event_modules as $event_module)
                                                                <tr>
                                                                    <td>{{ $event_module->name }}
                                                                    </td>
                                                                    <td>{{ $event_module->fee_amount }}
                                                                    </td>
                                                                    <td>{{ $event_module->totalApplication }}
                                                                    </td>
                                                                    <td class="d-flex justify-content-center">

                                                                        <a href="#"
                                                                            class="btn btn-sm btn-info float-right mr-2"
                                                                            name="edit-module" id="edit-module"
                                                                            data-target="#edit-module-modal"
                                                                            data-toggle="modal"
                                                                            data-id={{ $event_module->id }}
                                                                            data-name='{{ $event_module->name }}'
                                                                            data-fee_amount='{{ $event_module->fee_amount }}'>
                                                                            <i class="fal fa-pencil"></i>
                                                                        </a>
                                                                        <form method="post"
                                                                            action="/event/event_module/remove/{{ $event_module->id }}">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="btn btn-sm btn-danger float-right mr-2"
                                                                                {{ $event_module->totalApplication == 0 ? '' : 'disabled' }}>
                                                                                <i class="ni ni-close"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                    </table>
                                                    <div class="modal fade" id="edit-module-modal" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="card-header">
                                                                    <h5 class="card-title w-150">Edit
                                                                        Module</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ url('/events/module/update') }}"
                                                                        method="post" name="form">
                                                                        @csrf
                                                                        <p><span class="text-danger">*</span>
                                                                            Required Field</p>
                                                                        <hr class="mt-1 mb-2">
                                                                        <div id="form">
                                                                            <input type="number" name="module_id"
                                                                                id="module_id" style="display:none">
                                                                            <div class="form-group">
                                                                                <label class="form-label"
                                                                                    for="module_name"><span
                                                                                        class="text-danger">*</span>Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="module_name" name="module_name">
                                                                                @error('module_name')
                                                                                    <p style="color: red">
                                                                                        <strong> *
                                                                                            {{ $message }}
                                                                                        </strong>
                                                                                    </p>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="form-label"
                                                                                    for="module_fee_amount"><span
                                                                                        class="text-danger">*</span>Fee
                                                                                    Amount (RM)</label>
                                                                                <input type="number" step=".01"
                                                                                    class="form-control"
                                                                                    id="module_fee_amount"
                                                                                    name="module_fee_amount">
                                                                                @error('module_fee_amount')
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
                                                                                Update</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a href="javascript:;" name="addModule" id="addModule"
                                                        class="btn btn-primary btn-sm ml-auto float-right my-2">Add
                                                        More Module</a>
                                                </div>
                                                <hr class="mt-2 mb-3">
                                                <div class="card">
                                                    <div class="card-header bg-primary-50"><b>Participation Statistics</b>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row d-flex align-items-center justify-content-center">
                                                            <div class="col-sm-6 col-xl-3">
                                                                <div
                                                                    class="p-3 bg-primary-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                    <div class="___class_+?263___">
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
                                                                    <div class="___class_+?269___">
                                                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                            {{ $statistics['wait_for_applicant_making_payment'] }}
                                                                            <small class="m-0 l-h-n">In progress of
                                                                                Make.
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
                                                                    <div class="___class_+?275___">
                                                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">

                                                                            {{ $statistics['wait_for_payment_verification'] }}
                                                                            <small class="m-0 l-h-n">Wait for Pay.
                                                                                Confirm.</small>
                                                                        </h3>
                                                                    </div>
                                                                    <i class="ni ni-doc position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6"
                                                                        style="font-size: 8rem;"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-xl-3">
                                                                <div
                                                                    class="p-3 bg-info-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                    <div class="___class_+?281___">
                                                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                            {{ $statistics['ready_for_event'] }}
                                                                            <small class="m-0 l-h-n">Ready for
                                                                                Event</small>
                                                                        </h3>
                                                                    </div>
                                                                    <i class="fal fa-calendar position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                        style="font-size: 6rem;"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-xl-3">
                                                                <div
                                                                    class="p-3 bg-primary-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                    <div class="___class_+?287___">
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
                                                                    <div class="___class_+?293___">
                                                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                            {{ $statistics['not_attended_participant'] }}
                                                                            <small class="m-0 l-h-n">Not
                                                                                Attend</small>
                                                                        </h3>
                                                                    </div>
                                                                    <i class="fal fa-times position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                        style="font-size: 6rem;"></i>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-xl-3">
                                                                <div
                                                                    class="p-3 bg-danger-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                    <div class="___class_+?299___">
                                                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                            {{ $statistics['cancelled_application'] }}
                                                                            <small class="m-0 l-h-n">Cancelled
                                                                                Applic.</small>
                                                                        </h3>
                                                                    </div>
                                                                    <i class="fal fa-ban position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                                                                        style="font-size: 6rem;"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-xl-3">
                                                                <div
                                                                    class="p-3 bg-danger-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                    <div class="___class_+?305___">
                                                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                            {{ $statistics['not_completed_feedback'] }}
                                                                            <small class="m-0 l-h-n">Not Completed
                                                                                Feedback</small>
                                                                        </h3>
                                                                    </div>
                                                                    <i class="fal fa-clock position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n4"
                                                                        style="font-size: 6rem;"></i>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 col-xl-3">
                                                                <div
                                                                    class="p-3 bg-primary-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                    <div class="___class_+?311___">
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
                                                <hr class="mt-2 mb-3">
                                                <div class="card"
                                                    {{ $event->is_modular == 0 ? 'style=display:none;' : '' }}>
                                                    <div class="card-header bg-primary-50"><b>Application By Module</b>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row d-flex align-items-center justify-content-center">

                                                            @foreach ($event->event_modules as $event_module)
                                                                <div class="col-sm-6 col-xl-3">
                                                                    <div
                                                                        class="p-3 bg-primary-500 rounded overflow-hidden position-relative text-white mb-g">
                                                                        <div class="___class_+?263___">
                                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                                {{ $event_module->totalApplication }}
                                                                                <small
                                                                                    class="m-0 l-h-n">{{ $event_module->name }}</small>
                                                                            </h3>
                                                                        </div>
                                                                        <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                                                                            style="font-size:6rem"></i>
                                                                    </div>
                                                                </div>
                                                            @endforeach
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
                                                                <a data-toggle="tab" class="nav-link active"
                                                                    href="#description_specific_tab"
                                                                    role="tab">Description</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a data-toggle="tab" class="nav-link"
                                                                    href="#editor_target_audience_specific_tab"
                                                                    role="tab">Target Audience</a>
                                                            </li>
                                                            <li class="nav-item">
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
                                                                            id="description_specific_tab" role="tabpanel">
                                                                            <textarea id="editor_description"
                                                                                name="editor_description" rows="10"
                                                                                class="ck-editor__editable ck-editor__editable_inline"> {{ $event->description }} </textarea>
                                                                        </div>

                                                                        <div class="tab-pane"
                                                                            id="editor_target_audience_specific_tab"
                                                                            role="tabpanel">
                                                                            <textarea id="editor_target_audience"
                                                                                name="editor_target_audience" rows="10"
                                                                                class="ck-editor__editable ck-editor__editable_inline"> {{ $event->target_audience }} </textarea>
                                                                        </div>
                                                                        <div class="tab-pane"
                                                                            id="objective_specific_tab" role="tabpanel">
                                                                            <textarea id="editor_objective"
                                                                                name="editor_objective" rows="10"
                                                                                class="ck-editor__editable ck-editor__editable_inline"> {{ $event->objective }} </textarea>
                                                                        </div>
                                                                        <div class="tab-pane"
                                                                            id="outline_specific_tab" role="tabpanel">
                                                                            <textarea id="editor_outline"
                                                                                name="editor_outline" rows="10"
                                                                                class="ck-editor__editable ck-editor__editable_inline">{{ $event->outline }}</textarea>
                                                                        </div>
                                                                        <div class="tab-pane"
                                                                            id="tentative_specific_tab" role="tabpanel">
                                                                            <textarea id="editor_tentative"
                                                                                name="editor_tentative" rows="10"
                                                                                class="ck-editor__editable ck-editor__editable_inline">{{ $event->tentative }}</textarea>
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
                                                            @if (!isset($event->thumbnail_path))
                                                                <img src="{{ asset('img/shortcourse/poster/default/intec_poster.jpg') }}"
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
                                                                    <form action="{{ route('store.poster') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="number" value={{ $event->id }}
                                                                            name="event_id" id="event_id" hidden />
                                                                        <div class="form-group">
                                                                            <label class="form-label mx-2"
                                                                                for="inputGroupFile01">Upload
                                                                                New</label>
                                                                            <div class="input-group" style="width:100%">
                                                                                <div class="custom-file">
                                                                                    <input type="file"
                                                                                        class="custom-file-label"
                                                                                        name="poster_input"
                                                                                        accept="image/png, image/jpeg"
                                                                                        style="width:100%" />
                                                                                </div>
                                                                            </div>
                                                                            @error('poster_input')
                                                                                <p style="color: red">
                                                                                    {{ $message }}
                                                                                </p>
                                                                            @enderror
                                                                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                                                                style="content-align:right">
                                                                                <button type="submit"
                                                                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed">Upload</button>
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
                                    <div class="tab-pane" id="setting" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">

                                                <table class="table table-striped table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
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
                                                            <td class="text-center" id="event_status_category_name"
                                                                name="event_status_category_name">
                                                                {{ $event->event_status_category->name }}</td>
                                                            <td class="text-center">


                                                                <a id="status_move_forward" name="status_move_forward"
                                                                    href="javascript:;" @php
                                                                        if ($event->event_status_category->id === 2 || $event->event_status_category->id === 3) {
                                                                            echo "style='display: none'";
                                                                        }
                                                                    @endphp
                                                                    class="btn btn-primary mr-auto ml-2 waves-effect waves-themed font-weight-bold">{{ isset($eventStatusCategories->where('id', $event->event_status_category->id + 1)->first()->name) ? $eventStatusCategories->where('id', $event->event_status_category->id + 1)->first()->name : 'ERROR' }}</a>

                                                                <a id="status_move_backward" name="status_move_backward"
                                                                    href="javascript:;" @php
                                                                        if ($event->event_status_category->id === 1) {
                                                                            echo "style='display: none'";
                                                                        }
                                                                    @endphp
                                                                    class="btn btn-danger mr-auto ml-2 waves-effect waves-themed font-weight-bold">
                                                                    {{ isset($eventStatusCategories->where('id', $event->event_status_category->id - 1)->first()->name) ? $eventStatusCategories->where('id', $event->event_status_category->id - 1)->first()->name : 'ERROR' }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center" id="event_status_category_name"
                                                                name="event_status_category_name">
                                                                Active
                                                            </td>
                                                            <td class="text-center">
                                                                <button
                                                                    {{ count($event->events_participants) == 0 ? null : 'disabled' }}
                                                                    href="javascript:;" id="delete_event"
                                                                    class="btn btn-danger mr-auto ml-2 waves-effect waves-themed font-weight-bold">DELETE</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="card" style="box-shadow:none;">
                                                    <div class="card-header" style="display:flex;">
                                                        <i class="ni ni-eye"
                                                            style='font-size:35px; align-self:center;'></i>
                                                        <h1 style="margin:0;"><span
                                                                style="margin-left:15px; font-size:35px;">Preview</span>
                                                        </h1>
                                                    </div>
                                                    <div class="card-body">
                                                        <x-ShortCourseManagement.PublicViewEventDetail :errors=$errors
                                                            :event=$event />
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
        var event_status_category_id = '<?php echo $event->event_status_category_id; ?>';

        // General
        {
            $(document).ready(function() {

                document.getElementById("add-shortcourse").addEventListener("click", function(event) {
                    event.preventDefault()
                });
                $('.venue, .event_feedback_set, .event_type, .is_modular_single_selection').select2();
                $('.user').select2({
                    dropdownParent: $('#crud-modal-add-trainer, #crud-modal-add-contact_person')
                });
                $('.shortcourse').select2({
                    dropdownParent: $(
                        '#crud-modal-add-shortcourse')
                });
            });
            // Basic Information
            {
                $("#edit-basic").click(function(e) {
                    $("#name_show").hide();
                    $("#name_edit").show();

                    $("#event_type_show").hide();
                    $("#event_type_edit").show();

                    $("#is_modular_single_selection_show").hide();
                    $("#is_modular_single_selection_edit").show();

                    $("#modular_num_of_selection_min_show").hide();
                    $("#modular_num_of_selection_min_edit").show();


                    $("#modular_num_of_selection_max_show").hide();
                    $("#modular_num_of_selection_max_edit").show();


                    $("#datetime_start_show").hide();
                    $("#datetime_start_edit").show();


                    $("#datetime_end_show").hide();
                    $("#datetime_end_edit").show();

                    $("#venue_description_show").hide();
                    $("#venue_description_edit").show();

                    $("#venue_show").hide();
                    $("#venue_edit").show();

                    $("#event_feedback_set_show").hide();
                    $("#event_feedback_set_edit").show();

                    $("#max_participant_show").hide();
                    $("#max_participant_edit").show();


                    $("#edit-basic").hide();
                    $("#save-basic").show();
                    $("#edit-basic-close").show();
                });

                $("#edit-basic-close").click(function(e) {
                    $("#name_show").show();
                    $("#name_edit").hide();

                    $("#event_type_show").show();
                    $("#event_type_edit").hide();


                    $("#is_modular_single_selection_show").show();
                    $("#is_modular_single_selection_edit").hide();


                    $("#modular_num_of_selection_min_show").show();
                    $("#modular_num_of_selection_min_edit").hide();


                    $("#modular_num_of_selection_max_show").show();
                    $("#modular_num_of_selection_max_edit").hide();

                    $("#datetime_start_show").show();
                    $("#datetime_start_edit").hide();

                    $("#datetime_end_show").show();
                    $("#datetime_end_edit").hide();

                    $("#venue_description_show").show();
                    $("#venue_description_edit").hide();

                    $("#venue_show").show();
                    $("#venue_edit").hide();

                    $("#event_feedback_set_show").show();
                    $("#event_feedback_set_edit").hide();

                    $("#max_participant_show").show();
                    $("#max_participant_edit").hide();


                    $("#edit-basic").show();
                    $("#save-basic").hide();
                    $("#edit-basic-close").hide();
                });

                // Selection Type
                {
                    $('#event_type').on('change', function(event) {
                        if (event.target.value == 1) {
                            $('#is_modular_single_selection_row').show();
                            $('#is_modular_single_selection').val('1'); // Select the option with a value of '1'
                            $('#is_modular_single_selection').trigger('change');
                        } else {
                            $('#is_modular_single_selection').val(null);
                            $('#is_modular_single_selection_row').hide();
                            $('#modular_num_of_selection_max_row').hide();
                            $('#modular_num_of_selection_min_row').hide();
                            $('#modular_num_of_selection_max').val(null);
                            $('#modular_num_of_selection_min').val(null);
                        }

                    });
                    $('#is_modular_single_selection').on('change', function(event) {
                        if (event.target.value == 1) {
                            $('#modular_num_of_selection_max_row').hide();
                            $('#modular_num_of_selection_min_row').hide();
                            $('#modular_num_of_selection_max').val(null);
                            $('#modular_num_of_selection_min').val(null);
                        } else {
                            $('#modular_num_of_selection_max_row').show();
                            $('#modular_num_of_selection_min_row').show();
                            $('#modular_num_of_selection_max').val(2);
                            $('#modular_num_of_selection_min').val(1);
                        }
                    });
                }

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
                $('#add-trainer').click(function() {
                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);
                    $('.modal-body #fullname').val(null);
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('#crud-modal-add-trainer').modal('show');
                });

                $('#crud-modal-add-trainer').on('show.bs.modal', function(event) {

                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);
                    $('#trainer_user_id').next(".select2-container").hide();
                    $('#trainer_user_id').prop('disabled', true);


                    $('#search-by-trainer_ic').show();
                });

                // search by trainer ic
                $('#search-by-trainer_ic').click(function() {
                    var trainer_ic = $('#trainer_ic_input').val();
                    $.get("/trainer/search-by-trainer_ic/" + trainer_ic, function(data) {
                        $("#trainer_user_id option[value='" + data.id + "']").attr("selected", "true");
                        $("#trainer_user_id_text").show();
                        $("#trainer_user_id_text").removeAttr('disabled');
                        $("#trainer_user_id").removeAttr('disabled');
                        $('#trainer_user_id').prop('disabled', false);
                        $("#trainer_user_id").hide();
                        $("#trainer_user_id").attr('style', 'display: none');
                        // $("#trainer_user_id").removeClass('user');
                        $('#trainer_user_id').next(".select2-container").hide();


                        $("#trainer_user_id_text").val(data.id);
                        $('#trainer_fullname').val(data.name);

                        if (data.trainer) {
                            $('#trainer_phone').val(data.trainer.phone);
                        } else {
                            $('#trainer_phone').val(data.contact_person.phone);
                        }
                        $('#trainer_email').val(data.email);

                    }).fail(
                        function() {
                            console.log('fail');
                            $('#trainer_ic').val(null);
                            $("#trainer_user_id_text").hide();
                            $("#trainer_user_id_text").attr('disabled');

                            $("#trainer_user_id").show();
                            $("#trainer_user_id").removeProp('style');
                            $("#trainer_user_id").removeAttr('disabled');
                            // $("#trainer_user_id").addClass('user');
                            $("#trainer_user_id").prop('disabled', false);
                            $('#trainer_user_id').next(".select2-container").show();

                            $("#trainer_user_id option[value='-1']").attr("selected", "true");
                            $("#trainer_user_id option[value='-1']").prop("selected", true);
                            $("#trainer_user_id").select2().val(-1).trigger("change");
                            $('#trainer_fullname').val(null);
                            $('#trainer_phone').val(null);
                            $('#trainer_email').val(null);
                            $('.user').select2({
                                dropdownParent: $('#crud-modal-add-trainer')
                            });
                        }).always(
                        function() {
                            $("div[id=form-add-trainer-second-part]").show();
                            $('#add_trainer_footer').show();
                        });

                });

                $('#trainer_ic_input').change(function() {

                    $("#trainer_user_id_text").hide();
                    $("#trainer_user_id_text").attr('disabled');

                    $("#trainer_user_id_text").val(null);
                    $('#trainer_fullname').val(null);
                    $('#trainer_phone').val(null);
                    $('#trainer_email').val(null);

                    $('#add_trainer_footer').hide();

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
                $('#add-shortcourse').click(function() {
                    var id = null;
                    var shortcourse_id = null;
                    $('.modal-body #id').val(id);
                    $('.modal-body #shortcourse_id').val(shortcourse_id);
                    $('.modal-body #objective').empty();
                    $('.modal-body #description').empty();
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

                        $('.shortcourse').select2({
                            dropdownParent: $(
                                '#crud-modal-add-shortcourse')
                        });
                        $('.modal-body #objective').append(data.objective);
                        $('.modal-body #description').append(data.description);

                    }).fail(
                        function() {
                            $('.modal-body #objective').empty();
                            $('.modal-body #description').empty();
                        }).always(
                        function() {
                            $("div[id=form-add-shortcourse-second-part]").show();
                        });

                });
            }

            // List of Contact Persons
            {
                // Add contact_person
                $('#add-contact_person').click(function() {
                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);
                    $('.modal-body #fullname').val(null);
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('#crud-modal-add-contact_person').modal('show');
                });

                $('#crud-modal-add-contact_person').on('show.bs.modal', function(event) {

                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);

                    $('#contact_person_user_id').next(".select2-container").hide();
                    $('#contact_person_user_id').prop('disabled', true);

                    $('#search-by-contact_person_ic').show();
                });

                // search by contact_person ic
                $('#search-by-contact_person_ic').click(function() {
                    var contact_person_ic = $('#contact_person_ic_input').val();
                    $.get("/contact_person/search-by-contact_person_ic/" + contact_person_ic, function(data) {
                        $("#contact_person_user_id option[value='" + data.id + "']").attr("selected",
                            "true");

                        $("#contact_person_user_id_text").show();
                        $("#contact_person_user_id_text").removeAttr('disabled');
                        $("#contact_person_user_id").removeAttr('disabled');
                        $('#contact_person_user_id').prop('disabled', false);

                        $("#contact_person_user_id").hide();
                        $("#contact_person_user_id").attr('style', 'display: none');
                        // $("#contact_person_user_id").removeClass('user');
                        $('#contact_person_user_id').next(".select2-container").hide();

                        $("#contact_person_user_id_text").val(data.id);
                        $('#contact_person_fullname').val(data.name);

                        if (data.contact_person) {
                            $('#contact_person_phone').val(data.contact_person.phone);
                            $('#contact_person_email').val(data.contact_person.email);
                        } else {
                            $('#contact_person_phone').val(data.trainer.phone);
                            $('#contact_person_email').val(data.trainer.email);
                        }


                    }).fail(
                        function() {
                            console.log('fail');
                            $('#contact_person_ic').val(null);
                            $("#contact_person_user_id_text").hide();
                            $("#contact_person_user_id_text").attr('disabled');

                            $("#contact_person_user_id").show();
                            $("#contact_person_user_id").removeProp('style');
                            $("#contact_person_user_id").removeAttr('disabled');

                            $("#contact_person_user_id").prop('disabled', false);
                            $('#contact_person_user_id').next(".select2-container").show();

                            $("#contact_person_user_id option[value='-1']").attr("selected", "true");
                            $("#contact_person_user_id option[value='-1']").prop("selected", true);
                            $("#contact_person_user_id").select2().val(-1).trigger("change");
                            $('#contact_person_fullname').val(null);
                            $('#contact_person_phone').val(null);
                            $('#contact_person_email').val(null);
                            $('.user').select2({
                                dropdownParent: $('#crud-modal-add-contact_person')
                            });
                        }).always(
                        function() {
                            $("div[id=form-add-contact_person-second-part]").show();
                            $('#add_contact_person_footer').show();
                        });

                });

                $('#contact_person_ic_input').change(function() {

                    $("#contact_person_user_id_text").hide();
                    $("#contact_person_user_id_text").attr('disabled');

                    $("#contact_person_user_id_text").val(null);
                    $('#contact_person_fullname').val(null);
                    $('#contact_person_phone').val(null);
                    $('#contact_person_email').val(null);

                    $('#add_contact_person_footer').hide();

                    $('#search-by-contact_person_ic').trigger("click");


                });

                // User_ID information
                $('#contact_person_user_id').change(function(event) {
                    var contact_person_fullname = $('#contact_person_user_id').find(":selected").attr('name');
                    var contact_person_user_id = $('#contact_person_user_id').find(":selected").val();

                    var users = @json($users);

                    var selected_user = users.find((x) => {
                        return x.id == contact_person_user_id;
                    });
                    if (selected_user) {
                        $('#contact_person_fullname').val(selected_user.name);
                        $('#contact_person_email').val(selected_user.email);
                    } else {
                        $('#contact_person_fullname').val(null);
                        $('#contact_person_email').val(null);
                    }
                });

                // search by contact_person user_id
                $('#search-by-user_id').click(function() {
                    var user_id = $('.modal-body #user_id').val();
                    $.get("/contact_person/search-by-user_id/" + user_id, function(data) {
                        $('.modal-body #contact_person_id').val(data.contact_person.id);
                        $('.modal-body #fullname').val(data.name);
                        $('.modal-body #phone').val(data.contact_person.phone);
                        $('.modal-body #email').val(data.email);

                    }).fail(
                        function() {
                            $('.modal-body #contact_person_id').val(null);
                            $('.modal-body #fullname').val(null);
                            $('.modal-body #phone').val(null);
                            $('.modal-body #email').val(null);
                        }).always(
                        function() {
                            $("div[id=form-add-contact_person-second-part]").show();
                        });

                });
            }


            // Edit Module Modal
            {
                $('#edit-module-modal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id');
                    var name = button.data('name');
                    var amount = button.data('fee_amount');

                    $('.modal-body #module_id').val(id);
                    $('.modal-body #module_name').val(name);
                    $('.modal-body #module_fee_amount').val(amount);
                });
            }
            var i = 1;
            $('#addModule').click(function() {
                i++;
                $('#module_field tbody').after(`
                            <tr id="new-row">
                                <td>
                                    <input id="add_module" name="event_module" type="text" class="form-control" placeholder="Insert Module Name">
                                </td>

                                <td>
                                    <input id="module_fee_amount" name="module_fee_amount" type="text" class="form-control" value='0.00'>
                                </td>
                                <td>
                                    0
                                </td>
                                <td class="d-flex flex-row-reverse ">
                                    <a href="javascript:;" name="cancel-module" id="cancel-module" class="btn btn-sm btn-danger btn_remove mx-1">X</a>
                                    <a
                                        href="javascript:;"
                                        class="btn btn-sm btn-success mx-1"
                                        name="save-module" id="save-module">
                                        <i class="fal fa-save"></i>
                                    </a>
                                </td>
                            </tr>
                    `);
                $(`.module${i}`).select2();
                $('#addModule').hide();

                $(document).on('click', '#cancel-module', function() {
                    $('#new-row').remove();
                    $("#addModule").show();
                });


                $(document).on('click', '#save-module', function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var $shortcourse_module = $('#add_module').val();

                    var $module_fee_amount = $('#module_fee_amount').val();
                    var data = {
                        shortcourse_module: $shortcourse_module,
                        module_fee_amount: $module_fee_amount
                    }
                    var url = '/event/module/attached/' + event_id;

                    $.post(url, data).done(function() {
                            window.location.reload();
                        })
                        .fail(function() {
                            $('#new-row').show();
                            $("#addModule").remove();
                            alert('Unable to add module');
                        });
                });
            });

        }

        // Delete Event
        {

            var event_name = '<?php echo $event->name; ?>';
            $('#delete_event').on('click',
                function(e) {

                    const tag = $(e.currentTarget);

                    const title = "Delete Event";
                    const text = `Are you sure you want to delete '${event_name}'?`;
                    const confirmButtonText = "Delete";
                    const cancelButtonText = "Cancel";
                    const url = "/event/delete/" + event_id;
                    const urlRedirect = "/events";

                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
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
                            }).then((result) => {
                                $(location).prop('href', urlRedirect);
                            });

                        }
                    })
                });
        }

        // Additional Info
        {
            ClassicEditor
                .create(document.querySelector('#editor_description'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#editor_target_audience'))
                .catch(error => {
                    console.error(error);
                });

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

        }
    </script>
@endsection

@section('style')
@endsection
