@extends('layouts.shortcourse_portal')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        Name
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->name }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        IC
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->ic }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        Phone
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->phone }}
                                    </div>
                                </div>
                                <hr class="mt-1 mb-1">
                                <div class="row">
                                    <div class="col col-2 bg-primary text-white">
                                        Email
                                    </div>
                                    <div class="col col-10">
                                        {{ $participant->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
                <div class="card my-2">
                    <div class="card-body">

                        @if (Session::has('successPaymentProofUpdate'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;">
                                <i class="icon fal fa-check-circle"></i>
                                {{ Session::get('successPaymentProofUpdate') }}
                            </div>
                        @endif
                        @if (Session::has('failedPaymentProofUpdate'))
                            <div class="alert alert-danger" style="color: #5b0303; background-color: #ff6c6cc9;">
                                <i class="icon fal fa-times-circle"></i>
                                {{ Session::get('failedPaymentProofUpdate') }}
                            </div>
                        @endif
                        <div class="panel-container show">
                            <div class="panel-content">
                                <span id="intake_fail"></span>
                                @csrf
                                @if (session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session()->get('success') }}
                                    </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100 m-0 table-sm"
                                        id="event">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th>ID</th>
                                                <th style="width:30%">NAME</th>
                                                <th style="width:30%">FROM</th>
                                                <th style="width:30%">TO</th>
                                                <th style="width:25%">AMOUNTS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                    style="content-align:right">
                                </div>
                                <x-ShortCourseManagement.UpdatePaymentProof />
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

            var participant_id = '<?php echo $participant->id; ?>';

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
                    url: "/events/data/event-management/shortcourse/event-participant/" + participant_id,
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
                        name: 'datetime_start_toDayDateTimeString',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'datetime_end_toDayDateTimeString',
                        name: 'datetime_end_toDayDateTimeString',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fee_amount',
                        name: 'fee_amount',
                        orderable: false,
                        searchable: false
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

                "initComplete": function(settings, json) {


                }
            });
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
    </script>
@endsection
