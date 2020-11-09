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
                                        <label>Intake</label>
                                        <select class="selectfilter form-control" name="intake" id="intake">
                                            <option value="">Select Option</option>
                                            <option>All</option>
                                            @foreach($intake as $int)
                                            <option value="{{$int->id}}" <?php if($request->intake == $int->id) echo "selected"; ?> >{{$int->intake_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Batch</label>
                                        <select class="selectfilter form-control" name="batch_code" id="batch_code">
                                            <option value="">Select Option</option>
                                            <option>All</option>
                                            @foreach($batch as $bat)
                                            <option <?php if($request->batch_code == $bat->batch_code) echo "selected"; ?> >{{$bat->batch_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Programme Offered</label>
                                        <select class="selectfilter form-control" name="program" id="program">
                                            <option value="">Select Option</option>
                                            <option>All</option>
                                            @foreach($program as $pro)
                                            {{-- <option <?php if($request->program == $pro->id) echo "selected"; ?> >{{$pro->programme_code}}</option> --}}
                                            <option value="{{ $pro->id }}" {{ $request->program == $pro->id ? 'selected="selected"' : ''}}>{{ $pro->programme_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select class="selectfilter form-control" name="status" id="status">
                                            <option value="">Select Option</option>
                                            <option>All</option>
                                            @foreach($status as $statuses)
                                            {{-- <option <?php if($request->status == $statuses->status_code) echo "selected"; ?> >{{$statuses->status_code}}</option> --}}
                                            <option value="{{ $statuses->status_code }}" {{ $request->status == $statuses->status_code ? 'selected="selected"' : ''}}>{{ $statuses->status_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                            {{-- </form> --}}

                            <table class="table table-bordered" id="all">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>NO</th>
                                        <th>APPLICANT</th>
                                        <th>IC</th>
                                        <th>INTAKE</th>
                                        <th>SPONSOR CODE</th>
                                        <th>PROG 1</th>
                                        <th>PROG 2</th>
                                        <th>PROG 3</th>
                                        <th>BM</th>
                                        <th>ENG</th>
                                        <th>MATH</th>
                                        <th>PHONE</th>
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

        $('#intake, #batch_code, #program, #status').select2();

        $('#offer thead tr .hasinput').each(function(i)
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
        });

        function createDatatable(intake = null ,batch = null ,program = null ,status = null)
        {
            $('#all').DataTable().destroy();
            var table = $('#all').DataTable({
            processing: true,
            // serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_allexport",
                data: {intake:intake, batch:batch, program:program, status:status},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            iDisplayLength: 10,
            columnDefs: [{ "visible": false,"targets":[11]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'applicant_name', name: 'applicant_name' },
                    { data: 'applicant_ic', name: 'applicant_ic' },
                    { data: 'intake_id', name: 'intake_id' },
                    { data: 'sponsor_code', name: 'sponsor_code' },
                    { data: 'prog_name', name: 'prog_name' },
                    { data: 'prog_name_2', name: 'prog_name_2' },
                    { data: 'prog_name_3', name: 'prog_name_3' },
                    { data: 'bm', name: 'bm' },
                    { data: 'english', name: 'english' },
                    { data: 'math', name: 'math' },
                    { data: 'applicant_phone', name: 'applicant_phone'},
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
            var intake = $('#intake').val();
            var batch = $('#batch_code').val();
            var program = $('#program').val();
            var status = $('#status').val();
            createDatatable(intake,batch,program,status);
        });

    });
</script>
@endsection
