@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-syringe'></i>Vaccination Data Management
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Vaccination <span class="fw-300"><i>List</i></span>
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
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\Staff::all()->count() }}
                                            <small class="m-0 l-h-n">TOTAL STAFF</small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\Vaccine::where(['q1' => 'Y'])->get()->count() }}
                                            <small class="m-0 l-h-n">REGISTER VACCINE</small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\Vaccine::where(['q3' => 'Y'])->get()->count() }}
                                            <small class="m-0 l-h-n">FIRST DOSE COMPLETE</small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-syringe position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\Vaccine::where(['q4' => 'Y'])->get()->count() }}
                                            <small class="m-0 l-h-n">SECOND DOSE COMPLETE</small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6" style="font-size: 8rem;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="vac" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th style="width:15px">NO</th>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>POSITION</th>
                                        <th>DEPARTMENT</th>
                                        <th>Q1</th>
                                        <th>Q2</th>
                                        <th>Q3</th>
                                        <th>Q4</th>
                                        <th>Q5</th>
                                        <th>Q6</th>
                                        <th>STATUS</th>
                                        <th>CREATED DATE</th>
                                        <th>UPDATED DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Position"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Department"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q1"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q2"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q3"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q4"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q5"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Q6"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Status"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Date Created"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Date Updated"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a class="btn btn-warning ml-auto float-right mr-2" href="/export-vaccine"><i class="fal fa-file-excel"></i> Export</a>
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

        $('#vac thead tr .hasinput').each(function(i)
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

        var table = $('#vac').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/vaccineList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'user_id', name: 'user_id' },
                    { className: 'text-center', data: 'user_name', name: 'user_name' },
                    { className: 'text-center', data: 'user_position', name: 'user_position' },
                    { className: 'text-center', data: 'user_depart', name: 'user_depart' },
                    { className: 'text-center', data: 'q1', name: 'q1' },
                    { className: 'text-center', data: 'q2', name: 'q2' },
                    { className: 'text-center', data: 'q3', name: 'q3' },
                    { className: 'text-center', data: 'q3_effect', name: 'q3_effect' },
                    { className: 'text-center', data: 'q4', name: 'q4' },
                    { className: 'text-center', data: 'q4_effect', name: 'q4_effect' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'created_at', name: 'created_at' },
                    { className: 'text-center', data: 'updated_at', name: 'updated_at' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#vac').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#vac').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>
@endsection

