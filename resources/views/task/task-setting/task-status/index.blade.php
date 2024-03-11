@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Task Setting
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Task Status</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                          <div class="col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <table class="table table-bordered" id="task_table">
                              <thead>
                                  <tr class="bg-primary-50 text-center">
                                      <th>ID</th>
                                      <th>NAME</th>
                                      <th>CREATED AT</th>
                                      <th>ACTION</th>
                                  </tr>
                                  <tr id="filterRow">
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th></th>
                                  </tr>
                              </thead>
                              <tbody></tbody>
                            </table>
                            <a class="btn btn-success btn-sm float-right mb-2 mt-2" href="javascript:;" data-toggle="modal" id="new">Add Task Status</a>
                          </div>
                        </div>

                        <div class="modal fade" id="crud-modal" aria-hidden="true" >
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title"> Add Task Status</h4>
                                  </div>
                                  <div class="modal-body">
                                      {!! Form::open(['action' => 'Task\TaskSetting\TaskStatusController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                      <table class="table table-bordered">
                                        <tr>
                                          <td style="width: 30%">Status <span class="text-danger">*</span></td>
                                          <td style="width: 70%"><input type="text" class="form-control" name="name"></td>
                                        </tr>
                                        <tr>
                                          <td>Color <span class="text-danger">*</span></td>
                                          <td><input type="color" name="color"></td>
                                        </tr>
                                      </table>
                                      <button class="btn btn-success btn-sm float-right">Submit</button>
                                      {!! Form::close() !!}
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="modal fade editModal" id="editModal" aria-hidden="true" >
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Update Task Status</h4>
                                </div>
                                {!! Form::open(['action' => ['Task\TaskSetting\TaskStatusController@update', '1'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="task_id" id="task_id">
                                <div class="modal-body">
                                  <table class="table table-bordered">
                                    <tr>
                                      <td style="width: 30%">Status <span class="text-danger">*</span></td>
                                      <td style="width: 70%"><input type="text" class="form-control" name="name" id="name_edit"></td>
                                    </tr>
                                    <tr>
                                      <td>Color <span class="text-danger">*</span></td>
                                      <td><input type="color" name="color" id="color_edit"></td>
                                    </tr>
                                  </table>
                                </div>
                                <div class="modal-footer">
                                  <button class="btn btn-success btn-sm float-right">Update</button>
                                  <button type="button" class="btn btn-secondary btn-sm text-white" data-dismiss="modal">Close</button>
                                </div>
                                {{Form::hidden('_method', 'PUT')}}
                                {!! Form::close() !!}
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
<script>
  $('#new').click(function () {
      $('#crud-modal').modal('show');
  });

  $(document).ready(function() {
      var table = $('#task_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: false,
        ajax: {
            url: window.location.href,
        },

        columns: [
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'created_at', name: 'created_at'},
                { data: 'action'},
            ],
        order: [[ 0, "asc" ]],
        orderCellsTop: true,
        dom:"tpr",
        initComplete: function () {
          $("#task_table thead #filterRow .hasInputFilter").each( function ( i ) {
              var colIdx = $(this).index();
              var input = $('<input class="form-control" type="text">')
                  .appendTo( $(this).empty() )
                  .on( 'keyup', function () {
                      table.column(colIdx)
                          .search( $(this).val() )
                          .draw();
                  } );

          } );
        }
      });

      $.ajaxSetup({
        headers:{
        'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });

      $(document).on('click', '.edit_data', function(){
        var id = $(this).attr("data-id");
        $.ajax({
            url: '/task/task-setting/task-status/1',
            method:"GET",
            data:{id:id},
            dataType:"json",
            success:function(data){
                $('#task_id').val(data.id);
                $('#name_edit').val(data.name);
                $('#color_edit').val(data.color);
                $('.editModal').modal('show');
            }
        });
      });

  });

  $('#task_table').on('click', '.btn-delete[data-remote]', function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            data: {method: '_DELETE', submit: true}
            }).always(function (data) {
                $('#task_table').DataTable().draw(false);
            });
        }
    })
  });
</script>
@endsection
