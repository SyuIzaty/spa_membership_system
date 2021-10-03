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
            <div class="col-sm-6 col-xl-4">
                <div class="p-3 bg-warning-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{-- {{ $applicant->where('applicant_status','00')->count() }} --}}
                            <small class="m-0 l-h-n">Data 1</small>
                        </h3>
                    </div>
                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{-- {{ $applicant->where('applicant_status','2')->count() }} --}}
                            <small class="m-0 l-h-n">Data 2</small>
                        </h3>
                    </div>
                    <i class="fal fa-clipboard-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
                    <div class="">
                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                            {{-- {{ $applicant->where('applicant_status','3G')->count() }} --}}
                            <small class="m-0 l-h-n">Data 3</small>
                        </h3>
                    </div>
                    <i class="fal fa-times position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 30px">
                <div class="card">
                    <div class="card-header bg-primary-500">Training Request</div>
                </div>
                <div style="height:400px">
                    <canvas id="chart1" class="rounded shadow"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary-500">Training Claim</div>
                </div>
                <div style="height:400px">
                    <canvas id="offerApplicant" class="rounded shadow"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary-500">Training Evaluation</div>
                    <div class="card-body">
                        <div id='calendar'>
                            <div class="col-md-6 col-lg-5 mr-lg-auto">
                                <div class="d-flex mt-2 mb-1 fs-xs text-primary">
                                    Current Usage
                                </div>
                                <div class="progress progress-xs mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex mt-2 mb-1 fs-xs text-info">
                                    Net Usage
                                </div>
                                <div class="progress progress-xs mb-3">
                                    <div class="progress-bar bg-info-500" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex mt-2 mb-1 fs-xs text-warning">
                                    Users blocked
                                </div>
                                <div class="progress progress-xs mb-3">
                                    <div class="progress-bar bg-warning-500" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex mt-2 mb-1 fs-xs text-danger">
                                    Custom cases
                                </div>
                                <div class="progress progress-xs mb-3">
                                    <div class="progress-bar bg-danger-500" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex mt-2 mb-1 fs-xs text-success">
                                    Test logs
                                </div>
                                <div class="progress progress-xs mb-3">
                                    <div class="progress-bar bg-success-500" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex mt-2 mb-1 fs-xs text-dark">
                                    Uptime records
                                </div>
                                <div class="progress progress-xs mb-3">
                                    <div class="progress-bar bg-fusion-500" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6 col-sm-12">
                <div class="table-responsive">
                    <div id="chart1" style="height: 500px"></div>
                </div>
            </div> --}}
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
