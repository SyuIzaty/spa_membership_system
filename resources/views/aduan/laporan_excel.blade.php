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
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="rep">
                                            <thead>
                                                <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                                    <th>#TIKET</th>
                                                    <th>PELAPOR</th>
                                                    <th>EMEL</th>
                                                    <th>NO_TELEFON</th>
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
                                                    <th>PENGESAHAN_ADUAN</th>
                                                    <th>TAHAP_KATEGORI</th>
                                                    <th>TARIKH_SERAHAN</th>
                                                    <th>LAPORAN_PEMBAIKAN</th>
                                                    <th>BAHAN/ALATGANTI</th>
                                                    <th>KOS_UPAH</th>
                                                    <th>KOS_BAHAN</th>
                                                    <th>JUMLAH_KOS</th>
                                                    <th>TARIKH_SELESAI</th>
                                                    <th>PENGESAHAN_PEMBAIKAN</th>
                                                    <th>CATATAN_PEMBAIKAN</th>
                                                    <th>STATUS</th>
                                                    <th>SEBAB_PEMBATALAN</th>
                                                    <th>PENUKARAN_STATUS</th>
                                                    <th>JURUTEKNIK_BERTUGAS</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
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
<script>

    $(document).ready(function()
    {
        $('#kategori, #status, #tahap, #bulan').select2();

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
                    { data: 'sebab_pembatalan', name: 'sebab_pembatalan' }, 
                    { data: 'tukar_status', name: 'tukar_status' }, 
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

    });
</script>
@endsection
