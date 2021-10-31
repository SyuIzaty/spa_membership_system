@extends('layouts.public')
    
@section('content')
<style>
    @media print{
        @page {size: landscape}
    }
</style>
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
            <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center>
            <h4 style="text-align: center">
                <b style="text-transform: uppercase">{{ $training->title }} EVALUATION REPORT</b>
            </h4><br>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="tab-content col-md-12">
                            <?php $data = []; ?>
                            <div>
                                <div class="col-md-12">
                                    <div class="row ">

                                        <div class="col-md-12 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    Evaluation Result
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

                                                                        
                                                                        // avg point
                                                                        $dataz = $headers->whereHas('trainingEvaluation',function($query) use($id){
                                                                                    $query->whereHas('trainingList',function($query) use($id){
                                                                                        $query->where('id', $id);
                                                                                    });
                                                                                })->get();

                                                                        $listBale = [];
                                                                        foreach($dataz as $key => $test) {
                                                                            $datae = $headers->where('id', $test['id'])->first(); 
                                                                            $totale = 0;
                                                                            $questioncounte = 0;
                                                                            $total_bale = 0;
                                                                            
                                                                            foreach($datae->trainingEvaluationQuestions as $liste){
                                                                                if($liste->eval_rate != 'C')
                                                                                {
                                                                                    $questioncounte ++;
                                                                                    
                                                                                    foreach($liste->trainingEvaluationResults as $resulte){
                                                                                        if($resulte->training_id == $id)
                                                                                        {
                                                                                            $pointe = $resulte->where('question',$resulte->question)->where('training_id',$id)->sum('rating');
                                                                                            $frequencye = $resulte->where('question',$resulte->question)->where('training_id',$id)->groupby('staff_id')->count();
                                                                                            $gradee = $frequencye > 0 ? $pointe / $frequencye : 0;
                                                                                            $totale += $gradee;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                            $total_bale = $totale > 0 && $questioncounte >0 ? ROUND($totale / $questioncounte,2) : 0;
                                                                            $listBale[] = $total_bale;
                                                                        }

                                                                        $chart = new \App\TrainingEvaluationHead;
                                                                        $chart->labels = (array_keys($dataHead));
                                                                        $chart->backgroundColor = (array_keys($dataColor));
                                                                        $chart->dataset = (array_values($listBale)); 
                                                                    ?>
                                                                @endforeach
                                                                    <tr class="text-center font-weight-bold">
                                                                        <td colspan="7"> Average Point </td>
                                                                        <td> {{ $total > 0 && $questioncount >0 ? number_format($total / $questioncount,2) : 0 }}</td>
                                                                    </tr>
                                                            @endforeach
                                                        </table>
                                                    @endforeach
                                                    <canvas id="chartz1" class="rounded shadow row col-md-12"></canvas>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">Overall Result</div>
                                                <div class="card-body">
                                                    <table class="table table-bordered font-weight-bold">
                                                        <tr class="bg-danger-50" style="white-space: nowrap">
                                                            <th>Training Title</th>
                                                            <th>Date</th>
                                                            <th>Participant</th>
                                                            <th>Respondant</th>
                                                            <th>Submit Percentage</th>
                                                            <th>Total Average Point</th>
                                                            <th>Status</th>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ $training->title }}</td>
                                                            <?php 
                                                                $start = isset($training->start_date) ? date(' d-m-Y ', strtotime($training->start_date)) : 'd-m-Y';
                                                                $end = isset($training->end_date) ? date(' d-m-Y ', strtotime($training->end_date)) : 'd-m-Y';

                                                                if($training->start_date != null) {
                                                                    $dates = $start.' - '.$end;
                                                                } else {
                                                                    $dates = '--';
                                                                }  
                                                            ?>
                                                            <td>{{ $dates }}</td>
                                                            <td>{{ \App\TrainingClaim::where('status', '2')->where('training_id', $id)->count() }}</td>
                                                            <td>{{ \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count() }}</td>
                                                            <td>
                                                                {{ ROUND(((( \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count()) / (\App\TrainingClaim::where('status', '2')->where('training_id', $id)->count())) * 100),2) }} %
                                                            </td>
                                                            <?php                                                                  
                                                                $tot_average_pt = 0;
                                                                $tot_average_pt = $totalquestion * \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count() > 0 ? ROUND($grand_total / ($totalquestion * \App\TrainingEvaluationResult::where('training_id',$id)->groupBy('question')->count()) ,2) : 0
                                                            ?>
                                                            <td> {{ $tot_average_pt }}</td>
                                                            <td>
                                                                @foreach ($evaluationStatus as $eval_codes)
                                                                    @if (($tot_average_pt >= $eval_codes->min_point) && ($tot_average_pt <= $eval_codes->max_point))
                                                                        {{ $eval_codes->status }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    </table>
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
                <br>
                <div style="font-style: italic; font-size: 10px">
                    <p style="float: left">@ Copyright INTEC Education College</p>  
                    <p style="float: right">Printed Date : {{ date(' d/m/Y ', strtotime( \Carbon\Carbon::now()) )}}</p><br>
                </div>
        </div>
    </div>
</main>

@endsection

@section('script')
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
            bar: {groupWidth: "50%"},
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

