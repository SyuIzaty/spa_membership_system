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
                        <h2>Block</h2>
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
                            <table class="table table-bordered" id="block_table">
                              <thead>
                                  <tr class="bg-primary-50 text-center">
                                      <th>ID</th>
                                      <th>BLOCK</th>
                                      <th>STATUS</th>
                                      <th>TOTAL</th>
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
                              <tbody></tbody>
                            </table>
                            <a class="btn btn-success btn-sm float-right mb-2 mt-2 ml-2" href="/space/space-setting/block/create">Upload Block</a>
                            <a class="btn btn-success btn-sm float-right mb-2 mt-2" href="javascript:;" data-toggle="modal" id="new">Add Block</a>
                          </div>
                        </div>

                        <div class="modal fade" id="crud-modal" aria-hidden="true" >
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title"> Add Block</h4>
                                  </div>
                                  <div class="modal-body">
                                      {!! Form::open(['action' => 'Space\SpaceSetting\BlockController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                      <table class="table table-bordered">
                                        <tr>
                                          <td>Block <span class="text-danger">*</span></td>
                                          <td><input type="text" class="form-control" name="block_name"></td>
                                        </tr>
                                        <tr>
                                          <td>Open / Closed <span class="text-danger">*</span></td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="block_status" id="store_status">
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
                                  <h4 class="modal-title">Update Block</h4>
                                </div>
                                {!! Form::open(['action' => ['Space\SpaceSetting\BlockController@update', '1'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="block_id" id="block_id">
                                <div class="modal-body">
                                  <table class="table table-bordered">
                                    <tr>
                                      <td>Block <span class="text-danger">*</span></td>
                                      <td><input type="text" class="form-control" name="block_name" id="block_name"></td>
                                    </tr>
                                    <tr>
                                      <td>Status</td>
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
  $('#new').click(function () {
      $('#crud-modal').modal('show');
  });

  $(document).ready(function() {
      var table = $('#block_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: false,
        ajax: {
            url: window.location.href,
        },

        columns: [
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { 
                  data: 'block_status',
                  name: 'space-setting.name',
                  render: function(data) {
                    if(data == 'Open') {
                      badge = 'success';
                    } else if (data == 'Closed') {
                      badge = 'danger';
                    }

                    return '<span class="badge badge-'+ badge +'">'+ data +'</span>';
                  }
                },
                { data: 'room_total', name: 'room_total'},
                { data: 'created_at', name: 'created_at'},
                { data: 'action'},
            ],
        order: [[ 0, "asc" ]],
        orderCellsTop: true,
        dom:"tpr",
        initComplete: function () {
          $("#block_table thead #filterRow .hasInputFilter").each( function ( i ) {
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
            url: '/space/space-setting/block/1',
            method:"GET",
            data:{id:id},
            dataType:"json",
            success:function(data){
                $('#block_id').val(data.id);
                $('#block_name').val(data.name);

                if(data.status_id == 9){
                  $('#status').prop('checked', true);
                } if(data.status_id != 9) {
                  $('#status').prop('checked', false);
                }
                $('.editModal').modal('show');
            }
        });
      });

  });

  $('#block_table').on('click', '.btn-delete[data-remote]', function (e) {
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
                $('#block_table').DataTable().draw(false);
            });
        }
    })
  });
</script>
@endsection
