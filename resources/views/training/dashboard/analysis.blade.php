@extends('layouts.admin')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
            <li class="breadcrumb-item">Training</li>
            <li class="breadcrumb-item active">Training Hour Dashboard</li>
        </ol>

        <div class="subheader">
            <h1 class="subheader-title">
                <i class="subheader-icon fal fa-chart-area"></i> Training <span class="fw-300">Dashboard</span>
            </h1>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500">Training Performance</div>
                    <div class="card-body">
                        <div id="barchart_material" style="height:400px"></div>
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Year', 'Sales', 'Expenses', 'Profit'],
                            ['2015', 1170, 460, 250],
                            ['2016', 660, 1120, 300],
                            ['2017', 1030, 540, 350]
                            ]);

                            var options = {
                            chart: {
                                title: 'Company Performance',
                                subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                            },
                            bars: 'horizontal' // Required for Material Bar Charts.
                            };

                            var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500">Staff Performance</div>
                </div>
                <div style="height:400px">
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500">Training Category</div>
                    <div class="card-body">
                        <div id="piechart" style="height: 400px;"></div>
                        {{-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> --}}
                        <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {

                            var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['Work',     11],
                            ['Eat',      2],
                            ['Commute',  2],
                            ['Watch TV', 2],
                            ['Sleep',    7]
                            ]);

                            var options = {
                            title: 'My Daily Activities'
                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                            chart.draw(data, options);
                        }
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500"> <i class="fal fa-cubes"></i> Top Internal Training</div>
                    <div class="card-body">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Training</th>
                                    <th>Participant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainingRank as $trainRank)
                                    <?php
                                        $color = array('#FFFF7D', '#FFFF97', '#FFFFAC', 'FFFFFF', 'FFFFFF');
                                    ?>
                                    <tr style="background-color:   }}">
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-left">{{ $trainRank->trainings->title }}</td>
                                        <td class="text-center">{{ $trainRank->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500">Top Staff with Most Training</div>
                </div>
                <div style="height:400px">
                </div>
            </div>
             
            
            
        </div>

    </main>
@endsection

@section('script')

<script>
     $(function () {    
        var claim = <?php echo $claim; ?>;
        console.log(claim);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            var data = google.visualization.arrayToDataTable(claim);
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

    var ctx = document.getElementById('offerApplicant').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {  
            labels:  {!!json_encode($chart->labels)!!} ,
            datasets: [
                {
                    label: 'Offered applicant',
                    backgroundColor: ["#efb5ae", "#e2d6bb", "#b0d8ed", "#b0c7ed", "#b7e1e6", "#c2b8e5", "#bbe2d9", "#c0ddc6", "#f6e3d8", "#fcf6f2"],
                    data:  {!! json_encode($chart->dataset)!!} ,
                },
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: "left",
                labels: {
                    fontColor: '#122C4B',
                    fontFamily: "'Muli', sans-serif",
                    padding: 15,
                    boxWidth: 10,
                    fontSize: 14,
                }
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    bottom: 30,
                    top: 30
                }
            }
        }
    });

     
</script>

@endsection
