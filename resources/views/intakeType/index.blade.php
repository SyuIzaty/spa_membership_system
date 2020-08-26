@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Intake
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Intake <span class="fw-300"><i>Type</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="pull-right mb-4">
                            <a class="btn btn-primary pull-right" href="javascript:;" data-toggle="modal" id="new">Add Intake Type</a>
                        </div>
                        <table id="intakeType" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Intake Type Code</th>
                                    <th>Intake Type Description</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake Code"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake Description"></td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                        <!-- datatable end -->
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">

                    </div>
                    <div class="modal fade" id="crud-modal" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Add Intake Type</h4>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'IntakeTypeController@store', 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{Form::label('title', 'Intake Type')}}
                                        {{Form::text('id', '', ['class' => 'form-control', 'placeholder' => 'Intake Type'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Intake Description')}}
                                        {{Form::text('intake_type_description', '', ['class' => 'form-control', 'placeholder' => 'Intake Description', 'required'])}}
                                    </div>
                                    <div class="pull-right">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editModal" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> Edit Intake Type</h4>
                                </div>
                                <div class="modal-body">
                                    {{-- {!! Form::open(['action' => 'IntakeTypeController@update', 'method' => 'POST', 'id' => 'edit-form']) !!} --}}
                                    @csrf
                                    <input name="id" id="id" >
                                    <div class="form-group">
                                        {{Form::label('title', 'Intake Description')}}
                                        {{Form::text('intake_type_description', '', ['id' => 'intake_type_description','class' => 'form-control','placeholder' => 'Intake Type Description'])}}
                                    </div>
                                    <div class="modal-footer">
                                        {{Form::submit('Save', ['class' => 'btn btn-primary'])}}
                                        <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
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
    $('#new').click(function () {
        $('#crud-modal').modal('show');
    });



    $(document).ready(function()
    {
        $('#intakeType thead tr .hasinput').each(function(i)
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


        var table = $('#intakeType').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-intakeType",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'intake_type_description', name: 'intake_type_description' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#intakeType').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#intakeType').DataTable().draw(false);
                    });
                }
            })
        });


    });

</script>

@endsection
