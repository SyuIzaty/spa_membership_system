@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clock'></i>Declaration History Management
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Self History Declaration <span class="fw-300"><i>List</i></span>
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
                            <table id="history" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th style="width:25px">NO</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q3</th>
                                        <th>Q4(i)</th>
                                        <th>Q4(ii)</th>
                                        <th>Q4(iii)</th>
                                        <th>Q4(iv)</th>
                                        <th>CATEGORY</th>
                                        <th>DATE CREATED</th>
                                        <th>TIME CREATED</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q1"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q2"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q3"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Fever"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Cough"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Flu"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Breathing Difficulty"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Category"></td>
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
        $('#history thead tr .hasinput').each(function(i)
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


        var table = $('#history').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/historySelf",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { className: 'text-center', data: 'q1', name: 'q1' },
                    { className: 'text-center', data: 'q2', name: 'q2' },
                    { className: 'text-center', data: 'q3', name: 'q3' },
                    { className: 'text-center', data: 'q4a', name: 'q4a' },
                    { className: 'text-center', data: 'q4b', name: 'q4b' },
                    { className: 'text-center', data: 'q4c', name: 'q4c' },
                    { className: 'text-center', data: 'q4d', name: 'q4d' },
                    { className: 'text-center', data: 'category', name: 'category' },
                    { className: 'text-center', data: 'date', name: 'created_at' },
                    { className: 'text-center', data: 'time', name: 'created_at' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 9, "desc" ]], 
                "initComplete": function(settings, json) {

                } 
        });

        $('#history').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#history').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>
@endsection

