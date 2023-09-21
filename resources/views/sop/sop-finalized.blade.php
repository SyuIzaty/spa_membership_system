@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon ni ni-briefcase'></i> SOP Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of SOP</h2>
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
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            @if (Auth::user()->hasRole('SOP Admin'))
                                <div class="col-md-6" style="margin-bottom: 10px;">
                                    <label>Department</label>
                                    <select class="selectfilter form-control" name="department" id="department">
                                        <option value="">Select Department</option>
                                        @foreach ($department as $d)
                                            <option value="{{ $d->id }}" <?php if ($selectedDepartment == $d->id) {
                                                echo 'selected';
                                            } ?>>
                                                {{ $d->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="sop" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">SOP Title</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
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
        function Print(button) {
            var url = $(button).data('page');
            var printWindow = window.open('{{ url('/') }}' + url + '', 'Print',
                'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            }, true);
        }

        $(document).ready(function() {
            $('#department').select2();

            var table = $('#sop').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/fetch-sop-list",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        className: 'text-center',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        className: 'text-left',
                        data: 'sop',
                        name: 'sop'
                    },
                    {
                        className: 'text-left',
                        data: 'department',
                        name: 'department'
                    },
                    {
                        className: 'text-center',
                        data: 'action',
                        name: 'action'
                    },
                ],
                orderCellsTop: true,
                "order": [
                    [0, "asc"]
                ],
                "initComplete": function(settings, json) {}
            });

            function createDatatable(department = null) {
                $('#sop').DataTable().destroy();
                var table = $('#sop').DataTable({
                    processing: true,
                    serverSide: true,
                    autowidth: false,
                    deferRender: true,
                    ajax: {
                        url: "/fetch-sop-lists",
                        data: {
                            department: department
                        },
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    iDisplayLength: 10,
                    columns: [{
                            className: 'text-center',
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            className: 'text-left',
                            data: 'sop',
                            name: 'sop'
                        },
                        {
                            className: 'text-left',
                            data: 'department',
                            name: 'department'
                        },
                        {
                            className: 'text-center',
                            data: 'action',
                            name: 'action'
                        },
                    ],
                    orderCellsTop: true,
                    "order": [
                        [1, "asc"]
                    ],
                    "initComplete": function(settings, json) {},
                    "fnDrawCallback": function() {
                        $('.total_record').text(this.fnSettings().fnRecordsTotal());
                    },
                    select: true,
                });
            }

            $('.selectfilter').on('change', function() {
                var department = $('#department').val();
                createDatatable(department);
            });
        });
    </script>
@endsection
