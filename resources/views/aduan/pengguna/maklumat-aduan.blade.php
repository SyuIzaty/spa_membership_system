@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                        <h4 style="text-align: center">
                            <b>BORANG E-ADUAN FASILITI <br> ( TIKET ID : {{$aduan->id}} )</b>
                        </h4>

                        <div class="panel-container show">
                            <div class="panel-content">

                                @php
                                    $alertClasses = [
                                        'BS' => ['bg' => '#858cdf6b', 'text' => '#101ad8', 'border' => '#1c1ceb'],
                                        'DJ' => ['bg' => '#d585df6b', 'text' => '#b710d8', 'border' => '#b711d5'],
                                        'TD' => ['bg' => '#dfc6856b', 'text' => '#d88f10', 'border' => '#eb911c'],
                                        'AS' => ['bg' => '#8cdf856b', 'text' => '#049810', 'border' => '#28a745'],
                                        'LK' => ['bg' => '#8cdf856b', 'text' => '#049810', 'border' => '#28a745'],
                                        'LU' => ['bg' => '#8cdf856b', 'text' => '#049810', 'border' => '#28a745'],
                                        'AK' => ['bg' => '#df99856b', 'text' => '#d83b10', 'border' => '#b51b1b'],
                                    ];

                                    $status = $aduan->status_aduan;
                                    $statusClass = $alertClasses[$status] ?? ['bg' => '#df85856b', 'text' => '#d81010', 'border' => '#df8585'];
                                @endphp

                                <div class="alert alert-dismissible fade show" style="background-color: {{ $statusClass['bg'] }}; color: {{ $statusClass['text'] }}; border: 1px solid {{ $statusClass['border'] }}">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                    </button>
                                    <div class="d-flex align-items-center">
                                        <div class="alert-icon width-8">
                                            <i class="fal fa-info-circle"></i>
                                        </div>
                                        <div class="flex-1 pl-1">
                                            STATUS TERKINI : <b>{{ strtoupper($aduan->status->nama_status) }}</b>
                                            @if($aduan->status_aduan == 'AB')
                                                [ SEBAB PEMBATALAN : {{ strtoupper($aduan->sebab_pembatalan) ?? 'TIADA' }} ]
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK'|| $aduan->status_aduan == 'DP'|| $aduan->status_aduan == 'LU')
                                    @if(isset($aduan->pengesahan_pembaikan))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <div class="alert-icon width-8">
                                                    <i class="fal fa-check-circle color-success-800"></i>
                                                </div>
                                                <div class="flex-1 pl-1">
                                                    <b>PEMBAIKAN ADUAN TELAH DISAHKAN OLEH PENGADU</b>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                            </button>
                                            <div class="d-flex align-items-center">
                                                <div class="alert-icon width-8">
                                                    <i class="fal fa-times-circle color-danger-800"></i>
                                                </div>
                                                <div class="flex-1 pl-1">
                                                    <b>PEMBAIKAN ADUAN BELUM DISAHKAN OLEH PENGADU</b>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if(isset($aduan->notis_juruteknik))
                                    <div class="alert alert-warning alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                        </button>
                                        <div class="d-flex align-items-center">
                                            <div class="alert-icon width-8">
                                                <i class="fal fa-comment color-warning-800"></i>
                                            </div>
                                            <div class="flex-1 pl-1">
                                                NOTIS JURUTEKNIK : <b>{{ $aduan->notis_juruteknik }}</b>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif
                                <div class="table-responsive">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <i class="fal fa-user"></i>
                                                <span class=""> INFO PENGADU</span>
                                            </a>
                                        </li>
                                        <p></p>
                                    </ol>
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Nama Penuh : </th>
                                                <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->nama_pelapor)}}</td>
                                                <th width="20%" style="vertical-align: middle">@if(Auth::user()->hasRole('Staff') ) ID Staf : @endif @if(Auth::user()->hasRole('Student') ) ID Pelajar : @endif</th>
                                                <td colspan="2" style="vertical-align: middle">{{ strtoupper($aduan->id_pelapor)}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Emel : </th>
                                                <td colspan="2" style="vertical-align: middle">{{ $aduan->emel_pelapor}}</td>
                                                <th width="20%" style="vertical-align: middle">No. Telefon : </th>
                                                <td colspan="2" style="vertical-align: middle">{{ $aduan->no_tel_pelapor}}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <i class="fal fa-info"></i>
                                                <span class=""> BUTIRAN ADUAN</span>
                                            </a>
                                        </li>
                                        <p></p>
                                    </ol>
                                    <table id="aduan" class="table table-bordered table-hover table-striped w-100">
                                        <thead>

                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Tarikh Aduan Dibuat : </th>
                                                <td colspan="2" style="vertical-align: middle">{{ isset($aduan->tarikh_laporan) ? date('j F Y', strtotime($aduan->tarikh_laporan))  : '--' }}</td>
                                                <th width="20%" style="vertical-align: middle">Masa Aduan Dibuat : </th>
                                                <td colspan="2" style="vertical-align: middle">{{ isset($aduan->tarikh_laporan) ? date('h:i:s A', strtotime($aduan->tarikh_laporan))  : '--'}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Pejabat/Bahagian/ Fakulti/Kolej : </th>
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
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <i class="fal fa-upload"></i>
                                                <span class="">BUKTI DIMUATNAIK</span>
                                            </a>
                                        </li>
                                        <p></p>
                                    </ol>
                                    <table id="muatnaik" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                <td colspan="2" style="text-transform: uppercase;vertical-align: middle">
                                                    @if(isset($imej->first()->upload_image))
                                                        @foreach($imej as $imejAduan)
                                                            <a data-fancybox="gallery" href="/imej/{{ $imejAduan->upload_image }}"><img src="/imej/{{ $imejAduan->upload_image }}" style="width:150px; height:130px" class="img-fluid mr-2"></a>
                                                        @endforeach
                                                    @else
                                                        <span>Tiada Gambar Sokongan</span>
                                                    @endif
                                                </td>

                                                <th width="20%" style="vertical-align: middle">Resit : </th>
                                                <td colspan="2" style="text-transform: uppercase;vertical-align: middle">
                                                    @if(isset($resit->first()->nama_fail))
                                                        @foreach ($resit as $failResit)
                                                            <a target="_blank" href="{{ url('resit')."/".$failResit->nama_fail }}/Download">{{ $failResit->nama_fail }}</a>
                                                        @endforeach
                                                    @else
                                                        <span>Tiada Dokumen Sokongan</span>
                                                    @endif
                                                </td>
                                            </tr>

                                        </thead>
                                    </table>
                                </div>

                                @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK'|| $aduan->status_aduan == 'DP'|| $aduan->status_aduan == 'LU' || $aduan->status_aduan == 'AK')
                                    <div class="table-responsive">
                                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                            <li>
                                                <a href="#" disabled style="pointer-events: none">
                                                    <label class="form-label">
                                                        <i class="fal fa-list"></i> RINGKASAN PEMBAIKAN
                                                    </label>
                                                </a>
                                            </li>
                                            <p></p>
                                        </ol>
                                        <table class="table table-bordered table-hover w-100">
                                            <tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                                        <td colspan="2" style="text-transform: uppercase">{{ isset($aduan->tarikh_serahan_aduan) ? date(' j F Y | h:i:s A', strtotime($aduan->tarikh_serahan_aduan)) : '--' }}</td>
                                                        <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan :</label></td>
                                                        <td colspan="2" style="text-transform: uppercase">{{ isset($aduan->tarikh_selesai_aduan) ? date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) : '--'}}</td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan :</label></td>
                                                        <td colspan="4" style="text-transform: uppercase">{{ $aduan->laporan_pembaikan ?? '--'  }}</td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%" style="background-color: #fbfbfb82"><label class="form-label" for="juruteknik_bertugas"> Juruteknik Bertugas</label></td>
                                                        <td colspan="4" style="vertical-align: middle">
                                                            @if(!empty($juruteknik) && count($juruteknik) > 0)
                                                                <ol style="margin-left: -25px">
                                                                    @foreach($juruteknik as $senarai_juruteknik)
                                                                        <li style="line-height: 30px">
                                                                            @if ($senarai_juruteknik->jenis_juruteknik == 'K') KETUA @endif
                                                                            @if ($senarai_juruteknik->jenis_juruteknik == 'P') PEMBANTU @endif
                                                                            :
                                                                            {{ $senarai_juruteknik->juruteknik->name ?? '--'}}
                                                                            @if(isset($senarai_juruteknik->juruteknik->staff))
                                                                                @if(isset($senarai_juruteknik->juruteknik->staff->staff_phone))
                                                                                    ( {{ $senarai_juruteknik->juruteknik->staff->staff_phone }} )
                                                                                @elseif(isset($senarai_juruteknik->juruteknik->staff->staff_email))
                                                                                    ( {{ $senarai_juruteknik->juruteknik->staff->staff_email }} )
                                                                                @endif
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                            @else
                                                                TIADA JURUTEKNIK DITUGASKAN
                                                            @endif
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                    <td colspan="4">
                                                        @if(isset($gambar->first()->upload_image))
                                                            @foreach($gambar as $imejPembaikan)
                                                                <img src="/imej-pembaikan/{{ $imejPembaikan->upload_image }}" style="width:100px; height:100px;" class="img-fluid mr-2">
                                                            @endforeach
                                                        @else
                                                            <span>TIADA GAMBAR SOKONGAN</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tr>
                                        </table>
                                    </div>

                                    @if($aduan->status_aduan != 'AK')
                                        <div class="table-responsive">
                                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                <li>
                                                    <a href="#" disabled style="pointer-events: none">
                                                        <label class="form-label">
                                                            <i class="fal fa-check-circle"></i> PENGESAHAN PEMBAIKAN
                                                        </label>
                                                    </a>
                                                </li>
                                                <p></p>
                                            </ol>
                                            <table id="verifikasi" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    {!! Form::open(['action' => 'Aduan\AduanController@simpanPengesahan', 'method' => 'POST', 'id' => 'data']) !!}
                                                    <input type="hidden" name="id" value="{{ $aduan->id }}">
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
                                                                    <button style="margin-top: 5px;" class="btn btn-success float-right" id="submit" name="submit" disabled><i class="fal fa-check"></i> Hantar Pengesahan</button></td>
                                                                </div>
                                                            </tr>
                                                        @endif
                                                    {!! Form::close() !!}
                                                </thead>
                                            </table>
                                        </div>
                                    @endif
                                @endif
                                <a href="/aduan-individu" class="btn btn-secondary ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Kembali</a><br>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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

