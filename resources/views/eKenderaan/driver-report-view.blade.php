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
                        <h2>
                            {{ $driver->driverList->name }} <span class="fw-300"><i></i></span>
                        </h2>
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
                                            <h5 class="card-title w-100 text-center">EVALUATION RESULT <a
                                                    data-page="/report-driver-pdf/{{ $driver->driver_id }}"
                                                    style="color: black;" class="btn btn-warning float-right"
                                                    onclick="Print(this)"><i class="fal fa-file-pdf"
                                                        style="color: red; font-size: 20px"></i>
                                                    Print Report</a></h5>

                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="8" class="bg-info-50 font-weight-bold">
                                                                STAR RATING
                                                            </td>
                                                        </tr>
                                                        <tr class="font-weight-bold text-center">
                                                            <td>Excellent</td>
                                                            <td>Very Good</td>
                                                            <td>Good</td>
                                                            <td>Satisfying</td>
                                                            <td>Less Satisfying</td>
                                                            <td>Total</td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            {{-- Formula for Star Rating
                                                            AR = 1*a+2*b+3*c+4*d+5*e/(R)

                                                            Where AR is the average rating
                                                            a is the number of 1-star ratings
                                                            b is the number of 2-star ratings
                                                            c is the number of 3-star ratings
                                                            d is the number of 4-star ratings
                                                            e is the number of 5-star ratings
                                                            R is the total number of ratings --}}
                                                            @php
                                                                $count = 0;
                                                                $total = 0;
                                                                $totalAll = 0;
                                                            @endphp
                                                            @for ($i = 5; $i >= 1; $i--)
                                                                <td>
                                                                    {{ $data = $details->where('rating', $i)->count() }}
                                                                </td>
                                                                @php
                                                                    $total = $data * $i;
                                                                    $totalAll += $total;
                                                                @endphp
                                                            @endfor

                                                            <td>{{ $count = $details->count() }}</td>
                                                        </tr>
                                                        <tr class="font-weight-bold text-center">
                                                            <td colspan="5">Average Rating</td>
                                                            <td>{{ $totalAll / $count }}</td>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="8" class="bg-info-50 font-weight-bold">
                                                                QUALITY OF SERVICES
                                                            </td>
                                                        </tr>
                                                        <tr class="font-weight-bold text-center">
                                                            <td>No</td>
                                                            <td>Question</td>
                                                            <td>Excellent</td>
                                                            <td>Very Good</td>
                                                            <td>Good</td>
                                                            <td>Satisfying</td>
                                                            <td>Less Satisfying</td>
                                                            <td>Total</td>
                                                        </tr>
                                                        @php
                                                            $j = 1;
                                                            $countRating = 0;
                                                            $totalCountRating = 0;
                                                            $totalAllRating = 0;
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
                                                                <td class="text-center">
                                                                    {{ $totalRating = $countScale->where('ekn_feedback_questions_id', $q->ekn_feedback_questions_id)->count() }}
                                                                    @php $totalCountRating += $totalRating @endphp
                                                                </td>
                                                            </tr>
                                                            @php $j++ @endphp
                                                        @endforeach
                                                        <tr class="font-weight-bold text-center">
                                                            <td colspan="7">Average Rating</td>
                                                            <td>{{ $totalCountRating / $question->count() }}</td>
                                                        </tr>
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
                                                <table class="table table-bordered table-hover table-striped w-100">
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
    <script>
        function Print(button) {
            var url = $(button).data('page');
            var printWindow = window.open('{{ url('/') }}' + url + '', 'Print',
                'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            }, true);
        }
    </script>
@endsection
