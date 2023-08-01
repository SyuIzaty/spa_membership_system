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
                                <div class="col-md-6 mt-3">
                                    <label>Kategori</label>
                                    <select class="selectfilter form-control" name="kategori" id="kategori">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($kategori as $kat)
                                            <option value="{{$kat->kod_kategori}}" {{ $request->kategori == $kat->id  ? 'selected' : '' }}>{{strtoupper($kat->nama_kategori)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Status</label>
                                    <select class="selectfilter form-control" name="status" id="status">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($status as $stats)
                                            <option value="{{$stats->kod_status}}" <?php if($request->status == $stats->kod_status) echo "selected"; ?> >{{$stats->nama_status}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Tahap</label>
                                    <select class="selectfilter form-control" name="tahap" id="tahap">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($tahap as $thp)
                                            <option value="{{$thp->kod_tahap}}" <?php if($request->tahap == $thp->kod_tahap) echo "selected"; ?> >{{strtoupper($thp->jenis_tahap)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Tahun</label>
                                    <select class="selectfilter form-control" name="tahun" id="tahun">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($tahun as $tah)
                                            <option value="{{$tah->year}}" <?php if($request->tahun == $tah->year) echo "selected"; ?> >{{$tah->year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Bulan</label>
                                    <select class="selectfilter form-control" name="bulan" id="bulan">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($bulan as $bul)
                                            <option value="{{$bul->month}}" <?php if($request->bulan == $bul->month) echo "selected"; ?> >{{$bul->month}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Pelapor</label>
                                    <select class="selectfilter form-control" name="pelapor" id="pelapor">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($pelapor as $pel)
                                            <option value="{{$pel->id_pelapor}}" {{ $request->pelapor == $pel->id_pelapor  ? 'selected' : '' }}>{{$pel->id_pelapor}} - {{ \App\Aduan::where('id_pelapor', $pel->id_pelapor)->first()->nama_pelapor ?? 'N/A' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="rep">
                                    <thead>
                                        <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                            <th>TIKET ID</th>
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
                                            <th>STATUS TERKINI</th>
                                            <th>PENGESAHAN PEMBAIKAN</th>
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
    </main>
@endsection

@section('script')

<style>
    .buttons-excel {
        color: white;
        background-color: #606FAD;
        float: right;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

<script >

    $(document).ready(function()
    {
        $('#tahap, #status, #kategori, #bulan, #tahun, #pelapor').select2();

        function createDatatable(tahap = null, status = null, kategori = null, bulan = null, tahun = null, pelapor = null)
        {
            $('#rep').DataTable().destroy();
            var table = $('#rep').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_aduanexport",
                data: {tahap:tahap, status:status, kategori:kategori, bulan:bulan, tahun:tahun, pelapor:pelapor},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": false,"targets":[20]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'juruteknik', name: 'juruteknik' },
                    { data: 'nama_pelapor', name: 'nama_pelapor' },
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
                    { data: 'tahap_kategori', name: 'tahap_kategori' },
                    { data: 'tarikh_serahan_aduan', name: 'tarikh_serahan_aduan' },
                    { data: 'laporan_pembaikan', name: 'laporan_pembaikan' },
                    { data: 'jumlah_kos', name: 'jumlah_kos' },
                    { data: 'tarikh_selesai_aduan', name: 'tarikh_selesai_aduan' },
                    { data: 'status_aduan', name: 'status_aduan' },
                    { data: 'pengesahan_pembaikan', name: 'pengesahan_pembaikan' },
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                },
                select : true,
                buttons: [
                    {
                        extend: 'excel',
                        className: 'buttons-excel',
                        text: '<i class="fal fa-file-excel"></i> Export',
                        exportOptions: {
                            modifier: {
                                page: 'all',
                                search: 'none',
                            }
                        }
                    }
                ]
            });
        }

        $('.selectfilter').on('change',function(){
            var tahap = $('#tahap').val();
            var status = $('#status').val();
            var kategori = $('#kategori').val();
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            var pelapor = $('#pelapor').val();
            createDatatable(tahap,status,kategori,bulan,tahun,pelapor);
        });

    });
</script>
@endsection
