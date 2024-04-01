
@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content">

    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
        <li class="breadcrumb-item">E-Aduan Fasiliti</li>
        <li class="breadcrumb-item active">Fasiliti <i>Dashboard</i></li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span>{{ date('d/m/Y', strtotime(now())) }}</span></li>
    </ol>

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-chart-area"></i> <i>Dashboard</i> <span class="fw-300">Analisis</span>
        </h1>
    </div>

    <div class="col-lg-12 sortable-grid ui-sortable">
        <div class="row">
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-primary-400 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $aduan->count() }}
                            <small class="m-0 l-h-n">Jumlah Aduan Keseluruhan</small>
                        </h3>
                    </div>
                    <i class="fal fa-cog position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-primary-200 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            @php $idStaf = \App\User::select('id')->where('category', 'STF')->pluck('id')->toArray(); @endphp
                            {{ $aduan->whereIn('id_pelapor', $idStaf)->whereNull('deleted_at')->count() }}
                            <small class="m-0 l-h-n">Jumlah Aduan Staf</small>
                        </h3>
                    </div>
                    <i class="fal fa-globe position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-primary-100 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            @php $idPelajar = \App\User::select('id')->where('category', 'STD')->pluck('id')->toArray(); @endphp
                            {{ $aduan->whereIn('id_pelapor', $idPelajar)->whereNull('deleted_at')->count() }}
                            <small class="m-0 l-h-n">Jumlah Aduan Pelajar</small>
                        </h3>
                    </div>
                    <i class="fal fa-book position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="p-3 bg-danger-500 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{ $aduan->where('tarikh_laporan', now())->count() }}
                            <small class="m-0 l-h-n">Jumlah Aduan {{ date('d/m/Y', strtotime(now())) }}</small>
                        </h3>
                    </div>
                    <i class="fal fa-list position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>
        <div class="card col-md-2 col-sm-12 p-2 text-center">
            <span><i class="fal fa-filter"></i><b> TAPISAN</b></span>
        </div>

        <div class="card mb-2">
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-2 col-sm-12 mb-2">
                        <label>Tahun :</label>
                        <select id="filtTahun" name="filtTahun" class="filtTahun selectfilter form-control">
                            <option value="" selected>SEMUA</option>
                            @foreach($senarai_tahun as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2">
                        <label>Bulan :</label>
                        <select id="filtBulan" name="filtBulan" class="filtBulan selectfilter form-control">
                            <option value="" selected>SEMUA</option>
                            @foreach($senarai_bulan as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2">
                        <label>Kategori Aduan :</label>
                        <select id="filtKategori" name="filtKategori" class="filtKategori selectfilter form-control">
                            <option value="" selected>SEMUA</option>
                            @foreach ($senarai_kategori as $kategori)
                                <option value="{{ $kategori->kod_kategori }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-2">
                        <label>Jenis Kerosakan :</label>
                        <select id="filtJenis" name="filtJenis[]" class="filtJenis selectfilter form-control" multiple="multiple">
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-2">
                        <label>Sebab Kerosakan :</label>
                        <select id="filtSebab" name="filtSebab[]" class="filtSebab selectfilter form-control" multiple="multiple">
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2">
                        <label>Tahap :</label>
                        <select id="filtTahap" name="filtTahap" class="filtTahap selectfilter form-control">
                            <option value="" selected>SEMUA</option>
                            @foreach ($senarai_tahap as $tahap)
                                <option value="{{ $tahap->kod_tahap }}">{{ $tahap->jenis_tahap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2">
                        <label>Kategori Pengadu :</label>
                        <select id="filtKategoriPengadu" name="filtKategoriPengadu" class="filtKategoriPengadu selectfilter form-control">
                            <option value="" selected>SEMUA</option>
                            <option value="STF">STAF</option>
                            <option value="STD">PELAJAR</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2">
                        <label>Juruteknik :</label>
                        <select id="filtJuruteknik" name="filtJuruteknik" class="filtJuruteknik selectfilter form-control">
                            <option value="" selected>SEMUA</option>
                            @foreach ($senarai_juruteknik as $juruteknik)
                                <option value="{{ $juruteknik->staff_id }}">{{ $juruteknik->staff_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12 mb-2">
                        <label>Pengesahan Pengadu :</label>
                        <select id="filtPengesahanPengadu" name="filtPengesahanPengadu" class="filtPengesahanPengadu selectfilter form-control">
                            <option value="" selected>SEMUA</option>
                            <option value="Y">DISAHKAN</option>
                            <option value="N">BELUM DISAHKAN</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-2">
                        <label>Status :</label>
                        <select id="filtStatus" name="filtStatus[]" class="filtStatus selectfilter form-control" multiple="multiple">
                            @foreach ($senarai_status->whereNotIn('kod_status', ['AB']) as $status)
                                <option value="{{ $status->kod_status }}">{{ strtoupper($status->nama_status) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2 aduanPanelOne">
            <div class="card-header bg-secondary-500"><i class="fal fa-chart-bar"></i> Ringkasan Kategori & Juruteknik</div>
            <div class="card-body m-4">
                <div class="row">
                    <div class="table-responsive">
                        <div class="col-12" style="height: 400px">
                            <canvas id="juruteknikChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2 aduanPanelTwo">
            <div class="card-header bg-secondary-500"><i class="fal fa-cubes"></i> Ringkasan Kategori & Status</div>
            <div class="card-body m-4">
                <div class="row">
                    <div class="table-responsive">
                        <table id="aduanRingkasan" class="table table-bordered table-hover table-striped w-100" style="white-space: nowrap">
                            <thead id="aduanKategoriHeader"></thead>
                            <tbody id="aduanRingkasanBody"></tbody>
                            <tfoot id="aduanRingkasanFooter"></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@endsection

@section('script')

<script>

    $('#filtTahun, #filtBulan, #filtKategori, #filtJenis, #filtSebab, #filtTahap, #filtKategoriPengadu, #filtJuruteknik, #filtStatus, #filtPengesahanPengadu').select2();

    $(document).ready(function () {
        function updateAduanRingkasan() {
            var filters = {
                tahun: $('#filtTahun').val(),
                bulan: $('#filtBulan').val(),
                kategori: $('#filtKategori').val(),
                jenis: $('#filtJenis').val(),
                sebab: $('#filtSebab').val(),
                tahap: $('#filtTahap').val(),
                kategoriPengadu: $('#filtKategoriPengadu').val(),
                juruteknik: $('#filtJuruteknik').val(),
                status: $('#filtStatus').val(),
                pengesahanPengadu: $('#filtPengesahanPengadu').val(),
            };

            $.ajax({
                type: 'GET',
                url: '/kemaskini-aduan-ringkasan',
                data: filters,
                success: function (data) {
                    $('#aduanKategoriHeader').html(data.kategoriData);
                    $('#aduanRingkasanBody').html(data.aduanData);
                    $('#aduanRingkasanFooter').html(data.jumlahData);
                },
                error: function (error) {
                    console.error('Error fetching summary data:', error);
                }
            });
        }

        $('.selectfilter').change(function () {
            updateAduanRingkasan();
        });

        updateAduanRingkasan();
    });

    $(document).ready(function () {
        var myChart;

        function updateJuruteknikChart() {
            var filters = {
                tahun: $('#filtTahun').val(),
                bulan: $('#filtBulan').val(),
                kategori: $('#filtKategori').val(),
                jenis: $('#filtJenis').val(),
                sebab: $('#filtSebab').val(),
                tahap: $('#filtTahap').val(),
                kategoriPengadu: $('#filtKategoriPengadu').val(),
                juruteknik: $('#filtJuruteknik').val(),
                status: $('#filtStatus').val(),
                pengesahanPengadu: $('#filtPengesahanPengadu').val(),
            };

            if (myChart) {
                myChart.destroy();
            }

            $.ajax({
                type: 'GET',
                url: '/kemaskini-aduan-juruteknik',
                data: filters,
                success: function (data) {
                    fetchJuruteknikChartData(data);
                },
                error: function (error) {
                    console.error('Error fetching condition summary data:', error);
                }
            });
        }

        $('.selectfilter').change(function () {
            updateJuruteknikChart();
        });

        updateJuruteknikChart();

        function fetchJuruteknikChartData(data) {
            var ctx = document.getElementById('juruteknikChart').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: data.labels,
                    datasets: data.datasets
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true
                    },
                    tooltips: {
                        enabled: true
                    },
                    scales: {
                        xAxes: [{
                            stacked: true,
                            barPercentage: 0.4
                        }],
                        yAxes: [{
                            stacked: true,
                            barPercentage: 0.4
                        }]
                    }
                }
            });
        }
    });

    $(document).ready(function () {
        var filtKategori = $('.filtKategori');
        var filtJenis = $('.filtJenis');

        filtKategori.on('change', function () {
            var kodKategori = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/cari-jenis',
                data: { id: kodKategori },
                success: function (data) {
                    filtJenis.empty();

                    $.each(data, function (key, value) {
                        filtJenis.append($('<option></option>').attr('value', value.id).text(value.jenis_kerosakan.toUpperCase()));
                    });

                    if (kodKategori) {
                        filtJenis.prop('disabled', false);
                    } else {
                        filtJenis.prop('disabled', true);
                    }
                }
            });
        });

        filtJenis.prop('disabled', true);
    });

    $(document).ready(function () {
        var filtKategori = $('.filtKategori');
        var filtSebab = $('.filtSebab');

        filtKategori.on('change', function () {
            var kodKategori = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/cari-sebab',
                data: { id: kodKategori },
                success: function (data) {
                    filtSebab.empty();

                    $.each(data, function (key, value) {
                        filtSebab.append($('<option></option>').attr('value', value.id).text(value.sebab_kerosakan.toUpperCase()));
                    });

                    if (kodKategori) {
                        filtSebab.prop('disabled', false);
                    } else {
                        filtSebab.prop('disabled', true);
                    }
                }
            });
        });

        filtSebab.prop('disabled', true);
    });

</script>

@endsection
