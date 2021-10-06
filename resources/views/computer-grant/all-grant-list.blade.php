@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-laptop'></i> Computer Grant Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of Grant</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table id="application" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">Ticket No.</th>
                                            <th class="text-center">Staff ID.</th>
                                            <th class="text-center">Staff Department/Position</th>
                                            <th class="text-center">Grant Status</th>
                                            <th class="text-center">Total Price</th>
                                            <th class="text-center">Grant Amount/Period</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Brand/Model/Serial No.</th>
                                            <th class="text-center">Expiry Date</th>
                                            <th class="text-center">Remaining Grant Period</th>
                                            <th class="text-center">Balance Penalty</th>
                                            <th class="text-center">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                        </tr>
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
    $(document).ready(function()
    {
        var table = $('#application').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/alldatalist",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'ticket_no', name: 'ticket_no' },
                    { className: 'text-center', data: 'staff_id', name: 'staff_id' },
                    { className: 'text-center', data: 'details', name: 'details' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'price', name: 'price' },
                    { className: 'text-center', data: 'amount', name: 'amount' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'purchase', name: 'purchase' },
                    { className: 'text-center', data: 'expiryDate', name: 'expiryDate' },
                    { className: 'text-center', data: 'remainingPeriod', name: 'remainingPeriod' },
                    { className: 'text-center', data: 'penalty', name: 'penalty' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

</script>
@endsection
