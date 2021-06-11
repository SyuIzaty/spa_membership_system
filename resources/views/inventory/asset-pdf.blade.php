@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC" style="margin-top: -40px"></center><br>

                <div align="left">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b> ASSET ID : #{{ $asset->id}}</b></h4>
                </div>

                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td rowspan="10" align="center" style="vertical-align: middle">
                                    @if(isset($image))
                                        <img src="/get-file-image/{{ $image->upload_image }}" style="width:300px; height:300px;" class="img-fluid">
                                    @else
                                        <img src="{{ asset('img/default.png') }}" style="height: 300px; width: 300px;" class="img-fluid">
                                    @endif
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="department_id"> Department : </label></td>
                                <td colspan="3">{{ isset($asset->type->department->department_name) ? $asset->type->department->department_name : '--' }}</td>
                                <td width="15%"><label class="form-label" for="asset_type"> Asset Type : </label></td>
                                <td colspan="3">{{ isset($asset->type->asset_type) ? $asset->type->asset_type : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="asset_code">Asset Code : </label></td>
                                <td colspan="3">{{ isset($asset->asset_code) ? $asset->asset_code : '--' }}</td>
                                <td width="15%"><label class="form-label" for="asset_name">Asset Name:</label></td>
                                <td colspan="3">{{ isset($asset->asset_name) ? $asset->asset_name : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="serial_no">Serial No. : </label></td>
                                <td colspan="3">{{ isset($asset->serial_no) ? $asset->serial_no : '--' }}</td>
                                <td width="15%"><label class="form-label" for="model">Model:</label></td>
                                <td colspan="3">{{ isset($asset->model) ? $asset->model : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                <td colspan="3">{{ isset($asset->brand) ? $asset->brand : '--' }}</td>
                                <td width="15%"><label class="form-label" for="status"> Availability:</label></td>
                                <td colspan="3">{{ isset($asset->invStatus->status_name) ? $asset->invStatus->status_name : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="custodian_id"> Current Custodian : </label></td>
                                <td colspan="3">{{ isset($asset->custodian->custodian->name) ? $asset->custodian->custodian->name : '--' }}</td>
                                <td width="15%"><label class="form-label" for="storage_location"> Storage:</label></td>
                                <td colspan="3">{{ isset($asset->storage_location) ? $asset->storage_location : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="purchase_date"> Purchase Date : </label></td>
                                <td colspan="3">{{ isset($asset->purchase_date) ? date('d-m-Y', strtotime($asset->purchase_date)) : '--' }}</td>
                                <td width="15%"><label class="form-label" for="vendor_name"> Vendor :</label></td>
                                <td colspan="3">{{ isset($asset->vendor_name) ? $asset->vendor_name : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="lo_no"> L.O. Number : </label></td>
                                <td colspan="3">{{ isset($asset->lo_no) ? $asset->lo_no : '--' }}</td>
                                <td width="15%"><label class="form-label" for="do_no"> D.O. Number :</label></td>
                                <td colspan="3">{{ isset($asset->do_no) ? $asset->do_no : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="io_no"> Invoice Number : </label></td>
                                <td colspan="3">{{ isset($asset->io_no) ? $asset->io_no : '--'}}</td>
                                <td width="15%"><label class="form-label" for="total_price"> Price (RM) :</label></td>
                                <td colspan="3">{{ isset($asset->total_price) ? $asset->total_price : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                <td colspan="6">{{ isset($asset->remark) ? $asset->remark : '--' }}</td>
                            </div>
                        </tr>
                    </thead>
                </table>

                <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1" style="table-layout: fixed">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td colspan="4" align="center" style="vertical-align: middle">Barcode</td>
                                <td colspan="4" align="center" style="vertical-align: middle">QRCode</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td colspan="4" align="center" style="vertical-align: middle">
                                    @php echo DNS1D::getBarcodeSVG($asset->barcode, 'C39',1.0,33,'black', false); @endphp <br>
                                    {{ $asset->barcode}}
                                </td>
                                <td colspan="4" align="center" style="vertical-align: middle">
                                    {!! QrCode::generate($asset->qrcode); !!} <br>
                                    {{ $asset->qrcode }}
                                </td>
                            </div>
                        </tr>
                    </thead>
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