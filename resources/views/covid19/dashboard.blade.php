@extends('layouts.admin')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
            <li class="breadcrumb-item">Covid19</li>
            <li class="breadcrumb-item active">Covid19 Dashboard</li>
        </ol>

        <div class="subheader">
            <h1 class="subheader-title">
                <i class="subheader-icon fal fa-chart-area"></i> Covid19 <span class="fw-300">Dashboard</span>
            </h1>
        </div>
         
        <div class="row">
            <div class="col-md-12">
                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0)" class="card-title show" data-toggle="collapse" data-target="#ast" aria-expanded="true">
                                <i class="fal fa-signal width-2 fs-xl"></i>
                                DECLARATION ANALYSIS
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
                        <div id="ast" class="collapse show" data-parent="#ast">
                            <div class="card-body">
                                <div class="tab-content border border-top-0 p-3">
                                    <div class="row col-md-12 mb-6">
                                        <div class="col-sm-12 col-xl-4 mb-1">
                                            <div class="p-3 bg-info-300 rounded overflow-hidden position-relative text-white  ">
                                                <div class="">
                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                        {{ $activeA }}
                                                        <small class="m-0 l-h-n">TOTAL ACTIVE CATEGORY A </small>
                                                    </h3>
                                                </div>
                                                <i class="fal fa-tasks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-4 mb-1">
                                            <div class="p-3 bg-warning-300 rounded overflow-hidden position-relative text-white  ">
                                                <div class="">
                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                        {{ $activeB }}
                                                        <small class="m-0 l-h-n">TOTAL ACTIVE CATEGORY B</small>
                                                    </h3>
                                                </div>
                                                <i class="fal fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xl-4 mb-1">
                                            <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white  ">
                                                <div class="">
                                                    <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                        {{ $all }}
                                                        <small class="m-0 l-h-n">TOTAL OF TODAY DECLARATION </small>
                                                    </h3>
                                                </div>
                                                <i class="fal fa-archive position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" align="center">
                                        <div class="col-md-2 mb-4">
                                            <div class="js-easy-pie-chart color-danger-500 d-inline-flex" data-percent="{{ $percentA }}" data-piesize="100" data-linewidth="40" data-scalelength="2">
                                            </div>
                                            <button class="btn btn-xs btn-outline-primary pl-4 pr-4"><small>CATEGORY A : <b>{{ $categoryA }}</b></small></button>
                                        </div>
                                        <div class="col-md-2 mb-4">
                                            <div class="js-easy-pie-chart color-warning-500 d-inline-flex" data-percent="{{ $percentB }}" data-piesize="100" data-linewidth="40" data-scalelength="2">
                                            </div>
                                            <button class="btn btn-xs btn-outline-primary pl-4 pr-4"><small>CATEGORY B : <b>{{ $categoryB }}</b></small></button>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="js-easy-pie-chart color-primary-500 d-inline-flex" data-percent="{{ $percentC }}" data-piesize="100" data-linewidth="40" data-scalelength="2">
                                            </div>
                                            <button class="btn btn-xs btn-outline-primary pl-4 pr-4"><small>CATEGORY C : <b>{{ $categoryC }}</b></small></button>
                                        </div>
                                        <div class="col-md-2 mb-4">
                                            <div class="js-easy-pie-chart color-info-500 d-inline-flex" data-percent="{{ $percentD }}" data-piesize="100" data-linewidth="40" data-scalelength="2">
                                            </div>
                                            <button class="btn btn-xs btn-outline-primary pl-4 pr-4"><small>CATEGORY D : <b>{{ $categoryD }}</b></small></button>
                                        </div>
                                        <div class="col-md-2 mb-4">
                                            <div class="js-easy-pie-chart color-secondary-500 d-inline-flex" data-percent="{{ $percentE }}" data-piesize="100" data-linewidth="40" data-scalelength="2">
                                            </div>
                                            <button class="btn btn-xs btn-outline-primary pl-4 pr-4"><small>CATEGORY E : <b>{{ $categoryE }}</b></small></button>
                                        </div>
                                    </div>
                                    <br><br>
                                    <center>
                                        <a data-fancybox="gallery" class="btn btn-primary btn-pills btn-block waves-effect waves-themed w-25" href="{{asset('img/cvd_category.png')}}">
                                            >> Category Description <<
                                        </a>
                                    </center>
                                </div>
                            </div>
                            <div style="height:400px">
                                <canvas id="lineApp" class="rounded shadow"></canvas>
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
        var ctx = document.getElementById('lineApp').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels:  {!!json_encode($line->labels)!!} ,
                datasets: [
                    {
                        label: 'Daily Declaration',
                        borderColor: ["#efb5ae", "#e2d6bb", "#b0d8ed", "#b0c7ed", "#b7e1e6", "#c2b8e5", "#bbe2d9", "#c0ddc6", "#f6e3d8", "#fcf6f2"],
                        data:  {!! json_encode($line->dataset)!!} ,
                        fill: false,
                        borderColor: "#c78de6",
                        tension: 0.1
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 50,
                        right: 50,
                        bottom: 50,
                        top: 50
                    }
                }
            }
        });
</script>
@endsection
