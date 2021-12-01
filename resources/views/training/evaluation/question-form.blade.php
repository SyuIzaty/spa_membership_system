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
                            <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center><br>
                            <h4 style="text-align: center; margin-top: -25px">
                                <b>TRAINING EVALUATION FORM</b>
                            </h4>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="panel-container show">
                        @if(Session::has('message'))
                            <script type="text/javascript">

                            function massage() {
                            Swal.fire(
                                        'Successful!',
                                        'Your Evaluation Form Has Been Submitted and Recorded!',
                                        'success'
                                    );
                            }

                            window.onload = massage;
                            </script>
                        @endif
                        @if(Session::has('notification'))
                            <script type="text/javascript">

                            function massage() {
                            Swal.fire(
                                        'Successful!',
                                        'Your Evaluation Form Has Been Updated and Recorded!',
                                        'success'
                                    );
                            }

                            window.onload = massage;
                            </script>
                        @endif
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
                                    <?php
                                        $exist = \App\TrainingEvaluationHeadResult::where('staff_id', Auth::user()->id)->where('training_id', $training->id)->first();
                                        $duration = \App\TrainingEvaluationHeadResult::where('staff_id', Auth::user()->id)->where('training_id', $training->id)->whereHas('trainingList', function($query){
                                                        $query->where('evaluation_status', '1');
                                                    })->first();         
                                    ?>
                                    @if(isset($exist))
                                        @if(isset($duration))
                                            {{-- exist and evaluation open but can edit --}}
                                                {{-- Start Update Form --}}
                                                <div>
                                                    <div class="card-body">
                                                        @php $count=0; @endphp
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
                                                                    {!! Form::open(['action' => 'TrainingController@updateEvaluationForm', 'method' => 'POST']) !!}
                                                                    @csrf
                                                                    <input type="hidden" name="training_id" value="{{ $training->id }}">
                                                                    <input type="hidden" name="evaluation_id" value="{{ $questions->first()->evaluation_id }}">
                                                                    
                                                                    @foreach ($trainingResult as $result)
                                                                    <input type="hidden" name="question{{$count}}" value="{{ $result->question }}">
                                                                        @if($result->trainingEvaluationQuestion->trainingEvaluationHeads->id ==  $questions->first()->head_id)
                                                                        <input type="hidden" name="id{{$count}}" value ="{{ $result->id }}">
                                                                            <tr>
                                                                                @if( $result->trainingEvaluationQuestion->eval_rate === "R" )
                                                                                    <td>{{ $i++ }}</td>
                                                                                    <td>{{ $result->trainingEvaluationQuestion->question }}</td>
                                                                                    <input type="hidden" name="rating{{$count}}" id="rating" value="">
                                                                                    <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="1" {{ $result->rating == "1" ? 'checked="checked"' : '' }}></td>
                                                                                    <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="2" {{ $result->rating == "2" ? 'checked="checked"' : '' }}></td>
                                                                                    <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="3" {{ $result->rating == "3" ? 'checked="checked"' : '' }}></td>
                                                                                    <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="4" {{ $result->rating == "4" ? 'checked="checked"' : '' }}></td>
                                                                                    <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="5" {{ $result->rating == "5" ? 'checked="checked"' : '' }}></td>
                                                                                @endif
                                                                                @if( $result->trainingEvaluationQuestion->eval_rate === "C" )
                                                                                    <td>{{ $i++ }}</td>
                                                                                    <td>{{ $result->trainingEvaluationQuestion->question }}</td>
                                                                                    <td colspan="5"><textarea rows="3" class="form-control" id="rating" name="rating{{$count}}" value="{{ old('rating') }}">{{ $result->rating}}</textarea></td>
                                                                                @endif
                                                                            </tr>
                                                                            @php  $count+=1;  @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            </table>
                                                        @endforeach
                                                        <input type="hidden" name="count" value="{{ $count }}">
                                                        <div class="footer">
                                                            <button type="submit" class="btn btn-primary ml-auto float-center mt-2"><i class="fal fa-save"></i> Update Evaluation</button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                                {{-- End Update Form  --}}
                                        @else 
                                            {{-- exist and evaluation close but can view --}}
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
                                                        {{-- <div class="footer">
                                                            <button type="submit" class="btn btn-info ml-auto float-center mt-2"><i class="fal fa-arrow-alt-left"></i> Back</button>
                                                        </div> --}}
                                                        
                                                    </div>
                                                </div>
                                                {{-- End View Form  --}}
                                        @endif
                                    @else  
                                    {{-- new form  --}}
                                        {{-- Start New Form --}}
                                        <div>
                                            <div class="card-body">
                                                @php $count=0; @endphp
                                                @foreach($trainingHead as $detail => $headers)
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
                                                        
                                                            {!! Form::open(['action' => 'TrainingController@storeEvaluationForm', 'method' => 'POST']) !!}
                                                            @csrf
                                                            <input type="hidden" name="train_id" value="{{ $training->id }}">
                                                            <input type="hidden" name="evaluate_id" value="{{ $questions->first()->evaluation_id }}">
                                                            @foreach ($questions as $key => $item)
                                                                <input type="hidden" name="question{{$count}}" value="{{ $item->id }}">
                                                                    <tr>
                                                                        @if( $item->eval_rate === "R" )
                                                                            <td>{{ isset($item->sequence) ? $item->sequence : $loop->iteration }}</td>
                                                                            <td>{{ $item->question }}</td>
                                                                            <input type="hidden" name="rating{{$count}}" id="rating" value="">
                                                                            <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="1" {{ old('rating') == "1" ? 'checked' : '' }}></td>
                                                                            <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="2" {{ old('rating') == "2" ? 'checked' : '' }}></td>
                                                                            <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="3" {{ old('rating') == "3" ? 'checked' : '' }}></td>
                                                                            <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="4" {{ old('rating') == "4" ? 'checked' : '' }}></td>
                                                                            <td class="text-center"><input type="radio" name="rating{{$count}}" id="rating" value="5" {{ old('rating') == "5" ? 'checked' : '' }}></td>
                                                                        @endif
                                                                        @if( $item->eval_rate === "C" )
                                                                            <td>{{ isset($item->sequence) ? $item->sequence : $loop->iteration }}</td>
                                                                            <td>{{ $item->question }}</td>
                                                                            <td colspan="5"><textarea rows="3" class="form-control" id="rating" name="rating{{$count}}">{{ old('rating') }}</textarea></td>
                                                                        @endif
                                                                    </tr>
                                                                @php $count+=1; @endphp
                                                            @endforeach
                                                        @endforeach
                                                    </table>
                                                @endforeach
                                                <input type="hidden" name="count" value="{{ $count }}">
                                                <div class="footer">
                                                    <button type="submit" class="btn btn-primary ml-auto float-center mt-2"><i class="fal fa-save"></i> Submit Evaluation</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        {{-- End New Form   --}}
                                    @endif
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
