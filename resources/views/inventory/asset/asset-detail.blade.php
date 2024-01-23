@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> ASSET DETAIL MANAGEMENT
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 20px;">
                        {{-- ASSET ID : #{{ $asset->id}} --}}
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
                            <div class="col-sm-12">
                                <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
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
                                        <span class="hidden-sm-down ml-1"> ASSET TRACK</span>
                                    </a>
                                    @if (Auth::user()->hasPermissionTo('admin management'))
                                        <a class="nav-link mb-2" id="custodian-tab" data-toggle="pill" href="#custodian" role="tab" aria-controls="custodian" aria-selected="false" style="border: 1px solid;">
                                            <i class="fal fa-book"></i>
                                            <span class="hidden-sm-down ml-1"> CUSTODIAN TRACK</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane active" id="asset" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            {!! Form::open(['action' => ['Inventory\AssetManagementController@update_asset_detail'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                            {{Form::hidden('id', $asset->id)}}
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header">
                                                        <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>ASSET DETAIL</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        @if (Session::has('message'))
                                                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                                        @endif
                                                        <div class="table-responsive">
                                                            <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                <thead>
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
                                                                            <td width="15%"><label class="form-label" for="asset_code"><span class="text-danger">*</span> Asset Code : </label></td>
                                                                            <td colspan="3">
                                                                                <input class="form-control" id="asset_code" style="cursor:context-menu" name="asset_code" value="{{ $asset->asset_code ?? old('asset_code') }}" readonly>
                                                                                @error('asset_code')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                            <td width="15%"><label class="form-label" for="finance_code"> Finance Code:</label></td>
                                                                            <td colspan="3">
                                                                                <input class="form-control" id="finance_code" name="finance_code" value="{{ $asset->finance_code ?? old('finance_code') }}">
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
                                                                                <select class="form-control asset_code_type" name="asset_code_type" id="asset_code_type" required>
                                                                                    <option value="">Please Select</option>
                                                                                    @foreach ($codeType as $codeTypes)
                                                                                        <option value="{{ $codeTypes->id }}" {{ old('asset_code_type', ($asset->asset_code_type ? $asset->codeType->id : '' )) == $codeTypes->id ? 'selected' : '' }}>{{ $codeTypes->id }} - {{ $codeTypes->code_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('asset_code_type')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                            <td width="15%"><label class="form-label" for="asset_name"><span class="text-danger">*</span> Asset Name:</label></td>
                                                                            <td colspan="3">
                                                                                <input class="form-control" id="asset_name" name="asset_name" value="{{ $asset->asset_name ?? old('asset_name') }}" required>
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
                                                                                <input class="form-control" id="serial_no" name="serial_no" value="{{ $asset->serial_no ?? old('serial_no') }}" required>
                                                                                @error('serial_no')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                            <td width="15%"><label class="form-label" for="model"> Model:</label></td>
                                                                            <td colspan="3">
                                                                                <input class="form-control" id="model" name="model" value="{{ $asset->model ?? old('model') }}" style="text-transform: uppercase">
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
                                                                                <input class="form-control" id="brand" name="brand" value="{{ $asset->brand ?? old('brand') }}" style="text-transform: uppercase">
                                                                                @error('brand')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                            <td width="15%"><label class="form-label" for="storage_location"> Location:</label></td>
                                                                            <td colspan="3">
                                                                                <input class="form-control" id="storage_location" name="storage_location" value="{{ $asset->storage_location ?? old('storage_location') }}">
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
                                                                                <select class="form-control" id="status" name="status" required>
                                                                                    <option value="">Please Select</option>
                                                                                    <option value="1" {{ old('status', $asset->status) == '1' ? 'selected':''}} >ACTIVE</option>
                                                                                    <option value="0" {{ old('status', $asset->status) == '0' ? 'selected':''}} >INACTIVE</option>
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
                                                                            @php
                                                                                $exist = App\Rental::where('asset_id', $asset->id)->where('status', '0')->first();
                                                                            @endphp
                                                                            <td width="15%"><label class="form-label" for="availability"> Availability:</label></td>
                                                                            <td colspan="3">
                                                                                <select class="form-control availability" name="availability" id="availability" @if(isset($exist)) readonly @endif>
                                                                                    <option value="">Please Select</option>
                                                                                    @foreach ($availability as $available)
                                                                                        <option value="{{ $available->id }}" {{ old('availability', ($asset->availability ? $asset->assetAvailability->id : '')) == $available->id ? 'selected' : '' }}>{{ $available->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('availability')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                                @if(isset($exist))
                                                                                    <p class="mt-4">Renter : <b>{{ $exist->staff->staff_name }}</b></p>
                                                                                @endif
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr class="inactive">
                                                                        <div class="form-group">
                                                                            <td width="15%"><label class="form-label" for="inactive_reason"><span class="text-danger">*</span> Reason:</label></td>
                                                                            <td colspan="3">
                                                                                <select class="form-control inactive_reason" name="inactive_reason" id="inactive_reason">
                                                                                    <option value="">Please Select</option>
                                                                                    @foreach ($status as $statuss)
                                                                                        <option value="{{ $statuss->id }}" {{ old('inactive_reason', ($asset->inactive_reason ? $asset->assetStatus->id : '')) ==  $statuss->id  ? 'selected' : '' }}>
                                                                                            {{ $statuss->status_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('inactive_reason')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                            <td width="15%"><label class="form-label" for="inactive_remark"> Remark:</label></td>
                                                                            <td colspan="3">
                                                                                <textarea rows="5" class="form-control" id="inactive_remark" name="inactive_remark" >{{ $asset->inactive_remark ?? old('inactive_remark') }}</textarea>
                                                                                @error('inactive_remark')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td width="15%"><label class="form-label" for="asset_class"><span class="text-danger">*</span> Asset Class :</label></td>
                                                                            <td colspan="3">
                                                                                <select class="form-control asset_class" name="asset_class" id="asset_class" required>
                                                                                    <option value="">Please Select</option>
                                                                                    @foreach ($class as $classes)
                                                                                        <option value="{{ $classes->class_code }}" {{ old('asset_class', ($asset->asset_class ? $asset->assetClass->class_code : '')) ==  $classes->class_code  ? 'selected' : '' }}>
                                                                                            {{ $classes->class_code }} - {{ $classes->class_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('asset_class')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <td width="15%"><label class="form-label" for="custodian_id"> Current Custodian : </label></td>
                                                                            <td colspan="3">
                                                                                <input class="form-control" id="custodian_id" style="cursor:context-menu" name="custodian_id" value="{{ $asset->custodian->name ?? '' }}" readonly>
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td width="15%"><label class="form-label" for="set_package"><span class="text-danger">*</span> Set Package ?</label></td>
                                                                            <td colspan="6">
                                                                                <input class="ml-5" type="radio" name="set_package" id="set_package" value="Y" {{ $asset->set_package == "Y" ? 'checked="checked"' : ''}}> Yes
                                                                                <input class="ml-5" type="radio" name="set_package" id="set_package" value="N" {{ $asset->set_package == "N" ? 'checked="checked"' : '' }}> No
                                                                                @error('set_package')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                        </div>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                            <br>
                                                            <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                            <a style="margin-right:5px" data-page="/asset-detail-pdf/{{ $asset->id }}" onclick="Print(this)" class="btn btn-info ml-auto float-right text-white"><i class="fal fa-file-pdf"></i> Print PDF</a>
                                                            <a style="margin-right:5px" href="/asset-list" class="btn btn-secondary ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
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
                                                                        @if (Session::has('message-set'))
                                                                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message-set') }}</div>
                                                                        @endif
                                                                        @if (Auth::user()->hasPermissionTo('admin management'))
                                                                            <p><span class="text-danger">*</span> Required fields</p>
                                                                            {!! Form::open(['action' => ['Inventory\AssetManagementController@store_asset_set'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                                                            {{Form::hidden('asset_id', $asset->id)}}
                                                                                <div class="form-group">
                                                                                    <table class="table table-bordered text-center" id="head_field">
                                                                                        <tr class=" " style="white-space: nowrap">
                                                                                            <td><span class="text-danger">*</span> Asset Type</td>
                                                                                            <td><span class="text-danger">*</span> Serial No.</td>
                                                                                            <td>Model</td>
                                                                                            <td>Brand</td>
                                                                                            <td></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <select class="form-control asset_types" name="asset_types[]" id="asset_types" required>
                                                                                                    <option value="" disabled selected>Please Select</option>
                                                                                                    @foreach ($setType as $setTypes)
                                                                                                        <option value="{{ $setTypes->id }}" {{ old('asset_types') ==  $setTypes->id  ? 'selected' : '' }}>{{ $setTypes->asset_type }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </td>
                                                                                            <td><input name="serial_nos[]" class="form-control serial_nos" required/></td>
                                                                                            <td><input name="models[]" class="form-control models"/></td>
                                                                                            <td><input name="brands[]" class="form-control brands"/></td>
                                                                                            <td style="vertical-align: middle"><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                    <button type="submit" class="btn btn-success ml-auto float-right mb-4"><i class="fal fa-save"></i> Save</button>
                                                                                </div>
                                                                            {!! Form::close() !!}
                                                                        @endif
                                                                        <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                            <thead class="bg-primary-50 text-center">
                                                                                <tr style="white-space: nowrap">
                                                                                    <td>No.</td>
                                                                                    <td>Asset Type</td>
                                                                                    <td>Serial No.</td>
                                                                                    <td>Model</td>
                                                                                    <td>Brand</td>
                                                                                    <td>Action</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @if(!empty($asset->assetSets) && $asset->assetSets->count() > 0)
                                                                                    @foreach ($asset->assetSets as $sets)
                                                                                        <tr align="center">
                                                                                            <td>{{ $loop->iteration }}</td>
                                                                                            <td>{{ $sets->type->asset_type ?? '-' }}</td>
                                                                                            <td>{{ $sets->serial_no ?? '-' }}</td>
                                                                                            <td>{{ $sets->model ?? '-' }}</td>
                                                                                            <td>{{ $sets->brand ?? '-' }}</td>
                                                                                            <td><div class="btn-group">
                                                                                                <a href="" data-target="#crud-modal-set" data-toggle="modal" data-id="{{$sets->id}}" data-asset="{{$sets->asset_id}}" data-type="{{$sets->asset_type}}" data-serial="{{$sets->serial_no}}" data-model="{{$sets->model}}" data-brand="{{$sets->brand}}" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                                                                                                @if (Auth::user()->hasPermissionTo('admin management'))
                                                                                                    <a href="#" class="btn btn-danger btn-sm delete-set" data-id="{{ $sets->id }}">
                                                                                                        <i class="fal fa-trash"></i>
                                                                                                    </a>
                                                                                                @endif
                                                                                            </div></td>
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
                                                                    @if (Session::has('message-img'))
                                                                        <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message-img') }}</div>
                                                                    @endif
                                                                    {!! Form::open(['action' => 'Inventory\AssetManagementController@upload_asset_image', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                    {{Form::hidden('asset_id', $asset->id)}}
                                                                    <table width="100%">
                                                                        <tr>
                                                                            <td style="vertical-align: middle">
                                                                                <div class="btn-group w-100">
                                                                                    <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple required accept=".jpg, .jpeg, .png, .gif">
                                                                                    <button type="submit" class="btn btn-success" style="min-width: fit-content"><i class="fal fa-save"></i> Upload</button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table><br>
                                                                    {!! Form::close() !!}
                                                                    <table class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                        <thead>
                                                                            <tr align="center">
                                                                                @if($asset->assetImages->isNotEmpty())
                                                                                    @foreach($asset->assetImages as $img)
                                                                                    <td colspan="5">
                                                                                        <a data-fancybox="gallery" href="/get-asset-image/{{ $img->img_name }}">
                                                                                            <img src="/get-asset-image/{{ $img->img_name }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                                                        </a><br><br>
                                                                                        <a href="#" class="btn btn-danger btn-sm delete-image" data-id="{{ $img->id }}">
                                                                                            <i class="fal fa-trash"></i> Delete
                                                                                        </a>
                                                                                    </td>
                                                                                    @endforeach
                                                                                @else
                                                                                    <td>
                                                                                        <span>No Image Uploaded</span>
                                                                                    </td>
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="purchase" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            {!! Form::open(['action' => ['Inventory\AssetManagementController@update_asset_purchase'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                            {{Form::hidden('id', $asset->id)}}
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header">
                                                        <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>PURCHASE DETAIL</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        @if (Session::has('message-purchase'))
                                                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message-purchase') }}</div>
                                                        @endif
                                                        <div class="table-responsive">
                                                            <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                <thead>
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td width="15%"><label class="form-label" for="purchase_date"> Purchase Date : </label></td>
                                                                            <td colspan="3">
                                                                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ isset($asset->purchase_date) ? date('Y-m-d', strtotime($asset->purchase_date)) : old('purchase_date') }}"/>
                                                                                @error('purchase_date')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                            <td width="15%"><label class="form-label" for="vendor_name"> Vendor :</label></td>
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
                                                                            <td width="15%"><label class="form-label" for="acquisition_type"> Acquisition Type :</label></td>
                                                                            <td colspan="3">
                                                                                <select class="form-control acquisition_type" name="acquisition_type" id="acquisition_type">
                                                                                    <option value="">Please Select</option>
                                                                                    @foreach ($acquisition as $acq)
                                                                                        <option value="{{ $acq->id }}" {{ old('asset_code_type', ($asset->acquisition_type ? $asset->acquisitionType->id : '' )) == $acq->id ? 'selected' : '' }}>{{ $acq->acquisition_type }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('acquisition_type')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                            </td>
                                                                            <td width="15%"><label class="form-label" for="remark"> Remark : </label></td>
                                                                            <td colspan="3">
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
                                                            <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                            <a style="margin-right:5px" href="/asset-list" class="btn btn-secondary ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="track" role="tabpanel"><br>
                                        <div class="col-sm-12 mb-4">
                                            <div class="card card-primary card-outline">
                                                <div class="card-header">
                                                    <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>ASSET TRAIL</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="trail" class="table table-bordered table-hover table-striped w-100 text-center">
                                                            <thead>
                                                                <tr align="center" class="bg-primary-50" style="white-space: nowrap">
                                                                    <th>ID</th>
                                                                    <th>Asset Code</th>
                                                                    <th>Finance Code</th>
                                                                    <th>Code Type</th>
                                                                    <th>Asset Type</th>
                                                                    <th>Asset Class</th>
                                                                    <th>Asset Name</th>
                                                                    <th>Serial No.</th>
                                                                    <th>Model</th>
                                                                    <th>Brand</th>
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
                                                                @foreach($asset->assetTrails as $trails)
                                                                <tr>
                                                                    <td>{{ $trails->id ?? '-' }}</td>
                                                                    <td>{{ $trails->asset_code ?? '-' }}</td>
                                                                    <td>{{ $trails->finance_code ?? '-' }}</td>
                                                                    <td>{{ $trails->codeType->code_name ?? '-' }}</td>
                                                                    <td>{{ $trails->type->asset_type ?? '-' }}</td>
                                                                    <td>{{ $trails->assetClass->class_name ?? '-' }}</td>
                                                                    <td>{{ $trails->asset_name ?? '-' }}</td>
                                                                    <td>{{ $trails->serial_no ?? '-' }}</td>
                                                                    <td>{{ $trails->model ?? '-' }}</td>
                                                                    <td>{{ $trails->brand ?? '-' }}</td>
                                                                    <td>{{ isset($trails->purchase_date) ? date('d-m-Y', strtotime($trails->purchase_date)) : '-' }}</td>
                                                                    <td>{{ $trails->vendor_name ?? '-' }}</td>
                                                                    <td>{{ $trails->lo_no ?? '-' }}</td>
                                                                    <td>{{ $trails->do_no ?? '-' }}</td>
                                                                    <td>{{ $trails->io_no ?? '-' }}</td>
                                                                    <td>{{ $trails->total_price ?? '-' }}</td>
                                                                    @if($trails->status == '0')
                                                                        <td>INACTIVE</td>
                                                                    @else
                                                                        <td>ACTIVE</td>
                                                                    @endif
                                                                    <td>{{ $trails->staffs->name ?? '-' }}</td>
                                                                    <td>{{ date('d/m/Y', strtotime($trails->created_at)) }}<br>{{ date('h:i A', strtotime($trails->created_at)) }}</td>
                                                                    <td><a href="/asset-trail-detail/{{ $trails->id }}" class="btn btn-sm btn-info"><i class="fal fa-eye"></i></a></td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <a href="/asset-list" class="btn btn-secondary ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                        </div>
                                    </div>

                                    @if (Auth::user()->hasPermissionTo('admin management'))
                                        <div class="tab-pane" id="custodian" role="tabpanel"><br>
                                            <div class="col-sm-12 mb-4">
                                                <div class="card-header">
                                                    <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>CUSTODIAN TRAIL</h5>
                                                </div>
                                                <div class="card-body">
                                                    @if (Session::has('message-custodian'))
                                                        <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message-custodian') }}</div>
                                                    @endif
                                                    <div class="table-responsive">
                                                        <table id="cst" class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr align="center" class="bg-primary-50" style="white-space: nowrap">
                                                                    <th style="width: 50px;">No.</th>
                                                                    <th>Custodian</th>
                                                                    <th>Change Reason</th>
                                                                    <th>Location</th>
                                                                    <th>Assign Date</th>
                                                                    <th>Assign By</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($asset->assetCustodians as $list)
                                                                <tr align="center"  class="data-row">
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ isset($list->custodian->name) ? $list->custodian->name : '-'}}</td>
                                                                    <td>{{ isset($list->reason_remark) ? $list->reason_remark : '-'}}</td>
                                                                    <td>{{ isset($list->location) ? $list->location : '-'}}</td>
                                                                    <td>{{ isset($list->created_at) ? date('d-m-Y | h:i A', strtotime($list->created_at)) : '-' }}</td>
                                                                    <td>{{ isset($list->user->name) ? $list->user->name : '-' }}</td>
                                                                    <td style="color:green">{{ isset($list->status) ? $list->custodianStatus->status_name : '-' }}</td>
                                                                    <td>
                                                                        <a href="" data-target="#crud-modal-custodian" data-toggle="modal" data-id="{{$list->id}}" data-custodian="{{$list->custodian->name}}" data-reason="{{$list->reason_remark}}" data-location="{{$list->location}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                                                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
                                                <a href="" data-target="#crud-modal" data-toggle="modal" data-depart="{{$asset->type->department_id}}" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Change Custodian</a>
                                                <a style="margin-right:5px" href="/asset-list" class="btn btn-secondary ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                    </div>
                </div>

                <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title w-100"><i class="fal fa-user width-2 fs-xl"></i> CHANGE CUSTODIAN</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'Inventory\AssetManagementController@store_custodian', 'method' => 'POST']) !!}
                                {{Form::hidden('id', $asset->id)}}
                                <input type="hidden" name="depart_id" id="depart" class="depart">
                                <p><span class="text-danger">*</span> Required fields</p>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                                        <td colspan="7">
                                            <select name="department_id" id="department_id" class="department form-control" disabled>
                                                <option value="" selected disabled>Please select</option>
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
                                                <option value="" selected disabled>Please select</option>
                                                @foreach ($custodian as $custodians)
                                                    <option value="{{ $custodians->custodian_id }}" {{ old('custodian_id') ==  $custodians->custodian_id  ? 'selected' : '' }}>{{ $custodians->custodian->name }}</option>
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
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="location"> Location :</label></td>
                                        <td colspan="7">
                                            <input class="form-control" id="location" name="location" value="{{ old('location') }}">
                                            @error('location')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>

                                <div class="footer">
                                    <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                    <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="crud-modal-custodian" aria-hidden="true" data-keyboard="false" data-backdrop="static" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title w-100"><i class="fal fa-user width-2 fs-xl"></i> EDIT CUSTODIAN</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'Inventory\AssetManagementController@update_custodian', 'method' => 'POST']) !!}
                                {{Form::hidden('id', $asset->id)}}
                                <input type="hidden" name="ids" id="ids">
                                <input type="hidden" name="depart_id" id="depart" class="depart">
                                <p><span class="text-danger">*</span> Required fields</p>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                                        <td colspan="7">
                                            <select name="department_id" id="department_id" class="department form-control" disabled>
                                                <option value=""> Please select</option>
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
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="location"> Location :</label></td>
                                        <td colspan="7">
                                            <input rows="5" class="location form-control" id="locations" name="location">
                                            @error('location')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                        </td>
                                    </div>

                                <div class="footer">
                                    <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                    <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="crud-modal-set" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title w-100"><i class="fal fa-server width-2 fs-xl"></i> EDIT ASSET SET</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'Inventory\AssetManagementController@update_asset_set', 'method' => 'POST']) !!}
                                <input type="hidden" name="ids" id="ids">
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="asset_type"><span class="text-danger">*</span> Asset Type :</label></td>
                                        <td colspan="7">
                                            <select class="form-control type" style="cursor:context-menu" name="asset_type" id="asset_type" disabled>
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
                                        <td width="15%"><label class="form-label" for="serial_no"> <span class="text-danger">*</span> Serial No. :</label></td>
                                        <td colspan="7">
                                            <input class="serial form-control" id="serial_no" name="serial_no" value="{{ old('serial_no') }}" required>
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
                                    <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                    <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
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
        $('#status, #availability, #asset_types, #asset_code_type, #acquisition_type, #inactive_reason, #asset_class').select2();

        // Modal function

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
            $('#crud-modal-custodian').modal('show');
        });

        $('#crud-modal-custodian').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var custodian = button.data('custodian')
            var reason = button.data('reason')
            var location = button.data('location')

            $('.modal-body #ids').val(id);
            $('.modal-body #custodian').val(custodian);
            $('.modal-body #reason').val(reason);
            $('.modal-body #locations').val(location);
        });

        $('#crud-modal-set').on('show.bs.modal', function(event) {
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

            $('.type').select2({
                dropdownParent: $("#crud-modal-set")
            });
        });

        // Multiple add set function

        $('#addhead').click(function(){
            i++;
            $('#head_field').append(`
            <tr id="row${i}" class="head-added">
            <td>
                <select class="form-control assetType" name="asset_types[]" required>
                    <option value="" disabled selected>Please Select</option>
                    @foreach ($setType as $setTypes)
                        <option value="{{ $setTypes->id }}" {{ old('asset_types') ==  $setTypes->id  ? 'selected' : '' }}>{{ $setTypes->asset_type }}</option>
                    @endforeach
                </select>
            </td>
            <td><input name="serial_nos[]" class="form-control serial_nos" required/></td>
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

        var table = $('#trail').DataTable({
            searching: false,
            columnDefs: [],
                orderCellsTop: true,
                "order": [],
                "initComplete": function(settings, json) {
                }
        });

        var table = $('#cst').DataTable({
            searching: false,
            columnDefs: [],
                orderCellsTop: true,
                "order": [],
                "initComplete": function(settings, json) {
                }
        });

    });

    // Print function

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

    // Radiobutton function

    $(function () {

        $('input[name="set_package"]:checked').change();

        $(".inactive").hide();

        $( "#status" ).change(function() {
            var val = $("#status").val();
            if(val=="0"){
                $(".inactive").show();
            } else {
                $(".inactive").hide();
            }
        });

        $('#status').val();
        $("#status").change();
        $('#inactive_date').val();
        $('#inactive_reason').val();
        $('#inactive_remark').val();

    })

    // Delete image function

    $(document).on('click', '.delete-image', function (e) {
        e.preventDefault();
        var imageId = $(this).data('id');
        console.log(imageId);

        Swal.fire({
            title: 'Delete Image?',
            text: 'Data cannot be recovered after deletion!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/delete-asset-image/' + imageId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    // Delete set function

    $(document).on('click', '.delete-set', function (e) {
        e.preventDefault();
        var setId = $(this).data('id');

        Swal.fire({
            title: 'Delete Set?',
            text: 'Data cannot be recovered after deletion!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/delete-asset-set/' + setId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

</script>

@endsection
