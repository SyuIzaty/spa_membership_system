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
                    <p class="d-flex justify-content-center">Sila masukkan ID Aduan yang diberikan dalam ruangan di bawah.</p>
                    
                    <div class="card-body d-flex justify-content-center">
                        {!! Form::open(['action' => 'AduanController@semakAduan', 'method' => 'GET']) !!}
                        <div class="input-group" style="width: 380px;">
                            {{Form::text('id', '', ['class' => 'form-control', 'placeholder' => 'ID Aduan'])}}
                            <div class="input-group-prepend">
                                <button class="btn btn-warning" type="submit"><i class="fal fa-search"></i> SEMAK STATUS ADUAN</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                        @foreach($semak as $semakan)
                            <div class="d-flex justify-content-lg-center">
                                @if($semakan->status_aduan == 'AS')
                                    <div class="d-flex justify-content-lg-center">
                                        <center>
                                            <div class="card card-primary card-outline">
                                                <div class="card-header bg-primary-50">
                                                    <span class="fw-300"></span><i class="fal fa-chart-pie"></i><b> ID ADUAN: {{ $semakan->id }} </b>
                                                </div>
                                                <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Tarikh Aduan Dibuat :</label></td>
                                                            <td colspan="4"><b>{{ date('j F Y | h:i:s A', strtotime($semakan->tarikh_laporan)) }}</b></td>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Nama Pelapor :</label></td>
                                                            <td colspan="4"><b>{{ $semakan->nama_pelapor  }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Lokasi Aduan :</label></td>
                                                            <td colspan="4"><b>Bilik {{ $semakan->nama_bilik .', Aras '. $semakan->aras_aduan .', Blok '. $semakan->blok_aduan .', '. $semakan->lokasi_aduan }}</b></td>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Kategori Aduan:</label></td>
                                                            <td colspan="4"><b>{{ $semakan->kategori->nama_kategori  }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Jenis Aduan:</label></td>
                                                            <td colspan="4"><b>{{ $semakan->jenis->jenis_kerosakan  }}</b></td>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Sebab Aduan:</label></td>
                                                            <td colspan="4"><b>{{ $semakan->sebab->sebab_kerosakan  }}</b></td>
                                                        </tr>
                                                        <tr style="background-color: #d3fabc;">
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Status Aduan :</label></td>
                                                            <td colspan="8"><b><i class="icon fal fa-check-circle"></i> {{ $semakan->status->nama_status  }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Tarikh Aduan Selesai :</label></td>
                                                            <td colspan="8"><b>{{ date('j F Y | h:i:s A', strtotime($semakan->tarikh_selesai_aduan)) }}</b></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </center>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-lg-center">
                                        <center>
                                            <div class="card card-primary card-outline">
                                                <div class="card-header bg-primary-50">
                                                    <span class="fw-300"></span><i class="fal fa-chart-pie"></i><b> ID ADUAN: {{ $semakan->id }} </b>
                                                </div>
                                                <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Tarikh Aduan Dibuat :</label></td>
                                                            <td colspan="4"><b>{{ date('j F Y | h:i:s A', strtotime($semakan->tarikh_laporan)) }}</b></td>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Nama Pelapor :</label></td>
                                                            <td colspan="4"><b>{{ $semakan->nama_pelapor  }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Lokasi Aduan :</label></td>
                                                            <td colspan="4"><b>Bilik {{ $semakan->nama_bilik .', Aras '. $semakan->aras_aduan .', Blok '. $semakan->blok_aduan .', '. $semakan->lokasi_aduan }}</b></td>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Kategori Aduan:</label></td>
                                                            <td colspan="4"><b>{{ $semakan->kategori->nama_kategori  }}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Jenis Aduan:</label></td>
                                                            <td colspan="4"><b>{{ $semakan->jenis->jenis_kerosakan  }}</b></td>
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Sebab Aduan:</label></td>
                                                            <td colspan="4"><b>{{ $semakan->sebab->sebab_kerosakan  }}</b></td>
                                                        </tr>
                                                        <tr style="background-color: #fabcbc;">
                                                            <td width="20%"><label class="form-label" for="nama_pelapor">Status Aduan :</label></td>
                                                            <td colspan="8"><b><i class="fal fa-times-circle"></i> {{ $semakan->status->nama_status  }}</b></td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </center>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
