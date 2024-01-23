<head>
    <meta charset="UTF-8">
    <title>RENTAL REPORT</title>
</head>

<body>
    <table width="100%" class="table table-bordered">
        <tr>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">ID</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">STAFF NAME</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">ASSET CODE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">ASSET NAME</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">REASON</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">CHECKOUT DATE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">CHECKOUT BY</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">RETURN DATE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">RETURN TO</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">REMARK</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">STATUS</th>
        </tr>
        @foreach($data as $key => $datas)
            <tr>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->id ?? '-'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->staff->staff_name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->asset->asset_code ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->asset->asset_name  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->reason ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->checkout_date) ? date(' d/m/Y | h:i A ', strtotime($datas->checkout_date)) : '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->checkoutBy->name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->return_date) ? date(' d/m/Y | h:i A ', strtotime($datas->return_date)) : '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->returnTo->name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->remark ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">
                    @if($datas->status == 1)
                        RETURNED
                    @else
                        CHECKOUT
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
