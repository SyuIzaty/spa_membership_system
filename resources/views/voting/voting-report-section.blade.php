@if($voteData)
    <div class="col-md-12 mt-2 pr-0 text-right">
        <a href="{{ route('voting-pdf', ['voteData' => $voteData->id]) }}" onclick="openPrintWindow(event)" target="_blank" class="btn btn-primary"><i class="fal fa-file-pdf"></i> Print PDF Report</a>
    </div>
    <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
    <h4 style="text-align: center">
        <b>VOTING REPORT : {{ strtoupper($voteData->name) }}</b><br>
        <small>[
        {{ date('d-m-Y', strtotime($voteData->start_date)) . ' | ' . date('h:i A', strtotime($voteData->start_date)) }}
        -
        {{ date('d-m-Y', strtotime($voteData->end_date)) . ' | ' . date('h:i A', strtotime($voteData->end_date)) }}
        ]</small>
    </h4>
    @foreach($voteData->categories as $key => $category)
        <div class="card mb-g mt-4">
            <div class="row row-grid no-gutters">
                <div class="col-12" style="background-color: #e6dede">
                    <div class="p-3">
                        <h2 class="mb-0 fs-xl">
                            <b>{{ strtoupper($category->category_name) }}</b>
                        </h2>
                        <small>{{ $category->category_description }}</small>
                    </div>
                </div>
                <div class="col-12">
                    @foreach($category->programmes as $key => $programme)
                        <div class="p-3">
                            <h5 class="text-danger">
                                Programme Information
                            </h5>
                            <ul>
                                <li>
                                    <p class="text-muted">
                                        {{ $programme->programme_code }} - {{ $programme->programme->programme_name }}
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <hr class="m-0 p-0">
                        <div class="p-3">
                            <h5 class="text-danger">
                                General Information
                            </h5>
                            <ul>
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
                                <li>
                                    <p class="text-muted">
                                        Total Active Students: {{ $activeStudent }}
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted">
                                        Total Engaged Voters: {{ $engageVoter }} ({{ number_format($engagePercent, 2) }}%)
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted">
                                        Total Disengaged Voters: {{ $disengageVoter }} ({{ number_format($disengagePercent, 2) }}%)
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <hr class="m-0 p-0">
                        <div class="p-3">
                            <h5 class="text-danger">
                                Candidate Result Information
                            </h5>
                            <ul>
                                <li>
                                    <p class="text-muted">
                                        @php
                                            $finalCandidate = $programme->candidates->first(function ($candidate) {
                                                return $candidate->verify_status === 'Y';
                                            });
                                        @endphp
                                        @if ($finalCandidate)
                                            <p>
                                                Candidate <b><u>{{$finalCandidate->student->students_name ?? 'N/A'}}</u></b> has been verified and subsequently declared as the chosen winner in this category of voting.
                                             </p>
                                        @else
                                             <p>
                                                No verified candidate in this category of voting.
                                             </p>
                                        @endif
                                    </p>
                                </li>
                            </ul>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="text-center" style="white-space: nowrap">
                                            <th style="width:30px">No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Programme</th>
                                            <th>Session</th>
                                            <th>Cast Vote</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($programme->candidates as $candidate)
                                            @php
                                                $votesCast = $candidate->cast_vote;
                                                $totalVoters = $engageVoter;
                                                // Check if $totalVoters is not zero before performing division
                                                $candidatePercentage = ($totalVoters !== 0) ? ($votesCast / $totalVoters) * 100 : 0;
                                            @endphp
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $candidate->student_id ?? 'N/A' }}</td>
                                                <td>{{ $candidate->student->students_name ?? 'N/A' }}</td>
                                                <td>{{ $candidate->student->gender->gender_name ?? 'N/A' }}</td>
                                                <td>{{ $candidate->student_programme ?? 'N/A' }}</td>
                                                <td>{{ $candidate->student_session ?? 'N/A' }}</td>
                                                <td>{{ $candidate->cast_vote ?? '0' }} ({{ number_format($candidatePercentage, 2) }}%)</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="mt-4">No information to display.</p>
@endif
