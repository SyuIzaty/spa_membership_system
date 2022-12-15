@extends('layouts.public')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="row">
            <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC">
                </center>
                <h4 style="text-align: center; margin-top:10px;">
                    <b style="text-transform: uppercase">{{ $driver->driverList->name }} EVALUATION RESULT</b>
                </h4><br>
                <div class="panel-container show">
                    <div class="panel-content">
                        <table class="table table-bordered table-hover table-striped w-100">
                            <tr class="bg-dark-50 font-weight-bold text-center">
                                <td>Status</td>
                                <td>Grade</td>
                            </tr>
                            <tr class="text-center">
                                <td>Excellent</td>
                                <td>5</td>
                            </tr>
                            <tr class="text-center">
                                <td>Very Good</td>
                                <td>4</td>
                            </tr>
                            <tr class="text-center">
                                <td>Good</td>
                                <td>3</td>
                            </tr>
                            <tr class="text-center">
                                <td>Satisfying</td>
                                <td>2</td>
                            </tr>
                            <tr class="text-center">
                                <td>Less Satisfying</td>
                                <td>1</td>
                            </tr>
                        </table>

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
                                        <td class="text-center">{{ $j }}</td>
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
                    <br>
                    <div style="font-style: italic; font-size: 10px">
                        <p style="float: left">@ Copyright INTEC Education College</p>
                        <p style="float: right">Printed Date : {{ date(' d/m/Y ', strtotime(\Carbon\Carbon::now())) }}
                        </p><br>
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
