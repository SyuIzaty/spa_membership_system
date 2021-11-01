@extends('layouts.public')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-image: url({{asset('img/inventory.png')}}); background-size: cover; background-blend-mode: difference">
                    <div class="d-flex justify-content-center" style="color: black">
                        <div class="p-2">
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" height="120" width="320" class="responsive"/></center><br>
                            <h4 style="text-align: center">
                                <b>ASSET TRACKING</b>
                            </h4>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">

                    <div class="panel-container show">
                        <div class="panel-content">
                               
                            <div class="row">
    
                                <div class="col-sm-12 col-md-6 mb-4">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body">
                                            <form action="{{ route('assetSearch') }}" method="GET" id="form_find">
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped w-100">
                                                            <tr align="center">
                                                                <td colspan="2" style="vertical-align: middle"><label class="form-label" for="asset_code"><span class="text-danger">**</span> ASSET / FINANCE CODE :</label></td>
                                                            <tr>
                                                        </table>
                                                        <table class="table w-100">
                                                            <tr align="center">
                                                                <td style="vertical-align: middle"><input class="form-control" id="asset_code" name="asset_code"></td>
                                                                <td style="vertical-align: middle"><button type="submit" id="btn-search" class="btn btn-sm btn-danger "><i class="fal fa-location-arrow"></i></button></td>
                                                            <tr>
                                                        </table>
                                                        <i><span class="text-danger">**</span> Please key in asset or finance code to view details</i>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="col-sm-12 col-md-6">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body">
                                            <form action="{{ route('assetSearch') }}" method="GET" id="form_find">
                                                <div>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped w-100">
                                                            <tr align="center">
                                                                <td style="vertical-align: middle"><label class="form-label" for="asset_code"><span class="text-danger">**</span> SCAN HERE</label></td>
                                                            <tr> 
                                                        </table>
                                                        <table class="table w-100">
                                                            <tr align="center">
                                                                <td style="vertical-align: middle"></td>
                                                            <tr>
                                                        </table>
                                                        <i><span class="text-danger">**</span> Please scan qrcode here to view details</i>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="panel-container show">
                        <div class="panel-content">
                            @if($request->asset_code != '' && isset($data))
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
                                                            <div class="table-responsive">
                                                                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                    <thead>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="department_id"> Department : </label></td>
                                                                                <td colspan="3">{{ $data->type->department->department_name ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="asset_type"> Asset Type : </label></td>
                                                                                <td colspan="3">{{ $data->type->asset_type ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="asset_code">Code Type : </label></td>
                                                                                <td colspan="3">{{ $data->codeType->code_name ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="asset_code">Asset Code : </label></td>
                                                                                <td colspan="3">{{ $data->asset_code ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="finance_code">Finance Code :</label></td>
                                                                                <td colspan="3">{{ $data->finance_code ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="serial_no">Serial No. : </label></td>
                                                                                <td colspan="3">{{ $data->serial_no ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="asset_name">Asset Class :</label></td>
                                                                                <td colspan="3">{{ $data->assetClass->class_name ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="asset_name">Asset Name :</label></td>
                                                                                <td colspan="3">{{ $data->asset_name ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="model">Model :</label></td>
                                                                                <td colspan="3">{{ $data->model ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                                                                <td colspan="3">{{ $data->brand ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="created_by"> Created By : </label></td>
                                                                                <td colspan="3">{{ $data->user->name ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="custodian_id"> Current Custodian : </label></td>
                                                                                <td colspan="3">{{ $data->custodians->name ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="status"> Status :</label></td>
                                                                                <td colspan="3">
                                                                                    @if ($data->status == '0')
                                                                                        INACTIVE
                                                                                    @else
                                                                                        ACTIVE
                                                                                    @endif
                                                                                    <br><br>
                                                                                    @if($data->status == '0')
                                                                                        Date : {{ date('d-m-Y', strtotime($data->inactive_date)) ?? '--' }}
                                                                                    @endif
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="status"> Availability :</label></td>
                                                                                <td colspan="3">
                                                                                    {{ isset($data->availabilities->name) ? strtoupper($data->availabilities->name) : '--' }}
                                                                                    @if($data->availability == '1')
                                                                                        @if(isset($data->assetBorrower))
                                                                                            <br><br>
                                                                                            <p> Current Borrower : {{$data->assetBorrower->borrower->staff_name}} ({{$data->assetBorrower->borrower->staff_id}})</p>
                                                                                        @endif
                                                                                    @endif
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        @if($data->status == '0')
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="inactive_reason"> Reason : </label></td>
                                                                                <td colspan="3">{{ $data->assetStatus->status_name ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="inactive_remark"> Remark : </label></td>
                                                                                <td colspan="3">{{ $data->inactive_remark ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="storage_location"> Location :</label></td>
                                                                                <td colspan="3">{{ $data->storage_location ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="custodian_id"> Set Package : </label></td>
                                                                                <td colspan="3">
                                                                                    @if($data->set_package == 'Y') 
                                                                                        YES 
                                                                                    @else 
                                                                                        NO 
                                                                                    @endif
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            @if($data->set_package == 'Y')
                                                            <div class="table-responsive">
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
                                                                        @if(!empty($data->assetSet) && $data->assetSet->count() > 0)
                                                                            @foreach ($data->assetSet as $sets)
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
                                                            <div class="table-responsive">
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
                                                            <div class="table-responsive">
                                                                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                    <thead>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="purchase_date"> Purchase Date : </label></td>
                                                                                <td colspan="3">{{ date('d-m-Y', strtotime($data->purchase_date)) ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="vendor_name"> Vendor :</label></td>
                                                                                <td colspan="3">{{ $data->vendor_name ??'--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="lo_no"> L.O. Number : </label></td>
                                                                                <td colspan="3">{{ $data->lo_no ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="do_no"> D.O. Number :</label></td>
                                                                                <td colspan="3">{{ $data->do_no ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="io_no"> Invoice Number : </label></td>
                                                                                <td colspan="3">{{ $data->io_no ?? '--'}}</td>
                                                                                <td width="15%"><label class="form-label" for="total_price"> Price (RM) :</label></td>
                                                                                <td colspan="3">{{ $data->total_price ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="remark"> Acquisition Type : </label></td>
                                                                                <td colspan="3">{{ $data->acquisitionType->acquisition_type ?? '--' }}</td>
                                                                                <td width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                                                                <td colspan="3">{{ $data->remark ?? '--' }}</td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#image" aria-expanded="false">
                                                                    <i class="fal fa-camera width-2 fs-xl"></i>
                                                                    ASSET IMAGE
                                                                    <span class="ml-auto">
                                                                        <span class="collapsed-reveal">
                                                                            <i class="fal fa-minus fs-xl"></i>
                                                                        </span>
                                                                        <span class="collapsed-hidden">
                                                                            <i class="fal fa-plus fs-xl"></i>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div id="image" class="collapse" data-parent="#image">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1" style="table-layout: fixed">
                                                                                <thead>
                                                                                    <tr align="center">
                                                                                        @if(isset($data->assetImage->first()->upload_image))
                                                                                            @foreach($data->assetImage as $images)
                                                                                            <td colspan="5">
                                                                                                <a data-fancybox="gallery" href="/get-file-image/{{ $images->upload_image }}"><img src="/get-file-image/{{ $images->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2"></a><br><br>
                                                                                            </td>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <span>No Image Uploaded</span>
                                                                                        @endif
                                                                                    </tr>
                                                                                </thead>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                
                                            </div>
                                        </div>
                
                                    </div>
                                </div>
                            @else
                                <div align="center">No Details Available</div>
                            @endif
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
        
        // $("#datek, #cates").change(function(){
        //     $("#form_find").submit();
        // })

        $(document).ready(function() {
            $('#asset_code').on('click', '#btn-search', function(e) {
                e.preventDefault();
                $("#form_find").submit();
            });
        });

    </script>
@endsection
