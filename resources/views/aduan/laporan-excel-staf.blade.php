@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i>  PENGURUSAN LAPORAN ADUAN JURUTEKNIK 
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>SENARAI LAPORAN ADUAN</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <div class="row">
                                <div class="col">
                                    @role('Technical Admin')
                                        <div class="tab-pane" role="tabpanel" style="margin-top: -30px"><br>
                                            <form action="{{ route('exportAduanStaf') }}" method="GET" id="form_find">
                                                <div class="row"><br>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Juruteknik</label>
                                                        <select class="custom-juruteknik form-control" name="juruteknik" id="juruteknik">
                                                            <option value="" disabled selected>Silih pilih</option>
                                                            @foreach($juruteknik as $juru)
                                                                <option value="{{$juru->id}}" {{ $req_juruteknik == $juru->id  ? 'selected' : '' }}>{{ $juru->id}} : {{strtoupper($juru->name)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Status</label>
                                                        <select class="custom-stat form-control" name="stat" id="stat">
                                                            <option value="" disabled selected>Silih pilih</option>
                                                            @foreach($status as $stats)
                                                                <option value="{{$stats->kod_status}}" {{ $req_status == $stats->kod_status  ? 'selected' : '' }}>{{strtoupper($stats->nama_status)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Kategori</label>
                                                        <select class="custom-kate form-control" name="kate" id="kate">
                                                            <option value="" disabled selected>Silih pilih</option>
                                                            @foreach($kategori as $kat)
                                                                <option value="{{$kat->kod_kategori}}" {{ $req_kategori == $kat->kod_kategori  ? 'selected' : '' }}>{{strtoupper($kat->nama_kategori)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Bulan</label>
                                                        <select class="custom-bul form-control" name="bul" id="bul">
                                                            <option value="" disabled selected>Silih pilih</option>
                                                            @foreach($bulan as $bul)
                                                                <option value="{{$bul->bulan_laporan}}" {{ $req_bulan == $bul->bulan_laporan ? 'selected' : '' }}>{{$bul->bulan_laporan}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                            </form>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="reps">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#TIKET</th>
                                                            <th>JURUTEKNIK</th>
                                                            <th>PELAPOR</th>
                                                            <th>TARIKH_LAPORAN</th>
                                                            <th>BILIK</th>
                                                            <th>ARAS</th>
                                                            <th>BLOK</th>
                                                            <th>LOKASI</th>
                                                            <th>KATEGORI</th>
                                                            <th>JENIS</th>
                                                            <th>SEBAB</th>
                                                            <th>KUANTITI/UNIT</th>
                                                            <th>CAJ_KEROSAKAN</th>
                                                            <th>MAKLUMAT_TAMBAHAN</th>
                                                            <th>TAHAP_KATEGORI</th>
                                                            <th>TARIKH_SERAHAN</th>
                                                            <th>LAPORAN_PEMBAIKAN</th>
                                                            <th>JUMLAH_KOS</th>
                                                            <th>TARIKH_SELESAI</th>
                                                            <th>PENGESAHAN_PEMBAIKAN</th>
                                                            <th>STATUS_TERKINI</th>
                                                        </tr>
                                                    </thead>
                                                    @if (isset($data) && !empty($data))
                                                        <tbody>
                                                            @foreach ($data as $key => $datas)
                                                                <tr>
                                                                    <td class="text-center">{{ isset($datas->id_aduan) ? '#'.$datas->id_aduan : '--' }}</td>
                                                                    <td>{{ isset($datas->juruteknik->name) ? $datas->juruteknik_bertugas.' : '.strtoupper($datas->juruteknik->name) : '--' }}</td>
                                                                    <td>{{ isset($datas->aduan->nama_pelapor) ? $datas->aduan->id_pelapor.' : '.strtoupper($datas->aduan->nama_pelapor) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->tarikh_laporan) ? date(' d-m-Y ', strtotime($datas->aduan->tarikh_laporan)) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->nama_bilik) ? strtoupper($datas->aduan->nama_bilik) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->aras_aduan) ? strtoupper($datas->aduan->aras_aduan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->blok_aduan) ? strtoupper($datas->aduan->blok_aduan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->lokasi_aduan) ? strtoupper($datas->aduan->lokasi_aduan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->kategori->nama_kategori) ? strtoupper($datas->aduan->kategori->nama_kategori) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->jenis->jenis_kerosakan) ? strtoupper($datas->aduan->jenis->jenis_kerosakan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->sebab->sebab_kerosakan) ? strtoupper($datas->aduan->sebab->sebab_kerosakan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->kuantiti_unit) ? $datas->aduan->kuantiti_unit : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->caj_kerosakan) ? strtoupper($datas->aduan->caj_kerosakan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->maklumat_tambahan) ? strtoupper($datas->aduan->maklumat_tambahan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->tahap->jenis_tahap) ? strtoupper($datas->aduan->tahap->jenis_tahap ): '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->tarikh_serahan_aduan) ? date(' d-m-Y ', strtotime($datas->aduan->tarikh_serahan_aduan)) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->laporan_pembaikan) ? strtoupper($datas->aduan->laporan_pembaikan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->jumlah_kos) ? 'RM'.$datas->aduan->jumlah_kos : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->tarikh_selesai_aduan) ? date(' d-m-Y ', strtotime($datas->aduan->tarikh_selesai_aduan)) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->pengesahan_pembaikan) ? strtoupper($datas->aduan->pengesahan_pembaikan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($datas->aduan->status->nama_status) ? strtoupper($datas->aduan->status->nama_status) : '--' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    @endif
                                                </table>
                                            </div>
                                            <br>
                                            <a class="btn buttons-csv btn-md float-right mb-4" href="/juruExport/{{$req_juruteknik}}/{{$req_status}}/{{$req_kategori}}/{{$req_bulan}}"><span><i class="fal fa-file-excel"></i> Export</span></a>
                                        </div>
                                    @endrole

                                    @role('Technical Staff')
                                        <div class="tab-pane" role="tabpanel" style="margin-top: -30px"><br>
                                            <form action="{{ route('exportAduanStaf') }}" method="GET" id="form_finds">
                                                <div class="row"><br>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Status</label>
                                                        <select class="custom-status form-control" name="sel_stat" id="sel_stat">
                                                            <option value="" disabled selected>Silih pilih</option>
                                                            @foreach($status as $sel_stat)
                                                                <option value="{{$sel_stat->kod_status}}" {{ $req_stat == $sel_stat->kod_status  ? 'selected' : '' }}>{{strtoupper($sel_stat->nama_status)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Kategori</label>
                                                        <select class="custom-kategori form-control" name="sel_kate" id="sel_kate">
                                                            <option value="" disabled selected>Silih pilih</option>
                                                            @foreach($kategori as $sel_kate)
                                                                <option value="{{$sel_kate->kod_kategori}}" {{ $req_kate == $sel_kate->kod_kategori  ? 'selected' : '' }}>{{strtoupper($sel_kate->nama_kategori)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Bulan</label>
                                                        <select class="custom-bulan form-control" name="sel_bul" id="sel_bul">
                                                            <option value="" disabled selected>Silih pilih</option>
                                                            @foreach($bulan as $sel_bul)
                                                                <option value="{{$sel_bul->bulan_laporan}}" {{ $req_bul == $sel_bul->bulan_laporan ? 'selected' : '' }}>{{$sel_bul->bulan_laporan}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                            </form>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="repo">
                                                    <thead>
                                                        <tr class="text-center bg-primary-50">
                                                            <th>#TIKET</th>
                                                            <th>PELAPOR</th>
                                                            <th>TARIKH_LAPORAN</th>
                                                            <th>BILIK</th>
                                                            <th>ARAS</th>
                                                            <th>BLOK</th>
                                                            <th>LOKASI</th>
                                                            <th>KATEGORI</th>
                                                            <th>JENIS</th>
                                                            <th>SEBAB</th>
                                                            <th>KUANTITI/UNIT</th>
                                                            <th>CAJ_KEROSAKAN</th>
                                                            <th>MAKLUMAT_TAMBAHAN</th>
                                                            <th>TAHAP_KATEGORI</th>
                                                            <th>TARIKH_SERAHAN</th>
                                                            <th>LAPORAN_PEMBAIKAN</th>
                                                            <th>JUMLAH_KOS</th>
                                                            <th>TARIKH_SELESAI</th>
                                                            <th>PENGESAHAN_PEMBAIKAN</th>
                                                            <th>STATUS_TERKINI</th>
                                                        </tr>
                                                    </thead>
                                                    @if (isset($dat) && !empty($dat))
                                                        <tbody>
                                                            @foreach ($dat as $key => $dats)
                                                                <tr>
                                                                    <td class="text-center">{{ isset($dats->id_aduan) ? '#'.$dats->id_aduan : '--' }}</td>
                                                                    <td>{{ isset($dats->aduan->nama_pelapor) ? $dats->aduan->id_pelapor.' : '.strtoupper($dats->aduan->nama_pelapor) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->tarikh_laporan) ? date(' d-m-Y ', strtotime($dats->aduan->tarikh_laporan)) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->nama_bilik) ? strtoupper($dats->aduan->nama_bilik) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->aras_aduan) ? strtoupper($dats->aduan->aras_aduan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->blok_aduan) ? strtoupper($dats->aduan->blok_aduan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->lokasi_aduan) ? strtoupper($dats->aduan->lokasi_aduan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->kategori->nama_kategori) ? strtoupper($dats->aduan->kategori->nama_kategori) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->jenis->jenis_kerosakan) ? strtoupper($dats->aduan->jenis->jenis_kerosakan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->sebab->sebab_kerosakan) ? strtoupper($dats->aduan->sebab->sebab_kerosakan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->kuantiti_unit) ? $dats->aduan->kuantiti_unit : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->caj_kerosakan) ? strtoupper($dats->aduan->caj_kerosakan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->maklumat_tambahan) ? strtoupper($dats->aduan->maklumat_tambahan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->tahap->jenis_tahap) ? strtoupper($dats->aduan->tahap->jenis_tahap ): '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->tarikh_serahan_aduan) ? date(' d-m-Y ', strtotime($dats->aduan->tarikh_serahan_aduan)) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->laporan_pembaikan) ? strtoupper($dats->aduan->laporan_pembaikan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->jumlah_kos) ? 'RM'.$dats->aduan->jumlah_kos : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->tarikh_selesai_aduan) ? date(' d-m-Y ', strtotime($dats->aduan->tarikh_selesai_aduan)) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->pengesahan_pembaikan) ? strtoupper($dats->aduan->pengesahan_pembaikan) : '--' }}</td>
                                                                    <td class="text-center">{{ isset($dats->aduan->status->nama_status) ? strtoupper($dats->aduan->status->nama_status) : '--' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    @endif
                                                </table>
                                            </div>
                                            <br>
                                            <a class="btn buttons-csv btn-md float-right mb-4" href="/individuExport/{{$req_stat}}/{{$req_kate}}/{{$req_bul}}"><span><i class="fal fa-file-excel"></i> Export</span></a>
                                        </div>
                                    @endrole
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
<style>
    .buttons-csv{
        color: white;
        background-color: #606FAD;
        float: right;
    }
</style>
<script >

    $("#juruteknik, #stat, #kate, #bul").change(function(){
        $("#form_find").submit();
    })

    $("#sel_stat, #sel_kate, #sel_bul").change(function(){
        $("#form_finds").submit();
    })

    $(document).ready(function()
    {
        $('#juruteknik, #stat, #kate, #bul, #sel_stat, #sel_kate, #sel_bul').select2();

        var table = $('#reps').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

        var table = $('#repo').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });
</script>
@endsection
