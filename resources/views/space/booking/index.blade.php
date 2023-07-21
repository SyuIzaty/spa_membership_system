@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Booking
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of Booking</h2>
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
                        </div>
                        <div class="col-md-12">
                          <table class="table table-bordered" id="year_table" style="width:100%">
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                    <th>ID</th>
                                    <th>PURPOSE</th>
                                    <th>START DATE</th>
                                    <th>END DATE</th>
                                    <th>VENUE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                                <tr id="filterRow">
                                  <th class="hasInputFilter"></th>
                                  <th class="hasInputFilter"></th>
                                  <th class="hasInputFilter"></th>
                                  <th class="hasInputFilter"></th>
                                  <th class="hasInputFilter"></th>
                                  <th class="hasInputFilter"></th>
                                  <th><button id="resetFilter" class="btn btn-block btn-outline-danger"><i class="bx bx-block font-size-16 align-middle me-2"></i>Clear All Filter</button></th>
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
              { data: 'purposes', name: 'spaceBookingMain.purpose'},
              { data: 'start_dates', name: 'spaceBookingMain.start_date'},
              { data: 'end_dates', name: 'spaceBookingMain.end_date'},
              { data: 'venues', name: 'spaceVenue.name'},
              { data: 'statuses', name: 'spaceStatus.name'},
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
      
  });

  $('#year_table').on('click', '.btn-delete[data-remote]', function (e) {
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
                $('#year_table').DataTable().draw(false);
            });
        }
    })
  });
</script>
@endsection
