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
        <link rel="stylesheet" media="screen, print" href="{{asset('css/vendors.bundle.css')}}">
        <link rel="stylesheet" media="screen, print" href="{{asset('css/app.bundle.css')}}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/favicon/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('img/favicon/favicon-32x32.png')}}">
        <link rel="mask-icon" href="{{asset('img/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
        <!-- Optional: page related CSS-->
        <link rel="stylesheet" media="screen, print" href="{{asset('css/fa-brands.css')}}">
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
            .logo img{
                height:70px;
            }
        </style>
    </head>
    <body>
        <div class="page-wrapper">
    <div class="page-inner">
        <div class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-sm px-4">
                <div class="d-flex align-items-center container p-0">
                    <div class="logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                        <img src="{{asset('img/intec_logo.png')}}" alt="SmartAdmin WebApp" aria-roledescription="logo">
                        {{-- <span class="page-logo-text mr-1">INTEC Education College</span> --}}
                    </div>
                </div>
            </div>
            {{-- <div class="d-flex flex-1" style="background: url({{asset('img/svg/pattern-1.svg')}} no-repeat center bottom fixed; background-size: cover;"> --}}
                <div class="container py-4 py-lg-5 px-4 px-sm-0 text-white d-flex align-items-center justify-content-center">
                    @yield('content')
                    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                        2021 © INTEC Education College&nbsp;|&nbsp;<a href='https://intec.edu.my' class='text-white opacity-40 fw-500' title='gotbootstrap.com' target='_blank'>https://intec.edu.my</a>
                    </div>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>

<script src="{{asset('js/vendors.bundle.js')}}"></script>
<script src="{{asset('js/app.bundle.js')}}"></script>

</body>
</html>