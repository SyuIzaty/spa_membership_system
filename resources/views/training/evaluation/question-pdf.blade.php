@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC"></center>
                    <h4 style="text-align: center">
                        <b>INTEC EDUCATION COLLEGE {{ strtoupper($evaluate->first()->trainingEvaluation->evaluation) }} FORM</b>
                    </h4><br>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="card-primary card-outline">
                                <div class="card-body">
                                    @foreach($evaluate->groupby('head_id') as $detail => $questions)
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="8" class="bg-primary-50 font-weight-bold">
                                                    {{ $questions->first()->trainingEvaluationHeads->question_head }}
                                                </td>
                                            </tr>
                                            @if( $questions->first()->eval_rate === "R" )
                                                <tr class="font-weight-bold text-center">
                                                    <td style="width: 2%">No</td>
                                                    <td style="width: 50%">Question</td>
                                                    <td style="width: 7%">Strongly Disagree</td>
                                                    <td style="width: 7%">Disagree</td>
                                                    <td style="width: 7%">In Between</td>
                                                    <td style="width: 7%">Agree</td>
                                                    <td style="width: 7%">Strongly Agree</td>
                                                </tr>
                                            @else
                                                <tr class="font-weight-bold text-center">
                                                    <td style="width: 2%">No</td>
                                                    <td style="width: 50%">Question</td>
                                                    <td colspan="5">Answer</td>
                                                </tr>
                                            @endif
                                            @foreach ($questions as $key => $item)
                                                <tr>
                                                    @if( $item->eval_rate === "R" )
                                                        <td>{{ isset($item->sequence) ? $item->sequence : $loop->iteration }}</td>
                                                        <td>{{ $item->question }}</td>
                                                        <td class="text-center"><input type="radio" disabled></td>
                                                        <td class="text-center"><input type="radio" disabled></td>
                                                        <td class="text-center"><input type="radio" disabled></td>
                                                        <td class="text-center"><input type="radio" disabled></td>
                                                        <td class="text-center"><input type="radio" disabled></td>
                                                    @endif
                                                    @if( $item->eval_rate === "C" )
                                                        <td>{{ isset($item->sequence) ? $item->sequence : $loop->iteration }}</td>
                                                        <td>{{ $item->question }}</td>
                                                        <td colspan="5"><textarea rows="3" class="form-control" disabled></textarea></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endforeach
                                     
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
<script>
    //
</script>
@endsection

