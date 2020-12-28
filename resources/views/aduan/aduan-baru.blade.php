@extends('layouts.aduan')
@section('content')
<body>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-center">
                        <div class="p-2">
                            <img src="{{ asset('img/intec_logo.png') }}" class="responsive"/>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="d-flex justify-content-center">SELAMAT DATANG KE LAMAN E-ADUAN</h2>
                    <p class="d-flex justify-content-center">Sekiranya anda ingin membuat sebarang aduan baru berkaitan INTEC Education College atau menyemak status aduan anda, sila klik butang dibawah.</p>
                    @if (Session::has('message'))
                    <center><div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc; width: 655px; font-size: 15px;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div></center>
                    @endif
                    <div class="d-flex justify-content-center"> 
                        <div class="p-2"><a href="{{ route('borangAduan') }}" class="btn btn-primary"><i class="fal fa-plus-square"></i> ADUAN BARU</a></div>
                        <div class="p-2"><a href="{{ route('semakAduan') }}" class="btn btn-success"><i class="fal fa-search"></i> SEMAK ADUAN</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
