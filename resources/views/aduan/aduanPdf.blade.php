@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC" style="margin-top: -65px"></center><br>

                <div align="left">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b>LAPORAN ADUAN #{{ $aduan->id }}</b></h4>
                </div>

                <table class="table table-bordered table-hover w-100">
                    <tr>
                        <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">INFO ADUAN</label></td>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="tarikh_laporan">Tarikh Aduan Dibuat :</label></td>
                            <td colspan="2">{{ date('j F Y', strtotime($aduan->tarikh_laporan) )}}</td>
                            <td width="20%"><label class="form-label" for="tarikh_laporan">Masa Aduan Dibuat :</label></td>
                            <td colspan="2">{{ date('h:i:s A', strtotime($aduan->tarikh_laporan) )}}</td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="nama_pelapor">Nama Pelapor :</label></td>
                            <td colspan="2">{{ strtoupper($aduan->nama_pelapor ?? '--')  }}</td>
                            <td width="20%"><label class="form-label" for="emel_pelapor">Emel :</label></td>
                            <td colspan="2">{{ $aduan->emel_pelapor ?? '--'  }}</td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="no_tel_pelapor">No Telefon :</label></td>
                            <td colspan="2">{{ $aduan->no_tel_pelapor ?? '--'  }}</td>
                            <td width="20%"><label class="form-label" for="no_tel_pelapor">Status :</label></td>
                            <td colspan="2"><b>{{ strtoupper($aduan->status->nama_status ?? '--')  }}</b></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="lokasi_aduan">Lokasi :</label></td>
                            <td colspan="2">
                                {{ strtoupper($aduan->nama_bilik) . ', ARAS ' . strtoupper($aduan->aras_aduan) . ', BLOK ' . strtoupper($aduan->blok_aduan) . ', ' . strtoupper($aduan->lokasi_aduan) ?? '-- TIADA DATA --'  }}
                            </td>
                            <td width="20%"><label class="form-label" for="kategori_aduan">Aduan :</label></td>
                            <td colspan="2">
                                <div> KATEGORI : {{ strtoupper($aduan->kategori->nama_kategori) }}</div>
                                <div> JENIS : {{ strtoupper($aduan->jenis->jenis_kerosakan) }}</div>
                                @if($aduan->jenis->jenis_kerosakan == 'Lain-lain') 
                                    <div> PENERANGAN : <b>{{ strtoupper($aduan->jk_penerangan ?? '--') }}</b></div>
                                @endif
                                <div> SEBAB : {{ strtoupper($aduan->sebab->sebab_kerosakan) }}</div>
                                @if($aduan->sebab->sebab_kerosakan == 'Lain-lain')
                                    <div> PENERANGAN : <b>{{ strtoupper($aduan->sk_penerangan ?? '--') }}</b></div>
                                @endif
                            </td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="maklumat_tambahan">Kuantiti/Unit :</label></td>
                            <td colspan="2">{{ $aduan->kuantiti_unit ?? '--'  }}</td>
                            <td width="20%"><label class="form-label" for="maklumat_tambahan">Maklumat Tambahan :</label></td>
                            <td colspan="2">{{ strtoupper($aduan->maklumat_tambahan ?? '--')  }}</td>
                        </div>
                    </tr>
                    <tr>
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
                    </tr>
               
                    <tr>
                        <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">INFO PENAMBAHBAIKAN</label></td>
                    </tr>
                    <tr>
                        <tr>
                            <div class="form-group">
                                <td width="20%"><label class="form-label" for="lokasi_aduan">Tarikh Serahan Aduan :</label></td>
                                <td colspan="2">{{ date(' j F Y | h:i:s A', strtotime($aduan->tarikh_serahan_aduan)) }}</td>
                                <td width="20%"><label class="form-label" for="tarikh_selesai_aduan">Tarikh Selesai Pembaikan :</label></td>
                                <td colspan="2">{{ date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_selesai_aduan)) }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="20%"><label class="form-label" for="tahap_kategori">Tahap Aduan :</label></td>
                                <td colspan="2">{{ $aduan->tahap->jenis_tahap ?? '--'}}</td>
                                <td width="20%"><label class="form-label" for="caj_kerosakan">Caj Kerosakan :</label></td>
                                <td colspan="2">{{ strtoupper($aduan->caj_kerosakan) ?? '--'}}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="20%"><label class="form-label" for="laporan_pembaikan">Laporan Pembaikan :</label></td>
                                <td colspan="2">{{ strtoupper($aduan->laporan_pembaikan ?? '--')   }}</td>
                                <td width="20%"><label class="form-label" for="bahan_alat">Bahan/ Alat Ganti :</label></td>
                                <td colspan="2">
                                    @if(isset($alatan_ganti->first()->alat_ganti))
                                    <ol>
                                        @foreach($alatan_ganti as $al)
                                            <li>{{ strtoupper($al->alat->alat_ganti) }}</li>
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
                                <td colspan="3" style="background-color: #fbfbfb82"><label class="form-label" for="laporan_pembaikan"><i class="fal fa-money-bill"></i> Anggaran Kos</label></td>
                                <td colspan="2" style="background-color: #fbfbfb82"><label class="form-label" for="juruteknik_bertugas"><i class="fal fa-users"></i> Juruteknik Bertugas</label></td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="20%">
                                    <label class="form-label" for="ak_upah">Upah :</label><br>
                                    <label class="form-label" for="ak_bahan_alat">Bahan/ Alat Ganti :</label><br>
                                    <label class="form-label" for="jumlah_kos"><b>(+) Jumlah Kos :</b></label>
                                </td>
                                <td colspan="2" style="line-height: 1.8">
                                    RM {{ $aduan->ak_upah ?? '--'   }}<br>
                                    RM {{ $aduan->ak_bahan_alat ?? '--'   }}<br>
                                    RM {{ $aduan->jumlah_kos ?? '--'   }}
                                </td>
                                <td colspan="2" style="vertical-align: middle">
                                    <ol style="margin-left: -25px">
                                        @foreach($juruteknik as $senarai)
                                            <li style="line-height: 30px"> {{ $senarai->juruteknik->name ?? '--'}} 
                                                ( @if ($senarai->jenis_juruteknik == 'K') KETUA @endif
                                                    @if ($senarai->jenis_juruteknik == 'P') PEMBANTU @endif )
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <th width="20%" style="vertical-align: middle"> Gambar : </th>
                            <td colspan="4">
                                @if(isset($gambar->first()->upload_image))
                                    @foreach($gambar as $imejPembaikan)
                                        <img src="/get-file-gambar/{{ $imejPembaikan->upload_image }}" style="width:100px; height:100px;" class="img-fluid mr-2">
                                    @endforeach
                                @else
                                    <span>TIADA GAMBAR SOKONGAN</span>
                                @endif
                            </td>
                        </tr> 
                    </tr>
               
                    <tr>
                        <td colspan="5" style="background-color: rgb(228, 228, 228)"><label class="form-label">LAIN-LAIN INFO</label></td>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td width="20%"><label class="form-label" for="catatan_pembaikan">Catatan :</label></td>
                            <td colspan="2">{{ strtoupper($aduan->catatan_pembaikan ?? '--')   }}</td>
                            <td width="20%"><label class="form-label" for="pengesahan_pembaikan">Pengesahan oleh Pelapor :</label></td>
                            <td colspan="2"><b>
                                @if(isset($aduan->pengesahan_pembaikan))
                                    DISAHKAN
                                @else
                                    BELUM DISAHKAN
                                @endif
                            </b></td>
                        </div>
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