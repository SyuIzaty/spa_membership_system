@extends('layouts.applicant')
    
@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 50px; margin-bottom: 20px">
                
                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="320" alt="INTEC" style="margin-top: -40px"></center><br><br>

                <div align="left">
                    <h4 style="margin-top: -25px; margin-bottom: -15px"><b> STOCK ID : #{{ $stock->id}}</b></h4>
                </div>

                <table id="stock" class="table table-bordered table-hover table-striped w-100 mb-1">
                    <thead>
                        <tr>
                            <div class="form-group">
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="stock_code">Stock Code : </label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->stock_code) ? $stock->stock_code : '--' }}</td>
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="stock_name">Stock Name:</label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->stock_name) ? strtoupper($stock->stock_name) : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="model">Model:</label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->model) ? strtoupper($stock->model) : '--' }}</td>
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="brand"> Brand : </label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->brand) ? strtoupper($stock->brand) : '--' }}</td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="status"> Status:</label></td>
                                <td style="vertical-align: middle" colspan="3">
                                    @if ($stock->status == '1')
                                        ACTIVE
                                    @else
                                        INACTIVE
                                    @endif
                                </td>
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="availability"> Balance Status : </label></td>
                                <td style="vertical-align: middle" colspan="3">
                                    @if($total_bal <= 0)
                                        <b style="color:red">OUT OF STOCK</b>
                                    @else 
                                        <b style="color:green">READY STOCK</b>
                                    @endif
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div class="form-group">
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="created_by"> Created By : </label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->user->name) ? $stock->user->name : '--' }}</td>
                                <td style="vertical-align: middle" width="15%"><label class="form-label" for="created_at"> Created Date : </label></td>
                                <td style="vertical-align: middle" colspan="3">{{ isset($stock->created_at) ? date(' d/m/Y | h:i:s A', strtotime($stock->created_at) ) : '--' }}</td>
                            </div>
                        </tr>
                    </thead>
                </table>

                <br>
                {{-- <div class="table-responsive"> --}}
                    <table id="log" class="table table-bordered table-hover table-striped w-100 table-sm">
                        <thead>
                            <tr align="center" class="bg-primary-50" style="white-space: nowrap">
                                <th style="vertical-align: middle">#ID</th>
                                <th style="vertical-align: middle">StockIn (+)</th>
                                <th style="vertical-align: middle">StockOut (-)</th>
                                <th style="vertical-align: middle">Balance (=)</th>
                                <th style="vertical-align: middle">UnitPrice (RM)</th>
                                <th style="vertical-align: middle">Status</th>
                                <th style="vertical-align: middle">Transaction Date</th>
                                <th style="vertical-align: middle">Remark</th>
                                <th style="vertical-align: middle">L.O. No</th>
                                <th style="vertical-align: middle">Invoice No</th>
                                <th style="vertical-align: middle">Purchase Date</th>
                                <th style="vertical-align: middle">Supply Type</th>
                                <th style="vertical-align: middle">Supply To</th>
                                <th style="vertical-align: middle">Reason</th>
                                <th style="vertical-align: middle">Created By</th>
                                <th style="vertical-align: middle">Created At</th>
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
                                <td>{{ isset($list->trans_date) ? date('Y-m-d | h:i A', strtotime($list->trans_date)) : '--' }}</td>
                                <td>{{ isset($list->remark) ? $list->remark : '--'}}</td>
                                <td>{{ isset($list->lo_no) ? $list->lo_no : '--'}}</td>
                                <td>{{ isset($list->io_no) ? $list->io_no : '--'}}</td>
                                <td>{{ isset($list->purchase_date) ? date('Y-m-d', strtotime($list->purchase_date)) : '--' }}</td>
                                @if($list->supply_type == 'INT')
                                    <td>INT</td>
                                @else
                                    <td>EXT</td>
                                @endif
                                @if($list->supply_type == 'INT')
                                    <td>{{ isset($list->users->name) ? strtoupper($list->users->name) : '--' }}</td>
                                @else
                                    <td>{{ isset($list->ext_supply_to) ? strtoupper($list->ext_supply_to) : '--' }}</td>
                                @endif
                                <td>{{ isset($list->reason) ? $list->reason : '--'}}</td>
                                <td>{{ isset($list->user->name) ? strtoupper($list->user->name) : '--' }}</td>
                                <td>{{ isset($list->created_at) ? date('Y-m-d |  h:i A', strtotime($list->created_at)) : '--' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                {{-- </div> --}}
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
    // $(document).ready(function()
    // {
    //     var table = $('#log').DataTable({
    //         columnDefs: [],
    //             orderCellsTop: true,
    //             "order": [[ 6, "desc" ]],
    //             "initComplete": function(settings, json) {
    //             }
    //     });

    // });
</script>
@endsection