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
                        <h2>Manage Booking</h2>
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
                            <div class="row">
                                <div class="col-sm-6 col-xl-4">
                                    <div class="p-3 bg-warning-300 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $total->where('application_status',5)->count() }}
                                                <small class="m-0 l-h-n">TOTAL PENDING <b style="font-weight: 900">{{ Carbon\Carbon::now()->year }}</b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-alt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $total->where('application_status',3)->count() }}
                                                <small class="m-0 l-h-n">TOTAL APPROVE <b style="font-weight: 900">{{ Carbon\Carbon::now()->year }}</b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xl-4">
                                    <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $total->where('application_status',4)->count() }}
                                                <small class="m-0 l-h-n">TOTAL REJECTED  <b style="font-weight: 900">{{ Carbon\Carbon::now()->year }}</b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                    </div>
                                </div>
                            </div>
                          <ul class="nav nav-tabs nav-fill" role="tablist">
                              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#calendar_view" role="tab" aria-selected="true">Calendar View</a></li>
                              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#list_view" role="tab">List View</a></li>
                              </li>
                          </ul>
                        </div>
                        <div class="tab-content p-3">
                            <div class="tab-pane fade active show" id="calendar_view" role="tabpanel">
                              <div id="calendar"></div>
                              <div class="py-2 mt-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex">
                                <div class="row">
                                  <div class="card-body">
                                    <table id="info" class="table table-bordered table-hover table-striped" style="width: 160%!important">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <td style="width: 250px"><i style="color: red"><b>Note</b></i>
                                                        <br><br>
                                                        <label class="low" style="margin-left: 14px !important"><label class="" style="margin-left: 30px;">Approved</label></label>
                                                        <label class="medium" style="margin-left: 85px !important"><label class="" style="margin-left: 30px;">Pending</label></label>
                                                        <label class="high" style="margin-left: 85px !important"><label class="" style="margin-left: 30px; width: 130px">Rejected</label></label>
                                                    </td>
                                                </div>
                                            </tr>
                                        </thead>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="tab-pane fade" id="list_view" role="tabpanel">
                              <table class="table table-bordered" id="year_table" style="width:100%">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>PURPOSE</th>
                                        <th>START DATE</th>
                                        <th>END DATE</th>
                                        <th>VENUE</th>
                                        <th>STATUS</th>
                                        <th>APPLICATION</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr id="filterRow">
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Purpose"></td>
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Start Date"></td>
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search End Date"></td>
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Venue"></td>
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Status"></td>
                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Application"></td>
                                      <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                            <a href="/space/booking-management/create" class="btn btn-success float-right mb-3">New Application</a>
                        </div>

                        <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
                                  </div>
                                  <div class="modal-body">
                                    {!! Form::open(['action' => ['Space\BookingManagementController@update',1], 'method' => 'PATCH']) !!}
                                    <input type="hidden" name="booking_id" id="booking_id">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Purpose</td>
                                            <td colspan="3"><span id="purpose"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Number of User</td>
                                            <td colspan="3"><span id="no_user"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Request by</td>
                                            <td colspan="3"><span id="user"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Start Date</td>
                                            <td><span id="start_date"></span></td>
                                            <td>End Date</td>
                                            <td><span id="end_date"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Start Time</td>
                                            <td><span id="start_time"></span></td>
                                            <td>End Time</td>
                                            <td><span id="end_time"></span></td>
                                        </tr>
                                        <tr>
                                          <td>Room / Venue</td>
                                          <td colspan="3"><span id="room_venue"></span></td>
                                        </tr>
                                        <tr>
                                          <td>Requirement</td>
                                          <td colspan="3"><span id="requirement"></span></td>
                                        </tr>
                                        <tr>
                                          <td>Remark</td>
                                          <td colspan="3"><span id="remark"></span></td>
                                        </tr>
                                        <tr>
                                          <td>Application Date</td>
                                          <td colspan="3"><span id="created_at"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Application Status</td>
                                            <td colspan="3">
                                              <select class="form-control" name="application_status" id="application_status">
                                                @foreach($status as $statuses)
                                                <option value="{{ $statuses->id }}">{{ $statuses->name }}</option>
                                                @endforeach
                                              </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <button class="btn btn-success btn-sm float-right">Update</button>
                                    {!! Form::close() !!}
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

