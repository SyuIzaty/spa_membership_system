@extends('layouts.customer')

@section('content')

    <div class="container-fluid bg-breadcrumb py-5">
        <div class="container text-center py-5">
            <h3 class="text-white display-3 mb-4">Our Services</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Service</li>
            </ol>
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

                                        <p>Category : {{ $service->service_category ?? 'No information to display'}}</p>
                                        <p>Duration : {{ $service->service_duration ?? 'No information to display'}} minutes</p>
                                        <p>Price    : RM {{ $service->service_price ?? 'No information to display'}}</p>
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
            </div>
        </div>
    </div>

@endsection
