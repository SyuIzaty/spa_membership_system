@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-adjust'></i>ASSET DEPARTMENT MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Department List
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
                            <table id="department" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50">
                                        <th>#ID</th>
                                        <th>DEPARTMENT</th>
                                        <th>CODE NAME</th>
                                        <th>TOTAL MANAGER</th>
                                        <th>MANAGE MANAGER</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Total Manager"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add Department</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-building width-2 fs-xl"></i>ADD NEW DEPARTMENT</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Inventory\AssetParameterController@store_asset_department', 'method' => 'POST']) !!}
                    <p><span class="text-danger">*</span> Required fields</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                            <td colspan="2">
                                <select name="department_id" id="department_id" class="form-control" required>
                                    <option value="" selected disabled> Please select</option>
                                    @foreach ($department as $departments)
                                        <option value="{{ $departments->id }}" {{ old('department_id') ==  $departments->id  ? 'selected' : '' }}>
                                            {{ $departments->department_name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="department_name"><span class="text-danger">*</span> Code Name :
                                <i class="fal fa-info-circle fs-xs mr-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="A code name is utilized for inclusion in asset tagging, particularly in QR code and barcode applications."></i></label></td>
                            <td colspan="2"><input value="{{ old('department_name') }}" class="form-control" id="department_name" name="department_name" required>
                                @error('department_name')
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
                    <h5 class="card-title w-100"><i class="fal fa-building width-2 fs-xl"></i>EDIT DEPARTMENT</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Inventory\AssetParameterController@update_asset_department', 'method' => 'POST']) !!}
                    <input type="hidden" name="id" id="id">
                    <p><span class="text-danger">*</span> Required fields</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="department_ids"><span class="text-danger">*</span> Department :</label></td>
                            <td colspan="2">
                                <input value="{{ old('department_ids') }}" class="form-control" id="department_ids" name="department_ids" disabled>
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="department_names"><span class="text-danger">*</span> Code Name :
                                <i class="fal fa-info-circle fs-xs mr-1" data-toggle="tooltip" data-placement="right" title="" data-original-title="A code name is utilized for inclusion in asset tagging, particularly in QR code and barcode applications."></i></label></td></label></td>
                            <td colspan="2"><input value="{{ old('department_names') }}" class="form-control" id="department_names" name="department_names" required>
                                @error('department_names')
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

            $('#department_id').select2({
                dropdownParent: $('#crud-modal')
            });
        });

        $('#crud-modals').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var department = button.data('department')
            var departmentid = button.data('departmentid')

            $('.modal-body #id').val(id);
            $('.modal-body #department_names').val(department);
            $('.modal-body #department_ids').val(departmentid);
        })

        $('#department thead tr .hasinput').each(function(i)
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

        var table = $('#department').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-asset-department",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'department_id', name: 'department_id' },
                    { className: 'text-center', data: 'department_name', name: 'department_name' },
                    { className: 'text-center', data: 'total', name: 'total', orderable: false, searchable: false },
                    { className: 'text-center', data: 'manager', name: 'manager', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#department').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#department').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
