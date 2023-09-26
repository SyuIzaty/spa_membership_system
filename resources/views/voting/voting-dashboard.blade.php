@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content">

    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
        <li class="breadcrumb-item">eVoting</li>
        <li class="breadcrumb-item active">Voting Dashboard</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date">{{ Carbon\Carbon::now() }}</span></li>
    </ol>

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-chart-area"></i> Analytics <span class="fw-300">Dashboard</span>
        </h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-12 col-sm-12 mb-3">
            <form action="{{ route('voting-dashboard') }}" method="GET" id="form_find">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <select name="vote" id="vote" class="form-control">
                            <option value="" disabled selected> Please select</option>
                            @foreach ($vote as $votes)
                                <option value="{{ $votes->id }}" {{ $selectedVote == $votes->id ? 'selected' : '' }}>{{ strtoupper($votes->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
            <div id="spinner" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 sortable-grid ui-sortable">
            <div id="chart-section">
                <!-- The chart section content will be loaded dynamically here -->
            </div>
        </div>
    </div>

</main>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#vote').select2();

        $('#vote').on('change', function() {
            var selectedVote = $(this).val();

            $('#spinner').show();

            $.ajax({
                url: '{{ route('voting-dashboard') }}',
                type: 'GET',
                data: { vote: selectedVote },
                success: function(data) {
                    $('#spinner').hide();

                    $('#chart-section').html(data);
                },
                error: function() {
                    $('#spinner').hide();
                    alert('An error occurred.');
                }
            });
        });
    });
</script>

{{-- <script>
    $('#vote').on('change', function() {
        var selectedVote = $(this).val();

        var startDate = null;
        var endDate = null;

        $.ajax({
            type: 'GET',
            url: '/get-voting-date/' + selectedVote,
            success: function(response) {
                if (response.success) {
                    startDate = new Date(response.start_date).getTime();
                    endDate = new Date(response.end_date).getTime();
                    console.log(startDate, endDate);

                    function updateCountdown(endDate) {
                        var now = new Date().getTime();
                        var distance = endDate - now;

                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
                        + minutes + "m " + seconds + "s ";

                        if (distance < 0) {
                            document.getElementById("countdown").innerHTML = "Countdown expired";
                        }
                    }

                    if (endDate !== null && endDate > 0) {
                        var countdownInterval = setInterval(function() {
                            updateCountdown(endDate);
                        }, 1000);
                    }
                } else {
                    console.error('Failed to fetch vote dates');
                }
            },
            error: function() {
                console.error('An error occurred while fetching vote dates');
            }
        });
    });
</script> --}}

@endsection

