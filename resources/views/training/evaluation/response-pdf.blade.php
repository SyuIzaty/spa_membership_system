@extends('layouts.public')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
            <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center>
            <h4 style="text-align: center">
                <b style="text-transform: uppercase">{{ $ques_response->first()->trainingEvaluationHeads->question_head }} RESPONSE</b>
            </h4><br>
            <div class="panel-container show">
                <div class="panel-content">
                    @foreach($ques_response as $questions)
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2">{{ $questions->question }}</td>
                            </tr>
                            @foreach ($questions->trainingEvaluationResults as $all_result)
                                <tr>
                                    <td style="width: 5px">{{ $loop->iteration }}.</td>
                                    <td>{{ $all_result->rating }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endforeach
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

