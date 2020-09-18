@extends('layouts.applicant')
@section('content')
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <img src="{{ public_path('img/intec_offer.png') }}" style="height: 170px; width: 650px;">
                </div>
                <div class="card-body">
                    <h2>NEW APPLICATION / CHECK APPLICATION</h2>
                    <p>If you wish to apply for any INTEC programme or check your application, click on one of the button below.</p>
                    <div class="d-flex justify-content-center">
                        <div class="p-2"><a href="{{ route('registration.index') }}" class="btn btn-primary">NEW APPLICATION</a></div>
                        <div class="p-2"><a href="{{ route('register.index') }}" class="btn btn-primary">CHECK APPLICATION</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
