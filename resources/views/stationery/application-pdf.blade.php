@extends('layouts.applicant')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
            <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center>
            <h4 style="text-align: center">
                <b>I-STATIONERY APPLICATION #{{ $application->id }}</b>
                <p><span style="text-transform: uppercase; font-size: 15px"><b>[ {{ $application->status->status_name ?? 'N/A' }} ]</b></span></p>
            </h4><br>

            <div class="panel-container show">
                <div class="panel-content">
                    <div class="table-responsive">
                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                            <li>
                                <a href="#" disabled style="pointer-events: none">
                                    <i class="fal fa-user"></i>
                                    <span class=""> APPLICANT INFORMATION</span>
                                </a>
                            </li>
                            <p></p>
                        </ol>
                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                            <tr>
                                <th style="vertical-align: middle">Name : </th>
                                <td  style="vertical-align: middle; text-transform: uppercase">{{ $application->staff->staff_name }} ({{ $application->applicant_id }})</td>
                                <th  style="vertical-align: middle">Email : </th>
                                <td  style="vertical-align: middle">{{ $application->applicant_email }}</td>
                            </tr>
                            <tr>
                                <th  style="vertical-align: middle">Department : </th>
                                <td  style="vertical-align: middle; text-transform: uppercase">{{ $application->department->department_name }}</td>
                                <th  style="vertical-align: middle">Phone Number : </th>
                                <td  style="vertical-align: middle; text-transform: uppercase">{{ $application->applicant_phone }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                            <li>
                                <a href="#" disabled style="pointer-events: none">
                                    <i class="fal fa-info"></i>
                                    <span class=""> STATIONERY INFORMATION</span>
                                </a>
                            </li>
                            <p></p>
                        </ol>
                        <div class="form-group" id="stationery">
                            <table class="table table-bordered table-hover table-striped w-100 text-center">
                                <tr class="bg-primary-50">
                                    <th>No</th>
                                    <th>Item/Description</th>
                                    <th>Request Quantity</th>
                                    <th>Request Remark</th>
                                    @if(!in_array($application->current_status, ['RV', 'RA']))
                                        @if($application->applicant_id == Auth::user()->id)
                                            @if(in_array($application->current_status, ['AC', 'CP', 'RC']))
                                                <th>Approve Quantity</th>
                                                <th>Approve Remark</th>
                                            @endif
                                        @else
                                            @if(Auth::user()->hasPermissionTo('Manage Stationery'))
                                                @if($application->current_status == 'NA')
                                                    <th class="appStationery" style="display: none;">Approve Quantity</th>
                                                    <th class="appStationery" style="display: none;">Approve Remark</th>
                                                @else
                                                    <th>Approve Quantity</th>
                                                    <th>Approve Remark</th>
                                                @endif
                                            @else
                                                @if(in_array($application->current_status, ['PA', 'AC', 'CP', 'RC']))
                                                    <th>Approve Quantity</th>
                                                    <th>Approve Remark</th>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </tr>
                                @foreach($application->stationeries as $stationery)
                                        <tr>
                                        <td style="vertical-align:middle">{{ $loop->iteration }}</td>
                                        <td align="left" style="vertical-align:middle">{{ $stationery->stock->stock_name ?? 'N/A' }}</td>
                                        <td style="vertical-align:middle">{{ $stationery->request_quantity ?? 'N/A' }}</td>
                                        <td style="vertical-align:middle">{{ $stationery->request_remark ?? 'N/A' }}</td>
                                        @if(!in_array($application->current_status, ['RV', 'RA']))
                                            @if($application->applicant_id == Auth::user()->id)
                                                @if(in_array($application->current_status, ['AC', 'CP', 'RC']))
                                                    <td>{{ $stationery->approve_quantity ?? 'N/A' }}</td>
                                                    <td>{{ $stationery->approve_remark ?? 'N/A' }}</td>
                                                @endif
                                            @else
                                                @if(Auth::user()->hasPermissionTo('Manage Stationery'))
                                                    @if($application->current_status == 'NA')
                                                        <td class="appStationery" style="display: none;">
                                                            @php
                                                                $total_bal = 0;
                                                                $stockId = $stationery->stock_id;
                                                                $stockData = \App\Stock::where('id', $stockId)->first();

                                                                if ($stockData) {
                                                                    foreach ($stockData->transaction as $list) {
                                                                        $total_bal += ($list->stock_in - $list->stock_out);
                                                                    }

                                                                    $numbers = $total_bal > 0 ? range(1, $total_bal) : [];
                                                                }
                                                            @endphp
                                                            <select class="form-control approve_quantity" name="approve_quantity[]" id="approve_quantity_{{ $loop->index }}">
                                                                <option value="" disabled selected>Please select</option>
                                                                @foreach ($numbers as $value)
                                                                    <option value="{{ $value }}" {{ old('approve_quantity') !== null && old('approve_quantity') == $value ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="appStationery" style="display: none;">
                                                            <input class="form-control" id="approve_remark" name="approve_remark[]" value="{{ old('approve_remark') }}">
                                                        </td>
                                                    @else
                                                        <td>{{ $stationery->approve_quantity ?? 'N/A' }}</td>
                                                        <td>{{ $stationery->approve_remark ?? 'N/A' }}</td>
                                                    @endif
                                                @else
                                                    @if(in_array($application->current_status, ['PA', 'AC', 'CP', 'RC']))
                                                        <td>{{ $stationery->approve_quantity ?? 'N/A' }}</td>
                                                        <td>{{ $stationery->approve_remark ?? 'N/A' }}</td>
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    @php
                        $trackData = \App\IsmApplicationTrack::where('application_id', $application->id)
                            ->where('status_id', $application->current_status)
                            ->first();
                    @endphp

                    {{-- @unless(Auth::user()->hasPermissionTo('Manage Stationery') || Auth::user()->hasPermissionTo('Manage Approval')) --}}
                        @if($application->current_status == 'RV' || $application->current_status == 'RA')
                            <div class="table-responsive">
                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                    <li>
                                        <a href="#" disabled style="pointer-events: none">
                                            <i class="fal fa-eye"></i>
                                            <span class=""> REJECTION INFORMATION</span>
                                        </a>
                                    </li>
                                    <p></p>
                                </ol>
                                <table id="info" class="table table-bordered table-hover w-100">
                                    <tr>
                                        <th style="vertical-align: middle">Remark : </th>
                                        <td  style="vertical-align: middle">{{ ucwords($trackData->remark) ?? 'N/A' }}</td>
                                        <th  style="vertical-align: middle">Date : </th>
                                        <td  style="vertical-align: middle">{{ isset($trackData->created_at) ? date('d-m-Y', strtotime($trackData->created_at)) . ' | ' . date('h:i A', strtotime($trackData->created_at)) : 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        @endif
                    {{-- @endunless --}}

                    @if($application->applicant_id == Auth::user()->id)
                        <div class="table-responsive">
                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                <li>
                                    <a href="#" disabled style="pointer-events: none">
                                        <i class="fal fa-check-square"></i>
                                        <span class=""> CONSENT VERIFICATION</span>
                                    </a>
                                </li>
                                <p></p>
                            </ol>
                            <table id="verification" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <div class="form-group">
                                            <td colspan="4"><p class="form-label" for="applicant_verification">
                                            <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px" type="checkbox" @if($application->applicant_verification == 'Y') disabled checked @endif/>
                                            ALL INFORMATION PROVIDED ARE ACCURATE. I CONSENT TO BE CONTACTED FOR ANY FURTHER INQUIRIES RELATED TO THE SUBMITTED APPLICATION.
                                        </div>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                    @if($application->current_status == 'CP')
                        <div class="table-responsive">
                            <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                <li>
                                    <a href="#" disabled style="pointer-events: none">
                                        <i class="fal fa-check-square"></i>
                                        <span class=""> CONFIRMATION</span>
                                    </a>
                                </li>
                                <p></p>
                            </ol>
                            <table id="verification" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr>
                                        <div class="form-group">
                                            <td colspan="4"><p class="form-label">
                                            <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px" type="checkbox" disabled checked/>
                                                THIS APPLICATION HAVE BEEN SUCCESSFULLY CONFIRMED ON
                                                {{ isset($trackData->created_at) ? date('d-m-Y', strtotime($trackData->created_at)) . ' ( '. date('l', strtotime($trackData->created_at)) .' ) | ' . date('h:i A', strtotime($trackData->created_at)).'.' : 'N/A' }}
                                        </div>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    @endif
                 </div>
                <br>
                <div style="font-size: 10px">
                    <p style="float: left">@ Copyright INTEC Education College</p>
                    <p style="float: right">Printed Date : {{ date(' d/m/Y ', strtotime( \Carbon\Carbon::now()) )}}</p><br>
                </div>
        </div>
    </div>
</main>

@endsection

@section('script')
<script>
    //
</script>
@endsection

