<head>
    <meta charset="UTF-8">
    <title>STATIONERY REPORT</title>
</head>

<body>
    <table width="100%">
        @if($type == 'F')
            @foreach($data as $key => $datas)
                <tr>
                    <td> APPLICATION INFORMATION</td>
                </tr>
                <tr>
                    <th style="background-color: #b7c8ff;">APPLICATION ID</th>
                    <th style="background-color: #b7c8ff;">APPLICANT ID</th>
                    <th style="background-color: #b7c8ff;">APPLICANT NAME</th>
                    <th style="background-color: #b7c8ff;">APPLICANT EMAIL</th>
                    <th style="background-color: #b7c8ff;">APPLICANT PHONE NO</th>
                    <th style="background-color: #b7c8ff;">APPLICANT DEPARTMENT</th>
                    <th style="background-color: #b7c8ff;">APPLICANT VERIFICATION</th>
                    <th style="background-color: #b7c8ff;">APPLICATION DATE</th>
                    <th style="background-color: #b7c8ff;">CURRENT STATUS</th>
                </tr>
                <tr>
                    <td style="width: 100px;">{{ $datas->id ?? 'N/A'}}</td>
                    <td style="width: 100px;">{{ $datas->applicant_id ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->staff->staff_name ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->applicant_email  }}</td>
                    <td style="width: 100px;">{{ $datas->applicant_phone ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->department->department_name ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->applicant_verification ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ isset($datas->created_at) ? date('d-m-Y', strtotime($datas->created_at)) : 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->status->status_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td> STATIONERY LIST</td>
                </tr>
                @if (isset($datas))
                    <tr>
                        <th style="background-color: #b7f2ff;">ID</th>
                        <th style="background-color: #b7f2ff;">STOCK ID</th>
                        <th style="background-color: #b7f2ff;">STOCK NAME</th>
                        <th style="background-color: #b7f2ff;">REQUEST QUANTITY</th>
                        <th style="background-color: #b7f2ff;">REQUEST REMARK</th>
                        <th style="background-color: #b7f2ff;">APPROVE QUANTITY</th>
                        <th style="background-color: #b7f2ff;">APPROVE REMARK</th>
                    </tr>
                    @foreach ($datas->stationeries as $stationeryList)
                        <tr>
                            <td style="width: 100px;">{{ isset($stationeryList->id) ? $stationeryList->id : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($stationeryList->stock_id) ? $stationeryList->stock_id : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($stationeryList->stock->stock_name) ? $stationeryList->stock->stock_name : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($stationeryList->request_quantity) ? $stationeryList->request_quantity : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($stationeryList->request_remark) ? $stationeryList->request_remark : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($stationeryList->approve_quantity) ? $stationeryList->approve_quantity : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($stationeryList->approve_remark) ? $stationeryList->approve_remark : 'N/A'}}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td> STATUS TRACKING</td>
                </tr>
                @if (isset($datas))
                    <tr>
                        <th style="background-color: #b7f2ff;">ID</th>
                        <th style="background-color: #b7f2ff;">STATUS</th>
                        <th style="background-color: #b7f2ff;">REMARK</th>
                        <th style="background-color: #b7f2ff;">CHANGED BY</th>
                    </tr>
                    @foreach ($datas->applicationTracks as $trackList)
                        <tr>
                            <td style="width: 100px;">{{ isset($trackList->id) ? $trackList->id : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($trackList->status) ? $trackList->status->status_name : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($trackList->remark) ? $trackList->remark : 'N/A'}}</td>
                            <td style="width: 100px;">{{ isset($trackList->staff->staff_name) ? $trackList->staff->staff_name : 'N/A'}}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td></td>
                </tr>
            @endforeach
        @else
            <tr>
                <th style="background-color: #b7c8ff;">APPLICATION ID</th>
                <th style="background-color: #b7c8ff;">APPLICANT ID</th>
                <th style="background-color: #b7c8ff;">APPLICANT NAME</th>
                <th style="background-color: #b7c8ff;">APPLICANT EMAIL</th>
                <th style="background-color: #b7c8ff;">APPLICANT PHONE NO</th>
                <th style="background-color: #b7c8ff;">APPLICANT DEPARTMENT</th>
                <th style="background-color: #b7c8ff;">APPLICANT VERIFICATION</th>
                <th style="background-color: #b7c8ff;">APPLICATION DATE</th>
                <th style="background-color: #b7c8ff;">CURRENT STATUS</th>
            </tr>
            @foreach($data as $key => $datas)
                <tr>
                    <td style="width: 100px;">{{ $datas->id ?? 'N/A'}}</td>
                    <td style="width: 100px;">{{ $datas->applicant_id ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->staff->staff_name ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->applicant_email  }}</td>
                    <td style="width: 100px;">{{ $datas->applicant_phone ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->department->department_name ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->applicant_verification ?? 'N/A' }}</td>
                    <td style="width: 100px;">{{ isset($datas->created_at) ? date('d-m-Y', strtotime($datas->created_at)) : 'N/A' }}</td>
                    <td style="width: 100px;">{{ $datas->status->status_name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @endif
    </table>
</body>
