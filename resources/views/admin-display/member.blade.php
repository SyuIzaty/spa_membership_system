@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i> MEMBER MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            LIST OF <span class="fw-300"> MEMBER</span>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs nav-fill" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#member" role="tab" aria-selected="true"> Member List</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#nonMember" role="tab">Non-Member List</a></li>
                                    </ul>
                                </div>
                                <div class="col">
                                    <div class="tab-content p-3">
                                        <div class="tab-pane fade active show" id="member" role="tabpanel">
                                            <div class="col-sm-12 mb-4">
                                                <div class="table-responsive">
                                                    <table id="mem" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr class="text-center bg-danger-50" style="white-space: nowrap">
                                                                <th>No</th>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Phone No.</th>
                                                                <th>Current Membership ID</th>
                                                                <th>Current Membership</th>
                                                                <th>Current Membership Duration</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="nonMember" role="tabpanel">
                                            <div class="col-sm-12 mb-4">
                                                <div class="table-responsive">
                                                    <table id="nmem" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr class="text-center bg-danger-50" style="white-space: nowrap">
                                                                <th>No</th>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Phone No.</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
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
            </div>
        </div>
    </main>

@endsection

@section('script')
    <script>
        $(document).ready(function()
        {
            var table = $('#mem').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-member",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                        { className: 'text-center', data: 'user_id', name: 'user_id' },
                        { className: 'text-center', data: 'customer_name', name: 'customer_name' },
                        { className: 'text-center', data: 'customer_email', name: 'customer_email' },
                        { className: 'text-center', data: 'customer_phone', name: 'customer_phone'},
                        { className: 'text-center', data: 'membership_id', name: 'membership_id' },
                        { className: 'text-center', data: 'plan_id', name: 'plan_id' },
                        { className: 'text-center', data: 'membership_duration', name: 'membership_duration', orderable: false, searchable: false },
                        { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    orderCellsTop: true,
                    "order": [[ 0, "desc" ]],
                    "initComplete": function(settings, json) {

                    }
            });
        });

        $(document).ready(function()
        {
            var table = $('#nmem').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-non-member",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                        { className: 'text-center', data: 'user_id', name: 'user_id' },
                        { className: 'text-center', data: 'customer_name', name: 'customer_name' },
                        { className: 'text-center', data: 'customer_email', name: 'customer_email' },
                        { className: 'text-center', data: 'customer_phone', name: 'customer_phone'},
                        { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    orderCellsTop: true,
                    "order": [[ 0, "desc" ]],
                    "initComplete": function(settings, json) {

                    }
            });
        });
    </script>
@endsection
