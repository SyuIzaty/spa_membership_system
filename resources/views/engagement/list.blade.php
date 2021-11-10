@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-users'></i> Engagement Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table id="log" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Organization</th>
                                            <th class="text-center">Contact Number</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Designation</th>
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
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($id == "active")
                            @role('Engagement (Admin)')
                                <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                                    <a href= "/create" class="btn btn-danger waves-effect waves-themed float-right" style="margin-right: 7px; margin-bottom: 10px;"><i class="fal fa-plus-square"></i> Add New Engagement</a>
                                </div>
                            @endrole
                        @endif
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

        var table = $('#log').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/all-list/" + id,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                    { className: 'text-left', data: 'title', name: 'title' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-left', data: 'organization', name: 'organization' },
                    { className: 'text-left', data: 'phone', name: 'phone' },
                    { className: 'text-left', data: 'email', name: 'email' },
                    { className: 'text-left', data: 'designation', name: 'designation' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

</script>
@endsection
