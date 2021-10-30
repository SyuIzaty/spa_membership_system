@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-users'></i>MONITORING LISTS
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        List <span class="fw-300"><i>of Monitoring Borrower</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="monitor" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                        <th>#ID</th>
                                        <th>BORROWER</th>
                                        <th>ASSET TYPE</th>
                                        <th>ASSET CODE</th>
                                        <th>ASSET NAME</th>
                                        <th>BORROW DATE</th>
                                        <th>RETURN DATE</th>
                                        <th>DELAY</th>
                                        <th style="width: 150px">STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Borrower"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Type"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Borrow Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Return Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Delay"></td>
                                        <td class="hasinput">
                                            <select id="status" name="status" class="form-control">
                                                <option value="">ALL</option>
                                                <option value="1">CHECK-OUT</option>
                                                <option value="2">RETURNED</option>
                                            </select>
                                        </td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
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
    $(document).ready(function()
    {
        $('#status').select2();

        $('#monitor thead tr .hasinput').each(function(i)
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

        var table = $('#monitor').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/monitorList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'borrower_id', name: 'borrower_id' },
                    { className: 'text-center', data: 'asset_type', name: 'asset_type' },
                    { className: 'text-center', data: 'asset_code', name: 'asset_code' },
                    { className: 'text-center', data: 'asset_name', name: 'asset_name' },
                    { className: 'text-center', data: 'borrow_date', name: 'borrow_date' },
                    { className: 'text-center', data: 'return_date', name: 'return_date' },
                    { className: 'text-center', data: 'created_at', name: 'created_at' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 7, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

    });

</script>

@endsection
