@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> STOCK DETAILS
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
                               
                            <div class="row">

                                <div class="col-sm-12 col-md-4 mb-4">
                                    {!! Form::open(['action' => ['StockController@stockUpdate'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                    {{Form::hidden('id', $stock->id)}}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>STOCK PROFILE</h5>
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('notification'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <div style="float: right"><i><b>Updated Date : </b>{{ date(' j F Y | h:i:s A', strtotime($stock->updated_at) )}}</i></div><br>
                                                            <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control department" name="department_id" id="department_id" disabled>
                                                                            <option value="">Select Department</option>
                                                                            @foreach ($department as $depart) 
                                                                                <option value="{{ $depart->id }}" {{ $stock->department_id == $depart->id ? 'selected="selected"' : '' }}>{{ strtoupper($depart->department_name) }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('department_id')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
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
                                                                        <input class="form-control" id="stock_name" name="stock_name" value="{{ $stock->stock_name }}" style="text-transform: uppercase">
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
                                                                        <input class="form-control" id="model" name="model" value="{{ $stock->model }}" style="text-transform: uppercase">
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
                                                                    <td width="25%"><label class="form-label" for="status"> Status:</label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" id="status" name="status">
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
                                                                    <td width="25%"><label class="form-label" for="created_by"> Created By : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="created_by" style="cursor:context-menu" name="created_by" value="{{ $stock->user->name }}" readonly>
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
                                                        </thead>
                                                    </table>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                    <a style="margin-right:5px; color: white" data-page="/stockPdf/{{ $stock->id }}" class="btn btn-danger ml-auto float-right" onclick="Print(this)"><i class="fal fa-download"></i> PDF</a>
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
                                                            @if (Session::has('messages'))
                                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('messages') }}</div>
                                                            @endif
                                                            <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                <thead>
                                                                    <tr align="center">
                                                                        @if(isset($image->first()->upload_image))
                                                                            @foreach($image as $images)
                                                                            <td colspan="5">
                                                                                <a data-fancybox="gallery" href="/get-file-images/{{ $images->upload_image }}"><img src="/get-file-images/{{ $images->upload_image }}" style="width:150px; height:130px;" class="img-fluid mr-2"></a><br><br>
                                                                                <a href="{{ action('StockController@deleteImages', ['id' => $images->id, 'stock_id' => $images->stock_id]) }}" class="btn btn-danger btn-sm"><i class="fal fa-trash"></i> Delete</a>
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
                                    {{-- Transaction --}}
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-cog width-2 fs-xl"></i>TRANSACTION LOG</h5>
                                        </div>
                                        <div class="card-body">
                                            @if (Session::has('msg'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('msg') }}</div>
                                            @endif
                                            @if (Session::has('noty'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('noty') }}</div>
                                            @endif
                                            @if (Session::has('notyIn'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notyIn') }}</div>
                                            @endif
                                            @if (Session::has('notyOut'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notyOut') }}</div>
                                            @endif
                                            <div class="table-responsive">
                                                <table id="log" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr align="center" class="bg-primary-50">
                                                            <th style="vertical-align: middle">#ID</th>
                                                            <th style="vertical-align: middle">StockIn (+)</th>
                                                            <th style="vertical-align: middle">StockOut (-)</th>
                                                            <th style="vertical-align: middle">Balance (=)</th>
                                                            <th style="vertical-align: middle">UnitPrice (RM)</th>
                                                            <th style="vertical-align: middle">Status</th>
                                                            <th style="vertical-align: middle">Transaction Date</th>
                                                            <th style="vertical-align: middle">Remark</th>
                                                            <th style="vertical-align: middle">L.O. Number</th>
                                                            <th style="vertical-align: middle">Invoice Number</th>
                                                            <th style="vertical-align: middle">Purchase Date</th>
                                                            <th style="vertical-align: middle">Supply Type</th>
                                                            <th style="vertical-align: middle">Supply To</th>
                                                            <th style="vertical-align: middle">Reason</th>
                                                            <th style="vertical-align: middle">Created By</th>
                                                            <th style="vertical-align: middle">Created Date</th>
                                                            <th style="vertical-align: middle">Action</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Stock In"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Stock Out"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Balance"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Unit Price"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Status"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Transaction Date"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Remark"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="L.O. Number"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Invoice Number"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Purchase Date"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Reason"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Supply Type"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Supply To"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Created By"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Created At"></td>
                                                            <td class="hasinput"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $total_bal = 0; @endphp

                                                    @foreach($stock->transaction as $list)
                                                    <tr align="center" class="data-row">
                                                        <td>{{ isset($list->id) ? $list->id : '--'}}</td>
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
                                                        <td>{{ isset($list->remark) ? $list->remark : '--'}}</td>
                                                        <td>{{ isset($list->lo_no) ? $list->lo_no : '--'}}</td>
                                                        <td>{{ isset($list->io_no) ? $list->io_no : '--'}}</td>
                                                        <td>{{ isset($list->purchase_date) ? date('Y-m-d', strtotime($list->purchase_date)) : '--' }}</td>
                                                        @if($list->supply_type == 'INT')
                                                            <td>INTERNAL</td>
                                                        @else
                                                            <td>EXTERNAL</td>
                                                        @endif
                                                        @if($list->supply_type == 'INT')
                                                            <td>{{ isset($list->users->name) ? strtoupper($list->users->name) : '--' }}</td>
                                                        @else
                                                            <td>{{ isset($list->ext_supply_to) ? strtoupper($list->ext_supply_to) : '--' }}</td>
                                                        @endif
                                                        <td>{{ isset($list->reason) ? $list->reason : '--'}}</td>
                                                        <td>{{ isset($list->user->name) ? strtoupper($list->user->name) : '--' }}</td>
                                                        <td>{{ isset($list->created_at) ? date('Y-m-d |  h:i A', strtotime($list->created_at)) : '--' }}</td>
                                                        <td>
                                                            @if($list->status == '1')
                                                                <a href="" data-target="#crud-modalIn" data-toggle="modal" data-id="{{$list->id}}" data-stock="{{$list->stock_in}}" data-lo="{{$list->lo_no}}" data-io="{{$list->io_no}}" 
                                                                    data-price="{{$list->unit_price}}" data-purchase="{{$list->purchase_date}}" data-trans="{{$list->trans_date}}" data-remark="{{$list->remark}}" class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                                                            @else
                                                                <a href="" data-target="#crud-modalOut" data-toggle="modal" data-id="{{$list->id}}" data-stock="{{$list->stock_out}}" data-reason="{{$list->reason}}" data-supply="{{$list->supply_to}}" 
                                                                    data-extsupply="{{$list->ext_supply_to}}" data-trans="{{$list->trans_date}}" data-type="{{$list->supply_type}}"  class="btn btn-sm btn-danger"><i class="fal fa-pencil"></i></a>
                                                            @endif
                                                            <a href="{{ action('StockController@deleteTrans', ['id' => $list->id, 'stock_id' => $list->stock_id]) }}" class="btn btn-warning btn-sm"><i class="fal fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div><br>
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
                                    <h5 class="card-title w-100">TRANSACTION IN DETAIL</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'StockController@createTransIn', 'method' => 'POST']) !!}
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
                                            <td width="15%"><label class="form-label" for="unit_price"><span class="text-danger">*</span> Unit Price (RM) :</label></td>
                                            <td colspan="7">
                                                <input type="number" step="any" value="{{ old('unit_price') }}" class="form-control" id="unit_price" name="unit_price" required>
                                                @error('unit_price')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="purchase_date"><span class="text-danger">*</span> Purchase Date :</label></td>
                                            <td colspan="7">
                                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" required>
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
                                            <td width="15%"><label class="form-label" for="lo_no"><span class="text-danger">*</span> L.O. Number :</label></td>
                                            <td colspan="7">
                                                <input value="{{ old('lo_no') }}" class="form-control" id="lo_no" name="lo_no" required>
                                                @error('lo_no')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="io_no"><span class="text-danger">*</span> Invoice Number :</label></td>
                                            <td colspan="7">
                                                <input value="{{ old('io_no') }}" class="form-control" id="io_no" name="io_no" required>
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

                    <div class="modal fade" id="crud-modals" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100">TRANSACTION OUT DETAIL</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'StockController@createTransOut', 'method' => 'POST']) !!}
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
                                                    <option value=""> Select User </option>
                                                    @foreach ($user as $usr) 
                                                        <option value="{{ $usr->id }}" {{ old('supply_to') ==  $usr->id  ? 'selected' : '' }}>{{ $usr->id }} - {{ $usr->name }}</option>
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

                    <div class="modal fade" id="crud-modalIn" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-sign-in-alt width-2 fs-xl"></i>EDIT TRANSACTION IN</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'StockController@updateTransin', 'method' => 'POST']) !!}
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
                                        <td width="15%"><label class="form-label" for="unit_price"><span class="text-danger">*</span> Unit Price (RM) :</label></td>
                                        <td colspan="7">
                                            <input type="number" step="any" value="{{ old('unit_price') }}" class="form-control price" id="unit_price" name="unit_price" required>
                                            @error('unit_price')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="purchase_date"><span class="text-danger">*</span> Purchase Date :</label></td>
                                        <td colspan="7">
                                            <input type="date" class="form-control purchase" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" required>
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
                                        <td width="15%"><label class="form-label" for="lo_no"><span class="text-danger">*</span> L.O. Number :</label></td>
                                        <td colspan="7">
                                            <input value="{{ old('lo_no') }}" class="form-control lo" id="lo_no" name="lo_no" required>
                                            @error('lo_no')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                    </div>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="io_no"><span class="text-danger">*</span> Invoice Number :</label></td>
                                        <td colspan="7">
                                            <input value="{{ old('io_no') }}" class="form-control io" id="io_no" name="io_no" required>
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

                    <div class="modal fade" id="crud-modalOut" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title w-100"><i class="fal fa-sign-in-alt width-2 fs-xl"></i>EDIT TRANSACTION OUT</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'StockController@updateTransout', 'method' => 'POST']) !!}
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
                                                @foreach ($user as $usr) 
                                                    <option value="{{ $usr->id }}" {{ old('supply') ==  $usr->id  ? 'selected' : '' }}>{{ $usr->name }}</option>
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
        $('#statuss').select2();

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
                "order": [[ 6, "desc" ]],
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

</script>

@endsection
