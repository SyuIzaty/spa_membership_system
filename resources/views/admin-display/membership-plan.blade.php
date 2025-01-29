@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
            <i class='subheader-icon fal fa-id-card'></i> MEMBERSHIP PLAN
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            LIST OF <span class="fw-300"> MEMBERSHIP</span>
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
                                <table id="mbr" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="text-center bg-danger-50" style="white-space: nowrap">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price (RM)</th>
                                            <th>Duration (Month)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                            <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-info ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Membership</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="crud-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> ADD NEW MEMBERSHIP</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'MembershipPlanController@storeMembership', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <p><span class="text-danger">*</span> Required fields</p>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="plan_name"><span class="text-danger">*</span> Name :</label></td>
                                <td colspan="4">
                                    <input type="text" value="{{ old('plan_name') }}" class="plan_name form-control" id="plan_name" name="plan_name" required>
                                    @error('plan_name')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="plan_description"> Description :</label></td>
                                <td colspan="4">
                                    <textarea cols="3" class="plan_description form-control" id="plan_description" name="plan_description">{{ old('plan_description') }}</textarea>
                                    @error('plan_description')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="plan_price"><span class="text-danger">*</span> Price (RM) :</label></td>
                                <td colspan="4">
                                    <input type="number" value="{{ old('plan_price') }}" class="plan_price form-control" id="plan_price" name="plan_price" required>
                                    @error('plan_price')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="plan_duration_month"><span class="text-danger">*</span> Duration (Month) :</label></td>
                                <td colspan="4">
                                    <input type="number" value="{{ old('plan_duration_month') }}" class="plan_duration_month form-control" id="plan_duration_month" name="plan_duration_month" required>
                                    @error('plan_duration_month')
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
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT MEMBERSHIP</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'MembershipPlanController@updateMembership', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="membership_id" id="membership_id">
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
                            <td width="10%"><label class="form-label" for="price"><span class="text-danger">*</span> Price (RM) :</label></td>
                            <td colspan="4">
                                <input type="number" class="price form-control" id="price" name="price" required>
                                @error('price')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="duration"><span class="text-danger">*</span> Duration (Month) :</label></td>
                            <td colspan="4">
                                <input type="number" class="duration form-control" id="duration" name="duration" required>
                                @error('duration')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%">
                                <label class="form-label" for="service_id">
                                    <span class="text-danger">*</span> Service(s) :
                                </label>
                            </td>
                            <td colspan="4">
                                <select class="form-control" id="service_id" name="service_id[]" multiple>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                    @endforeach
                                </select>
                                @error('service_id')
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
                var button = $(event.relatedTarget);
                var id = button.data('membership');
                var modal = $(this);

                $.ajax({
                    url: '/get-membership/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        modal.find('.modal-body #membership_id').val(data.id);
                        modal.find('.modal-body #name').val(data.plan_name);
                        modal.find('.modal-body #description').val(data.plan_description);
                        modal.find('.modal-body #price').val(data.plan_price);
                        modal.find('.modal-body #duration').val(data.plan_duration_month);

                        var serviceSelect = modal.find('.modal-body #service_id');
                        serviceSelect.empty();
                        $.each(data.services, function(index, service) {
                            var isSelected = data.associated_service_ids.includes(service.id) ? 'selected' : '';
                            serviceSelect.append(
                                `<option value="${service.id}" ${isSelected}>${service.service_name}</option>`
                            );
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching membership:', error);
                    }
                });

                $('#service_id').select2({
                    dropdownParent: modal
                });
            });

            var table = $('#mbr').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-membership",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                        { className: 'text-center', data: 'plan_name', name: 'plan_name' },
                        { className: 'text-center', data: 'plan_description', name: 'plan_description' },
                        { className: 'text-center', data: 'plan_price', name: 'plan_price' },
                        { className: 'text-center', data: 'plan_duration_month', name: 'plan_duration_month' },
                        { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    orderCellsTop: true,
                    "order": [[ 0, "desc" ]],
                    "initComplete": function(settings, json) {

                    }
            });

            $('#mbr').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');

                Swal.fire({
                    title: 'Delete Membership Plan?',
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
                            $('#mbr').DataTable().draw(false);
                        });
                    }
                })
            });

        });
    </script>
@endsection
