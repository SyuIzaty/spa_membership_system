<head>
    <meta charset="UTF-8">

    <title>Attendance Sheet</title>

    <link rel="stylesheet" href="css/pdf.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>
    <div style="text-align: center;"><img src="{{ public_path('img/intec_logo_new.png') }}"
            style="height: 90px; width: 200px; margin-top: -30px"></div>

    <table class="table table-bordered">
        <tr class="bg-dark text-white" style="text-transform: uppercase;">
            <td colspan="2" style="text-align: center">Attendance Sheet</td>
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
    <table class="table table-bordered" width="100%" style="margin-top: 20px">
        <thead class="thead">
            <tr>
                <th class="___class_+?4___">#</th>
                <th class="col-sm-4">Name</th>
                <th class="___class_+?6___">I/C No.</th>
                <th class="___class_+?7___">Signature</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events_participants as $event_participant)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td class="col-sm-4">{{ $event_participant->participant->name }}</td>
                    <td>{{ $event_participant->participant->ic }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
