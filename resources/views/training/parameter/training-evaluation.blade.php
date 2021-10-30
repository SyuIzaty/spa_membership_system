@extends('layouts.public')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary-50">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="max-width: 100%" class="responsive"/></center><br>
                            <h4 style="text-align: center; margin-top: -25px">
                                <b>TRAINING EVALUATION FORM</b>
                            </h4>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="panel-container show">
                        <div class="p-2 col-md-12">
                            <table class="table table-striped m-0">
                                <tr>
                                    <td>Staff Name : </td>
                                    <td style="text-transform: uppercase"><b>{{ $staff->staff_name ?? '--' }} ( {{ $staff->staff_id ?? '--' }} )</b></td>
                                </tr>
                                <tr>
                                    <td>Title : </td>
                                    <td style="text-transform: uppercase"><b>{{ $training->title ?? '--' }}</b></td>
                                </tr>
                                <tr>
                                    <td>Venue : </td>
                                    <td style="text-transform: uppercase"><b>{{ $training->venue ?? '--'}}</b></td>
                                </tr>
                                <tr>
                                    <td>Link : </td>
                                    <td><b>{{ $training->link ?? '--' }}</b></td>
                                </tr>
                                <tr>
                                    <td>Date : </td>
                                    <td><b>{{ date(' d/m/Y ', strtotime($training->start_date) ) ?? '--'}} -  {{ date(' d/m/Y ', strtotime($training->end_date) ) ?? '--'}}</b></td>
                                </tr>
                                <tr>
                                    <td>Time : </td>
                                    <td><b>{{ date(' h:i A ', strtotime($training->start_time) ) ?? '--'}} -  {{ date(' h:i A ', strtotime($training->end_time) ) ?? '--'}}</b></td>
                                </tr>
                            </table>
                            <p></p>
                        </div>

                        <hr>

                        <div class="panel-content" align="center">
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- Start View Form --}}
                                    <div>
                                        <div class="card-body">
                                            @foreach($trainingHead as $detail => $headers)
                                                @php $i = 1; @endphp
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td colspan="8" class="bg-primary-50 font-weight-bold text-center">
                                                            {{ $headers->question_head }}
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                        $data = \App\TrainingEvaluationHead::where('id', $headers->id)->first();
                                                    ?>
                                                    @foreach($data->trainingEvaluationQuestions->groupBy('head_id') as $questions)
                                                        @if( $questions->first()->eval_rate === "R" )
                                                            <tr class="font-weight-bold text-center" style="white-space: nowrap">
                                                                <td style="width: 2%">No</td>
                                                                <td style="width: 50%">Question</td>
                                                                <td style="width: 7%">Strongly Disagree</td>
                                                                <td style="width: 7%">Disagree</td>
                                                                <td style="width: 7%">In Between</td>
                                                                <td style="width: 7%">Agree</td>
                                                                <td style="width: 7%">Strongly Agree</td>
                                                            </tr>
                                                        @else
                                                            <tr class="font-weight-bold text-center" style="white-space: nowrap">
                                                                <td style="width: 2%">No</td>
                                                                <td style="width: 50%">Question</td>
                                                                <td colspan="5">Answer</td>
                                                            </tr>
                                                        @endif
                                                        @foreach ($trainingResult as $result)
                                                            @if($result->trainingEvaluationQuestion->trainingEvaluationHeads->id ==  $questions->first()->head_id)
                                                                <tr>
                                                                    @if( $result->trainingEvaluationQuestion->eval_rate === "R" )
                                                                        <td>{{ $i++ }}</td>
                                                                        <td>{{ $result->trainingEvaluationQuestion->question }}</td>
                                                                        <td class="text-center"><input disabled type="radio" value="1" {{ $result->rating == "1" ? 'checked="checked"' : '' }}></td>
                                                                        <td class="text-center"><input disabled type="radio" value="2" {{ $result->rating == "2" ? 'checked="checked"' : '' }}></td>
                                                                        <td class="text-center"><input disabled type="radio" value="3" {{ $result->rating == "3" ? 'checked="checked"' : '' }}></td>
                                                                        <td class="text-center"><input disabled type="radio" value="4" {{ $result->rating == "4" ? 'checked="checked"' : '' }}></td>
                                                                        <td class="text-center"><input disabled type="radio" value="5" {{ $result->rating == "5" ? 'checked="checked"' : '' }}></td>
                                                                    @endif
                                                                    @if( $result->trainingEvaluationQuestion->eval_rate === "C" )
                                                                        <td>{{ $i++ }}</td>
                                                                        <td>{{ $result->trainingEvaluationQuestion->question }}</td>
                                                                        <td colspan="5"><textarea disabled rows="3" class="form-control">{{ $result->rating}}</textarea></td>
                                                                    @endif
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </table>
                                            @endforeach
                                        </div>
                                    </div>
                                    {{-- End View Form  --}}
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
