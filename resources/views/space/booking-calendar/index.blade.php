@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-calendar'></i> Booking
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Booking Calendar</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                      <div class="panel-content">
                        <div id="calendar"></div>
                        <div class="py-2 mt-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex">
                          <div class="row">
                            <div class="card-body">
                              <table id="info" class="table table-bordered table-hover table-striped" style="width: 200%!important">
                                  <thead>
                                      <tr>
                                          <div class="form-group">
                                              <td style="width: 250px"><i style="color: red"><b>Note</b></i>
                                                  <br><br>
                                                  <label class="low" style="margin-left: 14px !important; background-color: #E0D0F5"><label class="" style="margin-left: 30px;">IITU</label></label>
                                                  <label class="medium" style="margin-left: 70px !important; background-color: #FCE4BA"><label class="" style="margin-left: 30px;">LIBRARY</label></label>
                                                  <label class="high" style="margin-left: 85px !important; background-color: #F8BCBC"><label class="" style="margin-left: 30px; width: 130px">OPERATION</label></label>
                                                  <label class="high" style="margin-left: 85px !important; background-color: #C4DEF2"><label class="" style="margin-left: 30px; width: 130px">CE OFFICE</label></label>
                                              </td>
                                          </div>
                                      </tr>
                                  </thead>
                              </table>
                            </div>
                          </div>
                        </div>

                        <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="bookingModalLabel">Booking Details</h5>
                                  </div>
                                  <div class="modal-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Request By</td>
                                            <td colspan="3"><span id="user_id"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Purpose</td>
                                            <td colspan="3"><span id="purpose"></span></td>
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
                                    </table>
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

    $('#calendar').fullCalendar({
      events: [
          @foreach($booking as $bookings)
              {
                  title: '{{ $bookings->spaceVenue->name }}',
                  start: '{{ $bookings->spaceBookingMain->start_date }}',
                  end: moment('{{ $bookings->spaceBookingMain->end_date }}').add(1, 'day').format('YYYY-MM-DD'),
                  start_time: '{{ $bookings->spaceBookingMain->start_time }}',
                  end_time: '{{ $bookings->spaceBookingMain->end_time }}',
                  color: '{{ isset($bookings->spaceVenue->departmentList->color) ? $bookings->spaceVenue->departmentList->color : '' }}',
                  check_out: '{{ $bookings->spaceBookingMain->end_date }}',
                  spacebookingId: '{{ $bookings->id }}',
                  room_venue: '{{ isset($bookings->spaceVenue->name) ? $bookings->spaceVenue->name : '' }}',
                  user_id: '{{ isset($bookings->spaceBookingMain->user->name) ? $bookings->spaceBookingMain->user->name : '' }}',
                  purpose: '{{ isset($bookings->spaceBookingMain->purpose) ? $bookings->spaceBookingMain->purpose : '' }}',
              },
          @endforeach
      ],
      eventClick: function(calEvent, jsEvent, view) {
          $('#end_date').text(moment(calEvent.check_out).format('YYYY-MM-DD'));
          $('#start_date').text(calEvent.start.format('YYYY-MM-DD'));
          $('#start_time').text(moment(calEvent.start_time, 'HH:mm:ss').format('HH:mm:ss'));
          $('#end_time').text(moment(calEvent.end_time, 'HH:mm:ss').format('HH:mm:ss'));
          $('#room_venue').text(calEvent.room_venue);
          $('#user_id').text(calEvent.user_id);
          $('#purpose').text(calEvent.purpose);

          $('#bookingModal').modal('show');
          $("#bookingModal").prependTo("body");
      }
    });
      
  });

</script>
@endsection
