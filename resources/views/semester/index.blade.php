@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    {{-- <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
        <li class="breadcrumb-item">Datatables</li>
        <li class="breadcrumb-item active">ColumnFilter</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol> --}}
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-table'></i>Semester<!--span class='fw-300'>ColumnFilter</span> <sup class='badge badge-primary fw-500'>ADDON</sup-->
            <!--small>
                Create headache free searching, sorting and pagination tables without any complex configuration
            </small-->
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Semester <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!--div class="panel-tag">
                            This example demonstrates FixedHeader being used with individual column filters, placed into a second row of the table's header (using <code>$().clone()</code>).
                        </div-->
                        <!-- datatable start -->


                        <table id="semester" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-highlight">
                                <tr>
                                    <th>Semester Code</th>
                                    <th>Semester Name</th>
                                    <th>Description</th>
                                    <th>Program</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Course Registration</th>
                                    <th>Action</th>
                                </tr>

                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Semester Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Semester Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Description"></td>
                                    <td class="hasinput">
                                        <select id="program" name="program" class="form-control">
                                            <option value="">Search Program</option>
                                            <option value="0">IAT11</option>

                                        </select>
                                    </td>
                                    <td class="hasinput">
                                        <select id="type" name="type" class="form-control">
                                            <option value="">Search Type</option>
                                            <option value="FS">Full Semester</option>
                                            <option value="SS">Short Semester</option>
                                            <option value="DS">Deferred Semester</option>
                                            <option value="RS">Repeat Semester</option>
                                        </select>
                                    </td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Start Date"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search End Date"></td>
                                    <td class="hasinput">
                                        <select id="status" name="status" class="form-control">
                                            <option value="">All</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="hasinput">
                                        <select id="registrationstatus" name="registrationstatus" class="form-control">
                                            <option value="">All</option>
                                            <option value="1">Open</option>
                                            <option value="0">Closed</option>
                                        </select>
                                    </td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                        <!-- datatable end -->
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

        $('#semester thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });

            $('select', this).on('keyup change', function()
            {
                if (table.column(i).search() !== this.value)
                {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });


        var table = $('#semester').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/semester_list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'code', name: 'code' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'program_id', name: 'program_id' },
                    { data: 'type', name: 'type' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date'},
                    { data: 'status', name: 'status'},
                    { data: 'course_registration', name: 'course_registration'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

    });

</script>


@endsection
