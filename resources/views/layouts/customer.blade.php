<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name', 'Raudhah Serenity') }}</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/img/favicon/apple-touch-icon.jpg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/img/favicon/favicon-32x32.jpg') }}">
        <link rel="mask-icon" href="{{ asset('admin/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="{{ asset('customer/lib/animate/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('customer/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('customer/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('customer/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('customer/css/style.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=PT+Serif:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .custom-picker::-webkit-calendar-picker-indicator {
                filter: invert(1);
                cursor: pointer;
                position: absolute;
                right: 10px;
                padding-left: 300px;
            }
        </style>
    </head>
    <body>
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <div class="container-fluid sticky-top px-0">
            <div class="container-fluid topbar d-none d-lg-block">
                <div class="container px-0">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <div class="d-flex flex-wrap">
                                <a href="https://maps.app.goo.gl/KveTdJHsU8461BYJ8" class="me-4 text-light"><i class="fas fa-map-marker-alt text-primary me-2"></i>Find A Location</a>
                                <a href="#" class="me-4 text-light"><i class="fas fa-phone-alt text-primary me-2"></i>(+60) 3-1234 5678</a>
                                <a href="#" class="text-light"><i class="fas fa-envelope text-primary me-2"></i> info@raudhahserenity.com</a>
                            </div>
                        </div>
                        <div class="col-lg-5 text-lg-end">
                            @if(Auth::check())
                                @php
                                    $mem = \App\Customer::where('user_id', Auth::user()->id)->whereHas('customerPlans', function ($query) {
                                                $query->active();
                                            })->first();
                                @endphp
                                <span class="text-light">Welcome, {{ Auth::user()->customer->customer_name }}
                                    @if(isset($mem))
                                        (Member)
                                    @else
                                        (Non-Member)
                                    @endif
                                </span>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-primary-outline-0 rounded-pill py-1 px-4 ms-4"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                </form>
                            @else
                                <span class="text-light"><a href="/login" class="btn btn-primary btn-primary-outline-0 rounded-pill py-1 px-4 ms-4"> <i class="fas fa-sign-in-alt"></i> Login</a></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid bg-light">
                <div class="container px-0" style="max-width: 1450px">
                    <nav class="navbar navbar-light navbar-expand-xl">
                        <a href="/home" class="navbar-brand">
                            <h1 class="text-primary display-4">Raudhah Serenity Spa</h1>
                        </a>
                        <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                            <span class="fa fa-bars text-primary"></span>
                        </button>
                        <div class="collapse navbar-collapse bg-light py-3" id="navbarCollapse">
                            <div class="navbar-nav mx-auto border-top">
                                <a href="/home" class="nav-item nav-link active">Home</a>
                                <a href="/about" class="nav-item nav-link">About</a>
                                <a href="/service" class="nav-item nav-link">Service</a>
                                <a href="/membership" class="nav-item nav-link">Membership</a>
                                <a href="/contact" class="nav-item nav-link">Contact Us</a>
                            </div>
                            <div class="d-flex align-items-center flex-nowrap pt-xl-0">
                                @if(Auth::check())
                                    <a href="/profile" class="btn btn-primary btn-primary-outline-0 rounded-circle btn-lg-square"><i class="fas fa-user"></i></a>
                                @endif
                                <a href="/booking" class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-4 ms-4">Book Appointment</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        @yield('content')
        <div class="container-fluid footer py-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item">
                            <h4 class="mb-4 text-white">Our Achievements</h4>
                            <p class="text-white">Proudly awarded "Best Spa of the Year 2023" and certified by the International Wellness Association.</p>
                        </div>
                        <div class="footer-item">
                            <h4 class="mb-4 text-white">Our Policies</h4>
                            <p class="text-white">
                                Learn more about our policies by visiting our <a href="/policy" class="text-danger">Policy Page</a>.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">Our Services</h4>
                            @php
                                $services = \App\Service::all();
                            @endphp
                            @foreach($services as $service)
                                <a href="#" style="cursor: default"><i class="fas fa-angle-right me-2"></i> {{ $service->service_name ?? 'No information to display'}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <div class="footer-item d-flex flex-column">
                            <h4 class="mb-4 text-white">Schedule</h4>
                            <p class="text-muted mb-0">Monday: <span class="text-white"> 09:00 am – 10:00 pm</span></p>
                            <p class="text-muted mb-0">Saturday: <span class="text-white"> 09:00 am – 08:00 pm</span></p>
                            <p class="text-muted mb-0">Sunday: <span class="text-white"> 09:00 am – 05:00 pm</span></p>
                            <h4 class="my-4 text-white">Address</h4>
                            <p class="mb-0"><i class="fas fa-map-marker-alt text-secondary me-2"></i> Menara Harmony, Level 12, Jalan Ampang, 50450 Kuala Lumpur, Malaysia.</p>
                            <h4 class="my-4 text-white">Contact Us</h4>
                            <p class="mb-0"><i class="fas fa-envelope text-secondary me-2"></i> info@raudhahserenity.com</p>
                            <p class="mb-0"><i class="fas fa-phone text-secondary me-2"></i> (+60) 3-1234 5678</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4 text-center text-md-start mb-md-0">
                        <span class="text-light"><a href="/about"><i class="fas fa-copyright text-light me-2"></i>Raudhah Serenity Spa</a>, All right reserved.</span>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('customer/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('customer/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('customer/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('customer/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('customer/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('customer/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('customer/js/main.js') }}"></script>

    @yield('script')

</html>
