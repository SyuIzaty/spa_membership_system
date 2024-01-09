@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i>ASSET CLASS MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Class List
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
                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="class" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50">
                                        <th>CLASS CODE</th>
                                        <th>CLASS NAME</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Class Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Class Name"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add Asset Class</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>ADD NEW ASSET CLASS</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Inventory\AssetParameterController@store_asset_class', 'method' => 'POST']) !!}
                    <p><span class="text-danger">*</span> Required fields</p>

                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="class_code"><span class="text-danger">*</span> Code :</label></td>
                            <td colspan="4"><input value="{{ old('class_code') }}" class="form-control" id="class_code" name="class_code" style="text-transform: uppercase" required>
                                @error('class_code')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>

                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="class_name"><span class="text-danger">*</span> Name :</label></td>
                            <td colspan="4"><input value="{{ old('class_name') }}" class="form-control" id="class_name" name="class_name" style="text-transform: uppercase" required>
                                @error('class_name')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>

                    <div class="footer">
                        <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modals" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>EDIT ASSET CLASS</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Inventory\AssetParameterController@update_asset_class', 'method' => 'POST']) !!}
                    <input type="hidden" name="class_id" id="class">
                    <p><span class="text-danger">*</span> Required fields</p>

                    <div class="form-group">
                        <td width="15%"><label class="form-label" for="class_codes"><span class="text-danger">*</span> Code :</label></td>
                        <td colspan="5"><input class="form-control" id="codes" name="class_codes" style="text-transform: uppercase" disabled>
                            @error('class_codes')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>

                    <div class="form-group">
                        <td width="15%"><label class="form-label" for="class_names"><span class="text-danger">*</span> Name :</label></td>
                        <td colspan="5"><input class="form-control" id="names" name="class_names" style="text-transform: uppercase" required>
                            @error('class_names')
                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                            @enderror
                        </td>
                    </div>

                    <div class="footer">
                        <button type="submit" class="btn btn-success ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                        <button type="button" class="btn btn-secondary ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
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
            var code = button.data('code')
            var name = button.data('name')

            $('.modal-body #class').val(code);
            $('.modal-body #codes').val(code);
            $('.modal-body #names').val(name);
        })

        $('#class thead tr .hasinput').each(function(i)
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

        var table = $('#class').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-asset-class",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'class_code', name: 'class_code' },
                    { className: 'text-center', data: 'class_name', name: 'class_name' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#class').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#class').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
