@extends('layouts.public')

@section('content')
<script src="https://kit.fontawesome.com/5c6c94b6d7.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('css/icomplaint.css') }}">

<style> 
.box {
	background-color: #fff;
	border-radius: 10px;
	box-shadow: 0 10px 10px rgba(0, 0, 0, 0.2);
	display: flex;
	max-width: 100%;
	margin: 20px;
	overflow: hidden;
	width: 250px;
    color: rgb(0, 0, 0);
    transition: top ease 0.5s;
    top: 0;
    position: relative;
    border-color: #ebebeb;
    border-style: solid;
    border-width: thin;
}

.box:hover{
    top: -10px;
}

.box-icon {
	background-color: #e86e53;
	color: #fff;
	padding: 30px;
	max-width: 100%;
    width: 100px;
    position: relative;
    font-size: 20px;
}

.box-text {
	padding: 30px;
	position: relative;
	width: 100%;
    font-size: 15px;
}

.ftco-section {
  padding: 7em 0; }

  .justify-content-center {
  -webkit-box-pack: center !important;
  -ms-flex-pack: center !important;
  justify-content: center !important; }

  .img, .login-wrap {
  width: 50%; }
  @media (max-width: 991.98px) {
    .img, .login-wrap {
      width: 100%; } }

@media (max-width: 767.98px) {
  .wrap .img {
    height: 250px; } }

.login-wrap {
  position: relative;
  background: #fff h3;
    background-font-weight: 300; }

	.form-group {
  position: relative; }
  .form-group .label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #000;
    font-weight: 700; }
  .form-group a {
    color: gray; }

    .wrap {
  width: 100%;
  overflow: hidden;
  background: #fff;
  border-radius: 5px;
  -webkit-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
  -moz-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
  box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24); }

  
@media (max-width: 767.98px) {
  .wrap .img {
    height: 250px; } }

    .img {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center; }

  .img, .login-wrap {
  width: 50%; }
  @media (max-width: 991.98px) {
    .img, .login-wrap {
      width: 100%; } }

@media (max-width: 767.98px) {
  .wrap .img {
    height: 250px; } }

</style>
<main id="js-page-content" role="main" id="main" class="page-content" style="background-image: url({{asset('img/bg4.jpg')}}); background-size: cover">
    {{-- <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <img src="{{ asset('img/intec_logo_new.png') }}" style="width: 320px;"/><br>
                            <h1 class="title text-center" style="margin-top: 20px;">
                                i-Complaint
                            </h1>
                        </div>
                    </div>
                </div>
                
                <div class="card-body" style="background-color: #d3d3d366;">
                    <div style="margin-bottom: 100px;"></div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-6 col-xl-6" style="padding: 0 80px">
                                        <div>
                                            <a href="/form">
                                                <div class="box">
                                                    <div class="box-icon">
                                                        <span><i class="fas fa-plus-square"></i></span>
                                                    </div>
                                                    <div class="box-text text-center"><b>New</b></div>
                                                </div>
                                            </a> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6 col-xl-6" style="padding: 0 80px">
                                        <a href="/lists">
                                            <div class="box">
                                                <div class="box-icon">
                                                    <span><i class="fas fa-search"></i></span>
                                                </div>
                                                <div class="box-text text-center"><b>Check</b></div>
                                            </div>
                                        </a> 
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div style="margin-bottom: 100px;"></div>
                </div>
            </div>
        </div>
    </div> --}}
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <img src="{{ asset('img/intec_logo_new.png') }}" style="width: 320px;"/><br>
                            <h1 class="title text-center" style="margin-top: 20px;">
                                i-Complaint
                            </h1>
                        </div>
                    </div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url({{asset('img/3.jpg')}});"></div>
						<div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h5 class="mb-4">i-Complaint system welcomes public, INTEC staffs and students to submit complaint, suggestion, enquiry and appreciation.
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="padding: 0 80px">
                                    <div>
                                        <a href="/form">
                                            <div class="box">
                                                <div class="box-icon">
                                                    <span><i class="fas fa-plus-square"></i></span>
                                                </div>
                                                <div class="box-text text-center"><b>New</b></div>
                                            </div>
                                        </a> 
                                    </div>
                                </div>
                                
                                <div class="col-sm-12" style="padding: 0 80px">
                                    <a href="/lists">
                                        <div class="box">
                                            <div class="box-icon">
                                                <span><i class="fas fa-search"></i></span>
                                            </div>
                                            <div class="box-text text-center"><b>Check</b></div>
                                        </div>
                                    </a> 
                                </div>
                            </div>
		                </div>
		            </div>
				</div>
			</div>
		</div>

    @include('aduan-korporat.footer')
</main>
@endsection
@section('script')
    <script>

    </script>
@endsection
