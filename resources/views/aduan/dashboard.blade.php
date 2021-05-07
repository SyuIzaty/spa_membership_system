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
        /* overflow: auto; */
        visibility: visible;
    }
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
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a style="border: solid 1px; border-radius: 0" class="nav-link active test" href="#pie-chart" data-toggle="tab">Carta Pie</a>
                                </li>
                                <li class="nav-item">
                                    <a style="border: solid 1px; border-radius: 0" class="nav-link" href="#bar-chart" data-toggle="tab">Carta Bar</a>
                                </li>
                                    <a href="/export_aduan" class="btn btn-sm btn-danger ml-auto float-right" style="color: white; padding-top: 8px"><i class="fal fa-eye"></i> Lihat Laporan</a>
                                </ul>
                            </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content p-0">

                                    <div class="chart tab-pane active" id="pie-chart" >
                                        <div class="row">
                                            @role('Operation Admin')
                                            <div class="col-md-6 col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart1" style="height: 500px"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart2" style="height: 500px"></div>
                                                </div>
                                            </div>
                                            @endrole
                                            @role('Technical Staff')
                                            <div class="col-md-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart5" style="height: 500px"></div>
                                                </div>
                                            </div>
                                            @endrole
                                        </div>
                                    </div>

                                    <div class="chart tab-pane" id="bar-chart" >
                                        <div class="row">
                                            @role('Operation Admin')
                                            <div class="col-md-6 col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart3" style="height: 500px"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart4" style="height: 500px"></div>
                                                </div>
                                            </div>
                                            @endrole
                                            @role('Technical Staff')
                                            <div class="col-md-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <div id="chart6" style="height: 500px"></div>
                                                </div>
                                            </div>
                                            @endrole
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                @role('Operation Admin')
                <div class="col-md-12 mt-5">
                    <div class="panel-content">
                        <div class="accordion accordion-outline" id="js_demo_accordion-3">
                            <div class="card">
                                <div class="card-header">
                                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#dJ" aria-expanded="false">
                                        <i class="fal fa-users width-2 fs-xl"></i>
                                        Senarai Juruteknik
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
                                <div id="dJ" class="collapse" data-parent="#dJ">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 100%" id="dJ_list">
                                                <thead class="text-center">
                                                    <tr class="bg-primary-50">
                                                        <td>NO.</td>
                                                        <td>ID</td>
                                                        <td>NAMA</td>
                                                        <td>NO TELEFON</td>
                                                        <td>EMEL</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="hasinput"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Nama"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="No Telefon"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Emel"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($senarai as $dJ)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <td class="text-center">{{ $dJ->id }}</td>
                                                            <td>{{ $dJ->name }}</td>
                                                            <td>{{ isset($dJ->staff->staff_phone) ? $dJ->staff->staff_phone : 'No Data'}}</td>
                                                            <td>{{ isset($dJ->staff->staff_email) ? $dJ->staff->staff_email : 'No Data'}}</td>
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
                @endrole
                @role('Technical Staff')
                <div class="col-md-12 mt-5">
                    <div class="panel-content">
                        <div class="accordion accordion-outline" id="js_demo_accordion-3">
                            <div class="card">
                                <div class="card-header">
                                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#dJ" aria-expanded="false" style="color: maroon">
                                        <i class="fal fa-users width-2 fs-xl"></i>
                                        Senarai Admin Operasi
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
                                <div id="dJ" class="collapse" data-parent="#dJ">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 100%" id="dJ_list">
                                                <thead class="text-center">
                                                    <tr style="background-color: #880000; color:white">
                                                        <td>NO.</td>
                                                        <td>ID</td>
                                                        <td>NAMA</td>
                                                        <td>NO TELEFON</td>
                                                        <td>EMEL</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="hasinput"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Nama"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="No Telefon"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Emel"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($senaraiAdmin as $sA)
                                                        <tr>
                                                            <td class="text-center">{{ $no++ }}</td>
                                                            <td class="text-center">{{ $sA->id }}</td>
                                                            <td>{{ $sA->name }}</td>
                                                            <td>{{ isset($sA->staff->staff_phone) ? $sA->staff->staff_phone : 'No Data'}}</td>
                                                            <td>{{ isset($sA->staff->staff_email) ? $sA->staff->staff_email : 'No Data'}}</td>
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
                @endrole
            </div>
        </div>
    </div>
    
</main>
@endsection

@section('script')

<script>

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
        var aduan = <?php echo $aduan; ?>;
        console.log(aduan);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            var data = google.visualization.arrayToDataTable(aduan);
            var options = {
            title: 'LAPORAN ADUAN KEROSAKAN BERDASARKAN STATUS',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            borderColor: 
                'rgb(135, 48, 14)',
            legend: { position: 'bottom'},
            is3D: true,
            } 
            var chart = new google.visualization.PieChart(document.getElementById('chart1'));
            chart.draw(data, options);
            
        }

    })

    $(function () {
        var list = <?php echo $list; ?>;
        console.log(list);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart2);
        function drawChart2() {
            var data = google.visualization.arrayToDataTable(list);
            var options = {
            title: 'LAPORAN ADUAN KEROSAKAN JURUTEKNIK TERKINI',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            legend: { position: 'bottom'},
            is3D: true,
            } 
            var chart = new google.visualization.PieChart(document.getElementById('chart2'));
            chart.draw(data, options);
        }
    })

    $(function () {
        var juruteknik = <?php echo $juruteknik; ?>;
        console.log(juruteknik);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart5);
        function drawChart5() {
            var data = google.visualization.arrayToDataTable(juruteknik);
            var options = {
            title: 'LAPORAN ADUAN KEROSAKAN JURUTEKNIK',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            legend: { position: 'bottom'},
            is3D: true,
            } 
            var chart = new google.visualization.PieChart(document.getElementById('chart5'));
            chart.draw(data, options);
        }
    })

    $(function () {    
        var aduan = <?php echo $aduan; ?>;
        console.log(aduan);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart3);
        function drawChart3() {
            var data = google.visualization.arrayToDataTable(aduan);
            var options = {
            title: 'LAPORAN ADUAN KEROSAKAN BERDASARKAN STATUS',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            borderColor: 
                'rgb(135, 48, 14)',
            legend: { position: 'bottom'},
            } 
            var chart = new google.visualization.BarChart(document.getElementById('chart3'));
            chart.draw(data, options);
        }

    })

    $(function () {
        var list = <?php echo $list; ?>;
        console.log(list);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart4);
        function drawChart4() {
            var data = google.visualization.arrayToDataTable(list);
            var options = {
            title: 'LAPORAN ADUAN KEROSAKAN JURUTEKNIK TERKINI',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            legend: { position: 'bottom'},
            } 
            var chart = new google.visualization.BarChart(document.getElementById('chart4'));
            chart.draw(data, options);
        }
    })

    $(function () {
        var juruteknik = <?php echo $juruteknik; ?>;
        console.log(juruteknik);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart6);
        function drawChart6() {
            var data = google.visualization.arrayToDataTable(juruteknik);
            var options = {
            title: 'LAPORAN ADUAN KEROSAKAN JURUTEKNIK',
            titleTextStyle: {
                color: '333333',
                fontName: 'Arial',
                fontSize: 16,
            },
            bar: {groupWidth: "80%"},
            legend: { position: 'bottom'},
            } 
            var chart = new google.visualization.BarChart(document.getElementById('chart6'));
            chart.draw(data, options);
        }
    })

</script>
@endsection

