@extends('layouts.applicant')
    
@section('content')
<style type="text/css" media="print">
    @page { size: landscape; }
  </style>
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC" style="margin-top: -50px"></center><br>

                <div align="center">
                    <h3><b>SENARAI LAPORAN ADUAN</b></h3>
                </div>

                <table class="table table-bordered table-hover w-100">
                    {{-- <thead> --}}
                        <tr class="text-center" style="vertical-align: middle; background-color: rgb(228, 228, 228)">
                            <div class="form-group">
                                <td style="vertical-align: middle"><label class="form-label">#ID</label></td>
                                <td><label class="form-label">TARIKH LAPORAN</label></td>
                                <td style="vertical-align: middle"><label class="form-label">NAMA</label></td>
                                <td style="vertical-align: middle"><label class="form-label">LOKASI</label></td>
                                <td style="vertical-align: middle"><label class="form-label">KATEGORI</label></td>
                                <td style="vertical-align: middle"><label class="form-label">JENIS</label></td>
                                <td style="vertical-align: middle"><label class="form-label">SEBAB</label></td>
                                <td style="vertical-align: middle"><label class="form-label">UNIT</label></td>
                                <td style="vertical-align: middle"><label class="form-label">CAJ</label></td>
                                <td style="vertical-align: middle"><label class="form-label">TAHAP</label></td>
                                <td><label class="form-label">TARIKH SERAHAN</label></td>
                                <td><label class="form-label">LAPORAN PEMBAIKAN</label></td>
                                <td><label class="form-label">JUMLAH KOS</label></td>
                                <td><label class="form-label">TARIKH SELESAI</label></td>
                                <td style="vertical-align: middle"><label class="form-label">STATUS</label></td>
                                <td style="vertical-align: middle"><label class="form-label">JURUTEKNIK</label></td>
                                <td style="vertical-align: middle"><label class="form-label">PERANAN</label></td>
                            </div>
                        </tr>
                        @dd($cond)
                        @if(isset($cond))
                        @foreach($cond as $conds)
                        <tr class="text-center">
                            <div class="form-group">
                                <td>{{ $conds->id_aduan }}</td>
                                <td style="width: 50px">{{ date(' d/m/Y ', strtotime($conds->aduan->tarikh_laporan)) }}</td>
                                <td>{{ strtoupper($conds->aduan->nama_pelapor) }}</td>
                                <td style="text-align: left; width: 160px">{{ strtoupper($conds->aduan->nama_bilik) }}, ARAS {{ strtoupper($conds->aduan->aras_aduan) }}, BLOK {{ strtoupper($conds->aduan->blok_aduan) }}, {{ strtoupper($conds->aduan->lokasi_aduan) }}</td>
                                <td style="width: 115px">{{ strtoupper($conds->aduan->kategori->nama_kategori) }}</td>
                                <td>{{ strtoupper($conds->aduan->jenis->jenis_kerosakan) }}</td>
                                <td>{{ strtoupper($conds->aduan->sebab->sebab_kerosakan) }}</td>
                                <td>{{ $conds->aduan->kuantiti_unit }}</td>
                                <td>{{ $conds->aduan->caj_kerosakan }}</td>
                                <td>{{ $conds->aduan->tahap->jenis_tahap }}</td>
                                <td style="width: 50px">{{ date(' d/m/Y ', strtotime($conds->aduan->tarikh_serahan_aduan))}}</td>
                                <td style="text-align: left; width: 160px">{{ strtoupper($conds->aduan->laporan_pembaikan) }}</td>
                                <td style="width: 50px">RM{{ $conds->aduan->jumlah_kos }}</td>
                                <td style="width: 50px">{{ date(' d/m/Y ', strtotime($conds->aduan->tarikh_selesai_aduan))}}</td>
                                <td>{{ strtoupper($conds->aduan->status->nama_status) }}</td>
                                <td>{{ strtoupper($conds->juruteknik->name) }}</td>
                                <td>
                                    @if ($conds->jenis_juruteknik == 'K') KETUA @endif
                                    @if ($conds->jenis_juruteknik== 'P') PEMBANTU @endif
                                </td>
                            </div>
                        </tr>
                        @endforeach
                        @else
                            <tr align="center" class="data-row">
                                <td valign="top" colspan="17" class="dataTables_empty">-- TIADA DATA --</td>
                            </tr>
                        @endif
                    {{-- </thead> --}}
                </table>
                <br>
                <div style="font-style: italic; font-size: 10px">
                    <p style="float: left">@ Copyright INTEC Education College</p>
                    {{-- <p style="float: right">Review Date : {{ date(' j F Y | h:i:s A ', strtotime($cond->first()->aduan->updated_at)) }}</p><br> --}}
                </div>
            {{-- </div> --}}
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    //
</script>
@endsection