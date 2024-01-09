@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-archive'></i>{{ strtoupper($department->department_name) }} MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Custodian List
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card-body">
                            {!! Form::open(['action' => 'Inventory\AssetParameterController@store_department_custodian', 'method' => 'POST']) !!}
                                <input type="hidden" name="id" value="{{ $department->id }}">
                                <table class="table table-bordered">
                                    <tr>
                                        <td width="10%" style="vertical-align: middle">
                                            <label>Staff : </label>
                                        </td>
                                        <td>
                                            <select class="form-control custodian_id" name="custodian_id[]" id="custodian_id" multiple="multiple">
                                                @foreach ($staff as $staffs)
                                                    <option value="{{ $staffs->id }}" {{ old('custodian_id') ? 'selected' : '' }}>{{ $staffs->id }} - {{ $staffs->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                <button type="submit" class="btn btn-success ml-2 float-right"><i class="fal fa-save"></i> Save</button>
                                <a href="/asset-department" class="btn btn-secondary ml-auto float-right"><i class="fal fa-arrow-left"></i> Back</a>
                            {!! Form::close() !!}
                            <br><br>
                            <hr>
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                            @endif
                            <div class="table-responsive">
                                <table id="custodian" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="text-center bg-primary-50">
                                            <th>#ID</th>
                                            <th>STAFF ID</th>
                                            <th>STAFF NAME</th>
                                            <th>ACTION</th>
                                        </tr>
                                        <tr>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Staff ID"></td>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Staff Name"></td>
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
    </div>

</main>
@endsection

@section('script')

<script>
    $(document).ready(function()
    {
        $('#custodian_id').select2();

        $('#custodian thead tr .hasinput').each(function(i)
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

        var id = "<?php echo $department->id; ?>";
        var table = $('#custodian').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-department-custodian/" + id,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'custodian_id', name: 'custodian_id' },
                    { className: 'text-center', data: 'custodian_name', name: 'custodian.name' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#custodian').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#custodian').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
