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
                        <h2>APPLICATION</h2>
                    </div>
                    <div class="d-flex justify-content-lg-center">
                        {{-- @if(isset($intake))
                            <div class="p-2"><a href="{{ route('registration.index') }}" class="btn btn-primary">NEW APPLICATION</a></div>
                        @endif --}}
                        @if(isset($check_applicant))
                            <div class="p-2"><a href="/applicantRegister/check/{{ $check_applicant->id }}" class="btn btn-primary">CHECK APPLICATION</a></div>
                        @endif
                    </div>
                    @foreach($applicant as $applicants)
                        @if($applicants->applicant_status == '00' || $applicants->applicant_status == 'A1')
                            <div class="d-flex justify-content-lg-center">
                                <div class="p-2"><a href="/registration/{{ $applicants->id }}/edit" class="btn btn-primary">Edit Intake {{ $applicants->applicantIntake->intake_code }}</a></div>
                            </div>
                        @endif
                    @endforeach
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
