@extends('layouts.single')

@section('content')
 
<div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
    <div class="card card0 border-0">
        <div class="row d-flex">
            <div class="col-lg-6">
                <div class="card1 pb-5">
                    <div class="row"> <img src="https://i.imgur.com/CXQmsmF.png" class="logo"> </div>
                    <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img src="https://i.imgur.com/uNGdWHi.png" class="image"> </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card2 card border-0 px-4 py-5">
                    <div class="row mb-4 px-3 justify-content-center">
                        <img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC">
                    </div>

                    <div style="font-family: Verdana, sans-serif;" class="card-header"><center><b>{{ __('REGISTER ACCOUNT') }}</b></center></div><br><br>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fal fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input style="margin-top: 0px; height: 50px" id="name" type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror bg-white border-left-0 border-md" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                       <!-- User Name -->
                             <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fal fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input style="margin-top: 0px; height: 50px" id="username" type="text" placeholder="Username" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }} bg-white border-left-0 border-md" name="username" value="{{ old('username') }}" required>
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                            </div>

                         <!-- Email Address -->
                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fal fa-envelope text-muted"></i>
                                    </span>
                                </div>
                                <input style="margin-top: 0px; height: 50px" id="email" type="email" placeholder="E-mail Address" class="form-control @error('email') is-invalid @enderror bg-white border-left-0 border-md" name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        
                        <!-- Role -->
                            {{-- <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fal fa-black-tie text-muted"></i>
                                    </span>
                                </div>
                                <select id="job" name="jobtitle" class="form-control custom-select bg-white border-left-0 border-md">
                                    <option value="">Choose your role</option>
                                    <option value="">Staff</option>
                                    <option value="">Student</option>
                                </select>
                            </div> --}}
    
                        <!-- Password -->
                            <div class="input-group col-lg-12 mb-4"> 
                                
                                    <div class="input-group col-lg-6 mb-2 px-md-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                <i class="fal fa-lock text-muted"></i>
                                            </span>
                                        </div>
                                        <input style="margin-top: 0px; height: 50px" id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror bg-white border-left-0 border-md" name="password" required autocomplete="new-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="input-group col-lg-6 mb-2 px-md-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                <i class="fal fa-lock text-muted"></i>
                                            </span>
                                        </div>
                                        <input style="margin-top: 0px; height: 50px" id="password-confirm" type="password" placeholder="Confirm Password" class="form-control bg-white border-left-0 border-md" name="password_confirmation" required autocomplete="new-password">
                                    </div>

                            </div>
                            
                        <!-- Submit Button -->
                            <div class="form-group col-lg-12 mx-auto mb-0">
                                <button type="submit" class="btn btn-blue btn-block py-2 w-100">
                                    <span class="font-weight-bold">Register account</span>
                                </button>
                            </div>

                         <!-- Divider Text -->
                            <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                                <div class="border-bottom w-100 ml-5 border-dark"></div>
                                <span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
                                <div class="border-bottom w-100 mr-5 border-dark"></div>
                            </div>
                        
                         <!-- Already Registered -->
                            <div class="text-center w-100">
                                <p class="text-muted font-weight-bold">Already Registered? <a href="/login" class="text-primary ml-2">Login</a></p>
                            </div>

                    </form>
                                    
                </div>
            </div>
        </div>

        <div class="bg-blue py-4">
            <div class="row px-3"> <small class="ml-4 ml-sm-5 mb-2">Copyright © 2020 INTEC Education College. All Rights Reserved</small>
            </div>
        </div>
    </div>
</div>

@endsection
