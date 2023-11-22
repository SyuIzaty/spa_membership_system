@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> STOCK DETAIL MANAGEMENT
        </h1>
    </div>

        <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 20px;">
                            STOCK ID : #{{ $stock->id}}
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-4">
                                    {!! Form::open(['action' => ['Inventory\StockController@stockUpdate'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                    {{Form::hidden('id', $stock->id)}}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>STOCK DETAIL</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <div style="float: right"><b>Updated Date : </b>{{ date(' j F Y | h:i:s A', strtotime($stock->updated_at) )}}</div><br>
                                                            <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department : </label></td>
                                                                    <td colspan="3">
                                                                        <input value="{{ $stock->departments->department_name }}" class="form-control" id="department_id" name="department_id" disabled>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="stock_code"><span class="text-danger">*</span> Stock Code : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="stock_code" style="cursor:context-menu" name="stock_code" value="{{ $stock->stock_code }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="stock_name"><span class="text-danger">*</span> Stock Name:</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="stock_name" name="stock_name" value="{{ $stock->stock_name }}" style="text-transform: uppercase" required>
                                                                        @error('stock_name')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="model"><span class="text-danger">*</span> Model:</label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="model" name="model" value="{{ $stock->model }}" style="text-transform: uppercase" required>
                                                                        @error('model')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="brand"> Brand : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="brand" name="brand" value="{{ $stock->brand }}" style="text-transform: uppercase">
                                                                        @error('brand')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="status"><span class="text-danger">*</span> Status:</label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" id="status" name="status" required>
                                                                            <option value="">Select Status</option>
                                                                            <option value="1" {{ old('status', $stock->status) == '1' ? 'selected':''}} >ACTIVE</option>
                                                                            <option value="0" {{ old('status', $stock->status) == '0' ? 'selected':''}} >INACTIVE</option>
                                                                        </select>
                                                                        @error('status')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="current_owner"> Current Owner : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="current_owner" style="cursor:context-menu" name="current_owner" value="{{ $stock->user->name }}" readonly>
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="purchase_date"> Created Date : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="created_at" name="created_at" value="{{ date('Y-m-d', strtotime($stock->created_at)) }}" readonly>
                                                                        @error('created_at')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="balance_status"> Balance Status:</label></td>
                                                                    <td colspan="3" style="vertical-align: middle">
                                                                        @if($total_bal <= 0)
                                                                            <b style="color:red">OUT OF STOCK</b>
                                                                        @else
                                                                            <b style="color:green">READY STOCK</b>
                                                                        @endif
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            @if($stock->department_id == 'OFM')
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td colspan="4">
                                                                            <label class="form-label mr-4" for="applicable_for_stationary"> Applicable for i-Stationery ?</label>
                                                                            <label style="vertical-align: middle;">
                                                                                <input type="checkbox" name="applicable_for_stationary" value="1" id="applicable_for_stationary" {{ $stock->applicable_for_stationary == 1 ? 'checked' : '' }} style="vertical-align: middle">
                                                                            </label> Yes
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                            @endif
                                                            @if($stock->department_id == 'OFM' || $stock->department_id == 'IITU')
                                                                <tr>
                                                                    <div class="form-group">
                                                                        <td colspan="4">
                                                                            <label class="form-label mr-4" for="applicable_for_aduan"> Applicable for e-Aduan ?</label>
                                                                            <label style="vertical-align: middle;">
                                                                                <input type="checkbox" name="applicable_for_aduan" value="1" id="applicable_for_aduan" {{ $stock->applicable_for_aduan == 1 ? 'checked' : '' }} style="vertical-align: middle">
                                                                            </label> Yes
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                            @endif
                                                        </thead>
                                                    </table>
                                                    <br>
                                                    @cannot('view stock')
                                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                    @endcannot
                                                    <a style="margin-right:5px" href="/stock-index" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
                                                </div>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>

                                <div class="col-md-8 col-sm-12">
                                    {{-- Image --}}
                                    <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#image" aria-expanded="false">
                                                    <i class="fal fa-camera width-2 fs-xl"></i>
                                                    STOCK IMAGE
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
                                                            @cannot('view stock')
                                                                {!! Form::open(['action' => 'Inventory\StockController@uploadImages', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                                {{Form::hidden('stock_id', $stock->id)}}
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td style="vertical-align: middle">
                                                                            <div class="btn-group w-100">
                                                                                <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple required accept=".jpg, .jpeg, .png, .gif">
                                                                                <button type="submit" class="btn btn-primary" style="min-width: fit-content"><i class="fal fa-save"></i> Upload</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table><br>
                                                                {!! Form::close() !!}
                                                            @endcannot
                                                            <table class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                <thead>
                                                                    <tr align="center">
                                                                        @if($image->isNotEmpty())
                                                                            @foreach($image as $img)
                                                                            <td colspan="5">
                                                                                <a data-fancybox="gallery" href="/get-file-images/{{ $img->img_name }}">
                                                                                    <img src="/get-file-images/{{ $img->img_name }}" style="width:150px; height:130px;" class="img-fluid mr-2">
                                                                                </a><br><br>
                                                                                @cannot('view stock')
                                                                                    <a href="#" class="btn btn-danger btn-sm delete-image" data-id="{{ $img->id }}">
                                                                                        <i class="fal fa-trash"></i> Delete
                                                                                    </a>
                                                                                @endcannot
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
                                    {{-- Transaction --}}
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-cog width-2 fs-xl"></i>TRANSACTION LOG</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="log" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr align="center" class="bg-primary-50" style="white-space: nowrap">
                                                            <th style="vertical-align: middle">#ID</th>
                                                            <th style="vertical-align: middle">StockIn (+)</th>
                                                            <th style="vertical-align: middle">StockOut (-)</th>
                                                            <th style="vertical-align: middle">Balance (=)</th>
                                                            <th style="vertical-align: middle">UnitPrice (RM)</th>
                                                            <th style="vertical-align: middle">Status</th>
                                                            <th style="vertical-align: middle">Transaction Date</th>
                                                            <th style="vertical-align: middle">Purchase Date</th>
                                                            <th style="vertical-align: middle">Supply Type</th>
                                                            <th style="vertical-align: middle">Supply To</th>
                                                            <th style="vertical-align: middle">Reason</th>
                                                            <th style="vertical-align: middle">Created By</th>
                                                            <th style="vertical-align: middle">Created Date</th>
                                                            @cannot('view stock')
                                                                <th style="vertical-align: middle">Action</th>
                                                            @endcannot
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Stock In"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Stock Out"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Balance"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Unit Price"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Status"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Transaction Date"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Purchase Date"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Supply Type"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Supply To"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Reason"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Created By"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Created At"></td>
                                                            @cannot('view stock')
                                                                <td class="hasinput"></td>
                                                            @endcannot
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $total_bal = 0; @endphp

                                                    @foreach($stock->transaction as $list)
                                                        <tr align="center" class="data-row">
                                                            <td>{{ isset($list->id) ? '#'.$list->id : '--'}}</td>
                                                            <td>{{ isset($list->stock_in) ? $list->stock_in : '--'}}</td>
                                                            <td>{{ isset($list->stock_out) ? $list->stock_out : '--'}}</td>
                                                            <td>{{ $total_bal += ($list->stock_in - $list->stock_out) }}</td>
                                                            <td>{{ isset($list->unit_price) ? $list->unit_price : '--'}}</td>
                                                            @if($list->status == '1')
                                                                <td style="background-color: #1dc9b7">
                                                                    <div style="text-transform: uppercase; color: #000000"><b>IN</b></div>
                                                                </td>
                                                            @else
                                                                <td style="background-color: #fd3995">
                                                                    <div style="text-transform: uppercase; color: #000000"><b>OUT</b></div>
                                                                </td>
                                                            @endif
                                                            </td>
                                                            <td>{{ isset($list->trans_date) ? date('Y-m-d', strtotime($list->trans_date)) : '--' }}</td>
                                                            <td>{{ isset($list->purchase_date) ? date('Y-m-d', strtotime($list->purchase_date)) : '--' }}</td>
                                                            @if($list->supply_type == 'INT')
                                                                <td>INTERNAL</td>
                                                            @elseif($list->supply_type == 'EXT')
                                                                <td>EXTERNAL</td>
                                                            @else
                                                                <td>--</td>
                                                            @endif
                                                            @if($list->supply_type == 'INT')
                                                                <td>{{ isset($list->users->name) ? strtoupper($list->users->name) : '--' }}</td>
                                                            @else
                                                                <td>{{ isset($list->ext_supply_to) ? strtoupper($list->ext_supply_to) : '--' }}</td>
                                                            @endif
                                                            <td>{{ isset($list->reason) ? $list->reason : '--'}}</td>
                                                            <td>{{ isset($list->user->name) ? strtoupper($list->user->name) : '--' }}</td>
                                                            <td>{{ isset($list->created_at) ? date('Y-m-d', strtotime($list->created_at)) : '--' }}</td>
                                                            @cannot('view stock')
                                                                <td><div class="btn-group">
                                                                    @if($list->status == '1')
                                                                        <a href="" data-target="#crud-modalIn" data-toggle="modal" data-id="{{$list->id}}" data-stock="{{$list->stock_in}}" data-lo="{{$list->lo_no}}" data-io="{{$list->io_no}}"
                                                                            data-price="{{$list->unit_price}}" data-purchase="{{$list->purchase_date}}" data-trans="{{$list->trans_date}}" data-remark="{{$list->remark}}" class="btn btn-sm btn-success mr-1"><i class="fal fa-pencil"></i></a>
                                                                    @else
                                                                        <a href="" data-target="#crud-modalOut" data-toggle="modal" data-id="{{$list->id}}" data-stock="{{$list->stock_out}}" data-reason="{{$list->reason}}" data-supply="{{$list->supply_to}}"
                                                                            data-extsupply="{{$list->ext_supply_to}}" data-trans="{{$list->trans_date}}" data-type="{{$list->supply_type}}"  class="btn btn-sm btn-danger mr-1"><i class="fal fa-pencil"></i></a>
                                                                    @endif
                                                                    <a href="{{ action('Inventory\StockController@deleteTrans', ['id' => $list->id]) }}" class="btn btn-warning btn-sm delete-transaction" data-id="{{ $list->id }}"><i class="fal fa-trash"></i></a>
                                                                </div></td>
                                                            @endcannot
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div><br>
                                            @cannot('view stock')
                                                @if(isset($total_bal))
                                                    @if($total_bal > 0)
                                                        <a href="javascript:;" data-toggle="modal" id="news" class="btn btn-danger ml-2 float-right"><i class="fal fa-minus-square"></i> Transaction Out</a>
                                                    @else
                                                        <a href="#" data-toggle="modal" class="btn btn-secondary ml-2 float-right disabled"><i class="fal fa-minus-square"></i> Transaction Out</a>
                                                    @endif
                                                @else
                                                    <a href="#" data-toggle="modal" class="btn btn-secondary ml-2 float-right disabled"><i class="fal fa-minus-square"></i> Transaction Out</a>
                                                @endif
                                                <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-success ml-auto float-right"><i class="fal fa-plus-square"></i> Transaction In</a>
                                            @endcannot
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100">TRANSACTION IN DETAIL</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'Inventory\StockController@createTransIn', 'method' => 'POST']) !!}
                                    {{Form::hidden('id', $stock->id)}}
                                    <p><span class="text-danger">*</span> Required fields</p>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="stock_in"><span class="text-danger">*</span> Stock In :</label></td>
                                            <td colspan="7">
                                                <input type="number" step="any" value="{{ old('stock_in') }}" class="form-control" id="stock_in" name="stock_in" required>
                                                @error('stock_in')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="unit_price">
                                                Unit Price (RM) :</label></td>
                                            <td colspan="7">
                                                <input type="number" step="any" value="{{ old('unit_price') }}" class="form-control" id="unit_price" name="unit_price">
                                                @error('unit_price')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="purchase_date">
                                                Purchase Date :</label></td>
                                            <td colspan="7">
                                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                                                @error('purchase_date')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="trans_date"><span class="text-danger">*</span> Stock In Date :</label></td>
                                            <td colspan="7">
                                                <input type="date" class="form-control" id="trans_date" name="trans_date" value="{{ old('trans_date') }}" required>
                                                @error('trans_date')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="lo_no">
                                                L.O. Number :</label></td>
                                            <td colspan="7">
                                                <input value="{{ old('lo_no') }}" class="form-control" id="lo_no" name="lo_no">
                                                @error('lo_no')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="io_no">
                                                Invoice Number :</label></td>
                                            <td colspan="7">
                                                <input value="{{ old('io_no') }}" class="form-control" id="io_no" name="io_no">
                                                @error('io_no')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="remark"> Remark :</label></td>
                                            <td colspan="7">
                                                <textarea rows="5" class="form-control" id="remark" name="remark">{{ old('remark') }}</textarea>
                                                @error('remark')
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

                    <div class="modal fade" id="crud-modals" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100">TRANSACTION OUT DETAIL</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'Inventory\StockController@createTransOut', 'method' => 'POST']) !!}
                                    {{Form::hidden('id', $stock->id)}}
                                    <p><span class="text-danger">*</span> Required fields</p>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="stock_out"><span class="text-danger">*</span> Stock Out :</label></td>
                                            <td colspan="7">
                                                <input type="number" step="any" value="{{ old('stock_out') }}" class="form-control" id="stock_out" name="stock_out" required>
                                                @error('stock_out')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="trans_date"><span class="text-danger">*</span> Stock Out Date :</label></td>
                                            <td colspan="7">
                                                <input type="date" class="form-control" id="trans_date" name="trans_date" value="{{ old('trans_date') }}" required>
                                                @error('trans_date')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="supply_type"><span class="text-danger">*</span> Supply Type :</label></td>
                                            <td colspan="7">
                                                <select class="form-control supply_type" id="supply_type" name="supply_type" required>
                                                    <option value="">Please Select</option>
                                                    <option value="INT" {{ old('supply_type') == 'INT' ? 'selected':''}} >Internal</option>
                                                    <option value="EXT" {{ old('supply_type') == 'EXT' ? 'selected':''}} >External</option>
                                                </select>
                                                @error('supply_type')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group int">
                                            <td width="15%"><label class="form-label" for="supply_to"><span class="text-danger">*</span> Supply To :</label></td>
                                            <td colspan="7">
                                                <select class="form-control supply_to" name="supply_to" id="supply_to">
                                                    <option value=""> Please select </option>
                                                    @foreach ($user as $staffs)
                                                        <option value="{{ $staffs->id }}" {{ old('supply_to') ==  $staffs->id  ? 'selected' : '' }}>{{ $staffs->id }} - {{ $staffs->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('supply_to')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group ext">
                                            <td width="15%"><label class="form-label" for="ext_supply_to"><span class="text-danger">*</span> Supply To :</label></td>
                                            <td colspan="7">
                                                <input value="{{ old('ext_supply_to') }}" class="form-control" id="ext_supply_to" name="ext_supply_to" placeholder="Name/Company">
                                                @error('ext_supply_to')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="reason"><span class="text-danger">*</span> Reason :</label></td>
                                            <td colspan="7">
                                                <textarea rows="5" class="form-control" id="reason" name="reason" required>{{ old('reason') }}</textarea>
                                                @error('reason')
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

                    <div class="modal fade" id="crud-modalIn" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-sign-in-alt width-2 fs-xl"></i>EDIT TRANSACTION IN</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'Inventory\StockController@updateTransin', 'method' => 'POST']) !!}
                                    <input type="hidden" name="ids" id="ids">
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="stock_in"><span class="text-danger">*</span> Stock In :</label></td>
                                        <td colspan="7">
                                            <input type="number" step="any" value="{{ old('stock_in') }}" class="form-control stock" id="stock_in" name="stock_in" required>
                                            @error('stock_in')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="unit_price"> Unit Price (RM) :</label></td>
                                        <td colspan="7">
                                            <input type="number" step="any" value="{{ old('unit_price') }}" class="form-control price" id="unit_price" name="unit_price">
                                            @error('unit_price')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="purchase_date"> Purchase Date :</label></td>
                                        <td colspan="7">
                                            <input type="date" class="form-control purchase" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                                            @error('purchase_date')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="trans_date"><span class="text-danger">*</span> Stock In Date :</label></td>
                                        <td colspan="7">
                                            <input type="date" class="form-control trans" id="trans_date" name="trans_date" value="{{ old('trans_date') }}" required>
                                            @error('trans_date')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="lo_no"> L.O. Number :</label></td>
                                        <td colspan="7">
                                            <input value="{{ old('lo_no') }}" class="form-control lo" id="lo_no" name="lo_no" >
                                            @error('lo_no')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="io_no"> Invoice Number :</label></td>
                                        <td colspan="7">
                                            <input value="{{ old('io_no') }}" class="form-control io" id="io_no" name="io_no">
                                            @error('io_no')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="remark"> Remark :</label></td>
                                        <td colspan="7">
                                            <textarea rows="5" class="form-control remark" id="remark" name="remark">{{ old('remark') }}</textarea>
                                            @error('remark')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="crud-modalOut" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-sign-in-alt width-2 fs-xl"></i>EDIT TRANSACTION OUT</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'Inventory\StockController@updateTransout', 'method' => 'POST']) !!}
                                    <input type="hidden" name="ids" id="ids">
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="stock_out"><span class="text-danger">*</span> Stock Out :</label></td>
                                        <td colspan="7">
                                            <input type="number" step="any" value="{{ old('stock_out') }}" class="form-control stock" id="stock_out" name="stock_out" required>
                                            @error('stock_out')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="trans_date"><span class="text-danger">*</span> Stock Out Date :</label></td>
                                        <td colspan="7">
                                            <input type="date" class="form-control trans" id="trans_date" name="trans_date" value="{{ old('trans_date') }}" required>
                                            @error('trans_date')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="type"><span class="text-danger">*</span> Supply Type :</label></td>
                                        <td colspan="7">
                                            <select class="form-control type" name="type" id="type" required disabled>
                                                <option value="">Please Select</option>
                                                <option value="INT" {{ old('type') ==  'INT'  ? 'selected' : '' }}>Internal</option>
                                                <option value="EXT" {{ old('type') ==  'EXT'  ? 'selected' : '' }}>External</option>
                                            </select>
                                            @error('type')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group ints">
                                        <td width="15%"><label class="form-label" for="supply"><span class="text-danger">*</span> Supply To :</label></td>
                                        <td colspan="7">
                                            <select class="form-control supply" name="supply" id="supply">
                                                <option value=""> Please Select </option>
                                                @foreach ($user as $staffs)
                                                    <option value="{{ $staffs->id }}" {{ old('supply') ==  $staffs->id  ? 'selected' : '' }}>{{ $staffs->id }} - {{ $staffs->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('supply')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group exts">
                                        <td width="15%"><label class="form-label" for="extsupply"><span class="text-danger">*</span> Supply To :</label></td>
                                        <td colspan="7">
                                            <input value="{{ old('extsupply') }}" class="form-control extsupply" id="extsupply" name="extsupply" placeholder="Name/Company">
                                            @error('extsupply')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="reason"><span class="text-danger">*</span> Reason :</label></td>
                                        <td colspan="7">
                                            <textarea rows="5" class="form-control reason" id="reason" name="reason" required>{{ old('reason') }}</textarea>
                                            @error('reason')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
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

        // Display TransOut
            $(".int").hide();

            $( "#supply_type" ).change(function() {
                var val = $("#supply_type").val();
                if(val=="INT"){
                    $(".int").show();
                    $(".ext").hide();
                }
            });

            $(".ext").hide();

            $( "#supply_type" ).change(function() {
                var val = $("#supply_type").val();
                if(val=="EXT"){
                    $(".ext").show();
                    $(".int").hide();
                }
            });

            $('.supply_type').val('{{ old('supply_type') }}');
            $(".supply_type").change();
            $('.supply_to').val('{{ old('supply_to') }}');
            $('.ext_supply_to').val('{{ old('ext_supply_to') }}');
        //

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#news').click(function () {
            $('#crud-modals').modal('show');
        });

        $('.supply_to, .supply_type').select2({
            dropdownParent: $('#crud-modals')
        });

        $('#crud-modalIn').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var stock = button.data('stock')
            var lo = button.data('lo')
            var io = button.data('io')
            var price = button.data('price')
            var purchase = button.data('purchase')
            var trans = button.data('trans')
            var remark = button.data('remark')

            $('.modal-body #ids').val(id);
            $('.modal-body .stock').val(stock);
            $('.modal-body .lo').val(lo);
            $('.modal-body .io').val(io);
            $('.modal-body .price').val(price);
            $('.modal-body .purchase').val(purchase);
            $('.modal-body .trans').val(trans);
            $('.modal-body .remark').val(remark);

        });

        $('#crud-modalOut').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var stock = button.data('stock')
            var reason = button.data('reason')
            var type = button.data('type')
            var supply = button.data('supply')
            var extsupply = button.data('extsupply')
            var trans = button.data('trans')

            $('.modal-body #ids').val(id);
            $('.modal-body .stock').val(stock);
            $('.modal-body .reason').val(reason);
            $('.modal-body .type').val(type);
            $('.modal-body .supply').val(supply);
            $('.modal-body .extsupply').val(extsupply);
            $('.modal-body .trans').val(trans);

            $('.supply, .type').select2({
                dropdownParent: $('#crud-modalOut')
            });

            $(".ints").hide();
            $(".exts").hide();

            if(type=="INT")
            {
                $(".ints").show();
                $(".exts").hide();
            }
            if(type=="EXT")
            {
                $(".exts").show();
                $(".ints").hide();
            }
        });

    });

    $(document).ready(function()
    {
        $('#log thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#log').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 6, "desc" ],[ 0, "desc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(document).on('click', '.delete-image', function (e) {
        e.preventDefault();
        var imageId = $(this).data('id');

        Swal.fire({
            title: 'Delete Image?',
            text: 'Data cannot be recovered after deletion!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/deleteImages/' + imageId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // Add CSRF token if needed
                    },
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    $(document).on('click', '.delete-transaction', function (e) {
        e.preventDefault();
        var deleteLink = $(this).attr('href');
        var imageId = $(this).data('id');

        Swal.fire({
            title: 'Delete Transaction?',
            text: 'Data cannot be recovered after deletion!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: deleteLink, // Use the deleteLink variable
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}', // Add CSRF token if needed
                    },
                    success: function (response) {
                        console.log(response);
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
