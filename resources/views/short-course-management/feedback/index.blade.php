@extends('layouts.covid')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo.png') }}" style="max-width: 100%"
                                        class="responsive" /></center><br>
                                <h4 style="text-align: center">
                                    <b>INTEC EDUCATION COLLEGE EVENT EVALUATION FORM</b>
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="panel-container show">
                            <div class="panel-content">
                                {!! Form::open(['action' => 'ShortCourseManagement\Feedbacks\FeedbackController@submit', 'method' => 'POST']) !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" class="form-control participant_id" id="participant_id"
                                    name="participant_id">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i
                                            class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif
                                @if (Session::has('notification'))
                                    <div class="alert alert-success" style="color: #5b0303; background-color: #ff6c6cc9;">
                                        <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}
                                    </div>
                                @endif
                                <div>
                                    <div class="table-responsive">
                                        <p><span class="text-danger">*</span> Required fields</p>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr class="all">
                                                    <td width="20%"><label class="form-label" for="event_name"><span
                                                                class="text-danger">*</span> Event Name </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control intec" id="event_name" name="event_name"
                                                            value="{{ isset($event_participant) ? $event_participant->event->name : null }}"
                                                            readonly>
                                                        @error('event_name')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <tr class="all">
                                                    <td width="20%"><label class="form-label" for="event_date"><span
                                                                class="text-danger">*</span> Date </label></td>
                                                    <td colspan="6">
                                                        <input class="form-control intec" id="event_date" name="event_date"
                                                            value="{{ isset($event_participant) ? $event_participant->event->datetime_start : null }} - {{ isset($event_participant) ? $event_participant->event->datetime_end : null }}"
                                                            readonly>
                                                        @error('event_date')
                                                            <p style="color: red"><strong> {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                </tr>
                                                <input class="form-control intec" id="event_participant_id"
                                                    name="event_participant_id"
                                                    value="{{ isset($event_participant) ? $event_participant->id : null }}"
                                                    hidden>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <th style="text-align: center" width="4%"><label class="form-label"
                                                            for="qHeader">NO.</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">FEEDBACK LIST</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">1</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">2</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">3</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">4</label></th>
                                                    <th style="text-align: center"><label class="form-label"
                                                            for="qHeader">5</label></th>
                                                </div>
                                            </tr>
                                            @foreach ($event_feedback_set->sections as $section)
                                                <tr class="bg-primary text-white">
                                                    <td colspan="7">{{ $section->name }}</td>
                                                </tr>
                                                @foreach ($section->questions as $question)
                                                    <tr class="{{ 's' . $loop->parent->index . 'q' . $loop->index }}">
                                                        <div class="form-group">
                                                            <td style="text-align: center" width="4%"><label
                                                                    for="q{{strtoupper(substr($question->question_type,0,4))}}{{ $question->id }}">{{ $loop->index + 1 }}.</label>
                                                            </td>
                                                            <td width="60%;"><label
                                                                    for="q{{strtoupper(substr($question->question_type,0,4))}}{{ $question->id }}">{{ $question->question }}
                                                                </label>@error('q'.strtoupper(substr($question->question_type,0,4)).$question->id)<b style="color: red"><strong>
                                                                            required
                                                                    </strong></b>@enderror
                                                            </td>
                                                            @if ($question->question_type == 'RATE')
                                                                <td style="text-align: center"><input type="radio"
                                                                        name="q{{strtoupper(substr($question->question_type,0,4))}}{{ $question->id }}"
                                                                        id={{ 'id1s' . $loop->parent->index . 'q' . $loop->index }}
                                                                        value="1"
                                                                        {{ old('q'.strtoupper(substr($question->question_type,0,4)). $question->id) && old('q'.strtoupper(substr($question->question_type,0,4)) . $question->id) == '1' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio"
                                                                        name="q{{strtoupper(substr($question->question_type,0,4))}}{{ $question->id }}"
                                                                        id={{ 'id2s' . $loop->parent->index . 'q' . $loop->index }}
                                                                        value="2"
                                                                        {{ old('q' .strtoupper(substr($question->question_type,0,4)). $question->id) && old('q'.strtoupper(substr($question->question_type,0,4)) . $question->id) == '2' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio"
                                                                        name="q{{strtoupper(substr($question->question_type,0,4))}}{{ $question->id }}"
                                                                        id={{ 'id3s' . $loop->parent->index . 'q' . $loop->index }}
                                                                        value="3"
                                                                        {{ old('q'.strtoupper(substr($question->question_type,0,4)) . $question->id) && old('q'.strtoupper(substr($question->question_type,0,4)) . $question->id) == '3' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio"
                                                                        name="q{{strtoupper(substr($question->question_type,0,4))}}{{ $question->id }}"
                                                                        id={{ 'id4s' . $loop->parent->index . 'q' . $loop->index }}
                                                                        value="4"
                                                                        {{ old('q'.strtoupper(substr($question->question_type,0,4)) . $question->id) && old('q' .strtoupper(substr($question->question_type,0,4)). $question->id) == '4' ? 'checked' : '' }}>
                                                                </td>
                                                                <td style="text-align: center"><input type="radio"
                                                                        name="q{{strtoupper(substr($question->question_type,0,4))}}{{ $question->id }}"
                                                                        id={{ 'id5s' . $loop->parent->index . 'q' . $loop->index }}
                                                                        value="5"
                                                                        {{ old('q'.strtoupper(substr($question->question_type,0,4)) . $question->id) && old('q' .strtoupper(substr($question->question_type,0,4)). $question->id) == '5' ? 'checked' : '' }}>
                                                                </td>
                                                            @elseif($question->question_type == 'TEXT')
                                                                <td colspan="6">{!! Form::textarea('q' .strtoupper(substr($question->question_type,0,4)). $question->id, old('description'), ['class' => 'form-control', 'placeholder' => 'comment', 'id' => 'description']) !!}</td>
                                                            @endif
                                                        </div>
                                                    </tr>
                                                @endforeach

                                            @endforeach

                                        </thead>
                                    </table>

                                    <button style="margin-top: 5px;" class="btn btn-primary float-right mb-2 mr-2"
                                        id="submit" name="submit" {{ isset($event_participant) ? null : 'disabled' }}><i class="fal fa-check"></i> Submit Feedback</button>
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
