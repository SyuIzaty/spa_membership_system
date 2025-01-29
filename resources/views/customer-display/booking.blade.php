@extends('layouts.customer')

@section('content')
    <div class="container-fluid bg-breadcrumb py-5">
        <div class="container text-center py-5">
            <h3 class="text-white display-3 mb-4">Booking</h3>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Booking</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    <div>
                        <p class="fs-4 text-uppercase text-primary">Tailored for Your Wellness</p>
                        <h1 class="display-4 mb-4">Book Now and Discover a World of Relaxation</h1>
                        <p class="mb-4">
                            Explore our wide range of services designed to cater to your unique needs. With state-of-the-art facilities and a team of experienced specialists, we promise to deliver an unparalleled wellness experience. Whether you're looking to unwind, rejuvenate, or heal, our offerings are tailored to exceed your expectations.
                        </p>
                        <p class="mb-4">
                            Book your session today and enjoy access to premium services, personalized treatments, and exclusive amenities. Let us help you relax, refresh, and rediscover your best self.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid appointment py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    <div class="appointment-form p-5">
                        <p class="fs-4 text-uppercase text-primary">Book Your Session</p>
                        <h1 class="display-4 mb-4 text-white">Reserve Your Spot Today</h1>
                        @if(Auth::check())
                            @php
                                $customer = \App\Customer::where('user_id', Auth::user()->id)->first();
                            @endphp
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324"> <i class="icon fas fa-check-circle"></i> {{ Session::get('message') }}</div><br>
                            @endif
                            <form action="/register-booking" method="POST">
                                @csrf
                                <input type="hidden" name="services" id="services" value="">
                                <input type="hidden" name="subtotal_price" id="subtotal_price" value="">
                                <input type="hidden" name="discounts" id="discounts" value="">
                                <input type="hidden" name="total_price" id="total_price_input" value="">
                                <div class="row gy-3 gx-4">
                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Full Name :</label>
                                        <input name="customer_name" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_name }}" readonly>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Email :</label>
                                        <input type="email" name="customer_email" id="customer_email" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_email }}" readonly>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Phone No. :</label>
                                        <input name="customer_phone" id="customer_phone" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_phone }}" readonly>
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Booking Date :</label>
                                        <input type="date" id="booking_date" name="booking_date" class="form-control py-3 border-white bg-transparent text-white" required>
                                        @error('booking_date')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Booking Time :</label>
                                        <input type="time" id="booking_time" name="booking_time" class="form-control py-3 border-white bg-transparent text-white" required>
                                        @error('booking_time')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px"> Total Duration (Minutes):</label>
                                        <input type="text" id="total_duration" name="total_duration" class="form-control py-3 border-white bg-transparent text-white" readonly>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="label text-white" style="margin-bottom: 10px">Specialist :</label>
                                        <select name="staff_id" id="staff_id" class="form-control py-3 border-white bg-transparent text-white" required>
                                            <option value="" selected disabled> Please select</option>
                                            @foreach ($staffs as $staff)
                                                <option style="color: black" value="{{ $staff->user_id }}">{{ $staff->staff_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('staff_id')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="label text-white" style="margin-bottom: 10px">Select Services :</label>
                                        <table class="table table-bordered text-white text-center" id="services-table">
                                            <thead>
                                                <tr>
                                                    <th>Select</th>
                                                    <th>No.</th>
                                                    <th>Service Name</th>
                                                    <th>Service Duration (Minutes)</th>
                                                    <th>Service Price (RM)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($services as $index => $service)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" class="service-checkbox" value="{{ $service->id }}"
                                                            data-name="{{ $service->service_name }}"
                                                            data-duration="{{ $service->service_duration }}"
                                                            data-price="{{ in_array($service->id, $freeServices->toArray()) ? 0 : $service->service_price }}">
                                                    </td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $service->service_name }}</td>
                                                    <td>{{ $service->service_duration }}</td>
                                                    <td>
                                                        @if(in_array($service->id, $freeServices->toArray()))
                                                            Free
                                                        @else
                                                            RM {{ $service->service_price }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div align="left">
                                        <label class="text-white">
                                            @if($discounts instanceof \Illuminate\Support\Collection)
                                                @foreach($discounts as $discount)
                                                    <div>
                                                        Discount {{ $discount->discount_name }} Applied :
                                                        @if($discount->discount_type == 'percentage')
                                                            OFF {{ $discount->discount_value }}%
                                                        @elseif($discount->discount_type == 'fixed')
                                                            OFF RM {{ $discount->discount_value }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @elseif($discounts)
                                                <div>
                                                    Discount {{ $discounts->discount_name }} Applied :
                                                    @if($discounts->discount_type == 'percentage')
                                                        OFF {{ $discounts->discount_value }}%
                                                    @elseif($discounts->discount_type == 'fixed')
                                                        OFF RM {{ $discounts->discount_value }}
                                                    @endif
                                                </div>
                                            @else
                                                <div><i>No Discount</i></div>
                                            @endif
                                        </label>
                                    </div>

                                    <div align="right" style="font-size: 20px">
                                        <label class="text-white">Subtotal Price:</label>
                                        <span class="text-white" id="subtotal-price">0.00</span>
                                    </div>

                                    <div align="right" style="font-size: 20px">
                                        <label class="text-white">Total Price:</label>
                                        <span class="text-white" id="total-price">0.00</span>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary w-100 py-3 px-5">Reserve Booking</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-light">Please <a href="{{ route('login') }}" class="text-primary">login</a> to reserve booking.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    @if(Auth::check())
        <script>
            let selectedServices = [];

            function updateServiceTable() {
                let totalDuration = 0;
                let subtotalPrice = 0;

                // Reset the selectedServices array
                selectedServices = [];

                // Iterate over selected services
                document.querySelectorAll('.service-checkbox:checked').forEach(function (checkbox) {
                    const service = {
                        serviceId: checkbox.value,
                        serviceName: checkbox.getAttribute('data-name'),
                        serviceDuration: parseInt(checkbox.getAttribute('data-duration')),
                        servicePrice: parseFloat(checkbox.getAttribute('data-price')),
                    };

                    selectedServices.push(service);

                    totalDuration += service.serviceDuration;
                    subtotalPrice += service.servicePrice;
                });

                console.log("Selected Services:", selectedServices);

                // Update duration and subtotal price
                document.querySelector('#total_duration').value = totalDuration;
                document.querySelector('#subtotal-price').textContent = subtotalPrice.toFixed(2);

                // Calculate total price after discount
                calculateTotalPrice(subtotalPrice);
            }

            function calculateTotalPrice(subtotalPrice) {
                let discounts = @json($discounts); // Passing Laravel discounts to JavaScript
                let totalDiscount = 0;

                if (Array.isArray(discounts)) {
                    // For multiple discounts
                    discounts.forEach(discount => {
                        if (discount.discount_type === 'percentage') {
                            totalDiscount += (subtotalPrice * discount.discount_value) / 100;
                        } else if (discount.discount_type === 'fixed') {
                            totalDiscount += discount.discount_value;
                        }
                    });
                } else if (discounts) {
                    // For single discount
                    if (discounts.discount_type === 'percentage') {
                        totalDiscount = (subtotalPrice * discounts.discount_value) / 100;
                    } else if (discounts.discount_type === 'fixed') {
                        totalDiscount = discounts.discount_value;
                    }
                }

                // Ensure total discount does not exceed subtotal price
                totalDiscount = Math.min(totalDiscount, subtotalPrice);

                // Calculate and display total price
                let totalPrice = subtotalPrice - totalDiscount;
                document.querySelector('#total-price').textContent = totalPrice.toFixed(2);

                // Update hidden fields with total price, services, and discounts
                document.querySelector('#total_price_input').value = totalPrice.toFixed(2);
                document.querySelector('#services').value = JSON.stringify(selectedServices);
                document.querySelector('#discounts').value = JSON.stringify(discounts);
            }

            // Attach the event listener to all checkboxes
            document.querySelectorAll('.service-checkbox').forEach(function (checkbox) {
                checkbox.addEventListener('change', updateServiceTable);
            });

            // Initial calculation when the page loads
            updateServiceTable();
        </script>
    @endif

@endsection
