@extends('layouts.admin')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
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
                                        <th>PHONE</th>
                                        <th>INTAKE</th>
                                        <th>SPONSOR CODE</th>
                                        <th>PROG 1</th>
                                        <th>PROG 2</th>
                                        <th>PROG 3</th>
                                        <th>BM</th>
                                        <th>ENG</th>
                                        <th>MATH</th>
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
    .buttons-excel{
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
            columnDefs: [{ "visible": false,"targets":[3]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'applicant_name', name: 'applicant_name' },
                    { data: 'applicant_ic', name: 'applicant_ic' },
                    { data: 'applicant_phone', name: 'applicant_phone'},
                    { data: 'intake_id', name: 'intake_id' },
                    { data: 'sponsor_code', name: 'sponsor_code' },
                    { data: 'prog_name', name: 'prog_name' },
                    { data: 'prog_name_2', name: 'prog_name_2' },
                    { data: 'prog_name_3', name: 'prog_name_3' },
                    { data: 'bm', name: 'bm' },
                    { data: 'english', name: 'english' },
                    { data: 'math', name: 'math' },
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                },
                select : true,
                buttons: [
                    {
                        extend : 'excel',
                        text : 'Export',
                        "createEmptyCells" : true,
                        customizeData: function(data) {
                            for(var i = 0; i < data.body.length; i++) {
                            for(var j = 0; j < data.body[i].length; j++) {
                                data.body[i][j] = '\u200C' + data.body[i][j];
                            }
                            }
                        },
                        customize : function(doc)
                        {
                            var sSh = doc.xl['styles.xml'];
                            var lastXfIndex = $('cellXfs xf', sSh).length - 1;
                            var s1 = '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="0"/>';
                            var s2 = '<xf numFmtId="0" fontId="2" fillId="5" borderId="1" applyFont="2" applyFill="1" applyBorder="1" xfId="0" applyAlignment="1">'
                                     +'<alignment horizontal="center"/></xf>';
                            var s3 = '<xf numFmtId="4" fontId="2" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1">'
                                     +'<alignment horizontal="center"/></xf>';
                            // var s3 = '<xf numFmtId="4" fontId="2" fillId="0" borderId="1" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1"/>';

                            sSh.childNodes[0].childNodes[5].innerHTML += s1 + s2 + s3;
                            var border = lastXfIndex + 1;
                            var colorBoldCentered = lastXfIndex + 2;
                            var boldBorder = lastXfIndex + 3;

                            var sheet = doc.xl.worksheets['sheet1.xml'];
                            // var x =  sheet.childNodes[0].childNodes[5].innerHTML;

                            $('row c', sheet).attr('s', border);
                            $('row:eq(0) c', sheet).attr( 's', colorBoldCentered );
                            $('row:eq(1) c',sheet).attr('s', boldBorder);
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
