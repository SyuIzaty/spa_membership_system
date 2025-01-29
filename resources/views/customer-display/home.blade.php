@extends('layouts.customer')

@section('content')

    <div class="container-fluid carousel-header px-0">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="{{ asset('customer/img/carousel-3.jpg') }}" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-primary text-uppercase mb-3">Spa & Beauty Center</h4>
                            <h1 class="display-1 text-capitalize text-dark mb-3">Skin Care</h1>
                            <p class="mx-md-5 fs-4 px-4 mb-5 text-dark">Revitalize your skin with our expert treatments that nourish, hydrate, and bring out your natural glow.</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5" href="/booking">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('customer/img/carousel-2.jpg') }}" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-primary text-uppercase mb-3" style="letter-spacing: 3px;">Spa & Beauty Center</h4>
                            <h1 class="display-1 text-capitalize text-dark mb-3">Body Care</h1>
                            <p class="mx-md-5 fs-4 px-5 mb-5 text-dark">Indulge in our luxurious body care services, designed to relax muscles and leave you feeling rejuvenated.</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5" href="/booking">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('customer/img/carousel-1.jpg') }}" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-primary text-uppercase mb-3" style="letter-spacing: 3px;">Spa & Beauty Center</h4>
                            <h1 class="display-1 text-capitalize text-dark">Massage</h1>
                            <p class="mx-md-5 fs-4 px-5 mb-5 text-dark">Let our expert therapists melt away your stress with calming massages tailored for ultimate relaxation.</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5" href="/booking">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('customer/img/carousel-4.jpg') }}" class="img-fluid" alt="Image">
                    <div class="carousel-caption">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-primary text-uppercase mb-3" style="letter-spacing: 3px;">Spa & Beauty Center</h4>
                            <h1 class="display-1 text-capitalize text-dark">Beauty</h1>
                            <p class="mx-md-5 fs-4 px-5 mb-5 text-dark">Enhance your natural beauty with our professional services, tailored to make you look and feel your best.</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5" href="/booking">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
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
                    <p class="mb-4">At Raudhah Serenity Spa, we offer more than a spa experience—it's a journey to holistic well-being. Our exclusive membership program lets you enjoy personalized treatments, priority booking, and members-only benefits crafted to rejuvenate your body and mind.</p>
                    <p class="my-4">Join us to experience unmatched peace, priority access, and exclusive wellness perks tailored for your tranquility.</p>
                    <a href="/about" class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5">Explore More</a>
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

    <div class="container-fluid services py-5">
        <div class="container py-5">
            <div class="mx-auto text-center mb-5" style="max-width: 800px;">
                <p class="fs-4 text-uppercase text-center text-primary">Our Service</p>
                <h1 class="display-3">Spa & Beauty Services</h1>
            </div>
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-lg-6">
                        <div class="services-item bg-light border-4 border-end border-primary rounded p-4">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <div class="services-content text-end">
                                        <h3>{{ $service->service_name ?? 'No information to display'}}</h3>
                                        <p>{{ $service->service_description ?? 'No information to display'}}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="services-img d-flex align-items-center justify-content-center rounded">
                                        <a data-fancybox="gallery" href="{{ asset('storage/service/' . $service->service_img_name) }}">
                                            <img src="{{ asset('storage/service/' . $service->service_img_name) }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12">
                    <div class="services-btn text-center">
                        <a href="/service" class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5">Service More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pricing py-5">
        <div class="container py-5">
            <div class="owl-carousel pricing-carousel">
                @foreach($plans as $plan)
                    <div class="pricing-item">
                        <div class="rounded pricing-content">
                            <div class="d-flex align-items-center justify-content-between bg-light rounded-top border-3 border-bottom border-primary p-4">
                                <h5 class="text-primary text-uppercase m-0">{{ $plan->plan_name ?? 'No information to display' }}</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-between bg-light rounded-top border-3 border-bottom border-primary p-4">
                                <h1 class="display-4 mb-0">
                                    <small class="align-top text-muted" style="font-size: 20px; line-height: 45px;">RM</small>{{ $plan->plan_price ?? 'No information to display'}}<small class="text-muted" style="font-size: 16px; line-height: 40px;">/Mo</small>
                                </h1>
                            </div>
                            <div class="p-4" style="height: 400px">
                                <p><i class="fa fa-check text-primary me-2"></i>{{ $plan->plan_description ?? 'No information to display' }}</p>
                                @foreach($plan->planServices as $planService)
                                    <p><i class="fa fa-check text-primary me-2"></i>{{ $planService->service->service_name ?? 'No information to display'}}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12">
            <div class="services-btn text-center">
                <a href="/membership" class="btn btn-primary btn-primary-outline-0 rounded-pill py-3 px-5">Register Now</a>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-12">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="d-inline-flex bg-light w-100 border border-primary p-4 rounded">
                                <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                                <div>
                                    <h4>Address</h4>
                                    <p class="mb-0"> Menara Harmony, Level 12, Jalan Ampang, 50450 Kuala Lumpur, Malaysia.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-inline-flex bg-light w-100 border border-primary p-4 rounded">
                                <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                                <div>
                                    <h4>Mail Us</h4>
                                    <p class="mb-0"> info@raudhahserenity.com</p>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-inline-flex bg-light w-100 border border-primary p-4 rounded">
                                <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                                <div>
                                    <h4>Phone No.</h4>
                                    <p class="mb-0"> (+60) 3-1234 5678</p>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="rounded">
                        <iframe class="rounded-top w-100"
                        style="height: 450px; margin-bottom: -6px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.7890111542847!2d101.6930889436533!3d3.150282888663902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49d2dbcb2957%3A0xc14bb3af6712eb9!2s12%2C%20Jln%20Ampang%2C%2055000%20Kuala%20Lumpur%2C%20Wilayah%20Persekutuan%20Kuala%20Lumpur!5e0!3m2!1sen!2smy!4v1736746024369!5m2!1sen!2smy"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
