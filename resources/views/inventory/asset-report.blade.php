@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> ASSET REPORT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>EXPORT ASSET REPORT</h2>
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
                                    <label>Department</label>
                                    <select class="selectfilter form-control" name="department" id="department">
                                        <option value="">Select Department</option>
                                        <option>All</option>
                                        @foreach($department as $depart)
                                            <option value="{{$depart->id}}" <?php if($request->department == $depart->id) echo "selected"; ?> >{{$depart->department_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Status</label>
                                    <select class="selectfilter form-control" name="status" id="status">
                                        <option value="">Select Status</option>
                                        <option>All</option>
                                        @foreach($status as $stat)
                                            <option value="{{$stat->id}}" {{ $request->status == $stat->id  ? 'selected' : '' }}>{{strtoupper($stat->status_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Type</label>
                                    <select class="selectfilter form-control" name="type" id="type">
                                        <option value="">Select Type</option>
                                        <option>All</option>
                                        @foreach($type as $types)
                                            <option value="{{$types->id}}" <?php if($request->type == $types->id) echo "selected"; ?> >{{$types->asset_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="rep">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>ASSET CODE</th>
                                            <th>ASSET NAME</th>
                                            <th>ASSET TYPE</th>
                                            <th>SERIAL NO.</th>
                                            <th>MODEL</th>
                                            <th>BRAND</th>
                                            <th>PRICE (RM)</th>
                                            <th>L.O. NO.</th>
                                            <th>D.D. NO.</th>
                                            <th>INVOICE NO.</th>
                                            <th>PURCHASE DATE</th>
                                            <th>VENDOR</th>
                                            <th>CUSTODIAN</th>
                                            <th>LOCATION</th>
                                            <th>CREATED BY</th>
                                            <th>REMARK</th>
                                            <th>STATUS</th>
                                            <th>BARCODE</th>
                                            <th>QRCODE</th>
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
        $('#department, #status, #type').select2();

        function createDatatable(department = null, status = null, type = null)
        {
            $('#rep').DataTable().destroy();
            var table = $('#rep').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_assetexport",
                data: {department:department, status:status, type:type},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": false,"targets":[19]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'asset_code', name: 'asset_code' },
                    { data: 'asset_name', name: 'asset_name' },
                    { data: 'asset_type', name: 'asset_type' },
                    { data: 'serial_no', name: 'serial_no' },
                    { data: 'model', name: 'model' },
                    { data: 'brand', name: 'brand' },
                    { data: 'total_price', name: 'total_price' },
                    { data: 'lo_no', name: 'lo_no' },
                    { data: 'do_no', name: 'do_no' },
                    { data: 'io_no', name: 'io_no' },
                    { data: 'purchase_date', name: 'purchase_date' },
                    { data: 'vendor_name', name: 'vendor_name' },
                    { data: 'custodian_id', name: 'custodian_id' },
                    { data: 'storage_location', name: 'storage_location' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'remark', name: 'remark' },
                    { data: 'status', name: 'status' },
                    { data: 'barcode', name: 'barcode' },
                    { data: 'qrcode', name: 'qrcode' },
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
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
            var department = $('#department').val();
            var status = $('#status').val();
            var type = $('#type').val();
            createDatatable(department,status,type);
        });

    });
</script>
@endsection
