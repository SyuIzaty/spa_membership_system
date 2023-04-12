@extends('layouts.admin')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    .tab-content>.tab-pane {
        height: 1px;
        overflow: hidden;
        display: block;
        visibility: hidden;
    }

    .tab-content>.active {
        height: auto;
        visibility: visible;
    }

    .td-green td {background-color: rgb(67, 250, 67);}
    .td-yellow td {background-color: rgb(139, 255, 139);}
    .td-red td {background-color: rgb(176, 245, 176);}
</style>
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        DASHBOARD E-ADUAN <small>Info </small><span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-md-2 float-right" style="font-size: 12px">
                                    <form action="{{ route('dashAduan') }}" method="GET" id="form_find">
                                        <select class="selectfilter form-control" name="year" id="year">
                                            @foreach ($years as $yrs)
                                                <option value="{{ $yrs->year }}" {{ $selectedYear == $yrs->year ? 'selected' : '' }}>{{ $yrs->year }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> JUMLAH ADUAN MENGIKUT KATEGORI {{$selectedYear}}</div>
                                                <div class="card-body">
                                                    <div id="chart1" style="height: 500px"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> JUMLAH ADUAN TERKUMPUL JURUTEKNIK {{$selectedYear}}</div>
                                                <div class="card-body">
                                                    <div id="chart2" style="height: 500px"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary-500">
                                                    <i class="fal fa-adjust width-2 fs-xl"></i>
                                                    KEDUDUKAN 5 STAF TERTINGGI {{$selectedYear}}
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">
                                                            <thead>
                                                                <tr class="text-center bg-primary-50">
                                                                    <th>KEDUDUKAN</th>
                                                                    <th>JURUTEKNIK</th>
                                                                    <th>JUMLAH ADUAN SELESAI</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($rank as $ranks)
                                                                    <tr class="
                                                                        @if($loop->iteration == 1)
                                                                            {{ 'td-green' }}
                                                                        @elseif($loop->iteration == 2)
                                                                            {{ 'td-yellow' }}
                                                                        @elseif($loop->iteration == 3)
                                                                            {{ 'td-red' }}
                                                                        @endif
                                                                    ">
                                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                                        <td class="text-left">{{ $ranks->juruteknik->name }}</td>
                                                                        <td class="text-center">{{ $ranks->total }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-primary-500">
                                                    <i class="fal fa-adjust width-2 fs-xl"></i>
                                                    JUMLAH ADUAN MENGIKUT STATUS {{$selectedYear}}
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-xl-6">
                                                            <div class="p-3 rounded overflow-hidden position-relative text-black mb-g" style="border-style:dotted">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{\App\Aduan::whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->where(DB::raw('YEAR(cms_aduan.tarikh_laporan)'), '=', $selectedYear)->count()}}
                                                                    <small class="m-0 l-h-n">FASILITI</small>
                                                                </h3>
                                                                <i class="fal fa-cog position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-xl-6">
                                                            <div class="p-3 rounded overflow-hidden position-relative text-black mb-g" style="border-style:dotted">
                                                                <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                    {{\App\Aduan::whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->where(DB::raw('YEAR(cms_aduan.tarikh_laporan)'), '=', $selectedYear)->count()}}
                                                                    <small class="m-0 l-h-n">IITU</small>
                                                                </h3>
                                                                <i class="fal fa-cog position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" style="width: 100%; white-space: nowrap">
                                                            <thead>
                                                                <tr class="text-center bg-primary-50">
                                                                    <th>STATUS</th>
                                                                    <th>JUMLAH TERKUMPUL</th>
                                                                    <th>STAF</th>
                                                                    <th>PELAJAR</th>
                                                                    <th>PENGGUNA LUAR</th>
                                                                </tr>
                                                                @foreach(\App\StatusAduan::all() as $all)
                                                                <?php
                                                                    $cnt = \App\Aduan::where('status_aduan', $all->kod_status)->where(DB::raw('YEAR(cms_aduan.tarikh_laporan)'), '=', $selectedYear)->count();

                                                                    $user = \App\User::where('category', 'STF')->pluck('id');

                                                                    $cnt_stf = \App\Aduan::whereIn('id_pelapor',$user)->where('status_aduan', $all->kod_status)->where(DB::raw('YEAR(cms_aduan.tarikh_laporan)'), '=', $selectedYear)->count();

                                                                    $users = \App\User::where('category', 'STD')->pluck('id');

                                                                    $cnt_std = \App\Aduan::whereIn('id_pelapor',$users)->where('status_aduan', $all->kod_status)->where(DB::raw('YEAR(cms_aduan.tarikh_laporan)'), '=', $selectedYear)->with(['pelapor_pelajar'])->count();

                                                                    $merge = \App\User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

                                                                    $cnt_otr = \App\Aduan::whereNotIn('id_pelapor',$merge)->where('status_aduan', $all->kod_status)->where(DB::raw('YEAR(cms_aduan.tarikh_laporan)'), '=', $selectedYear)->with(['pelapor_pelajar'])->count();
                                                                ?>

                                                                    <tr @if($all->kod_status == 'BS' || $all->kod_status == 'DJ') style="background-color: red; color:white" @endif>
                                                                        <td>{{ $all->kod_status }} - {{ $all->nama_status}}</td>
                                                                        <td class="text-center">{{$cnt ?? '0'}}</td>
                                                                        <td class="text-center">{{$cnt_stf ?? '0'}}</td>
                                                                        <td class="text-center">{{$cnt_std ?? '0'}}</td>
                                                                        <td class="text-center">{{$cnt_otr ?? '0'}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                <tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title" data-toggle="collapse" data-target="#dJ" aria-expanded="true">
                                                <i class="fal fa-users width-2 fs-xl"></i>
                                                SENARAI JURUTEKNIK
                                                <span class="ml-auto">
                                                    <span class="collapsed-reveal">
                                                        <i class="fal fa-minus fs-xl"></i>
                                                    </span>
                                                    <span class="collapsed-hidden">
                                                        <i class="fal fa-plus fs-xl"></i>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                        <div id="dJ" class="collapse show" data-parent="#dJ">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="width: 100%" id="dJ_list">
                                                        <thead class="text-center">
                                                            <tr class="bg-primary-50">
                                                                <th>ID</th>
                                                                <th>NAMA</th>
                                                                <th>NO TELEFON</th>
                                                                <th>EMEL</th>
                                                                <th>JABATAN</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Nama"></td>
                                                                <td class="hasinput"><input type="text" class="form-control" placeholder="No Telefon"></td>
                                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Emel"></td>
                                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Jabatan"></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($senarai as $dJ)
                                                                <?php $jab = \App\Staff::where('staff_id', $dJ->id)->first() ?>
                                                                <tr>
                                                                    <td class="text-center">{{ $dJ->id }}</td>
                                                                    <td>{{ $dJ->name }}</td>
                                                                    <td>{{ isset($dJ->staff->staff_phone) ? $dJ->staff->staff_phone : '--'}}</td>
                                                                    <td>{{ isset($dJ->staff->staff_email) ? $dJ->staff->staff_email : '--'}}</td>
                                                                    <td>
                                                                        @if(isset($jab->staff_code))
                                                                            @if($jab->staff_code == 'IITU')
                                                                                IITU
                                                                            @endif
                                                                            @if($jab->staff_code == 'OFM')
                                                                                FASILITI
                                                                            @endif
                                                                        @else
                                                                            --
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('script')
<script>

    $(document).ready(function()
    {
        $("#year").change(function(){
            $("#form_find").submit();
        })
        $('#year').select2();
    });

    $(document).ready(function() {

        $('#dJ_list thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#dJ_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(function () {
        var list = <?php echo $list; ?>;

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart2);
        function drawChart2() {
            var data = google.visualization.arrayToDataTable(list);
            var options = {
                pieHole: 0.4,
            }
            var chart = new google.visualization.PieChart(document.getElementById('chart2'));
            chart.draw(data, options);
        }
    })

    $(function () {
        var category = <?php echo $category; ?>;

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            var data = google.visualization.arrayToDataTable(category);
            var options = {
                pieHole: 0.4,
            }
            var chart = new google.visualization.PieChart(document.getElementById('chart1'));
            chart.draw(data, options);

        }
    })

</script>
@endsection

