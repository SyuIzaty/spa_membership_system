@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i>TRAINING HOUR
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        TRAINING HOUR <span class="fw-300"><i>LIST</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('notification'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('notification') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="hour" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50">
                                        <th>NO.</th>
                                        <th>YEAR</th>
                                        <th>HOURS</th>
                                        <th>ASSIGN HOUR</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Year"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Training Hour"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Hour</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>NEW TRAINING HOUR</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'TrainingController@storeHour', 'method' => 'POST']) !!}
                    <p><span class="text-danger">*</span> Required fields</p>

                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="year"><span class="text-danger">*</span> Year :</label></td>
                            <td colspan="4"><input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}" required>
                                @error('year')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>

                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="training_hour"><span class="text-danger">*</span> Hour(s) :</label></td>
                            <td colspan="4"><input type="number" step="any" class="form-control" id="training_hour" name="training_hour" value="{{ old('training_hour') }}" required>
                                @error('training_hour')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                     
                    <div class="footer">
                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modals" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>EDIT TRAINING HOUR</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'TrainingController@updateHour', 'method' => 'POST']) !!}
                    <input type="hidden" name="hour_id" id="training">
                    <p><span class="text-danger">*</span> Required fields</p>
                    
                    <div class="form-group">
                        <td width="15%"><label class="form-label" for="years"><span class="text-danger">*</span> Year :</label></td>
                        <td colspan="5"><input type="number" class="form-control" id="year" name="years" required>
                            @error('years')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>

                    <div class="form-group">
                        <td width="15%"><label class="form-label" for="training_hours"><span class="text-danger">*</span> Hour(s) :</label></td>
                        <td colspan="5"><input type="number" step="any" class="form-control" id="hour" name="training_hours" required>
                            @error('training_hours')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>

                    <div class="footer">
                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                    </div>
                    {!! Form::close() !!}
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
        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) 
            var training = button.data('training') 
            var year = button.data('year') 
            var hour = button.data('hour')

            $('.modal-body #training').val(training); 
            $('.modal-body #year').val(year); 
            $('.modal-body #hour').val(hour); 
        })

        $('#hour thead tr .hasinput').each(function(i)
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

        var table = $('#hour').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-hour",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { className: 'text-center', data: 'year', name: 'year' },
                    { className: 'text-center', data: 'training_hour', name: 'training_hour' },
                    { className: 'text-center', data: 'assign', name: 'assign', orderable: false, searchable: false},
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#hour').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#hour').DataTable().draw(false);
                    });
                }
            })
        });

    });

    $('#hour').on('click', '.btn-assign[data-remote]', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = $(this).data('remote');
         
        Swal.fire({
            title: 'CONFIRM ASSIGNATION ?',
            text: " ASSIGN THIS TRAINING HOUR TO ALL STAFF.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {method: 'POST', submit: true},
                    success: function() {   
                        location.reload();  
                    }
                }).always(function (data) {
                    $('#hour').DataTable().draw(false);
                });
            }
        })
    });


</script>

@endsection
