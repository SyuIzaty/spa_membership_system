@extends('layouts.customer')

@section('content')

    <div class="container-fluid bg-breadcrumb py-5">
        <div class="container text-center py-5">
            <h3 class="text-white display-3 mb-4">About Us</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">About Us</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <div class="video position-relative">
                        <img src="{{ asset('customer/img/promo.jpg') }}"
                                class="img-fluid rounded w-100"
                                style="max-height: 400px; object-fit: cover;"
                                alt="Background Image">
                        <div class="position-absolute rounded border-5 border-top border-start border-white"
                                style="bottom: 10px; right: 10px; width: 100px; height: 100px;">
                            <img src="{{ asset('customer/img/promo.jpg') }}"
                                    class="img-fluid rounded w-100 h-100"
                                    style="object-fit: cover;"
                                    alt="Overlay Image">
                        </div>
                        <button type="button" class="btn btn-play"
                                data-bs-toggle="modal"
                                data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-7">
                    <p class="fs-4 text-uppercase text-primary">About Us</p>
                    <h1 class="display-4 mb-4">Discover Serenity at Raudhah Serenity Spa</h1>
                    <p class="mb-4">At Raudhah Serenity Spa, we offer more than just treatments – we provide a holistic experience that nurtures your mind, body, and soul. From rejuvenating facials and soothing massages to invigorating body treatments, our offerings are designed to promote wellness and relaxation.</p>
                    <p class="my-4">Our spa features state-of-the-art facilities and a team of expert therapists who use the finest products to ensure you receive the highest quality care. Whether you're looking to escape the hustle and bustle of daily life or indulge in a wellness retreat, we have tailored services just for you.</p>
                    <p class="my-4">In addition to our traditional spa services, we also offer exclusive packages, personalized treatment plans, and a VIP membership that provides priority booking, discounts, and special events throughout the year. Experience peace, tranquility, and ultimate relaxation with Raudhah Serenity Spa.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Promo Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <video id="promoVideo" class="w-100" controls>
                            <source src="{{ asset('customer/img/promo.mp4') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 800px;">
                <p class="fs-4 text-uppercase text-primary">Spa Specialist</p>
                <h1 class="display-4 mb-4">Spa & Beauty Specialist</h1>
            </div>
            <div class="row g-4">
                @foreach($staffs as $staff)
                    <div class="col-md-6 col-lg-6 col-xl-3">
                        <div class="team-item">
                            <div class="team-img rounded-top">
                                <img src="img/team-1.png" class="img-fluid w-100 rounded-top bg-light" alt="">
                            </div>
                            <div class="team-text rounded-bottom text-center p-4">
                                <h3 class="text-white"> {{ $staff->staff_name }} </h3>
                                <p class="mb-0 text-white" align="left">Spa & Beauty Expert</p>
                                <p class="mb-0 text-white" align="left">Phone No. : <u>{{ $staff->staff_phone }}</u></p>
                                <p class="mb-0 text-white" align="left">Email : <u>{{ $staff->staff_email }}</u></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-fluid testimonial py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 800px;">
                <p class="fs-4 text-uppercase text-primary">Testimonial</p>
                <h1 class="display-4 mb-4 text-white">What Our Customers Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                @php
                    $testimonials = [
                        "The spa experience was absolutely amazing—so relaxing and rejuvenating!",
                        "I love the calming ambiance and the professional service at this spa. Highly recommend it!",
                        "Every visit to this spa feels like a mini vacation. The treatments are heavenly!",
                        "The staff here are incredibly friendly, and the massages are the best I’ve ever had!",
                        "This spa is a true sanctuary! I always leave feeling refreshed and completely pampered."
                    ];
                @endphp
                @foreach($customers as $index => $customer)
                    <div class="testimonial-item rounded p-4" style="height: 200px">
                        <div class="row">
                            <div class="col-4">
                                <div class="d-flex flex-column mx-auto">
                                    <div class="rounded-circle mb-4" style="border: dashed; border-color: var(--bs-white);">
                                        <img src="img/testimonial-{{ $index + 1 }}.jpg" class="img-fluid rounded-circle" alt="">
                                    </div>
                                    <div class="text-center">
                                        <h4 class="mb-2 text-primary">{{ $customer->customer_name ?? 'No Name' }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="position-absolute" style="top: 20px; right: 25px;">
                                    <i class="fa fa-quote-right fa-2x text-secondary"></i>
                                </div>
                                <div class="testimonial-content">
                                    <div class="d-flex mb-4">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                    </div>
                                    <p class="fs-5 mb-0 text-white">{{ $testimonials[$index] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
