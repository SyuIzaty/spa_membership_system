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
                                                                    <td colspan="3" align="center" style="vertical-align: middle">
                                                                        @if(isset($image))
                                                                            <img src="/get-file-images/{{ $image->upload_image }}" style="width:300px; height:300px;" class="img-fluid">
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
                                                                        <input class="form-control" id="stock_name" name="stock_name" value="{{ $stock->stock_name }}">
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
                                                                        <input class="form-control" id="model" name="model" value="{{ $stock->model }}">
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
                                                                        <input class="form-control" id="brand" name="brand" value="{{ $stock->brand }}">
                                                                        @error('brand')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="status"> Availability:</label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control status" name="status" id="status">
                                                                            <option value="">Select Status</option>
                                                                            @foreach ($status as $stat) 
                                                                                <option value="{{ $stat->id }}" {{ $stock->status == $stat->id ? 'selected="selected"' : '' }}>{{ $stat->status_name }}</option>
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
                                                <div class="table-responsive">
                                                    <table id="log" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr align="center" class="bg-primary-50">
                                                                <th style="vertical-align: middle">No.</th>
                                                                <th style="width:90px; vertical-align: middle" width="90">StockIn (+)</th>
                                                                <th style="width:90px; vertical-align: middle">StockOut (-)</th>
                                                                <th style="vertical-align: middle">Balance (=)</th>
                                                                <th style="vertical-align: middle">UnitPrice (RM)</th>
                                                                <th style="vertical-align: middle">Status</th>
                                                                <th style="vertical-align: middle">Remark</th>
                                                                <th style="vertical-align: middle">L.O. Number</th>
                                                                <th style="vertical-align: middle">Invoice Number</th>
                                                                <th style="vertical-align: middle">Purchase Date</th>
                                                                <th style="vertical-align: middle">Created Date</th>
                                                                <th style="vertical-align: middle">Created By</th>
                                                                {{-- <th style="vertical-align: middle">Action</th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($stock->transaction as $list)
                                                            <tr align="center" class="data-row">
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ isset($list->trans_in) ? $list->trans_in : '--'}}</td>
                                                                <td>{{ isset($list->trans_out) ? $list->trans_out : '--'}}</td>
                                                                <td>{{ isset($list->current_balance) ? $list->current_balance : '--'}}</td>
                                                                <td>{{ isset($list->unit_price) ? $list->unit_price : '--'}}</td>
                                                                {{-- <td>
                                                                    @if($list->status == '1')
                                                                        <div style="text-transform: uppercase; color: #3CBC3C"><b>IN</b></div>
                                                                    @else
                                                                        <div style="text-transform: uppercase; color: #CC0000"><b>OUT</b></div>
                                                                    @endif
                                                                </td> --}}
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
                                                                <td>{{ isset($list->remark) ? $list->remark : '--'}}</td>
                                                                <td>{{ isset($list->lo_no) ? $list->lo_no : '--'}}</td>
                                                                <td>{{ isset($list->io_no) ? $list->io_no : '--'}}</td>
                                                                <td>{{ isset($list->trans_date) ? date('d/m/Y', strtotime($list->trans_date)) : '--' }}</td>
                                                                <td>{{ isset($list->created_at) ? date('d/m/Y', strtotime($list->created_at)) : '--' }}</td>
                                                                <td>{{ isset($list->user->name) ? strtoupper($list->user->name) : '--' }}</td>
                                                                {{-- <td>
                                                                    <a href="" data-target="#crud-modals" data-toggle="modal" data-id="{{$list->id}}" data-custodian="{{$list->custodian->custodian->name}}" data-reason="{{$list->reason_remark}}" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                                                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                                                </td> --}}
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div><br>
                                                @if(isset($transIn))
                                                    @if($transIn->current_balance > 0)
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
                                            <td width="15%"><label class="form-label" for="lo_no"><span class="text-danger">*</span> L.O. Number :</label></td>
                                            <td colspan="7">
                                                <input value="{{ old('lo_no') }}" class="form-control" id="lo_no" name="lo_no">
                                                @error('lo_no')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="io_no"><span class="text-danger">*</span> Invoice Number :</label></td>
                                            <td colspan="7">
                                                <input value="{{ old('io_no') }}" class="form-control" id="io_no" name="io_no">
                                                @error('io_no')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="trans_in"><span class="text-danger">*</span> Stock In :</label></td>
                                            <td colspan="7">
                                                <input type="number" step="any" value="{{ old('trans_in') }}" class="form-control" id="trans_in" name="trans_in">
                                                @error('trans_in')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="unit_price"><span class="text-danger">*</span> Unit Price (RM) :</label></td>
                                            <td colspan="7">
                                                <input type="number" step="any" value="{{ old('unit_price') }}" class="form-control" id="unit_price" name="unit_price">
                                                @error('unit_price')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="trans_date"><span class="text-danger">*</span> Purchase Date :</label></td>
                                            <td colspan="7">
                                                <input type="date" class="form-control" id="trans_date" name="trans_date" value="{{ old('trans_date') }}">
                                                @error('trans_date')
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
                                            <td width="15%"><label class="form-label" for="trans_out"><span class="text-danger">*</span> Stock Out :</label></td>
                                            <td colspan="7">
                                                <input type="number" step="any" value="{{ old('trans_out') }}" class="form-control" id="trans_out" name="trans_out">
                                                @error('trans_out')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <td width="15%"><label class="form-label" for="trans_date"><span class="text-danger">*</span> Transaction Date :</label></td>
                                            <td colspan="7">
                                                <input type="date" class="form-control" id="trans_date" name="trans_date" value="{{ old('trans_date') }}">
                                                @error('trans_date')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                        </div> --}}
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

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        // $('#crud-modal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget) 
        //     var depart = button.data('depart') 

        //     document.getElementById("depart").value = depart;
        // });

        $('#news').click(function () {
            $('#crud-modals').modal('show');
        });

        // $('#crud-modals').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget) 
        //     var id = button.data('id') 
        //     var custodian = button.data('custodian')
        //     var reason = button.data('reason')

        //     $('.modal-body #ids').val(id); 
        //     $('.modal-body #custodian').val(custodian); 
        //     $('.modal-body #reason').val(reason); 
        // });

    });

    $(document).ready(function()
    {
        $('#statuss').select2();

        // $('#log thead tr .hasinput').each(function(i)
        // {
        //     $('input', this).on('keyup change', function()
        //     {
        //         if (table.column(i).search() !== this.value)
        //         {
        //             table
        //                 .column(i)
        //                 .search(this.value)
        //                 .draw();
        //         }
        //     });

        //     $('select', this).on('keyup change', function()
        //     {
        //         if (table.column(i).search() !== this.value)
        //         {
        //             table
        //                 .column(i)
        //                 .search(this.value)
        //                 .draw();
        //         }
        //     });
        // });

        // var table = $('#log').DataTable({
        //     columnDefs: [],
        //         orderCellsTop: true,
        //         "order": [[ 0, "asc" ]],
        //         "initComplete": function(settings, json) {
        //         }
        // });

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
