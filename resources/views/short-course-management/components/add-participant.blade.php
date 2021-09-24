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
                            <label class="form-label" for="fullname"><span class="text-danger">*</span>Full
                                Name</label>
                            <input class="form-control" id="fullname" name="fullname">
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
                            <label class="form-label" for="phone"><span class="text-danger">*</span>Phone</label>
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

                        <div class="form-group" id="modular_form" style="display:none">

                            <input id="is_icdl" name="is_icdl" type="number"
                                value={{ $event->events_shortcourses[0]->shortcourse->is_icdl }} hidden>
                            <div class="form-group add-participant__module"
                                {{ $event->events_shortcourses[0]->shortcourse->is_icdl == 1 ? '' : 'style=display:none' }}>
                                <hr class="mt-1 mb-2">

                                <label class="form-label" for="modules"><span
                                        class="text-danger">*</span>Modules</label>
                                @foreach ($event->events_shortcourses[0]->shortcourse->shortcourse_icdl_modules as $shortcourse_icdl_module)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                            id="module-{{ $shortcourse_icdl_module->id }}" name="modules[]"
                                            value={{ $shortcourse_icdl_module->id }}
                                            data-fee_amount="{{ $shortcourse_icdl_module->fee_amount }}">
                                        <label class="custom-control-label"
                                            for="module-{{ $shortcourse_icdl_module->id }}">{{ $shortcourse_icdl_module->name }}
                                            (+RM{{ $shortcourse_icdl_module->fee_amount }})</label>
                                    </div>
                                @endforeach
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
            $('.modal-body #fullname').val(null);
            $('.modal-body #phone').val(null);
            $('.modal-body #payment_proof_input').val(null);
            $('.modal-body #email').val(null);
            $('.modal-body #representative_ic_input').val(ic_input);
            $('.modal-body #representative_fullname').val(null);

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
                    if (data.shortcourse_icdl_modules_event_participants) {
                        data.shortcourse_icdl_modules_event_participants.forEach((x) => {
                            $('.modal-body #module-' + x.shortcourse_icdl_module_id)
                                .prop('checked', true);

                        });
                    }
                    if (edit) {

                        $('.modal-body #fullname').attr('readonly', false);
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

                        $('.modal-body #fullname').attr('readonly', true);
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
                    $('.modal-body #fullname').removeAttr('readonly', true);
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

            $('#close-new-application').click(function() {
                $('.modal-body #ic').val(null);
                $('.modal-body #fullname').val(null);
                $('.modal-body #phone').val(null);
                $('.modal-body #payment_proof_input').val(null);
                $('.modal-body #email').val(null);
            });
        }

        // checkbox triggered
        {
            $('[id^="module-"]').change(function(e) {
                var value = 0;
                if (e.currentTarget.checked) {
                    value += parseFloat(e.currentTarget.dataset.fee_amount);
                } else {
                    value -= parseFloat(e.currentTarget.dataset.fee_amount);
                }

                var fee_amount_applied_total = $('#fee_amount_applied_total').val();
                var sum = parseFloat(fee_amount_applied_total) + value;
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
                if (event.events_shortcourses[0].shortcourse.is_icdl) {
                    event.events_shortcourses[0].shortcourse.shortcourse_icdl_modules.forEach((x) => {
                        $('.modal-body #module-' + x.id).prop('checked', false);
                    });
                }
                $('#crud-modal-new-application').modal('show');
            });
        }
    });

    $(document).ready(function() { //Edit Application
        {
            $('table[name*="table-all-applicant"]').on('click', '#edit-application', function(e) {

                var target = e.target;
                var ic = target.getAttribute("data-participant_ic");

                $('#input_type').val('edit');

                edit = true;
                $('.modal-body #ic_input').val(ic);

                $("#modular_form").hide();
                $("#fee_form").hide();



                if (event.events_shortcourses[0].shortcourse.is_icdl) {
                    event.events_shortcourses[0].shortcourse.shortcourse_icdl_modules.forEach((x) => {
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
