@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC"></center><br>

                <div align="center">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b> ASSET {{ $asset->asset_code}} - {{ $asset->asset_name}} INFO</b></h4>
                </div>
                <br>
                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td colspan="6"><label class="form-label"> Asset Profile</label></td>
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
                                <td width="15%"><label class="form-label" for="finance_code">Asset Code (Finance):</label></td>
                                <td colspan="3">{{ $asset->finance_code ?? '--' }}</td>
                                <td width="15%"><label class="form-label" for="serial_no">Serial No. : </label></td>
                                <td colspan="3">{{ $asset->serial_no ?? '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="asset_name">Asset Name:</label></td>
                                <td colspan="6">{{ $asset->asset_name ?? '--' }}</td>
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
                                    {{ isset($asset->assetStatus->status_name) ? strtoupper($asset->assetStatus->status_name) : '--' }}
                                    <br><br>
                                    @if($asset->status == '2' || $asset->status == '3' || $asset->status == '4' || $asset->status == '5')
                                        {{$asset->assetStatus->status_name}} Date : {{ date('d-m-Y', strtotime($asset->inactive_date)) ?? '--' }}
                                    @endif
                                </td>
                                <td width="15%"><label class="form-label" for="status"> Availability:</label></td>
                                <td colspan="3">
                                    {{ isset($asset->availabilities->name) ? strtoupper($asset->availabilities->name) : '--' }}
                                    @if($asset->availability == '1')
                                        @if(isset($borrow))
                                            <br><br>
                                            <p> Current Borrower : {{$borrow->borrower->staff_name}} ({{$borrow->borrower->staff_id}})</p>
                                        @endif
                                    @endif
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="custodian_id"> Current Custodian : </label></td>
                                <td colspan="3">{{ $asset->custodians->name ?? '--' }}</td>
                                <td width="15%"><label class="form-label" for="created_by"> Created By : </label></td>
                                <td colspan="3">{{ $asset->user->name ?? '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td width="15%"><label class="form-label" for="storage_location"> Location/Storage:</label></td>
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
                            <tr>
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
                                <td colspan="3">{{ date('d-m-Y', strtotime($asset->purchase_date)) ?? '--' }}</td>
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
                                <td width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                <td colspan="6">{{ $asset->remark ?? '--' }}</td>
                            </div>
                        </tr>
                    </thead>
                </table>

                {{-- <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1" style="table-layout: fixed">
                    <thead>
                        <tr>
                            <td colspan="5" align="center" style="vertical-align: middle">Image</td>
                        </tr>
                        <tr align="center">
                            @if(isset($image->first()->upload_image))
                                @foreach($image as $images)
                                <td>
                                    <img src="/get-file-image/{{ $images->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2"><br><br>
                                </td>
                                @endforeach
                            @else
                                <span>No Image Uploaded</span>
                            @endif
                        </tr>
                    </thead>
                </table> --}}

                <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1">
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
                                    @php echo DNS1D::getBarcodeSVG($asset->asset_code, 'C39',1.0,33,'black', false); @endphp <br>
                                </td>
                                <td colspan="4" align="center" style="vertical-align: middle">
                                    {!! QrCode::generate($asset->asset_code); !!} <br>
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