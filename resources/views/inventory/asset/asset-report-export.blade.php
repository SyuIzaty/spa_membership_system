<head>
    <meta charset="UTF-8">
    <title>ASSET REPORT</title>
</head>

<body>
    <table width="100%" class="table table-bordered">
        <tr>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">ID</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">DEPARTMENT</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">CODE TYPE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">FINANCE CODE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">ASSET CODE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">ASSET NAME</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">ASSET TYPE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">ASSET CLASS</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">SERIAL NO.</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">MODEL</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">BRAND</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">INACTIVE DATE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">INACTIVE REASON</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">INACTIVE REMARK</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">AVAILABILITY</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">PRICE (RM)</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">L.O. NO.</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">D.O. NO.</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">INVOICE NO.</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">PURCHASE DATE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">VENDOR</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">ACQUISITION TYPE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">REMARK</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">CUSTODIAN</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">LOCATION</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">CREATED BY</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">STATUS</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" rowspan="2">SET PACKAGE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black" colspan="4">SET</th>
        </tr>
        <tr>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">ASSET TYPE</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">SERIAL NO.</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">MODEL</th>
            <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">BRAND</th>
        </tr>
        @foreach($data as $key => $datas)
            @php
                $count = \App\AssetSet::where('asset_id', $datas->id)->count() + 1;
            @endphp
            <tr>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->id ?? '-'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->type->department->department_name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->codeType->code_name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->finance_code  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->asset_code ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->asset_name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->type->asset_type ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->assetClass->class_name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->serial_no ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->model ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->brand ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ isset($datas->inactive_date) ? date('Y-m-d', strtotime($datas->inactive_date)) : '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->inactive_reason ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->inactive_remark ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->assetAvailability->name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->total_price ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->lo_no ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->do_no ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->io_no ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ isset($datas->purchase_date) ? date('Y-m-d', strtotime($datas->purchase_date)) : '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->vendor_name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->acquisitionType->acquisition_type ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->remark ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->custodian->name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->storage_location ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->user->name ?? '-' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">
                    @if($datas->status == 1)
                        ACTIVE
                    @else
                        INACTIVE
                    @endif
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black" rowspan="{{ $count }}">{{ $datas->set_package ?? '-'}}</td>
                @if( $datas->assetSets->first() == null )
                    <td colspan="4" style="width: 200px; text-align: center; border: 1px solid black">No set available</td>
                @endif
            </tr>
            @if( $datas->assetSets->first() != null )
                @foreach($datas->assetSets as $index => $assetSet)
                    <tr>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ $assetSet->type->asset_type ?? '-' }}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ $assetSet->serial_no ?? '-' }}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ $assetSet->model ?? '-' }}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ $assetSet->brand ?? '-' }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </table>
</body>
