@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> ASSET TRAIL DETAILS
        </h1>
    </div>

        <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 20px;">
                        ASSET ID : #{{ $asset->id}}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                            
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <div class="col-sm-12 mb-4">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-primary-50">
                                            <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>ASSET PROFILE</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="department_id"> Department : </label></td>
                                                            <td colspan="3">{{ $asset->type->department->department_name ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="asset_type"> Asset Type : </label></td>
                                                            <td colspan="3">{{ $asset->type->asset_type ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="asset_code">Code Type : </label></td>
                                                            <td colspan="3">{{ $asset->codeType->code_name ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="asset_code">Asset Code : </label></td>
                                                            <td colspan="3">{{ $asset->asset_code ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="finance_code">Finance Code :</label></td>
                                                            <td colspan="3">{{ $asset->finance_code ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="serial_no">Serial No. : </label></td>
                                                            <td colspan="3">{{ $asset->serial_no ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="asset_class">Asset Class:</label></td>
                                                            <td colspan="3">{{ $asset->asset_class ?? '--' }} - {{ $asset->assetClass->class_name ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="asset_name">Asset Name:</label></td>
                                                            <td colspan="3">{{ $asset->asset_name ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="model">Model:</label></td>
                                                            <td colspan="3">{{ $asset->model ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                                            <td colspan="3">{{ $asset->brand ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="status"> Status:</label></td>
                                                            <td colspan="3">
                                                                @if ($asset->status == '0')
                                                                    INACTIVE
                                                                @else
                                                                    ACTIVE
                                                                @endif
                                                                <br><br>
                                                                @if($asset->status == '0')
                                                                    Date : {{ date('d-m-Y', strtotime($asset->inactive_date)) ?? '--' }}
                                                                @endif
                                                            </td>
                                                            <td width="15%"><label class="form-label" for="status"> Availability:</label></td>
                                                            <td colspan="3">
                                                                {{ isset($asset->availabilities->name) ? strtoupper($asset->availabilities->name) : '--' }}
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    @if($asset->status == '0')
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="inactive_reason"> Reason : </label></td>
                                                            <td colspan="3">{{ $asset->assetStatus->status_name ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="inactive_remark"> Remark : </label></td>
                                                            <td colspan="3">{{ $asset->inactive_remark ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="storage_location"> Location :</label></td>
                                                            <td colspan="3">{{ $asset->storage_location ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="custodian_id"> Set Package : </label></td>
                                                            <td colspan="3">
                                                                @if($asset->set_package == 'Y') 
                                                                    YES 
                                                                @else 
                                                                    NO 
                                                                @endif
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                            @if($asset->set_package == 'Y')
                                                <table id="assets" class="table table-bordered table-hover w-100 mb-1">
                                                    <thead style="background-color: #f7f7f7" class="text-center">
                                                        <tr style="white-space: nowrap">
                                                            <td>No.</td>
                                                            <td>Package Asset Type</td>
                                                            <td>Package Serial No.</td>
                                                            <td>Package Model</td>
                                                            <td>Package Brand</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(!empty($set) && $set->count() > 0)
                                                            @foreach ($set as $sets)
                                                                <tr align="center">
                                                                    <td>{{ $num++ }}</td>
                                                                    <td>{{ $sets->type->asset_type }}</td>
                                                                    <td>{{ $sets->serial_no }}</td>
                                                                    <td>{{ $sets->model }}</td>
                                                                    <td>{{ $sets->brand }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr align="center" class="data-row">
                                                                <td valign="top" colspan="6">-- NO SET AVAILABLE --</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-4">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-primary-50">
                                            <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>PURCHASE DETAILS</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                <thead>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="purchase_date"> Purchase Date : </label></td>
                                                            <td colspan="3">{{ isset($asset->purchase_date) ? date('d-m-Y', strtotime($asset->purchase_date)) : '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="vendor_name"> Vendor :</label></td>
                                                            <td colspan="3">{{ $asset->vendor_name ??'--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="lo_no"> L.O. Number : </label></td>
                                                            <td colspan="3">{{ $asset->lo_no ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="do_no"> D.O. Number :</label></td>
                                                            <td colspan="3">{{ $asset->do_no ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="io_no"> Invoice Number : </label></td>
                                                            <td colspan="3">{{ $asset->io_no ?? '--'}}</td>
                                                            <td width="15%"><label class="form-label" for="total_price"> Price (RM) :</label></td>
                                                            <td colspan="3">{{ $asset->total_price ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="15%"><label class="form-label" for="remark"> Acquisition Type : </label></td>
                                                            <td colspan="3">{{ $asset->acquisitionType->acquisition_type ?? '--' }}</td>
                                                            <td width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                                            <td colspan="3">{{ $asset->remark ?? '--' }}</td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <a style="margin-right: 10px" href="{{ url()->previous() }}" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a>
                            </div>
                        </div>

                    </div>
                </div>
                
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
