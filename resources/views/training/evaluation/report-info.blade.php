@extends('layouts.admin')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-folder-open'></i>EVALUATION REPORT 
        </h1>
    </div>

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        REPORT RESULT <span class="fw-300"><i> #{{ $id }} </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <div class="row">
                            <div class="tab-content col-md-12">
                                <?php $data = []; ?>
                                <div>
                                    <div class="col-md-12">
                                        <div class="row ">

                                            <div class="col-md-9">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Evaluation Result
                                                        <a data-page="#" class="float-right" style="cursor: pointer" onclick="Print(this)"><i class="fal fa-file-pdf" style="color: red; font-size: 20px"></i></a>
                                                    </div>
                                                        <div class="card-body">
                                                            <?php $grand_total = 0; $totalquestion = 0; ?>
                                                                @foreach($trainingHead as $detail => $headers)

                                                                    @php $is = 1; @endphp
                                                                    <?php $total = 0; $questioncount = 0; ?>
                                                                    <table class="table table-bordered" style="margin-bottom: 50px">
                                                                        <tr>
                                                                            <td colspan="8" class="bg-primary-50 font-weight-bold">
                                                                                {{ $headers->question_head }}
                                                                                @if ($headers->trainingEvaluationQuestions->whereIn('eval_rate',['C'])->count() >= 1)
                                                                                    <a href="/report-response/{{ $id }}/{{ $headers->id }}/{{ $headers->evaluation_id }}" class="btn btn-primary btn-xs float-right"><i class='fal fa-volume-down'></i> Response</a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <?php 
                                                                            $data = \App\TrainingEvaluationHead::where('id', $headers->id)->first();
                                                                        ?>
                                                                        <tr class="font-weight-bold text-center" style="white-space: nowrap">
                                                                            <td style="width: 2%">No</td>
                                                                            <td style="width: 50%">Question</td>
                                                                            <td style="width: 7%">Strongly Disagree</td>
                                                                            <td style="width: 7%">Disagree</td>
                                                                            <td style="width: 7%">In Between</td>
                                                                            <td style="width: 7%">Agree</td>
                                                                            <td style="width: 7%">Strongly Agree</td>
                                                                            <td style="width: 13%">Point</td>
                                                                        </tr>
                                                                        @foreach($data->trainingEvaluationQuestions->where('eval_rate', '!=', 'C')->groupBy('head_id') as $questions)
                                                                            @foreach ($trainingResult as $key => $item)
                                                                             @if($item->trainingEvaluationQuestion->trainingEvaluationHeads->id ==  $questions->first()->head_id)
                                                                                <tr>
                                                                                    @if( $questions->first()->eval_rate === "R" )
                                                                                        <td>{{ $is++ }}</td>
                                                                                        <td>{{ $item->trainingEvaluationQuestion->question }}</td>
                                                                                    @endif
                                                                                    @if( $questions->first()->eval_rate === "R" )
                                                                                        <?php
                                                                                            $questioncount ++;
                                                                                            $totalquestion ++;
                                                                                            $point = $item->where('question',$item->question)->where('training_id',$id)->sum('rating');
                                                                                            $frequency = $item->where('question',$item->question)->where('training_id',$id)->groupby('staff_id')->count();
                                                                                            $grade = $frequency > 0 ? $point / $frequency : 0;
                                                                                            $total += $grade;
                                                                                            $grand_total += $point;
                                                                                        ?>
                                                                                        @for($i = 1; $i <= 5; $i++)
                                                                                            <td class="text-center">
                                                                                                {{ $item->where('question',$item->question)->where('rating',$i)->where('training_id',$id)->count() }}
                                                                                            </td>
                                                                                        @endfor
                                                                                        <td class="text-center">{{ number_format($grade,2) }}</td>
                                                                                    @endif
                                                                                </tr>
                                                                             @endif
                                                                                <?php

                                                                                    // header
                                                                                    $dataHead = $headers->select('id', 'question_head')->whereHas('trainingEvaluation',function($query) use($id){
                                                                                                $query->whereHas('trainingList',function($query) use($id){
                                                                                                    $query->where('id', $id);
                                                                                                });
                                                                                            })->pluck('id', 'question_head')->toArray();
            
                                                                                    // color
                                                                                    $dataColor = $headers->select('id', 'color')->whereHas('trainingEvaluation',function($query) use($id){
                                                                                                $query->whereHas('trainingList',function($query) use($id){
                                                                                                    $query->where('id', $id);
                                                                                                });
                                                                                            })->pluck('id', 'color')->toArray();
            
                                                                                    // $data = [$headers->question_head];
                                                                                    // $datas = [$total > 0 && $questioncount >0 ? ROUND($total / $questioncount,2) : 0];
                                                                                    // $datass = [$headers->color ];

                                                                                    $dataz = $headers->whereHas('trainingEvaluation',function($query) use($id){
                                                                                                $query->whereHas('trainingList',function($query) use($id){
                                                                                                    $query->where('id', $id);
                                                                                                });
                                                                                            })->get();
            
                                                                                    $listBal = [];
            
                                                                                    foreach($dataz as $key => $test) {
                                                                                        $data = $headers->where('id', $test['id'])->first(); 
                                                                                        // dd($data);
                                                                                        $total_bal = 0;
                                                                                        
                                                                                        foreach($data->trainingEvaluationQuestions as $list){
                                                                                            // $a += $list->question->count();
                                                                                            
                                                                                            $total_bal = $total > 0 && $questioncount >0 ? ROUND($total / $questioncount,2) : 0;
                                                                                            // dd($total_bal);
                                                                                        }
                                                                                        $listBal[] = $total_bal;
                                                                                    }

                                                                                    // $dataTotal = $total > 0 && $questioncount >0 ? ROUND($total / $questioncount,2) : 0;
            
                                                                                    $chart = new \App\TrainingEvaluationHead;
                                                                                    $chart->labels = (array_keys($dataHead));
                                                                                    $chart->backgroundColor = (array_keys($dataColor));
                                                                                    $chart->dataset = (array_values($listBal)); 
            
                                                                                ?>
                                                                            @endforeach
                                                                            {{-- @if($key == count($trainingResult) - 1) --}}
                                                                                <tr class="text-center font-weight-bold">
                                                                                    <td colspan="7"> Average Point </td>
                                                                                    <td> {{ $total > 0 && $questioncount >0 ? number_format($total / $questioncount,2) : 0 }}</td>
                                                                                </tr>
                                                                            {{-- @endif --}}
                                                                        @endforeach
                                                                    </table>
                                                                
                                                                @endforeach
                                                             
                                                            <canvas id="chartz1" style="background: transparent" class="rounded shadow"></canvas>
                                                            <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
                                                            <script>
                                                                var ctx = document.getElementById('chartz1').getContext('2d');
                                                                
                                                                var myChart = new Chart(ctx, {
                                                                    type: 'bar',
                                                                    data: {
                                                                        labels:  {!!json_encode($chart->labels)!!} ,
                                                                        datasets: [{
                                                                            label: 'EVALUATION REPORT',
                                                                            data: {!!json_encode($chart->dataset)!!} ,
                                                                            backgroundColor: {!!json_encode($chart->backgroundColor)!!} ,
                                                                            borderWidth: 1
                                                                        }]
                                                                    },
                                                                    options: {
                                                                        scales: {
                                                                            yAxes: [{
                                                                                ticks: {
                                                                                    beginAtZero: true
                                                                                }
                                                                            }]
                                                                        },
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
                                                                        bar: {groupWidth: "80%"},
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

                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">Overall Result</div>
                                                    <div class="card-body">
                                                        <table class="table table-bordered font-weight-bold">
                                                            <tr>
                                                                <td class="bg-danger-50">Training Title</td>
                                                                <td>{{ $training->title }}</td>
                                                            </tr>
                                                            <?php 
                                                                $start = isset($training->start_date) ? date(' d-m-Y ', strtotime($training->start_date)) : 'd-m-Y';
                                                                $end = isset($training->end_date) ? date(' d-m-Y ', strtotime($training->end_date)) : 'd-m-Y';

                                                                if($training->start_date != null) {
                                                                    $dates = $start.' - '.$end;
                                                                } else {
                                                                    $dates = '--';
                                                                }  
                                                            ?>
                                                            <tr>
                                                                <td class="bg-danger-50">Date</td>
                                                                <td>{{ $dates }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-danger-50">Participant</td>
                                                                <td>{{ \App\TrainingClaim::where('status', '2')->where('training_id', $id)->count() }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-danger-50">Respondant</td>
                                                                <td>{{ \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count() }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-danger-50">Submit Percentage</td>
                                                                <td colspan="3">
                                                                    {{ ROUND(((( \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count()) / (\App\TrainingClaim::where('status', '2')->where('training_id', $id)->count())) * 100),2) }} %
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-danger-50">Total Average Point</td>
                                                                <?php                                                                  
                                                                    $tot_average_pt = 0;
                                                                    $tot_average_pt = $totalquestion * \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count() > 0 ? ROUND($grand_total / ($totalquestion * \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count()) ,2) : 0
                                                                ?>
                                                                 <td> {{ $tot_average_pt }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="bg-danger-50">Status</td>
                                                                <td>
                                                                    @foreach ($evaluationStatus as $eval_codes)
                                                                        @if (($tot_average_pt >= $eval_codes->min_point) && ($tot_average_pt <= $eval_codes->max_point))
                                                                            {{ $eval_codes->status }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="footer mt-3">
                                                            <a href="/evaluation-report" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card mt-5">
                                                    <div class="card-header">Status</div>
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-sm text-center">
                                                            <tr class="bg-danger-50 font-weight-bold">
                                                                <td>Status</td>
                                                                <td>Grade</td>
                                                            </tr>
                                                            @foreach ($evaluationStatus as $eval_stat)
                                                            <tr>
                                                                <td>{{ $eval_stat->status }}</td>
                                                                <td>{{ $eval_stat->min_point }} - {{ $eval_stat->max_point }}</td>
                                                            </tr>
                                                            @endforeach
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
            </div>
        </div>

    </div>
</main>
@endsection

@section('script')
<script>
    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

    

    
   

 


                                                                    

</script>
@endsection


