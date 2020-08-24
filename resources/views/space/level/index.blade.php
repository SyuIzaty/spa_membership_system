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
        <i class='subheader-icon fal fa-bars'></i>Level<!--span class='fw-300'>ColumnFilter</span> <sup class='badge badge-primary fw-500'>ADDON</sup-->
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
                        Level<span class="fw-300"><i>List</i></span>
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
                        <table id="level" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Campus</th>
                                    <th>Zone</th>
                                    <th>Building</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                    <td class="hasinput">
                                        <select name="campus_id" id="campus_id" class="form-control">
                                             <option value="">All</option>
                                                @foreach ($campus as $campuses) 
                                                    <option value="{{ $campuses->id }}" {{ $campuses->id == $level->campus_id ? 'selected' : '' }}>
                                                        {{ $campuses->name }}
                                                    </option>
                                                @endforeach
                                        </select>
                                    </td>
                                    <td class="hasinput">
                                        <select name="zone_id" id="zone_id" class="form-control">
                                             <option value="">All</option>
                                                @foreach ($zone as $zones) 
                                                    <option value="{{ $zones->id }}" {{ $zones->id == $level->zone_id ? 'selected' : '' }}>
                                                        {{ $zones->name }}
                                                    </option>
                                                @endforeach
                                        </select>
                                    </td>
                                    <td class="hasinput">
                                        <select name="building_id" id="building_id" class="form-control">
                                             <option value="">All</option>
                                                @foreach ($building as $buildings) 
                                                    <option value="{{ $buildings->id }}" {{ $buildings->id == $level->building_id ? 'selected' : '' }}>
                                                        {{ $buildings->name }}
                                                    </option>
                                                @endforeach
                                        </select>
                                    </td>
                                    <td class="hasinput">
                                        {{-- <input type="text" class="form-control" placeholder="Search Status"> --}}
                                        <select id="active" name="active" class="form-control">
                                            <option value="">All</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
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

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">

                        <a href="/space/level/create" class="btn btn-primary ml-auto"><i class="fal fa-search-plus"></i> Add New Level</a>
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
        $('#level thead tr .hasinput').each(function(i)
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

        var table = $('#level').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/level/list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'level_code', name: 'level_code' },
                    { data: 'name', name: 'name' },
                    { data: 'campus_id', name: 'campus_id' },
                    { data: 'zone_id', name: 'zone_id' },
                    { data: 'building_id', name: 'building_id' },
                    { data: 'active', name: 'active' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#level').on('click', '.btn-delete[data-remote]', function (e) { 
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');
            // confirm then
            if (confirm('Are you sure you want to delete this?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    $('#level').DataTable().draw(false);
                });
            }else
                alert("You have cancelled!");
        });

    });

</script>

@endsection
