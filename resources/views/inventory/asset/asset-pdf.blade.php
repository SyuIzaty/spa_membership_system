@extends('layouts.applicant')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">

                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC"></center><br><br>

                <div align="center">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b> ASSET {{ $asset->asset_code}} - {{ $asset->asset_name}}</b></h4>
                </div>
                <br>
                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td colspan="6"><label class="form-label"> Asset Detail</label></td>
                            </div>
                        </tr>
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
                                <td width="15%"><label class="form-label" for="asset_class">Asset Class :</label></td>
                                <td colspan="3">{{ $asset->asset_class ?? '--' }} - {{ $asset->assetClass->class_name ?? '--'}}</td>
                                <td width="15%"><label class="form-label" for="asset_name">Asset Name :</label></td>
                                <td colspan="3">{{ $asset->asset_name ?? '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="model">Model :</label></td>
                                <td colspan="3">{{ $asset->model ?? '--' }}</td>
                                <td width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                <td colspan="3">{{ $asset->brand ?? '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="status"> Status :</label></td>
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
                                    @php
                                        $exist = App\Rental::where('asset_id', $asset->id)->where('status', '0')->first();
                                    @endphp
                                    {{ isset($asset->assetAvailability->name) ? strtoupper($asset->assetAvailability->name) : '--' }}
                                    @if(isset($exist))
                                        <p class="mt-4">Renter : <b>{{ $exist->staff->staff_name }}</b></p>
                                    @endif
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
                                <td width="15%"><label class="form-label" for="custodian_id"> Current Custodian : </label></td>
                                <td colspan="3">{{ $asset->custodian->name ?? '--' }}</td>
                                <td width="15%"><label class="form-label" for="created_by"> Created By : </label></td>
                                <td colspan="3">{{ $asset->user->name ?? '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="storage_location"> Location:</label></td>
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
                            @if(!empty($asset->assetSets) && $asset->assetSets->count() > 0)
                                @foreach ($asset->assetSets as $sets)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
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

                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td colspan="6"><label class="form-label"> Purchase Detail</label></td>
                            </div>
                        </tr>
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

                <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td colspan="4" align="center" style="vertical-align: middle">Barcode</td>
                                <td colspan="4" align="center" style="vertical-align: middle">QRCode</td>
                            </div>
                        </tr>
                        <tr>
                            <?php
                                // $get_type = $asset->codeType->code_name ?? '--';
                                // $get_class = $asset->assetClass->class_code ?? '--';
                                // $get_department = $asset->type->department->department_name ?? '--';
                                // $get_asset = $asset->asset_code ?? '--';
                                // $get_code = $get_type.'/'.$get_class.'/'.$get_department.'/'.$get_asset;
                                $get_code = $asset->finance_code ?? '--';
                            ?>
                            <div class="form-group">
                                <td colspan="4" align="center" style="vertical-align: middle">
                                    @php echo DNS1D::getBarcodeSVG($get_code, 'C39',1.0,33,'black', false); @endphp <br>
                                    {{ $get_code }}
                                </td>
                                <td colspan="4" align="center" style="vertical-align: middle">
                                    {!! QrCode::generate($get_code); !!} <br>
                                    {{ $get_code }}
                                </td>
                            </div>
                        </tr>
                    </thead>
                </table>

                <br>
                <div style="font-size: 10px">
                    <p style="float: left">@ Copyright INTEC Education College</p>
                    <p style="float: right">Printed Date : {{ date(' j F Y | h:i:s A', strtotime($asset->updated_at) )}}</p><br>
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
