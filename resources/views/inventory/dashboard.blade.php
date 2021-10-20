@extends('layouts.admin')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">INTEC IDS</a></li>
            <li class="breadcrumb-item">Inventory</li>
            <li class="breadcrumb-item active">Inventory Dashboard</li>
        </ol>

        <div class="subheader">
            <h1 class="subheader-title">
                <i class="subheader-icon fal fa-chart-area"></i> Inventory <span class="fw-300">Dashboard</span>
            </h1>
        </div>
         
        <div class="row">
            <div class="col-md-12">
                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0)" class="card-title show" data-toggle="collapse" data-target="#ast" aria-expanded="true">
                                <i class="fal fa-signal width-2 fs-xl"></i>
                                ASSET ANALYSIS
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
                                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                                    @foreach($id as $count => $ids)
                                        <?php
                                            $department = \App\AssetDepartment::where('id', $ids)->first();
                                        ?>
                                        <li class="nav-item {{ $loop->first ? 'active' : '' }}">
                                            <a class="nav-link mb-2" id="nav-home-tab-{{$department->id}}" data-toggle="tab" href="#nav-home-{{$department->id}}" role="tab" aria-controls="{{$department->id}}">
                                                <i class="fal fa-unlink mr-1"></i>{{ $department->department_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content border border-top-0 p-3">
                                    @foreach($id as $count => $ids)
                                        <?php
                                            // Status
                                            $assetCountActive = \App\Asset::where('status', '1')->whereHas('type', function($query) use ($ids){
                                                                $query->whereHas('department', function($query) use ($ids){
                                                                    $query->where('id', $ids );
                                                                });
                                                            })->count();

                                            $assetCountInactive = \App\Asset::where('status', '0')->whereHas('type', function($query) use ($ids){
                                                                $query->whereHas('department', function($query) use ($ids){
                                                                    $query->where('id', $ids );
                                                                });
                                                            })->count();
                                            
                                            $assetAll = \App\Asset::whereHas('type', function($query) use ($ids){
                                                                $query->whereHas('department', function($query) use ($ids){
                                                                    $query->where('id', $ids );
                                                                });
                                                            })->count();   
                                            
                                            $percentActive = $assetAll == 0 ? 0 : ($assetCountActive / $assetAll * 100);
                                            $percentInactive = $assetAll == 0 ? 0 : ($assetCountInactive / $assetAll * 100);
                                            $department = \App\AssetDepartment::where('id', $ids)->first();
                                            $assetNo = \App\AssetType::where('department_id', $ids)->count();

                                            $assetValue = \App\Asset::where('status', '1')->whereHas('type', function($query) use ($ids){
                                                                $query->whereHas('department', function($query) use ($ids){
                                                                    $query->where('id', $ids );
                                                                });
                                                            })->sum('total_price'); 
                                        ?>
                                        <div class="tab-pane {{ $loop->first ? 'active in' : '' }}" id="nav-home-{{$department->id}}" role="tabpanel">
                                            <div class="row col-md-12">
                                                <div class="col-sm-12 col-xl-4 mb-1">
                                                    <div class="p-3 bg-info-300 rounded overflow-hidden position-relative text-white  ">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                {{ $assetAll }}
                                                                <small class="m-0 l-h-n">TOTAL OF ASSET </small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-tasks position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-xl-4 mb-1">
                                                    <div class="p-3 bg-warning-300 rounded overflow-hidden position-relative text-white  ">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                {{ $assetNo }}
                                                                <small class="m-0 l-h-n">TOTAL OF ASSET TYPE</small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-cubes position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-xl-4 mb-1">
                                                    <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white  ">
                                                        <div class="">
                                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                                RM {{ $assetValue }}
                                                                <small class="m-0 l-h-n">TOTAL VALUE OF ASSET </small>
                                                            </h3>
                                                        </div>
                                                        <i class="fal fa-money-bill position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row col-md-12">
                                                {{-- Start Status --}}
                                                <div class="card ml-2 mr-6 mb-4 col-sm-12 col-xl-3">
                                                    <div class="card-body">
                                                        <div class="panel-hdr">
                                                            <h2>
                                                                Status <span class="fw-300"><i>Partition</i></span>
                                                            </h2>
                                                        </div>
                                                        <br>
                                                        <a class="d-flex flex-row align-items-center">
                                                            <div class="col-md-6 align-items-center">
                                                                <div class="panel-container show">
                                                                    <div class="panel-content">
                                                                        <div class="js-easy-pie-chart color-success-900 position-relative d-flex align-items-center justify-content-center" data-percent="{{ $percentActive }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8" style="margin-left: -150px">
                                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                                                                <span class="d-block text-dark" style="margin-left: 150px">{{ $assetCountActive }}</span>
                                                                                <div class="d-block fs-xs text-dark opacity-70" style="margin-left: 150px">
                                                                                    <small>ACTIVE</small>
                                                                                </div>
                                                                            </div>
                                                                        <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 align-items-center">
                                                                <div class="panel-container show">
                                                                    <div class="panel-content">
                                                                        <div class="js-easy-pie-chart color-danger-900 position-relative d-flex align-items-center justify-content-center" data-percent="{{ $percentInactive }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8" style="margin-left: -150px">
                                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                                                                <span class="d-block text-dark" style="margin-left: 150px">{{ $assetCountInactive }}</span>
                                                                                <div class="d-block fs-xs text-dark opacity-70" style="margin-left: 150px">
                                                                                    <small>INACTIVE</small>
                                                                                </div>
                                                                            </div>
                                                                        <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- End Status --}}

                                                {{-- Start Reason --}}
                                                <div class="card mr-6 mb-4 col-sm-12 col-xl-4 ml-3">
                                                    <div class="card-body">
                                                        <div class="panel-hdr">
                                                            <h2>
                                                                Inactive <span class="fw-300"><i>Partition</i></span>
                                                            </h2>
                                                        </div>
                                                        <br>
                                                        <a class="d-flex flex-row align-items-center">
                                                            @foreach($assetStatus as $stats)
                                                            <?php 
                                                                // Reason
                                                                $data2 = \App\Asset::where('inactive_reason', $stats->id)->whereHas('type', function($query) use ($ids){
                                                                        $query->whereHas('department', function($query) use ($ids){
                                                                            $query->where('id', $ids );
                                                                        });
                                                                    })->get()->count();

                                                                $percentReason = $assetCountInactive == 0 ? 0 : ($data2 / $assetCountInactive * 100);     
                                                            ?>
                                                            <div class="col-md-6 align-items-center" style="margin-right: -60px">
                                                                <div class="panel-container show">
                                                                    <div class="panel-content">
                                                                        <div class="js-easy-pie-chart color-warning-900 position-relative  " data-percent="{{ $percentReason }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8" style="margin-left: -170px">
                                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                                                                <span class="d-block text-dark" style="margin-left: 75px">{{ $data2 }}</span>
                                                                                <div class="d-block fs-xs text-dark opacity-70" style="margin-left: 75px">
                                                                                    <small>{{ $stats->status_name }}</small>
                                                                                </div>
                                                                            </div>
                                                                        <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- End Reason --}}

                                                {{-- Start Acquisition --}}
                                                <div class="card mb-4 col-sm-12 col-xl-4 ml-3">
                                                    <div class="card-body">
                                                        <div class="panel-hdr">
                                                            <h2>
                                                                Acquisition <span class="fw-300"><i>Partition</i></span>
                                                            </h2>
                                                        </div>
                                                        <br>
                                                        <a class="d-flex flex-row align-items-center">
                                                            @foreach($assetAcquisition as $acq)
                                                            <?php 
                                                                // Acquisition
                                                                $acqs2 = \App\Asset::where('acquisition_type', $acq->id)->whereHas('type', function($query) use ($ids){
                                                                        $query->whereHas('department', function($query) use ($ids){
                                                                            $query->where('id', $ids );
                                                                        });
                                                                    })->get()->count();

                                                                $percentAcquisition = $assetAll == 0 ? 0 : ($acqs2 / $assetAll * 100);     
                                                            ?>
                                                            <div class="col-md-6 align-items-center" style="margin-right: -60px">
                                                                <div class="panel-container show">
                                                                    <div class="panel-content">
                                                                        <div class="js-easy-pie-chart color-info-900 position-relative  " data-percent="{{ $percentAcquisition }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8" style="margin-left: -170px">
                                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                                                                <span class="d-block text-dark" style="margin-left: 75px">{{ $acqs2 }}</span>
                                                                                <div class="d-block fs-xs text-dark opacity-70" style="margin-left: 75px">
                                                                                    <small>{{ $acq->acquisition_type }}</small>
                                                                                </div>
                                                                            </div>
                                                                        <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                            
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- End Reason --}}
                                            </div>
                                            <div class="row col-md-12" >
                                                @foreach($assetType->where('department_id', $ids) as $type)
                                                    <?php
                                                        $types = \App\Asset::where('asset_type', $type->id)->whereHas('type', function($query) use ($ids){
                                                                    $query->where('department_id', $ids );
                                                                })->count();
                                                    ?>
                                                    <div class="col-sm-6 col-xl-2 mb-2">
                                                        <div class="p-3 p-md-3 bg-primary-300">
                                                            <div class="d-flex align-items-center">
                                                                <div class="d-inline-block align-middle status status-success status-sm mr-2">
                                                                    <span class="profile-image-md rounded-circle d-block" style="width: 5rem">
                                                                        <h5 style="font-size: 25px">
                                                                            {{ $types }} 
                                                                        </h5>
                                                                    </span>
                                                                </div>
                                                                <div class="flex-1 min-width-0">
                                                                    <p class="d-block text-truncate">
                                                                        {{ strtoupper($type->asset_type) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <i class="fal fa-info position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0);" class="card-title show" data-toggle="collapse" data-target="#stk" aria-expanded="true">
                                <i class="fal fa-cubes width-2 fs-xl"></i>
                                STOCK ANALYSIS
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
                        <div id="stk" class="show" data-parent="#stk">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                                    @foreach($id as $item => $ids)
                                        <?php
                                            $dprt = \App\AssetDepartment::where('id', $ids)->first();
                                        ?>
                                        <li class="nav-item {{ $loop->first ? 'active' : '' }}">
                                            <a class="nav-link mb-2" id="nav-home2-tab-{{$dprt->id}}" data-toggle="tab" href="#nav-home2-{{$dprt->id}}" role="tab" aria-controls="{{$dprt->id}}">
                                                <i class="fal fa-unlink mr-1"></i>{{ $dprt->department_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content border border-top-0 p-3">
                                    @foreach($id as $item => $ids)
                                        <?php
                                            // Status
                                            $stockCountActive = \App\Stock::where('status', '1')->whereHas('departments', function($query) use ($ids){
                                                                    $query->where('id', $ids ); 
                                                            })->get()->count();

                                            $stockCountInactive = \App\Stock::where('status', '0')->whereHas('departments', function($query) use ($ids){
                                                                    $query->where('id', $ids );
                                                            })->get()->count();
                                            
                                            $stockAll = \App\Stock::whereHas('departments', function($query) use ($ids){
                                                                    $query->where('id', $ids );
                                                            })->get()->count();   
                                            
                                            $stockActive = $stockAll == 0 ? 0 : ($stockCountActive / $stockAll * 100);
                                            $stockInactive = $stockAll == 0 ? 0 : ($stockCountInactive / $stockAll * 100);
                                            $dprt = \App\AssetDepartment::where('id', $ids)->first();
                                        ?>
                                        <div class="tab-pane {{ $loop->first ? 'active in' : '' }}" id="nav-home2-{{$dprt->id}}" role="tabpanel">
                                            <div class="row">
                                                {{-- Start Status --}}
                                                <div class="card mb-4 col-sm-12 col-xl-2">
                                                    <div class="card-body">
                                                        <div class="panel-hdr">
                                                            <h2>
                                                                Status <span class="fw-300"><i>Partition</i></span>
                                                            </h2>
                                                        </div>
                                                        <br>
                                                        <a class="d-flex flex-row align-items-center">
                                                            <div class="col-md-12 align-items-center">
                                                                <div class="panel-container show mb-2">
                                                                    <div class="panel-content">
                                                                        <div class="js-easy-pie-chart color-success-900 position-relative d-flex align-items-center justify-content-center" data-percent="{{ $stockActive }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8" style="margin-left: -150px">
                                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                                                                <span class="d-block text-dark" style="margin-left: 150px">{{ $stockCountActive }}</span>
                                                                                <div class="d-block fs-xs text-dark opacity-70" style="margin-left: 150px">
                                                                                    <small>ACTIVE</small>
                                                                                </div>
                                                                            </div>
                                                                        <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas></div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel-container show">
                                                                    <div class="panel-content">
                                                                        <div class="js-easy-pie-chart color-danger-900 position-relative d-flex align-items-center justify-content-center" data-percent="{{ $stockInactive }}" data-piesize="145" data-linewidth="20" data-trackcolor="#ccbfdf" data-scalelength="8" style="margin-left: -150px">
                                                                            <div class="d-flex flex-column align-items-center justify-content-center position-absolute pos-left pos-right pos-top pos-bottom fw-300 fs-xl">
                                                                                <span class="d-block text-dark" style="margin-left: 150px">{{ $stockCountInactive }}</span>
                                                                                <div class="d-block fs-xs text-dark opacity-70" style="margin-left: 150px">
                                                                                    <small>INACTIVE</small>
                                                                                </div>
                                                                            </div>
                                                                        <canvas height="195" width="195" style="height: 145px; width: 145px;"></canvas></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- End Status --}}

                                                <div class="mb-4 col-sm-12 col-xl-10">
                                                    <?php

                                                        $stock = \App\Stock::select('id', 'stock_name')->groupBy('id')->whereHas('departments', function($query) use($ids) {
                                                                $query->where('id', $ids );
                                                        })->pluck('id', 'stock_name')->toArray();
                                                        
                                                        $stocks = \App\Stock::select('id', 'stock_name')->groupBy('id')->whereHas('departments', function($query) use($ids) {
                                                                $query->where('id', $ids );
                                                        })->get();

                                                        $listBal = [];
                                                        // $total = '';

                                                        // $integerIDs = collect([]);
                                                        foreach($stocks as $key => $stockss) {
                                                            $data = \App\Stock::where('id', $stockss['id'])->first(); 
                                                            
                                                            $total_bal = 0;
                                                            foreach($data->transaction as $list){
                                                                $total_bal += ($list->stock_in - $list->stock_out);
                                                            }
                                                            $listBal[] = $total_bal;
                                                        }

                                                        $chart = new \App\Stock;
                                                        $chart->labels = (array_keys($stock));
                                                        $chart->dataset = (array_values($listBal)); 
                                                    ?>
                                                    <canvas id="charts{{$ids}}" class="rounded shadow"></canvas>
                                                    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
                                                    <script>
                                                        var ctx = document.getElementById('charts{{$ids}}').getContext('2d');
                                                        var chart = new Chart(ctx, {
                                                            type: 'bar',
                                                            data: {
                                                                labels:  {!!json_encode($chart->labels)!!} ,
                                                                datasets: [
                                                                    {
                                                                        label: 'STOCK BALANCE',
                                                                        backgroundColor: [
                                                                            'rgba(255, 99, 132, 0.2)',
                                                                            'rgba(255, 159, 64, 0.2)',
                                                                            'rgba(255, 205, 86, 0.2)',
                                                                            'rgba(75, 192, 192, 0.2)',
                                                                            'rgba(54, 162, 235, 0.2)',
                                                                            'rgba(153, 102, 255, 0.2)',
                                                                            'rgba(201, 203, 207, 0.2)'
                                                                        ],
                                                                        borderColor: [
                                                                            'rgb(255, 99, 132)',
                                                                            'rgb(255, 159, 64)',
                                                                            'rgb(255, 205, 86)',
                                                                            'rgb(75, 192, 192)',
                                                                            'rgb(54, 162, 235)',
                                                                            'rgb(153, 102, 255)',
                                                                            'rgb(201, 203, 207)'
                                                                        ],
                                                                        borderWidth: 1,
                                                                        data:  {!! json_encode($chart->dataset)!!} ,
                                                                    },
                                                                ]
                                                            },
                                                            options: {
                                                                scales: {
                                                                    yAxes: [{
                                                                        ticks: {
                                                                            beginAtZero: true
                                                                        }
                                                                    }]
                                                                },
                                                                responsive: true,
                                                                maintainAspectRatio: false,
                                                                legend: {
                                                                    position: "top",
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
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
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
        //
    </script>
@endsection
