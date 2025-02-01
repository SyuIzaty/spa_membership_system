@extends('layouts.customer')

@section('content')

    <div class="container-fluid bg-breadcrumb py-5">
        <div class="container text-center py-5">
            <h3 class="text-white display-3 mb-4">Membership Plan</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Membership</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    <div>
                        <p class="fs-4 text-uppercase text-primary">Exclusive Perks</p>
                        <h1 class="display-4 mb-4">Experience Luxury & Wellness Like Never Before</h1>
                        <p class="mb-4">Join our membership program and unlock exclusive perks designed to elevate your spa experience. From new member discounts to seasonal offers, we ensure that every visit is special and rewarding.</p>
                        <div class="row g-4">
                            @foreach ($discounts as $discount)
                                <div class="{{ $discount->id == 1 ? 'col-md-12' : 'col-md-6' }}">
                                    <div class="d-flex align-items-center">
                                        @php
                                            $iconClass = 'fas fa-gift';

                                            if (isset($discount->id)) {
                                                switch ($discount->id) {
                                                    case 2:
                                                        $iconClass = 'fas fa-snowflake';
                                                        break;
                                                    case 3:
                                                        $iconClass = 'fas fa-seedling';
                                                        break;
                                                    case 4:
                                                        $iconClass = 'fas fa-sun';
                                                        break;
                                                    case 5:
                                                        $iconClass = 'fas fa-leaf';
                                                        break;
                                                }
                                            }
                                        @endphp
                                        <i class="{{ $iconClass }} fa-3x text-primary"></i>
                                        <div class="ms-4">
                                            <h5 class="mb-2">{{ $discount->discount_name ?? 'No information to display' }}</h5>
                                            <p class="mb-0">{{ $discount->discount_description ?? 'No information to display' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid   py-5">
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
                            <div class="p-4" style="height: 400px; background-color: deeppink; color: white">
                                <p><i class="fa fa-check text-white me-2"></i>{{ $plan->plan_description ?? 'No information to display' }}</p>
                                @foreach($plan->planServices as $planService)
                                    <p><i class="fa fa-check text-white me-2"></i>{{ $planService->service->service_name ?? 'No information to display'}}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-fluid appointment py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    <div class="appointment-form p-5">
                        <p class="fs-4 text-uppercase text-primary">Join Us Today</p>
                        <h1 class="display-4 mb-4 text-white">Sign Up for Membership</h1>
                        @if(Auth::check())
                            @php
                                $customer = \App\Customer::where('user_id', Auth::user()->id)->first();
                            @endphp
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324"> <i class="icon fas fa-check-circle"></i> {{ Session::get('message') }}</div><br>
                            @endif
                            <form action="/register-membership" method="POST">
                                @csrf
                                <div class="row gy-3 gx-4">
                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Full Name :</label>
                                        <input name="customer_name" id="customer_name" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_name }}" readonly>
                                        @error('customer_name')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Email :</label>
                                        <input type="email" name="customer_email" id="customer_email" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_email }}" readonly>
                                        @error('customer_email')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Phone No. :</label>
                                        <input name="customer_phone" id="customer_phone" class="form-control py-3 border-white bg-transparent text-white"value="{{ $customer->customer_phone }}" readonly>
                                        @error('customer_phone')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Membership Plan :</label>
                                        <select name="plan_id" id="plan_id" class="form-control py-3 border-white bg-transparent text-white" required>
                                            <option value="" selected disabled> Please select</option>
                                            @foreach ($plans as $plan)
                                                <option style="color: black" value="{{ $plan->id }}" data-duration="{{ $plan->plan_duration_month }}" data-price="{{ $plan->plan_price }}">
                                                    {{ $plan->plan_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('plan_id')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">Start Date :</label>
                                        <div class="position-relative">
                                            <input type="date" id="start_date" name="start_date"
                                                   class="form-control py-3 border-white bg-transparent text-white custom-picker"
                                                   placeholder="Start Date" disabled>
                                        </div>
                                        @error('start_date')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="label text-white" style="margin-bottom: 10px">End Date :</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control py-3 border-white bg-transparent text-white" placeholder="End Date" readonly>
                                        @error('end_date')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="label text-white" style="margin-bottom: 10px">Payment Amount :</label>
                                        <input id="membership_payment" name="membership_payment" class="form-control py-3 border-white bg-transparent text-white" placeholder="Payment Amount" readonly>
                                        @error('membership_payment')
                                            <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary btn-primary-outline-0 w-100 py-3 px-5">Register Membership</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-light">Please <a href="{{ route('login') }}" class="text-primary">log in</a> to join membership.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script>

    document.addEventListener("DOMContentLoaded", () => {

        const planSelect = document.getElementById("plan_id");
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");
        const paymentInput = document.getElementById("membership_payment");

        startDateInput.disabled = true;
        endDateInput.disabled = true;
        paymentInput.disabled = true;

        planSelect.addEventListener("change", () => {

            const selectedOption = planSelect.options[planSelect.selectedIndex];

            if (selectedOption && selectedOption.value) {
                const duration = parseInt(selectedOption.dataset.duration, 10);
                const price = parseFloat(selectedOption.dataset.price);

                console.log("Selected Plan Duration (Months):", duration);
                console.log("Selected Plan Price:", price);
                console.log("End Date:", endDateInput.value);

                startDateInput.disabled = false;
                paymentInput.value = price.toFixed(2);
                paymentInput.disabled = false;

                startDateInput.addEventListener("change", () => {
                    const startDate = new Date(startDateInput.value);
                    if (!isNaN(startDate.getTime())) {
                        const endDate = new Date(startDate);
                        endDate.setMonth(endDate.getMonth() + duration);

                        const formatDate = (date) => {
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2, "0");
                            const day = String(date.getDate()).padStart(2, "0");
                            return `${year}-${month}-${day}`;
                        };

                        endDateInput.value = formatDate(endDate);
                        endDateInput.disabled = false;
                    }
                });
            }
        });
    });

</script>

@endsection
