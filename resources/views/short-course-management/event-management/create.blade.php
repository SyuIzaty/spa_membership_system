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
                                                            <option value="-1">Others</option>
                                                            @foreach ($shortcourses as $shortcourse)
                                                                <option value="{{ $shortcourse->id }}">
                                                                    {{ $shortcourse->id }} -
                                                                    {{ $shortcourse->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('shortcourse_name', '', ['class' => 'form-control', 'placeholder' => 'Short Course Name']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Description **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::textarea('shortcourse_description', '', ['class' => 'form-control', 'placeholder' => 'Short Course Description']) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Objective **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::textarea('shortcourse_objective', '', ['class' => 'form-control', 'placeholder' => 'Short Course Objective']) }}
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
                                                                <option value="{{ $venue->id }}">
                                                                    {{ $venue->id }} -
                                                                    {{ $venue->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('venue_name', '', ['class' => 'form-control', 'placeholder' => 'Venue Name']) }}
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
                                                        <select class="form-control venue" name="venue_id" id="venue_id"
                                                            disabled>
                                                            <option disabled>Select Venue</option>
                                                            <option value="1" selected>Basic Fee</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Amount **', ['style' => 'font-weight:bold']) }}
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
                                                        {{ Form::text('trainer_ic', '', ['class' => 'form-control', 'placeholder' => "Trainer's IC"]) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Fullname **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_fullname', '', ['class' => 'form-control', 'placeholder' => "Trainer's Fullname"]) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Phone ** e.g.:0132345678", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_phone', '', ['class' => 'form-control', 'placeholder' => "Trainer's Phone"]) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's Email **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_email', '', ['class' => 'form-control', 'placeholder' => "Trainer's Email"]) }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Event's Topic **", ['style' => 'font-weight:bold']) }}
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
                                                        <a href="javascript:;" name="addTopic" id="addTopic" class="btn btn-success btn-sm ml-auto float-right">Add
                                                            More Topic</a>
                                                    </td>
                                            </table>
                                            </tr>
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
        $(document).ready(function() {
            // $('.venue, .is_base_fee_select_add, .is_base_fee_select_edit').select2();

            var i=1;
            $('#addTopic').click(function() {
                i++;
                $('#topic_field').append(`
                    <tr id="row${i}" class="topic-added">
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
                            <td class="col col-sm-1"><button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove">X</button></td>
                    </tr>
            `);
            });

            $('.shortcourse, .venue, .topic').select2();


        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
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
