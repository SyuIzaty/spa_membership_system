@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-cogs'></i> TRAINING DETAILS
        </h1>
    </div>

        <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 20px;">
                            TRAINING ID : #{{ $train->id }}
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
                                    {!! Form::open(['action' => ['TrainingController@updateTraining'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                    {{Form::hidden('id', $train->id)}}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="card-title w-100"><i class="fal fa-cube width-2 fs-xl"></i>TRAINING INFO</h5>
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('notification'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table id="asset" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                        <thead>
                                                            <div style="float: right"><i><b>Updated Date : </b>{{ date(' j F Y | h:i:s A', strtotime($train->updated_at) )}}</i></div><br>
                                                            <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="title"><span class="text-danger">*</span> Title : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="title" name="title" value="{{ $train->title }}">
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="start_date"> Start Date : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ isset($train->start_date) ? date('Y-m-d', strtotime($train->start_date)) : old('start_date') }}">
                                                                        @error('start_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="end_date"> End Date : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ isset($train->end_date) ? date('Y-m-d', strtotime($train->end_date)) : old('end_date') }}">
                                                                        @error('end_date')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="type"> Type : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" name="type" id="type">
                                                                            <option value="">Please Select</option>
                                                                            @foreach ($data_type as $types) 
                                                                                <option value="{{ $types->id }}" {{ $train->type == $types->id ? 'selected="selected"' : '' }}>{{ strtoupper($types->type_name) }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('type')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="category"> Category : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" name="category" id="category">
                                                                            <option value="">Please Select</option>
                                                                            @foreach ($data_category as $categories) 
                                                                                <option value="{{ $categories->id }}" {{ $train->category == $categories->id ? 'selected="selected"' : '' }}>{{ strtoupper($categories->category_name) }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('category')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="venue"> Venue : </label></td>
                                                                    <td colspan="3">
                                                                        <input class="form-control" id="venue" name="venue" value="{{ $train->venue }}">
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="evaluation"><span class="text-danger">*</span> Evaluation : </label></td>
                                                                    <td colspan="3">
                                                                        <select class="form-control" name="evaluation" id="evaluation">
                                                                            <option value="">Please Select</option>
                                                                            @foreach ($data_evaluation as $evaluates) 
                                                                                <option value="{{ $evaluates->id }}" {{ $train->evaluation == $evaluates->id ? 'selected="selected"' : '' }}>{{ strtoupper($evaluates->evaluation) }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('evaluation')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label" for="upload_image"> Upload Image : </label></td>
                                                                    <td colspan="3">
                                                                        <input type="file" class="form-control" id="upload_image" name="upload_image">
                                                                        @error('upload_image')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="25%"><label class="form-label"> Total Participant : </label></td>
                                                                    <td colspan="3">
                                                                        No Participant
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                    <a style="margin-right:5px" href="/training-list" class="btn btn-success ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a><br><br>
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
                                                    TRAINING IMAGE
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
                                                            <table id="assets" class="table table-bordered table-hover table-striped w-100 mb-1">
                                                                <thead>
                                                                    <tr align="center">
                                                                        @if(isset($train->upload_image))
                                                                            <td colspan="5">
                                                                                <a data-fancybox="gallery" href="/get-train-image/{{ $train->upload_image }}"><img src="/get-train-image/{{ $train->upload_image }}" style="width:1080px; height:500px;" class="img-fluid mr-2"></a><br><br>
                                                                            </td>
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
                                    {{-- Participant --}}
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title w-100"><i class="fal fa-users width-2 fs-xl"></i>LIST OF PARTICIPANT
                                                {{-- @if($training_history->first() != null) --}}
                                                <a data-page="#" class="float-right" style="cursor: pointer" onclick="Print(this)"><i class="fal fa-file-pdf" style="color: red; font-size: 20px"></i></a>
                                            {{-- @endif --}}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                {{-- <table id="log" class="table table-bordered table-hover table-striped w-100">
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
                                                </table> --}}
                                            </div><br>
                                        </div>
                                    </div>
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
        $('#evaluation, #type, #category').select2();
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
