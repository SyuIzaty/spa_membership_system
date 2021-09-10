<head>
    <meta charset="UTF-8">

    <title>Event Report</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>
    {{-- <div style="text-align: center;"><img src="{{ public_path('img/intec_logo_new.png') }}"
            style="height: 90px; width: 200px; margin-top: -30px"></div> --}}

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
                <td>
                    <h3>Total Mark</h3>
                </td>
                <td>
                    <h3>{{ $statistics_summary['mark_by_rate'] }}%</h3>
                </td>
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

    <table class="table table-bordered">
        <tr class="bg-dark text-white" style="text-transform: uppercase;">
            <td colspan="2" style="text-align: center">Charts and Visualization</td>
        </tr>
    </table>

    <div class="card">
        <div id="chart" class="row col-md-12"></div>
    </div>

    <p style="margin-bottom: -100px;">This report is computer generated, no signature required</p>

    <script>
        google.charts.load("current", {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var chartdata = {!! json_encode($chart) !!};
            var arr = [
                ['Rate', 'Total Voters', {
                    "role": "style"
                }]
            ];
            chartdata.forEach(function(ele) {
                arr.push(ele);
            });
            var data = google.visualization.arrayToDataTable(arr);
            var view = new google.visualization.DataView(data);
            var options = {
                title: "Overall Total Rate",
                width: 1000,
                height: 600,
                bar: {
                    groupWidth: "80%"
                },
                legend: {
                    position: "none"
                },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("chart"));
            chart.draw(view, options);
        }
    </script>
</body>
