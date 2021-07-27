@extends('layouts.admin')

{{-- The content template is taken from sims.resources.views.applicant.display --}}
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr bg-primary">
                        <h2 class="text-white">
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
                            {!! Form::open(['action' => 'ShortCourseManagement\EventManagement\EventController@storeNew', 'method' => 'POST']) !!}

                            <div class="row">
                                <div class="col-md-12">
                                    <hr class="mt-2 mb-3">
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <center><img src="http://iids.test/img/intec_logo.png"
                                                    style="height: 120px; width: 270px;"></center>
                                            <br />
                                            <h4 style="text-align: center">
                                                <b>EVENT REGISTRATION INTEC EDUCATION COLLEGE</b>
                                            </h4>
                                            <br />
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
                                            @if (session()->has('message'))
                                                <div class="alert alert-success">
                                                    {{ session()->get('message') }}
                                                </div>
                                            @endif
                                            <div class="text-danger mb-2">** Required Field</div>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <select class="form-control shortcourse" name="shortcourse_id"
                                                            id="shortcourse_id">
                                                            <option disabled selected>Select Short Course</option>
                                                            <option value="-1" name="Others">Others</option>
                                                            @foreach ($shortcourses as $shortcourse)
                                                                <option value="{{ $shortcourse->id }}"
                                                                    name="{{ $shortcourse->name }}">
                                                                    {{ $shortcourse->id }} -
                                                                    {{ $shortcourse->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="form-add-shortcourse-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('shortcourse_name', '', ['class' => 'form-control', 'placeholder' => 'Short Course Name', 'id' => 'shortcourse_name']) }}
                                                    </td>
                                                </tr>
                                                <tr id="form-add-shortcourse-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course Description **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::textarea('shortcourse_description', '', ['class' => 'form-control', 'placeholder' => 'Short Course Description', 'id' => 'shortcourse_description']) }}
                                                    </td>
                                                </tr>
                                                <tr id="form-add-shortcourse-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course Objective **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::textarea('shortcourse_objective', '', ['class' => 'form-control', 'placeholder' => 'Short Course Objective', 'id' => 'shortcourse_objective']) }}
                                                    </td>
                                                </tr>

                                                <tr id="form-add-shortcourse-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Short Course's Topic **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td>
                                                        <table class="table table-bordered" id="topic_field">
                                                            <tr>
                                                                <td class="col">
                                                                    <select class="form-control topic" name="topic[]"
                                                                        id="add_topic">
                                                                        <option value="-1" disabled selected>Select Topic
                                                                        </option>
                                                                        @foreach ($topics as $topic)
                                                                            <option value="{{ $topic->id }}">
                                                                                {{ $topic->id }} -
                                                                                {{ $topic->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <a href="javascript:;" name="addTopic" id="addTopic"
                                                            class="btn btn-success btn-sm ml-auto float-right">Add
                                                            More Topic</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Event Date and Time (Start) **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::input('dateTime-local', 'startDate', date('Y-m-d H:i:s'), ['class' => 'form-control', 'placeholder' => 'StartDate']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Event Date and Time (End) **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::input('dateTime-local', 'endDate', date('Y-m-d H:i:s'), ['class' => 'form-control', 'placeholder' => 'EndDate']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <select class="form-control venue" name="venue_id" id="venue_id">
                                                            <option disabled selected>Select Venue</option>
                                                            <option value="-1">Others</option>
                                                            @foreach ($venues as $venue)
                                                                <option value="{{ $venue->id }}"
                                                                    name="{{ $venue->name }}">
                                                                    {{ $venue->id }} -
                                                                    {{ $venue->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr id="form-add-venue-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('venue_name', '', ['class' => 'form-control', 'placeholder' => 'Venue Name', 'id' => 'venue_name']) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('fee_name', 'Regular Price', ['class' => 'form-control', 'placeholder' => 'Fee Name', 'disabled']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Type **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    {{-- <td class="col px-4">
                                                        {{ Form::text('fee_type', 'Basic Fee', ['class' => 'form-control', 'placeholder' => 'Fee Type', 'disabled']) }}
                                                    </td> --}}


                                                    <td class="col px-4">
                                                        <select class="form-control fee" name="fee_id" id="fee_id" disabled>
                                                            <option disabled>Select Fee</option>
                                                            <option value="1" selected>Basic Fee</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Amount (RM) **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::number('fee_amount', '0.00', ['class' => 'form-control', 'placeholder' => 'Fee Amount']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's IC ** e.g.:700423102003", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_ic', '', ['class' => 'form-control search-by-trainer_ic', 'placeholder' => "Trainer's IC", 'id' => 'search-by-trainer_ic_input']) }}
                                                        <a href="javascript:;" data-toggle="#" id="search-by-trainer_ic"
                                                            class="btn btn-primary btn-sm ml-auto float-right my-2">
                                                            Search</a>
                                                    </td>
                                                </tr>
                                                <tr id="form-add-trainer-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Fullname **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_fullname', '', ['class' => 'form-control', 'placeholder' => "Trainer's Fullname", 'id' => 'trainer_fullname']) }}
                                                    </td>
                                                </tr>
                                                <tr id="form-add-trainer-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Phone ** e.g.:0132345678", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_phone', '', ['class' => 'form-control', 'placeholder' => "Trainer's Phone", 'id' => 'trainer_phone']) }}
                                                    </td>
                                                </tr>

                                                <tr id="form-add-trainer-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Email **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_email', '', ['class' => 'form-control', 'placeholder' => "Trainer's Email", 'id' => 'trainer_email']) }}
                                                    </td>
                                                </tr>


                                            </table>
                                            {{-- <button class="btn btn-success btn-sm ml-auto float-right mb-5">Submit</button> --}}


                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                style="content-align:right">
                                <button type="submit"
                                    class="btn btn-danger ml-auto mr-2 waves-effect waves-themed font-weight-bold"><i
                                        class="ni ni-check"></i> Register</button>
                            </div>
                            {!! Form::close() !!}

                            <hr class="mt-2 mb-3">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        $('#search-by-trainer_ic').click(function() {
            var trainer_ic = $('#search-by-trainer_ic_input').val();
            $.get("/trainer/search-by-trainer_ic/" + trainer_ic, function(data) {
                $('#trainer_fullname').val(data.name);
                $('#trainer_phone').val(data.trainer.phone);
                $('#trainer_email').val(data.email);

            }).fail(
                function() {
                    $('#trainer_ic').val(null);
                    $('#trainer_fullname').val(null);
                    $('#trainer_phone').val(null);
                    $('#trainer_email').val(null);
                }).always(
                function() {
                    $("tr[id=form-add-trainer-second-part]").show();
                });

        });
        $('#shortcourse_id').change(function(event) {
            var shortcourse_name = $('#shortcourse_id').find(":selected").attr('name');
            var shortcourse_id = $('#shortcourse_id').find(":selected").val();

            var shortcourses = @json($shortcourses);

            var selected_shortcourse = shortcourses.find((x)=>{return x.id==shortcourse_id});
            if (shortcourse_id) {
                $('#shortcourse_name').val(selected_shortcourse.name);
                $('#shortcourse_description').val(selected_shortcourse.description);
                $('#shortcourse_objective').val(selected_shortcourse.objective);
                $("tr[id=form-add-shortcourse-second-part]").show();
            } else {
                $('#shortcourse_name').val(null);
                $('#shortcourse_description').val(null);
                $('#shortcourse_objective').val(null);
                $("tr[id=form-add-shortcourse-second-part]").hide();
            }
        });
        $('#venue_id').change(function(event) {
            var venue_name = $('#venue_id').find(":selected").attr('name');
            var venue_id = $('#venue_id').find(":selected").val();


            // var venue_name = $('#venue_id').prop("tagName");
            if (venue_id == -1) {
                $('#venue_name').val(venue_name);
                $("tr[id=form-add-venue-second-part]").show();
            } else {
                $('#venue_name').val(null);
                $("tr[id=form-add-venue-second-part]").hide();

            }
        });

        $(document).ready(function() {
            // $('.venue, .is_base_fee_select_add, .is_base_fee_select_edit').select2();

            var i = 1;
            $('#addTopic').click(function() {
                i++;
                $('#topic_field').append(`
                    <tr id="row${i}" class="topic-added">
                            <td class="col">
                                <select class="form-control topic${i}" name="topic[]"
                                id="add_topic">
                                    <option value="-1" disabled selected>Select Topic
                                    </option>
                                    @foreach ($topics as $topic)
                                        <option value="{{ $topic->id }}">
                                            {{ $topic->id }} -
                                            {{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="col col-sm-1"><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove">X</button></td>
                    </tr>
            `);
                $(`.topic${i}`).select2();
            });

            $('.shortcourse, .venue, .topic').select2();


            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });


            // <tr id="row${i}" class="role-added">
            // <input type="hidden" name="type" value="C">
            // <td><input type="text" name="role[]" placeholder="Role" class="form-control role" id="add_role"></td>
            // <td><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove">X</button></td>
            // </tr>


            // <tr>
            //     <input type="hidden" name="type" value="C">
            //     <td><input type="text" name="role[]" placeholder="Role" class="form-control head" id="add_role"></td>
            //     <td><button type="button" name="addrole" id="addrole" class="btn btn-info btn-sm">Add More</button></td>
            // </tr>
        });
    </script>
@endsection
