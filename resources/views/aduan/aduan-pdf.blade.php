@extends('layouts.applicant')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">

            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>

            <h4 style="text-align: center">
                <b>BORANG E-ADUAN FASILITI <br> ( TIKET ID : {{$aduan->id}} )</b>
            </h4><br>

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
                                PEMBAIKAN ADUAN TELAH DISAHKAN
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
                                PEMBAIKAN ADUAN BELUM DISAHKAN
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
                            NOTIS DARIPADA JURUTEKNIK : <b>{{ $aduan->notis_juruteknik }}</b>
                        </div>
                    </div>
                </div>
            @endif

            <table class="table table-bordered table-hover w-100">
                <tr>
                    <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label"> INFO PENGADU</label></td>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="nama_pelapor">Nama Pelapor :</label></td>
                        <td colspan="2">{{ strtoupper($aduan->nama_pelapor ?? '-')  }}</td>
                        <td width="20%"><label class="form-label" for="nama_pelapor">
                            @if(isset($pengadu->category))
                                @if($pengadu->category == 'STF') ID Staf : @else ID Pelajar : @endif
                            @endif
                        </label></td>
                        <td colspan="2">{{ strtoupper($aduan->id_pelapor ?? '-')  }}</td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="emel_pelapor">Emel :</label></td>
                        <td colspan="2">{{ $aduan->emel_pelapor ?? '--'  }}</td>
                        <td width="20%"><label class="form-label" for="no_tel_pelapor">No Telefon :</label></td>
                        <td colspan="2">{{ $aduan->no_tel_pelapor ?? '--'  }}</td>
                    </div>
                </tr>
            </table>

            <table class="table table-bordered table-hover w-100">
                <tr>
                    <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">BUTIRAN ADUAN</label></td>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="tarikh_laporan">Tarikh Aduan Dibuat :</label></td>
                        <td colspan="2" style="text-transform: uppercase">{{ isset($aduan->tarikh_laporan) ? date('j F Y', strtotime($aduan->tarikh_laporan))  : '--' }}</td>
                        <td width="20%"><label class="form-label" for="tarikh_laporan">Masa Aduan Dibuat :</label></td>
                        <td colspan="2">{{ isset($aduan->tarikh_laporan) ? date('h:i:s A', strtotime($aduan->tarikh_laporan))  : '--'}}</td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="kategori_aduan">Kategori Aduan :</label></td>
                        <td colspan="4">
                            <div> {{ strtoupper($aduan->kategori->nama_kategori) }}</div>
                        </td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="tarikh_laporan">Jenis Kerosakan :</label></td>
                        <td colspan="2">
                            {{ strtoupper($aduan->jenis->jenis_kerosakan) }}<br>
                            @if($aduan->jenis->jenis_kerosakan == 'Lain-lain')
                                <div> PENERANGAN : <b>{{ strtoupper($aduan->jk_penerangan ?? '--') }}</b></div>
                            @endif
                        </td>
                        <td width="20%"><label class="form-label" for="tarikh_laporan">Sebab Kerosakan :</label></td>
                        <td colspan="2">
                            {{ strtoupper($aduan->sebab->sebab_kerosakan) }}<br>
                            @if($aduan->sebab->sebab_kerosakan == 'Lain-lain')
                                <div> PENERANGAN : <b>{{ strtoupper($aduan->sk_penerangan ?? '--') }}</b></div>
                            @endif
                        </td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="lokasi_aduan">Lokasi :</label></td>
                        <td colspan="2">
                            {{ strtoupper($aduan->nama_bilik) . ', ARAS ' . strtoupper($aduan->aras_aduan) . ', BLOK ' . strtoupper($aduan->blok_aduan) . ', ' . strtoupper($aduan->lokasi_aduan) ?? '-- TIADA DATA --'  }}
                        </td>
                        <td width="20%"><label class="form-label" for="maklumat_tambahan">Kuantiti/Unit :</label></td>
                        <td colspan="2">{{ $aduan->kuantiti_unit ?? '--'  }}</td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="maklumat_tambahan">Maklumat Tambahan :</label></td>
                        <td colspan="4" style="text-transform: uppercase">{{ $aduan->maklumat_tambahan ?? '--'  }}</td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%" style="vertical-align: middle"><label class="form-label" for="maklumat_tambahan">Gambar :</label></td>
                        <td colspan="2">
                            @if(isset($imej->first()->upload_image))
                                @foreach($imej as $imejAduan)
                                    <img src="/imej/{{ $imejAduan->upload_image }}" style="width:100px; height:100px;" class="img-fluid mr-2">
                                @endforeach
                            @else
                                <span>TIADA GAMBAR SOKONGAN</span>
                            @endif
                        </td>
                        <td width="20%" style="vertical-align: middle"><label class="form-label" for="maklumat_tambahan">Resit :</label></td>
                        <td colspan="2" style="vertical-align: middle">
                            @if(isset($resit->first()->nama_fail))
                                @foreach ($resit as $failResit)
                                    <a target="_blank" href="{{ url('resit')."/".$failResit->nama_fail }}/Download">{{ $failResit->nama_fail }}</a>
                                @endforeach
                            @else
                                <span>TIADA DOKUMEN SOKONGAN</span>
                            @endif
                        </td>
                    </div>
                </tr>
            </table>

            @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK'|| $aduan->status_aduan == 'DP'|| $aduan->status_aduan == 'LU'|| $aduan->status_aduan == 'AK')
                @if($aduan->id_pelapor != Auth::user()->id)
                    <table class="table table-bordered table-hover w-100">
                        <tr>
                            <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">INFO PEMBAIKAN</label></td>
                        </tr>
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
                                    <td width="20%"><label class="form-label" for="tahap_kategori">Tahap Aduan :</label></td>
                                    <td colspan="2" style="text-transform: uppercase">{{ $aduan->tahap->jenis_tahap ?? '--'}}</td>
                                    <td width="20%"><label class="form-label" for="caj_kerosakan">Caj Kerosakan :</label></td>
                                    <td colspan="2">{{ strtoupper($aduan->caj_kerosakan) ?? '--'}}</td>
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
                                    <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                                    <td colspan="4">
                                        @if(isset($alatan_ganti->first()->alat_ganti))
                                        <ol>
                                            @foreach($alatan_ganti as $al)
                                                <li style="text-transform: uppercase">{{ strtoupper($al->alat->alat_ganti) }}</li>
                                            @endforeach
                                        </ol>
                                        @else
                                            --
                                        @endif
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="20%"><label class="form-label" for="bahan_alat">Stok :</label></td>
                                    <td colspan="4">
                                        @if(isset($stok_pembaikan->first()->id_stok))
                                        <ol>
                                            @foreach($stok_pembaikan as $sp)
                                                <li>{{ strtoupper($sp->stok->stock_name)}} [ kuantiti: {{ $sp->kuantiti}} ]</li>
                                            @endforeach
                                        </ol>
                                        @else
                                            --
                                        @endif
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="20%" style="background-color: #fbfbfb82"><label class="form-label" for="kos">Anggaran Kos</label></td>
                                    <td colspan="4">
                                        <label for="ak_upah">UPAH : @if(isset($aduan->ak_upah)) RM {{ $aduan->ak_upah }} @else TIADA @endif</label><br>
                                        <label for="ak_bahan_alat">BAHAN/ALAT GANTI :  @if(isset($aduan->ak_bahan_alat)) RM {{ $aduan->ak_bahan_alat }}@else TIADA @endif</label><br>
                                        <label for="jumlah_kos">(+) JUMLAH KOS :   @if(isset($aduan->jumlah_kos)) RM {{ $aduan->jumlah_kos }}@else TIADA @endif</label>
                                    </td>
                                </div>
                            </tr>
                            <tr>
                                <div class="form-group">
                                    <td width="20%" style="background-color: #fbfbfb82"><label class="form-label" for="juruteknik_bertugas">Juruteknik Bertugas</label></td>
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
                @else
                    <table class="table table-bordered table-hover w-100">
                        <tr>
                            <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">RINGKASAN PEMBAIKAN</label></td>
                        </tr>
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
                @endif
            @endif

            <br>
            <div style="font-size: 10px">
                <p style="float: left">@ Copyright INTEC Education College</p>
                <p style="float: right">Review Date : {{ date(' j F Y | h:i:s A ', strtotime($aduan->created_at)) }}</p><br>
            </div>
        </div>
    </div>
</main>
@endsection


