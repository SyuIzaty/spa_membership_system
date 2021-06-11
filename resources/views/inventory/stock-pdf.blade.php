@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC" style="margin-top: -40px"></center><br><br>

                <div align="left">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b> STOCK ID : #{{ $stock->id}}</b></h4>
                </div>

                <table id="stock" class="table table-bordered table-hover table-striped w-100 mb-1">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td rowspan="4" align="center" style="vertical-align: middle">
                                    @if(isset($image))
                                        <img src="/get-file-images/{{ $image->upload_image }}" style="width:200px; height:200px;" class="img-fluid">
                                    @else
                                        <img src="{{ asset('img/default.png') }}" style="height: 200px; width: 200px;" class="img-fluid">
                                    @endif
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="stock_code">Stock Code : </label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->stock_code) ? $stock->stock_code : '--' }}</td>
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="stock_name">Stock Name:</label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->stock_name) ? $stock->stock_name : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="model">Model:</label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->model) ? $stock->model : '--' }}</td>
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->brand) ? $stock->brand : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="status"> Availability:</label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->invStatus->status_name) ? $stock->invStatus->status_name : '--' }}</td>
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="created_by"> Created By : </label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->user->name) ? $stock->user->name : '--' }}</td>
                            </div>
                        </tr>
                    </thead>
                </table>

                <br>

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
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <br>
                <div style="font-style: italic; font-size: 10px">
                    <p style="float: left">@ Copyright INTEC Education College</p>
                    <p style="float: right">Review Date : {{ date(' j F Y | h:i:s A', strtotime($stock->updated_at) )}}</p><br>
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