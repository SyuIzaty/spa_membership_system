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
                    @if (isset($applicant) )
                        @if ($applicant->applicant_status == '5C')
                        <div class="d-flex justify-content-lg-center">
                            {{-- @foreach ($applicant as $applicants) --}}
                            <div class="p-2">
                                <h3>CONGRATULATIONS {{ $applicant->applicant_name }}</h3>
                                <div class="card">
                                    <div class="card-body">
                                        INTEC Education College is pleased to inform you of your admission to our Institute. <br>Please refer to the attachement below for your offer letter and registration instruction.
                                        <table class="table table-bordered mt-3">
                                            <tr>
                                                <td colspan="2" style="text-align: center">Programme Details</td>
                                            </tr>
                                            <tr>
                                                <td>Programme</td>
                                                <td>{{ $applicant->offeredProgramme->programme_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Major</td>
                                                <td>{{ $applicant->offeredMajor->major_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Duration</td>
                                                <td>{{ $applicant->offeredProgramme->programme_duration }}</td>
                                            </tr>
                                        </table>
                                        <div class="card m-3">
                                            <div class="row">
                                                <div class="col-md-3 ml-3 mb-3">
                                                    <i class="fal fa-file fa-2x mt-3 mr-2"></i><a href="/letter?applicant_id={{ $applicant->id }}">Offer Letter</a>
                                                </div>
                                                @foreach ($applicant->attachmentFile as $all_attachment)
                                                    <div class="col-md-12 ml-3 mb-3">
                                                        <i class="fal fa-file fa-2x mt-3 mr-2"></i><a target="_blank" href="{{ url('attachmentFile')."/".$all_attachment->file_name }}/Download"">{{ $all_attachment->file_name }}</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                        @endif
                        @if ($applicant->applicant_status == '3R')
                        <div class="d-flex justify-content-lg-center">
                            {{-- @foreach ($applicant as $applicants) --}}
                            <div class="p-2">
                                <div class="card">
                                    <div class="card-body">
                                        SORRY YOU DID NOT MEET MINIMUM QUALIFICATION
                                    </div>
                                </div>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                        @endif
                        @if ($applicant->applicant_status == '0' || $applicant->applicant_status == '3G' || $applicant->applicant_status == '4A' || $applicant->applicant_status == '5A')
                        <div class="d-flex justify-content-lg-center">
                            {{-- @foreach ($applicant as $applicants) --}}
                            <div class="p-2">
                                <div class="card">
                                    <div class="card-body">
                                        YOUR APPLICATION IS BEING PROCESSED
                                    </div>
                                </div>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                        @endif
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
