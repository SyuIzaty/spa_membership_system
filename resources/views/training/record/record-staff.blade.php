@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i> STAFF RECORD MANAGEMENT {{ \Carbon\Carbon::now()->format('Y')}}
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        STAFF RECORD <span class="fw-300"><i>LIST</i></span>
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
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\Staff::whereNotNull('staff_id')->get()->count() }}
                                            <small class="m-0 l-h-n">TOTAL STAFF</small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-users position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-danger-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\TrainingHourTrail::where('year', \Carbon\Carbon::now()->format('Y') )->where('status','5')->whereNotNull('staff_id')->get()->count() }}
                                            <small class="m-0 l-h-n">PENDING/UNCOMPLETE RECORD  <b style="font-weight: 900">{{ \Carbon\Carbon::now()->format('Y') }}</b></small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar-minus position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-4">
                                <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ \App\TrainingHourTrail::where('year', \Carbon\Carbon::now()->format('Y') )->where('status','4')->whereNotNull('staff_id')->get()->count() }}
                                            <small class="m-0 l-h-n">COMPLETE RECORD  <b style="font-weight: 900">{{ \Carbon\Carbon::now()->format('Y') }}</b></small>
                                        </h3>
                                    </div>
                                    <i class="fal fa-calendar-check position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4" style="font-size: 6rem;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="staff" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50">
                                        <th>#ID</th>
                                        <th>NAME</th>
                                        <th>POSITION</th>
                                        <th>DEPARTMENT</th>
                                        <th>ASSIGN HOURS</th>
                                        <th>CURRENT HOURS</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Staff"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Position"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Assign Hours"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Current Hours"></td>
                                        <td class="hasinput">
                                            <select id="data_status" name="data_status" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_status as $status)
                                                    <option value="{{$status->id}}">{{strtoupper($status->status_name)}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a class="btn btn-info ml-auto mr-2 float-right" href="/export-latest-record"><i class="fal fa-file-excel"></i> Export {{ \Carbon\Carbon::now()->format('Y') }}</a>
                        <a class="btn btn-warning float-right" href="/export-record"><i class="fal fa-file-excel"></i> Export All</a>
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
        $('#data_status').select2();

        $('#staff thead tr .hasinput').each(function(i)
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

        var table = $('#staff').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-record-staff",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'staff_id', name: 'staff_id' },
                    { data: 'staff_name', name: 'staff_id' },
                    { data: 'staff_position', name: 'staff_id' },
                    { data: 'staff_dept', name: 'staff_id' },
                    { className: 'text-center', data: 'staff_training_hr', name: 'year' },
                    { className: 'text-center', data: 'staff_current_hr', name: 'staff_id' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#staff').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#staff').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
