@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Report
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Booking Report</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                          <div class="row">
                            <div class="col-md-3">
                              <label>From</label>
                              <input type="date" class="selectfilter form-control" name="from" id="from">
                            </div>
                            <div class="col-md-3">
                                <label>To</label>
                                <input type="date" class="selectfilter form-control" name="to" id="to">
                            </div>
                            <div class="col-md-3">
                                <label>Venue</label>
                                <select class="selectfilter form-control" name="venue" id="venue">
                                    <option value="">Select Option</option>
                                    @foreach($venue as $venues)
                                    <option value="{{$venues->id}}" <?php if($request->venue == $venues->id) echo "selected"; ?> >{{$venues->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select class="selectfilter form-control" name="status" id="status">
                                    <option value="">Select Option</option>
                                    @foreach($status as $statuses)
                                    <option value="{{$statuses->id}}" <?php if($request->status == $statuses->id) echo "selected"; ?> >{{$statuses->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                              <div class="table-responsive">

                                <table class="table table-bordered mt-3" id="all">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>CATEGORY</th>
                                            <th>PURPOSE</th>
                                            <th>NUMBER OF USER</th>
                                            <th>VENUE</th>
                                            <th>START DATE</th>
                                            <th>END DATE</th>
                                            <th>START TIME</th>
                                            <th>END TIME</th>
                                            <th>STATUS</th>
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
            </div>
        </div>
    </main>
@endsection
@section('script')
<style>
    .buttons-csv{
        color: white;
        background-color: #606FAD;
        float: right;
    }
</style>
<script>
    $(document).ready(function()
    {
        $('#venue, #status').select2();

        function createDatatable(venue = null, status = null, from = null, to = null)
        {
            $('#all').DataTable().destroy();
            var table = $('#all').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_exportbooking",
                data: {venue:venue, status:status, from:from, to:to},
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            "dom" : "Bltp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 200, "All"]],
            iDisplayLength: 10,
            columns: [
                    { data: 'user_id', name: 'spaceBookingMain.staff_id' },
                    { data: 'user_name', name: 'user_name' },
                    { data: 'user_category', name: 'user_category' },
                    { data: 'user_purpose', name: 'spaceBookingMain.purpose' },
                    { data: 'user_no', name: 'spaceBookingMain.no_user' },
                    { data: 'venue', name: 'spaceVenue.name' },
                    { data: 'user_start', name: 'spaceBookingMain.start_date' },
                    { data: 'user_end', name: 'spaceBookingMain.end_date' },
                    { data: 'time_start', name: 'spaceBookingMain.start_time' },
                    { data: 'time_end', name: 'spaceBookingMain.end_time' },
                    { data: 'status', name: 'spaceStatus.name' },
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                },
                dom: 'Bfrtip',
                buttons: [
                    'csv'
                ]
            });
        }

        $('.selectfilter').on('change',function(){
            var venue = $('#venue').val();
            var status = $('#status').val();
            var from = $('#from').val();
            var to = $('#to').val();
            createDatatable(venue,status,from,to);
        });

    });
</script>
@endsection
