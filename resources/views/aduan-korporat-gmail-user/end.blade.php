@extends('layouts.public')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@700&display=swap');

        .title {
            font-family: 'Sora', sans-serif;
            font-size: 30px;

        }
    </style>
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg4.jpg') }}); background-size: cover">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-size: cover">
                        <div class="d-flex justify-content-center" style="color: black">
                            <div class="p-2">
                                <center><img src="{{ asset('img/intec_logo_new.png') }}"
                                        style="height: 120px; width: 320px;" class="responsive" /></center><br>
                                <h2 style="text-align: center" class="title">
                                    i-Complaint
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="jumbotron text-center">
                                    <h1 class="display-3">Thank You!</h1>
                                    <p class="lead">Your reference number is<strong> {{ $decryptTicket }}</strong>.</p>
                                    <p class="lead"><strong>Please check your email</strong> for any update.</p>
                                    <hr>
                                    <p class="lead">
                                        <a class="btn btn-primary btn-sm" href="/iComplaint-public/{{ $id }}"
                                            role="button">Continue to
                                            homepage</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
@endsection
