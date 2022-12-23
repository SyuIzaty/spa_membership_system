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

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label>Year</label>
                                    <select class="form-control year selectYear" name="year" id="year">
                                        <option disabled selected>Please Select</option>
                                        @foreach ($years as $y)
                                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                                {{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Month</label>
                                    <select class="form-control month selectMonth" name="month" id="month">
                                        <option disabled selected>Please Select</option>
                                        @if ($months != '')
                                            @foreach ($months as $m)
                                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                                    {{ $m }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            @if ($year == '')
                                <table class="table table-bordered table-hover table-striped w-100 text-center">
                                    <thead>
                                        <tr>
                                            <td class="bg-warning font-weight-bold">
                                                PLEASE SELECT YEAR
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            @else
                                <div class="row datas">
                                    <div class="col-sm-8">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header text-white bg-primary">

                                                @if ($year != '' && $month == '')
                                                    <h5 class="card-title w-100 text-center">EVALUATION RESULT <a
                                                            data-page="/report-driver-pdf/{{ $year }}/{{ $id }}"
                                                            style="color: black;" class="btn btn-warning float-right"
                                                            onclick="Print(this)"><i class="fal fa-file-pdf"
                                                                style="color: red; font-size: 20px"></i>
                                                            Print Report</a>
                                                    </h5>
                                                @elseif ($year != '' && $month != '')
                                                    <h5 class="card-title w-100 text-center">EVALUATION RESULT <a
                                                            data-page="/report-driver-pdf/{{ $year }}/{{ $month }}/{{ $id }}"
                                                            style="color: black;" class="btn btn-warning float-right"
                                                            onclick="Print(this)"><i class="fal fa-file-pdf"
                                                                style="color: red; font-size: 20px"></i>
                                                            Print Report</a>
                                                    </h5>
                                                @endif
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
                                                                <td>Point</td>
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
                                                                    $total = 0;
                                                                    $totalRating = 0;
                                                                @endphp
                                                                @for ($i = 5; $i >= 1; $i--)
                                                                    <td>
                                                                        {{ $data = $details->where('rating', $i)->count() }}
                                                                    </td>
                                                                    @php
                                                                        $total += $data * $i;
                                                                        $totalRating += $data;
                                                                    @endphp
                                                                @endfor

                                                                <td>{{ $total }}</td>
                                                            </tr>
                                                            <tr class="font-weight-bold text-center">
                                                                <td colspan="5">Average Rating</td>
                                                                <td>{{ number_format($total / $totalRating, 2) }}</td>
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
                                                                <td>Point</td>
                                                            </tr>
                                                            @php
                                                                $j = 1;
                                                                $datas = 0;
                                                                $totalRatings = 0;
                                                            @endphp
                                                            @foreach ($question as $q)
                                                                @php $totals = 0; @endphp

                                                                <tr>
                                                                    <td>{{ $j }}</td>
                                                                    <td>{{ $q->questionList->question }}
                                                                    </td>
                                                                    @for ($i = 5; $i >= 1; $i--)
                                                                        <td class="text-center">
                                                                            {{ $datas = $countScale->where('ekn_feedback_questions_id', $q->ekn_feedback_questions_id)->where('scale', $i)->count() }}
                                                                        </td>
                                                                        @php
                                                                            $totals += $datas * $i;
                                                                        @endphp
                                                                    @endfor
                                                                    <td class="text-center">
                                                                        {{ $totals }}
                                                                </tr>
                                                                @php
                                                                    $j++;
                                                                    $totalRatings += $totals;
                                                                @endphp
                                                            @endforeach
                                                            <tr class="font-weight-bold text-center">
                                                                <td colspan="7">Average Rating</td>
                                                                <td>{{ number_format($totalRatings / $question->count(), 2) }}
                                                                </td>
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
                                                    <table class="table table-bordered w-100">
                                                        <tr class="bg-dark-50 font-weight-bold">
                                                            <td>Status</td>
                                                            <td>Grade</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Excellent</td>
                                                            <td class="text-center">5</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Very Good</td>
                                                            <td class="text-center">4</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Good</td>
                                                            <td class="text-center">3</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Satisfying</td>
                                                            <td class="text-center">2</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Less Satisfying</td>
                                                            <td class="text-center">1</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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

        $('.selectYear').on('change', function() {
            var year = $('#year').val();
            var id = @json($id);

            window.location = "/view-driver-report/" + year + "/" + id;
        });

        $('.selectMonth').on('change', function() {
            var year = $('#year').val();
            var month = $('#month').val();
            var id = @json($id);

            window.location = "/view-driver-report/" + year + "/" + month + "/" + id;
        });
    </script>
@endsection
