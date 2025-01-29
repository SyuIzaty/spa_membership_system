@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-calendar'></i> BOOKING MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>LIST OF <span class="fw-300"> BOOKING</span></h2>
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
                                <div class="col-sm-12 col-xl-3">
                                    <div class="p-3 bg-danger-300 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $booking->count() }}
                                                <small class="m-0 l-h-n">TOTAL BOOKING <b style="font-weight: 900"></b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-alt position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-3">
                                    <div class="p-3 bg-success-400 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $booking->where('booking_status',1)->count() }}
                                                <small class="m-0 l-h-n">TOTAL BOOKED <b style="font-weight: 900"></b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-3">
                                    <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $booking->where('booking_status',2)->count() }}
                                                <small class="m-0 l-h-n">TOTAL COMPLETED  <b style="font-weight: 900"></b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-3">
                                    <div class="p-3 bg-info-400 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $booking->where('booking_status',3)->count() }}
                                                <small class="m-0 l-h-n">TOTAL CANCELLED  <b style="font-weight: 900"></b></small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                    </div>
                                </div>
                            </div>
                          <ul class="nav nav-tabs nav-fill" role="tablist">
                              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#calendar_view" role="tab" aria-selected="true">Calendar View</a></li>
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
                                                            <td style="width: 300px"><i style="color: red"><b> References :</b></i>
                                                                <br><br>
                                                                <label class="low" style="margin-left: 14px !important; background-color:#FED8B1"><label class="" style="margin-left: 30px;">Booked</label></label>
                                                                <label class="low" style="margin-left: 85px !important; background-color:#FF7F7F"><label class="" style="margin-left: 30px;">Cancelled</label></label>
                                                                <label class="low" style="margin-left: 85px !important; background-color:#90EE90"><label class="" style="margin-left: 30px; width: 130px">Completed</label></label>
                                                                <label class="low" style="margin-left: 85px !important; background-color:#ADD8E6"><label class="" style="margin-left: 30px; width: 130px">Refunded</label></label>
                                                            </td>
                                                        </div>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                 </div>
                            </div>
                        </div>

                        <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title w-100" id="bookingModalLabel"><i class="fal fa-info-circle width-2 fs-xl"></i> BOOKING DETAILS</h5>
                                </div>
                                  <div class="modal-body">
                                    {!! Form::open(['action' => ['BookingController@update',1], 'method' => 'PATCH']) !!}
                                    <input type="hidden" name="booking_id" id="booking_id">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Booking Date :</th>
                                            <td colspan="3"><span id="booking_date"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Time :</th>
                                            <td colspan="3"><span id="booking_time"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Customer Name :</th>
                                            <td colspan="3"><span id="customer_name"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Customer Email :</th>
                                            <td colspan="3"><span id="customer_email"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Customer Phone No. :</th>
                                            <td colspan="3"><span id="customer_phone"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Duration (Minutes) :</th>
                                            <td colspan="3"><span id="booking_duration"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Payment (RM) :</th>
                                            <td colspan="3"><span id="booking_payment"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Payment Status :</th>
                                            <td colspan="3"><span id="booking_payment_status"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Services :</th>
                                            <td colspan="3"><span id="booking_service"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Specialist Name :</th>
                                            <td colspan="3">
                                                <select class="form-control" name="staff_id" id="staff_id">
                                                    @foreach($staffs as $staff)
                                                        <option value="{{ $staff->user_id }}">{{ $staff->staff_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Booking Status :</th>
                                            <td colspan="3">
                                                <select class="form-control" name="booking_status" id="booking_status">
                                                    @foreach($statuses as $status)
                                                        <option value="{{ $status->id }}">{{ $status->status_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Application Date :</th>
                                            <td colspan="3"><span id="created_at"></span></td>
                                        </tr>
                                    </table>
                                    <div class="footer">
                                        <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                        <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
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

    $('#calendar').fullCalendar({
      events: [
          @foreach($booking as $bookings)
              {
                  title: 'BookingID:{{ $bookings->customer_id }} - {{ $bookings->customer->customer_name }}', //fixed
                  color: '{{ isset($bookings->bookingStatus->color) ? $bookings->bookingStatus->color : '' }}', //fixed
                  start: moment('{{ $bookings->booking_date }}').add(1, 'day').format('YYYY-MM-DD'), //fixed
                  customer_id:'{{ $bookings->customer_id }}',
                  customer_name:'{{ $bookings->customer->customer_name }}',
                  customer_email:'{{ $bookings->customer->customer_email }}',
                  customer_phone:'{{ $bookings->customer->customer_phone }}',
                  booking_id:'{{ $bookings->id }}',
                  booking_time: '{{ $bookings->booking_time }}',
                  booking_duration:'{{ $bookings->booking_duration }}',
                  booking_status:'{{ $bookings->booking_status }}',
                  booking_payment:'{{ $bookings->booking_payment }}',
                  booking_payment_status:'{{ $bookings->booking_payment_status }}',
                  staff_id:'{{ $bookings->staff_id }}',
                  staff_name:'{{ $bookings->staff->staff_name }}',
                  booking_service:'<ul>@foreach($bookings->bookingServices as $item)<li>{{ $item->service->service_name }}</li>@endforeach</ul>',
                  created_at:moment('{{ $bookings->created_at }}').add(1, 'day').format('YYYY-MM-DD'),
              },
          @endforeach
      ],

      eventClick: function(calEvent, jsEvent, view) {
        $('#booking_id').val(calEvent.booking_id);
        $('#customer_name').text(calEvent.customer_name);
        $('#customer_email').text(calEvent.customer_email);
        $('#customer_phone').text(calEvent.customer_phone);
        $('#booking_date').text(moment(calEvent.booking_date).format('DD/MM/YYYY'));
        $('#booking_time').text(moment(calEvent.booking_time, 'HH:mm:A').format('HH:mm:A'));
        $('#booking_duration').text(calEvent.booking_duration);
        $('#booking_payment').text(calEvent.booking_payment);
        $('#booking_payment_status').text(calEvent.booking_payment_status);
        $('#created_at').text(moment(calEvent.created_at).format('DD/MM/YYYY'));
        $('#booking_service').html(calEvent.booking_service);
        $('#staff_id').val(calEvent.staff_id);
        $('#booking_status').val(calEvent.booking_status);

        $('#bookingModal').modal('show');
        $("#bookingModal").prependTo("body");
      }
    });

  });

</script>

@endsection
