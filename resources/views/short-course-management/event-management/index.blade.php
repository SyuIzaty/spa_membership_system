@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Event Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Events</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <span id="intake_fail"></span>
                            @csrf
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100 m-0 table-sm" id="event">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>DATE START</th>
                                            <th>DATE END</th>
                                            <th>PARTICIPANT (VALID)</th>
                                            <th>PARTICIPANT (NOT VALID YET)</th>
                                            <th>CREATED DATE</th>
                                            <th>STATUS</th>
                                            <th>DOCUMENT</th>
                                            <th>ACTION</th>
                                        </tr>
                                        {{-- <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td> --}}
                                        {{-- <td class="hasinput"><input type="text" class="form-control" placeholder="Search Dates"></td> --}}
                                        {{-- <td></td>
                                    </tr> --}}
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                style="content-align:right">
                                <a href="/event/create"
                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                        class="ni ni-plus"> </i> Create New Event</a>
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
        function Print(button) {
            var url = $(button).data('page');
            var printWindow = window.open('{{ url('/') }}' + url + '', 'Print',
                'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            }, true);
        }
        $(document).ready(function() {

            $('#event thead tr .hasinput').each(function(i) {
                $('input', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });

                $('select', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });


            var table = $('#event').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/events/data/event-management",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'datetime_start_toDayDateTimeString',
                        name: 'datetime_start_toDayDateTimeString'
                    },

                    {
                        data: 'datetime_end_toDayDateTimeString',
                        name: 'datetime_end_toDayDateTimeString'
                    },
                    {
                        data: 'totalValidParticipants',
                        name: 'totalValidParticipants'
                    },
                    {
                        data: 'totalParticipantsNotApprovedYet',
                        name: 'totalParticipantsNotApprovedYet'
                    },
                    {
                        data: 'created_at_toDayDateTimeString',
                        name: 'created_at_toDayDateTimeString'
                    },
                    {
                        data: 'event_status_category.name',
                        name: 'event_status_category.name'
                    },
                    {
                        data: 'document',
                        name: 'document'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                orderCellsTop: true,
                "order": [
                    [0, "desc"]
                ],

                "columnDefs": [{
                    "targets": 2,
                    "orderable": false
                }, {
                    "targets": 3,
                    "orderable": false
                }, {
                    "targets": 6,
                    "orderable": false
                }, {
                    "targets": 8,
                    "orderable": false
                }],
                "initComplete": function(settings, json) {


                }
            });

        });
    </script>
@endsection
