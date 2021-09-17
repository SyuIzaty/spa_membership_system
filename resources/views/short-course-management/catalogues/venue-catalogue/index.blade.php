@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Venue
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Venues</h2>
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
                            <span id="intake_fail"></span>
                            @csrf
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100 m-0 table-sm" id="venue">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>NAME</th>
                                            <th>DATES</th>
                                            <th>EVENTS</th>
                                            <th>MANAGE. DETAILS</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right"
                                style="content-align:right">
                                <a href="javascript:;" id="create"
                                    class="btn btn-primary ml-auto mt-2 mr-2 waves-effect waves-themed"><i
                                        class="ni ni-plus"> </i> Create New Venue</a>

                                <div class="modal fade" id="crud-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="card-header">
                                                <h5 class="card-title w-150">Add Venue</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('/venue') }}" method="post" name="form">
                                                    @csrf
                                                    <p><span class="text-danger">*</span>
                                                        Required Field</p>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="form-group">
                                                        <label for="user_id"><span class="text-danger">*</span>
                                                            Venue Name</label>
                                                        {{ Form::text('venue_name', '', ['class' => 'form-control', 'placeholder' => 'Venue Name', 'id' => 'venue_name']) }}
                                                        @error('venue_name')
                                                            <p style="color: red">{{ $message }}
                                                            </p>
                                                        @enderror
                                                    </div>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="footer" id="add_contact_person_footer">
                                                        <button type="button"
                                                            class="btn btn-danger ml-auto float-right mr-2"
                                                            data-dismiss="modal" id="close-add-contact_person"><i
                                                                class="fal fa-window-close"></i>
                                                            Close</button>
                                                        <button type="submit" id="submitVenue"
                                                            class="btn btn-primary ml-auto float-right mr-2"><i
                                                                class="ni ni-plus"></i>
                                                            Add</button>
                                                    </div>
                                                </form>
                                            </div>
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
    <script>
        $(document).ready(function() {

            $('#venue thead tr .hasinput').each(function(i) {
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


            var table = $('#venue').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/venues/data",
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
                        data: 'dates',
                        name: 'dates'
                    },
                    {
                        data: 'events',
                        name: 'events'
                    },
                    {
                        data: 'management_details',
                        name: 'management_details'
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

            $('#create').click(function() {
                $('#venue_name').val('Unnamed Venue');

                $("#submitVenue").trigger("click");
            });
        });
    </script>
@endsection
