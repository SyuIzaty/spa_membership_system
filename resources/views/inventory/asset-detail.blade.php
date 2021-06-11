@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> ASSET DETAILS
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
                                    {!! Form::open(['action' => ['AssetController@assetUpdate'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                    {{Form::hidden('id', $asset->id)}}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>ASSET PROFILE</h5>
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('notification'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <div style="float: right"><i><b>Updated Date : </b>{{ date(' j F Y | h:i:s A', strtotime($asset->updated_at) )}}</i></div><br>
                                                            <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td rowspan="10" align="center" style="vertical-align: middle">
                                                                        @if(isset($image))
                                                                            <img src="/get-file-image/{{ $image->upload_image }}" style="width:300px; height:300px;" class="img-fluid">
                                                                        @else
                                                                            <img src="{{ asset('img/default.png') }}" style="height: 300px; width: 300px;" class="img-fluid">
                                                                        @endif
                                                                        <br><br>
                                                                        <input style="width: 300px" type="file" class="form-control" id="upload_image" name="upload_image">
                                                                        @error('upload_image')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="department_id" style="cursor:context-menu" name="department_id" value="{{ $asset->type->department->department_name }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="asset_type"><span class="text-danger">*</span> Asset Type : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="asset_type" style="cursor:context-menu" name="asset_type" value="{{ $asset->type->asset_type }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="asset_code"><span class="text-danger">*</span> Asset Code : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="asset_code" style="cursor:context-menu" name="asset_code" value="{{ $asset->asset_code }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="asset_name"><span class="text-danger">*</span> Asset Name:</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="asset_name" name="asset_name" value="{{ $asset->asset_name }}">
                                                                        @error('asset_name')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="serial_no"><span class="text-danger">*</span> Serial No. : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="serial_no" name="serial_no" value="{{ $asset->serial_no }}">
                                                                        @error('serial_no')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="model"><span class="text-danger">*</span> Model:</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="model" name="model" value="{{ $asset->model }}">
                                                                        @error('model')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="brand" name="brand" value="{{ $asset->brand }}">
                                                                        @error('brand')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="status"> Availability:</label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control status" name="status" id="status">
                                                                            <option value="">Select Status</option>
                                                                            @foreach ($status as $stat) 
                                                                                <option value="{{ $stat->id }}" {{ $asset->status == $stat->id ? 'selected="selected"' : '' }}>{{ $stat->status_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('status')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="custodian_id"><span class="text-danger">*</span> Current Custodian : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="custodian_id" style="cursor:context-menu" name="custodian_id" value="{{ $asset->custodian->custodian->name }}" readonly>
                                                                    </td>
                                                                    <td width="15%"><label class="form-label" for="storage_location"> Storage:</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="storage_location" name="storage_location" value="{{ $asset->storage_location }}">
                                                                        @error('storage_location')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td style="background-color: ghostwhite" width="15%"><label class="form-label" for="purchase_date"><span class="text-danger">*</span> Purchase Date : </label></td>
                                                                    <td style="background-color: ghostwhite" colspan="3">
                                                                        <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ date('Y-m-d', strtotime($asset->purchase_date)) }}" />
                                                                        @error('purchase_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td style="background-color: ghostwhite" width="15%"><label class="form-label" for="vendor_name"><span class="text-danger">*</span> Vendor :</label></td>
                                                                    <td style="background-color: ghostwhite" colspan="3">
                                                                        <input class="form-control" id="vendor_name" name="vendor_name" value="{{ $asset->vendor_name }}">
                                                                        @error('vendor_name')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td style="background-color: ghostwhite" width="15%"><label class="form-label" for="lo_no"> L.O. Number : </label></td>
                                                                    <td style="background-color: ghostwhite" colspan="3">
                                                                        <input class="form-control" id="lo_no" name="lo_no" value="{{ $asset->lo_no }}">
                                                                        @error('lo_no')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td style="background-color: ghostwhite" width="15%"><label class="form-label" for="do_no"> D.O. Number :</label></td>
                                                                    <td style="background-color: ghostwhite" colspan="3">
                                                                        <input class="form-control" id="do_no" name="do_no" value="{{ $asset->do_no }}">
                                                                        @error('do_no')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td style="background-color: ghostwhite" width="15%"><label class="form-label" for="io_no"> Invoice Number : </label></td>
                                                                    <td style="background-color: ghostwhite" colspan="3">
                                                                        <input class="form-control" id="io_no" name="io_no" value="{{ $asset->io_no }}">
                                                                        @error('io_no')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                    <td style="background-color: ghostwhite" width="15%"><label class="form-label" for="total_price"> Price (RM) :</label></td>
                                                                    <td style="background-color: ghostwhite" colspan="3">
                                                                        <input type="number" step="any" class="form-control" id="total_price" name="total_price" value="{{ $asset->total_price }}">
                                                                        @error('total_price')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td style="background-color: ghostwhite" width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                                                    <td style="background-color: ghostwhite" colspan="6">
                                                                        <textarea rows="2" class="form-control" id="remark" name="remark" >{{ $asset->remark }}</textarea>
                                                                        @error('io_no')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                    <a style="margin-right:5px; color: white" data-page="/assetPdf/{{ $asset->id }}" class="btn btn-danger ml-auto float-right" onclick="Print(this)"><i class="fal fa-download"></i> PDF</a>
                                                    <a style="margin-right:5px" href="/asset-index" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                </div>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>

                                <div class="col-md-12">
                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">

                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#code" aria-expanded="false">
                                                    <i class="fal fa-barcode width-2 fs-xl"></i>
                                                    BARCODE & QRCODE
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
                                            <div id="code" class="collapse" data-parent="#code">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1" style="table-layout: fixed">
                                                                <thead>
                                                                    <tr class="bg-primary-50">
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">

                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#cust" aria-expanded="false">
                                                    <i class="fal fa-thumbtack width-2 fs-xl"></i>
                                                    CUSTODIAN TRACK
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
                                            <div id="cust" class="collapse" data-parent="#cust">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            @if (Session::has('msg'))
                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('msg') }}</div>
                                                            @endif
                                                            @if (Session::has('noty'))
                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('noty') }}</div>
                                                            @endif
                                                            <div class="table-responsive">
                                                            <table class="table table-bordered table-hover table-striped w-100">
                                                                <thead>
                                                                    <tr align="center" class="bg-primary-50">
                                                                        <th style="width: 50px;">No.</th>
                                                                        <th>Custodian</th>
                                                                        <th>Change Reason</th>
                                                                        <th>Assign Date</th>
                                                                        <th>Assign By</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                    @foreach($asset->assetCustodian as $list)
                                                                    <tr align="center"  class="data-row">
                                                                        <td>{{ $no++ }}</td>
                                                                        <td class="custodian">{{$list->custodian->custodian->name}}</td>
                                                                        <td class="reason">{{ isset($list->reason_remark) ? $list->reason_remark : '--'}}</td>
                                                                        <td class="date">{{ date('d-m-Y | h:i A', strtotime($list->created_at)) }}</td>
                                                                        <td class="user">{{ strtoupper($list->user->name) }}</td>
                                                                        <td>
                                                                            <a href="" data-target="#crud-modals" data-toggle="modal" data-id="{{$list->id}}" data-custodian="{{$list->custodian->custodian->name}}" data-reason="{{$list->reason_remark}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                                                                            <meta name="csrf-token" content="{{ csrf_token() }}">
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </thead>
                                                            </table>
                                                            </div>
                                                            <a href="" data-target="#crud-modal" data-toggle="modal" data-depart="{{$asset->type->department_id}}" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Change Custodian</a>
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

                    <div class="modal fade" id="crud-modal" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-primary-50">
                                    <h5 class="card-title w-100">CHANGE CUSTODIAN</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'AssetController@createCustodian', 'method' => 'POST']) !!}
                                    {{Form::hidden('id', $asset->id)}}
                                    <input type="hidden" name="depart_id" id="depart" class="depart">
                                    <p><span class="text-danger">*</span> Required fields</p>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                                            <td colspan="7">
                                                <select name="department_id" id="department_id" class="department form-control" disabled>
                                                    <option value="">Select Department</option>
                                                    @foreach ($department as $depart) 
                                                        <option value="{{ $depart->id }}" {{  $asset->type->department_id == $depart->id ? 'selected="selected"' : '' }}>{{ strtoupper($depart->department_name) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('department_id')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="custodian_id"><span class="text-danger">*</span> Custodian :</label></td>
                                            <td colspan="7">
                                                <select class="form-control custodian_id" name="custodian_id" id="custodian_id" >
                                                </select>
                                                @error('custodian_id')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="reason_remark"><span class="text-danger">*</span> Reason :</label></td>
                                            <td colspan="7">
                                                <textarea rows="5" class="form-control" id="reason_remark" name="reason_remark">{{ old('reason_remark') }}</textarea>
                                                @error('reason_remark')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                     
                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="crud-modals" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-primary-50">
                                    <h5 class="card-title w-100">EDIT CUSTODIAN</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'AssetController@updateCustodian', 'method' => 'POST']) !!}
                                    {{Form::hidden('id', $asset->id)}}
                                    <input type="hidden" name="ids" id="ids">
                                    <input type="hidden" name="depart_id" id="depart" class="depart">
                                    <p><span class="text-danger">*</span> Required fields</p>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                                            <td colspan="7">
                                                <select name="department_id" id="department_id" class="department form-control" disabled>
                                                    <option value="">Select Department</option>
                                                    @foreach ($department as $depart) 
                                                        <option value="{{ $depart->id }}" {{  $asset->type->department_id == $depart->id ? 'selected="selected"' : '' }}>{{ strtoupper($depart->department_name) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('department_id')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="custodian"><span class="text-danger">*</span> Custodian :</label></td>
                                            <td colspan="7"><input class="custodian form-control" id="custodian" name="custodian" disabled>
                                                @error('custodian')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="reason_remark"><span class="text-danger">*</span> Reason :</label></td>
                                            <td colspan="7">
                                                <textarea rows="5" class="reason form-control" id="reason" name="reason_remark">{{ old('reason_remark') }}</textarea>
                                                @error('reason_remark')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                            </td>
                                        </div>
                                     
                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
                                    {!! Form::close() !!}
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

    $(document).ready(function()
    {
        $('#status').select2();

        $('.department, .custodian_id').select2({ 
            dropdownParent: $("#crud-modal") 
        });

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#crud-modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var depart = button.data('depart') 

            document.getElementById("depart").value = depart;
        });

        $('#news').click(function () {
            $('#crud-modals').modal('show');
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var custodian = button.data('custodian')
            var reason = button.data('reason')

            $('.modal-body #ids').val(id); 
            $('.modal-body #custodian').val(custodian); 
            $('.modal-body #reason').val(reason); 
        });

        if($('.department').val()!=''){
                    updateCust($('.department'));
                }
                $(document).on('change','.department',function(){
                    updateCust($(this));
                });

                function updateCust(elem){
                var eduid=elem.val();
                var op=" "; 

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findCustodian')!!}',
                    data:{'id':eduid},
                    success:function(data)
                    {
                        console.log(data)
                        op+='<option value=""> Select Custodian </option>';
                        for (var i=0; i<data.length; i++)
                        {
                            var selected = (data[i].id=="{{old('custodian_id', $asset->custodian_id)}}") ? "selected='selected'" : '';
                            op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].custodian.name+'</option>';
                        }

                        $('.custodian_id').html(op);
                    },
                    error:function(){
                        console.log('success');
                    },
                });
            }

    });

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

</script>

@endsection
