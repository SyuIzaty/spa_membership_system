@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-folder-open'></i>EVALUATION REPORT RESPONSE
        </h1>
    </div>

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        REPORT RESPONSE <span class="fw-300"><i> {{ $ques_response->first()->trainingEvaluationHeads->question_head }} </i></span>
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
                                <div>
                                    <div class="col-md-12">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    @foreach($ques_response as $questions)
                                                    <div class="card-header bg-primary-50 font-weight-bold"> {{ $questions->question }}</div>
                                                        <div class="card-body">
                                                            @foreach ($questions->trainingEvaluationResults as $all_result)
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td style="width: 5px">{{ $loop->iteration }}.</td>
                                                                        <td>{{ $all_result->rating }}</td>
                                                                    </tr>
                                                                </table>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="footer mt-3">
                                                    <a href="/report-info/{{ $id }}" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a>
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
   //
</script>
@endsection


