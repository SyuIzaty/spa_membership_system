<head>
    <meta charset="UTF-8">
    <title>STOCK REPORT</title>
</head>

<body>
    <table width="100%">
        @foreach($data as $key => $datas)
            <tr>
                <th style="background-color: #ffe1b7;">ID</th>
                <th style="background-color: #ffe1b7;">DEPARTMENT</th>
                <th style="background-color: #ffe1b7;">CODE</th>
                <th style="background-color: #ffe1b7;">NAME</th>
                <th style="background-color: #ffe1b7;">MODEL</th>
                <th style="background-color: #ffe1b7;">BRAND</th>
                <th style="background-color: #ffe1b7;">STATUS</th>
                <th style="background-color: #ffe1b7;">BALANCE STATUS</th>
                <th style="background-color: #ffe1b7;">APPLICABLE FOR i-STATIONERY</th>
                <th style="background-color: #ffe1b7;">CURRENT OWNER</th>
                <th style="background-color: #ffe1b7;">CREATED DATE</th>
            </tr>
            <tr>
                <td style="width: 100px;">{{ $datas->id ?? 'No Data'}}</td>
                <td style="width: 100px;">{{ $datas->departments->department_name ?? 'No Data' }}</td>
                <td style="width: 100px;">{{ $datas->stock_code ?? 'No Data' }}</td>
                <td style="width: 100px;">{{ $datas->stock_name  }}</td>
                <td style="width: 100px;">{{ $datas->model ?? 'No Data' }}</td>
                <td style="width: 100px;">{{ $datas->brand ?? 'No Data' }}</td>
                <td style="width: 100px;">
                    @if($datas->status == 1)
                        ACTIVE
                    @else
                        INACTIVE
                    @endif
                </td>
                <td style="width: 100px;">
                    @php
                        $total_bal = 0;
                        foreach($datas->transaction as $list){
                            $total_bal += ($list->stock_in - $list->stock_out);
                        }
                    @endphp
                    @if($total_bal <= 0)
                        <b>OUT OF STOCK</b>
                    @else
                        <b>READY STOCK</b>
                    @endif
                </td>
                <td style="width: 100px;">
                    @if($datas->applicable_for_stationary == 1)
                        YES
                    @else
                        NO
                    @endif
                </td>
                <td style="width: 100px;">{{ $datas->user->name ?? 'No Data' }}</td>
                <td style="width: 100px;">{{ isset($datas->created_at) ? date('Y-m-d', strtotime($datas->created_at)) : 'No Data' }}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            @if (isset($datas))
                @php $total_bal = 0; @endphp
                <tr>
                    <th style="background-color: #ffb7d1;">ID</th>
                    <th style="background-color: #ffb7d1;">STOCKIN(+)</th>
                    <th style="background-color: #ffb7d1;">STOCKOUT(-)</th>
                    <th style="background-color: #ffb7d1;">BALANCE(=)</th>
                    <th style="background-color: #ffb7d1;">UNIT PRICE (RM)</th>
                    <th style="background-color: #ffb7d1;">STATUS</th>
                    <th style="background-color: #ffb7d1;">TRANSACTION DATE</th>
                    <th style="background-color: #ffb7d1;">REMARK</th>
                    <th style="background-color: #ffb7d1;">L.O. NO</th>
                    <th style="background-color: #ffb7d1;">INVOICE NO</th>
                    <th style="background-color: #ffb7d1;">PURCHASE DATE</th>
                    <th style="background-color: #ffb7d1;">SUPPLY TYPE</th>
                    <th style="background-color: #ffb7d1;">SUPPLY TO</th>
                    <th style="background-color: #ffb7d1;">REASON</th>
                    <th style="background-color: #ffb7d1;">CREATED BY</th>
                    <th style="background-color: #ffb7d1;">CREATED AT</th>
                </tr>
                @foreach ($datas->transaction as $list)
                    <tr>
                        <td style="width: 100px;">{{ isset($list->id) ? $list->id : 'No Data'}}</td>
                        <td style="width: 100px;">{{ isset($list->stock_in) ? $list->stock_in : 'No Data'}}</td>
                        <td style="width: 100px;">{{ isset($list->stock_out) ? $list->stock_out : 'No Data'}}</td>
                        <td style="width: 100px;">{{ $total_bal += ($list->stock_in - $list->stock_out) }}</td>
                        <td style="width: 100px;">{{ isset($list->unit_price) ? $list->unit_price : 'No Data'}}</td>
                        <td style="width: 100px;">
                            @if($list->status == '1')
                                <b>IN</b>
                            @else
                                <b>OUT</b>
                            @endif
                        </td>
                        <td style="width: 100px;">{{ isset($list->trans_date) ? date('Y-m-d', strtotime($list->trans_date)) : 'No Data' }}</td>
                        <td style="width: 100px;">{{ isset($list->remark) ? $list->remark : 'No Data'}}</td>
                        <td style="width: 100px;">{{ isset($list->lo_no) ? $list->lo_no : 'No Data'}}</td>
                        <td style="width: 100px;">{{ isset($list->io_no) ? $list->io_no : 'No Data'}}</td>
                        <td style="width: 100px;">{{ isset($list->purchase_date) ? date('Y-m-d', strtotime($list->purchase_date)) : 'No Data' }}</td>
                        <td style="width: 100px;">
                            @if($list->supply_type == 'INT')
                                INTERNAL
                            @elseif($list->supply_type == 'EXT')
                                EXTERNAL
                            @else
                                No Data
                            @endif
                        </td>
                        <td style="width: 100px;">
                            @if($list->supply_type == 'INT')
                                {{ isset($list->users->name) ? strtoupper($list->users->name) : 'No Data' }}
                            @else
                                {{ isset($list->ext_supply_to) ? strtoupper($list->ext_supply_to) : 'No Data' }}
                            @endif
                        </td>
                        <td style="width: 100px;">{{ isset($list->reason) ? $list->reason : 'No Data'}}</td>
                        <td style="width: 100px;">{{ isset($list->user->name) ? strtoupper($list->user->name) : 'No Data' }}</td>
                        <td style="width: 100px;">{{ isset($list->created_at) ? date('Y-m-d', strtotime($list->created_at)) : 'No Data' }}</td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td></td>
            </tr>
        @endforeach
    </table>
</body>
