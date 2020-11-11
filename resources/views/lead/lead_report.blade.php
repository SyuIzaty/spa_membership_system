@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> Export
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Export</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            {{-- <form action="{{url('export_applicant')}}" method="GET" id="upload_form"> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Group</label>
                                        <select class="selectfilter form-control" name="group" id="group">
                                            <option value="">Select Option</option>
                                            <option>All</option>
                                            @foreach($group as $grp)
                                                <option value="{{$grp->id}}" <?php if($request->group == $grp->id) echo "selected"; ?> >{{$grp->group_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select class="selectfilter form-control" name="status" id="status">
                                            <option value="">Select Option</option>
                                            <option>All</option>
                                            @foreach($status as $statuses)
                                            <option value="{{ $statuses->status_code }}" {{ $request->status == $statuses->status_code ? 'selected="selected"' : ''}}>{{ $statuses->status_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                            {{-- </form> --}}

                            <table class="table table-bordered" id="rep">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>NO</th>
                                        <th>NAME</th>
                                        <th>IC</th>
                                        <th>PHONE NO.</th>
                                        <th>EMAIL</th>
                                        <th>GROUP</th>
                                        <th>STATUS</th>
                                        <th>ASSIGN TO</th>
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

        $('#group, #status').select2();

        function createDatatable(group = null ,status = null)
        {
            $('#rep').DataTable().destroy();
            var table = $('#rep').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_leadexport",
                data: {group:group, status:status},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": false,"targets":[8]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'leads_name', name: 'leads_name' },
                    { data: 'leads_ic', name: 'leads_ic' },
                    { data: 'leads_phone', name: 'leads_phone' },
                    { data: 'leads_email', name: 'leads_email' },
                    { data: 'leads_group', name: 'leads_group' },
                    { data: 'leads_status', name: 'leads_status' },
                    { data: 'assigned_to', name: 'assigned_to' },
                    { data: 'created_at', name: 'created_at' },
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                },
                select : true,
                buttons: [
                    {
                        extend : 'csv',
                        text : 'Export',
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
            var group = $('#group').val();
            var status = $('#status').val();
            createDatatable(group,status);
        });

    });
</script>
@endsection
