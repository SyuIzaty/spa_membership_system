@extends('layouts.admin')

@section('content')
<style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: white !important;
    background-color: #880000;
}
</style>
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> LAPORAN EXCEL
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>LAPORAN ADUAN</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <ul class="nav nav-pills" role="tablist">
                                @role('Operation Admin')
                                <li class="nav-item" style="margin-right: 2px">
                                    <a style="color: #880000; border: solid 1px;  border-radius: 0" data-toggle="tab" class="nav-link" href="#all" role="tab"><i class="fal fa-file"></i> KESELURUHAN</a>
                                </li>
                                <li class="nav-item">
                                    <a style="color: #880000; border: solid 1px; border-radius: 0" data-toggle="tab" class="nav-link" href="#juru" role="tab"><i class="fal fa-user"></i> JURUTEKNIK</a>
                                </li>
                                @endrole
                                @role('Technical Staff')
                                <li class="nav-item">
                                    <a style="color: #880000; border: solid 1px; border-radius: 0" data-toggle="tab" class="nav-link" href="#test" role="tab"><i class="fal fa-user"></i> JURUTEKNIK</a>
                                </li>
                                @endrole
                            </ul>
    
                            <br><br>

                            <div class="row">
                                <div class="col">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        @role('Operation Admin')
                                        <div class="tab-pane active" id="all" role="tabpanel" style="margin-top: -30px"><br>
                                            {{-- <form action="{{ route('exportAduan') }}" method="GET" id="form_find"> --}}
                                            <div class="row"><br>
                                                <div class="col-md-6 mt-2">
                                                    <label>Kategori</label>
                                                    <select class="selectfilter form-control" name="kategori" id="kategori">
                                                        <option value="">Pilih Kategori</option>
                                                        <option>All</option>
                                                        @foreach($kategori as $kat)
                                                            <option value="{{$kat->kod_kategori}}" {{ $request->kategori == $kat->kod_kategori  ? 'selected' : '' }}>{{$kat->nama_kategori}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label>Status</label>
                                                    <select class="selectfilter form-control" name="status" id="status">
                                                        <option value="">Pilih Status</option>
                                                        <option>All</option>
                                                        @foreach($status as $stat)
                                                            <option value="{{$stat->kod_status}}" {{ $request->status == $stat->kod_status  ? 'selected' : '' }}>{{strtoupper($stat->nama_status)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label>Tahap</label>
                                                    <select class="selectfilter form-control" name="tahap" id="tahap">
                                                        <option value="">Pilih Tahap</option>
                                                        <option>All</option>
                                                        @foreach($tahap as $thp)
                                                            <option value="{{$thp->kod_tahap}}" {{ $request->tahap == $thp->kod_tahap  ? 'selected' : '' }}>{{$thp->jenis_tahap}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label>Bulan</label>
                                                    <select class="selectfilter form-control" name="bulan" id="bulan">
                                                        <option value="">Pilih Bulan</option>
                                                        <option>All</option>
                                                        @foreach($bulan as $bul)
                                                            <option value="{{$bul->bulan_laporan}}" {{ $request->bulan == $bul->bulan_laporan ? 'selected' : '' }}>{{$bul->bulan_laporan}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <br>
                                            
                                            {{-- </form> --}}
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="rep">
                                                    <thead>
                                                        <tr class="text-center" style="background-color: #880000; color: white">
                                                            <th>#ID</th>
                                                            <th>NAMA</th>
                                                            <th>EMEL</th>
                                                            <th>STAF ID</th>
                                                            <th>NO TELEFON</th>
                                                            <th>TARIKH LAPORAN</th>
                                                            <th>BILIK</th>
                                                            <th>ARAS</th>
                                                            <th>BLOK</th>
                                                            <th>LOKASI</th>
                                                            <th>KATEGORI</th>
                                                            <th>JENIS</th>
                                                            <th>SEBAB</th>
                                                            <th>KUANTITI / UNIT</th>
                                                            <th>CAJ KEROSAKAN</th>
                                                            <th>MAKLUMAT TAMBAHAN</th>
                                                            <th>PENGESAHAN ADUAN</th>
                                                            <th>TAHAP KATEGORI</th>
                                                            <th>TARIKH SERAHAN ADUAN</th>
                                                            <th>LAPORAN PEMBAIKAN</th>
                                                            <th>BAHAN/ALAT GANTI</th>
                                                            <th>KOS UPAH</th>
                                                            <th>KOS BAHAN</th>
                                                            <th>JUMLAH KOS</th>
                                                            <th>TARIKH SELESAI ADUAN</th>
                                                            <th>PENGESAHAN PEMBAIKAN</th>
                                                            <th>CATATAN PEMBAIKAN</th>
                                                            <th>STATUS TERKINI</th>
                                                            <th>JURUTEKNIK BERTUGAS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="tab-pane" id="juru" role="tabpanel" style="margin-top: -30px"><br>

                                            <form action="{{ route('exportAduan') }}" method="GET" id="form_find">
                                                <div class="row"><br>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Juruteknik</label>
                                                        <select class="custom-juruteknik form-control" name="juruteknik" id="juruteknik">
                                                            <option value="">Pilih Juruteknik</option>
                                                            {{-- <option>All</option> --}}
                                                            @foreach($juruteknik as $juru)
                                                                <option value="{{$juru->id}}" {{ $req_juruteknik == $juru->id  ? 'selected' : '' }}>{{$juru->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Status</label>
                                                        <select class="custom-stat form-control" name="stat" id="stat">
                                                            <option value="">Pilih Status</option>
                                                            {{-- <option>All</option> --}}
                                                            @foreach($status as $stats)
                                                                <option value="{{$stats->kod_status}}" {{ $req_status == $stats->kod_status  ? 'selected' : '' }}>{{strtoupper($stats->nama_status)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Kategori</label>
                                                        <select class="custom-kate form-control" name="kate" id="kate">
                                                            <option value="">Pilih Kategori</option>
                                                            {{-- <option>All</option> --}}
                                                            @foreach($kategori as $kat)
                                                                <option value="{{$kat->kod_kategori}}" {{ $req_kategori == $kat->kod_kategori  ? 'selected' : '' }}>{{$kat->nama_kategori}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Bulan</label>
                                                        <select class="custom-bul form-control" name="bul" id="bul">
                                                            <option value="">Pilih Bulan</option>
                                                            {{-- <option>All</option> --}}
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
                                                            <tr class="text-center" style="background-color: #880000; color: white">
                                                                <th>#ID</th>
                                                                <th>JURUTEKNIK</th>
                                                                <th>PELAPOR</th>
                                                                <th>TARIKH LAPORAN</th>
                                                                <th>BILIK</th>
                                                                <th>ARAS</th>
                                                                <th>BLOK</th>
                                                                <th>LOKASI</th>
                                                                <th>KATEGORI</th>
                                                                <th>JENIS</th>
                                                                <th>SEBAB</th>
                                                                <th>KUANTITI/UNIT</th>
                                                                <th>CAJ KEROSAKAN</th>
                                                                <th>MAKLUMAT TAMBAHAN</th>
                                                                <th>TAHAP KATEGORI</th>
                                                                <th>TARIKH SERAHAN</th>
                                                                <th>LAPORAN PEMBAIKAN</th>
                                                                <th>JUMLAH KOS</th>
                                                                <th>TARIKH SELESAI</th>
                                                                <th>PENGESAHAN PEMBAIKAN</th>
                                                                <th>STATUS TERKINI</th>
                                                            </tr>
                                                        </thead>
                                                        @if (isset($data) && !empty($data))
                                                            <tbody>
                                                                @foreach ($data as $key => $datas)
                                                                    <tr>
                                                                        <td class="text-center">{{ isset($datas->id_aduan) ? $datas->id_aduan : '--' }}</td>
                                                                        <td class="text-center">{{ isset($datas->juruteknik->name) ? strtoupper($datas->juruteknik->name) : '--' }}</td>
                                                                        <td class="text-center">{{ isset($datas->aduan->nama_pelapor) ? strtoupper($datas->aduan->nama_pelapor) : '--' }}</td>
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
                                                                        <td class="text-center">{{ isset($datas->aduan->jumlah_kos) ? $datas->aduan->jumlah_kos : '--' }}</td>
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
                                        <div class="tab-pane" id="test" role="tabpanel" style="margin-top: -30px"><br>

                                            <form action="{{ route('exportAduan') }}" method="GET" id="form_finds">
                                                <div class="row"><br>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Status</label>
                                                        <select class="custom-status form-control" name="sel_stat" id="sel_stat">
                                                            <option value="">Pilih Status</option>
                                                            @foreach($status as $sel_stat)
                                                                <option value="{{$sel_stat->kod_status}}" {{ $req_stat == $sel_stat->kod_status  ? 'selected' : '' }}>{{strtoupper($sel_stat->nama_status)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Kategori</label>
                                                        <select class="custom-kategori form-control" name="sel_kate" id="sel_kate">
                                                            <option value="">Pilih Kategori</option>
                                                            @foreach($kategori as $sel_kate)
                                                                <option value="{{$sel_kate->kod_kategori}}" {{ $req_kate == $sel_kate->kod_kategori  ? 'selected' : '' }}>{{$sel_kate->nama_kategori}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <label>Bulan</label>
                                                        <select class="custom-bulan form-control" name="sel_bul" id="sel_bul">
                                                            <option value="">Pilih Bulan</option>
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
                                                            <tr class="text-center" style="background-color: #880000; color: white">
                                                                <th>#ID</th>
                                                                <th>PELAPOR</th>
                                                                <th>TARIKH LAPORAN</th>
                                                                <th>BILIK</th>
                                                                <th>ARAS</th>
                                                                <th>BLOK</th>
                                                                <th>LOKASI</th>
                                                                <th>KATEGORI</th>
                                                                <th>JENIS</th>
                                                                <th>SEBAB</th>
                                                                <th>KUANTITI/UNIT</th>
                                                                <th>CAJ KEROSAKAN</th>
                                                                <th>MAKLUMAT TAMBAHAN</th>
                                                                <th>TAHAP KATEGORI</th>
                                                                <th>TARIKH SERAHAN</th>
                                                                <th>LAPORAN PEMBAIKAN</th>
                                                                <th>JUMLAH KOS</th>
                                                                <th>TARIKH SELESAI</th>
                                                                <th>PENGESAHAN PEMBAIKAN</th>
                                                                <th>STATUS TERKINI</th>
                                                            </tr>
                                                        </thead>
                                                        @if (isset($dat) && !empty($dat))
                                                            <tbody>
                                                                @foreach ($dat as $key => $dats)
                                                                    <tr>
                                                                        <td class="text-center">{{ isset($dats->id_aduan) ? $dats->id_aduan : '--' }}</td>
                                                                        <td class="text-center">{{ isset($dats->aduan->nama_pelapor) ? strtoupper($dats->aduan->nama_pelapor) : '--' }}</td>
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
                                                                        <td class="text-center">{{ isset($dats->aduan->jumlah_kos) ? $dats->aduan->jumlah_kos : '--' }}</td>
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
        $('#kategori, #status, #tahap, #bulan, #juruteknik, #stat, #kate, #bul, #sel_stat, #sel_kate, #sel_bul').select2();

        function createDatatable(kategori = null, status = null, tahap = null, bulan = null)
        {
            $('#rep').DataTable().destroy();
            var table = $('#rep').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_aduanexport",
                data: {kategori:kategori, status:status, tahap:tahap, bulan:bulan},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": true,"targets":[28]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nama_pelapor', name: 'nama_pelapor' },
                    { data: 'emel_pelapor', name: 'emel_pelapor' },
                    { data: 'id_pelapor', name: 'id_pelapor' },
                    { data: 'no_tel_pelapor', name: 'no_tel_pelapor' },
                    { data: 'tarikh_laporan', name: 'tarikh_laporan' },
                    { data: 'nama_bilik', name: 'nama_bilik' },
                    { data: 'aras_aduan', name: 'aras_aduan' },
                    { data: 'blok_aduan', name: 'blok_aduan' },
                    { data: 'lokasi_aduan', name: 'lokasi_aduan' },
                    { data: 'kategori_aduan', name: 'kategori_aduan' },
                    { data: 'jenis_kerosakan', name: 'jenis_kerosakan' },
                    { data: 'sebab_kerosakan', name: 'sebab_kerosakan' },
                    { data: 'kuantiti_unit', name: 'kuantiti_unit' },
                    { data: 'caj_kerosakan', name: 'caj_kerosakan' },
                    { data: 'maklumat_tambahan', name: 'maklumat_tambahan' },
                    { data: 'pengesahan_aduan', name: 'pengesahan_aduan' },
                    { data: 'tahap_kategori', name: 'tahap_kategori' },
                    { data: 'tarikh_serahan_aduan', name: 'tarikh_serahan_aduan' },
                    { data: 'laporan_pembaikan', name: 'laporan_pembaikan' },
                    { data: 'bahan', name: 'bahan' }, 
                    { data: 'ak_upah', name: 'ak_upah' },
                    { data: 'ak_bahan_alat', name: 'ak_bahan_alat' },
                    { data: 'jumlah_kos', name: 'jumlah_kos' },
                    { data: 'tarikh_selesai_aduan', name: 'tarikh_selesai_aduan' },
                    { data: 'pengesahan_pembaikan', name: 'pengesahan_pembaikan' },
                    { data: 'catatan_pembaikan', name: 'catatan_pembaikan' },
                    { data: 'status_aduan', name: 'status_aduan' },
                    { data: 'juruteknik', name: 'juruteknik' }, 
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                },
                select : true,
                buttons: [
                    {
                        extend : 'csv',
                        text : '<i class="fal fa-file-excel"></i> Export',
                        exportOptions : {
                            modifier : {
                                order : 'original',  // 'current', 'applied', 'index',  'original'
                                page : 'all',      // 'all',     'current'
                                search : 'none',     // 'none',    'applied', 'removed'
                                // selected: null
                            }
                        }
                    }
                ]
            });
        }

        $('.selectfilter').on('change',function(){
            var kategori = $('#kategori').val();
            var status = $('#status').val();
            var tahap = $('#tahap').val();
            var bulan = $('#bulan').val();
            createDatatable(kategori,status,tahap,bulan);
        });

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