<script>
  $(document).ready(function() {

    $('#year_table thead tr .hasinput').each(function(i)
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

    var table = $('#year_table').DataTable({
      processing: true,
      serverSide: true,
      stateSave: false,
      ajax: {
          url: window.location.href,
      },

      columns: [
              { data: 'id', name: 'id'},
              { data: 'user_names', name: 'spaceBookingMain.user.name'},
              { data: 'purposes', name: 'spaceBookingMain.purpose'},
              { data: 'start_dates', name: 'spaceBookingMain.start_date'},
              { data: 'end_dates', name: 'spaceBookingMain.end_date'},
              { data: 'venues', name: 'spaceVenue.name'},
              {
                data: 'status_name',
                name: 'spaceStatus.name',
                render: function (data) {
                    badge = 'info';
                    if (data == 'Rejected') {
                        badge = 'danger';
                    } else if(data == 'Pending') {
                        badge = 'warning';
                    } else if(data == 'Approve') {
                        badge = 'success';
                    }
                    return '<span class="badge badge-' + badge + '">' + data + '</span>';
                }
              },
              { data: 'created_at', name: 'created_at'},
              { data: 'action'},
          ],
      order: [[ 0, "asc" ]],
      orderCellsTop: true,
      dom:"tpr",
      initComplete: function () {
      }
    });

    $('#calendar').fullCalendar({
      events: [
          @foreach($booking as $bookings)
              {
                  title: '{{ $bookings->spaceVenue->name }}',
                  start: '{{ $bookings->spaceBookingMain->start_date }}',
                  end: moment('{{ $bookings->spaceBookingMain->end_date }}').add(1, 'day').format('YYYY-MM-DD'),
                  purpose: '{{ $bookings->spaceBookingMain->purpose }}',
                  no_user: '{{ $bookings->spaceBookingMain->no_user }}',
                  start_time: '{{ $bookings->spaceBookingMain->start_time }}',
                  end_time: '{{ $bookings->spaceBookingMain->end_time }}',
                  color: '{{ isset($bookings->spaceStatus->color) ? $bookings->spaceStatus->color : '' }}',
                  check_out: '{{ $bookings->spaceBookingMain->end_date }}',
                  spacebookingId: '{{ $bookings->id }}',
                  bookingDetails: '{{ $bookings->spaceBookingMain->purpose }}',
                  buyer: '{{ isset($bookings->spaceBookingMain->user->name) ? $bookings->spaceBookingMain->user->name : '' }}',
                  application_status: '{{ isset($bookings->application_status) ? $bookings->application_status : '' }}',
                  room_venue: '{{ isset($bookings->spaceVenue->name) ? $bookings->spaceVenue->name : '' }}',
                  remark: '{{ isset($bookings->spaceBookingMain->remark) ? $bookings->spaceBookingMain->remark : '' }}',
                  requirement: '<ul>@foreach($bookings->spaceBookingItems as $item)<li>{{ $item->spaceItem->name }}</li>@endforeach</ul>',
                  created_at: '{{ $bookings->created_at }}',
              },
          @endforeach
      ],
      eventClick: function(calEvent, jsEvent, view) {
          $('#booking_id').val(calEvent.spacebookingId);
          $('#purpose').text(calEvent.purpose);
          $('#no_user').text(calEvent.no_user);
          $('#end_date').text(moment(calEvent.check_out).format('YYYY-MM-DD'));
          $('#start_date').text(calEvent.start.format('YYYY-MM-DD'));
          $('#start_time').text(moment(calEvent.start_time, 'HH:mm:ss').format('HH:mm:ss'));
          $('#end_time').text(moment(calEvent.end_time, 'HH:mm:ss').format('HH:mm:ss'));
          $('#user').text(calEvent.buyer);
          $('#application_status').val(calEvent.application_status);
          $('#room_venue').text(calEvent.room_venue);
          $('#remark').text(calEvent.remark);
          $('#requirement').html(calEvent.requirement);
          $('#created_at').html(calEvent.created_at);

          $('#bookingModal').modal('show');
          $("#bookingModal").prependTo("body");
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
