@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-paperclip'></i>ICT EQUIPMENT RENTAL
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Equipment Rental <span class="fw-300"><i>List</i></span>
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
                            <table id="rental" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                        <th style="width:25px">id</th>
                                        <th>Staff id:</th>
                                        <th>No. Phone:</th>
                                        <th>Rent Date:</th>
                                        <th>Return Date:</th>
                                        <th>Purpose:</th>
                                        <th>Action: </th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Staff ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="No. phone"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Rent Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Return Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Purpose"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Action"></td>

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

        $('#rental thead tr .hasinput').each(function(i)
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


        var table = $('#rental').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_rental", //update into '/data_rental'
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'sid', name: 'id' },
                    { className: 'text-center', data: 'staff', name: 'staff_id' }, //call the data from equipmentStaff table(declare in TestController@data_rental)
                    { className: 'text-center', data: 'phone', name: 'hp_no' },
                    { className: 'text-center', data: 'renDate', name: 'rent_date' },
                    { className: 'text-center', data: 'retDate', name: 'return_date' },
                    { className: 'text-center', data: 'pur', name: 'purpose' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 5, "desc" ], [ 2, "asc"]],
                "initComplete": function(settings, json) {

                }
        });

        $('#rental').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#rental').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>
@endsection