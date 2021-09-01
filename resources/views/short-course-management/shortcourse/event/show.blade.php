@extends('layouts.shortcourse_portal')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        {{-- <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Public View (Details)
            </h1>
        </div> --}}
        <div class="row">
            <div class="col-xl-12">
                {{-- Start Update Form --}}

                @if (Session::has('successNewApplication'))
                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;width:100%;">
                        <i class="icon fal fa-check-circle"></i>
                        {{ Session::get('successNewApplication') }}
                    </div>
                @endif

                @if (Session::has('failedNewApplication'))
                    <div class="alert alert-danger" style="color: #5b0303; background-color: #ff6c6cc9;">
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
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row row-md-12">
                            <div class="col-sm-6">
                                {{-- <div class="d-flex justify-content-center">
                                    <img src="/get-file-event/intec_poster.jpg" class="card-img" alt="..."
                                            style="width:137px;height:194px;">
                                    <img src="{{ URL::to('/') }}/img/system/intec_poster.jpg" class="card-img" alt="..."
                                        style="object-fit: fill;">
                                    @if (!isset($event->thumbnail_path))
                                        <img src="{{ asset('storage/shortcourse/poster/default/intec_poster.jpg') }}"
                                            class="card-img" style="object-fit: fill;">
                                    @else
                                        <img src="{{ asset($event->thumbnail_path) }}" style="object-fit: fill;
                                                                                background-image:url('{{ asset('storage /shortcourse/poster/default/intec_poster.jpg') }}');
                                                                                background-repeat: no-repeat;
                                                                                background-size: 137px 194px;">
                                    @endif
                                </div> --}}

                                <div class="d-flex justify-content-center">
                                    @if (!isset($event->thumbnail_path))
                                        <img src="{{ asset('storage/shortcourse/poster/default/intec_poster.jpg') }}"
                                            class="card-img" style="object-fit: fill;">
                                    @else
                                        <img src="{{ asset($event->thumbnail_path) }}" class="card-img"
                                            style="object-fit: fill;">
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <h1 class="text-center">
                                                <b class="semi-bold">{{ $event->name }}</b>
                                            </h1>
                                        </div>
                                        <hr class="mt-2 mb-1">
                                        <div class="row">
                                            <div class="col">
                                                <b>Fee</b>
                                            </div>
                                            <div class="col">
                                                @php($index = 0)
                                                |
                                                @foreach ($event->fees as $fee)
                                                    @if ($fee->is_base_fee == 1)
                                                        RM{{ $fee->amount }}/person ({{ $fee->name }}) |
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr class="mt-1 mb-1">
                                        <div class="row">
                                            <div class="col">
                                                <b>Seat Availability</b>
                                            </div>
                                            <div class="col">
                                                {{ $event->total_seat_available }} over {{ $event->max_participant }}
                                                Seats
                                            </div>
                                        </div>
                                        <hr class="mt-1 mb-1">
                                        <div class="row">
                                            <div class="col">
                                                <b>From</b>
                                            </div>
                                            <div class="col">
                                                {{ Carbon\Carbon::parse($event->datetime_start)->toDayDateTimeString() }}
                                            </div>
                                        </div>
                                        <hr class="mt-1 mb-1">
                                        <div class="row">
                                            <div class="col">
                                                <b>To</b>
                                            </div>
                                            <div class="col">
                                                {{ Carbon\Carbon::parse($event->datetime_end)->toDayDateTimeString() }}
                                            </div>
                                        </div>
                                        <hr class="mt-1 mb-1">
                                        <div class="row">
                                            <div class="col">
                                                <b>Venue</b>
                                            </div>
                                            <div class="col">
                                                {{ $event->venue->name }}
                                            </div>
                                        </div>
                                        <hr class="mt-1 mb-2">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <button href="javascript:;" id="new-application"
                                                class="btn btn-sm btn-primary btn btn-block call-to-action"
                                                {{ $event->total_seat_available == 0 ? 'disabled' : null }}>Apply
                                                now!</button>
                                        </div>
                                        <div class="modal fade" id="crud-modal-new-application" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="card-header">
                                                        <h5 class="card-title w-150">Application</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ url('/event/' . $event->id . '/events-participants/store') }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            {{-- {!! Form::open(['action' => 'ShortCourseManagement\EventManagement\EventParticipantController@store', 'method' => 'POST']) !!} --}}
                                                            {{-- <input type="hidden" name="id"
                                                                    id="id"> --}}
                                                            <p><span class="text-danger">*</span>
                                                                Required Field</p>
                                                            <hr class="mt-1 mb-2">
                                                            <div class="form-group">
                                                                <label for="ic"><span class="text-danger">*</span>
                                                                    IC</label>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <input class="form-control" id="ic_input"
                                                                            name="ic_input">
                                                                    </div>
                                                                    <td class="col col-sm-1">
                                                                        <a href="javascript:;" data-toggle="#"
                                                                            id="search-by-ic" class="btn btn-primary mb-2"
                                                                            hidden><i class="ni ni-magnifier"></i></a>

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
                                                            <div id="form-application-second-part">

                                                                <div class="alert alert-primary d-flex justify-content-center"
                                                                    style="color: #ffffff; background-color: #2c0549;width:100%;"
                                                                    id="application_message">
                                                                    Applicant Details
                                                                </div>

                                                                <hr class="mt-1 mb-2">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="fullname"><span
                                                                            class="text-danger">*</span>Fullname</label>
                                                                    <input class="form-control" id="fullname"
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
                                                                    <label class="form-label" for="phone"><span
                                                                            class="text-danger">*</span>Phone</label>
                                                                    <input class="form-control" id="phone" name="phone">
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
                                                                    <input class="form-control" id="email" name="email">
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
                                                                        for="payment_proof_input"><span
                                                                            class="text-danger">*</span>Payment
                                                                        Proof</label>
                                                                    <div class="custom-file px-2 d-flex flex-column">
                                                                        <input type="file" class="custom-file-label"
                                                                            name="payment_proof_input[]"
                                                                            accept="image/png, image/jpeg" multiple="" />
                                                                    </div>
                                                                    @error('payment_proof_input')
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
                                                                    <select class="form-control fee_id font-weight-bold"
                                                                        name="fee_id" id="fee_id" tabindex="-1"
                                                                        aria-hidden="true" hidden>
                                                                        <option disabled selected>Select
                                                                            Fee
                                                                            Applied</option>
                                                                        @foreach ($event->fees as $fee)
                                                                            <option value="{{ $fee->id }}">
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
                                                                                id="fee_id_show" name="fee_id_show"
                                                                                style="display:none; width:auto">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"
                                                                                        style="background-color:white; border-style: none;"
                                                                                        id="addon-wrapping">RM</span>
                                                                                </div>
                                                                                <input class="form-control-plaintext"
                                                                                    id="fee_id_input" name="fee_id_input"
                                                                                    readonly>
                                                                                <div class="input-group-append">
                                                                                    <span
                                                                                        style="background-color:white; border-style: none;"
                                                                                        class="input-group-text">/
                                                                                        person</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-7" id="promo_code_col"
                                                                            style="display:none">
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <input class="form-control"
                                                                                        id="promo_code" name="promo_code"
                                                                                        placeholder="Promo Code (Only if applicable)">
                                                                                </div>
                                                                                <td class="col col-sm-1">
                                                                                    <button type="button" name="remove"
                                                                                        id="promo_code_edit_remove"
                                                                                        class="btn btn-danger btn_remove"
                                                                                        style="display:none">
                                                                                        <i class="ni ni-close"></i>
                                                                                    </button>
                                                                                    <button type="button" name="add"
                                                                                        id="promo_code_edit_add"
                                                                                        class="btn btn-primary btn_add">
                                                                                        <i class="ni ni-check"></i>
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
                                                                <div class="custom-control custom-checkbox">
                                                                    {{-- <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="represent-by-himself_show"
                                                                            checked="checked"
                                                                            disabled> --}}
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="represent-by-himself" checked="checked"
                                                                        type="hidden">
                                                                    {{-- <label
                                                                            class="custom-control-label"
                                                                            for="represent-by-himself">Represent
                                                                            By Himself</label> --}}
                                                                </div>
                                                                <div id="representative" style="display:none">
                                                                    <hr class="mt-1 mb-2">
                                                                    <div class="form-group">
                                                                        <label for="representative-ic"><span
                                                                                class="text-danger">*</span>
                                                                            Representative
                                                                            IC</label>
                                                                        <div class="form-inline" style="width:100%">
                                                                            <div class="form-group mr-2 mb-2"
                                                                                style="width:85%">
                                                                                <input class="form-control w-100"
                                                                                    id="representative_ic_input"
                                                                                    name="representative_ic_input">
                                                                            </div>
                                                                            <a href="javascript:;" data-toggle="#"
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
                                                                            <label class="form-label"
                                                                                for="representative_fullname"><span
                                                                                    class="text-danger">*</span>Representative
                                                                                Fullname</label>
                                                                            <input id="representative_fullname"
                                                                                name="representative_fullname"
                                                                                class="form-control" readonly>
                                                                            @error('representative_fullname')
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
                                                            <div class="footer" id="new_application_footer"
                                                                style="display:none">
                                                                <button type="button"
                                                                    class="btn btn-danger ml-auto float-right mr-2"
                                                                    data-dismiss="modal" id="close-new-application"><i
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
                                </div>
                                <hr class="mt-2 mb-2">
                                <span><em>For any inquries, please contact :-</em></span>
                                <div class="row">
                                    @foreach ($event->events_contact_persons as $event_contact_person)
                                        <div class="col-sm-6 my-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <b>{{ $event_contact_person->contact_person->user->name }}</b>
                                                    <hr class="mt-1 mb-1">
                                                    <table class="table table-borderless table-hover"
                                                        style="margin-bottom: 0rem">
                                                        <tbody>
                                                            <tr>
                                                                <td><i class="ni ni-call-end"></i></td>
                                                                <td>{{ $event_contact_person->contact_person->phone }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><i class="ni ni-envelope"></i></td>
                                                                <td>{{ $event_contact_person->contact_person->user->email }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    {{-- <div class="row">
                                                        <div class="col-sm-2"><i class="ni ni-call-end"></i>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            {{ $event_contact_person->contact_person->phone }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2"><i class="ni ni-envelope"></i>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            {{ $event_contact_person->contact_person->user->email }}
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="mt-2 mb-2">

                                {{-- <div class="row">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="heading text-iceps-blue">
                                                Description
                                            </h5>

                                            {{ $event->description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="heading text-iceps-blue">
                                                Who should attend?
                                            </h5>
                                            {{ $event->target_audience }}
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                        </div>

                        <div class="panel panel-default">
                            <div class="row">
                                <div class="col">
                                    <div class="p-5">
                                        <h1>Description</h1>

                                        {!! $event->description !!}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="p-5">
                                        <h1> Who should attend?</h1>
                                        {!! $event->target_audience !!}
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-tabs nav-tabs-clean" style="padding: 0 15px 0 15px;" role="tablist">
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link active" href="#objective" role="tab">Objective</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#outline" role="tab">Outline</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#tentative" role="tab">Tentative</a>
                                </li>
                            </ul>
                            <div class="tab-content col-md-12 p-5">
                                <div class="tab-pane active" id="objective" role="tabpanel">
                                    {!! $event->objective !!}
                                </div>
                                <div class="tab-pane" id="outline" role="tabpanel">
                                    {!! $event->outline !!}
                                </div>
                                <div class="tab-pane" id="tentative" role="tabpanel">
                                    {!! $event->tentative !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- End Update Form --}}





            </div>
        </div>
    </main>

@endsection

@section('script')
    <script>
        var event_id = '<?php echo $event->id; ?>';
        //New Application
        $(document).ready(function() {
            //New Application
            {
                $('#new-application').click(function() {
                    var ic = null;
                    $('.modal-body #ic_input').val(ic);

                    // $("div[id=form-application-second-part]").hide();
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
                            $('.modal-body #payment_proof_input').attr('readonly', true);

                            $('.modal-body #promo_code').attr('readonly', true);

                            $('#promo_code_edit_add').hide();
                            $('#promo_code_edit_remove').hide();

                            $('.modal-body #application_update_submit').hide();

                            $('.modal-body #application_message').append(
                                'Already Apply');

                        } else {
                            // TODO: Not Apply Yet
                            $('.modal-body #fullname').removeAttr('readonly', true);
                            $('.modal-body #phone').removeAttr('readonly', true);
                            $('.modal-body #payment_proof_input').removeAttr('readonly', true);
                            $('.modal-body #email').removeAttr('readonly', true);
                            $('.modal-body #application_update_submit').show();
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
                            $('.modal-body #payment_proof_input').val(null);

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
                            } else {
                                $('.modal-body #promo_code').removeAttr('readonly');
                                $('#promo_code_edit_add').show();
                                $('#promo_code_edit_remove').hide();
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
                                $('.modal-body #representative_fullname').val(data.participant
                                    .name);
                            }
                        }

                    }).fail(
                        function() {
                            $('.modal-body #fullname').val(null);
                            $('.modal-body #phone').val(null);
                            $('.modal-body #email').val(null);
                            $('.modal-body #payment_proof_input').val(null);


                            $("select[id=fee_id]").hide();
                            $("div[id=fee_id_show]").show();

                            if ($('#represent-by-himself:checked').length > 0) {
                                $('.modal-body #representative_ic_input').val(ic);
                                $('.modal-body #representative_fullname').val(null);
                            }

                            $('.modal-body #application_update_submit').show();
                            $('.modal-body #application_update_submit').append(
                                '<i class = "ni ni-plus"></i> Apply');
                        }).always(
                        function() {
                            $("div[id=form-application-second-part]").show();
                            $("#new_application_footer").show();

                        });
                });

                // promo_code_edit_add
                $('#promo_code_edit_add').click(function() {
                    var promo_code = $('.modal-body #promo_code').val();
                    $.get("/event/" + event_id + "/promo-code/" + promo_code + "/participant", function(
                        data) {
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
                    $('.modal-body #payment_proof_input').val(null);
                    $('.modal-body #email').val(null);
                    $('.modal-body #representative_ic_input').val(ic_input);
                    $('.modal-body #representative_fullname').val(null);
                    // $("div[id=form-application-second-part]").hide();
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
                    $('.modal-body #payment_proof_input').val(null);
                    $('.modal-body #email').val(null);
                });
            }
        });
    </script>
@endsection
