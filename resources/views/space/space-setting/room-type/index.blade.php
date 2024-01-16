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
                        <h2>Room Type</h2>
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
                            <table class="table table-bordered" id="type_table">
                              <thead>
                                  <tr class="bg-primary-50 text-center">
                                      <th>ID</th>
                                      <th>ROOM TYPE</th>
                                      <th>DESCRIPTION</th>
                                      <th>STATUS</th>
                                      <th>CREATED AT</th>
                                      <th>ACTION</th>
                                  </tr>
                                  <tr id="filterRow">
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                            <a class="btn btn-success btn-sm float-right mb-2 mt-2 new" href="javascript:;" data-toggle="modal">Add Room Type</a>
                          </div>
                        </div>

                        <div class="modal fade" id="crud-modal" aria-hidden="true" >
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title"> Add Room Type</h4>
                                  </div>
                                  <div class="modal-body">
                                      {!! Form::open(['action' => 'Space\SpaceSetting\RoomTypeController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                      <table class="table table-bordered">
                                        <tr>
                                          <td>Room Type <span class="text-danger">*</span></td>
                                          <td><input type="text" class="form-control" name="room_name"></td>
                                        </tr>
                                        <tr>
                                          <td>Description <span class="text-danger">*</span></td>
                                          <td><input type="text" class="form-control" name="room_description"></td>
                                        </tr>
                                        <tr>
                                          <td>Enable Generate</td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="room_enable" id="store_enable">
                                              <label class="custom-control-label" for="store_enable"></label>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Status</td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="room_status" id="store_status">
                                              <label class="custom-control-label" for="store_status"></label>
                                            </div>
                                          </td>
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
                                  <h4 class="modal-title">Update Room Type</h4>
                                </div>
                                {!! Form::open(['action' => ['Space\SpaceSetting\RoomTypeController@update', '1'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="type_id" id="type_id">
                                <div class="modal-body">
                                  <table class="table table-bordered">
                                    <tr>
                                      <td>Room Type <span class="text-danger">*</span></td>
                                      <td><input type="text" class="form-control" name="room_name" id="room_name"></td>
                                    </tr>
                                    <tr>
                                      <td>Description <span class="text-danger">*</span></td>
                                      <td><input type="text" class="form-control" name="room_description" id="room_description"></td>
                                    </tr>
                                    <tr>
                                      <td>Status <span class="text-danger">*</span></td>
                                      <td>
                                        <div class="custom-control custom-switch">
                                          <input type="checkbox" class="custom-control-input" name="status" id="status">
                                          <label class="custom-control-label" for="status"></label>
                                        </div>
                                      </td>
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
  $('.new').click(function () {
      $('#crud-modal').modal('show');
  });

  $(document).ready(function() {
    var table = $('#type_table').DataTable({
      processing: true,
      serverSide: true,
      stateSave: false,
      ajax: {
          url: window.location.href,
      },

      columns: [
              { data: 'id', name: 'id'},
              { data: 'name', name: 'name'},
              { data: 'description', name: 'description'},
              { 
                data: 'type_status', 
                name: 'facilityStatus.name',
                render: function(data) {
                  if (data == 'Open'){
                    badge = 'success';
                  } else if (data == 'Closed'){
                    badge = 'danger';
                  }

                  return '<span class="badge badge-'+ badge +'">'+ data +'</span>';
                }
              },
              { data: 'created_at', name: 'created_at'},
              { data: 'action'},
          ],
      order: [[ 0, "asc" ]],
      orderCellsTop: true,
      dom:"tpr",
      initComplete: function () {
        $("#type_table thead #filterRow .hasInputFilter").each( function ( i ) {
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
          url: '/space/space-setting/room-type/1/edit',
          method:"GET",
          data:{id:id},
          dataType:"json",
          success:function(data){
              $('#type_id').val(data.id);
              $('#room_name').val(data.name);
              $('#room_description').val(data.description);

              if(data.status_id == 1){
                $('#status').prop('checked', true);
              } if(data.status_id != 1) {
                $('#status').prop('checked', false);
              }
              $('.editModal').modal('show');
          }
      });
    });

  });

  $('#type_table').on('click', '.btn-delete[data-remote]', function (e) {
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
                $('#type_table').DataTable().draw(false);
            });
        }
    })
  });
</script>
@endsection
