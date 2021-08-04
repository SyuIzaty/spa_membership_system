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
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        Name
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->name }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        IC
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->ic }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        Phone
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->phone }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        Email
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">
                        <div class="panel-container show">
                            <div class="panel-content">
                                <span id="intake_fail"></span>
                                @csrf
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100" id="event">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th>ID</th>
                                                <th>NAME</th>
                                                <th>DATES</th>
                                                <th>PARTICIPANT</th>
                                                <th>MANAGE. DETAILS</th>
                                                <th>ACTION</th>
                                            </tr>
                                            {{-- <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td> --}}
                                            {{-- <td class="hasinput"><input type="text" class="form-control" placeholder="Search Dates"></td> --}}
                                            {{-- <td></td>
                                </tr> --}}
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                    style="content-align:right">
                                </div>
                                <div class="modal fade" id="crud-modals" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="card-header">
                                                <h5 class="card-title w-100">Payment Proof</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('store.payment_proof') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group col">
                                                        {{-- <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="validatedCustomFile" required>
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose
                                                            file...</label>
                                                    </div> --}}
                                                        <label class="form-label" for="fullname">Receipt Image</label>
                                                        {{-- @if ($eventParticipant->payment_proof_path) --}}
                                                        <img style="display:none" id="payment_proof_path"
                                                            name="payment_proof_path" class="card-img" alt="...">
                                                        {{-- @endif --}}

                                                        <hr class="mt-2 mb-2">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-label"
                                                                name="payment_proof_input" accept="image/png, image/jpeg" />
                                                        </div>
                                                    </div>
                                                    <hr class="mt-1 mb-1">
                                                    <div class="form-group col">
                                                        <label class="form-label" for="fullname">Status</label>
                                                        {{-- <input class="form-control-plaintext" id="status" name="status"
                                                        disabled> --}}
                                                        <div class="row">

                                                            <input type="number" name="event_id" value=0 id="event_id"
                                                                hidden />
                                                            <input type="number" value={{ $participant->id }}
                                                                name="participant_id" id="participant_id" hidden />
                                                            <input class="form-control-plaintext"
                                                                id="is_verified_payment_proof_id"
                                                                name="is_verified_payment_proof_id" hidden>
                                                            <div class="col d-flex justify-content-start">
                                                                <input class="form-control-plaintext"
                                                                    id="is_verified_payment_proof"
                                                                    name="is_verified_payment_proof" disabled>
                                                            </div>
                                                            <div class="col d-flex justify-content-end">
                                                                <div class="row d-flex justify-content-end">
                                                                    <td class="col col-sm-1">
                                                                        <button type="button" name="request_verification"
                                                                            id="request_verification"
                                                                            class="btn btn-primary btn_add">
                                                                            Request Verification
                                                                        </button>
                                                                    </td>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="mt-1 mb-1">


                                                    {{-- <div class="invalid-feedback">Example invalid custom file feedback</div> --}}
                                                    <div class="footer">
                                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i
                                                                class="fal fa-save"></i>
                                                            Save</button>
                                                        <button type="button"
                                                            class="btn btn-danger ml-auto float-right mr-2"
                                                            data-dismiss="modal"><i class="fal fa-window-close"></i>
                                                            Close</button>
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
    </main>

@endsection
@section('script')
    <script>
        $(document).ready(function() {

            var participant_id = '<?php echo $participant->id; ?>';

            $('#event thead tr .hasinput').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

                $('select', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table = $('#event').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/events/data/event-management/shortcourse/event-participant/" + participant_id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'dates',
                        name: 'dates'
                    },
                    {
                        data: 'participant',
                        name: 'participant'
                    },
                    {
                        data: 'management_details',
                        name: 'management_details'
                    },
                    {
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
                "initComplete": function(settings, json) {


                }
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
                                stringStatus = "Not making any request yet"
                                $("#request_verification").attr("disabled", "false");
                        style='text-danger';
                            } else if (data.is_verified_payment_proof == 0) {
                                stringStatus = "In verification Process"
                                $("#request_verification").attr("disabled", "true");
                        style='text-primary';
                            } else if (data.is_verified_payment_proof == 1) {
                                stringStatus = "Verified!"
                                $("#request_verification").attr("disabled", "true");
                        style='text-success';
                            }
                            $("#is_verified_payment_proof_id").val(data.is_verified_payment_proof);
                            $('.modal-body #is_verified_payment_proof').val(stringStatus);
                    $('.modal-body #is_verified_payment_proof').addClass(style);
                        }).fail(
                        function() {
                            // TODO: The code is not valid
                        });
                }
            });

            //Update Payment Proof
            {

                $('#crud-modals').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var is_verified_payment_proof_id = button.data('is_verified_payment_proof');
                    $("#is_verified_payment_proof_id").val(is_verified_payment_proof_id);
                    var payment_proof_path = button.data('payment_proof_path');
                    var event_id = button.data('event_id');
                    $("#event_id").val(event_id);
                    var stringStatus;
                    var style;
                    if (typeof(is_verified_payment_proof_id) !== "number") {
                        stringStatus = "Not making any request yet"
                        style='text-danger';
                        // $("#request_verification").attr("disabled", "false");
                    } else if (is_verified_payment_proof_id == 0) {
                        stringStatus = "In verification Process"
                        $("#request_verification").attr("disabled", "true");
                        style='text-primary';
                    } else if (is_verified_payment_proof_id == 1) {
                        stringStatus = "Verified!"
                        $("#request_verification").attr("disabled", "true");
                        style='text-success';
                    }
                    if (!payment_proof_path) {
                        $("#payment_proof_path").hide();
                    } else {
                        $("#payment_proof_path").show();
                        var src = `{{ asset('${payment_proof_path}') }}`;
                        // console.log(`{{ asset('${payment_proof_path}') }}`);

                        // src="http://iids.test/+payment_proof_path+"
                        $("#payment_proof_path").attr("src", src);
                    }
                    $('.modal-body #is_verified_payment_proof').val(stringStatus);
                    $('.modal-body #is_verified_payment_proof').addClass(style);
                });
            }

        });
    </script>
@endsection
