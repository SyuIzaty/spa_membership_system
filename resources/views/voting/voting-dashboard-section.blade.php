<style>
    .chart-container {
        width: 50%; /* Set the desired width */
        height: 50%; /* Set the desired height */
    }

    .bar-chart-container {
        width: 70%; /* Set width to 100% of parent */
        height: 70%; /* Set height to 100% of parent */
    }
</style>

@if($voteData)

    <h2 style="text-align: center">
        <b>{{ strtoupper($voteData->name) }}</b><br>
        <small>[
        {{ date('d-m-Y', strtotime($voteData->start_date)) . ' | ' . date('h:i A', strtotime($voteData->start_date)) }}
        -
        {{ date('d-m-Y', strtotime($voteData->end_date)) . ' | ' . date('h:i A', strtotime($voteData->end_date)) }}
        ]</small>
        @if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($voteData->end_date))
            <b style="color:green"> - Complete Voting - </b>
        @elseif (\Carbon\Carbon::now() >= \Carbon\Carbon::parse($voteData->start_date) && \Carbon\Carbon::now() <= \Carbon\Carbon::parse($voteData->end_date))
            <b style="color:red"> - Active Voting - </b>
        @else
            <b style="color:orange">- Upcoming Voting -</b>
        @endif
    </h2><br>

    {{-- <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
    <div class="toast-header">
        <img src="img/logo.png" alt="brand-logo" height="16" class="mr-2">
        <strong class="mr-auto">COUNTDOWN</strong>
    </div>
    <div class="toast-body">
        <h1>
            <b style="color:red">
                <span id="countdown"></span>
            </b>
        </h1>
    </div>
    </div> --}}

    <div class="row mb-4">
        <div class="col-sm-12 col-xl-4">
            <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{ $voteData->categories->count() }}
                        <small class="m-0 l-h-n">Total Overall Category</small>
                    </h3>
                </div>
                <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
            </div>
        </div>
        @php
            $totalProgrammes = 0;
            $totalCandidates = 0;

            foreach ($voteData->categories as $category) {
                $totalProgrammes += count($category->programmes);

                foreach ($category->programmes as $programme) {
                    $totalCandidates += count($programme->candidates);
                }
            }
        @endphp
        <div class="col-sm-12 col-xl-4">
            <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{ $totalProgrammes }}
                        <small class="m-0 l-h-n">Total Overall Programme</small>
                    </h3>
                </div>
                <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
            </div>
        </div>
        <div class="col-sm-12 col-xl-4">
            <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                <div class="">
                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                        {{ $totalCandidates }}
                        <small class="m-0 l-h-n">Total Overall Candidate</small>
                    </h3>
                </div>
                <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
            </div>
        </div>
    </div>

    @foreach($voteData->categories as $key => $category)
        <div class="card mb-g">
            <div class="row row-grid no-gutters">
                <div class="col-sm-12 col-xl-12 text-center">
                    <div class="p-3">
                        <p class="mb-0 fs-xl">
                            <b style="font-family: initial; font-size: 30px">{{ strtoupper($category->category_name) }}</b>
                        </p>
                    </div>
                </div>
                @foreach($category->programmes as $programmeKey => $programme)
                    @php
                        $activeStudent = \App\Student::where('students_programme', $programme->programme_code)->where('students_status', 'AKTIF')->count();

                        $engageVoter = \App\EvmVoter::where('voter_programme', $programme->programme_code)->whereHas('candidate', function($query) use($category, $voteData){
                            $query->whereHas('programme', function($subQuery) use($category, $voteData){
                                $subQuery->whereHas('category', function($subSubQuery) use($category, $voteData){
                                    $subSubQuery->where('id', $category->id)->where('vote_id', $voteData->id);
                                });
                            });
                        })->count();

                        $disengageVoter = $activeStudent - $engageVoter;

                        // $engagePercent = ($engageVoter / $activeStudent) * 100;

                        // $disengagePercent = ($disengageVoter / $activeStudent) * 100;

                        if ($activeStudent > 0) {
                            $engagePercent = ($engageVoter / $activeStudent) * 100;
                            $disengagePercent = ($disengageVoter / $activeStudent) * 100;
                        } else {
                            $engagePercent = 0;
                            $disengagePercent = 0;
                        }
                    @endphp
                    <div class="col-sm-12 col-xl-12">
                        <div class="p-3">
                            <ul>
                                <li>
                                    <p class="text-muted">
                                        {{ $programme->programme->programme_name ?? 'N/A'}}
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4" align="center">
                        <div class="p-3">
                            <b>Participation Chart</b><br><br>
                            <div class="chart-container">
                                <canvas id="pieChart{{ $key }}_{{ $programmeKey }}"></canvas>
                            </div>
                            <script>
                                // Function to generate a random color
                                function getRandomColor() {
                                    var letters = '0123456789ABCDEF';
                                    var color = '#';
                                    for (var i = 0; i < 6; i++) {
                                        color += letters[Math.floor(Math.random() * 16)];
                                    }
                                    return color;
                                }

                                // Function to create pie charts with random colors
                                function createRandomColorPieChart(canvasId, engagedCount, disengagedCount, width, height) {
                                    var ctx = document.getElementById(canvasId);
                                    if (ctx) {
                                        // Set the canvas width and height
                                        ctx.width = width;
                                        ctx.height = height;

                                        // Generate random colors
                                        var randomBackgroundColorEngaged = getRandomColor();
                                        var randomBackgroundColorDisengaged = getRandomColor();

                                        var pieChart = new Chart(ctx, {
                                            type: 'pie',
                                            data: {
                                                labels: ['Engaged', 'Disengaged'],
                                                datasets: [{
                                                    data: [engagedCount, disengagedCount],
                                                    backgroundColor: [randomBackgroundColorEngaged, randomBackgroundColorDisengaged],
                                                }],
                                            },
                                        });
                                    }
                                }

                                // Get engaged and disengaged voter counts for this specific program
                                var engagedVoterCount_{{ $key }}_{{ $programmeKey }} = {{ $engageVoter }};
                                var disengagedVoterCount_{{ $key }}_{{ $programmeKey }} = {{ $disengageVoter }};

                                // Create the pie chart with random colors and a specified width and height
                                createRandomColorPieChart("pieChart{{ $key }}_{{ $programmeKey }}", engagedVoterCount_{{ $key }}_{{ $programmeKey }}, disengagedVoterCount_{{ $key }}_{{ $programmeKey }}, 200, 200); // Adjust width and height as needed
                            </script>
                            <br>
                            <table class="table m-0 table-bordered table-hover table-striped text-center">
                                <thead>
                                    <tr>
                                        <td>Engaged Voters</td>
                                        <th><b>{{ $engageVoter }} ({{ number_format($engagePercent, 2) }}%)</b></th>
                                    </tr>
                                    <tr>
                                        <td>Disengaged Voters</td>
                                        <th><b>{{ $disengageVoter }} ({{ number_format($disengagePercent, 2) }}%)</b></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-8" align="center">
                        <div class="p-3">
                            @php
                                $programmeWithCandidates = $programme->with('candidates')->find($programme->id);
                                $candidates = $programmeWithCandidates->candidates;
                            @endphp
                            <b>Total Candidate Cast Vote</b><br><br>
                            <div class="bar-chart-container">
                                <canvas id="barChart{{ $key }}_{{ $programmeKey }}"></canvas>
                            </div>
                            <script>
                                // Function to generate random colors
                                function getRandomColor() {
                                    var letters = '0123456789ABCDEF';
                                    var color = '#';
                                    for (var i = 0; i < 6; i++) {
                                        color += letters[Math.floor(Math.random() * 16)];
                                    }
                                    return color;
                                }

                                // Get candidates and cast votes for this specific program
                                var candidates_{{ $key }}_{{ $programmeKey }} = @json($candidates);
                                var candidateNames_{{ $key }}_{{ $programmeKey }} = candidates_{{ $key }}_{{ $programmeKey }}.map(function(candidate) {
                                    return candidate.student_id;
                                });
                                var castVotes_{{ $key }}_{{ $programmeKey }} = candidates_{{ $key }}_{{ $programmeKey }}.map(function(candidate) {
                                    return candidate.cast_vote;
                                });

                                // Generate random colors for bars
                                var backgroundColors_{{ $key }}_{{ $programmeKey }} = [];
                                for (var i = 0; i < candidates_{{ $key }}_{{ $programmeKey }}.length; i++) {
                                    backgroundColors_{{ $key }}_{{ $programmeKey }}.push(getRandomColor());
                                }

                                // Create the bar graph with random colors
                                var ctx_bar_{{ $key }}_{{ $programmeKey }} = document.getElementById('barChart{{ $key }}_{{ $programmeKey }}');
                                if (ctx_bar_{{ $key }}_{{ $programmeKey }}) {
                                    var barChart_{{ $key }}_{{ $programmeKey }} = new Chart(ctx_bar_{{ $key }}_{{ $programmeKey }}, {
                                        type: 'bar',
                                        data: {
                                            labels: candidateNames_{{ $key }}_{{ $programmeKey }},
                                            datasets: [{
                                                label: 'Cast Votes',
                                                data: castVotes_{{ $key }}_{{ $programmeKey }},
                                                backgroundColor: backgroundColors_{{ $key }}_{{ $programmeKey }},
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                }
                            </script>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

@else

    <p>No information to display.</p>

@endif
