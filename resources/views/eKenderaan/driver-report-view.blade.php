@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-car'></i> e-Kenderaan
            </h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 20px;"></h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;">
                                    <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-exclamation-circle"></i> {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header text-white bg-primary">
                                            <h5 class="card-title w-100 text-center">EVALUATION RESULT</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="8" class="bg-info-50 font-weight-bold">
                                                                STAR RATING
                                                            </td>
                                                        </tr>
                                                        <tr class="font-weight-bold text-center">
                                                            <td style="width: 7%">Excellent</td>
                                                            <td style="width: 7%">Very Good</td>
                                                            <td style="width: 7%">Good</td>
                                                            <td style="width: 7%">Satisfying</td>
                                                            <td style="width: 7%">Less Satisfying</td>
                                                            <td style="width: 13%">Total</td>
                                                        </tr>
                                                        <tr>
                                                            @php $count = 0; @endphp
                                                            @for ($i = 5; $i >= 1; $i--)
                                                                <td class="text-center">
                                                                    {{ $details->where('rating', $i)->count() }}
                                                                </td>
                                                            @endfor
                                                            <td>{{ $details->count() }}</td>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                <table class="table table-borderless table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="8" class="bg-info-50 font-weight-bold">
                                                                QUALITY OF SERVICES
                                                            </td>
                                                        </tr>
                                                        <tr class="font-weight-bold text-center">
                                                            <td style="width: 7%">No</td>
                                                            <td style="width: 7%">Question</td>
                                                            <td style="width: 7%">Excellent</td>
                                                            <td style="width: 7%">Very Good</td>
                                                            <td style="width: 7%">Good</td>
                                                            <td style="width: 7%">Satisfying</td>
                                                            <td style="width: 7%">Less Satisfying</td>
                                                            <td style="width: 13%">Total</td>
                                                        </tr>
                                                        @php
                                                            $j = 1;
                                                            $c = 0;
                                                        @endphp
                                                        @foreach ($question as $q)
                                                            <tr>
                                                                <td>{{ $j }}</td>
                                                                <td>{{ $q->questionList->question }}
                                                                </td>
                                                                @for ($i = 5; $i >= 1; $i--)
                                                                    <td class="text-center">
                                                                        {{ $countScale->where('ekn_feedback_questions_id', $q->ekn_feedback_questions_id)->where('scale', $i)->count() }}
                                                                    </td>
                                                                @endfor
                                                                <td>{{ $countScale->where('ekn_feedback_questions_id', $q->ekn_feedback_questions_id)->count() }}
                                                                </td>
                                                            </tr>
                                                            @php $j++ @endphp
                                                        @endforeach
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-4">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header text-white bg-dark">
                                            <h5 class="card-title w-100 text-center">STATUS</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-hover table-striped w-100">
                                                    <tr class="bg-dark-50 font-weight-bold">
                                                        <td>Status</td>
                                                        <td>Grade</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Excellent</td>
                                                        <td>5</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Very Good</td>
                                                        <td>4</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Good</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Satisfying</td>
                                                        <td>2</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Less Satisfying</td>
                                                        <td>1</td>
                                                    </tr>
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
    </main>
@endsection

@section('script')
    <script></script>
@endsection
