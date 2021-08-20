@extends('layouts.covid')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    {{-- <div class="card-header" style="background-image: url({{asset('img/coronavirus.png')}}); background-size: cover"> --}}
                    <div class="card-header">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo.png') }}" style="max-width: 100%"
                                        class="responsive" /></center><br>
                                <h4 style="text-align: center">
                                    <b>INTEC EDUCATION COLLEGE EVENT EVALUATION FORM</b>
                                </h4>
                                {{-- <p style="padding-left: 40px; padding-right: 40px">
                                *<i><b>IMPORTANT!</b></i> : All staff, student and visitor are required to make a daily declaration of COVID-19 risk screening on every working day (whether working in the office or from home) as prevention measures.
                                However, you are encouraged to make a declaration on a daily basis including public holidays and other holidays.
                            </p> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card-body text-center">
                        <h1>Your feedback have been submitted. Thank you for your cooperation.</h1>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
