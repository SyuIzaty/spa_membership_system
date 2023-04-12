@extends('layouts.single')

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
	margin: 55px;
	overflow: hidden;
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
	background-color: #1A237E;
	color: #fff;
	padding: 12px;
	max-width: 100%;
    width: 100px;
    position: relative;
    font-size: 12px;
}

.box-text {
	padding: 12px;
	position: relative;
	width: 100%;
    font-size: 12px;
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
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url({{asset('img/3.jpg')}});"></div>
						<div class="login-wrap p-4 p-md-5">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <div class="row mb-4 px-3 justify-content-center">
                                        <img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" alt="INTEC">
                                    </div>
                                    <div style="font-family: Verdana, sans-serif;" class="card-header"><center><b>{{ __('E-ADUAN') }}</b></center></div><br><br>
                                    <form  action="{{ url('/eAduan') }}" method="GET" id="form_find">
                                        <div class="input-group col-lg-12 mb-4"><br><br>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                                    <i class="fal fa-user text-muted"></i>
                                                </span>
                                            </div>
                                            <input style="margin-top: 0px; height: 50px" id="ic_no" placeholder="No. Kad Pengenalan Tanpa (-)" class="form-control @error('ic_no') is-invalid @enderror bg-white border-left-0 border-md" name="ic_no" value="{{ $request->ic_no ?? old('ic_no') }}" required>
                                            @error('ic_no')
                                                <span class="invalid-feedback mt-2 p-2" role="alert" style="text-align: left">
                                                    <strong><p style="color:red">* No Kad Pengenalan mesti mengandungi 12 digit.<br>
                                                        * No Kad Pengenalan yang dimasukkan mesti tanpa (-).<br>
                                                        * No Kad Pengenalan dengan format tidak sah tidak boleh mengakses sistem ini.
                                                    </p></strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-12 mx-auto mb-4">
                                            <center><button type="submit" id="btn-search" class="btn btn-blue btn-block py-2 w-100">
                                                <span class="font-weight-bold">Semak Pengguna</span>
                                            </button></center>
                                        </div>
                                    </form>
                                    @if($request->ic_no  != "")
                                        @if(isset($exist_stf) || isset($exist_std))
                                            <p style="color:red">{{$result}}</p>
                                        @else
                                            <div class="row" style="margin: 2px">
                                                <div class="col-lg-12 text-center">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-12 text-center mb-4">
                                                            <a href="/borang-aduan/{{$request->ic_no}}" class="text-center">
                                                                <div class="box m-0">
                                                                    <div class="box-icon">
                                                                        <span><i class="fas fa-plus-square"></i></span>
                                                                    </div>
                                                                    <div class="box-text text-center"><b>Aduan Baru</b></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 text-center">
                                                            <a href="/semak-aduan/{{$request->ic_no}}">
                                                                <div class="box m-0">
                                                                    <div class="box-icon">
                                                                        <span><i class="fas fa-search"></i></span>
                                                                    </div>
                                                                    <div class="box-text"><b>Semak Aduan</b></div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="row mt-4">
                                        <div class="col-lg-12 text-center">
                                            <a href="/manual-aduan-umum" target="_blank" style="text-decoration: none!important; color: #1A237E">
                                                <span class="nav-link-text" data-i18n="nav.user-manual"><i class="fas fa-book mr-2"></i><u>Manual Pengguna</u></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
		                </div>
		            </div>
				</div>
			</div>
		</div>

        <p class="text-center text-black mt-4">Copyright © {{ \Carbon\Carbon::now()->format('Y') }} INTEC Education College. All Rights Reserved</p>
</main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#ic_no').on('click', '#btn-search', function(e) {
                e.preventDefault();
                $("#form_find").submit();
            });
        });
    </script>
@endsection
