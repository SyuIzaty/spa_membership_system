@extends('layouts.admin')

@section('content')
<style>
    .td-green td {background-color: rgb(67, 250, 67);}
    .td-yellow td {background-color: rgb(139, 255, 139);}
    .td-red td {background-color: rgb(176, 245, 176);}
</style>
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
                    <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Training Category {{ $year }}</div>
                    <div class="card-body">

                        <?php
                            $data_year = \App\TrainingHourYear::select('year')->orderBy('year', 'desc')->limit(3)->pluck('year')->toArray();
                            $cht = new \App\TrainingHourYear;
                            $cht->dataset = (array_values($data_year)); 

                            $data_categories = \App\TrainingCategory::select('id','category_name')->groupBy('id')->pluck('id','category_name')->toArray();
                            $data_category = \App\TrainingCategory::select('id', 'category_name')->groupBy('id')->get();
                            $listTotal = [];

                            foreach($data_category as $key => $data_cat) {
                                $datas = \App\TrainingCategory::where('id', $data_cat['id'])->first();

                                $total = 0;
                                foreach($data_cat->claims as $list) {
                                    $total = $list->where('category', $data_cat['id'])->get()->count();
                                }
                                $listTotal[] = $total;
                            }
                            // dd($listTotal);

                            $chts = new \App\TrainingCategory;
                            $chts->labels = (array_keys($data_categories));
                            $chts->dataset = (array_values($listTotal)); 

                            $namelist = collect(['Category' => $chts->labels, 'Total' => $chts->dataset]);

                            // $namelist = array();
                            // $namelist = array_merge($namelist, ['Category' => $chts->labels, 'Total' => $chts->dataset]); //add to our array
                            // $grouped = collect($namelist);
                            // dd($grouped);
                        ?>

                        <canvas id="chartJSContainer" width="600" height="250"></canvas>
                        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
                        <script>
                            var colors = [
                                '#FF0000', '#0000FF', '#0000FF', '#0000FF', '#0000FF'
                            ];
    
                            var data = {
                                loans: [4],
                                pays: [3]
                                 
                                // {!!json_encode($chts->labels)!!} : {!!json_encode($chts->dataset)!!}
                            };
    
                            function getChartData(data) {
                            let chartData = {
                                labels: {!!json_encode($cht->dataset)!!},
                                datasets: [],
                                options: {
                                scales: {
                                    yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        precision: 0
                                    }
                                    }]
                                }
                                }
                            };
                            
                            Object.keys(data).forEach(function(label, index) {  
                                chartData.datasets.push({
                                    label: label,
                                data: data[label],
                                backgroundColor: colors[index]
                                });
                            });
    
                            return chartData;
                            }
    
                            var options = {
                            type: 'bar',
                            data: getChartData(data),
                            options: {
                                scales: {
                                    yAxes: [{
                                    ticks: {
                                                beginAtZero: true,
                                    precision: 0
                                    }
                                }]
                                }
                            }
                            }
    
                            var ctx = document.getElementById('chartJSContainer').getContext('2d');
                            new Chart(ctx, options);
    
                        </script>

                        {{-- <div id="barchart_material" style="height:400px"></div>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages':['bar']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General',
                                    'Western', 'Literature', { role: 'annotation' } ],
                                    ['2021', 10, 24, 20, 32, 18, 5, ''],
                                    ['2020', 16, 22, 23, 30, 16, 9, ''],
                                    ['2019', 28, 19, 29, 30, 12, 13, '']
                                ]);

                                var options = {
                                    width: 1000,
                                    height: 400,
                                    legend: { position: 'top', maxLines: 3 },
                                    bar: { groupWidth: '75%' },
                                    isStacked: true
                                };

                                var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                                chart.draw(data, google.charts.Bar.convertOptions(options));
                            }
                        </script> --}}
                        
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Staff Performance {{ $year }}</div>
                        <div class="card-body">
                            <?php 
                                $complete = \App\TrainingHourTrail::where('status', '4')->where('year', $year)->count();

                                $uncomplete = \App\TrainingHourTrail::where('status', '5')->where('year', $year)->count();
                                
                                $all = \App\TrainingHourTrail::where('year', $year)->count();   
                                
                                $percentComplete = $all == 0 ? 0 : ($complete / $all * 100);
                                $percentUncomplete = $all == 0 ? 0 : ($uncomplete / $all * 100);
                            ?>
                            <div class="col-md-6">
                                <div class="js-easy-pie-chart color-primary-900 d-flex" data-percent="{{ $percentComplete }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8">
                                    <div class="d-flex align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                        <span class="text-dark" style="margin-left: 220px">{{ $complete }}</span>
                                    </div>
                                    <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div align="center">
                                    <button class="btn btn-xs btn-outline-primary pl-4 pr-4"><small>COMPLETE</small></button>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="js-easy-pie-chart color-danger-900 d-flex" data-percent="{{ $percentUncomplete }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8">
                                    <div class="d-flex align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                        <span class="text-dark" style="margin-left: 220px">{{ $uncomplete }}</span>
                                    </div>
                                    <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div align="center">
                                    <button class="btn btn-xs btn-outline-primary pl-4 pr-4"><small>UNCOMPLETE</small></button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Training Type {{ $year }}</div>
                    <div class="card-body">
                        <div id="piechart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500"><i class="fal fa-cubes"></i> Top Internal Training {{ $year }}</div>
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
                                    <tr class="
                                        @if($loop->iteration == 1)
                                            {{ 'td-green' }} 
                                        @elseif($loop->iteration == 2) 
                                            {{ 'td-yellow' }}
                                        @elseif($loop->iteration == 3)
                                            {{ 'td-red' }}
                                        @endif
                                    ">
                                        <td class="text-center">{{ $train_no++ }}</td>
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
                    <div class="card-header bg-primary-500"><i class="fal fa-cubes"></i> Top Staff with Most Training {{ $year }}</div>
                    <div class="card-body">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Staff</th>
                                    <th>Total Hour</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staffRank as $staffsRank)
                                    <tr class="
                                        @if($loop->iteration == 1)
                                            {{ 'td-green' }} 
                                        @elseif($loop->iteration == 2) 
                                            {{ 'td-yellow' }}
                                        @elseif($loop->iteration == 3)
                                            {{ 'td-red' }}
                                        @endif
                                    ">
                                        <td class="text-center">{{ $staff_no++ }}</td>
                                        <td class="text-left">{{ $staffsRank->staffs->staff_name }}</td>
                                        <td class="text-center">{{ $staffsRank->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>

    </main>
@endsection

@section('script')
 
<script>
    // Start PieChart
        $(function () {    
            var type = <?php echo $type; ?>;
             
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart1);
            function drawChart1() {
                var data = google.visualization.arrayToDataTable(type);
                var options = {
                // title: 'Total Training Based Type {{$year}}',
                titleTextStyle: {
                    color: '666666',
                    fontName: 'Roboto',
                    fontSize: 16,
                    bold: false,
                },
                bar: {groupWidth: "80%"},
                borderColor: 
                    'rgb(135, 48, 14)',
                legend: { position: 'bottom'},
                is3D: true,
                } 
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        })
    // End PieCart

     // Start BarChart
     $(function () {    
            var type = <?php echo $type; ?>;
             
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart1);
            function drawChart1() {
                var data = google.visualization.arrayToDataTable(type);
                var options = {
                // title: 'Total Training Based Type {{$year}}',
                titleTextStyle: {
                    color: '666666',
                    fontName: 'Roboto',
                    fontSize: 16,
                    bold: false,
                },
                bar: {groupWidth: "80%"},
                borderColor: 
                    'rgb(135, 48, 14)',
                legend: { position: 'bottom'},
                is3D: true,
                } 
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        })
    // End BarChart
</script>

@endsection
