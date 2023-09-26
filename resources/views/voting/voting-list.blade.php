@extends('layouts.admin')

@section('content')

<style>
    .hoverable-row {
        position: relative;
    }

    .hoverable-row:hover::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(99, 92, 92, 0.661);
        z-index: 1;
    }

    .click-here-button {
        color: white;
        background-color: #007bff;
        padding: 10px 20px;
        border-radius: 15px;
        text-decoration: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        display: none;
    }

    .hoverable-row:hover .click-here-button {
        display: block;
    }
</style>

<main id="js-page-content" role="main" class="page-content">

    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
        <li class="breadcrumb-item">eVoting</li>
        <li class="breadcrumb-item active">Voting Official Platform</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date">{{ \Carbon\Carbon::now()->format('d-m-Y | h:i A') }}</span></li>
    </ol>

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-box-check"></i> Voting <span class="fw-300">Official Platform</span>
        </h1>
    </div>

    <div class="row">
        @if(count($vote) > 0)
            @foreach($vote as $votes)
                <div class="col-sm-12 col-xl-12">
                    <div class="card mb-g">
                        <div class="card-body pb-0 px-4">
                            <div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
                                <div class="d-inline-block align-middle status status-success mr-3">
                                    <span class="profile-image rounded-circle d-block" style="background-image:url('img/vote-img1.png'); background-size: cover;"></span>
                                </div>
                                <h2 class="mb-0 mt-2 flex-1 text-dark fw-500">
                                    {{ strtoupper($votes->name) }}
                                </h2>
                                <span class="text-muted fs-xs opacity-70">
                                    <b style="color:red">
                                        <span id="countdown_{{ $votes->id }}"></span>
                                    </b>
                                </span>
                            </div>
                            <p>
                                <b style="color:red">
                                    Start Date : {{ isset($votes->start_date) ? \Carbon\Carbon::parse($votes->start_date)->format('d-m-Y | h:i A') : '' }}
                                    -
                                    End Date : {{ isset($votes->end_date) ? \Carbon\Carbon::parse($votes->end_date)->format('d-m-Y | h:i A') : '' }}
                                </b>
                            </p>
                            <div class="row">
                                @foreach($votes->categories->filter(function($category) use ($student) {
                                    return $category->programmes->where('programme_code', $student->students_programme)->isNotEmpty() &&
                                           count($category->programmes->flatMap->candidates) > 1;
                                }) as $category)
                                <div class="col-sm-12 col-xl-3">
                                    <div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
                                        <div class="row no-gutters hoverable-row">
                                            <div class="col-2 col-sm-4" style="background-image:url('img/vote-img2.png'); background-size: cover; height: 130px; border: solid 1px #dee2e6"></div>
                                            <div class="col d-flex align-items-center" style="border: solid 1px #dee2e6; border-left-width: 0; height: 130px;">
                                                <div class="bg-faded flex-1 p-4">
                                                    <h3 class="text-dark fw-500">
                                                        {{ strtoupper($category->category_name) }}
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="overlay">
                                                <a class="btn btn-outline-info btn-pills waves-effect waves-themed click-here-button"
                                                href="{{ route('voting-platform.show', ['voting_platform' => $category->id]) }}">Vote Here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div align="center" class="alert alert-danger alert-dismissible fade show mx-auto col-xs-12 col-xl-12">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
                <div class="d-flex align-items-center">
                    <div class="flex-1 pl-1">
                        Voting is presently <b>NOT ACCESSIBLE</b>. Please return when it has begun at the designated date and time.
                    </div>
                </div>
            </div>
        @endif
    </div>

</main>

@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to update a countdown timer
    function updateCountdown(endDate, countdownElementId) {
        var now = new Date().getTime(); // Current date and time
        var distance = endDate - now;   // Calculate the time remaining

        // Calculate days, hours, minutes, and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the countdown timer in the specified element
        document.getElementById(countdownElementId).innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the countdown is over, display a message
        if (distance < 0) {
            document.getElementById(countdownElementId).innerHTML = "Countdown expired";
        }
    }

    @foreach($vote as $votes)
        // Get the start date and end date from your Laravel object (replace with your actual variables)
        var startDate_{{ $votes->id }} = new Date("{{ $votes->start_date }}").getTime();
        var endDate_{{ $votes->id }} = new Date("{{ $votes->end_date }}").getTime();

        // Define a unique ID for each countdown element, based on $votes->id
        var countdownElementId_{{ $votes->id }} = "countdown_{{ $votes->id }}";

        // Update the countdown for this element every 1 second
        var countdownInterval_{{ $votes->id }} = setInterval(function() {
            updateCountdown(endDate_{{ $votes->id }}, countdownElementId_{{ $votes->id }});
        }, 1000);
    @endforeach
</script>

@endsection

