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
        <i class='subheader-icon fal fa-user-plus'></i>Room Owner<!--span class='fw-300'>ColumnFilter</span> <sup class='badge badge-primary fw-500'>ADDON</sup-->
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
                        Room Owner <span class="fw-300"><i>List</i></span>
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


                        <table id="roomowner" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Phone Number"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Email"></td>
                                    <td class="hasinput">
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

                        {{-- <span class="badge badge-pill rounded-circle badge-secondary fw-400 ml-auto mr-2">
                            1
                        </span> --}}
                        <a href="/space/roomowner/create" class="btn btn-primary ml-auto"><i class="fal fa-search-plus"></i> Add New Room Owner</a>

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

        $('#roomowner thead tr .hasinput').each(function(i)
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


        var table = $('#roomowner').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/roomowner/list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: "image", "render": function(data, type, full, meta) {return '<img src=/storage/space/'+data+' style="height:100px;width:100px;"/>';}},
                    { data: 'name', name: 'name' },
                    { data: 'phone_number', name: 'phone_number' },
                    { data: 'email', name: 'email' },
                    { data: 'active', name: 'active'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#roomowner').on('click', '.btn-delete[data-remote]', function (e) { 
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
                    $('#roomowner').DataTable().draw(false);
                });
            }else
                alert("You have cancelled!");
        });

    });

</script>

@endsection
