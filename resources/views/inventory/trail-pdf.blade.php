@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC"></center><br>

                <div align="center">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b> ASSET {{ $asset->asset_code}} - {{ $asset->asset_name}} TRAIL LIST</b></h4>
                </div>
                <br><br><br>
                <table id="trk" class="table table-bordered table-hover table-striped table-sm w-100">
                    <thead>
                        <tr align="center">
                            <th>#ID</th>
                            <th>Type</th>
                            <th>Asset Code</th>
                            <th>Finance Code</th>
                            <th>Asset Name</th>
                            <th>Serial No.</th>
                            <th>Purchase Date</th>
                            <th>Vendor Name</th>
                            <th>L.O. No.</th>
                            <th>D.O. No.</th>
                            <th>Invoice No.</th>
                            <th>Price (RM)</th>
                            <th>Status</th>
                            <th>Updated By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asset->assetTrail as $trails)
                        <tr>
                            <td>{{ $trails->id ?? '--' }}</td>
                            <td>{{ $trails->codeType->code_name ?? '--' }}</td>
                            <td>{{ $trails->asset_code ?? '--' }}</td>
                            <td>{{ $trails->finance_code ?? '--' }}</td>
                            <td>{{ $trails->asset_name ?? '--' }}</td>
                            <td>{{ $trails->serial_no ?? '--' }}</td>
                            <td>{{ date('d-m-Y', strtotime($trails->purchase_date)) ?? '--' }}</td>
                            <td>{{ $trails->vendor_name ?? '--' }}</td>
                            <td>{{ $trails->lo_no ?? '--' }}</td>
                            <td>{{ $trails->do_no ?? '--' }}</td>
                            <td>{{ $trails->io_no ?? '--' }}</td>
                            <td>{{ $trails->total_price ?? '--' }}</td>
                            <td>{{ $trails->assetStatus->status_name ?? '--' }}</td>
                            <td>{{ $trails->staffs->name ?? '--' }}</td>
                            <td>{{ date('d/m/Y', strtotime($trails->created_at)) }}<br>{{ date('h:i A', strtotime($trails->created_at)) }}</td>
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