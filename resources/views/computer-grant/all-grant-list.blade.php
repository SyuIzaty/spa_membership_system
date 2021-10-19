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
                        <h2>List of Grant for Status : {{$data->description}}</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
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
                                            <th class="text-center">Action</th>
                                            <th class="text-center">Activity Log</th>
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
        var id= @json($id);
        console.log(id);
        var table = $('#application').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/alldatalist/" + id,
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
                    { className: 'text-center', data: 'log', name: 'log', orderable: false, searchable: false} 
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#application').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Are you sure you want to verify this application cancellation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Verify!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#application').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>
@endsection
