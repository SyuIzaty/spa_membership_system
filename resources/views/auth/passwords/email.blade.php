@extends('layouts.single')

@section('content')

<div class="container">
    <div class="row py-5 mt-6 justify-content-center">
        <div class="card2 border-0 col-lg-5">
            <div class="row d-flex">
    
                <div class="col-lg-12">
                    <div class="card card border-0 px-4 py-5"> 
                        <div><a href="{{ route('login') }}" class="btn border-3 float-right"><i class="fal fa-window-close" style="font-size:24px"></i></a></div>
                        <div class="row mb-4 px-3 justify-content-center">
                            <img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" alt="INTEC">
                        </div>

                        <div class="card-header">{{ __('Reset Password') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 mx-auto mb-0">
                                    <button type="submit" class="btn btn-blue btn-block py-2" style="width: 350px;">
                                        <span class="font-weight-bold">Send Password Reset Link</span>
                                    </button>
                                </div>

                            </form>
                        </div>
                                        
                    </div>
                </div>
            </div>

            <div class="bg-blue py-3">
                <div class="row px-3"> <small class="ml-4 ml-sm-4 mb-1">Copyright © 2020 INTEC Education College. All Rights Reserved</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
