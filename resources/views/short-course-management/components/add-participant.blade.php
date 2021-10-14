<head>
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<div class="modal fade" id="crud-modal-new-application" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card-header">
                <h5 class="card-title w-150">
                    Application
                </h5>
            </div>
            <div class="modal-body">
                <form action="{{ url('/event/' . $event->id . '/events-participants/store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <p><span class="text-danger">*</span>
                        Required Field</p>
                    <hr class="mt-1 mb-2">
                    <div class="form-group">
                        <label for="ic"><span class="text-danger">*</span>
                            IC</label>
                        <div class="row">
                            <div class="col">
                                <input class="form-control" id="ic_input" name="ic_input">
                            </div>
                            <td class="col col-sm-1">
                                <a href="javascript:;" data-toggle="#" id="search-by-ic" class="btn btn-primary mb-2"
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
                            style="color: #ffffff; background-color: #2c0549;width:100%;" id="application_message">
                            Applicant Details
                        </div>

                        <input type="hidden" id="input_type" name="input_type">
                        <hr class="mt-1 mb-2">
                        <div class="form-group">
                            <label class="form-label" for="firstname"><span class="text-danger">*</span>First
                                Name</label>
                            <input class="form-control" id="firstname" name="firstname">
                            @error('firstname')
                                <p style="color: red">
                                    <strong> *
                                        {{ $message }}
                                    </strong>
                                </p>
                            @enderror
                        </div>
                        <hr class="mt-1 mb-2">
                        <div class="form-group">
                            <label class="form-label" for="lastname"><span class="text-danger">*</span>Last
                                Name</label>
                            <input class="form-control" id="lastname" name="lastname">
                            @error('lastname')
                                <p style="color: red">
                                    <strong> *
                                        {{ $message }}
                                    </strong>
                                </p>
                            @enderror
                        </div>

                        <hr class="mt-1 mb-2">
                        <div class="form-group">
                            <label class="form-label" for="fullname"><span class="text-danger">*</span>Full
                                Name</label>
                            <input class="form-control" id="fullname" name="fullname" readonly>
                            @error('fullname')
                                <p style="color: red">
                                    <strong> *
                                        {{ $message }}
                                    </strong>
                                </p>
                            @enderror
                        </div>
                        <hr class="mt-1 mb-2">
                        {{-- <div class="input-group-prepend"> --}}

                        <div class="form-group">
                            <label class="form-label" for="gender"><span
                                    class="text-danger">*</span>Gender</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="male" name="gender" value="M"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="male">Male</label>
                                    </div>
                                </div>
                                <div class="input-group-text">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="female" name="gender" value="F"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-1 mb-2">
                        <div class="form-group">
                            <label class="form-label" for="phone"><span class="text-danger">*</span>Phone (e.g.:
                                +60134567891)</label>
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
                            <label class="form-label" for="email"><span class="text-danger">*</span>Email</label>
                            <input class="form-control" id="email" name="email">
                            @error('email')
                                <p style="color: red">
                                    <strong> *
                                        {{ $message }}
                                    </strong>
                                </p>
                            @enderror
                        </div>

                        <div class="form-group" id="modular_form" style="display:none">

                            <input id="is_modular" name="is_modular" type="number" value={{ $event->is_modular }}
                                hidden>
                            <input id="is_modular_single_selection" name="is_modular_single_selection" type="number"
                                hidden
                                value={{ !is_null($event->is_modular_single_selection) ? $event->is_modular_single_selection : '' }}>
                            <input id="modular_num_of_selection_min" name="modular_num_of_selection_min" type="number"
                                hidden
                                value={{ !is_null($event->modular_num_of_selection_min) ? $event->modular_num_of_selection_min : '' }}>
                            <input id="modular_num_of_selection_max" name="modular_num_of_selection_max" type="number"
                                hidden
                                value={{ !is_null($event->modular_num_of_selection_max) ? $event->modular_num_of_selection_max : '' }}>
                            <div class="form-group add-participant__module"
                                {{ $event->is_modular == 1 ? '' : 'style=display:none' }}>
                                <hr class="mt-1 mb-2">

                                @if ($event->is_modular_single_selection == 0)

                                    <label class="form-label" for="modules"><span
                                            class="text-danger">*</span>Modules
                                        <small>(You may choose
                                            {{ $event->modular_num_of_selection_min == $event->modular_num_of_selection_max ? '' : $event->modular_num_of_selection_min . ' to ' }}
                                            {{ $event->modular_num_of_selection_max }} modules
                                            only)</small></label>
                                    @foreach ($event->event_modules as $event_module)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input module-limiter"
                                                id="module-{{ $event_module->id }}" name="modules[]"
                                                value={{ $event_module->id }}
                                                data-fee_amount="{{ $event_module->fee_amount }}">
                                            <label class="custom-control-label"
                                                for="module-{{ $event_module->id }}">{{ $event_module->name }}
                                                (+RM{{ $event_module->fee_amount }})</label>
                                        </div>
                                    @endforeach
                                @else
                                    <label class="form-label" for="modules"><span
                                            class="text-danger">*</span>Modules
                                        <small>(You may choose a module
                                            only)</small></label>
                                    @foreach ($event->event_modules as $event_module)
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" class="custom-control-input"
                                                id="module-{{ $event_module->id }}" name="modules[]"
                                                value={{ $event_module->id }}
                                                data-fee_amount="{{ $event_module->fee_amount }}">
                                            <label class="custom-control-label"
                                                for="module-{{ $event_module->id }}">{{ $event_module->name }}
                                                (+RM{{ $event_module->fee_amount }})</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <hr class="mt-1 mb-2">
                        <div class="form-group" id="fee_form" style="display:none">
                            <label class="form-label" for="is_base_fee_select_add"><span
                                    class="text-danger">*</span>Base Fee</label>
                            <select class="form-control fee_id font-weight-bold" name="fee_id" id="fee_id" tabindex="-1"
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
                                    <div class="input-group flex-nowrap" id="fee_id_show" name="fee_id_show"
                                        style="display:none; width:auto">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                style="background-color:white; border-style: none;"
                                                id="addon-wrapping">RM</span>
                                        </div>
                                        <input type="number" class="form-control-plaintext" id="fee_id_input"
                                            name="fee_id_input" readonly>
                                        <div class="input-group-append">
                                            <span style="background-color:white; border-style: none;"
                                                class="input-group-text">/
                                                person</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7" id="promo_code_col" style="display:none">
                                    <div class="row">
                                        <div class="col">
                                            <input class="form-control" id="promo_code" name="promo_code"
                                                placeholder="Promo Code (Only if applicable)">
                                        </div>
                                        <td class="col col-sm-1">
                                            <button type="button" name="remove" id="promo_code_edit_remove"
                                                class="btn btn-danger btn_remove" style="display:none">
                                                <i class="ni ni-close"></i>
                                            </button>
                                            <button type="button" name="add" id="promo_code_edit_add"
                                                class="btn btn-primary btn_add">
                                                <i class="ni ni-check"></i>
                                            </button>
                                        </td>

                                    </div>
                                </div>
                            </div>

                            <hr class="mt-1 mb-2">
                            <label class="form-label" for="fee_amount_applied_total"><span
                                    class="text-danger">*</span>Total Fee (RM)</label>
                            <input id="fee_amount_applied_total" name="fee_amount_applied_total" type="number"
                                class="form-control" value='0.00' readonly>
                            @error('fee_id')
                                <p style="color: red">
                                    <strong> *
                                        {{ $message }}
                                    </strong>
                                </p>
                            @enderror

                            <hr class="mt-1 mb-2">
                            <div class="form-group" id="payment_proof_form">
                                <label class="form-label" for="payment_proof_input"><span
                                        class="text-danger">*</span>Payment
                                    Proof</label>
                                <div class="custom-file px-2 d-flex flex-column">
                                    <input type="file" class="custom-file-label" name="payment_proof_input[]"
                                        accept="image/png, image/jpeg" multiple="" id="payment_proof_input" />
                                </div>

                                @error('payment_proof_input')
                                    <p style="color: red">
                                        <strong> *
                                            {{ $message }}
                                        </strong>
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="custom-control custom-checkbox" style="display:none">
                            <input type="checkbox" class="custom-control-input" id="represent-by-himself"
                                checked="checked" type="hidden">
                        </div>
                        <div id="representative" style="display:none">
                            <hr class="mt-1 mb-2">
                            <div class="form-group">
                                <label for="representative-ic"><span class="text-danger">*</span>
                                    Representative
                                    IC</label>
                                <div class="form-inline" style="width:100%">
                                    <div class="form-group mr-2 mb-2" style="width:85%">
                                        <input class="form-control w-100" id="representative_ic_input"
                                            name="representative_ic_input">
                                    </div>
                                    <a href="javascript:;" data-toggle="#" id="search-by-representative-ic"
                                        class="btn btn-primary mb-2"><i class="ni ni-magnifier"></i></a>
                                </div>
                                @error('representative_ic_input')
                                    <p style="color: red">
                                        <strong> *
                                            {{ $message }}
                                        </strong>
                                    </p>
                                @enderror
                            </div>
                            <p id="representative-doesnt-exist" style="color: red; display:none;">
                                <strong> * The
                                    representative
                                    doesn't
                                    exist
                                </strong>
                            </p>
                            <p id="representative-doesnt-valid" style="color: red; display:none;">
                                <strong> * The
                                    choosen
                                    participant is
                                    not
                                    valid
                                    to represent
                                    others
                                </strong>
                            </p>
                            <div id="form-application-third-part" style="display: none">
                                <div class="form-group">
                                    <label class="form-label" for="representative_fullname"><span
                                            class="text-danger">*</span>Representative
                                        Fullname</label>
                                    <input id="representative_fullname" name="representative_fullname"
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
                    <div class="footer" id="new_application_footer">
                        <button type="button" class="btn btn-danger ml-auto float-right mr-2" data-dismiss="modal"
                            id="close-new-application"><i class="fal fa-window-close"></i>
                            Close</button>
                        <button type="submit" class="btn btn-success ml-auto float-right mr-2"
                            id="application_update_submit" style="display:none"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var edit;
    var event = @json($event);

    $(document).ready(function() {

        if (event.is_modular_single_selection == 0) {

            var checks = document.querySelectorAll(".module-limiter");
            var max = event.modular_num_of_selection_max;
            for (var i = 0; i < checks.length; i++) {
                checks[i].onclick = selectiveCheck;
            }

            function selectiveCheck(e) {
                var checkedChecks = document.querySelectorAll(".module-limiter:checked");
                if (checkedChecks.length >= max + 1) {

                    return false;
                }
            }
        }

        $('#crud-modal-new-application').on('show.bs.modal', function(event) {
            var ic = document.getElementById('ic_input').value;
            if (ic == "") {

                $('.modal-body #ic_input').attr('readonly', false);
            } else {

                $('.modal-body #ic_input').attr('readonly', true);
            }
        });


        $('#ic_input').change(function() {
            var ic_input = $('.modal-body #ic_input').val();
            $('.modal-body #firstname').val(null);
            $('.modal-body #lastname').val(null);
            $('.modal-body #fullname').val(null);
            document.getElementById("male").checked = false;
            document.getElementById("female").checked = false;
            $('.modal-body #phone').val(null);
            $('.modal-body #payment_proof_input').val(null);
            $('.modal-body #email').val(null);
            $('.modal-body #representative_ic_input').val(ic_input);
            $('.modal-body #representative_fullname').val(null);


            var event_modules_event_participants = $('[id^="module-"]');
            if (event_modules_event_participants) {
                for (var i = 0; i < event_modules_event_participants.length; i++) {
                    $('.modal-body #' + event_modules_event_participants.eq(i)[0].id)
                        .prop('checked', false);
                }
            }

            $('#search-by-ic').trigger("click");
        });


        $('#search-by-ic').click(function() {
            var ic = $('.modal-body #ic_input').val();
            $.get("/participant/search-by-ic/" + ic + "/event/" + event.id, function(data) {
                $('.modal-body #application_update_submit').empty();
                $('.modal-body #application_message').empty();
                if (data.id) {

                    $('#promo_code_edit_add').hide();
                    $('#promo_code_edit_remove').hide();

                    $('.modal-body #application_update_submit').hide();
                    if (data.event_modules_event_participants) {
                        data.event_modules_event_participants.forEach((x) => {
                            $('.modal-body #module-' + x.event_module_id)
                                .prop('checked', true);

                        });
                    }
                    if (edit) {
                        $('.modal-body #firstname').attr('readonly', false);
                        $('.modal-body #lastname').attr('readonly', false);
                        // $('.modal-body #fullname').attr('readonly', false);
                        $('.modal-body #gender').attr('readonly', false);

                        // document.getElementById("male").disabled = false;
                        // document.getElementById("female").disabled = false;
                        $('.modal-body #phone').attr('readonly', false);

                        $('.modal-body #email').attr('readonly', false);
                        $('.modal-body #payment_proof_input').attr('readonly', false);

                        $('.modal-body #promo_code').attr('readonly', false);

                        $('[id^="module-"]').attr('disabled', false);

                        $('.modal-body #application_update_submit').show();
                        $('.modal-body #application_update_submit').append(
                            '<i class = "ni ni-plus"></i> Edit');

                        $('.modal-body #application_message').append(
                            'Already Apply - Edit Details');
                    } else {

                        $('.modal-body #firstname').attr('readonly', true);
                        $('.modal-body #lastname').attr('readonly', true);
                        $('.modal-body #fullname').attr('readonly', true);
                        $('.modal-body #gender').attr('readonly', true);
                        // document.getElementById("male").disabled = true;
                        // document.getElementById("female").disabled = true;
                        $('.modal-body #phone').attr('readonly', true);

                        $('.modal-body #email').attr('readonly', true);
                        $('.modal-body #payment_proof_input').attr('readonly', true);

                        $('.modal-body #promo_code').attr('readonly', true);

                        $('[id^="module-"]').attr('disabled', true);


                        $('.modal-body #application_message').append(
                            'Already Apply');
                    }


                } else {
                    // TODO: Not Apply Yet
                    $('.modal-body #firstname').removeAttr('readonly', true);
                    $('.modal-body #lastname').removeAttr('readonly', true);
                    // $('.modal-body #fullname').removeAttr('readonly', true);
                    $('.modal-body #gender').removeAttr('readonly', true);
                    // document.getElementById("male").disabled = true;
                    //     document.getElementById("female").disabled = true;
                    $('.modal-body #phone').removeAttr('readonly', true);
                    $('.modal-body #payment_proof_input').removeAttr('readonly',
                        true);
                    $('.modal-body #email').removeAttr('readonly', true);


                    $('[id^="module-"]').removeAttr('disabled', true);

                    $('.modal-body #application_update_submit').show();
                    $('.modal-body #application_update_submit').append(
                        '<i class = "ni ni-plus"></i> Apply');
                    $('.modal-body #application_message').append(
                        'Make New Application');
                }

                if (data.participant) {
                    $('.modal-body #firstname').val(data.participant.firstname);
                    $('.modal-body #lastname').val(data.participant.lastname);
                    $('.modal-body #fullname').val(data.participant.name);
                    if (data.participant.gender == "M") {
                        document.getElementById("male").checked = true;
                        document.getElementById("female").checked = false;
                    } else if (data.participant.gender == "F") {
                        document.getElementById("male").checked = false;
                        document.getElementById("female").checked = true;
                    } else {
                        document.getElementById("male").checked = false;
                        document.getElementById("female").checked = false;
                    }
                    $('.modal-body #phone').val(data.participant.phone);
                    $('.modal-body #email').val(data.participant.email);
                } else {
                    $('.modal-body #firstname').val(null);
                    $('.modal-body #lastname').val(null);
                    $('.modal-body #fullname').val(null);
                    document.getElementById("male").checked = false;
                    document.getElementById("female").checked = false;
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('.modal-body #payment_proof_input').val(null);

                    var event_modules_event_participants = $('[id^="module-"]');
                    if (event_modules_event_participants) {
                        for (var i = 0; i < event_modules_event_participants.length; i++) {
                            $('.modal-body #' + event_modules_event_participants.eq(i)[0].id)
                                .prop('checked', false);
                        }
                    }

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

                    if (data.fee_amount_applied) {
                        $('#fee_amount_applied_total').val(data.fee_amount_applied);
                    } else {
                        $('#fee_amount_applied_total').val(data.fee.amount);
                    }

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
                        $('.modal-body #representative_fullname').val(data
                            .participant
                            .name);
                    }
                }

            }).fail(
                function() {
                    $('.modal-body #firstname').val(null);
                    $('.modal-body #lastname').val(null);
                    $('.modal-body #fullname').val(null);
                    document.getElementById("male").checked = false;
                    document.getElementById("female").checked = false;
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('.modal-body #payment_proof_input').val(null);

                    var event_modules_event_participants = $('[id^="module-"]');
                    if (event_modules_event_participants) {
                        for (var i = 0; i < event_modules_event_participants.length; i++) {
                            $('.modal-body #' + event_modules_event_participants.eq(i)[0].id)
                                .prop('checked', false);
                        }
                    }

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
                    $("#modular_form").show();
                    $("#fee_form").show();
                });
        });



        $('#promo_code_edit_add').click(function() {
            var promo_code = $('.modal-body #promo_code').val();
            $.get("/event/" + event.id + "/promo-code/" + promo_code + "/participant",
                function(
                    data) {
                    if (data.fee_id) {
                        // It is important for prevAmount assignment come before new value inserted
                        var prevAmount = $("input[id=fee_id_input]").val();

                        $("input[id=fee_id_input]").val(data.fee.amount);
                        $("select[id=fee_id]").hide();
                        $("div[id=fee_id_show]").show();
                        $('#promo_code_edit_add').hide();
                        $('#promo_code_edit_remove').show();
                        $('.modal-body #promo_code').attr('readonly', true);
                        $("select[id=fee_id]").val(data.fee_id);


                        var fee_amount_applied_total = $('#fee_amount_applied_total').val();
                        var sum = (parseFloat(fee_amount_applied_total) -
                                parseFloat(prevAmount)) +
                            parseFloat(data.fee.amount);
                        $('#fee_amount_applied_total').val(sum);

                    } else {
                        $('.modal-body #promo_code').val(null);
                    }
                }).fail(
                function() {
                    // TODO: The code is not valid
                    alert('The promo code is not valid.');
                });

        });

        // promo_code_edit_remove
        $('#promo_code_edit_remove').click(function() {
            $.get("/event/" + event.id + "/base-fee", function(data) {
                var promo_code = $('.modal-body #promo_code').val(null);
                if (data.fee_id) {
                    var prevAmount = $("input[id=fee_id_input]").val();
                    $("input[id=fee_id_input]").val(data.fee.amount);
                    $("select[id=fee_id]").hide();
                    $("div[id=fee_id_show]").show();
                    $('#promo_code_edit_add').show();
                    $('#promo_code_edit_remove').hide();
                    $('.modal-body #promo_code').removeAttr('readonly');
                    $("select[id=fee_id]").val(data.fee_id);


                    var fee_amount_applied_total = $('#fee_amount_applied_total').val();
                    var sum = (parseFloat(fee_amount_applied_total) -
                            parseFloat(prevAmount)) +
                        parseFloat(data.fee.amount);

                    $('#fee_amount_applied_total').val(sum);

                }
            });
        });

        $('.modal-body #firstname').change(function() {
            var firstname = $('.modal-body #firstname').val();
            var lastname = $('.modal-body #lastname').val();
            $('.modal-body #fullname').val(firstname + ' ' + lastname);
            $('.modal-body #fullname').trigger("change");
        });

        $('.modal-body #lastname').change(function() {
            var firstname = $('.modal-body #firstname').val();
            var lastname = $('.modal-body #lastname').val();
            $('.modal-body #fullname').val(firstname + ' ' + lastname);
            $('.modal-body #fullname').trigger("change");

        });


        $('.modal-body #fullname').change(function() {
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

        // search-by-representative-ic
        {
            $('#search-by-representative-ic').click(function() {
                var representativeIc = $('.modal-body #representative-ic').val();
                $.get("/participant/search-by-representative-ic/" + representativeIc, function(
                    data) {
                    $('.modal-body #representative_fullname').val(data.name);
                }).fail(
                    function() {
                        $("p[id=representative-doesnt-exist]").show();
                    }).done(
                    function() {
                        $("div[id=form-application-third-part]").show();
                    });

            });

            // $('#close-new-application').click(function() {
            $('#crud-modal-new-application').on('hide.bs.modal', function(event) {
                $('.modal-body #ic').val(null);
                $('.modal-body #firstname').val(null);
                $('.modal-body #lastname').val(null);
                $('.modal-body #fullname').val(null);
                document.getElementById("male").checked = false;
                document.getElementById("female").checked = false;
                $('.modal-body #phone').val(null);
                $('.modal-body #payment_proof_input').val(null);
                $('.modal-body #email').val(null);

                var event_modules_event_participants = $('[id^="module-"]');
                if (event_modules_event_participants) {
                    for (var i = 0; i < event_modules_event_participants.length; i++) {
                        $('.modal-body #' + event_modules_event_participants.eq(i)[0].id)
                            .prop('checked', false);
                    }
                }
            });
        }

        // checkbox triggered
        {
            var totalAddition = 0;
            $('[id^="module-"]').change(function(e) {
                var value = 0;
                var prevValue = totalAddition;
                if (e.currentTarget.type == 'checkbox') {
                    if (e.currentTarget.checked) {
                        value += parseFloat(e.currentTarget.dataset.fee_amount);

                    } else {
                        value -= parseFloat(e.currentTarget.dataset.fee_amount);
                    }
                } else {
                    value += parseFloat(e.currentTarget.dataset.fee_amount);
                    totalAddition = value;
                }

                var fee_amount_applied_total = $('#fee_amount_applied_total').val();
                var sum = parseFloat(fee_amount_applied_total) + value - prevValue;
                $('#fee_amount_applied_total').val(sum);
            });


        }
    })

    $(document).ready(function() { //New Application
        {
            /*
            NOTE: This behave like $emit function. The element with id 'new-application' came from the
            the source view.
            */
            document.getElementById("new-application").addEventListener("click", function(event) {
                event.preventDefault()
            });
            $('#new-application').click(function() {
                var ic = null;
                edit = false;
                $('.modal-body #ic_input').val(ic);
                $('#input_type').val('add');
                $("#modular_form").hide();
                $("#fee_form").hide();
                if (event.events_shortcourses[0].shortcourse.is_modular) {
                    event.events_shortcourses[0].shortcourse.event_modules.forEach((x) => {
                        $('.modal-body #module-' + x.id).prop('checked', false);
                    });
                }
                $('#crud-modal-new-application').modal('show');

                $('.modal-body #application_update_submit').empty();
                $('.modal-body #application_message').empty();
                $('.modal-body #application_update_submit').append(
                    '<i class = "ni ni-plus"></i> Apply');
                $('.modal-body #application_update_submit').hide();
                $('.modal-body #application_message').append(
                    'Applicant Details');
            });
        }
    });

    $(document).ready(function() { //Edit Application
        {
            $('#table-all-applicant').on('click', '#edit-application', function(e) {
                var target = e.target;
                var ic = target.getAttribute("data-participant_ic");

                $('#input_type').val('edit');

                edit = true;
                $('.modal-body #ic_input').val(ic);

                $("#modular_form").hide();
                $("#fee_form").hide();



                if (event.events_shortcourses[0].shortcourse.is_modular) {
                    event.events_shortcourses[0].shortcourse.event_modules.forEach((x) => {
                        $('.modal-body #module-' + x.id).prop('checked', false);
                    });
                }

                $('.modal-body #payment_proof_input').attr('readonly', false);
                $('.modal-body #payment_proof_input').attr('disabled', true);
                $('.modal-body #payment_proof_input').hide();
                $('#payment_proof_form').hide();

                $('#crud-modal-new-application').modal('show');
                $('#search-by-ic').trigger("click");
            });
        }
    });
</script>
<style>
    .add-participant__module {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr));

    }

    .add-participant__module .form-label {
        grid-column: 1/-1;
    }

</style>
