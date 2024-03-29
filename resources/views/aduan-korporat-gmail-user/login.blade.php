@extends('layouts.public')

@section('content')
    <script src="https://kit.fontawesome.com/5c6c94b6d7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/icomplaint.css') }}">

    <style>
        .box {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            max-width: 100%;
            margin: 55px;
            overflow: hidden;
            color: rgb(0, 0, 0);
            transition: top ease 0.5s;
            top: 0;
            position: relative;
            border-color: #ebebeb;
            border-style: solid;
            border-width: thin;
        }

        .box:hover {
            top: -10px;
        }

        .box-icon {
            background-color: #e86e53;
            color: #fff;
            padding: 30px;
            max-width: 100%;
            width: 100px;
            position: relative;
            font-size: 20px;
        }

        .box-text {
            padding: 30px;
            position: relative;
            width: 100%;
            font-size: 16px;
        }

        .ftco-section {
            padding: 7em 0;
        }

        .justify-content-center {
            -webkit-box-pack: center !important;
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }

        .img,
        .login-wrap {
            width: 50%;
        }

        @media (max-width: 991.98px) {

            .img,
            .login-wrap {
                width: 100%;
            }
        }

        @media (max-width: 767.98px) {
            .wrap .img {
                height: 250px;
            }
        }

        .login-wrap {
            position: relative;
            background: #fff h3;
            background-font-weight: 300;
        }

        .form-group {
            position: relative;
        }

        .form-group .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
            font-weight: 700;
        }

        .form-group a {
            color: gray;
        }

        .wrap {
            width: 100%;
            overflow: hidden;
            background: #fff;
            border-radius: 5px;
            -webkit-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            -moz-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
        }


        @media (max-width: 767.98px) {
            .wrap .img {
                height: 250px;
            }
        }

        .img {
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .img,
        .login-wrap {
            width: 50%;
        }

        @media (max-width: 991.98px) {

            .img,
            .login-wrap {
                width: 100%;
            }
        }

        @media (max-width: 767.98px) {
            .wrap .img {
                height: 250px;
            }
        }

        .login-with-google-btn {
            transition: background-color 0.3s, box-shadow 0.3s;
            padding: 12px 16px 12px 42px;
            border: none;
            border-radius: 3px;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            color: #757575;
            font-size: 14px;
            font-weight: 500;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
            background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
            background-color: white;
            background-repeat: no-repeat;
            background-position: 12px 11px;
        }

        .login-with-google-btn:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        .login-with-google-btn:active {
            background-color: #eeeeee;
        }

        .login-with-google-btn:focus {
            outline: none;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25), 0 0 0 3px #c8dafc;
        }

        .login-with-google-btn:disabled {
            filter: grayscale(100%);
            background-color: #ebebeb;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            cursor: not-allowed;
        }

        body {
            text-align: center;
            padding-top: 2rem;
        }
    </style>
    <main id="js-page-content" role="main" id="main" class="page-content"
        style="background-image: url({{ asset('img/bg4.jpg') }}); background-size: cover">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <img src="{{ asset('img/intec_logo_new.png') }}" style="width: 320px;" /><br>
                            <h1 class="title text-center" style="margin-top: 20px;">
                                i-Complaint
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url({{ asset('img/3.jpg') }});"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h5 class="mb-4">i-Complaint system welcomes public, INTEC staffs and students to
                                        submit complaint, suggestion, enquiry and appreciation.
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    @if ($errors->any())
                                        <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                            <i class="icon fal fa-exclamation-circle"></i> {{ $errors->first() }}
                                        </div>
                                    @endif

                                    {!! Form::open(['url' => 'auth/gmail', 'method' => 'get']) !!}

                                    <button type="submit" id="submit" name="submit" class="login-with-google-btn">
                                        Sign in with Google
                                    </button>

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('aduan-korporat.footer')
    </main>
@endsection
@section('script')
    <script></script>
@endsection
