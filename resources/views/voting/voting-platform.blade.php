@extends('layouts.admin')

@section('content')

<style>
    .custom-checkbox {
        position: relative;
        cursor: pointer;
    }

    .custom-checkbox input[type="checkbox"] {
        display: none;
    }

    .custom-checkbox .custom-checkbox-icon {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px; /* Adjust the size of the checkbox container */
        height: 40px; /* Adjust the size of the checkbox container */
        background-color: #ffffff;
        border: 1px solid #000000;
        text-align: center;
        line-height: 38px; /* Adjust to vertically center the 'X' */
        font-weight: bold;
    }

    .custom-checkbox input[type="checkbox"]:checked + .custom-checkbox-icon::before {
        content: 'X';
        width: 100%; /* Make 'X' fill the checkbox horizontally */
        height: 100%; /* Make 'X' fill the checkbox vertically */
        line-height: 40px; /* Vertically center 'X' */
        font-size: 40px; /* Adjust the size of 'X' as needed */
    }

    .custom-checkbox input[type="checkbox"]:not(:checked) + .custom-checkbox-icon::before {
        content: '';
    }
</style>

<main id="js-page-content" role="main" class="page-content">

    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
        <li class="breadcrumb-item">eVoting</li>
        <li class="breadcrumb-item active">Voting Official Platform</li>
        <li class="breadcrumb-item active">Voting Candidate</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date">{{ \Carbon\Carbon::now()->format('d-m-Y | h:i A') }}</span></li>
    </ol>

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-box-check"></i> {{ ucwords($category->vote->name) }} <span class="fw-300"> Candidate</span>
        </h1>
    </div>
    @php
        $exist = \App\EvmCandidate::where('student_id', '2021039049')->whereHas('programme', function($query) use($category){
            $query->whereHas('category', function($subQuery) use($category){
                $subQuery->where('id', $category->id);
            });
        })->first();
    @endphp
    @if(!isset($exist))
        <div align="center">
            <div class="alert alert-danger alert-dismissible fade show mx-auto">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
                <div class="d-flex align-items-center">
                    <div class="flex-1 pl-1">
                        <span class="text-muted fs-xs opacity-70">
                            <h1><b style="color:red">
                                <span id="countdown"></span>
                            </b></h1>
                        </span>
                        You are required to cast a vote. To return to the platform, please click here : <a href="/voting-platform" title="Return to Platform" style="text-decoration: underline; font-weight: bold;"><u>Return to Platform</u></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($candidate as $candidates)
                <div class="col-sm-12 col-xl-6">
                    <div class="card mb-g">
                        <div class="card-body pb-0 px-4">
                            <table class="table table-bordered table-hover table-striped w-100">
                                <tr>
                                    <td style="vertical-align: middle;" rowspan="3" width="35%">
                                        <div style="display: flex; align-items: center; text-align: left; margin-right: 10px;">
                                            <label class="custom-checkbox">
                                                <input type="checkbox" class="candidate-checkbox" data-id="{{ $candidates->id }}" style="display: none;">
                                                <span class="custom-checkbox-icon"></span>
                                            </label>
                                        </div>
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            @if(isset($candidates->img_name))
                                                <a data-fancybox="gallery" href="/get-candidate-image/{{ $candidates->img_name }}">
                                                    <img src="/get-candidate-image/{{ $candidates->img_name }}" style="width: 200px; height: 200px;" class="img-fluid">
                                                </a>
                                            @else
                                                <img src="{{ asset('img/default.png') }}" style="width: 200px; height: 200px;">
                                            @endif
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <h3><b>{{$candidates->student->students_name ?? 'N/A'}}</b></h3>
                                        <small>{{$candidates->student->programmes->programme_name ?? 'N/A'}}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle">
                                        <h4>" {{$candidates->student_tagline}} "</h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div align="center">
            <div class="alert alert-danger alert-dismissible fade show mx-auto">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
                <div class="d-flex align-items-center">
                    <div class="flex-1 pl-1">
                        Congratulations! Your vote has been successfully cast. To return to the platform, please click here : <a href="/voting-platform" title="Return to Platform" style="text-decoration: underline; font-weight: bold;"><u>Return to Platform</u></a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</main>

@endsection

@section('script')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- <script src="/path/to/node_modules/axios/dist/axios.min.js"></script> --}}

    <script>
        // Function to update the countdown timer
        function updateCountdown(endDate) {
            var now = new Date().getTime(); // Current date and time
            var distance = endDate - now;   // Calculate the time remaining

            // Calculate days, hours, minutes, and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the countdown timer
            document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";

            // If the countdown is over, display a message
            if (distance < 0) {
                document.getElementById("countdown").innerHTML = "Countdown expired";
            }
        }

        // Get the start date and end date from your Laravel object (replace with your actual variables)
        var startDate = new Date("{{ $category->vote->start_date }}").getTime();
        var endDate = new Date("{{ $category->vote->end_date }}").getTime();

        // Update the countdown every 1 second
        var countdownInterval = setInterval(function() {
            updateCountdown(endDate);
        }, 1000);
    </script>

    <script>
        // Function to cast vote
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".candidate-checkbox");

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener("change", function () {
                    const candidateId = this.getAttribute("data-id");
                    if (this.checked) {
                        console.log('Check');
                        Swal.fire({
                            title: "Confirm Vote",
                            text: "Are you sure you want to vote for this candidate?",
                            icon: "question",
                            showCancelButton: true,
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                        }).then((result) => {
                            if (result.value) {
                                axios.post('/voting-store', { candidate_id: candidateId })
                                    .then(() => {
                                        location.reload();
                                    })
                                    .catch((error) => {
                                        console.error(error);
                                    });
                            } else {
                                this.checked = false;
                            }
                        });
                    } else {
                        console.log('Uncheck');
                    }
                });
            });
        });

    </script>


@endsection

