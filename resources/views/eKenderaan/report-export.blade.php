<head>
    <meta charset="UTF-8">
    <title>E-KENDERAAN REPORT</title>
</head>

<body>
    <table width="100%">
        <tr>
            <th style="background-color: #ffe1b7;">NO</th>
            <th style="background-color: #ffe1b7;">STAFF/STUDENT ID</th>
            <th style="background-color: #ffe1b7;">NAME</th>
            <th style="background-color: #ffe1b7;">DEPARTMENT/PROGRAM</th>
            <th style="background-color: #ffe1b7;">PHONE NUMBER</th>
            <th style="background-color: #ffe1b7;">DEPARTURE DATE</th>
            <th style="background-color: #ffe1b7;">DEPARTURE TIME</th>
            <th style="background-color: #ffe1b7;">RETURN DATE</th>
            <th style="background-color: #ffe1b7;">RETURN TIME</th>
            <th style="background-color: #ffe1b7;">DESTINATION</th>
            <th style="background-color: #ffe1b7;">WAITING AREA</th>
            <th style="background-color: #ffe1b7;">PURPOSE</th>
            <th style="background-color: #ffe1b7;">DATE APPLIED</th>
            <th style="background-color: #ffe1b7;">FEEDBACK</th>
            <th style="background-color: #ffe1b7;" colspan="5">PASSENGER</th>
        </tr>

        <tr>
            <td colspan="14"></td>
            <th>NO</th>
            <th>NAME</th>
            <th>FACULTY/PROGRAMME</th>
            <th>IC</th>
            <th>ID</th>
        </tr>

        @php $i = 1;@endphp
        @foreach ($data as $d)
            <tr>
                <td style="width: 10px;">{{ $i }}</td>
                <td style="width: 50px;">{{ $d->intec_id }}</td>

                @if ($d->category == 'STF')
                    <td style="width: 200px;">{{ isset($d->staff->staff_name) ? $d->staff->staff_name : 'N/A' }}</td>
                    <td style="width: 200px;">{{ isset($d->staff->staff_dept) ? $d->staff->staff_dept : 'N/A' }}</td>
                @elseif ($d->category == 'STD')
                    <td style="width: 200px;">
                        {{ isset($d->student->students_name) ? $d->student->students_name : 'N/A' }}</td>
                    <td style="width: 200px;">
                        {{ isset($d->student->programmes->programme_name) ? $d->student->programmes->programme_name : 'N/A' }}
                    </td>
                @endif
                <td style="width: 50px;">{{ $d->phone_no }}</td>
                <td style="width: 50px;">{{ date('d/m/Y', strtotime($d->depart_date)) }}</td>
                <td style="width: 50px;">{{ date('g:i a', strtotime($d->depart_time)) }}</td>
                <td style="width: 50px;">{{ date('d/m/Y', strtotime($d->return_date)) }}</td>
                <td style="width: 50px;">{{ date('g:i a', strtotime($d->return_time)) }}</td>
                <td style="width: 250px;">{{ $d->destination }}</td>
                <td style="width: 100px;">{{ $d->waitingArea->department_name }}</td>
                <td style="width: 300px;">{{ $d->purpose }}</td>
                <td style="width: 50px;">{{ date('d/m/Y', strtotime($d->created_at)) }}</td>
                <td style="width: 250px;">{{ isset($d->feedback->remark) ? $d->feedback->remark : 'N/A' }}</td>
                @php $j = 1;@endphp
                @if (isset($d->passengers))
                    @foreach ($d->passengers as $p)
                        <td>{{ $j }}</td>
                        @if ($p->category == 'STF')
                            <td style="width: 200px;">
                                {{ isset($p->staff->staff_name) ? $p->staff->staff_name : 'N/A' }}</td>
                            <td style="width: 200px;">
                                {{ isset($p->staff->staff_dept) ? $p->staff->staff_dept : 'N/A' }}</td>
                            <td>{{ isset($p->staff->staff_ic) ? $p->staff->staff_ic : 'N/A' }}</td>
                            <td>{{ isset($p->intec_id) ? $p->intec_id : 'N/A' }}</td>
                        @elseif ($p->category == 'STD')
                            <td style="width: 200px;">
                                {{ isset($p->student->students_name) ? $p->student->students_name : 'N/A' }}</td>
                            <td style="width: 200px;">
                                {{ isset($p->student->programmes->programme_name) ? $p->student->programmes->programme_name : 'N/A' }}
                            </td>
                            <td>{{ isset($p->intec_id) ? $p->intec_id : 'N/A' }}</td>
                        @endif
                        @php $j++; @endphp
            </tr>
            <tr>
                @if ($j >= 2)
                    <td colspan="14"></td>
                    <td>{{ $j }}</td>
                    @if ($p->category == 'STF')
                        <td>{{ isset($p->staff->staff_name) ? $p->staff->staff_name : 'N/A' }}</td>
                        <td>{{ isset($p->staff->staff_dept) ? $p->staff->staff_dept : 'N/A' }}</td>
                        <td>{{ isset($p->staff->staff_ic) ? $p->staff->staff_ic : 'N/A' }}</td>
                        <td>{{ isset($p->intec_id) ? $p->intec_id : 'N/A' }}</td>
                    @elseif ($p->category == 'STD')
                        <td>{{ isset($p->student->students_name) ? $p->student->students_name : 'N/A' }}</td>
                        <td>{{ isset($p->student->programmes->programme_name) ? $p->student->programmes->programme_name : 'N/A' }}
                        </td>
                        <td>{{ isset($p->intec_id) ? $p->intec_id : 'N/A' }}</td>
                    @endif
                @endif
            </tr>
        @endforeach
        @endif
        @endforeach
        </tr>
        @php $i++; @endphp
    </table>
</body>
