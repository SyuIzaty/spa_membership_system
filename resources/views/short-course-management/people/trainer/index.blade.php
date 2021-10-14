@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Trainer
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Trainers</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <span id="intake_fail"></span>
                            @csrf
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100 m-0 table-sm"
                                    id="trainer">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>IC</th>
                                            <th>EMAIL</th>
                                            <th>PHONE</th>
                                            <th>EVENTS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                style="content-align:right">
                                <a href="javascript:;" id="create"
                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                        class="ni ni-plus"> </i> Create New Trainer</a>

                                <div class="modal fade" id="crud-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="card-header">
                                                <h5 class="card-title w-150">Add Trainer</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('/trainer') }}" method="post" name="form">
                                                    @csrf
                                                    <p><span class="text-danger">*</span>
                                                        Required Field</p>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="form-group">
                                                        <label for="trainer_ic"><span class="text-danger">*</span>
                                                            Trainer's IC</label>
                                                        <div class="form-inline" style="width:100%">
                                                            <div class="form-group mr-2 mb-2" style="width:85%"
                                                                id="search-by-trainer_ic-div">
                                                                <input class="form-control w-100" id="trainer_ic_input"
                                                                    name="trainer_ic_input">
                                                            </div>
                                                            <a href="javascript:;" data-toggle="#" id="search-by-trainer_ic"
                                                                class="btn btn-primary mb-2" style="width:10%"><i
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
                                                    <div id="form-add-trainer-second-part" style="display: none">
                                                        <div class="alert alert-primary d-flex justify-content-center"
                                                            style="color: #ffffff; background-color: #2c0549;width:100%;"
                                                            id="registration_message">

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="user_id"><span class="text-danger">*</span>
                                                                Trainer's User ID</label>
                                                            {{ Form::text('trainer_user_id_text', '', ['class' => 'form-control', 'placeholder' => "Trainer's User ID", 'id' => 'trainer_user_id_text', 'disabled', 'style' => 'display:none', 'readonly']) }}
                                                            <select class="form-control user" name="trainer_user_id"
                                                                id="trainer_user_id" disabled style="display:none">
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

                                                        <input class="form-control-plaintext" id="trainer_id"
                                                            name="trainer_id" hidden>
                                                        <div class="form-group">
                                                            <label class="form-label" for="trainer_fullname"><span
                                                                    class="text-danger">*</span>Fullname</label>
                                                            <input class="form-control" id="trainer_fullname"
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
                                                            <label class="form-label" for="trainer_phone"><span
                                                                    class="text-danger">*</span>Phone (e.g.: +60134567891)</label>
                                                            <input class="form-control" id="trainer_phone"
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
                                                            <label class="form-label" for="trainer_email"><span
                                                                    class="text-danger">*</span>Email</label>
                                                            <input class="form-control" id="trainer_email"
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
                                                    <div class="footer" id="add_trainer_footer"
                                                        style="display:none; margin-top: 10px;">
                                                        <button type="button"
                                                            class="btn btn-danger ml-auto float-right mr-2"
                                                            data-dismiss="modal" id="close-add-trainer"><i
                                                                class="fal fa-window-close"></i>
                                                            Close</button>
                                                        <button type="submit"
                                                            class="btn btn-success ml-auto float-right mr-2"
                                                            id="registration_update_submit"></button>
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

            $('.user').select2({
                dropdownParent: $('#crud-modal')
            });

            $('#trainer thead tr .hasinput').each(function(i) {
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


            var table = $('#trainer').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/trainers/data",
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
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'ic',
                        name: 'ic'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'events_trainers',
                        name: 'events_trainers'
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

            // List of Trainers
            {
                // Add trainer
                // crud-modal-add-trainer
                $('#create').click(function() {
                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);
                    $('.modal-body #fullname').val(null);
                    $('.modal-body #phone').val(null);
                    $('.modal-body #email').val(null);
                    $('#crud-modal').modal('show');
                    $("div[id=form-add-trainer-second-part]").hide();
                });

                $('#crud-modal').on('show.bs.modal', function(event) {

                    $('.modal-body #id').val(null);
                    $('.modal-body #user_id').val(null);
                    $('#trainer_user_id').next(".select2-container").hide();
                    $('#trainer_user_id').prop('disabled', true);


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
                        $("#trainer_user_id option[value='" + data.id + "']").attr("selected",
                            "true");
                        $("#trainer_user_id_text").show();
                        $("#trainer_user_id_text").removeAttr('disabled');
                        $("#trainer_user_id").removeAttr('disabled');

                        $("#trainer_user_id").removeAttr('disabled');
                        $('#trainer_user_id').prop('disabled', false);

                        $("#trainer_user_id").hide();
                        $("#trainer_user_id").attr('style', 'display: none');

                        $('#trainer_user_id').next(".select2-container").hide();

                        $("#trainer_user_id_text").val(data.id);
                        $('#trainer_fullname').val(data.name);

                        console.log(data);

                        $('.modal-body #registration_message').empty();
                        $('.modal-body #registration_update_submit').empty();
                        if (data.trainer) {
                            $('.modal-body #registration_update_submit').append(
                                '<i class = "fal fa-save"></i> Update');
                            $('.modal-body #registration_message').append(
                                'Already Registered as Trainer - Update Details');
                        } else {
                            $('.modal-body #registration_update_submit').append(
                                '<i class = "ni ni-plus"></i> Register');
                            $('.modal-body #registration_message').append(
                                'Register a new Trainer');
                        }

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
                            $("#trainer_user_id").removeAttr('disabled');
                            $("#trainer_user_id").addClass('user');

                            $("#trainer_user_id").removeProp('style');
                            $("#trainer_user_id").removeAttr('disabled');


                            $("#trainer_user_id").prop('disabled', false);
                            $('#trainer_user_id').next(".select2-container").show();

                            $('.modal-body #registration_message').empty();
                            $('.modal-body #registration_update_submit').empty();

                            $('.modal-body #registration_update_submit').append(
                                '<i class = "ni ni-plus"></i> Register');
                            $('.modal-body #registration_message').append(
                                'Register a new Trainer');

                            $("#trainer_user_id option[value='-1']").attr("selected", "true");
                            $("#trainer_user_id option[value='-1']").prop("selected", true);
                            $("#trainer_user_id").select2().val(-1).trigger("change");
                            $('#trainer_fullname').val(null);
                            $('#trainer_phone').val(null);
                            $('#trainer_email').val(null);

                            $('.user').select2({
                                dropdownParent: $('#crud-modal')
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

        });
    </script>
@endsection
