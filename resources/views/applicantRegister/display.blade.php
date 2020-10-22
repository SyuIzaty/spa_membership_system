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
                    <div class="d-flex justify-content-lg-center">
                        @if($check_applicant != 'NULL')
                            <div class="row">
                                <div class="d-flex justify-content-lg-center col-md-12">
                                    <h2>CHECK APPLICATION</h2>
                                </div>
                                <div class="d-flex justify-content-lg-center col-md-12">
                                    If you have made application for any INTEC programme before and <br>wish to continue with your application, Click the button below
                                </div>
                                <div class="d-flex justify-content-lg-center col-md-12">
                                    <div class="p-2"><a href="/applicantRegister/check/{{ $check_applicant->id }}" class="btn btn-primary mt-3">CHECK APPLICATION</a></div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <hr class="mt-2 mb-3" style="border: 1px solid #ececec">
                    @if($applicant != 'NULL')
                        <div class="d-flex justify-content-lg-center">
                            <h2>EDIT APPLICATION</h2>
                        </div>
                        @foreach($applicant as $applicants)
                            @if($applicants->applicant_status == '00' || $applicants->applicant_status == '0')
                                <div class="d-flex justify-content-lg-center">
                                    <div class="p-2"><p>If you wish to continue with your application, click on the button below</p></div>
                                </div>
                                <div class="d-flex justify-content-lg-center">
                                    <div class="p-2"><a href="/registration/{{ $applicants->id }}/edit" class="btn btn-primary">EDIT INTAKE {{ $applicants->applicantIntake->intake_code }}</a></div>
                                </div>
                            @endif
                            @if($applicants->applicant_status == '4A' || $applicants->applicant_status == '3G' || $applicants->applicant_status == '3R' || $applicants->applicant_status == '5A')
                                <div class="d-flex justify-content-lg-center">
                                    <div class="p-2">
                                        <div class="card">
                                            <div class="card-body">
                                                Your application is being processed. You are not allowed to edit you details. Thank you
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('script')
<script>

</script>
@endsection
