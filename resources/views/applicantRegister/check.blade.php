@extends('layouts.applicant')
@section('content')
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            <img src="{{ asset('img/intec_logo.png') }}" class="ml-5"/>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <hr class="mt-2 mb-3">
                    @if (count($applicant) >0)
                        <div class="d-flex justify-content-lg-center">
                            @foreach ($applicant as $applicants)
                            <div class="p-2">
                                <h3>CONGRATULATIONS {{ $applicants->applicant_name }}</h3>
                                <div class="card">
                                    <div class="card-body">
                                        INTEC Education College is pleased to inform you of your admission to our Institute. <br>Please refer to the attachement below for your offer letter and registration instruction.
                                        <table class="table table-bordered mt-3">
                                            <tr>
                                                <td colspan="2" style="text-align: center">Programme Details</td>
                                            </tr>
                                            <tr>
                                                <td>Programme</td>
                                                <td>{{ $applicants->offeredProgramme->programme_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Major</td>
                                                <td>{{ $applicants->offeredMajor->major_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Duration</td>
                                                <td>{{ $applicants->offeredProgramme->programme_duration }}</td>
                                            </tr>
                                        </table>
                                        <div class="card m-3">
                                            <div class="row">
                                                <div class="col-md-3 ml-3 mb-3">
                                                    <i class="fal fa-file fa-2x mt-3"></i><a href="/letter?applicant_id={{ $applicants->id }}">Offer Letter</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex justify-content-lg-center">
                            <div class="p-2">
                                <h3>SORRY YOU DID NOT MEET MINIMUM QUALIFICATION</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
