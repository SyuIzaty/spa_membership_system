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
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-sm-6 col-xl-6">
                                  <div class="p-3 bg-success-300 rounded overflow-hidden position-relative text-white mb-g">
                                      <div class="">
                                          <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                              {{ $open }}
                                              <small class="m-0 l-h-n">OPEN <b style="font-weight: 900">{{ Carbon\Carbon::now()->year }}</b></small>
                                          </h3>
                                      </div>
                                      <i class="fal fa-table position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                  </div>
                              </div>
                              <div class="col-sm-6 col-xl-6">
                                  <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
                                      <div class="">
                                          <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ $closed }}
                                              <small class="m-0 l-h-n">CLOSED <b style="font-weight: 900">{{ Carbon\Carbon::now()->year }}</b></small>
                                          </h3>
                                      </div>
                                      <i class="fal fa-table position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                  </div>
                              </div>
                            </div>
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
                            <table class="table table-bordered" id="year_table">
                              <thead>
                                  <tr class="bg-primary-50 text-center">
                                      <th>ID</th>
                                      <th>BLOCK</th>
                                      <th>CATEGORY</th>
                                      <th>FLOOR</th>
                                      <th>ROOM NO / NAME</th>
                                      <th>CAPACITY</th>
                                      <th>OPEN / CLOSED</th>
                                      <th>ACTION</th>
                                  </tr>
                                  <tr id="filterRow">
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
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
                            <a class="btn btn-success btn-sm float-right mb-2 mt-2" href="/space/space-setting/room/create">Add Room</a>
                          </div>
                          <div class="modal fade" id="crud-modal" aria-hidden="true" >
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"> Add Room</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                          <tr>
                                            <td>Block <span class="text-danger">*</span></td>
                                            <td><input type="text" class="form-control" name="name"></td>
                                          </tr>
                                          <tr>
                                            <td>Open / Closed <span class="text-danger">*</span></td>
                                            <td>
                                              <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="status" id="store_status">
                                                <label class="custom-control-label" for="store_status"></label>
                                              </div>
                                            </td>
                                          </tr>
                                        </table>
                                        <button class="btn btn-success btn-sm float-right">Submit</button>
                                    </div>
                                </div>
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
  $(document).ready(function() {
      var table = $('#year_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: false,
        ajax: {
            url: window.location.href,
        },

        columns: [
                { data: 'id', name: 'id'},
                { data: 'room_block', name: 'facilityBlock.name'},
                { data: 'room_name', name: 'facilityRoomType.name'},
                { data: 'floor', name: 'floor'},
                { data: 'name', name: 'name'},
                { data: 'capacity', name: 'capacity'},
                { data: 'room_status', name: 'facilityStatus.name'},
                { data: 'action'},
            ],
        order: [[ 0, "asc" ]],
        orderCellsTop: true,
        dom:"tpr",
        initComplete: function () {
          $("#year_table thead #filterRow .hasInputFilter").each( function ( i ) {
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

  });
</script>
@endsection
