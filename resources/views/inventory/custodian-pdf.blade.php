@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC"></center><br>

                <div align="center">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b> ASSET {{ $asset->asset_code}} - {{ $asset->asset_name}} CUSTODIAN TRAIL LIST</b></h4>
                </div>
                <br><br><br>
                <table id="trk" class="table table-bordered table-hover table-striped table-sm w-100">
                    <thead>
                        <tr align="center">
                            <th>#ID</th>
                            <th>Asset Code</th>
                            <th>Finance Code</th>
                            <th>Asset Name</th>
                            <th>Custodian</th>
                            <th>Change Reason</th>
                            <th>Assign Date</th>
                            <th>Status</th>
                            <th>Verification</th>
                            <th>Verification Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asset->assetCustodian as $trails)
                        <tr align="center" style="text-transform: uppercase">
                            <td>{{ $trails->id ?? '--' }}</td>
                            <td>{{ $trails->assets->asset_code ?? '--' }}</td>
                            <td>{{ $trails->assets->finance_code ?? '--' }}</td>
                            <td>{{ $trails->assets->asset_name ?? '--' }}</td>
                            <td>{{ $trails->custodian->name ?? '--' }}</td>
                            <td>{{ $trails->reason_remark ?? '--' }}</td>
                            <td>{{ date('d-m-Y | h:i A', strtotime($trails->created_at)) ?? '--' }}</td>
                            <td>{{ $trails->custodianStatus->status_name ?? '--' }}</td>
                            <td>
                                @if($trails->verification == '1')
                                   YES
                                @else
                                   NO
                                @endif
                            </td>
                            <td>{{ isset($trails->verification_date) ? date('d-m-Y', strtotime($trails->verification_date)) : '--' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <br>
                <div style="font-style: italic; font-size: 10px">
                    <p style="float: left">@ Copyright INTEC Education College</p>
                    <p style="float: right">Review Date : {{ date(' j F Y | h:i:s A', strtotime($asset->updated_at) )}}</p><br>
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