@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Participant
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Participants</h2>
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
                            <span id="intake_fail"></span>
                            @csrf
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100" id="participant">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>IC</th>
                                            <th>DATES</th>
                                            <th>EVENTS</th>
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
                                <a href="javascript:;" id="create"
                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                        class="ni ni-plus"> </i> Create New Participant</a>

                                <div class="modal fade" id="crud-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="card-header">
                                                <h5 class="card-title w-150">Add Participant</h5>
                                            </div>
                                            {{-- <div class="modal-body">
                                                <form action="{{ url('/participant') }}"
                                                    method="post" name="form">
                                                    @csrf
                                                    <p><span class="text-danger">*</span>
                                                        Vital Information</p>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="form-group">
                                                        <label for="user_id"><span class="text-danger">*</span>
                                                            Participant Name</label>
                                                        {{ Form::text('participant_name', '', ['class' => 'form-control', 'placeholder' => "Participant Name", 'id' => 'participant_name']) }}
                                                        @error('participant_name')
                                                            <p style="color: red">{{ $message }}
                                                            </p>
                                                        @enderror
                                                    </div>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="footer" id="add_contact_person_footer">
                                                        <button type="button"
                                                            class="btn btn-danger ml-auto float-right mr-2"
                                                            data-dismiss="modal" id="close-add-contact_person"><i
                                                                class="fal fa-window-close"></i>
                                                            Close</button>
                                                        <button type="submit"
                                                            class="btn btn-primary ml-auto float-right mr-2"><i
                                                                class="ni ni-plus"></i>
                                                            Add</button>
                                                    </div>
                                                </form>
                                            </div> --}}
                                            <div class="modal-body">
                                                <form action="{{ url('/participant') }}" method="post" name="form">
                                                    @csrf
                                                    <p><span class="text-danger">*</span>
                                                        Vital Information</p>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="form-group">
                                                        <label for="participant_ic"><span class="text-danger">*</span>
                                                            Participant's IC</label>
                                                        <div class="form-inline" style="width:100%">
                                                            <div class="form-group mr-2 mb-2" style="width:85%"
                                                                id="search-by-participant_ic-div">
                                                                <input class="form-control w-100" id="participant_ic_input"
                                                                    name="participant_ic_input">
                                                            </div>
                                                            <a href="javascript:;" data-toggle="#"
                                                                id="search-by-participant_ic" class="btn btn-primary mb-2"
                                                                style="width:10%"><i class="ni ni-magnifier"></i></a>
                                                        </div>
                                                        @error('participant_ic_input')
                                                            <p style="color: red">
                                                                <strong> *
                                                                    {{ $message }}
                                                                </strong>
                                                            </p>
                                                        @enderror
                                                    </div>
                                                    <hr class="mt-1 mb-2">
                                                    <div id="form-add-participant-second-part" style="display: none">
                                                        <div class="alert alert-primary d-flex justify-content-center"
                                                            style="color: #ffffff; background-color: #2c0549;width:100%;"
                                                            id="registration_message">

                                                        </div>
                                                        <hr class="mt-1 mb-2">

                                                        <input class="form-control-plaintext" id="participant_id"
                                                            name="participant_id" hidden>
                                                        <div class="form-group">
                                                            <label class="form-label" for="participant_fullname"><span
                                                                    class="text-danger">*</span>Fullname</label>
                                                            <input class="form-control" id="participant_fullname"
                                                                name="participant_fullname">
                                                            @error('participant_fullname')
                                                                <p style="color: red">
                                                                    <strong> *
                                                                        {{ $message }}
                                                                    </strong>
                                                                </p>
                                                            @enderror
                                                        </div>
                                                        <hr class="mt-1 mb-2">
                                                        <div class="form-group">
                                                            <label class="form-label" for="participant_phone"><span
                                                                    class="text-danger">*</span>Phone</label>
                                                            <input class="form-control" id="participant_phone"
                                                                name="participant_phone">
                                                            @error('participant_phone')
                                                                <p style="color: red">
                                                                    <strong> *
                                                                        {{ $message }}
                                                                    </strong>
                                                                </p>
                                                            @enderror
                                                        </div>

                                                        <hr class="mt-1 mb-2">
                                                        <div class="form-group">
                                                            <label class="form-label" for="participant_email"><span
                                                                    class="text-danger">*</span>Email</label>
                                                            <input class="form-control" id="participant_email"
                                                                name="participant_email">
                                                            @error('participant_email')
                                                                <p style="color: red">
                                                                    <strong> *
                                                                        {{ $message }}
                                                                    </strong>
                                                                </p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="footer" id="add_participant_footer" style="display:none">
                                                        <button type="button"
                                                            class="btn btn-danger ml-auto float-right mr-2"
                                                            data-dismiss="modal" id="close-add-participant"><i
                                                                class="fal fa-window-close"></i>
                                                            Close</button>
                                                        <button type="submit"
                                                            class="btn btn-success ml-auto float-right mr-2"
                                                            id="registration_update_submit"></button>
                                                    </div>

                                                    {{-- {!! Form::close() !!} --}}
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

            $('#participant thead tr .hasinput').each(function(i) {
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


            var table = $('#participant').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/participants/data",
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
                        data: 'ic',
                        name: 'ic'
                    },
                    {
                        data: 'dates',
                        name: 'dates'
                    },
                    {
                        data: 'events_participants',
                        name: 'events_participants'
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

            // crud-modal-add-contact_person
            // $('#create').click(function() {
            //     $('.modal-body #participant_name').val(null);
            //     $('#crud-modal').modal('show');
            // });

            // $('#crud-modal').on('show.bs.modal', function(event) {
            //     $('.modal-body #participant_name').val(null);
            // });

            // List of Participants
            {
                // Add participant
                // crud-modal-add-participant
                $('#create').click(function() {
                    $('.modal-body #id').val(null);
                    $('.modal-body #fullname').val(null);
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('#crud-modal').modal('show');
                    $("div[id=form-add-participant-second-part]").hide();
                });

                $('#crud-modal').on('show.bs.modal', function(event) {
                    // var button = $(event.relatedTarget)
                    // var id = button.data('id');

                    $('.modal-body #id').val(null);
                    $("div[id=form-add-participant-second-part]").hide();
                    $('#add_participant_footer').hide();
                    $("#search-by-participant_ic-div").css({
                        "width": "85%"
                    });
                    $('#search-by-participant_ic').show();
                });

                // search by participant ic
                $('#search-by-participant_ic').click(function() {
                    var participant_ic = $('#participant_ic_input').val();


                    $.get("/participant/search-by-participant_ic/" + participant_ic, function(data) {


                        $('.modal-body #registration_message').empty();
                        $('.modal-body #registration_update_submit').empty();

                        if (data) {

                            $('#participant_fullname').val(data.name);
                            $('#participant_phone').val(data.phone);
                            $('#participant_email').val(data.email);

                            $('.modal-body #registration_update_submit').append(
                                '<i class = "fal fa-save"></i> Update');

                            $('.modal-body #registration_message').append(
                                'Already Registered as Participant - Update Details');
                        } else {
                            $('.modal-body #registration_update_submit').append(
                                '<i class = "ni ni-plus"></i> Register');
                            $('.modal-body #registration_message').append(
                                'Register a new Participant');
                        }


                    }).fail(
                        function() {
                            console.log('fail');
                            $('#participant_ic').val(null);
                            $('#participant_fullname').val(null);
                            $('#participant_phone').val(null);
                            $('#participant_email').val(null);


                            $('.modal-body #registration_update_submit').append(
                                '<i class = "ni ni-plus"></i> Register');
                            $('.modal-body #registration_message').append(
                                'Register a new Participant');
                        }).always(
                        function() {
                            $("div[id=form-add-participant-second-part]").show();
                            $('#add_participant_footer').show();
                        });

                });

                $('#participant_ic_input').change(function() {
                    $('#participant_fullname').val(null);
                    $('#participant_phone').val(null);
                    $('#participant_email').val(null);

                    $('#add_participant_footer').hide();

                    $("div[id=form-add-participant-second-part]").hide();
                    $('#search-by-participant_ic').trigger("click");


                });
            }

        });
    </script>
@endsection
