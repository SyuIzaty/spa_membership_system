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
                                                <tr class="row">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Short Course **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <select class="form-control shortcourse" name="shortcourse_id"
                                                            id="shortcourse_id">
                                                            <option disabled selected>Select Short Course</option>
                                                            <option value="-1" name="Create New Short Course">
                                                                Create New Short Course
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
                                                <tr class="row" id="form-add-shortcourse-second-part"
                                                    {{ old('shortcourse_id') ? null : 'style=display:none' }}>


                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Event Name **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('shortcourse_name', old('shortcourse_name'), ['class' => 'form-control', 'placeholder' => 'Event Name', 'id' => 'shortcourse_name']) }}

                                                        @error('shortcourse_name')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row" id="form-add-shortcourse-second-part"
                                                    {{ old('shortcourse_id') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Event Description **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{-- {{ Form::textarea('shortcourse_description', old('shortcourse_description'), ['class' => 'form-control', 'placeholder' => 'Event Description', 'id' => 'shortcourse_description']) }} --}}
                                                        <textarea id="shortcourse_description"
                                                            name="shortcourse_description"
                                                            class="form-control ck-editor__editable ck-editor__editable_inline"
                                                            rows="10">{{ old('shortcourse_description') }}  </textarea>
                                                        @error('shortcourse_description')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row" id="form-add-shortcourse-second-part"
                                                    {{ old('shortcourse_id') ? null : 'style=display:none' }}>
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Event Objective **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <textarea id="shortcourse_objective" name="shortcourse_objective"
                                                            class="form-control ck-editor__editable ck-editor__editable_inline"
                                                            rows="10">{{ old('shortcourse_objective') }}  </textarea>
                                                        @error('shortcourse_objective')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr class="row">
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
                                                <tr class="row">
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
                                                <tr class="row">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <select class="form-control venue" name="venue_id" id="venue_id">
                                                            <option disabled selected>Select Venue</option>
                                                            <option value="-1"
                                                                {{ old('venue_id') == -1 ? 'selected' : null }}>
                                                                Others</option>
                                                            @foreach ($venues as $venue)
                                                                <option value="{{ $venue->id }}"
                                                                    name="{{ $venue->name }}"
                                                                    data-venue-type="{{ $venue->venue_type->id }}"
                                                                    {{ old('venue_id') == $venue->id ? 'selected' : null }}>
                                                                    {{ $venue->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('venue_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row" id="form-add-venue-second-part"
                                                    style="display: none">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue Type **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <select class="form-control venue_type" name="venue_type_id"
                                                            id="venue_type_id">
                                                            <option disabled selected>Select Venue Type</option>
                                                            @foreach ($venue_types as $venue_type)
                                                                <option value="{{ $venue_type->id }}"
                                                                    name="{{ $venue_type->name }}"
                                                                    {{ old('venue_type_id') == $venue_type->id ? 'selected' : null }}>
                                                                    {{ $venue_type->id }} -
                                                                    {{ $venue_type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('venue_type_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row" id="form-add-venue-second-part"
                                                    style="display: none">
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

                                                <tr class="row">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Venue Description (Address/URL) **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::textarea('venue_description', old('venue_description'), ['class' => 'form-control', 'placeholder' => 'Venue Description', 'id' => 'venue_description']) }}
                                                        @error('venue_description')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr class="row">
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
                                                <tr class="row">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Fee Type **', ['style' => 'font-weight:bold']) }}
                                                    </td>


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
                                                <tr class="row">
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
                                                <tr class="row">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', 'Feedback Set **', ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <select class="form-control event_feedback_set"
                                                            name="event_feedback_set_id" id="event_feedback_set_id">
                                                            <option disabled selected>Select Feedback Set</option>
                                                            @foreach ($event_feedback_sets as $event_feedback_set)
                                                                <option value="{{ $event_feedback_set->id }}"
                                                                    name="{{ $event_feedback_set->name }}"
                                                                    {{ old('event_feedback_set_id') == $event_feedback_set->id ? 'selected' : null }}>
                                                                    {{ $event_feedback_set->id }} -
                                                                    {{ $event_feedback_set->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('event_feedback_set_id')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's IC ** e.g.:700423102003", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        {{ Form::text('trainer_ic', old('trainer_ic'), ['class' => 'form-control search-by-trainer_ic', 'placeholder' => "Trainer's IC", 'id' => 'search-by-trainer_ic_input']) }}
                                                        @error('trainer_ic')
                                                            <p style="color: red">{{ $message }}</p>
                                                        @enderror
                                                        <a href="javascript:;" data-toggle="#" id="search-by-trainer_ic"
                                                            class="btn btn-primary btn-sm ml-auto float-right my-2" hidden>
                                                            Search</a>
                                                    </td>
                                                </tr>
                                                <tr class="row" id="form-add-trainer-second-part">
                                                    <td class="col col-lg-2 px-4">
                                                        {{ Form::label('title', "Trainer's User ID **", ['style' => 'font-weight:bold']) }}
                                                    </td>
                                                    <td class="col px-4">
                                                        <input type="text" name="trainer_user_id_hidden"
                                                            id="trainer_user_id_hidden" hidden>
                                                        {{ Form::text('trainer_user_id_text', '', ['class' => 'form-control', 'placeholder' => "Trainer's User ID", 'id' => 'trainer_user_id_text', 'disabled', 'style' => 'display:none', 'readonly']) }}
                                                        <select class="form-control user" name="trainer_user_id"
                                                            id="trainer_user_id"
                                                            {{ old('trainer_user_id') == -1 ? null : 'disabled' }}
                                                            style="display:none">
                                                            <option disabled>Select User ID</option>
                                                            <option value='-1' name="create_new"
                                                                {{ old('trainer_user_id') == -1 ? 'selected' : null }}>
                                                                Create
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
                                                <tr class="row" id="form-add-trainer-second-part">
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
                                                <tr class="row" id="form-add-trainer-second-part">
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
                                                <tr class="row" id="form-add-trainer-second-part">
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
                            <div class="modal fade" id="crud-modal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="card-header">
                                            <h5 class="card-title w-150">Add New Shortcourse</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('/shortcourse/event') }}" method="post"
                                                name="form">
                                                @csrf
                                                {{-- {!! Form::open(['action' => 'ShortCourseManagement\EventManagement\EventController@storeContactPerson\ '.$shortcourse->id, 'method' => 'POST']) !!} --}}

                                                <p><span class="text-danger">*</span>
                                                    Required Field</p>
                                                <hr class="mt-1 mb-2">
                                                <div class="form-group">
                                                    <label for="user_id"><span
                                                            class="text-danger">*</span>
                                                        Short Course Name</label>
                                                    {{ Form::text('shortcourse_name_new', '', ['class' => 'form-control', 'placeholder' => 'Short Course Name', 'id' => 'shortcourse_name_new']) }}
                                                    @error('shortcourse_name_new')
                                                        <p style="color: red">{{ $message }}
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="shortcourse_type"><span
                                                            class="text-danger">*</span>
                                                        Short Course Type</label>
                                                    <select class="form-control shortcourse_type "
                                                        name="shortcourse_type" id="shortcourse_type"
                                                        data-select2-id="shortcourse_type"
                                                        aria-hidden="true">
                                                        <option value="0">
                                                            Regular Short Course
                                                        </option>
                                                        <option value="1">
                                                            ICDL
                                                        </option>
                                                    </select>
                                                    @error('shortcourse_type')
                                                        <p style="color: red">
                                                            <strong> *
                                                                {{ $message }}
                                                            </strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="objective"><span
                                                            class="text-danger">*</span>
                                                        Objective</label>
                                                    <textarea id="objective" name="objective" type="text"
                                                        rows="10"
                                                        class="form-control ck-editor__editable ck-editor__editable_inline"></textarea>
                                                    @error('objective')
                                                        <p style="color: red">
                                                            <strong> *
                                                                {{ $message }}
                                                            </strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="description"><span
                                                            class="text-danger">*</span>
                                                        Description</label>
                                                    <textarea id="description" name="description"
                                                        type="text" rows="10"
                                                        class="form-control ck-editor__editable ck-editor__editable_inline"></textarea>
                                                    @error('description')
                                                        <p style="color: red">
                                                            <strong> *
                                                                {{ $message }}
                                                            </strong>
                                                        </p>
                                                    @enderror
                                                </div>
                                                <div class="modules" id="modules"
                                                    style="display: inline-block; width:100%;" hidden>
                                                    <table class="table table-striped table-bordered m-0"
                                                        id="module_field">
                                                        <thead class="thead">
                                                            <tr class=" bg-primary-50">
                                                                <th colspan="3"><b>List of Modules</b>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr hidden></tr>
                                                        </tbody>
                                                    </table>
                                                    <a href="javascript:;" name="addModule" id="addModule"
                                                        class="btn btn-primary btn-sm ml-auto float-right my-2">Add
                                                        More Module</a>

                                                </div>
                                                <hr class="mt-1 mb-2">
                                                <div class="footer" id="add_contact_person_footer">
                                                    <button type="button"
                                                        class="btn btn-danger ml-auto float-right mr-2"
                                                        data-dismiss="modal"
                                                        id="close-add-contact_person"><i
                                                            class="fal fa-window-close"></i>
                                                        Close</button>
                                                    <button type="submit" id="submitShortCourse"
                                                        class="btn btn-primary ml-auto float-right mr-2"><i
                                                            class="ni ni-plus"></i>
                                                        Add</button>
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
    </main>
@endsection
@section('script')
    <script>
        let editor_shortcourse_description;
        ClassicEditor
            .create(document.querySelector('#shortcourse_description'))
            .then(editor => {
                editor_shortcourse_description = editor;
            })
            .catch(error => {
                console.error(error);
            });

        let editor_shortcourse_objective;
        ClassicEditor
            .create(document.querySelector('#shortcourse_objective'))
            .then(editor => {
                editor_shortcourse_objective = editor;
            })
            .catch(error => {
                console.error(error);
            });


        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#objective'))
            .catch(error => {
                console.error(error);
            });

        $('#search-by-trainer_ic').click(function() {

            var trainer_ic = $('#search-by-trainer_ic_input').val();
            $.get("/trainer/search-by-trainer_ic/" + trainer_ic, function(data) {


                $("#trainer_user_id").select2().val(data.id).trigger("change");
                $("#trainer_user_id_text").hide();
                $("#trainer_user_id_text").attr('disabled');
                $("#trainer_user_id").prop('disabled', true);
                $("#trainer_user_id_hidden").val(data.id);


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

                    $("#trainer_user_id_hidden").val(trainer_ic);


                    $("#trainer_user_id option[value='-1']").attr("selected", "true");
                    $('input[name=trainer_user_id]').val(-1);
                    $('#trainer_fullname').val(null);
                    $('#trainer_phone').val(null);
                    $('#trainer_email').val(null);
                }).always(
                function() {
                    $("tr[id=form-add-trainer-second-part]").show();

                    $('#submit').show();
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
            $("#trainer_user_id").prop('disabled', false);
            $("#trainer_user_id").prop('disabled', true);

            $("#trainer_user_id_text").val(null);
            $('#trainer_fullname').val(null);
            $('#trainer_phone').val(null);
            $('#trainer_email').val(null);

            $('#submit').hide();

            $('#search-by-trainer_ic').trigger("click");


        });

        $('#shortcourse_id').change(function(event) {
            var shortcourse_name = $('#shortcourse_id').find(":selected").attr('name');
            var shortcourse_id = $('#shortcourse_id').find(":selected").val();

            var shortcourses = @json($shortcourses);
            if (shortcourse_id == -1) {

                $('#shortcourse_name').val(null);
                editor_shortcourse_description.setData('');
                editor_shortcourse_objective.setData('');

                var rowCount = $('#topic_field tr').length;
                while (rowCount > 1) {


                    $(`#row${rowCount}`).remove();
                    rowCount -= 1;
                }

                $('.modal-body #shortcourse_name').val(null);
                $('#crud-modal').modal('show');

                $("#shortcourse_type").select2("val", "0")

                $('#crud-modal').on('show.bs.modal', function(event) {
                    $('.modal-body #shortcourse_name_new').val(null);;
                });

                $("tr[id=form-add-shortcourse-second-part]").show();

            } else {

                var selected_shortcourse = shortcourses.find((x) => {
                    return x.id == shortcourse_id
                });

                // console.log(selected_shortcourse);


                shortcourse_description = selected_shortcourse.description;
                shortcourse_objective = selected_shortcourse.objective;

                nodeNames = [];
                if (selected_shortcourse != null) {
                    // console.log(selected_shortcourse.name);
                    $('#shortcourse_name').val(selected_shortcourse.name);

                    editor_shortcourse_description.setData(shortcourse_description);
                    editor_shortcourse_objective.setData(shortcourse_objective);

                    $("tr[id=form-add-shortcourse-second-part]").show();

                    var i = 1;

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
            var venue_type_id = $('#venue_id').find(":selected").attr('data-venue-type');

            $('#venue_name').val(venue_name);
            $('#venue_type_id').val(venue_type_id);


            if (venue_id == -1) {
                $("tr[id=form-add-venue-second-part]").show();
            } else {
                $("tr[id=form-add-venue-second-part]").hide();

            }
        });


        $(document).ready(function() {
            var i = 0;
            $('#addModule').click(function() {
                i++;
                $('#module_field tbody tr:last').after(`
                            <tr id="new-row${i}">
                                    <td>
                                        <input id="add_module" name="shortcourse_modules[]" type="text" class="form-control" placeholder="Insert Module Name">
                                    </td>
                                    <td>
                                        <a href="javascript:;" name="cancel-module" data-value="${i}" id="cancel-module" class="btn btn-sm btn-danger btn_remove mx-1">X</a>
                                    </td>
                            </tr>
                    `);

                $(document).on('click', '#cancel-module', function(event) {
                    var row_id=event.target.dataset.value;
                    $(`#new-row${row_id}`).remove();
                    $("#addModule").show();
                });


                $(document).on('click', '#save-module', function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var $shortcourse_module = $('#add_module').val();
                    var data = {
                        shortcourse_module: $shortcourse_module
                    }
                    var url = '/shortcourse/module/attached/' + shortcourse_id;

                    $.post(url, data).done(function() {
                            window.location.reload();
                        })
                        .fail(function() {
                            $('#new-row').show();
                            $("#addModule").remove();
                            alert('Unable to add module');
                        });
                });
            });

            $('#shortcourse_type').change(function(event) {
                var shortcourse_type = $('#shortcourse_type').find(':selected');
                if (shortcourse_type[0].value == 0) {
                    $('#modules').attr("hidden", true);
                    console.log('hide');
                } else if (shortcourse_type[0].value == 1) {
                    $('#modules').removeAttr("hidden", false);
                    console.log('show');
                }
            });

            $('.shortcourse, .user, .venue, .topic1, .fee, .venue_type, .event_feedback_set').select2();

            $('.shortcourse_type').select2({
                dropdownParent: $('#crud-modal')
            });


            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

            $('#close-add-contact_person').click(function() {
                location.reload();
            })
        });
    </script>
@endsection
