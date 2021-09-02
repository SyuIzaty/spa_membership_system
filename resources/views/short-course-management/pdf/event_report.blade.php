<head>
    <meta charset="UTF-8">

    <title>Event Report</title>

    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="stylesheet" href="css/statistics/chartjs/chartjs.css.map">
    <link rel="stylesheet" href="css/statistics/chartjs/chartjs.css">
</head>

<body>
    <div style="text-align: center;"><img src="{{ public_path('img/intec_logo_new.png') }}"
            style="height: 90px; width: 200px; margin-top: -30px"></div>

    <table class="table table-bordered">
        <tr class="bg-dark text-white" style="text-transform: uppercase;">
            <td colspan="2" style="text-align: center">Event Report</td>
        </tr>
        <tbody>
            <tr>
                <td>Event ID</td>
                <td>{{ $event->id }}</td>
            </tr>
            <tr>
                <td>Event Name</td>
                <td>{{ $event->name }}</td>
            </tr>

            <tr>
                <td>Date</td>
                <td>{{ $event->datetime_start }} until {{ $event->datetime_end }}</td>
            </tr>
            <tr>
                <td>Venue</td>
                <td>{{ $event->venue->name }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Question</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($statistics as $statistic)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $statistic['question'] }}</td>
                    <td>{{ $statistic['rate_1'] }}</td>
                    <td>{{ $statistic['rate_2'] }}</td>
                    <td>{{ $statistic['rate_3'] }}</td>
                    <td>{{ $statistic['rate_4'] }}</td>
                    <td>{{ $statistic['rate_5'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-striped table-bordered">
        <tbody>
            <tr>
                <td><h3>Total Mark</h3></td>
                <td><h3>{{ $statistics_summary['mark_by_rate'] }}%</h3></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <tr class="bg-dark text-white" style="text-transform: uppercase;">
            <td colspan="2" style="text-align: center">Subjective Report</td>
        </tr>
        <tbody>
            @foreach ($comments as $comment)
                <tr>
                    <td colspan="2">{{ $comment['question'] }}</td>
                </tr>
                @foreach ($comment['answers'] as $answer)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="col-sm-10">{{ $answer }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    {{-- <div class="col-md-6">
        <div style="height:400px">
            <canvas id="applicants" class="rounded shadow"></canvas>
        </div>
    </div> --}}


    <p style="margin-bottom: -100px;">This report is computer generated, no signature required</p>


    {{-- <script>
        var ctx = document.getElementById('applicants').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                // labels:  ['SPM','A Level','O Level','STPM','STAM','KKM','SVM','IELTS','ICAEW','SKM','Foundation','Diploma','CAT','CFAB','Matriculation','Foundation','MQF','Bachelor Degree','Master','PhD','APEL','SACE'] ,
                labels: {!! json_encode($chart->labels) !!},
                datasets: [{
                    label: 'Offered applicant',
                    backgroundColor: ["#efb5ae", "#e2d6bb", "#b0d8ed", "#b0c7ed", "#b7e1e6", "#c2b8e5",
                        "#bbe2d9", "#c0ddc6", "#f6e3d8", "#fcf6f2"
                    ],
                    data: {!! json_encode($chart->dataset) !!},
                }, ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: "left",
                    labels: {
                        fontColor: '#122C4B',
                        fontFamily: "'Muli', sans-serif",
                        padding: 15,
                        boxWidth: 10,
                        fontSize: 14,
                    }
                },
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
    </script> --}}
    <script src="js/statistics/chartjs/chartjs.bundle.js"></script>
</body>
