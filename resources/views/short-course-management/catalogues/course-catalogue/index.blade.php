@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Short Course
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Short Courses</h2>
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
                            @if (Session::has('success'))
                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;">
                                    <i class="icon fal fa-check-circle"></i>
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <span id="intake_fail"></span>
                            @csrf
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped w-100 m-0 table-sm"
                                    id="shortcourse">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th>ID</th>
                                            <th>NAME</th>
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
                                        class="ni ni-plus"> </i> Create New Shortcourse</a>

                                <div class="modal fade" id="crud-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="card-header">
                                                <h5 class="card-title w-150">Add Shortcourse</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('/shortcourse') }}" method="post" name="form">
                                                    @csrf
                                                    <p><span class="text-danger">*</span>
                                                        Required Field</p>
                                                    <hr class="mt-1 mb-2">
                                                    <div class="form-group">
                                                        <label for="user_id"><span class="text-danger">*</span>
                                                            Short Course Name</label>
                                                        {{ Form::text('shortcourse_name', '', ['class' => 'form-control', 'placeholder' => 'Short Course Name', 'id' => 'shortcourse_name']) }}
                                                        @error('shortcourse_name')
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
                                                        <button type="submit" id="submitShortCourse"
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

            $('#shortcourse thead tr .hasinput').each(function(i) {
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


            var table = $('#shortcourse').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/shortcourses/data",
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
                // $('#shortcourse_name').val('Unnamed Shortcourse');
                // $("#submitShortCourse").trigger("click");

                $('#crud-modal').modal('show');
            });
        })
    </script>
@endsection
