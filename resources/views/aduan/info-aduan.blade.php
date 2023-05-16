@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-list-alt'></i>BORANG E-ADUAN : TIKET #{{$aduan->id}}
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
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
                        <div class="row">
                            @if(Auth::user()->hasRole('Technical Admin'))
                                @if($aduan->status_aduan == 'BS' || $aduan->status_aduan == 'DJ' || $aduan->status_aduan == 'TD')
                                    <div class="col-md-7">
                                @else
                                    <div class="col-md-12">
                                @endif
                            @endif
                            @if(Auth::user()->hasRole('Technical Staff'))
                                @if($juru->jenis_juruteknik == 'K')
                                    @if($aduan->status_aduan == 'DJ')
                                        <div class="col-md-7">
                                    @else
                                        <div class="col-md-12">
                                    @endif
                                @else
                                    <div class="col-md-12">
                                @endif
                            @endif
                                <div class="card card-primary card-outline p-4">
                                    <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                                    <h4 style="text-align: center">
                                        <b>BORANG E-ADUAN BAGI TIKET #{{$aduan->id}}</b>
                                    </h4>
                                    <center>
                                        <label class="form-label">
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
                                        </label><br>
                                    </center>
                                    <div class="panel-container show">
                                        <div class="panel-content">

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
                                                            <th width="20%" style="vertical-align: middle">
                                                                @if(isset($pengadu->category))
                                                                    @if($pengadu->category == 'STF') ID Staf : @else ID Pelajar : @endif
                                                                @else
                                                                    No. Kad Pengenalan :
                                                                @endif
                                                            </th>
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
                                                            <td colspan="2" style="vertical-align: middle; text-transform: uppercase">{{ date(' j F Y ', strtotime($aduan->tarikh_laporan)) }}</td>
                                                            <th width="20%" style="vertical-align: middle">Masa Aduan Dibuat : </th>
                                                            <td colspan="2" style="vertical-align: middle; text-transform: uppercase">{{ date(' h:i:s A ', strtotime($aduan->tarikh_laporan)) }}</td>
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
                                                            <span class=""> BUKTI DIMUATNAIK</span>
                                                        </a>
                                                    </li>
                                                    <p></p>
                                                </ol>
                                                <table id="muatnaik" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: top"> Gambar : </th>
                                                            <td colspan="2" style="text-transform: uppercase">
                                                                @if(isset($imej->first()->upload_image))
                                                                    @foreach($imej as $imejAduan)
                                                                        <a data-fancybox="gallery" href="/get-file-resit/{{ $imejAduan->upload_image }}"><img src="/get-file-resit/{{ $imejAduan->upload_image }}" style="width:150px; height:130px" class="img-fluid mr-2"></a>
                                                                    @endforeach
                                                                @else
                                                                    <span>TIADA GAMBAR SOKONGAN</span>
                                                                @endif
                                                            </td>

                                                            <th width="20%" style="vertical-align: top">Resit : </th>
                                                            <td colspan="2" style="text-transform: uppercase">
                                                                @if(isset($resit->first()->nama_fail))
                                                                    @foreach ($resit as $failResit)
                                                                        <a target="_blank" href="{{ url('resit')."/".$failResit->nama_fail }}/Download">{{ $failResit->nama_fail }}</a>
                                                                    @endforeach
                                                                @else
                                                                    <span>TIADA DOKUMEN SOKONGAN</span>
                                                                @endif
                                                            </td>
                                                        </tr>

                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none">
                                                            <i class="fal fa-upload"></i>
                                                            <span class=""> INFO PENYERAHAN</span>
                                                        </a>
                                                    </li>
                                                    <p></p>
                                                </ol>
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: middle"> Tahap Aduan : </th>
                                                            <td colspan="2" style="text-transform: uppercase">
                                                                {{ $aduan->tahap->jenis_tahap ?? '--'}}
                                                            </td>
                                                            <th width="20%" style="vertical-align: middle">Caj Kerosakan : </th>
                                                            <td colspan="2" style="text-transform: uppercase">
                                                                {{ $aduan->caj_kerosakan ?? '--'}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: middle"> Juruteknik Bertugas :</th>
                                                            <td colspan="4" style="text-transform: uppercase">
                                                                @if(isset($senarai_juruteknik->first()->juruteknik_bertugas))
                                                                    <ol style="margin-bottom: 0rem; margin-left: -25px">
                                                                        @foreach($senarai_juruteknik as $senarai)
                                                                            <li style="line-height: 30px"> {{ $senarai->juruteknik->name}}
                                                                                ( @if ($senarai->jenis_juruteknik == 'K') KETUA @endif
                                                                                @if ($senarai->jenis_juruteknik == 'P') PEMBANTU @endif )
                                                                            </li>
                                                                        @endforeach
                                                                    </ol>
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none">
                                                            <i class="fal fa-info"></i>
                                                            <span class=""> BUTIRAN PENAMBAHBAIKAN</span>
                                                        </a>
                                                    </li>
                                                    <p></p>
                                                </ol>
                                                <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                                                <td colspan="2">{{ isset($aduan->tarikh_serahan_aduan) ? date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) : '--' }}</td>
                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Serahan Aduan :</label></td>
                                                                <td colspan="2">{{ isset($aduan->tarikh_serahan_aduan) ? date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) : '--' }}</td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Penambahbaikan:</label></td>
                                                                <td colspan="2">{{ $aduan->laporan_pembaikan ?? '--'   }}</td>
                                                                <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                                                                <td colspan="2">
                                                                    @if(isset($alatan_ganti->first()->alat_ganti))
                                                                        <ol>
                                                                            @foreach($alatan_ganti as $al)
                                                                                <li>{{ $al->alat->alat_ganti}}</li>
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
                                                                <td class="card-header" width="20%" style="border-right-style: hidden; background-color: #fbfbfb82"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                                <td class="card-header" style="background-color: #fbfbfb82" colspan="4"><b></b></td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%">
                                                                    <label class="form-label" for="ak_upah">Upah :</label><br><br>
                                                                    <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label>
                                                                </td>
                                                                <td colspan="4">
                                                                    RM {{ $aduan->ak_upah ?? '--'   }}<br><br>
                                                                    RM {{ $aduan->ak_bahan_alat ?? '--'   }}
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                    <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label>
                                                                </td>
                                                                <td colspan="4" style="background-color: #ddd; cursor: not-allowed;">
                                                                    RM {{ $aduan->jumlah_kos ?? '--'   }}
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <th width="20%" style="vertical-align: top"> Gambar : </th>
                                                            <td colspan="4">
                                                                @if(isset($gambar->first()->upload_image))
                                                                    @foreach($gambar as $imejPembaikan)
                                                                        <a data-fancybox="gallery" href="/get-file-gambar/{{ $imejPembaikan->upload_image }}"><img src="/get-file-gambar/{{ $imejPembaikan->upload_image }}" style="width:150px; height:130px" class="img-fluid mr-2"></a>
                                                                    @endforeach
                                                                @else
                                                                    <span>TIADA GAMBAR SOKONGAN</span>
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Penambahbaikan:</label></td>
                                                                <td colspan="2">{{ isset($aduan->tarikh_selesai_aduan) ? date(' j F Y ', strtotime($aduan->tarikh_selesai_aduan)) : '--' }}</td>
                                                                <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Masa Selesai Penambahbaikan:</label></td>
                                                                <td colspan="2">{{ isset($aduan->tarikh_selesai_aduan) ? date('h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) : '--' }}</td>
                                                            </div>
                                                        </tr>
                                                        @if($aduan->tukar_status != null)
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Penukaran Status Oleh :</label></td>
                                                                <td colspan="4">{{ $aduan->penukaran->staff_name ?? '--' }}</td>
                                                            </div>
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Sebab Penukaran Status :</label></td>
                                                                <td colspan="4">{{ $aduan->sebab_tukar_status ?? '--' }}</td>
                                                            </div>
                                                        </tr>
                                                        @endif
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none">
                                                            <i class="fal fa-upload"></i>
                                                            <span class=""> PENGESAHAN PENAMBAHBAIKAN</span>
                                                        </a>
                                                    </li>
                                                    <p></p>
                                                </ol>
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                <td colspan="4" style="text-transform: uppercase">{{ $aduan->catatan_pembaikan ?? '--'   }}</td>
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none">
                                                            <i class="fal fa-upload"></i>
                                                            <span class=""> PENGESAHAN PELAPOR</span>
                                                        </a>
                                                    </li>
                                                    <p></p>
                                                </ol>
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td width="20%"><label class="form-label" for="catatan_pembaikan">Pengesahan :</label></td>
                                                            <td colspan="2" style="text-transform: uppercase"><b>
                                                                @if($aduan->pengesahan_pembaikan == 'Y')
                                                                    <b>TELAH DISAHKAN</b>
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <a data-page="/pdfAduan/{{$aduan->id}}" class="btn btn-danger text-white float-right" style="cursor: pointer" onclick="Print(this)"><i class="fal fa-print"></i> Cetak Borang</a>
                                            <a href="javascript:history.back()" class="btn btn-success ml-auto float-right mr-2" ><i class="fal fa-arrow-alt-left"></i> Kembali</a><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                @can('view technical admin')
                                    @if($aduan->status_aduan == 'BS' || $aduan->status_aduan == 'DJ')
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>PENYERAHAN ADUAN</h5>
                                            </div>
                                            <div class="card-body">
                                                {!! Form::open(['action' => 'Aduan\AduanController@kemaskiniTahap', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'data']) !!}
                                                <input type="hidden" name="ids" value="{{ $aduan->id }}">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td colspan="2" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"><span class="text-danger">*</span> Tahap Aduan :</label></td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td colspan="2" style="vertical-align: middle">
                                                                            <select class="form-control tahap_kategori" name="tahap_kategori" id="tahap_kategori" required>
                                                                                <option value="" disabled selected>Sila Pilih</option>
                                                                                @foreach ($tahap as $thp)
                                                                                    <option value="{{ $thp->kod_tahap }}" {{ $aduan->tahap_kategori == $thp->kod_tahap ? 'selected="selected"' : '' }}>{{ $thp->jenis_tahap }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('tahap_kategori')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td colspan="2" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"><span class="text-danger">*</span> Adakah Kerosakan Dicaj ?</label></td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td colspan="2" style="padding-top: 20px; padding-left: 0px">
                                                                            <input class="ml-5" type="radio" name="caj_kerosakan" id="caj_kerosakan" required value="Ya" {{ $aduan->caj_kerosakan == "Ya" ? 'checked="checked"' : '' }}> Ya
                                                                            <input class="ml-5" type="radio" name="caj_kerosakan" id="caj_kerosakan" value="Tidak" {{ $aduan->caj_kerosakan == "Tidak" ? 'checked="checked"' : '' }}> Tidak
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td colspan="2" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"><span class="text-danger">*</span> Juruteknik :</label></td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                    <td colspan="2">
                                                                            <div class="test" id="test">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-bordered" id="head_field">
                                                                                        <tr class="bg-primary-50 text-center">
                                                                                            <td>Juruteknik</td>
                                                                                            <td>Tugas</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <select class="form-control juruteknik_bertugas" name="juruteknik_bertugas[]" required>
                                                                                                    <option value="" disabled selected>Sila Pilih</option>
                                                                                                    @foreach ($juruteknik as $juru)
                                                                                                    <option value="{{ $juru->id }}" {{ old('juruteknik_bertugas') ? 'selected' : '' }}>
                                                                                                            {{ $juru->name }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </td>
                                                                                            <td>
                                                                                                <select class="form-control jenis_juruteknik" name="jenis_juruteknik[]" required>
                                                                                                    <option value="" disabled selected>Sila Pilih</option>
                                                                                                    <option value="K">Ketua</option>
                                                                                                    <option value="P">Pembantu</option>
                                                                                                </select>
                                                                                            </td>
                                                                                            <td class="text-center"><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <button type="submit" class="btn btn-danger float-right" name="submit" id="submithead"><i class="fal fa-save"></i> Simpan Penyerahan</button>
                                                                                </div><br>
                                                                                @if(session()->has('kemaskiniTahap'))
                                                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                                                                        {{ session()->get('kemaskiniTahap') }}
                                                                                    </div>
                                                                                @endif
                                                                                <table class="table table-bordered">
                                                                                    <thead>
                                                                                        <tr class="text-center" style="background-color: #fbfbfb82">
                                                                                            <td style="width: 5px">ID</td>
                                                                                            <td>Juruteknik</td>
                                                                                            <td>Tugas</td>
                                                                                            <td>Tindakan</td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @foreach ($senarai_juruteknik as $sJ)
                                                                                        <input type="hidden" name="id" value="{{ $sJ->id }}">
                                                                                            <tr class="data-row" align="center">
                                                                                                <td>{{ $sJ->juruteknik_bertugas }}</td>
                                                                                                <td>{{ $sJ->juruteknik->name }}</td>
                                                                                                <td>
                                                                                                    @if($sJ->jenis_juruteknik == 'K')
                                                                                                    Ketua
                                                                                                    @elseif($sJ->jenis_juruteknik == 'P')
                                                                                                    Pembantu
                                                                                                    @else
                                                                                                    --
                                                                                                    @endif
                                                                                                </td>
                                                                                                <td>
                                                                                                    <a href="{{ action('Aduan\AduanController@padamJuruteknik', ['id' => $sJ->id, 'id_aduan' => $sJ->id_aduan]) }}" class="btn btn-danger btn-sm deleteJr"><i class="fal fa-trash"></i></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <br><br>
                                    @endif
                                @endcan
                                @can('view technical staff')
                                 @if(isset($juru))
                                        @if($juru->jenis_juruteknik == 'K')
                                            @if($aduan->status_aduan == 'DJ')
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header">
                                                        <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>BORANG PENAMBAHBAIKAN</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        {!! Form::open(['action' => 'Aduan\AduanController@kemaskiniPenambahbaikan', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'datas']) !!}
                                                        {{Form::hidden('idp', $aduan->id)}}
                                                        <div class="table-responsive">
                                                            <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2"><label class="form-label" for="laporan_pembaikan"><span class="text-danger">*</span> Laporan Penambahbaikan:</label></td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2">
                                                                                <textarea rows="5" class="form-control" id="laporan_pembaikan" name="laporan_pembaikan" required>{{ $aduan->laporan_pembaikan }}</textarea>
                                                                                {{-- <p align="right" class="mt-2">Tidak melebihi 1000 huruf</p>
                                                                                maxlength="1000" --}}
                                                                                @error('laporan_pembaikan')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2"><label class="form-label" for="laporan_pembaikan"> Bahan/ Alat Ganti :</label></td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2">
                                                                                <select class="form-control bahan_alat" name="bahan_alat[]" multiple>
                                                                                    <option value="" disabled>Sila Pilih</option>
                                                                                        @foreach ($senarai_alat as $alats)
                                                                                            <option value="{{ $alats->id }}">{{ $alats->alat_ganti }}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                                @error('bahan_alat')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                                <br>
                                                                                <div class="card-body">
                                                                                    @if(session()->has('message'))
                                                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                                                                            {{ session()->get('message') }}
                                                                                        </div>
                                                                                    @endif
                                                                                    <table class="table table-bordered">
                                                                                        <tr class="text-center">
                                                                                            <td>No</td>
                                                                                            <td>Bahan/Alat Ganti</td>
                                                                                            <td>Tindakan</td>
                                                                                        </tr>
                                                                                        @if(!empty($alatan_ganti) && $alatan_ganti->count() > 0)
                                                                                            @foreach ($alatan_ganti as $aG)
                                                                                            <tr align="center">
                                                                                                <td>{{ $urutan++}}</td>
                                                                                                <td>{{ $aG->alat->alat_ganti }}</td>
                                                                                                <td>
                                                                                                    <a href="{{ action('Aduan\AduanController@padamAlatan', ['id' => $aG->id, 'id_aduan' => $aG->id_aduan]) }}" class="btn btn-danger btn-sm deleteEl"><i class="fal fa-trash"></i></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <tr align="center" class="data-row">
                                                                                                <td valign="top" colspan="3" class="dataTables_empty">-- TIADA DATA --</td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    </table>
                                                                                </div>
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2"><label class="form-label" for="upload_image"> Gambar Penambahbaikan:</label></td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2" style="vertical-align: middle">
                                                                                <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple><br>
                                                                                <div class="card-body">
                                                                                    @if(session()->has('messages'))
                                                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                                                                            {{ session()->get('messages') }}
                                                                                        </div>
                                                                                    @endif
                                                                                    <table class="table table-bordered">
                                                                                        <tr class="text-center">
                                                                                            <td>Gambar</td>
                                                                                            <td>Tindakan</td>
                                                                                        </tr>
                                                                                        @if(!empty($gambar) && $gambar->count() > 0)
                                                                                            @foreach($gambar as $imejPembaikan)
                                                                                            <tr align="center">
                                                                                                <td><a target="_blank" href="{{ url('pembaikan')."/".$imejPembaikan->upload_image }}/Download">{{ $imejPembaikan->upload_image }}</a></td>
                                                                                                <td style="vertical-align: middle">
                                                                                                    <a href="{{ action('Aduan\AduanController@padamGambar', ['id' => $imejPembaikan->id, 'id_aduan' => $imejPembaikan->id_aduan]) }}" class="btn btn-danger btn-sm deleteEg"><i class="fal fa-trash"></i></a>
                                                                                                </td>
                                                                                            </tr>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <tr align="center" class="data-row">
                                                                                                <td valign="top" colspan="3" class="dataTables_empty">-- TIADA DATA --</td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    </table>
                                                                                </div>
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td class="card-header" colspan="2" style="border-right-style: hidden; background-color: #fbfbfb82"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td  colspan="1">
                                                                                <label class="form-label" for="ak_upah">Upah :</label><label class="form-label" style="padding-left: 205px;" for="ak_upah">RM</label><br><br><br><br>
                                                                                <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label><label class="form-label" style="padding-left: 130px;" for="ak_bahan_alat">RM</label>
                                                                            </td>
                                                                            <td colspan="1">
                                                                                <input type="number" step="any" class="form-control" id="ak_upah" name="ak_upah"  value="{{ $aduan->ak_upah }}">
                                                                                    @error('ak_upah')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror<br><br>
                                                                                <input type="number" step="any" class="form-control" id="ak_bahan_alat" name="ak_bahan_alat" value="{{ $aduan->ak_bahan_alat }}">
                                                                                    @error('ak_bahan_alat')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror<br>
                                                                            </td>


                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td  colspan="1" style="background-color: #ddd; cursor: not-allowed;">
                                                                                <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label><label class="form-label" style="padding-left: 133px;" for="jumlah_kos">RM</label>
                                                                            </td>
                                                                            <td colspan="1" style="background-color: #ddd; cursor: not-allowed;">
                                                                                <input type="number" step="any" class="form-control" id="jumlah_kos" style="cursor:context-menu;" name="jumlah_kos" value="{{ $aduan->jumlah_kos }}" readonly>
                                                                                    @error('jumlah_kos')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2"><label class="form-label" for="upload_image"><span class="text-danger">*</span> Tarikh Selesai Penambahbaikan:</label></td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2">
                                                                            @if(isset($aduan->tarikh_selesai_aduan))
                                                                                <input type="datetime-local" class="form-control" required id="tarikh_selesai_aduan" name="tarikh_selesai_aduan" value="{{ date('Y-m-d\TH:i', strtotime($aduan->tarikh_selesai_aduan)) }}" />
                                                                            @else
                                                                                <input type="datetime-local" class="form-control" required id="tarikh_selesai_aduan" name="tarikh_selesai_aduan" value="{{ old('tarikh_selesai_aduan') }}">
                                                                            @endif
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2"><label class="form-label" for="upload_image"><span class="text-danger">*</span> Status Aduan :</label></td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="2">
                                                                                <select class="form-control status_aduan" name="status_aduan" id="status_aduan" required>
                                                                                <option value="" disabled selected>Sila Pilih</option>
                                                                                    @foreach($status as $stt)
                                                                                        <option value="{{$stt->kod_status}}"  {{ $aduan->status_aduan == $stt->kod_status ? 'selected="selected"' : '' }}>{{$stt->nama_status}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('status_aduan')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                        </div>
                                                                    </tr>


                                                                </thead>
                                                            </table>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger float-right" id="submitheads"><i class="fal fa-save"></i> Simpan Penambahbaikan</button>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                <br><br>
                                            @endif
                                        @endif
                                    @endif
                                @endcan
                                @can('view technical admin')
                                    @if($aduan->status_aduan == 'TD' && $aduan->pengesahan_pembaikan != 'Y')
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>PENGESAHAN PENAMBAHBAIKAN</h5>
                                            </div>
                                            <div class="card-body">
                                                {!! Form::open(['action' => 'Aduan\AduanController@simpanStatus', 'method' => 'POST', 'id' => 'datass']) !!}
                                                {{Form::hidden('ide', $aduan->id)}}
                                                <div class="table-responsive">
                                                    <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="2"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="2">
                                                                        <textarea rows="3" class="form-control" maxlength="150" id="catatan_pembaikan" name="catatan_pembaikan">{{ old('catatan_pembaikan') }}</textarea>
                                                                        <p align="right" class="mt-2">Tidak melebihi 150 huruf</p>
                                                                        @error('catatan_pembaikan')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="2"><label class="form-label" for="status_aduan"><span class="text-danger">*</span> Tukar Status :</label></td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="2">
                                                                        <select class="form-control status_adu" name="status_aduan" id="status_aduan" required>
                                                                            <option value="" disabled selected>Sila Pilih</option>
                                                                            @foreach ($tukarStatus as $stats)
                                                                            <option value="{{ $stats->kod_status }}" {{ old('status_aduan') ? 'selected' : '' }}>
                                                                                    {{ $stats->nama_status }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('status_aduan')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>

                                                        </thead>
                                                    </table>
                                                </div>
                                                    <button type="submit" class="btn btn-danger float-right" id="submitheadss"><i class="fal fa-save"></i> Simpan Pengesahan</button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <br><br>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

            </div>

</main>
@endsection

@section('script')
    <script>

        $(document).ready(function() {
            $('.tahap_kategori, .juruteknik_bertugas, .status_aduan, .status_adu, .tukar_status, .jenis_juruteknik, .bahan_alat').select2();

            sum();
            $("#ak_upah, #ak_bahan_alat").on("keydown keyup", function() {
                sum();
            });

            // Tambah Juruteknik
            $('#addhead').click(function(){
                i++;
                $('#head_field').append(`
                <tr id="row${i}" class="head-added">
                <td>
                    <select class="form-control juruteknik_bertugas" name="juruteknik_bertugas[]" required>
                        <option value="" disabled selected>Sila Pilih</option>
                        @foreach ($juruteknik as $juru)
                        <option value="{{ $juru->id }}" {{ old('juruteknik_bertugas') ? 'selected' : '' }}>
                                {{ $juru->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control jenis_juruteknik" name="jenis_juruteknik[]" required>
                        <option value="" disabled selected>Sila Pilih</option>
                        <option value="P">Pembantu</option>
                    </select>
                </td>
                <td class="text-center"><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
                </tr>
                `);
                $('.juruteknik_bertugas, .jenis_juruteknik').select2();
            });

            var postURL = "<?php echo url('addmore'); ?>";
            var i=1;

            $.ajaxSetup({
                headers:{
                'X-CSRF-Token' : $("input[name=_token]").val()
                }
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submithead').click(function(){
                $.ajax({
                    url:postURL,
                    method:"POST",
                    data:$('#add_name').serialize(),
                    type:'json',
                    success:function(data)
                    {
                        if(data.error){
                            printErrorMsg(data.error);
                        }else{
                            i=1;
                            $('.head-added').remove();
                        }
                    }
                });
            });

        });

        function sum() {
            var ak_upah = $('#ak_upah').val();
            var ak_bahan_alat = $('#ak_bahan_alat').val();
            var jumlah_kos = parseFloat(ak_upah) + parseFloat(ak_bahan_alat);
            var result = jumlah_kos.toFixed(2);
            $('#jumlah_kos').val(result);
        }

        function Print(button)
        {
            var url = $(button).data('page');
            var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function(){
                printWindow.print();
            }, true);
        }

        $(document).ready(function () {
            $("#data").submit(function () {
                $("#submithead").attr("disabled", true);
                return true;
            });
        });

        $(document).ready(function () {
            $("#datas").submit(function () {
                $("#submitheads").attr("disabled", true);
                return true;
            });
        });

        $(document).ready(function () {
            $("#datass").submit(function () {
                $("#submitheadss").attr("disabled", true);
                return true;
            });
        });

    </script>
@endsection
