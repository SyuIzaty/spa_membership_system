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
                          <div class="row">
                            <div class="col-md-3">
                              <label>From</label>
                              <input type="date" class="selectfilter form-control" name="from" id="from">
                            </div>
                            <div class="col-md-3">
                                <label>To</label>
                                <input type="date" class="selectfilter form-control" name="to" id="to">
                            </div>
                            <div class="col-md-3">
                                <label>Department</label>
                                <select class="selectfilter form-control" name="department" id="department">
                                    <option value="">Select Option</option>
                                    @foreach($department as $departments)
                                    <option value="{{$departments->department_code}}" <?php if($request->department == $departments->department_code) echo "selected"; ?> >{{$departments->department_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select class="selectfilter form-control" name="status" id="status">
                                    <option value="">Select Option</option>
                                    @foreach($status as $statuses)
                                    <option value="{{$statuses->arkib_status}}" <?php if($request->status == $statuses->arkib_status) echo "selected"; ?> >{{$statuses->arkib_description}}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <br>
                          <div class="table-responsive">

                              <table class="table table-bordered" id="all">
                                  <thead>
                                      <tr class="bg-primary-50 text-center">
                                          <th>TITLE</th>
                                          <th>DESCRIPTION</th>
                                          <th>DEPARTMENT</th>
                                          <th>STATUS</th>
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
    .buttons-excel{
        color: white;
        background-color: #606FAD;
        float: right;
    }
</style>
<script >

    $(document).ready(function()
    {

        $('#department, #status, #duration').select2();

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
        function createDatatable(department = null, status = null, from = null, to = status)
        {
            $('#all').DataTable().destroy();
            var table = $('#all').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_exportarkib",
                data: {department:department, status:status, from:from, to:to},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 200, "All"]],
            iDisplayLength: 10,
            columns: [
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'dept', name: 'department.department_name' },
                    { data: 'stat', name: 'arkibStatus.arkib_description' },
                    { data: 'created_at', name: 'created_at' },
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                },
                select : true,
                buttons: [
                    {
                        extend : 'excel',
                        text : 'Export Current Page',
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
                            var s3 = '<xf numFmtId="4" fontId="2" fillId="5" borderId="1" applyFont="1" applyFill="1" applyBorder="1" xfId="0" applyNumberFormat="1">'
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
            var department = $('#department').val();
            var status = $('#status').val();
            var from = $('#from').val();
            var to = $('#to').val();
            createDatatable(department,status,from,to);
        });

    });
</script>
@endsection
