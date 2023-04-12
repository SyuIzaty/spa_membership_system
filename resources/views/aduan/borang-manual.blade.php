@extends('layouts.applicant')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">

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

            <table class="table table-bordered table-hover w-100">
                <tr>
                    <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">INFO PENGADU</label></td>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="nama_pelapor">Nama Pelapor :</label></td>
                        <td colspan="2">{{ strtoupper($aduan->nama_pelapor ?? '--')  }}</td>
                        <td width="20%"><label class="form-label" for="nama_pelapor">
                            @if(isset($pengadu->category))
                                @if($pengadu->category == 'STF') ID Staf : @else ID Pelajar : @endif
                            @else
                                No. Kad Pengenalan :
                            @endif
                        </label></td>
                        <td colspan="2">{{ strtoupper($aduan->id_pelapor ?? '--')  }}</td>
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
                    <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">INFO ADUAN</label></td>
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
                        <td width="20%"><label class="form-label" for="kategori_aduan">Aduan :</label></td>
                        <td colspan="4">
                            <div> KATEGORI : {{ strtoupper($aduan->kategori->nama_kategori) }}</div>
                        </td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="20%"><label class="form-label" for="tarikh_laporan">Jenis :</label></td>
                        <td colspan="2">
                            {{ strtoupper($aduan->jenis->jenis_kerosakan) }}<br>
                            @if($aduan->jenis->jenis_kerosakan == 'Lain-lain')
                                <div> PENERANGAN : <b>{{ strtoupper($aduan->jk_penerangan ?? '--') }}</b></div>
                            @endif
                        </td>
                        <td width="20%"><label class="form-label" for="tarikh_laporan">Sebab :</label></td>
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
                        <td width="15%"><label class="form-label" for="tahap_kategori">Tahap Aduan :</label></td>
                        <td colspan="2">{{ $aduan->tahap->jenis_tahap ?? '--'}}</td>
                        <td width="15%"><label class="form-label" for="caj_kerosakan">Caj Kerosakan :</label></td>
                        <td colspan="2">{{ strtoupper($aduan->caj_kerosakan) ?? '--'}}</td>
                    </div>
                </tr>
                <tr>
                    <div class="form-group">
                        <td width="15%" style="vertical-align: middle"><label class="form-label" for="juruteknik">Juruteknik :</label></td>
                            <td colspan="4" style="vertical-align: middle">
                                <ol style="margin-left: -25px">
                                    @foreach($juruteknik as $senarai)
                                        <li> {{ strtoupper($senarai->juruteknik->name) ?? '--'}}
                                            ( @if ($senarai->jenis_juruteknik == 'K') KETUA @endif
                                                @if ($senarai->jenis_juruteknik == 'P') PEMBANTU @endif )
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                    </div>
                </tr>
                {{-- <tr>
                    <div class="form-group">
                        <td width="20%" style="vertical-align: middle"><label class="form-label" for="maklumat_tambahan">Gambar :</label></td>
                        <td colspan="2">
                            @if(isset($imej->first()->upload_image))
                                @foreach($imej as $imejAduan)
                                    <img src="/get-file-resit/{{ $imejAduan->upload_image }}" style="width:100px; height:100px;" class="img-fluid mr-2">
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
                </tr> --}}
            </table>

            <table class="table table-bordered table-hover w-100">
                <tr>
                    <td colspan="6" style="background-color: rgb(228, 228, 228)"><label class="form-label">TINDAKAN PENAMBAHBAIKAN</label></td>
                </tr>
                <tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="tarikh_serahan_aduan">Tarikh Serahan Aduan :</label></td>
                            <td colspan="2"  style="text-transform: uppercase">{{ date(' j F Y | h:i:s A', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                            <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan :</label></td>
                            <td colspan="3"><input class="form-control" id="tarikh_selesai_aduan" name="tarikh_selesai_aduan"></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan :</label></td>
                            <td colspan="6"><textarea rows="8" class="form-control" id="laporan_pembaikan" name="laporan_pembaikan"></textarea></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                            <td colspan="6"><textarea rows="8" class="form-control" id="bahan_alat" name="bahan_alat"></textarea></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td colspan="3" style="background-color: #fbfbfb82"><label class="form-label" for="kos"> Anggaran Kos :</label></td>
                            <td colspan="3" style="background-color: #fbfbfb82"><label class="form-label" for="status"> Status : </label></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%">
                                <label class="form-label" for="ak_upah">Upah :</label><br><br><br>
                                <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label><br><br><br>
                                <label class="form-label" for="jumlah_kos"><b>(+) Jumlah Kos :</b></label>
                            </td>
                            <td colspan="2" style="line-height: 1.8">
                                <input class="form-control" id="tarikh_selesai_aduan" name="tarikh_selesai_aduan"><br>
                                <input class="form-control" id="tarikh_selesai_aduan" name="tarikh_selesai_aduan"><br>
                                <input class="form-control" id="tarikh_selesai_aduan" name="tarikh_selesai_aduan">
                            </td>
                            <td colspan="3">
                                <textarea rows="7" class="form-control" id="status" name="status"></textarea>
                            </td>
                        </div>
                    </tr>
                </tr>
            </table>
            <br>
            <div style="font-style: italic; font-size: 10px">
                <p style="float: left">@ Copyright INTEC Education College</p>
                <p style="float: right">Review Date : {{ date(' j F Y | h:i:s A ', strtotime($aduan->created_at)) }}</p><br>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    //
</script>
@endsection
