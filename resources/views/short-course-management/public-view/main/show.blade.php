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
                <div id="panel-1" class="panel">
                    <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                        <h2>
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

                        <div class="hidden-sm hidden-xs">
                            <div style="position:relative;background-color:#67338f;height:100%;max-height:108px;width:50%;">
                            </div>
                            <img src="https://iceps-apps.uitm.edu.my/img/banner-iceps.png"
                                style="position:relative;width:100%;">
                        </div>
                        <div class="panel-content">
                            <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;">
                            </center>
                            <br>
                            <h4 style="text-align: center">
                                <b>INTEC EDUCATION COLLEGE ACADEMIC TEAM</b>
                            </h4>
                            <div>
                                {{-- <p style="padding-left: 40px; padding-right: 40px" align="center">
                                    *<i><b>IMPORTANT!</b></i> : All staff are required to fill in the vaccination survey for
                                    the purpose of data collection. This survey can be updated anytime if there are any
                                    information changed.
                                </p> --}}
                            </div>
                            <hr class="mt-2 mb-2">
                            <h1 class="text-center heading text-iceps-blue">
                                Short Course - <b class="semi-bold">{{ $event->name }}</b>
                            </h1>
                            <hr class="mt-2 mb-2">
                            {{-- Start Update Form --}}
                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="card">
                                                <div class="card-header">Poster</div>
                                                <div class="card-body">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="card">
                                                <div class="card-header">General Information</div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <b>Cost</b>
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
                                                            {{ $event->max_participant }} Seats
                                                        </div>
                                                    </div>
                                                    <hr class="mt-1 mb-1">
                                                    <div class="row">
                                                        <div class="col">
                                                            <b>Event Date Start</b>
                                                        </div>
                                                        <div class="col">
                                                            {{ $event->datetime_start }}
                                                        </div>
                                                    </div>
                                                    <hr class="mt-1 mb-1">
                                                    <div class="row">
                                                        <div class="col">
                                                            <b>Event Date End</b>
                                                        </div>
                                                        <div class="col">
                                                            {{ $event->datetime_end }}
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
                                                    <hr class="mt-1 mb-1">
                                                    <a href="javascript:;" id="new-application"
                                                        class="btn btn-sm btn-primary btn btn-block">Register</a>
                                                    <div class="modal fade" id="crud-modal-new-application"
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
                                                                        {{-- {!! Form::open(['action' => 'ShortCourseManagement\EventManagement\EventParticipantController@store', 'method' => 'POST']) !!} --}}
                                                                        {{-- <input type="hidden" name="id"
                                                                                id="id"> --}}
                                                                        <p><span class="text-danger">*</span>
                                                                            Vital Information</p>
                                                                        <hr class="mt-1 mb-2">
                                                                        <div class="form-group">
                                                                            <label for="ic"><span
                                                                                    class="text-danger">*</span>
                                                                                IC</label>
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <input class="form-control"
                                                                                        id="ic_input" name="ic_input">
                                                                                </div>
                                                                                <td class="col col-sm-1">
                                                                                    <a href="javascript:;" data-toggle="#"
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
                                                                                <input class="form-control" id="phone"
                                                                                    name="phone">
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
                                                                                <input class="form-control" id="email"
                                                                                    name="email">
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
                                                                                    name="fee_id" id="fee_id" tabindex="-1"
                                                                                    aria-hidden="true">
                                                                                    <option disabled selected>Select Fee
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
                                                                                            <div class="input-group-append">
                                                                                                <span
                                                                                                    style="background-color:white; border-style: none;"
                                                                                                    class="input-group-text">/
                                                                                                    person</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-7">
                                                                                        <div class="row">
                                                                                            <div class="col">
                                                                                                <input class="form-control"
                                                                                                    id="promo_code"
                                                                                                    name="promo_code"
                                                                                                    placeholder="Promo Code (Only if applicable)">
                                                                                            </div>
                                                                                            <td class="col col-sm-1">
                                                                                                <button type="button"
                                                                                                    name="remove"
                                                                                                    id="promo_code_edit_remove"
                                                                                                    class="btn btn-danger btn_remove"
                                                                                                    style="display:none">
                                                                                                    <i
                                                                                                        class="ni ni-close"></i>
                                                                                                </button>
                                                                                                <button type="button"
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
                                                                            <div class="custom-control custom-checkbox">
                                                                                {{-- <input type="checkbox"
                                                                                        class="custom-control-input"
                                                                                        id="represent-by-himself_show"
                                                                                        checked="checked"
                                                                                        disabled> --}}
                                                                                <input type="checkbox"
                                                                                    class="custom-control-input"
                                                                                    id="represent-by-himself"
                                                                                    checked="checked" type="hidden">
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

                                                                    {{-- {!! Form::close() !!} --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="row">
                                        <div class="col">

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="heading text-iceps-blue">
                                                                        Description
                                                                    </h5>

                                                                    {{ $event->description }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="heading text-iceps-blue">
                                                                        Who should attend?
                                                                    </h5>
                                                                    {{ $event->target_audience }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr class="mt-2 mb-2">
                                                    <div class="panel-container show">
                                                        <div class="panel-content">
                                                            <ul class="nav nav-pills" role="tablist">
                                                                <li class="nav-item">
                                                                    <a data-toggle="tab" class="nav-link active"
                                                                        href="#objective" role="tab">Objective</a>

                                                                </li>
                                                                <li class="nav-item">
                                                                    <a data-toggle="tab" class="nav-link" href="#outline"
                                                                        role="tab">Outline</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a data-toggle="tab" class="nav-link" href="#tentative"
                                                                        role="tab">tentative</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content col-md-12 mt-3">
                                                                <div class="tab-pane active" id="objective" role="tabpanel">
                                                                    {{ $event->objective }}
                                                                </div>
                                                                <div class="tab-pane" id="outline" role="tabpanel">
                                                                    Outline
                                                                </div>
                                                                <div class="tab-pane" id="tentative" role="tabpanel">
                                                                    Tentative
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
                            {{-- End Update Form --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')
    <script>
        var event_id = '<?php echo $event->id; ?>'; {
            $('#new-application').click(function() {
                // var id = null;
                var ic = null;
                // $('.modal-body #id').val(id);
                $('.modal-body #ic_input').val(ic);

                $("div[id=form-application-second-part]").hide();
                $('#crud-modal-new-application').modal('show');
            });

            $('#crud-modal-new-application').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                // var id = button.data('id');
                var ic = button.data('ic');

                // $('.modal-body #id').val(id);
                $('.modal-body #ic_input').val(ic);
            });

            $('#search-by-ic').click(function() {
                var ic = $('.modal-body #ic_input').val();
                $.get("/participant/search-by-ic/" + ic + "/event/" + event_id, function(data) {
                    $('.modal-body #fullname').val(data.participant.name);
                    $('.modal-body #phone').val(data.participant.phone);
                    $('.modal-body #email').val(data.participant.email);
                    if (data.fee_id) {
                        $("select[id=fee_id]").val(data.fee_id);
                        $('.modal-body #promo_code').val(data.fee.promo_code);
                        $("input[id=fee_id_input]").val(data.fee.amount);
                        $("select[id=fee_id]").hide();
                        $("div[id=fee_id_show]").show();
                        if (data.fee.promo_code) {
                            $('.modal-body #promo_code').attr('readonly');
                            $('#promo_code_edit_add').hide();
                            $('#promo_code_edit_remove').show();
                        }

                    } else {
                        $("select[id=fee_id]").show();
                        $("div[id=fee_id_show]").hide();
                    }
                    if ($('#represent-by-himself:checked').length > 0) {
                        $('.modal-body #representative_ic_input').val(ic);
                        $('.modal-body #representative_fullname').val(data.participant.name);
                    }
                }).fail(
                    function() {
                        $('.modal-body #fullname').val(null);
                        $('.modal-body #phone').val(null);
                        $('.modal-body #email').val(null);

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
                        $('.modal-body #promo_code').attr('readonly');
                        $("select[id=fee_id]").val(data.fee_id);

                    } else {
                        $('.modal-body #promo_code').val(null);
                    }
                }).fail(
                    function() {
                        // TODO: The code is not valid
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
    </script>
@endsection
