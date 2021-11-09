@extends('layouts.applicant')

@section('content')

<style>
    .table {
    border: 0.5px solid #000000;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > tbody > tr > th,
    .table-bordered > tfoot > tr > th,
    .table-bordered > thead > tr > td,
    .table-bordered > tbody > tr > td,
    .table-bordered > tfoot > tr > td {
    border: 0.5px solid #000000;
    }

    .table td{
        font-size: 7pt;
    }

    .table th{
        font-size: 7pt;
    }
</style>

<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 100px; font-size: 15px; color: black;">

            <center><img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="110" width="300" alt="INTEC" style="margin-top: -65px"></center><br>

                <div class="table-responsive" style="margin-top: 30px;">
                    <table class="table table-bordered table-hover table-striped small">
                        <thead>
                            <tr class="text-center">
                                @if ($my != '')
                                    <th colspan="10">COMPUTER GRANT REPORT ON {{ strtoupper($my)}}</th>
                                @else
                                    <th colspan="10">COMPUTER GRANT REPORT</th>
                                @endif
                            </tr>
                            <tr class="bg-primary-50 text-center">
                                <th class="text-center">No.</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Staff ID</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Department/Position</th>
                                <th class="text-center">Application Date</th>
                                <th class="text-center">Approval Date</th>
                                <th class="text-center">Purchase Approval Date</th>
                                <th class="text-center">Status</th>
                            </tr>
                        @if ($lists->isNotEmpty())
                                @php $i = 1; @endphp
                                @foreach ($lists as $list )
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td>{{ $list->staff->staff_name }}</td>
                                        <td class="text-center">{{ $list->staff_id }}</td>
                                        <td class="text-center">{{ $list->hp_no }}</td>
                                        <td>{{ $list->staff->staff_dept }} / {{ $list->staff->staff_position }}</td>
                                        <td class="text-center">{{ $list->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">{{ isset($list->approved_at) ? $list->approved_at->format('d/m/Y') : 'N/A' }}</td>
                                        <td class="text-center">{{ isset($list->getLog->where('activity', 'Approve purchase')->first()->created_at) ? $list->getLog->where('activity', 'Approve purchase')->first()->created_at->format('d/m/Y') : 'N/A' }}</td>
                                        <td>{{ $list->getStatus->description }}</td>
                                    </tr>
                                    
                                    @php $i++; @endphp

                                @endforeach

                            @else
                            <tr><td colspan="10" class="text-center"><b>NOT AVAILABLE</b></td></tr>                   
                        @endif
                        </thead>
                    </table>
                </div>

                <div style="float: left; margin-top: 100px; font-size: 7pt;">
                    .......................................................................................

                    <p style="margin-top: 10px;">PROFESSOR DR ROSHAYANI BINTI DATO’ ARSHAD</p>
                    <p>CHIEF EXECUTIVE</p>
                    <br>
                    <p>Date:</p>
                </div>
        </div>
    </div>
</main>
@endsection