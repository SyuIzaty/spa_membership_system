<head>
    <meta charset="UTF-8">
    <title>STATIONERY REPORT</title>
</head>

<body>
    <table width="100%">
        @if($type == 'F')
            @foreach($data as $key => $datas)
                <tr>
                    <td><b> APPLICATION INFORMATION : </b></td>
                </tr>
                <tr>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICATION ID</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT ID</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT NAME</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT EMAIL</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT PHONE NO</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT DEPARTMENT</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT VERIFICATION</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICATION DATE</th>
                    <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">CURRENT STATUS</th>
                </tr>
                <tr>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->id ?? 'N/A'}}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_id ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->staff->staff_name ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_email  }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_phone ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->department->department_name ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_verification ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->created_at) ? date('d-m-Y', strtotime($datas->created_at)) : 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->status->status_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td><b> STATIONERY LIST : </b></td>
                </tr>
                @if (isset($datas))
                    <tr>
                        <th style="background-color: #b7f2ff; text-align: center; border: 1px solid black">STOCK NAME</th>
                        <th style="background-color: #b7f2ff; text-align: center; border: 1px solid black">REQUEST QUANTITY</th>
                        <th style="background-color: #b7f2ff; text-align: center; border: 1px solid black">REQUEST REMARK</th>
                        <th style="background-color: #b7f2ff; text-align: center; border: 1px solid black">APPROVE QUANTITY</th>
                        <th style="background-color: #b7f2ff; text-align: center; border: 1px solid black">APPROVE REMARK</th>
                    </tr>
                    @foreach ($datas->stationeries as $stationeryList)
                        <tr>
                            <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($stationeryList->stock->stock_name) ? $stationeryList->stock->stock_name : 'N/A'}}</td>
                            <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($stationeryList->request_quantity) ? $stationeryList->request_quantity : 'N/A'}}</td>
                            <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($stationeryList->request_remark) ? $stationeryList->request_remark : 'N/A'}}</td>
                            <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($stationeryList->approve_quantity) ? $stationeryList->approve_quantity : 'N/A'}}</td>
                            <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($stationeryList->approve_remark) ? $stationeryList->approve_remark : 'N/A'}}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            @endforeach
        @else
            <tr>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICATION ID</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT ID</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT NAME</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT EMAIL</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT PHONE NO</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT DEPARTMENT</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICANT VERIFICATION</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">APPLICATION DATE</th>
                <th style="background-color: #b7c8ff; text-align: center; border: 1px solid black">CURRENT STATUS</th>
            </tr>
            @foreach($data as $key => $datas)
                <tr>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->id ?? 'N/A'}}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_id ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->staff->staff_name ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_email  }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_phone ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->department->department_name ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->applicant_verification ?? 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->created_at) ? date('d-m-Y', strtotime($datas->created_at)) : 'N/A' }}</td>
                    <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->status->status_name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @endif
    </table>
</body>
