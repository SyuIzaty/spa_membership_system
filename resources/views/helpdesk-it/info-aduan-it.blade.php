@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-list-alt'></i>BORANG E-ADUAN IT - TIKET ID : {{$aduan->id}}
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2></h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card card-primary card-outline p-4">
                                <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                                <h4 style="text-align: center">
                                    <b>BORANG E-ADUAN IT - TIKET ID : {{$aduan->id}}</b>
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
                                                                    <a data-fancybox="gallery" href="/imej/{{ $imejAduan->upload_image }}"><img src="/imej/{{ $imejAduan->upload_image }}" style="width:150px; height:130px" class="img-fluid mr-2"></a>
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
                                                        <i class="fal fa-info"></i>
                                                        <span class=""> INFO PENYERAHAN ADUAN</span>
                                                    </a>
                                                </li>
                                                <p></p>
                                            </ol>
                                            <table class="table table-bordered table-hover table-striped w-100">
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
                                                        <td colspan="4">
                                                            @if(!empty($senarai_juruteknik) && count($senarai_juruteknik) > 0)
                                                                <ol style="margin-left: -25px; margin-bottom: -10px">
                                                                    @foreach($senarai_juruteknik as $teknikal)
                                                                        <li>
                                                                            @if ($teknikal->jenis_juruteknik == 'K') KETUA @endif
                                                                            @if ($teknikal->jenis_juruteknik == 'P') PEMBANTU @endif
                                                                            :
                                                                            {{ $teknikal->juruteknik->name ?? '--'}}
                                                                            @if(isset($teknikal->juruteknik->staff))
                                                                                @if(isset($teknikal->juruteknik->staff->staff_phone))
                                                                                    ( {{ $teknikal->juruteknik->staff->staff_phone }} )
                                                                                @elseif(isset($teknikal->juruteknik->staff->staff_email))
                                                                                    ( {{ $teknikal->juruteknik->staff->staff_email }} )
                                                                                @endif
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                            @else
                                                                TIADA JURUTEKNIK DITUGASKAN
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @if(isset($aduan->notis_juruteknik))
                                                        <tr>
                                                            <th width="20%" style="vertical-align: middle"> Notis :</th>
                                                            <td colspan="4">
                                                                {{ $aduan->notis_juruteknik }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                <li>
                                                    <a href="#" disabled style="pointer-events: none">
                                                        <i class="fal fa-info"></i>
                                                        <span class=""> BUTIRAN PEMBAIKAN</span>
                                                    </a>
                                                </li>
                                                <p></p>
                                            </ol>
                                            <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan:</label></td>
                                                            <td colspan="2">{{ isset($aduan->tarikh_selesai_aduan) ? date(' j F Y ', strtotime($aduan->tarikh_selesai_aduan)) : '--' }}</td>
                                                            <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Masa Selesai Pembaikan:</label></td>
                                                            <td colspan="2">{{ isset($aduan->tarikh_selesai_aduan) ? date('h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) : '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan:</label></td>
                                                            <td colspan="4">{{ $aduan->laporan_pembaikan ?? '--'   }}</td>
                                                        </div>
                                                    </tr>

                                                    <tr>
                                                        <div class="form-group">
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
                                                            <td width="20%"><label class="form-label" for="bahan_alat">Stok :</label></td>
                                                            <td colspan="2">
                                                                @if(isset($stok_pembaikan->first()->id_stok))
                                                                    <ol>
                                                                        @foreach($stok_pembaikan as $sp)
                                                                            <li>{{ $sp->stok->stock_name}} [ kuantiti: {{ $sp->kuantiti}} ]</li>
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
                                                                <label for="ak_upah"> @if(isset($aduan->ak_upah)) RM {{ $aduan->ak_upah }} @else - @endif</label><br><br>
                                                                <label for="ak_bahan_alat">@if(isset($aduan->ak_bahan_alat)) RM {{ $aduan->ak_bahan_alat }}@else - @endif</label>
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label>
                                                            </td>
                                                            <td colspan="4" style="background-color: #ddd; cursor: not-allowed;">
                                                                @if(isset($aduan->jumlah_kos)) RM {{ $aduan->jumlah_kos }}@else - @endif
                                                            </td>
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
                                                        <span class=""> BUKTI PEMBAIKAN DIMUATNAIK</span>
                                                    </a>
                                                </li>
                                                <p></p>
                                            </ol>
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top"> Gambar : </th>
                                                        <td colspan="4">
                                                            @if(isset($gambar->first()->upload_image))
                                                                @foreach($gambar as $imejPembaikan)
                                                                    <a data-fancybox="gallery" href="/imej-pembaikan/{{ $imejPembaikan->upload_image }}"><img src="/imej-pembaikan/{{ $imejPembaikan->upload_image }}" style="width:150px; height:130px" class="img-fluid mr-2"></a>
                                                                @endforeach
                                                            @else
                                                                <span>TIADA GAMBAR SOKONGAN</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK'|| $aduan->status_aduan == 'DP'|| $aduan->status_aduan == 'LU')
                                            <div class="table-responsive">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none">
                                                            <i class="fal fa-pencil"></i>
                                                            <span class=""> PENGESAHAN PEMBAIKAN ADMIN</span>
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
                                        @endif
                                        <a href="/aduan-it" class="btn btn-secondary ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Kembali</a><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>MAKLUMAT PEMBAIKAN</h5>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['action' => 'HelpdeskIT\EAduanController@simpanPembaikanIT', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'data']) !!}
                                    <input type="hidden" name="id" value="{{ $aduan->id }}">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr class="bg-secondary text-white">
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="tarikh_serahan_aduan"> INFO PENYERAHAN ADUAN </label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="tarikh_serahan_aduan"> Tarikh Penyerahan Aduan:</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2">
                                                            @if(isset($aduan->tarikh_serahan_aduan))
                                                                <input type="datetime-local" class="form-control" id="tarikh_serahan_aduan" name="tarikh_serahan_aduan" value="{{ date('Y-m-d\TH:i', strtotime($aduan->tarikh_serahan_aduan)) }}" />
                                                            @else
                                                                <input type="datetime-local" class="form-control" id="tarikh_serahan_aduan" name="tarikh_serahan_aduan" value="{{ old('tarikh_serahan_aduan') }}">
                                                            @endif
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"> Tahap Aduan :</label></td>
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
                                                            <td colspan="2" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"> Adakah Kerosakan Dicaj ?</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2" style="padding-top: 20px; padding-left: 0px">
                                                                <input class="ml-5" type="radio" name="caj_kerosakan" id="caj_kerosakan" value="Ya" {{ $aduan->caj_kerosakan == "Ya" ? 'checked="checked"' : '' }}> Ya
                                                                <input class="ml-5" type="radio" name="caj_kerosakan" id="caj_kerosakan" value="Tidak" {{ $aduan->caj_kerosakan == "Tidak" ? 'checked="checked"' : '' }}> Tidak
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"> Juruteknik :</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <select class="juruteknik_bertugas form-control" name="juruteknik_bertugas[]" id="juruteknik_bertugas" multiple required>
                                                                <option value="" disabled>Please select</option>
                                                                @foreach ($juruteknik as $juru)
                                                                    <option value="{{ $juru->id }}"
                                                                        @foreach ($juruteknik_bertugas as $juru_bertugas)
                                                                            {{ in_array($juru->id, (array) $juru_bertugas->juruteknik_bertugas) ? 'selected' : '' }}
                                                                        @endforeach
                                                                    >
                                                                    {{ $juru->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('juruteknik_bertugas')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr class="bg-secondary text-white">
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="tarikh_serahan_aduan"> INFO PEMBAIKAN ADUAN </label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="upload_image"> Tarikh Selesai Pembaikan:</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2">
                                                            @if(isset($aduan->tarikh_selesai_aduan))
                                                                <input type="datetime-local" class="form-control" id="tarikh_selesai_aduan" name="tarikh_selesai_aduan" value="{{ date('Y-m-d\TH:i', strtotime($aduan->tarikh_selesai_aduan)) }}" />
                                                            @else
                                                                <input type="datetime-local" class="form-control" id="tarikh_selesai_aduan" name="tarikh_selesai_aduan" value="{{ old('tarikh_selesai_aduan') }}">
                                                            @endif
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="laporan_pembaikan"> Laporan Pembaikan:</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2">
                                                                <textarea rows="5" class="form-control" id="laporan_pembaikan" name="laporan_pembaikan">{{ $aduan->laporan_pembaikan }}</textarea>
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
                                                                <select class="bahan_alat form-control" name="bahan_alat[]" id="bahan_alat" multiple required>
                                                                    <option value="" disabled>Please select</option>
                                                                    @foreach ($alatan as $alat)
                                                                        <option value="{{ $alat->id }}"
                                                                            @foreach ($alatan_ganti as $alat_ganti)
                                                                                {{ in_array($alat->id, (array) $alat_ganti->alat_ganti) ? 'selected' : '' }}
                                                                            @endforeach
                                                                        >
                                                                            {{ $alat->alat_ganti }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('juruteknik_bertugas')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="upload_image"> Gambar Pembaikan:</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2" style="vertical-align: middle">
                                                                <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple><br>
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
                                                            <td colspan="2"><label class="form-label" for="status_aduan">  Status Terkini :</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2">
                                                                <select class="form-control status_aduan" name="status_aduan" id="status_aduan" required>
                                                                    <option value="" disabled selected>Sila Pilih</option>
                                                                    @foreach ($status->whereNotIn('kod_status', ['AB']) as $stats)
                                                                    <option value="{{ $stats->kod_status }}" {{ $aduan->status_aduan == $stats->kod_status ? 'selected="selected"' : '' }}>
                                                                            {{ strtoupper($stats->nama_status) }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('status_aduan')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr class="bg-secondary text-white">
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="tarikh_serahan_aduan"> INFO PENGESAHAN ADUAN - ADMIN</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2">
                                                                <textarea rows="3" class="form-control" maxlength="150" id="catatan_pembaikan" name="catatan_pembaikan">{{ $aduan->catatan_pembaikan }}</textarea>
                                                                <p align="right" class="mt-2">Tidak melebihi 150 huruf</p>
                                                                @error('catatan_pembaikan')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr class="bg-secondary text-white">
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="tarikh_serahan_aduan"> INFO PENGESAHAN ADUAN - PENGADU</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2"><label class="form-label" for="pengesahan_pembaikan">Pengesahan Pembaikan :</label></td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td colspan="2" style="padding-top: 20px; padding-left: 0px">
                                                                <input class="ml-5" type="radio" name="pengesahan_pembaikan" id="pengesahan_pembaikan" value="Y" {{ $aduan->pengesahan_pembaikan == "Y" ? 'checked="checked"' : '' }}> Ya
                                                                <input class="ml-5" type="radio" name="pengesahan_pembaikan" id="pengesahan_pembaikan" value="" {{ $aduan->pengesahan_pembaikan == "" ? 'checked="checked"' : '' }}> Tidak
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn btn-success float-right"><i class="fal fa-save"></i> Simpan</button>
                                    {!! Form::close() !!}
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

        $(document).ready(function() {

            $('.tahap_kategori, .juruteknik_bertugas, .status_aduan, .status_adu, .tukar_status, .jenis_juruteknik, .bahan_alat, .id_stok, .kuantiti').select2();

            sum();
            $("#ak_upah, #ak_bahan_alat").on("keydown keyup", function() {
                sum();
            });

        });

        function sum() {
            var ak_upah = $('#ak_upah').val();
            var ak_bahan_alat = $('#ak_bahan_alat').val();
            var jumlah_kos = parseFloat(ak_upah) + parseFloat(ak_bahan_alat);
            var result = jumlah_kos.toFixed(2);
            $('#jumlah_kos').val(result);
        }

    </script>
@endsection
