@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> BORROW REPORT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>EXPORT BORROW REPORT</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label>Asset</label>
                                    <select class="selectfilter form-control" name="asset" id="asset">
                                        <option value="">Select Asset</option>
                                        <option>All</option>
                                        @foreach($asset as $assets)
                                            <option value="{{$assets->id}}" <?php if($request->asset == $assets->id) echo "selected"; ?> >{{strtoupper($assets->asset_code)}} - {{strtoupper($assets->asset_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Borrower</label>
                                    <select class="selectfilter form-control" name="borrower" id="borrower">
                                        <option value="">Select Borrower</option>
                                        <option>All</option>
                                        @foreach($borrower as $borrowers)
                                            <option value="{{$borrowers->borrower_id}}" {{ $request->borrower == $borrowers->borrower_id  ? 'selected' : '' }}>{{strtoupper($borrowers->borrower->staff_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Status</label>
                                    <select class="selectfilter form-control" name="status" id="status">
                                        <option value="">Select Status</option>
                                        <option>All</option>
                                        @foreach($status as $statuss)
                                            <option value="{{$statuss->id}}" <?php if($request->status == $statuss->id) echo "selected"; ?> >{{$statuss->status_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="rep">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>#ID</th>
                                            <th>BORROWER</th>
                                            <th>ASSET TYPE</th>
                                            <th>ASSET CODE</th>
                                            <th>ASSET NAME</th>
                                            <th>REASON</th>
                                            <th>BORROW DATE</th>
                                            <th>RETURN DATE</th>
                                            <th>ACTUAL RETURN DATE</th>
                                            <th>VERIFIED BY</th>
                                            <th>REMARK</th>
                                            <th style="width: 150px">STATUS</th>
                                            <th>CREATED BY</th>
                                            <th>CREATED AT</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                                 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
<style>
    .buttons-csv{
        color: white;
        background-color: #606FAD;
        float: right;
    }
</style>
<script >
    
    $(document).ready(function()
    {
        $('#asset, #borrower, #status').select2();

        function createDatatable(asset = null, borrower = null, status = null)
        {
            $('#rep').DataTable().destroy();
            var table = $('#rep').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_borrowexport",
                data: {asset:asset, borrower:borrower, status:status},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": false,"targets":[13]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'borrower_id', name: 'borrower_id' },
                    { data: 'asset_type', name: 'asset_type' },
                    { data: 'asset_code', name: 'asset_code' },
                    { data: 'asset_name', name: 'asset_name' },
                    { data: 'reason', name: 'reason' },
                    { data: 'borrow_date', name: 'borrow_date' },
                    { data: 'return_date', name: 'return_date' },
                    { data: 'actual_return_date', name: 'actual_return_date' },
                    { data: 'verified_by', name: 'verified_by' },
                    { data: 'remark', name: 'remark' },
                    { data: 'status', name: 'status' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'created_at', name: 'created_at' },
                ],
                orderCellsTop: true,
                "order": [[ 0, "desc" ]],
                "initComplete": function(settings, json) {
                },
                select : true,
                buttons: [
                    {
                        extend : 'csv',
                        text : '<i class="fal fa-file-excel"></i> Export',
                        exportOptions : {
                            modifier : {
                                order : 'original',  // 'current', 'applied', 'index',  'original'
                                page : 'all',      // 'all',     'current'
                                search : 'none',     // 'none',    'applied', 'removed'
                                // selected: null
                            }
                        }
                    }
                ]
            });
        }

        $('.selectfilter').on('change',function(){
            var asset = $('#asset').val();
            var borrower = $('#borrower').val();
            var status = $('#status').val();
            createDatatable(asset,borrower,status);
        });

    });
</script>
@endsection
