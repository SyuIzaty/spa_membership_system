<head>
    <meta charset="UTF-8">
    <title>STOCK REPORT</title>
</head>

<body>
    <table width="100%">
        @foreach($data as $key => $datas)
            <tr>
                <td><b> STOCK : </b></td>
            </tr>
            <tr>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">ID</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">DEPARTMENT</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">CODE</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">NAME</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">MODEL</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">BRAND</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">STATUS</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">BALANCE STATUS</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">APPLICABLE FOR i-STATIONERY</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">CURRENT OWNER</th>
                <th style="background-color: #ffe1b7; text-align: center; border: 1px solid black">CREATED DATE</th>
            </tr>
            <tr>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->id ?? 'No Data'}}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->departments->department_name ?? 'No Data' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->stock_code ?? 'No Data' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->stock_name  }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->model ?? 'No Data' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->brand ?? 'No Data' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">
                    @if($datas->status == 1)
                        ACTIVE
                    @else
                        INACTIVE
                    @endif
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black">
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
                <td style="width: 200px; text-align: center; border: 1px solid black">
                    @if($datas->applicable_for_stationary == 1)
                        YES
                    @else
                        NO
                    @endif
                </td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ $datas->user->name ?? 'No Data' }}</td>
                <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($datas->created_at) ? date('Y-m-d', strtotime($datas->created_at)) : 'No Data' }}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td><b> STOCK TRANSACTION : </b></td>
            </tr>
            @if (isset($datas))
                @php $total_bal = 0; @endphp
                <tr>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">STOCKIN(+)</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">STOCKOUT(-)</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">BALANCE(=)</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">UNIT PRICE (RM)</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">STATUS</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">TRANSACTION DATE</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">REMARK</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">L.O. NO</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">INVOICE NO</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">PURCHASE DATE</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">SUPPLY TYPE</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">SUPPLY TO</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">REASON</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">CREATED BY</th>
                    <th style="background-color: #ffb7d1; text-align: center; border: 1px solid black">CREATED AT</th>
                </tr>
                @foreach ($datas->transaction as $list)
                    <tr>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->stock_in) ? $list->stock_in : 'No Data'}}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->stock_out) ? $list->stock_out : 'No Data'}}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ $total_bal += ($list->stock_in - $list->stock_out) }}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->unit_price) ? $list->unit_price : 'No Data'}}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">
                            @if($list->status == '1')
                                <b>IN</b>
                            @else
                                <b>OUT</b>
                            @endif
                        </td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->trans_date) ? date('Y-m-d', strtotime($list->trans_date)) : 'No Data' }}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->remark) ? $list->remark : 'No Data'}}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->lo_no) ? $list->lo_no : 'No Data'}}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->io_no) ? $list->io_no : 'No Data'}}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->purchase_date) ? date('Y-m-d', strtotime($list->purchase_date)) : 'No Data' }}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">
                            @if($list->supply_type == 'INT')
                                INTERNAL
                            @elseif($list->supply_type == 'EXT')
                                EXTERNAL
                            @else
                                No Data
                            @endif
                        </td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">
                            @if($list->supply_type == 'INT')
                                {{ isset($list->users->name) ? strtoupper($list->users->name) : 'No Data' }}
                            @else
                                {{ isset($list->ext_supply_to) ? strtoupper($list->ext_supply_to) : 'No Data' }}
                            @endif
                        </td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->reason) ? $list->reason : 'No Data'}}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->user->name) ? strtoupper($list->user->name) : 'No Data' }}</td>
                        <td style="width: 200px; text-align: center; border: 1px solid black">{{ isset($list->created_at) ? date('Y-m-d', strtotime($list->created_at)) : 'No Data' }}</td>
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
    </table>
</body>
