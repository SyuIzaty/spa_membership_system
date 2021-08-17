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
                                                            <option value="-1" name="Others"
                                                                {{ old('shortcourse_id') == -1 ? 'selected' : null }}>Others
                                                            </option>
                                                            @foreach ($shortcourses as $shortcourse)
                                                                <option value="{{ $shortcourse->id }}"
                                                                    name="{{ $shortcourse->name }}"
                                                                    {{ old('shortcourse_id') == $shortcourse->id ? 'selected' : null }}>
                                                                    {{ $shortcourse->id }} -
                                                                    {{ $shortcourse->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('shortcourse_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                {{-- <tr id="form-add-shortcourse-second-part" style="display: none"> --}}
                                                <tr id="form-add-shortcourse-second-part"
                                                    {{ old('shortcourse_id') ? null : 'style=display:none' }}>


                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('shortcourse_name', old('shortcourse_name'), ['class' => 'form-control', 'placeholder' => 'Short Course Name', 'id' => 'shortcourse_name', 'readonly' => 'readonly']) }}

                                                        @error('shortcourse_name')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr id="form-add-shortcourse-second-part"
                                                    {{ old('shortcourse_id') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course Description **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::textarea('shortcourse_description', old('shortcourse_description'), ['class' => 'form-control', 'placeholder' => 'Short Course Description', 'id' => 'shortcourse_description', 'readonly' => 'readonly']) }}
                                                        @error('shortcourse_description')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr id="form-add-shortcourse-second-part"
                                                    {{ old('shortcourse_id') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course Objective **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::textarea('shortcourse_objective', old('shortcourse_objective'), ['class' => 'form-control', 'placeholder' => 'Short Course Objective', 'id' => 'shortcourse_objective', 'readonly' => 'readonly']) }}
                                                        @error('shortcourse_objective')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr id="form-add-shortcourse-second-part"
                                                    {{ old('shortcourse_id') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Short Course's Topic **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td>
                                                        <table class="table table-bordered" id="topic_field">
                                                            <tr id="row1" class="topic-added">
                                                                <td class="col">
                                                                    <select class="form-control topic1"
                                                                        name="shortcourse_topic[]" id="add_topic">
                                                                        <option value="-1" disabled
                                                                            {{ old('shortcourse_topic') ? (old('shortcourse_topic')[0] == -1 ? 'selected' : null) : null }}>
                                                                            Select Topic
                                                                        </option>
                                                                        @foreach ($topics as $topic)
                                                                            <option value="{{ $topic->id }}"
                                                                                {{ old('shortcourse_topic') ? (old('shortcourse_topic')[0] == $topic->id ? 'selected' : null) : null }}>
                                                                                {{ $topic->id }} -
                                                                                {{ $topic->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        @error('shortcourse_topic')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
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
                                                        {{ Form::input('dateTime-local', 'datetime_start', old('datetime_start') ? old('datetime_start') : date('Y-m-d H:i:s'), ['class' => 'form-control', 'placeholder' => 'Datetime_start']) }}

                                                        @error('datetime_start')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Event Date and Time (End) **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::input('dateTime-local', 'datetime_end', old('datetime_end') ? old('datetime_end') : date('Y-m-d H:i:s'), ['class' => 'form-control', 'placeholder' => 'Datetime_end']) }}
                                                        @error('datetime_end')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <select class="form-control venue" name="venue_id" id="venue_id">
                                                            <option disabled selected>Select Venue</option>
                                                            <option value="-1" {{ old('venue_id') == -1 ? 'selected' : null }}>
                                                                Others</option>
                                                            @foreach ($venues as $venue)
                                                                <option value="{{ $venue->id }}"
                                                                    name="{{ $venue->name }}"
                                                                    {{ old('venue_id') == $venue->id ? 'selected' : null }}>
                                                                    {{ $venue->id }} -
                                                                    {{ $venue->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('venue_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr id="form-add-venue-second-part" style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('venue_name', old('venue_name'), ['class' => 'form-control', 'placeholder' => 'Venue Name', 'id' => 'venue_name']) }}

                                                        @error('venue_name')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('fee_name', 'Regular Price', ['class' => 'form-control', 'placeholder' => 'Fee Name', 'readonly', 'id' => 'fee_name']) }}
                                                        @error('fee_name')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Type **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    {{-- <td class="col px-4">
                                                        {{ Form::text('fee_type', 'Normal Price', ['class' => 'form-control', 'placeholder' => 'Fee Type', 'readonly']) }}
                                                    </td> --}}


                                                    <td class="col px-4">
                                                        <input type="hidden" id="fee_id" name="fee_id" value="1" />
                                                        <select class="form-control fee" name="fee_id_select"
                                                            id="fee_id_select" disabled>
                                                            <option disabled>Select Fee</option>
                                                            <option value="1" selected>Normal Price</option>
                                                            <option value="0">Discounted Price</option>
                                                        </select>
                                                        @error('fee_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Amount (RM) **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::number('fee_amount', old('fee_amount') ? old('fee_amount') : '0.00', ['class' => 'form-control', 'placeholder' => 'Fee Amount']) }}

                                                        @error('fee_amount')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's IC ** e.g.:700423102003", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_ic', old('trainer_ic'), ['class' => 'form-control search-by-trainer_ic', 'placeholder' => "Trainer's IC", 'id' => 'search-by-trainer_ic_input']) }}
                                                        @error('trainer_ic')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                        <a href="javascript:;" data-toggle="#" id="search-by-trainer_ic"
                                                            class="btn btn-primary btn-sm ml-auto float-right my-2">
                                                            Search</a>
                                                    </td>
                                                </tr>
                                                <tr id="form-add-trainer-second-part"
                                                    {{ old('trainer_ic') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's User ID **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <input type="number" name="trainer_user_id" hidden>
                                                        {{ Form::text('trainer_user_id_text', '', ['class' => 'form-control', 'placeholder' => "Trainer's User ID", 'id' => 'trainer_user_id_text', 'disabled', 'style' => 'display:none', 'readonly']) }}
                                                        <select class="form-control user" name="trainer_user_id"
                                                            id="trainer_user_id"
                                                            {{ old('trainer_user_id') == -1 ? null : 'disabled' }}
                                                            style="display:none">
                                                            <option disabled>Select User ID</option>
                                                            <option value='-1' name="create_new"
                                                                {{ old('trainer_user_id') == -1 ? 'selected' : null }}>Create
                                                                New</option>
                                                            @foreach ($users as $user)
                                                                <option value='{{ $user->id }}'
                                                                    name="{{ $user->name }}"
                                                                    {{ old('trainer_user_id') == $user->id ? 'selected' : null }}>
                                                                    {{ $user->id }} -
                                                                    {{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('trainer_user_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr id="form-add-trainer-second-part"
                                                    {{ old('trainer_ic') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Fullname **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_fullname', old('trainer_fullname'), ['class' => 'form-control', 'placeholder' => "Trainer's Fullname", 'id' => 'trainer_fullname']) }}
                                                        @error('trainer_fullname')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr id="form-add-trainer-second-part"
                                                    {{ old('trainer_ic') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Phone ** e.g.:0132345678", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_phone', old('trainer_phone'), ['class' => 'form-control', 'placeholder' => "Trainer's Phone", 'id' => 'trainer_phone']) }}
                                                        @error('trainer_phone')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr id="form-add-trainer-second-part"
                                                    {{ old('trainer_ic') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Email **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_email', old('trainer_email'), ['class' => 'form-control', 'placeholder' => "Trainer's Email", 'id' => 'trainer_email']) }}
                                                        @error('trainer_email')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
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
                                <button type="submit" id="submit" {{ old('trainer_ic') ? null : 'style=display:none' }}
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

                console.log(data.id);
                // $("#trainer_user_id option[value='" + data.id + "']").attr("selected", "true");

                $("#trainer_user_id").select2().val(data.id).trigger("change");
                $("#trainer_user_id_text").hide();
                $("#trainer_user_id_text").attr('disabled');

                // $("#trainer_user_id").hide();
                // $("#trainer_user_id").attr('style', 'display: none');
                // $("#trainer_user_id").removeClass('user');

                $("#trainer_user_id_text").val(data.id);
                $('#trainer_fullname').val(data.name);
                $('#trainer_phone').val(data.trainer.phone);
                $('#trainer_email').val(data.email);



            }).fail(
                function() {
                    $('#trainer_ic').val(null);
                    $("#trainer_user_id_text").hide();
                    $("#trainer_user_id_text").attr('disabled');

                    $("#trainer_user_id").show();
                    $("#trainer_user_id").removeAttr('disabled');
                    $("#trainer_user_id").addClass('user');

                    $("#trainer_user_id option[value='-1']").attr("selected", "true");
                    $('input[name=trainer_user_id]').val(-1);
                    $('#trainer_fullname').val(null);
                    $('#trainer_phone').val(null);
                    $('#trainer_email').val(null);
                }).always(
                function() {
                    $("tr[id=form-add-trainer-second-part]").show();

                    $('#submit').show();
                    // $('#search-by-trainer_ic').hide();
                });

        });
        $('#trainer_user_id').change(function(event) {
            var trainer_fullname = $('#trainer_user_id').find(":selected").attr('name');
            var trainer_user_id = $('#trainer_user_id').find(":selected").val();
            $('input[name=trainer_user_id]').val(trainer_user_id);

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

        $('#search-by-trainer_ic_input').change(function() {

            $("#trainer_user_id").select2().val(-1).trigger("change");
            $("#trainer_user_id_text").hide();
            $("#trainer_user_id_text").attr('disabled');

            $("#trainer_user_id_text").val(null);
            $('#trainer_fullname').val(null);
            $('#trainer_phone').val(null);
            $('#trainer_email').val(null);

            $('#submit').hide();

            $("tr[id=form-add-trainer-second-part]").hide();
            $('#search-by-trainer_ic').trigger("click");


        });

        $('#shortcourse_id').change(function(event) {
            var shortcourse_name = $('#shortcourse_id').find(":selected").attr('name');
            var shortcourse_id = $('#shortcourse_id').find(":selected").val();

            var shortcourses = @json($shortcourses);
            if (shortcourse_id == -1) {

                $('#shortcourse_name').val(null);
                $('#shortcourse_description').val(null);
                $('#shortcourse_objective').val(null);
                $('#shortcourse_topic').val(null);

                var rowCount = $('#topic_field tr').length;
                while (rowCount > 1) {


                    $(`#row${rowCount}`).remove();
                    rowCount -= 1;
                }
                $(".topic1").select2().val(-1).trigger("change");

                $("tr[id=form-add-shortcourse-second-part]").show();
            } else {

                var selected_shortcourse = shortcourses.find((x) => {
                    return x.id == shortcourse_id
                });


                $("topic_field").find("tr:gt(0)").remove();

                if (shortcourse_id) {
                    $('#shortcourse_name').val(selected_shortcourse.name);
                    $('#shortcourse_description').val(selected_shortcourse.description);
                    $('#shortcourse_objective').val(selected_shortcourse.objective);
                    $('#shortcourse_topic').val(selected_shortcourse.topics);
                    $("tr[id=form-add-shortcourse-second-part]").show();

                    var i = 1;
                    selected_shortcourse.topics.forEach((x) => {
                        if (i > 1) {
                            $(`#row${i}`).remove();
                            $('#topic_field tr:last').after(`
                            <tr id="row${i}" class="topic-added">
                                    <td class="col">
                                        <select class="form-control topic${i}" name="shortcourse_topic[]"
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
                            </tr> `);
                            $(`.topic${i}`).select2();

                        }
                        $(".topic" + i).select2().val(x.id).trigger("change");
                        i += 1;
                    });

                    var rowCount = $('#topic_field tr').length;
                    while (rowCount > selected_shortcourse.topics.length) {
                        $(`#row${rowCount}`).remove();
                        rowCount -= 1;
                    }

                } else {
                    $('#shortcourse_name').val(null);
                    $('#shortcourse_description').val(null);
                    $('#shortcourse_objective').val(null);
                    $("tr[id=form-add-shortcourse-second-part]").hide();
                }
            }
        });
        $('#venue_id').change(function(event) {
            var venue_name = $('#venue_id').find(":selected").attr('name');
            var venue_id = $('#venue_id').find(":selected").val();

            $('#venue_name').val(venue_name);


            // var venue_name = $('#venue_id').prop("tagName");
            if (venue_id == -1) {
                $('#venue_name').val(venue_name);
                $("tr[id=form-add-venue-second-part]").show();
            } else {
                $('#venue_name').val(venue_name);
                $("tr[id=form-add-venue-second-part]").hide();

            }
        });

        $(document).ready(function() {
            var i = 101;
            var index =0;
            $('#addTopic').click(function() {
                $('#topic_field tr:last').after(`
                    <tr id="row${i}" class="topic-added">
                            <td class="col">
                                <select class="form-control topic${i}" name="shortcourse_topic[]"
                                id="add_topic">
                                    <option value="-1" disabled  {{ old('shortcourse_topic') ? (old('shortcourse_topic')[${index}] == -1 ? 'selected' : null) : null }}>Select Topic
                                    </option  {{ old('shortcourse_topic') ? (old('shortcourse_topic')[${index}] == $topic->id ? 'selected' : null) : null }}>
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
                i+=1;
                index+=1;
            });

            $('.shortcourse, .user, .venue, .topic1, .fee').select2();


            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });
    </script>
@endsection
