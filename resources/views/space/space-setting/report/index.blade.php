@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Space Setting
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Room</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                          <div class="row">
                            <div class="col-md-4">
                              <p>Block</p>
                              <select class="form-control selectfilter" id="block_id">
                                <option disabled selected>Please Select</option>
                                @foreach($block as $blocks)
                                <option value="{{ $blocks->id }}">{{ $blocks->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-4">
                              <p>Open / Closed</p>
                              <select class="form-control selectfilter" id="status_id">
                                <option disabled selected>Please Select</option>
                                <option value="1">Open</option>
                                <option value="2">Closed</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <p>Room Type</p>
                              <select class="form-control selectfilter" id="room_type">
                                <option disabled selected>Please Select</option>
                                @foreach($type as $types)
                                <option value="{{ $types->id }}">{{ $types->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="col-md-12">
                              <table class="table table-bordered mt-3" id="all">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>ID</th>
                                        <th>BLOCK</th>
                                        <th>ROOM TYPE</th>
                                        <th>FLOOR</th>
                                        <th>ROOM NO / NAME</th>
                                        <th>CAPACITY</th>
                                        <th>OPEN / CLOSED</th>
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
        </div>
    </main>
@endsection
@section('script')
<script >

  $(document).ready(function()
  {
    $('.selectfilter').select2();

    function createDatatable(block_id = null ,status_id = null ,room_type = null)
    {
        $('#all').DataTable().destroy();
        var table = $('#all').DataTable({
        processing: true,
        serverSide: true,
        autowidth: false,
        deferRender: true,
        ajax: {
            url: "/space/data_spacereport",
            data: {block_id:block_id, status_id:status_id, room_type:room_type},
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        },
        "dom" : "Bltp",
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 200, "All"]],
        iDisplayLength: -1,
        columns: [
                { data: 'id', name: 'id' },
                { data: 'block_name', name: 'facilityBlock.name' },
                { data: 'type_name', name: 'facilityRoomType.name' },
                { data: 'floor', name: 'floor' },
                { data: 'name', name: 'name' },
                { data: 'capacity', name: 'capacity' },
                { data: 'status_name', name: 'facilityStatus.name' },
            ],
            orderCellsTop: true,
            "order": [[ 0, "asc" ]],
            "initComplete": function(settings, json) {
            },
            "fnDrawCallback": function () {
                $('.total_record').text(this.fnSettings().fnRecordsTotal());
            },
            select : true,
            buttons: ['csv']
            [
                {
                    text : 'Export Current Page',
                    "createEmptyCells" : true,
                    // action : newexportaction,
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
        var block_id = $('#block_id').val();
        var status_id = $('#status_id').val();
        var room_type = $('#room_type').val();
        createDatatable(block_id,status_id,room_type);
    });

  });
</script>
@endsection
