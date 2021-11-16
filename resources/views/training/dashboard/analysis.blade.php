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
                <div class="row">
                    <div class="col-md-10">
                        <i class="subheader-icon fal fa-chart-area"></i> Training <span class="fw-300">Dashboard</span>
                    </div>
                    <div class="col-md-2" style="font-size: 12px">
                        <form action="{{ route('dashList') }}" method="GET" id="form_find">
                            <select class="selectfilter form-control" name="year" id="year">
                                @foreach ($years as $yrs)
                                    <option value="{{ $yrs->year }}" {{ $selectedYear == $yrs->year ? 'selected' : '' }}>{{ $yrs->year }}</option>
                                @endforeach
                            </select> 
                        </form>
                    </div>
                </div>
            </h1>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Training Category {{ $selectedYear }}</div>
                    <div class="card-body">
                        <div id="barchart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Staff Performance {{ $selectedYear }}</div>
                        <div class="card-body">
                            <?php 
                                $complete = \App\TrainingHourTrail::where('status', '4')->where('year', $selectedYear)->count();

                                $uncomplete = \App\TrainingHourTrail::where('status', '5')->where('year', $selectedYear)->count();
                                
                                $all = \App\TrainingHourTrail::where('year', $selectedYear)->count();   
                                
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
                    <div class="card-header bg-primary-500"><i class="fal fa-burn"></i> Training Type {{ $selectedYear }}</div>
                    <div class="card-body">
                        <div id="piechart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-500"><i class="fal fa-cubes"></i> Top Internal Training {{ $selectedYear }}</div>
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
                    <div class="card-header bg-primary-500"><i class="fal fa-cubes"></i> Top Staff with Most Training {{ $selectedYear }}</div>
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
    $(document).ready(function()
    {
        $("#year").change(function(){
            $("#form_find").submit();
        })
        $('#year').select2();
    });
</script>
<script>
    $(function () {    
        var type = <?php echo $type; ?>;
            
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            var data = google.visualization.arrayToDataTable(type);
            var options = {
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
</script>
<script>
    $(function () {    
        var category = <?php echo $category; ?>;
            
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            var data = google.visualization.arrayToDataTable(category);
            var options = {
                titleTextStyle: {
                    color: '666666',
                    fontName: 'Roboto',
                    fontSize: 16,
                    bold: false,
                },
                bar: {groupWidth: "80%"},
                borderColor: 
                    'rgb(38, 244, 255)',
                legend: { position: 'bottom'},
                is3D: true,
            } 
            var chart = new google.visualization.BarChart(document.getElementById('barchart'));
            chart.draw(data, options);
        }
    })
</script>
@endsection
