@extends('layouts.admin')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
  <main id="js-page-content" role="main" class="page-content">
      <div class="subheader">
          <h1 class="subheader-title">
              <i class='subheader-icon fal fa-search'></i> Report
          </h1>
      </div>
      <div class="row">
          <div class="col-xl-12">
              <div id="panel-1" class="panel">
                  <div class="panel-hdr">
                      <h2>Task Report</h2>
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
                                <label>Member</label>
                                <select class="selectfilter form-control" name="user_id" id="user_id">
                                    <option value="">Select Option</option>
                                    @foreach($user as $users)
                                    <option value="{{$users->id}}" <?php if($request->user_id == $users->id) echo "selected"; ?> >{{$users->short_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Category</label>
                                <select class="selectfilter form-control" name="category_id" id="category_id">
                                    <option value="">Select Option</option>
                                    @foreach($category as $categories)
                                    <option value="{{$categories->id}}" <?php if($request->category_id == $categories->id) echo "selected"; ?> >{{$categories->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Type</label>
                                <select class="selectfilter form-control" name="type_id" id="type_id">
                                    <option value="">Select Option</option>
                                    @foreach($type as $types)
                                    <option value="{{$types->id}}" <?php if($request->type_id == $types->id) echo "selected"; ?> >{{$types->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Department</label>
                                <select class="selectfilter form-control" name="department_id" id="department_id">
                                    <option value="">Select Option</option>
                                    @foreach($department as $departments)
                                    <option value="{{$departments->id}}" <?php if($request->department_id == $departments->id) echo "selected"; ?> >{{$departments->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Progress</label>
                                <select class="selectfilter form-control" name="progress_id" id="progress_id">
                                    <option value="">Select Option</option>
                                    @foreach($status->where('category','Progress') as $statuses)
                                    <option value="{{$statuses->id}}" <?php if($request->progress_id == $statuses->id) echo "selected"; ?> >{{$statuses->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Priority</label>
                                <select class="selectfilter form-control" name="priority_id" id="priority_id">
                                    <option value="">Select Option</option>
                                    @foreach($status->where('category','Priority') as $statuses)
                                    <option value="{{$statuses->id}}" <?php if($request->priority_id == $statuses->id) echo "selected"; ?> >{{$statuses->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <br>
                          <div class="table-responsive">

                              <table class="table table-bordered" id="all">
                                  <thead>
                                      <tr class="bg-primary-50 text-center">
                                          <th>MEMBER</th>
                                          <th>CATEGORY</th>
                                          <th>SUB CATEGORY</th>
                                          <th>TYPE</th>
                                          <th>DEPARTMENT</th>
                                          <th>START DATE</th>
                                          <th>END DATE</th>
                                          <th>PROGRESS STATUS</th>
                                          <th>PRIORITY</th>
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

        $('.selectfilter').select2();

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
        function createDatatable(user_id = null, category_id = null, type_id = null, department_id = null, progress_id = null, priority_id = null)
        {
            $('#all').DataTable().destroy();
            var table = $('#all').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/task/task-report/data_exporttask",
                data: {user_id:user_id, category_id:category_id, type_id:type_id, department_id:department_id, progress_id:progress_id, priority_id:priority_id},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 200, "All"]],
            iDisplayLength: 10,
            columns: [
                    { data: 'user_name', name: 'taskUser.short_name' },
                    { data: 'category_name', name: 'taskCategory.name' },
                    { data: 'sub_category', name: 'sub_category' },
                    { data: 'type_name', name: 'taskType.name' },
                    { data: 'department_name', name: 'departmentList.name' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'progress_name', name: 'progressStatus.name' },
                    { data: 'priority_name', name: 'priorityStatus.name' },
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
            var user_id = $('#user_id').val();
            var category_id = $('#category_id').val();
            var type_id = $('#type_id').val();
            var department_id = $('#department_id').val();
            var progress_id = $('#progress_id').val();
            var priority_id = $('#priority_id').val();
            createDatatable(user_id,category_id,type_id,department_id,progress_id,priority_id);
        });

    });
</script>
@endsection
