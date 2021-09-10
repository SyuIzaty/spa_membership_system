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
                                <div class="col-auto">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link mb-2 active" id="asset-tab" data-toggle="pill" href="#asset" role="tab" aria-controls="asset" aria-selected="false" style="border: 1px solid;">
                                            <i class="fal fa-info-circle"></i>
                                            <span class="hidden-sm-down ml-1"> ASSET INFO</span>
                                        </a>
                                        <a class="nav-link mb-2" id="purchase-tab" data-toggle="pill" href="#purchase" role="tab" aria-controls="purchase" aria-selected="false" style="border: 1px solid;">
                                            <i class="fal fa-list"></i>
                                            <span class="hidden-sm-down ml-1"> PURCHASE INFO</span>
                                        </a>
                                        <a class="nav-link mb-2" id="track-tab" data-toggle="pill" href="#track" role="tab" aria-controls="track" aria-selected="false" style="border: 1px solid;">
                                            <i class="fal fa-road"></i>
                                            <span class="hidden-sm-down ml-1"> ASSET TRAIL</span>
                                        </a>
                                        <a class="nav-link mb-2" id="custodian-tab" data-toggle="pill" href="#custodian" role="tab" aria-controls="custodian" aria-selected="false" style="border: 1px solid;">
                                            <i class="fal fa-book"></i>
                                            <span class="hidden-sm-down ml-1"> CUSTODIAN TRACK</span>
                                        </a>
                                        <a class="nav-link mb-2" data-page="/assetPdf/{{ $asset->id }}" onclick="Print(this)" style="font-weight: 500; cursor: pointer; color: #886ab5; border: 1px solid"><i class="fal fa-download"></i> DOWNLOAD PDF</a>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane active" id="asset" role="tabpanel" style="margin-top: -18px"><br>
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
                                                                                <td width="15%"><label class="form-label" for="department_id"> Department : </label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="department_id" style="cursor:context-menu" name="department_id" value="{{ strtoupper($asset->type->department->department_name) }}" readonly>
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="asset_type"> Asset Type : </label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="asset_type" style="cursor:context-menu" name="asset_type" value="{{ $asset->type->asset_type }}" readonly>
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="asset_code"> Asset Code : </label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="asset_code" style="cursor:context-menu" name="asset_code" value="{{ $asset->asset_code }}" readonly>
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="finance_code"> Asset Code (Finance):</label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="finance_code" name="finance_code" value="{{ $asset->finance_code }}">
                                                                                    @error('finance_code')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="asset_code_type"><span class="text-danger">*</span> Code Type:</label></td>
                                                                                <td colspan="3">
                                                                                    <select class="form-control asset_code_type" name="asset_code_type" id="asset_code_type">
                                                                                        <option value="">Please Select</option>
                                                                                        @foreach ($codeType as $codeTypes) 
                                                                                            <option value="{{ $codeTypes->id }}" {{ $asset->asset_code_type == $codeTypes->id ? 'selected="selected"' : '' }}>{{ $codeTypes->id }} - {{ $codeTypes->code_name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('asset_code_type')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="asset_name"><span class="text-danger">*</span> Asset Name:</label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="asset_name" name="asset_name" value="{{ $asset->asset_name }}" style="text-transform: uppercase">
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
                                                                                    <input class="form-control" id="serial_no" name="serial_no" value="{{ $asset->serial_no }}" style="text-transform: uppercase">
                                                                                    @error('serial_no')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="model"><span class="text-danger">*</span> Model:</label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="model" name="model" value="{{ $asset->model }}" style="text-transform: uppercase">
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
                                                                                    <input class="form-control" id="brand" name="brand" value="{{ $asset->brand }}" style="text-transform: uppercase">
                                                                                    @error('brand')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="storage_location"> Location/Storage:</label></td>
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
                                                                                <td width="15%"><label class="form-label" for="status"><span class="text-danger">*</span> Status:</label></td>
                                                                                <td colspan="3">
                                                                                    <select class="form-control status" name="status" id="status">
                                                                                        <option value="">Select Status</option>
                                                                                        @foreach ($status as $statuss) 
                                                                                            <option value="{{ $statuss->id }}" {{ old('status', ($asset->status ? $asset->assetStatus->id : '')) ==  $statuss->id  ? 'selected' : '' }}>
                                                                                                {{ $statuss->status_name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('status')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                    <br><br>
                                                                                    <input type="date" class="form-control inactive" id="inactive_date" name="inactive_date" value="{{ isset($asset->inactive_date) ? date('Y-m-d', strtotime($asset->inactive_date)) : old('inactive_date') }}"/>
                                                                                    @error('inactive_date')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="availability"> Availability:</label></td>
                                                                                <td colspan="3">
                                                                                    <select class="form-control availability" name="availability" id="availability">
                                                                                        <option value="">Select Availability</option>
                                                                                        @foreach ($availability as $available) 
                                                                                            <option value="{{ $available->id }}" {{ $asset->availability == $available->id ? 'selected="selected"' : '' }}>{{ $available->name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @error('availability')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
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
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="custodian_id" style="cursor:context-menu" name="custodian_id" value="{{ $asset->custodians->name }}" readonly>
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="created_by"> Created By : </label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="created_by" style="cursor:context-menu" name="created_by" value="{{ $asset->user->name }}" readonly>
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="upload_image"> Image :</label></td>
                                                                                <td colspan="3">
                                                                                    <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple>
                                                                                    @error('upload_image')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="set_package"><span class="text-danger">*</span> Set Package ?</label></td>
                                                                                <td colspan="3">
                                                                                    <input class="ml-5" type="radio" name="set_package" id="set_package" value="Y" {{ $asset->set_package == "Y" ? 'checked="checked"' : ''}}> Yes
                                                                                    <input class="ml-5" type="radio" name="set_package" id="set_package" value="N" {{ $asset->set_package == "N" ? 'checked="checked"' : '' }}> No
                                                                                    @error('set_package')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr class="set_tab">
                                                                            <div class="form-group">
                                                                                <td colspan="6">
                                                                                    <div class="card-body test" id="test">
                                                                                        <table class="table table-bordered text-center" id="head_field">
                                                                                            <tr class="bg-primary-50">
                                                                                                <td>Asset Type</td>
                                                                                                <td>Serial No.</td>
                                                                                                <td>Model</td>
                                                                                                <td>Brand</td>
                                                                                                <td></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <select class="form-control asset_types" name="asset_types[]" id="asset_types" >
                                                                                                        <option value="">Select Asset Type</option>
                                                                                                        @foreach ($setType as $setTypes) 
                                                                                                            <option value="{{ $setTypes->id }}" {{ old('asset_types') ==  $setTypes->id  ? 'selected' : '' }}>{{ $setTypes->asset_type }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </td>
                                                                                                <td><input name="serial_nos[]" class="form-control serial_nos"/></td>
                                                                                                <td><input name="models[]" class="form-control models"/></td>
                                                                                                <td><input name="brands[]" class="form-control brands"/></td>
                                                                                                <td style="vertical-align: middle"><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                                <a style="margin-right:5px" href="/asset-index" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {!! Form::close() !!}
                                            </div>

                                            @if($asset->set_package == 'Y')
                                                <div class="col-md-12">
                                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#set" aria-expanded="false">
                                                                    <i class="fal fa-info width-2 fs-xl"></i>
                                                                    SET INFO
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
                                                            <div id="set" class="collapse" data-parent="#set">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            @if (Session::has('notySet'))
                                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notySet') }}</div>
                                                                            @endif
                                                                            @if (Session::has('messages'))
                                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('messages') }}</div>
                                                                            @endif
                                                                            <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                                <thead class="bg-primary-50 text-center">
                                                                                    <tr>
                                                                                        <td>No.</td>
                                                                                        <td>Asset Type</td>
                                                                                        <td>Serial No.</td>
                                                                                        <td>Model</td>
                                                                                        <td>Brand</td>
                                                                                        <td>Action</td>
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
                                                                                                <td>
                                                                                                    <a href="" data-target="#crud-modal3" data-toggle="modal" data-id="{{$sets->id}}" data-asset="{{$sets->asset_id}}" data-type="{{$sets->asset_type}}" data-serial="{{$sets->serial_no}}" data-model="{{$sets->model}}" data-brand="{{$sets->brand}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                                                                                                    <a href="{{ action('AssetController@deleteSet', ['id' => $sets->id, 'asset_id' => $sets->asset_id]) }}" class="btn btn-danger btn-sm"><i class="fal fa-trash"></i></a>
                                                                                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <tr align="center" class="data-row">
                                                                                            <td valign="top" colspan="6" class="dataTables_empty">-- NO SET AVAILABLE --</td>
                                                                                        </tr>
                                                                                    @endif
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

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
                                                                                    @if(isset($image->first()->upload_image))
                                                                                        @foreach($image as $images)
                                                                                        <td colspan="5">
                                                                                            <a data-fancybox="gallery" href="/get-file-image/{{ $images->upload_image }}"><img src="/get-file-image/{{ $images->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2"></a><br><br>
                                                                                            <a href="{{ action('AssetController@deleteImage', ['id' => $images->id, 'asset_id' => $images->asset_id]) }}" class="btn btn-danger btn-sm"><i class="fal fa-trash"></i> Delete</a>
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
                                                                                            @php echo DNS1D::getBarcodeSVG($asset->asset_code, 'C39',1.0,33,'black', false); @endphp <br>
                                                                                            {{-- {{ $asset->asset_code}} --}}
                                                                                        </td>
                                                                                        <td colspan="4" align="center" style="vertical-align: middle">
                                                                                            {!! QrCode::generate($asset->asset_code); !!} <br>
                                                                                            {{-- {{ $asset->asset_code }} --}}
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
                                        </div>

                                        <div class="tab-pane" id="purchase" role="tabpanel" style="margin-top: -18px"><br>
                                            <div class="col-sm-12 mb-4">
                                                {!! Form::open(['action' => ['AssetController@assetPurchaseUpdate'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                                {{Form::hidden('id', $asset->id)}}
                                                    <div class="card card-primary card-outline">
                                                        <div class="card-header">
                                                            <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>PURCHASE DETAILS</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            @if (Session::has('notifications'))
                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notifications') }}</div>
                                                            @endif
                                                            <div class="table-responsive">
                                                                <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                    <thead>
                                                                        <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="purchase_date"><span class="text-danger">*</span> Purchase Date : </label></td>
                                                                                <td colspan="3">
                                                                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ date('Y-m-d', strtotime($asset->purchase_date)) }}" />
                                                                                    @error('purchase_date')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="vendor_name"><span class="text-danger">*</span> Vendor :</label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="vendor_name" name="vendor_name" value="{{ $asset->vendor_name }}">
                                                                                    @error('vendor_name')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="lo_no"> L.O. Number : </label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="lo_no" name="lo_no" value="{{ $asset->lo_no }}">
                                                                                    @error('lo_no')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="do_no"> D.O. Number :</label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="do_no" name="do_no" value="{{ $asset->do_no }}">
                                                                                    @error('do_no')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="io_no"> Invoice Number : </label></td>
                                                                                <td colspan="3">
                                                                                    <input class="form-control" id="io_no" name="io_no" value="{{ $asset->io_no }}">
                                                                                    @error('io_no')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                                <td width="15%"><label class="form-label" for="total_price"> Price (RM) :</label></td>
                                                                                <td colspan="3">
                                                                                    <input type="number" step="any" class="form-control" id="total_price" name="total_price" value="{{ $asset->total_price }}">
                                                                                    @error('total_price')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                        <tr>
                                                                            <div class="form-group">
                                                                                <td width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                                                                <td colspan="6">
                                                                                    <textarea rows="5" class="form-control" id="remark" name="remark" >{{ $asset->remark }}</textarea>
                                                                                    @error('remark')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                                </td>
                                                                            </div>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                                <a style="margin-right:5px" href="/asset-index" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="track" role="tabpanel" style="margin-top: -18px"><br>
                                            <div class="col-sm-12 mb-4">
                                                <div class="table-responsive">
                                                    <table id="trk" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr align="center" class="bg-primary-50">
                                                                <th>#ID</th>
                                                                <th>Code Type</th>
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
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($assetTrail as $trails)
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
                                                                <td><a href="/asset-trail/{{ $trails->id }}" class="btn btn-sm btn-info"><i class="fal fa-eye"></i></a></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                                <a style="color: white" data-page="/trailPdf/{{ $asset->id }}" class="btn btn-danger ml-auto float-right" onclick="Print(this)"><i class="fal fa-download"></i> PDF</a>
                                                <a style="margin-right:5px" href="/asset-index" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="custodian" role="tabpanel" style="margin-top: -18px"><br>
                                            <div class="col-sm-12 mb-4">
                                                @if (Session::has('msg'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('msg') }}</div>
                                                @endif
                                                @if (Session::has('noty'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('noty') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table id="cst" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr align="center" class="bg-primary-50">
                                                                <th style="width: 50px;">No.</th>
                                                                <th>Custodian</th>
                                                                <th>Change Reason</th>
                                                                <th>Assign Date</th>
                                                                <th>Assign By</th>
                                                                <th>Verification</th>
                                                                <th>Verify Date</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($asset->assetCustodian as $list)
                                                            <tr align="center"  class="data-row">
                                                                <td>{{ $no++ }}</td>
                                                                <td class="custodian">{{$list->custodian->name}}</td>
                                                                <td class="reason">{{ isset($list->reason_remark) ? $list->reason_remark : '--'}}</td>
                                                                <td class="date">{{ date('d-m-Y | h:i A', strtotime($list->created_at)) }}</td>
                                                                <td class="user">{{ strtoupper($list->user->name) }}</td>
                                                                <td class="user">
                                                                    @if($list->verification == '1')
                                                                        <p style="color: green"><b>YES</b></p>
                                                                    @else
                                                                        <p style="color: red"><b>NO</b></p>
                                                                    @endif
                                                                </td>
                                                                <td class="date">{{ isset($list->verification_date) ? date('d-m-Y | h:i A', strtotime($list->verification_date)) : '--' }}</td>
                                                                <td class="user">{{ isset($list->status) ? strtoupper($list->custodianStatus->status_name) : '--' }}</td>
                                                                <td>
                                                                    <a href="" data-target="#crud-modal2" data-toggle="modal" data-id="{{$list->id}}" data-custodian="{{$list->custodian->name}}" data-reason="{{$list->reason_remark}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                                                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                                <a href="" data-target="#crud-modal" data-toggle="modal" data-depart="{{$asset->type->department_id}}" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Change Custodian</a>
                                                <a style="color: white; margin-right:5px" data-page="/custodianPdf/{{ $asset->id }}" class="btn btn-danger ml-auto float-right" onclick="Print(this)"><i class="fal fa-download"></i> PDF</a>
                                                <a style="margin-right:5px" href="/asset-index" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>

                    <div class="modal fade" id="crud-modal" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-user width-2 fs-xl"></i>CHANGE CUSTODIAN</h5>
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
                                                <select class="form-control custodian_id" name="custodian_id" id="custodian_id" required>
                                                    <option value="">Select Custodian</option>
                                                    @foreach ($custodian as $custs) 
                                                        <option value="{{ $custs->id }}" {{ old('custodian_id') ==  $custs->id  ? 'selected' : '' }}>{{ $custs->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('custodian_id')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="reason_remark"><span class="text-danger">*</span> Reason :</label></td>
                                            <td colspan="7">
                                                <textarea rows="5" class="form-control" id="reason_remark" name="reason_remark" required>{{ old('reason_remark') }}</textarea>
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

                    <div class="modal fade" id="crud-modal2" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-user width-2 fs-xl"></i>EDIT CUSTODIAN</h5>
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
                                                <textarea rows="5" class="reason form-control" id="reason" name="reason_remark" required>{{ old('reason_remark') }}</textarea>
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

                    <div class="modal fade" id="crud-modal3" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-server width-2 fs-xl"></i>EDIT SET</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'AssetController@updateSet', 'method' => 'POST']) !!}
                                    <input type="hidden" name="ids" id="ids">
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="asset_type"><span class="text-danger">*</span> Asset Type :</label></td>
                                            <td colspan="7">
                                                <select class="form-control type" name="asset_type" id="asset_type" disabled>
                                                    <option value="">Select Asset Type</option>
                                                    @foreach ($setType as $setTypes) 
                                                        <option value="{{ $setTypes->id }}" {{ old('asset_type') ==  $setTypes->id  ? 'selected' : '' }}>{{ $setTypes->asset_type }}</option>
                                                    @endforeach
                                                </select>
                                                @error('asset_type')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="serial_no"> Serial No. :</label></td>
                                            <td colspan="7">
                                                <input class="serial form-control" id="serial_no" name="serial_no" value="{{ old('serial_no') }}">
                                                @error('serial_no')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="model"> Model :</label></td>
                                            <td colspan="7">
                                                <input class="model form-control" id="model" name="model" value="{{ old('model') }}">
                                                @error('model')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="brand"> Brand :</label></td>
                                            <td colspan="7">
                                                <input class="brand form-control" id="brand" name="brand" value="{{ old('brand') }}">
                                                @error('brand')
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
                       
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>

    $(document).ready(function()
    {
        $('#status, #availability, #asset_types, #asset_code_type').select2();

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
            $('#crud-modal2').modal('show');
        });

        $('#crud-modal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var custodian = button.data('custodian')
            var reason = button.data('reason')

            $('.modal-body #ids').val(id); 
            $('.modal-body #custodian').val(custodian); 
            $('.modal-body #reason').val(reason); 
        });

        $('#crud-modal3').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var id = button.data('id') 
            var asset = button.data('asset') 
            var type = button.data('type') 
            var serial = button.data('serial')
            var model = button.data('model')
            var brand = button.data('brand')

            $('.modal-body #ids').val(id); 
            $('.modal-body .type').val(type); 
            $('.modal-body .serial').val(serial); 
            $('.modal-body .model').val(model); 
            $('.modal-body .brand').val(brand); 
        });

        // Add Set
        $('#addhead').click(function(){
            i++;
            $('#head_field').append(`
            <tr id="row${i}" class="head-added">
            <td>
                <select class="form-control assetType" name="asset_types[]">
                    <option value="">Select Asset Type</option>
                    @foreach ($setType as $setTypes) 
                        <option value="{{ $setTypes->id }}" {{ old('asset_types') ==  $setTypes->id  ? 'selected' : '' }}>{{ $setTypes->asset_type }}</option>
                    @endforeach
                </select>
            </td>
            <td><input name="serial_nos[]" class="form-control serial_nos"/></td>
            <td><input name="models[]" class="form-control models"/></td>
            <td><input name="brands[]" class="form-control brands"/></td>
            <td><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
            </tr>
            `);
            $('.assetType').select2();
        });

        var postURL = "<?php echo url('addmore'); ?>";
        var i=1;

        $.ajaxSetup({
            headers:{
            'X-CSRF-Token' : $("input[name=_token]").val()
            }
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function(){
            $.ajax({
                url:postURL,
                method:"POST",
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.dynamic-added').remove();
                    }
                }
            });
        });

        var table = $('#trk').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [],
                "initComplete": function(settings, json) {
                }
        });

        var table = $('#cst').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [],
                "initComplete": function(settings, json) {
                }
        });

    });

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

    // Radiobutton
    $(function () {          

        $(".set_tab").hide();

        $("input[name=set_package]").change(function () {        
            if ($(this).val() == "Y") {
            $(".set_tab").show();
            }
            else {
            $(".set_tab").hide();
            }
        });

        $('input[name="set_package"]:checked').change(); 

        $(".inactive").hide();

        $( "#status" ).change(function() {
            var val = $("#status").val();
            if(val=="2" || val=="3" || val=="4" || val=="5"){
                $(".inactive").show();
            } else {
                $(".inactive").hide();
            }
        });

        $('#status').val(); 
        $("#status").change(); 
        $('#inactive_date').val('{{ old('inactive_date') }}');

    })

</script>

@endsection
