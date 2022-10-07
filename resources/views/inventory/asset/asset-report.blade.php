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
                                    <label>Availability</label>
                                    <select class="selectfilter form-control" name="availability" id="availability">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($availability as $available)
                                            <option value="{{$available->id}}" {{ $request->availability == $available->id  ? 'selected' : '' }}>{{strtoupper($available->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Type</label>
                                    <select class="selectfilter form-control" name="type" id="type">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($type as $types)
                                            <option value="{{$types->id}}" <?php if($request->type == $types->id) echo "selected"; ?> >{{$types->asset_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Class</label>
                                    <select class="selectfilter form-control" name="classs" id="classs">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        @foreach($class as $classes)
                                            <option value="{{$classes->class_code}}" <?php if($request->classs == $classes->class_code) echo "selected"; ?> >{{$classes->class_code}} - {{ $classes->class_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Status</label>
                                    <select class="selectfilter form-control" name="status" id="status">
                                        <option value="">Please Select</option>
                                        <option>All</option>
                                        <option value="1" {{ $request->status == '1' ? 'selected':''}} >ACTIVE</option>
                                        <option value="0" {{ $request->status == '0' ? 'selected':''}} >INACTIVE</option>
                                    </select>
                                </div>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="rep">
                                    <thead>
                                        <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                            <th>ID</th>
                                            <th>DEPARTMENT</th>
                                            <th>CODE TYPE</th>
                                            <th>FINANCE CODE</th>
                                            <th>ASSET CODE</th>
                                            <th>ASSET NAME</th>
                                            <th>ASSET TYPE</th>
                                            <th>ASSET CLASS</th>
                                            <th>SERIAL NO.</th>
                                            <th>MODEL</th>
                                            <th>BRAND</th>
                                            <th>STATUS</th>
                                            <th>INACTIVE DATE</th>
                                            <th>INACTIVE REASON</th>
                                            <th>INACTIVE REMARK</th>
                                            <th>AVAILABILITY</th>
                                            <th>SET</th>
                                            <th>PRICE (RM)</th>
                                            <th>L.O. NO.</th>
                                            <th>D.O. NO.</th>
                                            <th>INVOICE NO.</th>
                                            <th>PURCHASE DATE</th>
                                            <th>VENDOR</th>
                                            <th>ACQUISITION TYPE</th>
                                            <th>REMARK</th>
                                            <th>CUSTODIAN</th>
                                            <th>LOCATION</th>
                                            <th>CREATED BY</th>
                                            <th>NOTES</th>
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
        $('#availability, #type, #status, #classs').select2();

        function createDatatable(availability = null, type = null, status = null, classs = null)
        {
            $('#rep').DataTable().destroy();
            var table = $('#rep').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_assetexport",
                data: {availability:availability, type:type, status:status, classs:classs},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, 0], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": false,"targets":[26]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'department', name: 'department' },
                    { data: 'asset_code_type', name: 'asset_code_type' },
                    { data: 'finance_code', name: 'finance_code' },
                    { data: 'asset_code', name: 'asset_code' },
                    { data: 'asset_name', name: 'asset_name' },
                    { data: 'asset_type', name: 'asset_type' },
                    { data: 'asset_class', name: 'asset_class' },
                    { data: 'serial_no', name: 'serial_no' },
                    { data: 'model', name: 'model' },
                    { data: 'brand', name: 'brand' },
                    { data: 'status', name: 'status' },
                    { data: 'inactive_date', name: 'inactive_date' },
                    { data: 'inactive_reason', name: 'inactive_reason' },
                    { data: 'inactive_remark', name: 'inactive_remark' },
                    { data: 'availability', name: 'availability' },
                    { data: 'set_package', name: 'set_package' },
                    { data: 'total_price', name: 'total_price' },
                    { data: 'lo_no', name: 'lo_no' },
                    { data: 'do_no', name: 'do_no' },
                    { data: 'io_no', name: 'io_no' },
                    { data: 'purchase_date', name: 'purchase_date' },
                    { data: 'vendor_name', name: 'vendor_name' },
                    { data: 'acquisition_type', name: 'acquisition_type' },
                    { data: 'remark', name: 'remark' },
                    { data: 'custodian_id', name: 'custodian_id' },
                    { data: 'storage_location', name: 'storage_location' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'notes', name: 'notes' },

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
            var availability = $('#availability').val();
            var type = $('#type').val();
            var status = $('#status').val();
            var classs = $('#classs').val();
            createDatatable(availability,type,status,classs);
        });

    });
</script>
@endsection
