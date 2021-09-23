<div class="row">
    <div class="col-xl-12">

        @if (Session::has('successNewApplication'))
            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;width:100%;">
                <i class="icon fal fa-check-circle"></i>
                {{ Session::get('successNewApplication') }}
            </div>
        @endif

        @if (Session::has('failedNewApplication'))
            <div class="alert alert-danger" style="color: #5b0303; background-color: #ff6c6cc9;">
                <i class="icon fal fa-times-circle"></i>
                {{ Session::get('failedNewApplication') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some
                problems with your
                input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel-container show">
            <div class="panel-content">
                <div class="row row-md-12">
                    <div class="col-sm-6">

                        <div class="d-flex justify-content-center">
                            @if (!isset($event->thumbnail_path))
                                <img src="{{ asset('storage/shortcourse/poster/default/intec_poster.jpg') }}"
                                    class="card-img" style="object-fit: fill;">
                            @else
                                <img src="{{ asset($event->thumbnail_path) }}" class="card-img"
                                    style="object-fit: fill;">
                            @endif
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <h1 class="text-center">
                                        <b class="semi-bold">{{ $event->name }}</b>
                                    </h1>
                                </div>
                                <hr class="mt-2 mb-1">
                                <div class="row">
                                    <div class="col">
                                        <b>Fee</b>
                                    </div>
                                    <div class="col">
                                        @php($index = 0)
                                        |
                                        @foreach ($event->fees as $fee)
                                            @if ($fee->is_base_fee == 1)
                                                RM{{ $fee->amount }}/person ({{ $fee->name }}) |
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col">
                                        <b>Seat Availability</b>
                                    </div>
                                    <div class="col">
                                        {{ $event->total_seat_available }} over {{ $event->max_participant }}
                                        Seats
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col">
                                        <b>From</b>
                                    </div>
                                    <div class="col">
                                        {{ Carbon\Carbon::parse($event->datetime_start)->toDayDateTimeString() }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col">
                                        <b>To</b>
                                    </div>
                                    <div class="col">
                                        {{ Carbon\Carbon::parse($event->datetime_end)->toDayDateTimeString() }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col">
                                        <b>Venue</b>
                                    </div>
                                    <div class="col">
                                        {{ $event->venue->name }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-2">
                                <div class="row d-flex align-items-center justify-content-center">
                                    <button href="javascript:;" id="new-application"
                                        class="btn btn-sm btn-primary btn btn-block call-to-action"
                                        {{ $event->total_seat_available == 0 ? 'disabled' : null }}>Apply
                                        now!</button>
                                </div>
                                <x-ShortCourseManagement.AddParticipant :event=$event edit={{false}}/>

                            </div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <span><em>For any inquries, please contact :-</em></span>
                        <div class="row">
                            @foreach ($event->events_contact_persons as $event_contact_person)
                                <div class="col-sm-6 my-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <b>{{ $event_contact_person->contact_person->user->name }}</b>
                                            <hr class="mt-1 mb-1">
                                            <table class="table table-borderless table-hover"
                                                style="margin-bottom: 0rem">
                                                <tbody>
                                                    <tr>
                                                        <td><i class="ni ni-call-end"></i></td>
                                                        <td>{{ $event_contact_person->contact_person->phone }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><i class="ni ni-envelope"></i></td>
                                                        <td>{{ $event_contact_person->contact_person->user->email }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr class="mt-2 mb-2">
                    </div>

                </div>

                <div class="panel panel-default">
                    <div class="row">
                        <div class="col">
                            <div class="p-5">
                                <h1>Description</h1>

                                {!! $event->description !!}
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-5">
                                <h1> Who should attend?</h1>
                                {!! $event->target_audience !!}
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs nav-tabs-clean" style="padding: 0 15px 0 15px;" role="tablist">
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link active" href="#preview-objective" role="tab">Objective</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#preview-outline" role="tab">Outline</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#preview-tentative" role="tab">Tentative</a>
                        </li>
                    </ul>
                    <div class="tab-content col-md-12 p-5">
                        <div class="tab-pane active" id="preview-objective" role="tabpanel">
                            {!! $event->objective !!}
                        </div>
                        <div class="tab-pane" id="preview-outline" role="tabpanel">
                            {!! $event->outline !!}
                        </div>
                        <div class="tab-pane" id="preview-tentative" role="tabpanel">
                            {!! $event->tentative !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
