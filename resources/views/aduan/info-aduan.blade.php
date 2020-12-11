@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
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
                    @if (Session::has('message'))
                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                    @endif
                    <div class="row">
                        <div class="col-sm-4">

                            <div class="card card-primary card-outline">
                                <div class="card-header bg-primary-50">
                                    <span class="fw-300"></span><i class="fal fa-user"></i><b> INFO PENGADU </b>
                                </div>

                                <div class="card-body">

                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <td width="30%"><label class="form-label" for="nama_pelapor">Nama Pelapor :</label></td>
                                                    <td colspan="4"><b>{{ $aduan->nama_pelapor ?? '-- TIADA DATA --'  }}</b></td>
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="form-group">
                                                    <td width="30%"><label class="form-label" for="jawatan_pelapor">Jawatan :</label></td>
                                                    <td colspan="4"><b>{{ $aduan->jawatan->nama_jawatan ?? '-- TIADA DATA --'  }}</b></td>
                                                </div>
                                            </tr>
                
                                            <tr>
                                                <div class="form-group">
                                                    <td width="30%"><label class="form-label" for="no_tel_pelapor">No Telefon :</label></td>
                                                    <td colspan="4"><b>{{ $aduan->no_tel_pelapor ?? '-- TIADA DATA --'  }}</b></td>
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="form-group">
                                                    <td width="30%"><label class="form-label" for="no_tel_bimbit_pelapor">No Telefon Bimbit :</label></td>
                                                    <td colspan="4"><b>{{ $aduan->no_tel_bimbit_pelapor ?? '-- TIADA DATA --'  }}</b></td>
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="form-group">
                                                    <td width="30%"><label class="form-label" for="no_bilik_pelapor">No Bilik :</label></td>
                                                    <td colspan="4"><b>{{ $aduan->no_bilik_pelapor ?? '-- TIADA DATA --'  }}</b></td>
                                                </div>
                                            </tr>
                                        
                                        </thead>
                                    </table>

                                </div>
                            </div>

                        </div>

                        <br>

                        <div class="col-sm-8">
                            <div class="card card-primary card-outline">
                                <div class="card-header bg-primary-50">
                                    <span class="fw-300"></span><i class="fal fa-list"></i><b> BUTIRAN ADUAN </b>
                                </div>

                                <div class="card-body">

                                    {!! Form::open(['action' => 'AduanController@updateJuruteknik', 'method' => 'POST']) !!}
                                    {{Form::hidden('id', $aduan->id)}}
                                    
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <td width="20%"><label class="form-label" for="lokasi_aduan">Lokasi :</label></td>
                                                    <td colspan="4"><b>{{ strtoupper($aduan->nama_bilik) . ', ARAS ' . strtoupper($aduan->aras_aduan) . ', BLOK ' . strtoupper($aduan->blok_aduan) . ', ' . strtoupper($aduan->lokasi_aduan) ?? '-- TIADA DATA --'  }}</b></td>
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="form-group">
                                                    <td width="20%"><label class="form-label" for="kategori_aduan">Kategori Aduan :</label></td>
                                                    <td colspan="4"><b>{{ $aduan->kategori->nama_kategori ?? '-- TIADA DATA --'  }}</b></td>
                                                </div>
                                            </tr>
                                            
                                            <tr>
                                                <div class="form-group">
                                                    @if($aduan->jenis->jenis_kerosakan == 'Lain-lain') 
                                                        <td width="20%"><label class="form-label" for="jenis_kerosakan">Jenis Kerosakan :</label></td>
                                                        <td colspan="2"><b>{{ $aduan->jenis->jenis_kerosakan ?? '-- TIADA DATA --'  }}</b></td>
                                                        <td width="20%"><label class="form-label" for="jk_penerangan">Penerangan :</label></td>
                                                        <td colspan="2"><b>{{ $aduan->jk_penerangan ?? '-- TIADA DATA --'  }}</b></td>
                                                    @else
                                                        <td width="20%"><label class="form-label" for="jenis_kerosakan">Jenis Kerosakan :</label></td>
                                                        <td colspan="4"><b>{{ $aduan->jenis->jenis_kerosakan ?? '-- TIADA DATA --'  }}</b></td>
                                                    @endif
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="form-group">
                                                    @if($aduan->sebab->sebab_kerosakan == 'Lain-lain')
                                                        <td width="20%"><label class="form-label" for="sebab_kerosakan">Sebab Kerosakan :</label></td>
                                                        <td colspan="2"><b>{{ $aduan->sebab->sebab_kerosakan ?? '-- TIADA DATA --'  }}</b></td>
                                                        <td width="20%"><label class="form-label" for="sk_penerangan">Penerangan :</label></td>
                                                        <td colspan="2"><b>{{ $aduan->sk_penerangan ?? '-- TIADA DATA --'  }}</b></td>
                                                    @else
                                                        <td width="20%"><label class="form-label" for="sebab_kerosakan">Sebab Kerosakan :</label></td>
                                                        <td colspan="4"><b>{{ $aduan->sebab->sebab_kerosakan ?? '-- TIADA DATA --'  }}</b></td>
                                                    @endif
                                                </div>
                                            </tr>

                                        @if($aduan->status_aduan == 'BS') 

                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%"><label class="form-label" for="tahap_kategori"><span class="text-danger">*</span> Tahap Aduan :</label></td>
                                                            <td colspan="2">
                                                                <select class="form-control tahap_kategori" name="tahap_kategori" id="tahap_kategori" >
                                                                    <option value="">-- Pilih Tahap Aduan --</option>
                                                                    @foreach ($tahap as $thp) 
                                                                    <option value="{{ $thp->jenis_tahap }}" {{ old('tahap_kategori') ? 'selected' : '' }}>
                                                                            {{ $thp->jenis_tahap }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('tahap_kategori')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                            <td width="20%"><label class="form-label" for="juruteknik_bertugas"><span class="text-danger">*</span> Juruteknik :</label></td>
                                                            <td colspan="2">
                                                                <select class="form-control juruteknik_bertugas" name="juruteknik_bertugas" id="juruteknik_bertugas" >
                                                                    <option value="">-- Pilih Juruteknik Bertugas --</option>
                                                                    @foreach ($juruteknik as $juru) 
                                                                    <option value="{{ $juru->id }}" {{ old('juruteknik_bertugas') ? 'selected' : '' }}>
                                                                            {{ $juru->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('juruteknik_bertugas')
                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                @enderror
                                                            </td>
                                                        </div>
                                                    </tr>

                                                </thead>
                                            </table>

                                            <button type="submit" class="btn btn-primary float-right"><i class="fal fa-save"> Hantar Aduan</i></button>
                                    
                                        @else

                                        @can('edit tahap')
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%"><label class="form-label" for="tahap_kategori"><span class="text-danger">*</span> Tahap Aduan :</label></td>
                                                        <td colspan="2">
                                                            <select class="form-control tahap_kategori" name="tahap_kategori" id="tahap_kategori" >
                                                                <option value="">-- Pilih Tahap Aduan --</option>
                                                                @foreach ($tahap as $thp) 
                                                                    <option value="{{ $thp->jenis_tahap }}" {{ $aduan->tahap_kategori == $thp->jenis_tahap ? 'selected="selected"' : '' }}>{{ $thp->jenis_tahap }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('tahap_kategori')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                        <td width="20%"><label class="form-label" for="juruteknik_bertugas"><span class="text-danger">*</span> Juruteknik :</label></td>
                                                        <td colspan="2">
                                                            <select class="form-control juruteknik_bertugas" name="juruteknik_bertugas" id="juruteknik_bertugas" >
                                                                <option value="">-- Pilih Juruteknik Bertugas --</option>
                                                                @foreach ($juruteknik as $juru) 
                                                                <option value="{{ $juru->id }}" {{ $aduan->juruteknik_bertugas == $juru->id ? 'selected="selected"' : '' }}>{{ $juru->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('juruteknik_bertugas')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                    </div>
                                                </tr>

                                                </thead>
                                            </table>

                                            <button type="submit" class="btn btn-primary float-right"><i class="fal fa-save"> Kemaskini Aduan</i></button>

                                            @endcan

                                            @can('papar tahap')
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%"><label class="form-label" for="tahap_kategori">Tahap Aduan :</label></td>
                                                        <td colspan="2"><b>{{ $aduan->tahap_kategori ?? '-- TIADA DATA --'  }}</b></td>
                                                        <td width="20%"><label class="form-label" for="juruteknik_bertugas">Juruteknik :</label></td>
                                                        <td colspan="2"><b>{{ $aduan->juruteknik->name ?? '-- TIADA DATA --'  }}</b></td>
                                                    </div>
                                                </tr>
                                            @endcan

                                                </thead>
                                            </table>

                                        @endif  

                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>

                    <br><br>

                    @if($aduan->status_aduan == 'DJ') 
                        @can('tambah pembaikan')
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-header bg-primary-50">
                                        <span class="fw-300"></span><i class="fal fa-edit"></i><b> BUTIRAN TINDAKAN KEATAS ADUAN </b>
                                    </div>

                                    <div class="card-body">
                                            {!! Form::open(['action' => 'AduanController@simpanPenambahbaikan', 'method' => 'POST']) !!}
                                            {{Form::hidden('id', $aduan->id)}}
                                            
                                            <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Penerimaan Aduan :</label></td>
                                                            <td colspan="4"><b>{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                            <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Penerimaan Aduan :</label></td>
                                                            <td colspan="4"><b>{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                        </div>
                                                    </tr>

                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="20%"><label class="form-label" for="laporan_pembaikan"><span class="text-danger">*</span> Laporan Pembaikan :</label></td>
                                                            <td colspan="4">
                                                                <textarea rows="10" class="form-control" id="laporan_pembaikan" name="laporan_pembaikan">{{ old('laporan_pembaikan') }}</textarea>
                                                                    @error('laporan_pembaikan')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                            <td width="20%"><label class="form-label" for="bahan_alat"><span class="text-danger">*</span> Bahan/ Alat Ganti :</label></td>
                                                            <td colspan="4">
                                                                <textarea rows="10" class="form-control" id="bahan_alat" name="bahan_alat">{{ old('bahan_alat') }}</textarea>
                                                                    @error('bahan_alat')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                        </div>
                                                    </tr>

                                                    <tr>
                                                        <div class="form-group">
                                                            <td class="card-header bg-primary-50" width="20%" style="border-right-style: hidden;"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                            <td class="card-header bg-primary-50" colspan="4"><b></b></td>
                                                            <td width="20%"><label class="form-label" for="tarikh_selesai_aduan"><span class="text-danger">*</span> Tarikh Selesai Pembaikan :</label></td>
                                                            <td colspan="4">
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
                                                                <label class="form-label" for="ak_upah"><span class="text-danger">*</span> Upah :</label><label class="form-label" style="padding-left: 205px;" for="ak_upah">RM</label><br><br><br><br>
                                                                <label class="form-label" for="ak_bahan_alat"><span class="text-danger">*</span> Bahan/ Alat Ganti :</label><label class="form-label" style="padding-left: 130px;" for="ak_bahan_alat">RM</label>
                                                            </td>
                                                            <td colspan="4">
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
                                                            <td colspan="4">
                                                                <select class="form-control status_aduan" name="status_aduan" id="status_aduan" >
                                                                    <option value="">-- Pilih Status Aduan --</option>
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
                                                                <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label><label class="form-label" style="padding-left: 142px;" for="jumlah_kos">RM</label>
                                                            </td>
                                                            <td colspan="4" style="background-color: #ddd; cursor: not-allowed;">
                                                                <input type="number" step="any" class="form-control" id="jumlah_kos" style="cursor:context-menu;" name="jumlah_kos" value="{{ old('jumlah_kos') }}" readonly>
                                                                    @error('jumlah_kos')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>

                                                            <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                            <td colspan="4" style="border-top-style: hidden;"></td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>

                                            <button type="submit" class="btn btn-primary float-right"><i class="fal fa-save"> Hantar Tindakan</i></button>
                                            <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"> Reset</i></button>

                                            {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    @endif

                    @if($aduan->status_aduan == 'TD' | $aduan->status_aduan == 'AS' | $aduan->status_aduan == 'AK') 
                        @can('tambah pembaikan')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-primary-50">
                                            <span class="fw-300"></span><i class="fal fa-edit"></i><b> BUTIRAN TINDAKAN KEATAS ADUAN </b>
                                        </div>

                                        <div class="card-body">
                                                {!! Form::open(['action' => 'AduanController@kemaskiniPenambahbaikan', 'method' => 'POST']) !!}
                                                {{Form::hidden('id', $aduan->id)}}
                                                
                                                <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Penerimaan Aduan :</label></td>
                                                                <td colspan="4"><b>{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Penerimaan Aduan :</label></td>
                                                                <td colspan="4"><b>{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="laporan_pembaikan"><span class="text-danger">*</span> Laporan Pembaikan :</label></td>
                                                                <td colspan="4">
                                                                    <textarea rows="10" class="form-control" id="laporan_pembaikan" name="laporan_pembaikan">{{ $aduan->laporan_pembaikan }}</textarea>
                                                                        @error('laporan_pembaikan')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                                <td width="20%"><label class="form-label" for="bahan_alat"><span class="text-danger">*</span> Bahan/ Alat Ganti :</label></td>
                                                                <td colspan="4">
                                                                    <textarea rows="10" class="form-control" id="bahan_alat" name="bahan_alat">{{ $aduan->bahan_alat }}</textarea>
                                                                        @error('bahan_alat')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td class="card-header bg-primary-50" width="20%" style="border-right-style: hidden;"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                                <td class="card-header bg-primary-50" colspan="4"><b></b></td>
                                                                <td width="20%"><label class="form-label" for="tarikh_selesai_aduan"><span class="text-danger">*</span> Tarikh Selesai Pembaikan :</label></td>
                                                                <td colspan="4"><b>{{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}</b></td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%">
                                                                    <label class="form-label" for="ak_upah"><span class="text-danger">*</span> Upah :</label><label class="form-label" style="padding-left: 205px;" for="ak_upah">RM</label><br><br><br><br>
                                                                    <label class="form-label" for="ak_bahan_alat"><span class="text-danger">*</span> Bahan/ Alat Ganti :</label><label class="form-label" style="padding-left: 130px;" for="ak_bahan_alat">RM</label>
                                                                </td>
                                                                <td colspan="4">
                                                                    <input type="number" step="any" class="form-control" id="ak_upah" name="ak_upah"  value="{{ $aduan->ak_upah }}">
                                                                        @error('ak_upah')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror<br><br>
                                                                    <input type="number" step="any" class="form-control" id="ak_bahan_alat" name="ak_bahan_alat" value="{{ $aduan->ak_bahan_alat }}">
                                                                        @error('ak_bahan_alat')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror<br>
                                                                </td>
                                                                <td width="20%">
                                                                    <label class="form-label" for="status_aduan"><span class="text-danger">*</span> Status Aduan :</label>
                                                                </td>
                                                                <td colspan="4"><b>{{ $aduan->status->nama_status }}</b></td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                    <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label><label class="form-label" style="padding-left: 142px;" for="jumlah_kos">RM</label>
                                                                </td>
                                                                <td colspan="4" style="background-color: #ddd; cursor: not-allowed;">
                                                                    <input type="number" step="any" class="form-control" id="jumlah_kos" style="cursor:context-menu;" name="jumlah_kos" value="{{ $aduan->jumlah_kos }}" readonly>
                                                                        @error('jumlah_kos')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>

                                                                <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                                <td colspan="4" style="border-top-style: hidden;"></td>
                                                            </div>
                                                        </tr>

                                                        @if($aduan->status_aduan == 'AS' | $aduan->status_aduan == 'AK') 
                                                            @can('papar catatan')
                                                            <tr>
                                                                <div class="form-group">
                                                                        <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                        <td colspan="8"><b>{{ $aduan->catatan_pembaikan ?? '-- TIADA DATA --'   }}</b></td>
                                                                </div>
                                                            </tr>
                                                            @endcan
                                                        @endif

                                                    </thead>
                                                </table>

                                                <button type="submit" class="btn btn-primary float-right"><i class="fal fa-save"> Kemaskini Tindakan</i></button>
                                                
                                                {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan

                        @can('papar pembaikan')
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-primary-50">
                                            <span class="fw-300"></span><i class="fal fa-edit"></i><b> BUTIRAN TINDAKAN KEATAS ADUAN </b>
                                        </div>

                                        <div class="card-body">
                                            {!! Form::open(['action' => 'AduanController@simpanStatus', 'method' => 'POST']) !!}
                                            {{Form::hidden('id', $aduan->id)}}
                                                <table id="tindakan" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Penerimaan Aduan :</label></td>
                                                                <td colspan="4"><b>{{ date(' j F Y ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                                <td width="20%"><label class="form-label" for="lokasi_aduan">Masa Penerimaan Aduan :</label></td>
                                                                <td colspan="4"><b>{{ date(' h:i:s A ', strtotime($aduan->tarikh_serahan_aduan)) }}</b></td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan :</label></td>
                                                                <td colspan="4"><b>{{ $aduan->laporan_pembaikan ?? '-- TIADA DATA --'   }}</b></td>
                                                                <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                                                                <td colspan="4"><b>{{ $aduan->bahan_alat ?? '-- TIADA DATA --'   }}</b></td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td class="card-header bg-primary-50" width="20%" style="border-right-style: hidden;"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                                                <td class="card-header bg-primary-50" colspan="4"><b></b></td>
                                                                <td width="20%">
                                                                    <label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan :</label>
                                                                </td>
                                                                <td colspan="4">
                                                                    <b>{{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}</b>
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%">
                                                                    <label class="form-label" for="ak_upah">Upah :</label><br><br>
                                                                    <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label>
                                                                </td>
                                                                <td colspan="4">
                                                                    <b>RM {{ $aduan->ak_upah ?? '-- TIADA DATA --'   }}</b><br><br>
                                                                    <b>RM {{ $aduan->ak_bahan_alat ?? '-- TIADA DATA --'   }}</b>
                                                                </td>
                                                                <td width="20%">
                                                                    <label class="form-label" for="status_aduan">Status Aduan :</label>
                                                                </td>
                                                                <td colspan="4">
                                                                    <b>{{ $aduan->status->nama_status }}</b>
                                                                </td>
                                                            </div>
                                                        </tr>

                                                        <tr>
                                                            <div class="form-group">
                                                                <td width="20%" style="background-color: #ddd; cursor: not-allowed;">
                                                                    <label class="form-label" for="jumlah_kos"><b>(+) JUMLAH KOS :</b></label>
                                                                </td>
                                                                <td colspan="4" style="background-color: #ddd; cursor: not-allowed;">
                                                                    <b>RM {{ $aduan->jumlah_kos ?? '-- TIADA DATA --'   }}</b>
                                                                </td>

                                                                <td width="20%" style="border-top-style: hidden;"><label class="form-label" for=""></label></td>
                                                                <td colspan="4" style="border-top-style: hidden;"></td>
                                                            </div>
                                                        </tr>

                                                        @if($aduan->status_aduan == 'AS' | $aduan->status_aduan == 'AK') 
                                                        
                                                            @can('edit pembaikan')
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                                    <td colspan="4"><textarea rows="8" class="form-control" id="catatan_pembaikan" name="catatan_pembaikan" >{{ $aduan->catatan_pembaikan }}</textarea></td>
                                                                                    <td width="20%"><label class="form-label" for="status_aduan">Tukar Status :</label></td>
                                                                                    <td colspan="4">
                                                                                        <select class="form-control tukar_status" name="status_aduan" id="status_aduan" >
                                                                                        <option value="">-- Pilih Status Aduan --</option>
                                                                                        @foreach($tukarStatus as $stats)
                                                                                            <option value="{{$stats->kod_status}}"  {{ $aduan->status_aduan == $stats->kod_status ? 'selected="selected"' : '' }}>{{$stats->nama_status}}</option><br>
                                                                                        @endforeach
                                                                                        @error('status_aduan')
                                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                        @enderror
                                                                                    </select><br></td>
                                                                            </div>
                                                                        </tr>

                                                                    </thead>
                                                                </table>
                                                                <button type="submit" class="btn btn-primary float-right"><i class="fal fa-save"> Kemaskini</i></button>
                                                            @endcan

                                                            @else

                                                            @can('edit pembaikan')
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                    <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                                                                                    <td colspan="4">
                                                                                        <textarea rows="8" class="form-control" id="catatan_pembaikan" name="catatan_pembaikan">{{ old('catatan_pembaikan') }}</textarea>
                                                                                            @error('catatan_pembaikan')
                                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                            @enderror
                                                                                    </td>
                                                                                    <td width="20%"><label class="form-label" for="status_aduan">Tukar Status :</label></td>
                                                                                    <td colspan="4">
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
                                                                <button type="submit" class="btn btn-primary float-right"><i class="fal fa-save"> Simpan</i></button>
                                                            @endcan

                                                        @endif

                                                    </thead>
                                                </table>
                                                
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    @endif
                     
                    <br><a style="margin-right:5px" href="{{ url()->previous() }}" class="btn btn-success float-right"><i class="fal fa-angle-double-left"></i> Kembali</a><br><br>
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
            $('.tahap_kategori, .juruteknik_bertugas, .status_aduan, .status, .tukar_status').select2();

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