@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> PENGURUSAN LAPORAN ADUAN KESELURUHAN
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
                                    <form action="{{ route('exportAduan') }}" method="GET" id="form_find">
                                        <div class="row"><br>
                                            <div class="col-md-6 mt-2">
                                                <label>Kategori</label>
                                                <select class="custom-kategori form-control" name="kategori" id="kategori">
                                                    <option value="" disabled selected>Silih pilih</option>
                                                    @foreach($kategori as $kat)
                                                        <option value="{{$kat->kod_kategori}}" {{ $req_kategori == $kat->kod_kategori  ? 'selected' : '' }}>{{strtoupper($kat->nama_kategori)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>Status</label>
                                                <select class="custom-status form-control" name="status" id="status">
                                                    <option value="" disabled selected>Silih pilih</option>
                                                    @foreach($status as $stats)
                                                        <option value="{{$stats->kod_status}}" {{ $req_status == $stats->kod_status  ? 'selected' : '' }}>{{strtoupper($stats->nama_status)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>Tahap</label>
                                                <select class="custom-tahap form-control" name="tahap" id="tahap">
                                                    <option value="" disabled selected>Silih pilih</option>
                                                    @foreach($tahap as $thp)
                                                        <option value="{{$thp->kod_tahap}}" {{ $req_tahap == $thp->kod_tahap  ? 'selected' : '' }}>{{strtoupper($thp->jenis_tahap)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label>Bulan</label>
                                                <select class="custom-bulan form-control" name="bulan" id="bulan">
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
                                        <table class="table table-bordered" id="rep">
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
                                                            <td class="text-center">{{ isset($datas->id) ? '#'.$datas->id : '--' }}</td>
                                                            <td>
                                                                <?php $juru = \App\JuruteknikBertugas::where('id_aduan', $datas->id)->get() ?>

                                                                @if($juru->first() != null)
                                                                    @foreach($juru as $jurutek)
                                                                        {{ isset($jurutek->juruteknik->name) ? $jurutek->juruteknik_bertugas.' : '.strtoupper($jurutek->juruteknik->name) : '--' }},
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td>{{ isset($datas->nama_pelapor) ? $datas->id_pelapor.' : '.strtoupper($datas->nama_pelapor) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->tarikh_laporan) ? date(' d-m-Y ', strtotime($datas->tarikh_laporan)) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->nama_bilik) ? strtoupper($datas->nama_bilik) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->aras_aduan) ? strtoupper($datas->aras_aduan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->blok_aduan) ? strtoupper($datas->blok_aduan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->lokasi_aduan) ? strtoupper($datas->lokasi_aduan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->kategori->nama_kategori) ? strtoupper($datas->kategori->nama_kategori) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->jenis->jenis_kerosakan) ? strtoupper($datas->jenis->jenis_kerosakan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->sebab->sebab_kerosakan) ? strtoupper($datas->sebab->sebab_kerosakan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->kuantiti_unit) ? $datas->kuantiti_unit : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->caj_kerosakan) ? strtoupper($datas->caj_kerosakan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->maklumat_tambahan) ? strtoupper($datas->maklumat_tambahan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->tahap->jenis_tahap) ? strtoupper($datas->tahap->jenis_tahap ): '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->tarikh_serahan_aduan) ? date(' d-m-Y ', strtotime($datas->tarikh_serahan_aduan)) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->laporan_pembaikan) ? strtoupper($datas->laporan_pembaikan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->jumlah_kos) ? 'RM'.$datas->jumlah_kos : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->tarikh_selesai_aduan) ? date(' d-m-Y ', strtotime($datas->tarikh_selesai_aduan)) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->pengesahan_pembaikan) ? strtoupper($datas->pengesahan_pembaikan) : '--' }}</td>
                                                            <td class="text-center">{{ isset($datas->status->nama_status) ? strtoupper($datas->status->nama_status) : '--' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                    <br>
                                    <a class="btn buttons-csv btn-md float-right mb-4" href="/aduanExport/{{$req_kategori}}/{{$req_status}}/{{$req_tahap}}/{{$req_bulan}}"><span><i class="fal fa-file-excel"></i> Export</span></a>

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
<script>

    $("#tahap, #status, #kategori, #bulan").change(function(){
        $("#form_find").submit();
    })

    $(document).ready(function()
    {
        $('#tahap, #status, #kategori, #bulan').select2();

        var table = $('#rep').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });
</script>
@endsection
