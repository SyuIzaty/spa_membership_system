<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ICT EQUIPMENT RENTAL REPORT</title>
</head>
<body>
    <table width="100%">
        <tr>
            <th style="background-color: #ffe1b7;" colspan="8">STAFF INFORMATION</th>
            <th style="background-color: #ffe1b7;" colspan="3">EQUIPMENT RENTAL</th>
        </tr>
        <tr>
            <th style="background-color: #ffe1b7;">NO</th>
            <th style="background-color: #ffe1b7;">STAFF ID</th>
            <th style="background-color: #ffe1b7;">NAME</th>
            <th style="background-color: #ffe1b7;">DEPARTMENT</th>
            <th style="background-color: #ffe1b7;">PHONE NUMBER</th>
            <th style="background-color: #ffe1b7;">RENT DATE</th>
            <th style="background-color: #ffe1b7;">RETURN DATE</th>
            <th style="background-color: #ffe1b7;">STATUS</th>
            <th style="background-color: #ffe1b7;">EQUIPMENT NAME</th>
            <th style="background-color: #ffe1b7;">SER NO</th>
            <th style="background-color: #ffe1b7;">DESC</th>
        </tr>
        @php $i = 1;@endphp
        @foreach ($data as $d)
            <tr>
                <td style="width: 50px;">{{ $i }}</td>
                <td style="width: 100px;">{{ $d->staff_id }}</td>
                <td style="width: 200px;">{{ isset($d->name) ? $d->name : 'N/A' }}</td>
                <td style="width: 350px;">{{ isset($d->staff->staff_dept) ? $d->staff->staff_dept : 'N/A' }}</td>
                <td style="width: 350px;">{{ isset($d->hp_no) ? $d->hp_no : 'N/A' }}</td>
                <td style="width: 100px;">{{ date('d/m/Y', strtotime($d->rent_date)) }}</td>
                <td style="width: 100px;">{{ date('d/m/Y', strtotime($d->return_date)) }}</td>
                <td style="width: 250px;">{{ $d->status }}</td>
            </tr>
            @php $i++; @endphp
            @if (isset($d->equipmentRent))
                @foreach ($d->equipmentRent as $r)
                    <tr>
                        <td colspan="8"></td>
                        <td style="width: 200px;">
                            {{ isset($r->equipment->equipment_name) ? $r->equipment->equipment_name : 'N/A' }}</td>
                        <td style="width: 350px;">{{ isset($r->ser_no) ? $r->ser_no : 'N/A' }}</td>
                        <td style="width: 350px;">{{ isset($r->desc) ? $r->desc : 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </table>
</body>
</html>
