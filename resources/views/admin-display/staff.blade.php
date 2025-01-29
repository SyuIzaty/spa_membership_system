@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
            <i class='subheader-icon fal fa-users'></i> STAFF MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            LIST OF <span class="fw-300"> STAFF</span>
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
                                <table id="stf" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="text-center bg-danger-50" style="white-space: nowrap">
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone No.</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                            <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-info ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Staff</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="crud-modal" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> ADD NEW STAFF</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'StaffController@storeStaff', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <p><span class="text-danger">*</span> Required fields</p>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_name"><span class="text-danger">*</span> Name :</label></td>
                                    <td colspan="4">
                                        <input value="{{ old('staff_name') }}" class="staff_name form-control" id="staff_name" name="staff_name" required>
                                        @error('staff_name')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_ic"><span class="text-danger">*</span> Identification Card/Passport No. :</label></td>
                                    <td colspan="4">
                                        <input value="{{ old('staff_ic') }}" class="staff_ic form-control" id="staff_ic" name="staff_ic" min="12" max="12" required>
                                        @error('staff_ic')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_email"><span class="text-danger">*</span> Email :</label></td>
                                    <td colspan="4">
                                        <input type="email" value="{{ old('staff_email') }}" class="staff_email form-control" id="staff_email" name="staff_email" required>
                                        @error('staff_email')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_phone"><span class="text-danger">*</span> Phone No. :</label></td>
                                    <td colspan="4">
                                        <input type="number" value="{{ old('staff_phone') }}" class="staff_phone form-control" id="staff_phone" name="staff_phone" required>
                                        @error('staff_phone')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_gender"><span class="text-danger">*</span> Gender :</label></td>
                                    <td colspan="4">
                                        <select name="staff_gender" id="staff_gender" class="staff_gender form-control" required>
                                            <option value="" selected disabled> Please select</option>
                                            <option value="M" {{ old('staff_gender') ? 'selected' : '' }}>Male</option>
                                            <option value="F" {{ old('staff_gender') ? 'selected' : '' }}>Female</option>
                                         </select>
                                        @error('staff_gender')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_address"><span class="text-danger">*</span> Address :</label></td>
                                    <td colspan="4">
                                        <input type="text" value="{{ old('staff_address') }}" class="staff_address form-control" id="staff_address" name="staff_address" required>
                                        @error('staff_address')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_state"><span class="text-danger">*</span> State :</label></td>
                                    <td colspan="4">
                                        <input type="text" value="{{ old('staff_state') }}" class="staff_state form-control" id="staff_state" name="staff_state" required>
                                        @error('staff_state')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_postcode"><span class="text-danger">*</span> Postcode :</label></td>
                                    <td colspan="4">
                                        <input type="text" value="{{ old('staff_postcode') }}" class="staff_postcode form-control" id="staff_postcode" name="staff_postcode" required>
                                        @error('staff_postcode')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_start_date"><span class="text-danger">*</span> Start Date :</label></td>
                                    <td colspan="4">
                                        <input type="date" value="{{ old('staff_start_date') }}" class="staff_start_date form-control" id="staff_start_date" name="staff_start_date" required>
                                        @error('staff_start_date')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="staff_end_date"> End Date :</label></td>
                                    <td colspan="4">
                                        <input type="date" value="{{ old('staff_end_date') }}" class="staff_end_date form-control" id="staff_end_date" name="staff_end_date">
                                        @error('staff_end_date')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="role_id"><span class="text-danger">*</span> Role :</label></td>
                                <td colspan="4">
                                    <select name="role_id" id="role_id" class="role_id form-control" required>
                                        <option value="" selected disabled> Please select</option>
                                        <option value="SPA001" {{ old('role_id') ? 'selected' : '' }}>Administrator</option>
                                        <option value="SPA002" {{ old('role_id') ? 'selected' : '' }}>Staff</option>
                                        </select>
                                    @error('role_id')
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT STAFF</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'StaffController@updateStaff', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="staff_id" id="staff_id">
                        <p><span class="text-danger">*</span> Required fields</p>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="id"> ID :</label></td>
                                <td colspan="4">
                                    <input class="id form-control" id="id" name="id" disabled>
                                </td>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="name"><span class="text-danger">*</span> Name :</label></td>
                                    <td colspan="4">
                                        <input class="name form-control" id="name" name="name" required>
                                        @error('name')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="ic"><span class="text-danger">*</span> Identification Card/Passport No. :</label></td>
                                    <td colspan="4">
                                        <input class="ic form-control" id="ic" name="ic" min="12" max="12" required>
                                        @error('ic')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="email"> Email :</label></td>
                                    <td colspan="4">
                                        <input type="email" class="email form-control" id="email" name="email" disabled>
                                        @error('email')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="phone"><span class="text-danger">*</span> Phone No. :</label></td>
                                    <td colspan="4">
                                        <input type="number" class="phone form-control" id="phone" name="phone" required>
                                        @error('phone')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="gender"><span class="text-danger">*</span> Gender :</label></td>
                                    <td colspan="4">
                                        <select name="gender" id="gender" class="gender form-control" required>
                                            <option value="" selected disabled> Please select</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                         </select>
                                        @error('gender')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="address"><span class="text-danger">*</span> Address :</label></td>
                                    <td colspan="4">
                                        <input class="address form-control" id="address" name="address" required>
                                        @error('address')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="state"><span class="text-danger">*</span> State :</label></td>
                                    <td colspan="4">
                                        <input class="state form-control" id="state" name="state" required>
                                        @error('state')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="postcode"><span class="text-danger">*</span> Postcode :</label></td>
                                    <td colspan="4">
                                        <input class="postcode form-control" id="postcode" name="postcode" required>
                                        @error('postcode')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="start"><span class="text-danger">*</span> Start Date :</label></td>
                                    <td colspan="4">
                                        <input type="date" class="start form-control" id="start" name="start" required>
                                        @error('start')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                                <div class="col-md-6">
                                    <td width="10%"><label class="form-label" for="end"> End Date :</label></td>
                                    <td colspan="4">
                                        <input type="date" class="end form-control" id="end" name="end">
                                        @error('end')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                    </td>
                                </div>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="role"><span class="text-danger">*</span> Role :</label></td>
                                <td colspan="4">
                                    <select name="role" id="role" class="role form-control" required>
                                        <option value="" selected disabled> Please select</option>
                                        <option value="SPA001">Administrator</option>
                                        <option value="SPA002">Staff</option>
                                    </select>
                                    @error('role')
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

                $('#staff_gender, #role_id').select2({
                    dropdownParent: $('#crud-modal')
                });
            });

            $('#crud-modals').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('staff');
                var modal = $(this);

                $.ajax({
                    url: '/get-staff/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        modal.find('.modal-body #staff_id').val(data.id);
                        modal.find('.modal-body #name').val(data.staff_name);
                        modal.find('.modal-body #id').val(data.user_id);
                        modal.find('.modal-body #ic').val(data.staff_ic);
                        modal.find('.modal-body #email').val(data.staff_email);
                        modal.find('.modal-body #phone').val(data.staff_phone);
                        modal.find('.modal-body #gender').val(data.staff_gender).trigger('change');
                        modal.find('.modal-body #address').val(data.staff_address);
                        modal.find('.modal-body #state').val(data.staff_state);
                        modal.find('.modal-body #postcode').val(data.staff_postcode);
                        modal.find('.modal-body #start').val(data.staff_start_date);
                        modal.find('.modal-body #end').val(data.staff_end_date);
                        modal.find('.modal-body #role').val(data.user.role_id).trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching staff:', error);
                    }
                });

                $('.gender, .role').select2({
                    dropdownParent: modal
                });
            });

            var table = $('#stf').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-staff",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                        { className: 'text-center', data: 'user_id', name: 'user_id' },
                        { className: 'text-center', data: 'staff_name', name: 'staff_name' },
                        { className: 'text-center', data: 'staff_email', name: 'staff_email' },
                        { className: 'text-center', data: 'staff_phone', name: 'staff_phone' },
                        { className: 'text-center', data: 'role_id', name: 'role_id', orderable: false, searchable: false },
                        { className: 'text-center', data: 'staff_status', name: 'staff_status', orderable: false, searchable: false },
                        { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    orderCellsTop: true,
                    "order": [[ 0, "desc" ]],
                    "initComplete": function(settings, json) {

                    }
            });

            $('#stf').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');

                Swal.fire({
                    title: 'Delete Staff?',
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
                            $('#stf').DataTable().draw(false);
                        });
                    }
                })
            });

        });
    </script>
@endsection
