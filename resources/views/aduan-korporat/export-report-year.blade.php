<head>
    <meta charset="UTF-8">
    <title>iCOMPLAINT REPORT YEAR {{$year}}</title>
</head>
<body>
    <table width="100%">
        <tr rowspan="3"></tr>
        <tr rowspan="3"></tr>
        <tr></tr>
        <tr>
            <th style="width: 10px; background-color: #ffe1b7;">NO</th>
            <th style="width: 20px; background-color: #ffe1b7;">COMPLAINT DATE</th>
            <th style="width: 20px; background-color: #ffe1b7;">TICKET NO.</th>
            <th style="width: 50px; background-color: #ffe1b7;">NAME</th>
            <th style="width: 20px; background-color: #ffe1b7;">CONTACT NO.</th>
            <th style="width: 50px; background-color: #ffe1b7;">ADDRESS</th>
            <th style="width: 50px; background-color: #ffe1b7;">EMAIL</th>
            <th style="width: 15px; background-color: #ffe1b7;">USER CATEGORY</th>
            <th style="width: 15px; background-color: #ffe1b7;">CATEGORY</th>
            <th style="width: 15px; background-color: #ffe1b7;">SUBCATEGORY</th>
            <th style="width: 15px; background-color: #ffe1b7;">STATUS</th>
            <th style="width: 50px; background-color: #ffe1b7;">DEPARTMENT ASSIGNED</th>
            <th style="width: 50px; background-color: #ffe1b7;">COMPLAINT TITLE</th>
            <th style="width: 100px; background-color: #ffe1b7;">COMPLAINT CONTENT</th>
            <th style="width: 10px; background-color: #ffe1b7;">DURATION</th>
        </tr>

        @php $i = 1;@endphp
            @foreach($list as $l)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $l->created_at }}</td>
                    <td>{{ $l->ticket_no }}</td>
                    <td>{{ $l->name }}</td>
                    <td>{{ $l->phone_no }}</td>
                    <td>{{ $l->address }}</td>
                    <td>{{ $l->email }}</td>
                    <td>{{ $l->getUserCategory->description }}</td>
                    <td>{{ $l->getCategory->description }}</td>
                    <td>{{ isset($l->getSubCategory->description) ? $l->getSubCategory->description : 'N/A' }}</td>
                    <td>{{ $l->getStatus->description }}</td>
                    <td>{{ isset($l->getDepartment->name) ? $l->getDepartment->name : 'N/A' }}</td>
                    <td>{{ $l->title }}</td>
                    <td>{{ $l->description }}</td>
                    @if ($log->where('complaint_id',$l->id)->exists())
                        <td>{{ $l->created_at->diffInDays($date->first()->created_at) }} days</td>
                    @else
                        <td>{{ $l->created_at->diffInDays(date('Y-m-d H:i:s')) }} days</td>
                    @endif
                </tr>
                @php $i++; @endphp
            @endforeach
    </table>
</body>
