@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-car'></i> e-Kenderaan
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Driver Calendar</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div id="calendar"></div>
                            <div class="modal fade" id="eKenderaan" tabindex="-1" role="dialog"
                                aria-labelledby="eKenderaanLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="eKenderaanLabel">Details</h5>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>Depart Date</td>
                                                    <td><span id="depart_date"></span></td>
                                                    <td>Return Date</td>
                                                    <td><span id="return_date"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Depart Time</td>
                                                    <td><span id="depart_time"></span></td>
                                                    <td>Return Time</td>
                                                    <td><span id="return_time"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Purpose</td>
                                                    <td colspan="3">
                                                        <textarea class="form-control" id="purpose" rows="2" readonly></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Destination</td>
                                                    <td colspan="3">
                                                        <textarea class="form-control" id="destination" rows="2" readonly></textarea>
                                                    </td>
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
                    @foreach ($driver as $d)
                        {
                            title: '{{ $d->driverList->name }}',
                            start: '{{ $d->details->depart_date }}',
                            end: moment('{{ $d->details->return_date }}').add(1, 'day').format(
                                'YYYY-MM-DD'),
                            depart_time: '{{ $d->details->depart_time }}',
                            return_time: '{{ $d->details->return_time }}',
                            color: '{{ isset($d->driverList->color) ? $d->driverList->color : '' }}',
                            return_date: '{{ $d->details->return_date }}',
                            purpose: {!! json_encode($d->details->purpose, JSON_UNESCAPED_UNICODE) !!},
                            destination: {!! json_encode($d->details->destination, JSON_UNESCAPED_UNICODE) !!},
                            eKenderaanId: '{{ $d->ekn_details_id }}',
                        },
                    @endforeach
                ],
                eventRender: function(event, element) {
                    if (event.start && event.end) {
                        $(element).css('cursor', 'pointer');
                    }
                },
                eventClick: function(calEvent, jsEvent, view) {
                    $('#return_date').text(moment(calEvent.return_date).format('DD-MM-YYYY'));
                    $('#depart_date').text(calEvent.start.format('DD-MM-YYYY'));
                    $('#depart_time').text(moment(calEvent.depart_time, 'HH:mm:ss').format(
                        'h:mm:ss A'));
                    $('#return_time').text(moment(calEvent.return_time, 'HH:mm:ss').format(
                        'h:mm:ss A'));
                    $('#purpose').text(calEvent.purpose);
                    $('#destination').text(calEvent.destination);

                    $('#eKenderaan').modal('show');
                    $("#eKenderaan").prependTo("body");
                }
            });
        });
    </script>
@endsection
