@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-paperclip'></i>Category D Management
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Category D <span class="fw-300"><i>List</i></span>
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
                            <table id="catD" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th style="width:25px">NO</th>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>POSITION</th>
                                        <th>DATE DECLARE</th>
                                        <th>TIME DECLARE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Position"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Date Created"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Time Created"></td>
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
        $('#catD thead tr .hasinput').each(function(i)
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


        var table = $('#catD').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/DList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { className: 'text-center', data: 'user_id', name: 'user_id' },
                    { className: 'text-center', data: 'user_name', name: 'user_name' },
                    { className: 'text-center', data: 'user_position', name: 'user_position' },
                    { className: 'text-center', data: 'date', name: 'declare_date' },
                    { className: 'text-center', data: 'time', name: 'declare_time' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 4, "desc" ], [ 2, "asc"]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#catD').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#catD').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>
@endsection

