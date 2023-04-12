@extends('layouts.public')

@section('content')
<style>
    .preserveLines {
        white-space: pre-wrap;
    }

    .breadcrumb-arrow li a:after {
        left: 100%;
        border-color: transparent;
        border-left-color: #1A237E;
    }

    .breadcrumb-arrow li a {
        color: #fff;
        display: inline-block;
        background: #1A237E;
        text-decoration: none;
        position: relative;
        height: 2.5em;
        line-height: 2.5em;
        padding: 0 10px 0 5px;
        text-align: center;
        margin-right: 22px;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/icomplaint.css') }}">
<link rel="stylesheet" href="{{ asset('css/indicator.css') }}">
<main id="js-page-content" role="main" id="main" class="page-content"  style="background-image: url({{asset('img/bg4.jpg')}}); background-size: cover">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-size: cover">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="width: 320px;" class="responsive"/></center><br>
                            <h3 style="text-align: center" class="title">
                                Borang E-Aduan <sub class="ml-2" style="font-size: 12px">( TIKET #{{$aduan->id}} )</sub>
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="table-responsive">

                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="pt-4" style="border-left-style: hidden; border-right-style: hidden; border-top-style: hidden; padding: 0px">
                                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                            <li>
                                                                <a href="#" disabled style="pointer-events: none">
                                                                    <i class="fal fa-user"></i>
                                                                    <span class=""><b>INFO PENGADU</b></span>
                                                                </a>
                                                            </li>
                                                            <p></p>
                                                        </ol>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Nama Penuh : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->nama_pelapor)}}</td>
                                                    <th width="20%" style="vertical-align: middle">No Kad Pengenalan : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->id_pelapor)}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Emel : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ $aduan->emel_pelapor}}</td>
                                                    <th width="20%" style="vertical-align: middle">No. Telefon : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ $aduan->no_tel_pelapor}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="pt-4" style="border-left-style: hidden; border-right-style: hidden; padding: 0px">
                                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                            <li>
                                                                <a href="#" disabled style="pointer-events: none">
                                                                    <i class="fal fa-info"></i>
                                                                    <span class=""><b>BUTIRAN ADUAN</b></span>
                                                                </a>
                                                            </li>
                                                            <p></p>
                                                        </ol>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Pejabat/Bahagian/ Fakulti/Kolej: </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->lokasi_aduan) }}</td>
                                                    <th width="20%" style="vertical-align: middle">Blok : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->blok_aduan) }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Tingkat/Aras : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->aras_aduan) }}</td>
                                                    <th width="20%" style="vertical-align: middle">Nama Bilik/No. Bilik : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->nama_bilik) }}</td>
                                                </tr>

                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Kategori Aduan : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->kategori->nama_kategori) }}</td>
                                                    <th width="20%" style="vertical-align: middle">Jenis Kerosakan : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        <div>{{ strtoupper($aduan->jenis->jenis_kerosakan) }}</div word-break: break-all>
                                                        @if($aduan->jenis->jenis_kerosakan == 'Lain-lain')
                                                            <div> Penerangan : {{ strtoupper($aduan->jk_penerangan ?? '--') }}</div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: top">Sebab Kerosakan : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        <div>{{ strtoupper($aduan->sebab->sebab_kerosakan) }}</div word-break: break-all>
                                                        @if($aduan->sebab->sebab_kerosakan == 'Lain-lain')
                                                            <div> Penerangan : {{ strtoupper($aduan->sk_penerangan ?? '--') }}</div>
                                                        @endif
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle">Kuantiti/Unit : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{ $aduan->kuantiti_unit}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: top">Maklumat Tambahan : </th>
                                                    <td colspan="4" style="vertical-align: middle; text-transform: uppercase">{{ isset($aduan->maklumat_tambahan) ? $aduan->maklumat_tambahan : '-'}}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="pt-4" style="border-left-style: hidden; border-right-style: hidden; padding: 0px">
                                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                            <li>
                                                                <a href="#" disabled style="pointer-events: none">
                                                                    <i class="fal fa-upload"></i>
                                                                    <span class=""><b>MUATNAIK BUKTI</b></span>
                                                                </a>
                                                            </li>
                                                            <p></p>
                                                        </ol>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: top"> Gambar : </th>
                                                    <td colspan="2" style="text-transform: uppercase">
                                                        @if(isset($imej->first()->upload_image))
                                                            @foreach($imej as $imejAduan)
                                                                {{-- <a data-fancybox="gallery" href="/imej-aduan/{{ $imejAduan->upload_image }}"><img src="/imej-aduan/{{ $imejAduan->upload_image }}" style="width:150px; height:130px" class="img-fluid mr-2"></a> --}}
                                                                <a target="_blank" href="{{ url('imej-aduan')."/".$imejAduan->upload_image }}/Download">{{ $imejAduan->upload_image }}</a><br>
                                                            @endforeach
                                                        @else
                                                            <span>Tiada Gambar Sokongan</span>
                                                        @endif
                                                    </td>
                                                    <th width="20%" style="vertical-align: top">Resit : </th>
                                                    <td colspan="2" style="text-transform: uppercase">
                                                        @if(isset($resit->first()->nama_fail))
                                                            @foreach ($resit as $failResit)
                                                                <a target="_blank" href="{{ url('resit-aduan')."/".$failResit->nama_fail }}/Download">{{ $failResit->nama_fail }}</a><br>
                                                            @endforeach
                                                        @else
                                                            <span>Tiada Dokumen Sokongan</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="pt-4" style="border-left-style: hidden; border-right-style: hidden; padding: 0px">
                                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                            <li>
                                                                <a href="#" disabled style="pointer-events: none">
                                                                    <label class="form-label">
                                                                        <i class="fal fa-check-circle"></i> <b>STATUS TERKINI ADUAN</b> :
                                                                            @if($aduan->status_aduan=='BS')
                                                                            {
                                                                            <span class="badge badge-new">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @elseif($aduan->status_aduan=='DJ')
                                                                            {
                                                                                <span class="badge badge-sent">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @elseif($aduan->status_aduan=='TD')
                                                                            {
                                                                                <span class="badge badge-done">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @elseif($aduan->status_aduan=='AS')
                                                                            {
                                                                                <span class="badge badge-success">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @elseif($aduan->status_aduan=='LK')
                                                                            {
                                                                                <span class="badge badge-success2">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @elseif($aduan->status_aduan=='LU')
                                                                            {
                                                                                <span class="badge badge-success2">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @elseif($aduan->status_aduan=='AK')
                                                                            {
                                                                                <span class="badge badge-kiv">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @else
                                                                            {
                                                                                <span class="badge badge-duplicate">{{ strtoupper($aduan->status->nama_status) }}</span>
                                                                            }
                                                                            @endif
                                                                    </label>
                                                                </a>
                                                            </li>
                                                            <p></p>
                                                        </ol>
                                                    </td>
                                                </tr>
                                                @if($aduan->status_aduan == 'AB')
                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle">Sebab Pembatalan : </th>
                                                        <td colspan="4" style="vertical-align: middle; text-transform: uppercase">{{ $aduan->sebab_pembatalan ?? '-' }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Tarikh Aduan Dibuat : </th>
                                                    <td colspan="2" style="vertical-align: middle; text-transform: uppercase">{{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_laporan)) }}</td>
                                                    <th width="20%" style="vertical-align: middle">Tarikh Aduan Selesai : </th>
                                                    <td colspan="2" style="vertical-align: middle; text-transform: uppercase">
                                                        @if(isset($aduan->tarikh_selesai_aduan))
                                                            {{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if($aduan->notis_juruteknik != null)
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Notis Juruteknik : </th>
                                                    <td colspan="4" style="vertical-align: middle">{{ $aduan->notis_juruteknik ?? '-'}}</td>
                                                </tr>
                                                @endif
                                                {!! Form::open(['action' => 'Aduan\AduanUmumController@simpanPengesahan', 'method' => 'POST', 'id' => 'data']) !!}
                                                <input type="hidden" name="id" value="{{ $aduan->id }}">
                                                    @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK'|| $aduan->status_aduan == 'DP'|| $aduan->status_aduan == 'LU')
                                                        @if(isset($aduan->pengesahan_pembaikan))
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="5"><p class="form-label">
                                                                    <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px" type="checkbox" checked disabled>
                                                                    SAYA, <b><u>{{ strtoupper($aduan->nama_pelapor) }}</u></b> MENGESAHKAN BAHAWA ADUAN YANG DIBUAT TELAH DILAKUKAN PEMBAIKAN. </p>
                                                                </div>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="5"><p class="form-label" for="pengesahan_pembaikan">
                                                                    <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px; margin-bottom: 15px;" type="checkbox" name="pengesahan_pembaikan" id="chk" required onclick="btn()"/>
                                                                    SAYA, <b><u>{{ strtoupper($aduan->nama_pelapor) }}</u></b> MENGESAHKAN BAHAWA ADUAN YANG DIBUAT TELAH DILAKUKAN PEMBAIKAN. </p>
                                                                    <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Hantar Pengesahan</button></td>
                                                                </div>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                {!! Form::close() !!}
                                            </thead>
                                        </table>
                                    </div>
                                    <a href="/semak-aduan/{{$aduan->id_pelapor}}" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Kembali</a><br>
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
        function btn()
        {
            var chk = document.getElementById("chk")
            var submit = document.getElementById("submit");
            submit.disabled = chk.checked ? false : true;
            if(!submit.disabled){
                submit.focus();
            }
        }

        $(document).ready(function () {
            $("#data").submit(function () {
                $("#submit").attr("disabled", true);
                return true;
            });
        });
    </script>
@endsection
