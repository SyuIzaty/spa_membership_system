<head>
    <meta charset="UTF-8">

    <title>Certificate of Partipation</title>
    <style>
        @page {
            margin: 0in;
        }

        /* img {
            background-position: top left;
            background-repeat: no-repeat;
            background-size: 100%;
            text-align: center;
        } */


        body {
            background-image: url('{{ asset('storage/shortcourse/general/Participation-CO-01.jpg') }}');
            background-position: top left;
            background-repeat: no-repeat;
            background-size: 100%;
            text-align: center;
        }

    </style>

</head>

<body>

    {{-- <img class="card-img-top" src="/get-certificate-background" alt="Card image cap"> --}}
    <p style="font-size: 25px; margin-left: 6%; margin-top: 390px;">{{ $eventParticipant->participant->name }}</p>
    <p style="font-size: 25px; margin-left: 5%; margin-top: 70px;">{{ $eventParticipant->event->name }}</p>
    <p style="font-size: 25px; margin-left: 5%; margin-top: 80px;">Participant</p>
    <p style="font-size: 25px; margin-left: 5%; margin-top: 100px;">UiTM Private Education Sdn Bhd (INTEC)</p>
    <p style="font-size: 25px; margin-left: 7%; margin-top: 70px;">
        {{ isset($eventParticipant->event->datetime_start) ? date('j F Y', strtotime($eventParticipant->event->datetime_start)) : '' }}
    </p>
    <p style="font-size: 25px; margin-left: 7%;" {{ $eventParticipant->event->days_diff > 0 ? '' : 'hidden' }}>until</p>
    <p style="font-size: 25px; margin-left: 7%;">
        {{ $eventParticipant->event->days_diff > 0 ? date('j F Y', strtotime($eventParticipant->event->datetime_end)) : '' }}
    </p>
</body>
