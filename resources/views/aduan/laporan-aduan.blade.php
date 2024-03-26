@extends('layouts.admin')

@section('content')
    <style>
        .swal2-container {
            z-index: 10000;
        }

        .dataTables_wrapper .dt-buttons {
            float: right;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file'></i> PENGURUSAN LAPORAN ADUAN
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Laporan Keseluruhan</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                </button>
                                <div class="d-flex align-items-center">
                                    <div class="alert-icon width-8">
                                        <span class="icon-stack icon-stack-md">
                                            <i class="base-2 icon-stack-3x color-danger-400"></i>
                                            <i class="base-10 text-white icon-stack-1x"></i>
                                            <i class="fal fa-info-circle color-danger-800 icon-stack-2x"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1 pl-1">
                                        <ul class="mb-0 pb-0">
                                            <li>Untuk menjana laporan, pengguna dikehendaki memilih salah satu pilihan di bawah.</li>
                                            <li>Proses penjanaan laporan mungkin mengambil masa disebabkan pemprosesan data.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Tahun : </label>
                                    <select class="form-control tahun selectTahun" name="tahun" id="tahun">
                                        <option value="" selected>SEMUA</option>
                                        @foreach($senarai_tahun as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Bulan : </label>
                                    <select class="form-control bulan selectBulan" name="bulan" id="bulan">
                                        <option value="" selected>SEMUA</option>
                                        @foreach($senarai_bulan as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Kategori Aduan : </label>
                                    <select class="form-control kategori selectKategori" name="kategori" id="kategori">
                                        <option value="" selected>SEMUA</option>
                                        @foreach ($senarai_kategori as $kategori)
                                            <option value="{{ $kategori->kod_kategori }}">{{ $kategori->nama_kategori }}</option>
                                        @endforeach
                                    </select>

                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Jenis Kerosakan : </label>
                                    <select class="form-control jenis selectJenis" name="jenis" id="jenis">
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Sebab Kerosakan : </label>
                                    <select class="form-control sebab selectSebab" name="sebab" id="sebab">
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Tahap : </label>
                                    <select class="form-control tahap selectTahap" name="tahap" id="tahap">
                                        <option value="" selected>SEMUA</option>
                                        @foreach ($senarai_tahap as $tahap)
                                            <option value="{{ $tahap->kod_tahap }}">{{ $tahap->jenis_tahap }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Kategori Pengadu : </label>
                                    <select class="form-control kategoriPengadu selectKategoriPengadu" name="kategoriPengadu" id="kategoriPengadu">
                                        <option value="" selected>SEMUA</option>
                                        <option value="STF">STAF</option>
                                        <option value="STD">PELAJAR</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Pengadu : </label>
                                    <select class="form-control pengadu selectPengadu" name="pengadu" id="pengadu">
                                    </select>
                                </div>
                                @can('view complaint - admin')
                                    <div class="col-md-3 col-sm-12 mb-4">
                                        <label>Juruteknik : </label>
                                        <select class="form-control juruteknik selectJuruteknik" name="juruteknik" id="juruteknik">
                                            <option value="" selected>SEMUA</option>
                                            @foreach ($senarai_juruteknik as $juruteknik)
                                                <option value="{{ $juruteknik->staff_id }}">{{ $juruteknik->staff_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endcan
                                <div class="col-md-3 col-sm-12 mb-4">
                                    <label> Status : </label>
                                    <select class="form-control status selectStatus" name="status[]" id="status" multiple="multiple">
                                        @foreach ($senarai_status->whereNotIn('kod_status', ['AB']) as $status)
                                            <option value="{{ $status->kod_status }}">{{ strtoupper($status->nama_status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="report">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>TIKET</th>
                                            <th>PENGADU</th>
                                            <th>LOKASI</th>
                                            <th>BLOK</th>
                                            <th>ARAS</th>
                                            <th>NO/NAMA BILIK</th>
                                            <th>KATEGORI ADUAN</th>
                                            <th>JENIS KEROSAKAN</th>
                                            <th>SEBAB KEROSAKAN</th>
                                            <th>TAHAP ADUAN</th>
                                            <th>TARIKH ADUAN</th>
                                            <th>TARIKH SELESAI</th>
                                            <th>STATUS</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <a href="#" id="buttonfull" class="btn btn-primary float-right" style="margin-top: 15px; margin-bottom: 15px;">
                                <i class="fal fa-file-excel"></i> Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>

        $('#tahun, #bulan, #kategori, #jenis, #sebab, #status, #tahap, #kategoriPengadu, #pengadu, #juruteknik').select2();

        $(document).ready(function() {
            var table;

            function initializeDataTable(params) {
                table = $('#report').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    searching: false,
                    ajax: {
                        url: "/data-laporan-aduan",
                        type: 'POST',
                        data: params,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { className: 'text-center', data: 'id', name: 'id' },
                        { className: 'text-center', data: 'nama_pelapor', name: 'nama_pelapor' },
                        { className: 'text-center', data: 'lokasi_aduan', name: 'lokasi_aduan' },
                        { className: 'text-center', data: 'blok_aduan', name: 'blok_aduan' },
                        { className: 'text-center', data: 'aras_aduan', name: 'aras_aduan' },
                        { className: 'text-center', data: 'nama_bilik', name: 'nama_bilik' },
                        { className: 'text-center', data: 'kategori_aduan', name: 'kategori.nama_kategori' },
                        { className: 'text-center', data: 'jenis_kerosakan', name: 'jenis.jenis_kerosakan' },
                        { className: 'text-center', data: 'sebab_kerosakan', name: 'sebab.sebab_kerosakan' },
                        { className: 'text-center', data: 'tahap_kategori', name: 'tahap.jenis_tahap' },
                        { className: 'text-center', data: 'tarikh_laporan', name: 'tarikh_laporan' },
                        { className: 'text-center', data: 'tarikh_selesai_aduan', name: 'tarikh_selesai_aduan' },
                        { className: 'text-center', data: 'status_aduan', name: 'status.nama_status' }
                    ],
                    orderCellsTop: true,
                    "order": [
                        [0, "asc"]
                    ],
                    "initComplete": function(settings, json) {},
                    dom: 'frtipB',
                    buttons: [{
                        extend: 'excel',
                        text: 'Report',
                        className: 'btn btn-danger',
                        title: 'Laporan Aduan'
                    }],
                });
            }

            initializeDataTable({}); // Pass an empty object initially

            function updateDataTable(params) {
                table.destroy();
                initializeDataTable(params);
            }

            $('#tahun, #bulan, #kategori, #jenis, #sebab, #status, #tahap, #kategoriPengadu, #pengadu, #juruteknik').on('change', function () {
                var params = {
                    tahun: $('#tahun').val(),
                    bulan: $('#bulan').val(),
                    kategori: $('#kategori').val(),
                    jenis: $('#jenis').val(),
                    sebab: $('#sebab').val(),
                    status: $('#status').val(),
                    tahap: $('#tahap').val(),
                    kategoriPengadu: $('#kategoriPengadu').val(),
                    pengadu: $('#pengadu').val(),
                    juruteknik: $('#juruteknik').val()
                };

                if (Object.values(params).some(val => val !== '' && (Array.isArray(val) ? val.length > 0 : true))) {
                    $('#buttonfull').removeAttr('disabled');
                    $('#buttonfull').attr('href', "/laporan-aduan-excel/" + Object.values(params).map(val => val ? (Array.isArray(val) ? val.join(',') : val) : 'null').join('/'));
                } else {
                    $('#buttonfull').attr('disabled', 'disabled');
                    $('#buttonfull').removeAttr('href');
                }

                updateDataTable(params);
            });
        });

        $(document).ready(function () {
            var selectKategori = $('.selectKategori');
            var selectJenis = $('.selectJenis');

            selectKategori.on('change', function () {
                var kodKategori = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/cari-jenis',
                    data: { id: kodKategori },
                    success: function (data) {
                        selectJenis.empty();
                        selectJenis.append($('<option></option>').attr('value', '').text('SEMUA'));

                        $.each(data, function (key, value) {
                            selectJenis.append($('<option></option>').attr('value', value.id).text(value.jenis_kerosakan.toUpperCase()));
                        });

                        if (kodKategori) {
                            selectJenis.prop('disabled', false);
                        } else {
                            selectJenis.prop('disabled', true);
                        }
                    }
                });
            });

            selectJenis.prop('disabled', true);
        });

        $(document).ready(function () {
            var selectKategori = $('.selectKategori');
            var selectSebab = $('.selectSebab');

            selectKategori.on('change', function () {
                var kodKategori = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/cari-sebab',
                    data: { id: kodKategori },
                    success: function (data) {
                        selectSebab.empty();
                        selectSebab.append($('<option></option>').attr('value', '').text('SEMUA'));

                        $.each(data, function (key, value) {
                            selectSebab.append($('<option></option>').attr('value', value.id).text(value.sebab_kerosakan.toUpperCase()));
                        });

                        if (kodKategori) {
                            selectSebab.prop('disabled', false);
                        } else {
                            selectSebab.prop('disabled', true);
                        }
                    }
                });
            });

            selectSebab.prop('disabled', true);
        });

        $(document).ready(function () {
            var selectKategoriPengadu = $('.selectKategoriPengadu');
            var selectPengadu = $('.selectPengadu');

            selectKategoriPengadu.on('change', function () {
                var kodKategori = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/cari-pengadu',
                    data: { id: kodKategori },
                    success: function (data) {
                        selectPengadu.empty();
                        selectPengadu.append($('<option></option>').attr('value', '').text('SEMUA'));

                        $.each(data, function (key, value) {
                            selectPengadu.append($('<option></option>').attr('value', value.id).text(value.name.toUpperCase()));
                        });

                        if (kodKategori) {
                            selectPengadu.prop('disabled', false);
                        } else {
                            selectPengadu.prop('disabled', true);
                        }
                    }
                });
            });

            selectPengadu.prop('disabled', true);
        });

    </script>
@endsection
