@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-list'></i> BORANG ADUAN {{ $aduan->id }}
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
                    
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item" style="margin-right: 2px">
                                <a style="border: solid 1px;  border-radius: 0" data-toggle="tab" class="nav-link" href="#aduan" role="tab"><i class="fal fa-info"></i> ADUAN</a>
                            </li>
                            @if($aduan->status_aduan != 'BS')
                            <li class="nav-item">
                                <a style="border: solid 1px; border-radius: 0" data-toggle="tab" class="nav-link" href="#baiki" role="tab"><i class="fal fa-clone"></i> PENAMBAHBAIKAN</a>
                            </li>
                                @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK' || $aduan->status_aduan == 'DP')
                                    <a data-page="/pdfAduan/{{ $aduan->id }}" class="btn btn-sm btn-danger ml-auto float-right" onclick="Print(this)" style="color: white; padding-top: 8px"><i class="fal fa-download"></i> PDF</a>
                                @endif
                            @endif
                        </ul>

                        <br><br>

                        <div class="row">
                            <div class="col">
                                <div class="tab-content" id="v-pills-tabContent">
      
                                <div class="tab-pane active" id="aduan" role="tabpanel" style="margin-top: -30px"><br>
                                    <div class="row"><br>
                                        <div class="col-md-12 col-sm-12" style="margin-bottom: 20px">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header text-white" style="background-color:#886ab5">
                                                    <span class="fw-300"></span><i class="fal fa-list"></i><b> BUTIRAN ADUAN </b>
                                                </div>
                                                <div class="card-body">
                                                    <div style="float: right"><i><b>Tarikh Aduan : </b>{{ date(' j F Y | h:i:s A', strtotime($aduan->tarikh_laporan) )}}</i></div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> INFO PENGADU</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="20%"><label class="form-label" for="nama_pelapor">Nama :</label></td>
                                                                        <td colspan="2">{{ strtoupper($aduan->nama_pelapor ?? '--')  }}</td>
                                                                        <td width="20%"><label class="form-label" for="emel_pelapor">Emel :</label></td>
                                                                        <td colspan="2">{{ $aduan->emel_pelapor ?? '--'  }}</td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="20%"><label class="form-label" for="no_tel_pelapor">No Telefon :</label></td>
                                                                        <td colspan="2">{{ $aduan->no_tel_pelapor ?? '--'  }}</td>
                                                                        <td width="20%"><label class="form-label" for="no_tel_pelapor">Status Terkini :</label></td>
                                                                        <td colspan="2"><b>{{ strtoupper($aduan->status->nama_status ?? '--')  }}</b></td>
                                                                    </div>
                                                                </tr>
                                                            
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-clipboard-list"></i> ADUAN</label></td>
                                                                </tr>
                    
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="20%"><label class="form-label" for="lokasi_aduan">Lokasi :</label></td>
                                                                        <td colspan="1">
                                                                        {{ strtoupper($aduan->nama_bilik) . ', ARAS ' . strtoupper($aduan->aras_aduan) . ', BLOK ' . strtoupper($aduan->blok_aduan) . ', ' . strtoupper($aduan->lokasi_aduan) ?? '-- TIADA DATA --'  }}
                                                                        </td>
                                                                        <td width="20%"><label class="form-label" for="kategori_aduan">Aduan :</label></td>
                                                                        <td colspan="3">
                                                                            <div> Kategori : <b>{{ strtoupper($aduan->kategori->nama_kategori) }}</b></div><br>
                                                                            <div> Jenis : <b>{{ strtoupper($aduan->jenis->jenis_kerosakan) }}</b></div word-break: break-all>
                                                                            @if($aduan->jenis->jenis_kerosakan == 'Lain-lain') 
                                                                                <div> Penerangan : <b>{{ strtoupper($aduan->jk_penerangan ?? '--') }}</b></div><br>
                                                                            @else 
                                                                                <br>
                                                                            @endif
                                                                            <div> Sebab : <b>{{ strtoupper($aduan->sebab->sebab_kerosakan) }}</b></div word-break: break-all>
                                                                            @if($aduan->sebab->sebab_kerosakan == 'Lain-lain')
                                                                                <div> Penerangan : <b>{{ strtoupper($aduan->sk_penerangan ?? '--') }}</b></div>
                                                                            @endif
                                                                        </td>
                                                                    </div>
                                                                </tr>
                    
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="20%"><label class="form-label" for="maklumat_tambahan">Kuantiti/Unit :</label></td>
                                                                        <td colspan="1">{{ $aduan->kuantiti_unit ?? '--'  }}</td>
                                                                        <td width="20%"><label class="form-label" for="maklumat_tambahan">Caj Kerosakan :</label></td>
                                                                        <td colspan="3">{{ $aduan->caj_kerosakan ?? '--'  }}</td>
                                                                    </div>
                                                                </tr>
                    
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="20%"><label class="form-label" for="maklumat_tambahan">Maklumat Tambahan :</label></td>
                                                                        <td colspan="4">{{ $aduan->maklumat_tambahan ?? '--'  }}</td>
                                                                    </div>
                                                                </tr>
                    
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="20%" style="vertical-align: middle"><label class="form-label" for="maklumat_tambahan">Gambar :</label></td>
                                                                        <td colspan="2">
                                                                            @if(isset($imej->first()->upload_image))
                                                                                @foreach($imej as $imejAduan)
                                                                                    <img src="/get-file-resit/{{ $imejAduan->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                                                @endforeach
                                                                            @else
                                                                                <span>Tiada Gambar Sokongan</span>
                                                                            @endif
                                                                        </td>
                                                                        <td width="20%" style="vertical-align: middle"><label class="form-label" for="maklumat_tambahan">Resit :</label></td>
                                                                        <td colspan="2" style="vertical-align: middle">
                                                                            @if(isset($resit->first()->nama_fail))
                                                                                @foreach ($resit as $failResit)
                                                                                    <a target="_blank" href="{{ url('resit')."/".$failResit->nama_fail }}/Download"">{{ $failResit->nama_fail }}</a>
                                                                                @endforeach
                                                                            @else
                                                                                <span>Tiada Dokumen Sokongan</span>
                                                                            @endif
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    @if($aduan->status_aduan == 'BS') 
                                                        @can('handover')

                                                        {!! Form::open(['action' => 'AduanController@updateJuruteknik', 'method' => 'POST']) !!}
                                                            <input type="hidden" name="id" value="{{ $aduan->id }}">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover table-striped w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-handshake"></i> PENYERAHAN ADUAN</label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="10%" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"><span class="text-danger">*</span> Tahap Aduan :</label></td>
                                                                                <td colspan="4" style="vertical-align: middle">
                                                                                    <select class="form-control tahap_kategori" name="tahap_kategori" id="tahap_kategori" >
                                                                                        <option value="">Pilih Tahap Aduan</option>
                                                                                        @foreach ($tahap as $thp) 
                                                                                        <option value="{{ $thp->kod_tahap }}" {{ old('tahap_kategori') ? 'selected' : '' }}>
                                                                                                {{ $thp->jenis_tahap }}</option>
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
                                                                                <td width="10%" style="vertical-align: middle"><label class="form-label" for="juruteknik_bertugas"><span class="text-danger">*</span> Juruteknik :</label></td>
                                                                                <td colspan="4">
                                                                                    <div class="card-body test" id="test">
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
                                                                                                            <option value="">Pilih Juruteknik</option>
                                                                                                            @foreach ($juruteknik as $juru) 
                                                                                                            <option value="{{ $juru->id }}" {{ old('juruteknik_bertugas') ? 'selected' : '' }}>
                                                                                                                    {{ $juru->name }}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <select class="form-control jenis_juruteknik" name="jenis_juruteknik[]" required>
                                                                                                            <option value="">Pilih Tugas</option>
                                                                                                            <option value="K">Ketua</option>
                                                                                                            <option value="P">Pembantu</option>
                                                                                                        </select>
                                                                                                    </td>
                                                                                                    <td class="text-center"><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <button type="submit" class="btn btn-danger float-right" name="submit" id="submithead"><i class="fal fa-save"></i> Hantar Aduan</button>
                                                        {!! Form::close() !!}
                                                            
                                                        @endcan
                                                    @endif

                                                    @if($aduan->status_aduan == 'DJ') 
                                                        @can('edit handover')
                                                        @if (Session::has('message'))
                                                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                                        @endif
                                                            {!! Form::open(['action' => 'AduanController@updateTahap', 'method' => 'POST']) !!}
                                                                <input type="hidden" name="id_adu" value="{{ $aduan->id }}">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-handshake"></i> KEMASKINI PENYERAHAN ADUAN</label></td>
                                                                            </tr>
                    
                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="10%" style="vertical-align: middle"><label class="form-label" for="tahap_kategori"><span class="text-danger">*</span> Tahap Aduan :</label></td>
                                                                                    <td colspan="4" style="vertical-align: middle">
                                                                                        <select class="form-control tahap_kategori" name="tahap_kategori" id="tahap_kategori">
                                                                                            <option value="">Pilih Tahap Aduan</option>
                                                                                            @foreach ($tahap as $thp) 
                                                                                                <option value="{{ $thp->kod_tahap }}" {{ $aduan->tahap_kategori == $thp->kod_tahap ? 'selected="selected"' : '' }}>{{ $thp->jenis_tahap }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </td>
                                                                                </div>
                                                                            </tr>
                    
                                                                            <tr>
                                                                                <div>
                                                                                    <td width="10%" style="vertical-align: middle"><label class="form-label" for="juruteknik_bertugas"><span class="text-danger">*</span> Juruteknik :</label></td>
                                                                                    <td colspan="4">
                                                                                        <div class="card-body">
                                                                                            <table class="table table-bordered">
                                                                                                <thead>
                                                                                                    <tr class="text-center" style="background-color: #fbfbfb82">
                                                                                                        <td style="width: 5px">ID</td>
                                                                                                        <td>Juruteknik</td>
                                                                                                        <td>Tugas</td>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach ($senarai_juruteknik as $sJ)
                                                                                                    <input type="hidden" name="id" value="{{ $sJ->id }}">
                                                                                                    <tr class="data-row">
                                                                                                        <td style="vertical-align: middle">{{ $sJ->juruteknik_bertugas }}</td>
                                                                                                        <td>
                                                                                                            <select class="form-control juruteknik_bertugas" name="juruteknik_bertugas[]" id="juruteknik_bertugas">
                                                                                                                <option disabled selected>Pilih Juruteknik</option>
                                                                                                                @foreach ($juruteknik as $juru) 
                                                                                                                    <option value="{{ $juru->id }}" {{ $sJ->juruteknik_bertugas == $juru->id ? 'selected="selected"' : '' }}>{{ $juru->name }}</option>
                                                                                                                @endforeach
                                                                                                            </select>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <select class="form-control jenis_juruteknik" name="jenis_juruteknik[]" id="jenis_juruteknik">
                                                                                                                <option disabled selected>Pilih Tugas</option>
                                                                                                                <option value="K" {{ $sJ->jenis_juruteknik == 'K' ? 'selected="selected"' : '' }}>Ketua</option>
                                                                                                                <option value="P" {{ $sJ->jenis_juruteknik == 'P' ? 'selected="selected"' : '' }}>Pembantu</option>
                                                                                                            </select>
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
                                                                <button type="submit" class="btn btn-danger ml-auto float-right"><i class="fal fa-save"></i> Kemaskini Aduan</button>
                                                            {!! Form::close() !!}

                                                        @endcan
                                                    @endif

                                                    @can('view handover')
                                                        @role('Operation Admin')
                                                            @if($aduan->status_aduan == 'TD' || $aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK' || $aduan->status_aduan == 'AK' || $aduan->status_aduan == 'DP') 
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover table-striped w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-handshake"></i> MAKLUMAT PENYERAHAN ADUAN</label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%" style="vertical-align: middle"><label class="form-label">Tahap Aduan :</label></td>
                                                                                <td colspan="2" style="vertical-align: middle; width: 150px">{{ $aduan->tahap->jenis_tahap}}</td>
                                                                                <td width="15%" style="vertical-align: middle"><label class="form-label">Juruteknik Bertugas :</label></td>
                                                                                <td colspan="2">
                                                                                    <ol style="margin-bottom: 0rem">
                                                                                        @foreach($senarai_juruteknik as $senarai)
                                                                                        <li style="line-height: 30px"> {{ $senarai->juruteknik->name}} 
                                                                                            ( @if ($senarai->jenis_juruteknik == 'K') KETUA @endif
                                                                                                @if ($senarai->jenis_juruteknik == 'P') PEMBANTU @endif )
                                                                                        </li>
                                                                                        @endforeach
                                                                                    </ol>
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            @endif  
                                                        @endrole
                                                        @role('Technical Staff')
                                                        <div class="table-responsive">
                                                        <table class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-handshake"></i> MAKLUMAT PENYERAHAN ADUAN</label></td>
                                                                </tr>
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td width="15%" style="vertical-align: middle"><label class="form-label">Tahap Aduan :</label></td>
                                                                        <td colspan="2" style="vertical-align: middle; width: 150px">{{ $aduan->tahap->jenis_tahap ?? '--'}}</td>
                                                                        <td width="15%" style="vertical-align: middle"><label class="form-label">Juruteknik Bertugas :</label></td>
                                                                        <td colspan="2">
                                                                            <ol style="margin-bottom: 0rem">
                                                                                @foreach($senarai_juruteknik as $senarai)
                                                                                <li style="line-height: 30px"> {{ $senarai->juruteknik->name ?? '--'}} 
                                                                                    ( @if ($senarai->jenis_juruteknik == 'K') KETUA @endif
                                                                                        @if ($senarai->jenis_juruteknik == 'P') PEMBANTU @endif )
                                                                                </li>
                                                                                @endforeach
                                                                            </ol>
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        </div>
                                                        @endrole
                                                    @endcan
                                                    <br>
                                                    <a style="margin-right:5px; margin-top:-18px" href="{{ url()->previous() }}" class="btn btn-success float-right"><i class="fal fa-angle-double-left"></i> Kembali</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($aduan->status_aduan != 'BS')
                                    <div class="tab-pane" id="baiki" role="tabpanel" style="margin-top: -30px"><br>
                                        <div class="row"><br>
                                            <div class="col-md-12 col-sm-12" style="margin-bottom: 20px">
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header text-white" style="background-color:#886ab5">
                                                        <span class="fw-300"></span><i class="fal fa-check-square"></i><b> BUTIRAN PENAMBAHBAIKAN </b>
                                                    </div>
                                                    <div class="card-body">
                                                        @can('repair')
                                                            @if($aduan->status_aduan == 'DJ' && $juru->jenis_juruteknik == 'K') 
                                                                @if (Session::has('simpanPembaikan'))
                                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('simpanPembaikan') }}</div>
                                                                @endif
                                                                {!! Form::open(['action' => 'AduanController@simpanPenambahbaikan', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                {{Form::hidden('id', $aduan->id)}}
                                                                <div class="table-responsive">
                                                                    <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-box"></i> PENAMBAHBAIKAN</label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                                                                    <td colspan="2"><b>{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                                                    <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Serahan Aduan :</label></td>
                                                                                    <td colspan="2"><b>{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="laporan_pembaikan"><span class="text-danger">*</span> Laporan Pembaikan :</label></td>
                                                                                    <td colspan="2">
                                                                                        <textarea rows="10" class="form-control" id="laporan_pembaikan" name="laporan_pembaikan">{{ old('laporan_pembaikan') }}</textarea>
                                                                                            @error('laporan_pembaikan')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror
                                                                                    </td>
                                                                                    <td width="20%"><label class="form-label" for="bahan_alat"> Bahan/ Alat Ganti :</label></td>
                                                                                    <td colspan="2">
                                                                                        <select class="form-control bahan_alat" name="bahan_alat[]" multiple>
                                                                                        <option value="">Bahan/ Alat Ganti</option>
                                                                                            @foreach ($alatan as $alat)
                                                                                                <option value="{{ $alat->id }}">{{ $alat->alat_ganti }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('bahan_alat')
                                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                        @enderror
                                                                                    </td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td class="card-header" width="20%" style="border-right-style: hidden; background-color: #fbfbfb82"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                                                    <td class="card-header" colspan="2" style="background-color: #fbfbfb82"><b></b></td>
                                                                                    <td width="20%"><label class="form-label" for="tarikh_selesai_aduan"><span class="text-danger">*</span> Tarikh Selesai Pembaikan :</label></td>
                                                                                    <td colspan="2">
                                                                                        <input type="datetime-local" class="form-control" id="tarikh_selesai_aduan" name="tarikh_selesai_aduan" value="{{ old('tarikh_selesai_aduan') }}">
                                                                                            @error('tarikh_selesai_aduan')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror
                                                                                    </td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="ak_upah">Upah :</label><label class="form-label" style="padding-left: 205px;" for="ak_upah">RM</label><br><br><br><br>
                                                                                        <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label><label class="form-label" style="padding-left: 130px;" for="ak_bahan_alat">RM</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        <input type="number" step="any" class="form-control" id="ak_upah" name="ak_upah"  value="{{ old('ak_upah') }}">
                                                                                            @error('ak_upah')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror<br><br>
                                                                                        <input type="number" step="any" class="form-control" id="ak_bahan_alat" name="ak_bahan_alat" value="{{ old('ak_bahan_alat') }}">
                                                                                            @error('ak_bahan_alat')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror<br>
                                                                                    </td>
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="status_aduan"><span class="text-danger">*</span> Status Aduan :</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        <select class="form-control status_aduan" name="status_aduan" id="status_aduan" >
                                                                                            <option value="">Pilih Status Aduan</option>
                                                                                            @foreach ($status as $stat) 
                                                                                            <option value="{{ $stat->kod_status }}" {{ old('status_aduan') ? 'selected' : '' }}>
                                                                                                    {{ $stat->nama_status }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        @error('status_aduan')
                                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                        @enderror
                                                                                    </td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                                        <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label><label class="form-label" style="padding-left: 132px;" for="jumlah_kos">RM</label>
                                                                                    </td>
                                                                                    <td colspan="2" style="background-color: #ddd; cursor: not-allowed;">
                                                                                        <input type="number" step="any" class="form-control" id="jumlah_kos" style="cursor:context-menu;" name="jumlah_kos" value="{{ old('jumlah_kos') }}" readonly>
                                                                                            @error('jumlah_kos')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror
                                                                                    </td>

                                                                                    <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                                                    <td colspan="2" style="border-top-style: hidden;"></td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                                                <td colspan="4">
                                                                                    <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple>
                                                                                    @error('upload_image')
                                                                                        <p style="color: red">{{ $message }}</p>
                                                                                    @enderror
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                    <button type="submit" class="btn btn-danger float-right"><i class="fal fa-save"></i> Hantar Tindakan</button>
                                                                {!! Form::close() !!}
                                                            @endif
                                                        @endcan
                                                    
                                                        @can('update repair')
                                                            @if($juru->jenis_juruteknik == 'K') 
                                                                @if($aduan->status_aduan == 'TD' || $aduan->status_aduan == 'AK' )
                                                                    @if (Session::has('kemaskiniPembaikan'))
                                                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('kemaskiniPembaikan') }}</div>
                                                                    @endif
                                                                    {!! Form::open(['action' => 'AduanController@kemaskiniPenambahbaikan', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                    {{Form::hidden('id', $aduan->id)}}
                                                                    <div class="table-responsive">
                                                                        <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                            <thead>
                                                                                <tr>
                                                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-box"></i> KEMASKINI PENAMBAHBAIKAN</label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <div class="form-group">
                                                                                        <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                                                                        <td colspan="2"><b>{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                                                        <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Serahan Aduan :</label></td>
                                                                                        <td colspan="2"><b>{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                                                    </div>
                                                                                </tr>

                                                                                <tr>
                                                                                    <div class="form-group">
                                                                                        <td width="20%"><label class="form-label" for="laporan_pembaikan"><span class="text-danger">*</span> Laporan Pembaikan :</label></td>
                                                                                        <td colspan="4">
                                                                                            <textarea rows="5" class="form-control" id="laporan_pembaikan" name="laporan_pembaikan">{{ $aduan->laporan_pembaikan }}</textarea>
                                                                                                @error('laporan_pembaikan')
                                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                                @enderror
                                                                                        </td>
                                                                                    </div>
                                                                                </tr>

                                                                                <tr>
                                                                                    <div class="form-group">
                                                                                        <td width="20%"><label class="form-label" for="bahan_alat"> Bahan/ Alat Ganti :</label></td>
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
                                                                                        </td>
                                                                                        <td colspan="2">
                                                                                            <div class="card-body">
                                                                                                @if(session()->has('message'))
                                                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                                                                                        {{ session()->get('message') }}
                                                                                                    </div>
                                                                                                @endif
                                                                                                @if(session()->has('notification'))
                                                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i>
                                                                                                        {{ session()->get('notification') }}
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
                                                                                                                <a href="{{ action('AduanController@padamAlatan', ['id' => $aG->id, 'id_aduan' => $aG->id_aduan]) }}" class="btn btn-danger btn-sm deleteEl"><i class="fal fa-trash"></i></a>
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
                                                                                        <td class="card-header" width="20%" style="border-right-style: hidden; background-color: #fbfbfb82"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                                                        <td class="card-header" style="background-color: #fbfbfb82" colspan="2"><b></b></td>
                                                                                        <td width="20%"><label class="form-label" for="tarikh_selesai_aduan"><span class="text-danger">*</span> Tarikh Selesai Pembaikan :</label></td>
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
                                                                                        <td width="20%">
                                                                                            <label class="form-label" for="ak_upah">Upah :</label><label class="form-label" style="padding-left: 205px;" for="ak_upah">RM</label><br><br><br><br>
                                                                                            <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label><label class="form-label" style="padding-left: 130px;" for="ak_bahan_alat">RM</label>
                                                                                        </td>
                                                                                        <td colspan="2">
                                                                                            <input type="number" step="any" class="form-control" id="ak_upah" name="ak_upah"  value="{{ $aduan->ak_upah }}">
                                                                                                @error('ak_upah')
                                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                                @enderror<br><br>
                                                                                            <input type="number" step="any" class="form-control" id="ak_bahan_alat" name="ak_bahan_alat" value="{{ $aduan->ak_bahan_alat }}">
                                                                                                @error('ak_bahan_alat')
                                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                                @enderror<br>
                                                                                        </td>
                                                                                        {{-- @if($aduan->status_aduan == 'AS')  --}}
                                                                                            {{-- <td width="20%"><label class="form-label" for="status_aduan">Status Aduan :</label></td>
                                                                                            <td colspan="4"><b>{{ $aduan->status->nama_status }}</b></td> --}}
                                                                                        {{-- @else --}}
                                                                                        <td width="20%"><label class="form-label" for="status_aduan"><span class="text-danger">*</span> Status Aduan :</label></td>
                                                                                        <td colspan="2"> 
                                                                                            <select class="form-control status_aduan" name="status_aduan" id="status_aduan" >
                                                                                            <option value="">-- Pilih Status Aduan --</option>
                                                                                                @foreach($status as $stt)
                                                                                                    <option value="{{$stt->kod_status}}"  {{ $aduan->status_aduan == $stt->kod_status ? 'selected="selected"' : '' }}>{{$stt->nama_status}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            @error('status_aduan')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror
                                                                                        </td>
                                                                                        {{-- @endif --}}
                                                                                    </div>
                                                                                </tr>

                                                                                <tr>
                                                                                    <div class="form-group">
                                                                                        <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                                            <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label><label class="form-label" style="padding-left: 142px;" for="jumlah_kos">RM</label>
                                                                                        </td>
                                                                                        <td colspan="2" style="background-color: #ddd; cursor: not-allowed;">
                                                                                            <input type="number" step="any" class="form-control" id="jumlah_kos" style="cursor:context-menu;" name="jumlah_kos" value="{{ $aduan->jumlah_kos }}" readonly>
                                                                                                @error('jumlah_kos')
                                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                                @enderror
                                                                                        </td>

                                                                                        <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                                                        <td colspan="2" style="border-top-style: hidden;"></td>
                                                                                    </div>
                                                                                </tr>

                                                                                <tr>
                                                                                    <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                                                        @if(isset($gambar->first()->upload_image))
                                                                                            <td colspan="2">
                                                                                                @foreach($gambar as $imejPembaikan)
                                                                                                    <img src="/get-file-gambar/{{ $imejPembaikan->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                                                                @endforeach
                                                                                            </td>
                                                                                            <td colspan="2" style="vertical-align: middle">
                                                                                                <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple>
                                                                                            </td>
                                                                                        @else
                                                                                            <td colspan="2" style="vertical-align: middle">
                                                                                                <span>Tiada Gambar Sokongan</span>
                                                                                            </td>
                                                                                            <td colspan="2">
                                                                                                <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple>
                                                                                            </td>
                                                                                        @endif
                                                                                </tr> 
                                                                            </thead>
                                                                        </table>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-danger float-right"><i class="fal fa-save"></i> Kemaskini Tindakan</button>
                                                                    {!! Form::close() !!}
                                                                @endif
                                                            @endif
                                                        @endcan

                                                        @can('view repair')
                                                            {{-- pembantu --}}
                                                            @if($juru->jenis_juruteknik != 'K') 
                                                                @if($aduan->status_aduan != 'BS')
                                                                <div class="table-responsive">
                                                                    <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-info"></i> INFO PENAMBAHBAIKAN</label></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                                                                    <td colspan="2">{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                                                                                    <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Serahan Aduan :</label></td>
                                                                                    <td colspan="2">{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan :</label></td>
                                                                                    <td colspan="2">{{ $aduan->laporan_pembaikan ?? '--'   }}</td>
                                                                                    <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                                                                                    <td colspan="2">
                                                                                        @if(isset($alatan_ganti->alat_ganti))
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
                                                                                    <td class="card-header" style="background-color: #fbfbfb82" colspan="2"><b></b></td>
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan :</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        @if(isset($aduan->tarikh_selesai_aduan))
                                                                                            {{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}
                                                                                        @else
                                                                                            --
                                                                                        @endif
                                                                                        
                                                                                    </td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="ak_upah">Upah :</label><br><br>
                                                                                        <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        RM {{ $aduan->ak_upah ?? '--'   }}<br><br>
                                                                                        RM {{ $aduan->ak_bahan_alat ?? '--'   }}
                                                                                    </td>
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="status_aduan">Status Aduan :</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        <b>{{ strtoupper($aduan->status->nama_status) }}</b>
                                                                                    </td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                                        <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label>
                                                                                    </td>
                                                                                    <td colspan="2" style="background-color: #ddd; cursor: not-allowed;">
                                                                                        RM {{ $aduan->jumlah_kos ?? '--'   }}
                                                                                    </td>

                                                                                    <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                                                    <td colspan="2" style="border-top-style: hidden;"></td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                                                <td colspan="4">
                                                                                    @if(isset($gambar->first()->upload_image))
                                                                                        @foreach($gambar as $imejPembaikan)
                                                                                            <img src="/get-file-gambar/{{ $imejPembaikan->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                                                        @endforeach
                                                                                    @else
                                                                                        <span>Tiada Gambar Sokongan</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr> 
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                @endif
                                                            @endif
                                                            {{-- ketua --}}
                                                            @if($juru->jenis_juruteknik == 'K') 
                                                                @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK' || $aduan->status_aduan == 'DP')
                                                                <div class="table-responsive">
                                                                    <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-info"></i> INFO PENAMBAHBAIKAN</label></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                                                                    <td colspan="2">{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                                                                                    <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Serahan Aduan :</label></td>
                                                                                    <td colspan="2">{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan :</label></td>
                                                                                    <td colspan="2">{{ $aduan->laporan_pembaikan ?? '--'   }}</td>
                                                                                    <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                                                                                    <td colspan="2">
                                                                                        <ol>
                                                                                            @foreach($alatan_ganti as $al)
                                                                                                <li>{{ $al->alat->alat_ganti}}</li>
                                                                                            @endforeach
                                                                                        </ol>
                                                                                    </b>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td class="card-header" width="20%" style="border-right-style: hidden; background-color: #fbfbfb82"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                                                    <td class="card-header" style="background-color: #fbfbfb82" colspan="2"><b></b></td>
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan :</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        @if(isset($aduan->tarikh_selesai_aduan))
                                                                                            {{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}
                                                                                        @else
                                                                                            --
                                                                                        @endif
                                                                                        
                                                                                    </td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="ak_upah">Upah :</label><br><br>
                                                                                        <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        RM {{ $aduan->ak_upah ?? '--'   }}<br><br>
                                                                                        RM {{ $aduan->ak_bahan_alat ?? '--'   }}
                                                                                    </td>
                                                                                    <td width="20%">
                                                                                        <label class="form-label" for="status_aduan">Status Aduan :</label>
                                                                                    </td>
                                                                                    <td colspan="2">
                                                                                        <b>{{ strtoupper($aduan->status->nama_status) }}</b>
                                                                                    </td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <div class="form-group">
                                                                                    <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                                        <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label>
                                                                                    </td>
                                                                                    <td colspan="2" style="background-color: #ddd; cursor: not-allowed;">
                                                                                        RM {{ $aduan->jumlah_kos ?? '--'   }}
                                                                                    </td>

                                                                                    <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                                                    <td colspan="2" style="border-top-style: hidden;"></td>
                                                                                </div>
                                                                            </tr>

                                                                            <tr>
                                                                                <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                                                <td colspan="4">
                                                                                    @if(isset($gambar->first()->upload_image))
                                                                                        @foreach($gambar as $imejPembaikan)
                                                                                            <img src="/get-file-gambar/{{ $imejPembaikan->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                                                        @endforeach
                                                                                    @else
                                                                                        <span>Tiada Gambar Sokongan</span>
                                                                                    @endif
                                                                                </td>
                                                                            </tr> 
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                @endif
                                                            @endif
                                                        @endcan

                                                        @can('show repair')
                                                            @if($aduan->status_aduan != 'BS' || $aduan->status_aduan != 'DJ') 
                                                            <div class="table-responsive">
                                                                <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-info"></i> INFO PENAMBAHBAIKAN</label></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                                                                <td colspan="2">{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Serahan Aduan :</label></td>
                                                                                <td colspan="2">{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                                                                            </div>
                                                                        </tr>

                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan :</label></td>
                                                                                <td colspan="2">{{ $aduan->laporan_pembaikan ?? '--'   }}</td>
                                                                                <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                                                                                <td colspan="2">
                                                                                    @if(isset($alatan_ganti->alat_ganti))
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
                                                                                <td class="card-header" style="background-color: #fbfbfb82" colspan="2"><b></b></td>
                                                                                <td width="20%">
                                                                                    <label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan :</label>
                                                                                </td>
                                                                                <td colspan="2">
                                                                                    @if(isset($aduan->tarikh_selesai_aduan))
                                                                                        {{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}
                                                                                    @else
                                                                                        --
                                                                                    @endif
                                                                                    
                                                                                </td>
                                                                            </div>
                                                                        </tr>

                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="20%">
                                                                                    <label class="form-label" for="ak_upah">Upah :</label><br><br>
                                                                                    <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label>
                                                                                </td>
                                                                                <td colspan="2">
                                                                                    RM {{ $aduan->ak_upah ?? '--'   }}<br><br>
                                                                                    RM {{ $aduan->ak_bahan_alat ?? '--'   }}
                                                                                </td>
                                                                                <td width="20%">
                                                                                    <label class="form-label" for="status_aduan">Status Aduan :</label>
                                                                                </td>
                                                                                <td colspan="2">
                                                                                    <b>{{ strtoupper($aduan->status->nama_status) }}</b>
                                                                                </td>
                                                                            </div>
                                                                        </tr>

                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                                    <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label>
                                                                                </td>
                                                                                <td colspan="2" style="background-color: #ddd; cursor: not-allowed;">
                                                                                    RM {{ $aduan->jumlah_kos ?? '--'   }}
                                                                                </td>

                                                                                <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                                                <td colspan="2" style="border-top-style: hidden;"></td>
                                                                            </div>
                                                                        </tr>

                                                                        <tr>
                                                                            <th width="20%" style="vertical-align: middle"> Gambar : </th>
                                                                            <td colspan="4">
                                                                                @if(isset($gambar->first()->upload_image))
                                                                                    @foreach($gambar as $imejPembaikan)
                                                                                        <img src="/get-file-gambar/{{ $imejPembaikan->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                                                    @endforeach
                                                                                @else
                                                                                    <span>Tiada Gambar Sokongan</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr> 
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            @endif
                                                        @endcan
                                                            
                                                        @can('edit confirm')
                                                            @if($aduan->status_aduan == 'AS' | $aduan->status_aduan == 'LK' && $aduan->pengesahan_pembaikan != 'Y') 
                                                                @if (Session::has('simpanCatatan'))
                                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('simpanCatatan') }}</div>
                                                                @endif
                                                                {!! Form::open(['action' => 'AduanController@simpanStatus', 'method' => 'POST']) !!}
                                                                {{Form::hidden('id', $aduan->id)}}
                                                                <div class="table-responsive">
                                                                    <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-clipboard-check"></i> KEMASKINI PENGESAHAN PENAMBAHBAIKAN</label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <div class="form-group">
                                                                                        <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                                        <td colspan="2"><textarea rows="8" class="form-control" id="catatan_pembaikan" name="catatan_pembaikan" >{{ $aduan->catatan_pembaikan }}</textarea></td>
                                                                                        <td width="20%"><label class="form-label" for="status_aduan">Tukar Status :</label></td>
                                                                                        <td colspan="2">
                                                                                            <select class="form-control tukar_status" name="status_aduan" id="status_aduan" >
                                                                                                <option value="">-- Pilih Status Aduan --</option>
                                                                                                @foreach($tukarStatus as $stats)
                                                                                                    <option value="{{$stats->kod_status}}"  {{ $aduan->status_aduan == $stats->kod_status ? 'selected="selected"' : '' }}>{{$stats->nama_status}}</option><br>
                                                                                                @endforeach
                                                                                            </select><br></td>
                                                                                            @error('status_aduan')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror
                                                                                </div>
                                                                            </tr>

                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                    <button type="submit" class="btn btn-danger float-right"><i class="fal fa-save"></i> Kemaskini Pengesahan</button>
                                                                {!! Form::close() !!}
                                                            @endif
                                                        @endcan   

                                                        @can('confirm')
                                                            @if($aduan->status_aduan == 'TD') 
                                                                @if (Session::has('simpanCatatan'))
                                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('simpanCatatan') }}</div>
                                                                @endif
                                                                {!! Form::open(['action' => 'AduanController@simpanStatus', 'method' => 'POST']) !!}
                                                                {{Form::hidden('id', $aduan->id)}}
                                                                <div class="table-responsive">
                                                                    <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-clipboard-check"></i> PENGESAHAN PENAMBAHBAIKAN</label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <div class="form-group">
                                                                                        <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                                        <td colspan="2">
                                                                                            <textarea rows="8" class="form-control" id="catatan_pembaikan" name="catatan_pembaikan">{{ old('catatan_pembaikan') }}</textarea>
                                                                                                @error('catatan_pembaikan')
                                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                                @enderror
                                                                                        </td>
                                                                                        <td width="20%"><label class="form-label" for="status_aduan">Tukar Status :</label></td>
                                                                                        <td colspan="2">
                                                                                            <select class="form-control status" name="status_aduan" id="status_aduan" >
                                                                                                <option value="">-- Pilih Status Aduan --</option>
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
                                                                    <button type="submit" class="btn btn-danger float-right"><i class="fal fa-save"></i> Hantar Pengesahan</button>
                                                                {!! Form::close() !!}     
                                                            @endif
                                                        @endcan
                                                    
                                                        @role('Operation Admin')
                                                            @if($aduan->status_aduan == 'AS' | $aduan->status_aduan == 'LK' && $aduan->pengesahan_pembaikan == 'Y') 
                                                            <div class="table-responsive">
                                                                <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-clipboard-check"></i> CATATAN</label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                                <td colspan="4"><b>{{ $aduan->catatan_pembaikan ?? '--'   }}</b></td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            @endif
                                                        @endrole
                                                        @role('Technical Staff')
                                                            @if($aduan->status_aduan == 'AS' || $aduan->status_aduan == 'LK') 
                                                            <div class="table-responsive">
                                                                <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-clipboard-check"></i> CATATAN</label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                                <td colspan="4"><b>{{ $aduan->catatan_pembaikan ?? '--'   }}</b></td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            @endif
                                                        @endrole

                                                        @if($aduan->pengesahan_pembaikan == 'Y')
                                                        <div class="table-responsive">
                                                            <table id="pengesahan" class="table table-bordered table-hover table-striped w-100">
                                                                <thead>
                                                                    <tr>
                                                                        <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-clipboard-check"></i> PENGESAHAN PELAPOR</label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td colspan="5"><b>TELAH DISAHKAN</b></td>
                                                                        </div>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                        @endif

                                                        <a style="margin-right:5px" href="{{ url()->previous() }}" class="btn btn-success float-right"><i class="fal fa-angle-double-left"></i> Kembali</a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                    
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
            $('.tahap_kategori, .juruteknik_bertugas, .status_aduan, .status, .tukar_status, .jenis_juruteknik, .bahan_alat').select2();

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
                        <option value="">Pilih Juruteknik</option>
                        @foreach ($juruteknik as $juru) 
                        <option value="{{ $juru->id }}" {{ old('juruteknik_bertugas') ? 'selected' : '' }}>
                                {{ $juru->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control jenis_juruteknik" name="jenis_juruteknik[]" required>
                        <option disabled selected>Pilih Tugas</option>
                        <option value="K">Ketua</option>
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

    </script>
@endsection