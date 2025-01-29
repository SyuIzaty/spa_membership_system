@extends('layouts.customer')

@section('content')

    <div class="container-fluid bg-breadcrumb py-5">
        <div class="container text-center py-5">
            <h3 class="text-white display-3 mb-4">Profile</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Profile</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid appointment py-5" style="background: white">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-12">
                    <div class="appointment-form p-5">
                        <p class="fs-4 text-uppercase" style="color: pink">Your Profile at a Glance</p>
                        <h1 class="display-4 mb-4 text-white">Personalize Your Profile</h1>
                        @php
                            $customer = \App\Customer::where('user_id', Auth::user()->id)->first();
                        @endphp
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fas fa-check-circle"></i> {{ Session::get('message') }}</div><br>
                        @endif
                        <form action="/update-profile" method="POST">
                            <input type="hidden" name="id" id="id" value="{{ $customer->user_id }}">
                            @csrf
                            <div class="row gy-3 gx-4">
                                <div class="col-lg-12">
                                    <label class="label text-white" style="margin-bottom: 10px"><span class="text-danger">*</span> Full Name :</label>
                                    <input name="customer_name" id="customer_name" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_name }}" required>
                                    @error('customer_name')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label class="label text-white" style="margin-bottom: 10px">Identification Card/Passport :</label>
                                    <input name="customer_ic" id="customer_ic" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_ic }}">
                                    @error('customer_ic')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label class="label text-white" style="margin-bottom: 10px"><span class="text-danger">*</span> Email :</label>
                                    <input type="email" name="customer_email" id="customer_email" class="form-control py-3 border-white bg-transparent text-white"value="{{ $customer->customer_email }}" required>
                                    @error('customer_email')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label class="label text-white" style="margin-bottom: 10px"><span class="text-danger">*</span> Phone No. :</label>
                                    <input name="customer_phone" id="customer_phone" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_phone }}" required>
                                    @error('customer_phone')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label class="label text-white" style="margin-bottom: 10px"> <span class="text-danger">*</span> Gender :</label>
                                    <select name="customer_gender" id="customer_gender" class="form-control py-3 border-white bg-transparent text-white" required>
                                        <option value="" disabled {{ old('customer_gender') == '' ? 'selected' : '' }}> Please select</option>
                                        <option style="color: black" value="M" {{ old('customer_gender', $customer->customer_gender) == 'M' ? 'selected' : '' }}> Male</option>
                                        <option style="color: black" value="F" {{ old('customer_gender', $customer->customer_gender) == 'F' ? 'selected' : '' }}> Female</option>
                                    </select>
                                    @error('customer_gender')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <label class="label text-white" style="margin-bottom: 10px"> Address :</label>
                                    <textarea rows="3" class="form-control py-3 border-white bg-transparent text-white" id="customer_address" name="customer_address" >{{ $customer->customer_address ?? old('customer_address') }}</textarea>
                                    @error('customer_address')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label class="label text-white" style="margin-bottom: 10px"> State :</label>
                                    <input name="customer_state" id="customer_state" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_state }}">
                                    @error('customer_state')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label class="label text-white" style="margin-bottom: 10px">Postcode :</label>
                                    <input name="customer_postcode" id="customer_postcode" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_postcode }}">
                                    @error('customer_postcode')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <label class="label text-white" style="margin-bottom: 10px">Join Date :</label>
                                    <input type="date" id="customer_start_date" name="customer_start_date" class="form-control py-3 border-white bg-transparent text-white" value="{{ $customer->customer_start_date }}" disabled>
                                    @error('customer_start_date')
                                        <p style="color: red; margin-bottom: 10px"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-primary-outline-0 w-100 py-3 px-5"> Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
