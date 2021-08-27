<!DOCTYPE html>
<!--
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.0.0
Author: Sunnyat Ahmmed
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        INTEC Shortcourse
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/vendors.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/app.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="mask-icon" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <!-- Optional: page related CSS-->
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/fa-brands.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <style>
        .logo {
            height: 4.125rem;
            -webkit-box-shadow: 0 0 28px 0 rgb(0 0 0 / 13%);
            box-shadow: 0 0 28px 0 rgb(0 0 0 / 13%);
            overflow: hidden;
            text-align: center;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-positive: 0;
            -webkit-box-flex: 0;
            flex-grow: 0;
            -ms-flex-negative: 0;
            flex-shrink: 0;
            min-height: 1px;
            padding: 0 2rem;
        }

        .logo img {
            height: 70px;
        }

    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="page-inner">
            <div class="page-content-wrapper bg-transparent m-0">
                <div class="height-10 w-100 shadow-sm px-4">
                    <div class="row row-xl-12 justify-content-between">
                        <div
                            class="col col-sm-6 d-flex align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 logo width-mobile-auto m-0">
                            <a href="/shortcourse"><img src="{{ asset('img/intec_logo.png') }}"
                                    alt="INTEC Shourtcourse" aria-roledescription="logo"></a>
                            {{-- <span class="page-logo-text mr-1">INTEC Education College</span> --}}
                        </div>
                        <div
                            class="col col-sm-6 d-flex align-items-center justify-content-center p-0 width-mobile-auto m-0">
                            <form class="form-inline">
                                <input class="form-control mr-sm-2" type="search" placeholder="IC No."
                                    id="ic_input_general" name="ic_input_general" aria-label="Search">
                                <a href="javascript:;" data-toggle="#" id="search-by-ic-general"
                                    class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search/Pay</a>
                            </form>

                        </div>
                    </div>

                </div>

                <div class="card text-center" id="applicant-basic-details" style="display:none;">
                    <div class="card-header">
                        Result
                    </div>
                    {{-- <form action="{{ url('/participant/search-by-ic-general/data') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf --}}
                    <div class="card-body">
                        <input type="hidden" name="ic" id="ic">
                        <h5 class="card-title" id="applicant-basic-details-name"><span class="content"></span></h5>
                        <p class="card-text" id="applicant-basic-details-ic"><span class="content"></span></p>
                        <button type="submit" href="#" class="btn btn-primary" id="ic_details_view"
                            style="display:none;">View</button>
                    </div>
                    {{-- </form> --}}
                    {{-- <div class="card-footer text-muted">
                        2 days ago
                    </div> --}}
                </div>
                {{-- <div class="d-flex flex-1" style="background: url({{asset('img/svg/pattern-1.svg')}} no-repeat center bottom fixed; background-size: cover;"> --}}
                <div class="container text-white d-flex align-items-center justify-content-center">
                    @yield('content')
                    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                        2021 © INTEC Education College&nbsp;|&nbsp;<a href='https://intec.edu.my'
                            class='text-white opacity-40 fw-500' title='gotbootstrap.com'
                            target='_blank'>https://intec.edu.my</a>
                    </div>
                </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
    @yield('script')
    <script src="{{ asset('js/vendors.bundle.js') }}"></script>
    <script src="{{ asset('js/app.bundle.js') }}"></script>

    <script src="{{ asset('js/datagrid/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/notifications/sweetalert2/sweetalert2.bundle.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }} "></script>
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> --}}

    {{-- <script src="{{asset('js/select2.min.js')}}"></script> --}}
    <link rel="stylesheet" media="screen, print" href="{{ asset('css/formplugins/select2/select2.bundle.css') }}">
    <script src="{{ asset('js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ asset('js/jquery.tabledit.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.js') }}"></script>
    <script>
        $('#search-by-ic-general').click(function() {
            var ic = $('#ic_input_general').val();
            $.get("/participant/search-by-ic-general/" + ic, function(data) {
                console.log(data);
                if (data) {
                    $("#applicant-basic-details").show();
                    $("#applicant-basic-details-name .content").replaceWith("<span class='content'>" + data
                        .name + "</span>");
                    $("#applicant-basic-details-ic .content").replaceWith("<span class='content'>" + ic +
                        "</span>");
                    $('#ic').val(ic);
                    $('#ic_details_view').show();
                    console.log("Has Data");
                } else {
                    $("#applicant-basic-details").show();
                    $("#applicant-basic-details-name .content").replaceWith(
                        "<span class='content'>No Data Available</span>");
                    $("#applicant-basic-details-ic .content").replaceWith("<span class='content'>" + ic +
                        "</span>");
                    $('#ic_details_view').hide();
                    // $("#applicant-basic-details-ic").append(data.ic);
                }

            }).done(
                function() {

                }).fail(
                function() {
                    console.log("Fail");
                });
        });

        $('#ic_details_view').click(function() {
            var ic = $('#ic_input_general').val();
            // TODO: Use Ajax to send ic to backend and return sha1 value

            $.get("/participant/get-hash-ic/" + ic, function(data) {
                window.location.href = '/participant/search-by-ic-general/' + data + '/data';
            });
        })
    </script>

</body>

</html>
