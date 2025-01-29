@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
            <i class='subheader-icon fal fa-tags'></i> DISCOUNT MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            LIST OF <span class="fw-300"> DISCOUNT</span>
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
                                <table id="dsc" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="text-center bg-danger-50" style="white-space: nowrap">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                            <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-info ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Discount</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="crud-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> ADD NEW DISCOUNT</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'DiscountController@storeDiscount', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <p><span class="text-danger">*</span> Required fields</p>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="discount_name"><span class="text-danger">*</span> Name :</label></td>
                                <td colspan="4">
                                    <input type="text" value="{{ old('discount_name') }}" class="discount_name form-control" id="discount_name" name="discount_name" required>
                                    @error('discount_name')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="discount_description"> Description :</label></td>
                                <td colspan="4">
                                    <textarea cols="3" class="discount_description form-control" id="discount_description" name="discount_description">{{ old('discount_description') }}</textarea>
                                    @error('discount_description')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="discount_type"><span class="text-danger">*</span> Type :</label></td>
                                <td colspan="4">
                                    <select name="discount_type" id="discount_type" class="discount_type form-control" required>
                                        <option value="" selected disabled> Please select</option>
                                        <option value="percentage" {{ old('discount_type') ? 'selected' : '' }}> Percentage</option>
                                        <option value="fixed" {{ old('discount_type') ? 'selected' : '' }}> Fixed</option>
                                     </select>
                                    @error('discount_type')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="discount_value"><span class="text-danger">*</span> Value :</label></td>
                                <td colspan="4">
                                    <input type="number" value="{{ old('discount_value') }}" class="discount_value form-control" id="discount_value" name="discount_value" required>
                                    @error('discount_value')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="discount_start_date"><span class="text-danger">*</span> Start Date :</label></td>
                                <td colspan="4">
                                    <input type="date" value="{{ old('discount_start_date') }}" class="discount_start_date form-control" id="discount_start_date" name="discount_start_date" required>
                                    @error('discount_start_date')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="discount_end_date"><span class="text-danger">*</span> End Date :</label></td>
                                <td colspan="4">
                                    <input type="date" value="{{ old('discount_end_date') }}" class="discount_end_date form-control" id="discount_end_date" name="discount_end_date" required>
                                    @error('discount_end_date')
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

        <div class="modal fade" id="crud-modals" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT DISCOUNT</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'DiscountController@updateDiscount', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="discount_id" id="discount_id">
                        <p><span class="text-danger">*</span> Required fields</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="name"><span class="text-danger">*</span> Name :</label></td>
                            <td colspan="4">
                                <input type="text" class="name form-control" id="name" name="name" required>
                                @error('name')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="description"> Description :</label></td>
                            <td colspan="4">
                                <textarea cols="3" class="description form-control" id="description" name="description"></textarea>
                                @error('description')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="type"><span class="text-danger">*</span> Type :</label></td>
                            <td colspan="4">
                                <select name="type" id="type" class="type form-control" required>
                                    <option value="" disabled> Please select</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed</option>
                                 </select>
                                @error('type')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="value"><span class="text-danger">*</span> Value :</label></td>
                            <td colspan="4">
                                <input type="number" class="value form-control" id="value" name="value" required>
                                @error('value')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="start"><span class="text-danger">*</span> Start Date :</label></td>
                            <td colspan="4">
                                <input type="date" class="start form-control" id="start" name="start" required>
                                @error('start')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="end"><span class="text-danger">*</span> End Date :</label></td>
                            <td colspan="4">
                                <input type="date" class="end form-control" id="end" name="end" required>
                                @error('end')
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

                $('#discount_type').select2({
                    dropdownParent: $('#crud-modal')
                });
            });

            $('#crud-modals').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('discount');
                var modal = $(this);

                $.ajax({
                    url: '/get-discount/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        modal.find('.modal-body #discount_id').val(data.id);
                        modal.find('.modal-body #name').val(data.discount_name);
                        modal.find('.modal-body #description').val(data.discount_description);
                        modal.find('.modal-body #type').val(data.discount_type).trigger('change');
                        modal.find('.modal-body #value').val(data.discount_value);
                        modal.find('.modal-body #start').val(data.discount_start_date);
                        modal.find('.modal-body #end').val(data.discount_end_date);

                        if (data.id == 1) {
                            modal.find('.modal-body #start').removeAttr('required');
                            modal.find('.modal-body #end').removeAttr('required');
                        } else {
                            modal.find('.modal-body #start').attr('required', 'required');
                            modal.find('.modal-body #end').attr('required', 'required');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching discount:', error);
                    }
                });

                $('.type').select2({
                    dropdownParent: modal
                });
            });

            var table = $('#dsc').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-discount",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                        { className: 'text-center', data: 'discount_name', name: 'discount_name' },
                        { className: 'text-center', data: 'discount_type', name: 'discount_type' },
                        { className: 'text-center', data: 'discount_value', name: 'discount_value' },
                        { className: 'text-center', data: 'discount_start_date', name: 'discount_start_date' },
                        { className: 'text-center', data: 'discount_end_date', name: 'discount_end_date' },
                        { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    orderCellsTop: true,
                    "order": [[ 0, "desc" ]],
                    "initComplete": function(settings, json) {

                    }
            });

            $('#dsc').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');

                Swal.fire({
                    title: 'Delete Discount?',
                    text: "The data cannot be restored!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: '_DELETE', submit: true}
                        }).always(function (data) {
                            $('#dsc').DataTable().draw(false);
                        });
                    }
                })
            });

        });
    </script>
@endsection
