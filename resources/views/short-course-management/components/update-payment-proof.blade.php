<head>
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<div class="modal fade" id="crud-modals" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="card-header">
                <h5 class="card-title w-100">Payment Proof
                </h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('store.payment_proof') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group col" id="carousel" style="display:none">

                        <!--Carousel Wrapper-->
                        <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

                            <!--Controls-->
                            <div class="controls-top">
                                <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i
                                        class="ni ni-arrow-left"></i></a>

                                <a class="btn-floating" href="#multi-item-example" data-slide="next"><i
                                        class="ni ni-arrow-right"></i></a>
                            </div>
                            <!--/.Controls-->

                            <!--Indicators-->
                            <ol class="carousel-indicators mb-0" id="carousel-indicators">
                            </ol>
                            <!--/.Indicators-->

                            <!--Slides-->
                            <div class="carousel-inner" role="listbox" id="carousel-slides">
                            </div>
                            <!--/.Slides-->

                        </div>
                        <!--/.Carousel Wrapper-->
                    </div>

                    <div class="custom-file px-2 d-flex flex-column">
                        <input type="file" class="custom-file-label" name="payment_proof_input[]"
                            accept="image/png, image/jpeg" multiple="" />
                    </div>
                    <hr class="mt-1 mb-1">
                    <div class="form-group col col-sm-5">
                        <label class="form-label" for="amount">Fee Amount</label>
                        <div class="input-group flex-nowrap" id="fee_id_show" name="fee_id_show" style="width:auto">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color:white; border-style: none;"
                                    id="addon-wrapping">RM</span>
                            </div>
                            <input class="form-control-plaintext" id="amount" name="amount" readonly>
                            <div class="input-group-append">
                                <span style="background-color:white; border-style: none;" class="input-group-text">/
                                    person</span>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-1 mb-1">
                    <div class="form-group col">
                        <label class="form-label" for="fullname">Status</label>
                        <div class="row">
                            <input type="number" name="event_participant_id" value=0 id="event_participant_id" hidden />
                            <input type="number" name="event_id" value=0 id="event_id" hidden />
                            <input type="number" name="participant_id" id="participant_id" hidden />
                            <input class="form-control-plaintext" id="is_verified_payment_proof_id"
                                name="is_verified_payment_proof_id" hidden>
                            <div class="col d-flex justify-content-start">
                                <input class="form-control-plaintext" id="is_verified_payment_proof"
                                    name="is_verified_payment_proof" disabled>
                            </div>
                            <div class="col d-flex justify-content-end">
                                <div class="row d-flex justify-content-end">
                                    <td class="col col-sm-1">
                                        <button type="button" name="request_verification" id="request_verification"
                                            class="btn btn-primary btn_add" style="display:none">
                                            Request
                                            Verification
                                        </button>
                                    </td>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-1 mb-1">
                    <div class="footer">
                        <button type="submit" class="btn btn-primary ml-auto float-right" id="submit_payment_proof"><i
                                class="fal fa-save"></i>
                            Save & Request
                            Verification</button>
                        <button type="button" class="btn btn-danger ml-auto float-right mr-2" data-dismiss="modal"><i
                                class="fal fa-window-close"></i>
                            Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    //Update Payment Proof
    {
        $(document).ready(function() {
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
                $('#carousel').hide();

                $.get("/event-participant/" + event_participant_id + "/payment_proof",
                    function(data) {

                        // TODO: Insert result into couresol
                        data.forEach(function(img, index) {
                            var src = img.name;
                            var id = img.id;
                            $('#carousel-indicators').append(
                                `<li data-target="#multi-item-example" data-slide-to="${index}" ${index==0?"class='active'":null}></li>`
                            );

                            $('#carousel-slides').append(
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
                                                    <form method="post"
                                                        action="/event-participant-payment_proof">
                                                        @csrf
                                                        <input type="hidden" name="payment_proof_id" value="${img.id}">
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
                                </div>`
                            );
                        });
                        if (data.length > 0) {
                            $('#carousel').show();
                        } else {
                            $('#carousel').hide();
                        }
                    }).fail(
                    function() {
                        // TODO: Notify Users
                        console.log('No payment proof to show.');
                    });

                $('.modal-body #is_verified_payment_proof').val(stringStatus);
                $('.modal-body #is_verified_payment_proof').addClass(style);
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
                        }).fail(
                        function() {
                            // TODO: The code is not valid
                            alert('Request Verification Failed');
                        }
                    );
                }
            });
        });
    }
</script>
