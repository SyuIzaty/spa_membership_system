@extends('layouts.covid')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo.png') }}" style="max-width: 100%"
                                        class="responsive" /></center><br>
                                <h4 style="text-align: center">
                                    <b>INTEC EDUCATION COLLEGE EVENT EVALUATION FORM</b>
                                </h4>
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
