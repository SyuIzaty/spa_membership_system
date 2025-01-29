@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
            <i class='subheader-icon fal fa-burn'></i> SERVICE MANAGEMENT
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            LIST OF <span class="fw-300"> SERVICE</span>
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
                                <table id="srv" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="text-center bg-danger-50" style="white-space: nowrap">
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Duration (Min.)</th>
                                            <th>Price (RM)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                            <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-info ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="crud-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> ADD NEW SERVICE</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'ServiceController@storeService', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <p><span class="text-danger">*</span> Required fields</p>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="service_name"><span class="text-danger">*</span> Name :</label></td>
                                <td colspan="4">
                                    <input type="text" value="{{ old('service_name') }}" class="service_name form-control" id="service_name" name="service_name" required>
                                    @error('service_name')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="service_description"> Description :</label></td>
                                <td colspan="4">
                                    <textarea cols="3" class="service_description form-control" id="service_description" name="service_description">{{ old('service_description') }}</textarea>
                                    @error('service_description')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="service_category"><span class="text-danger">*</span> Category :</label></td>
                                <td colspan="4">
                                    <select name="service_category" id="service_category" class="service_category form-control" required>
                                        <option value="" selected disabled> Please select</option>
                                        <option value="Skin Care" {{ old('service_category') ? 'selected' : '' }}>Skin Care</option>
                                        <option value="Body Care" {{ old('service_category') ? 'selected' : '' }}>Body Care</option>
                                        <option value="Massage" {{ old('service_category') ? 'selected' : '' }}>Massage</option>
                                        <option value="Beauty" {{ old('service_category') ? 'selected' : '' }}>Beauty</option>
                                     </select>
                                    @error('service_category')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="service_duration"><span class="text-danger">*</span> Duration (Min.) :</label></td>
                                <td colspan="4">
                                    <input type="number" value="{{ old('service_duration') }}" class="service_duration form-control" id="service_duration" name="service_duration" required>
                                    @error('service_duration')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="service_price"><span class="text-danger">*</span> Price (RM) :</label></td>
                                <td colspan="4">
                                    <input type="number" value="{{ old('service_price') }}" class="service_price form-control" id="service_price" name="service_price" required>
                                    @error('service_price')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </div>
                            <div class="form-group">
                                <td width="10%"><label class="form-label" for="service_img_name"><span class="text-danger">*</span> Image :</label></td>
                                <td colspan="4">
                                    <input type="file" class="form-control" value="{{ old('service_img_name') }}" id="service_img_name" name="service_img_name" accept=".jpg, .jpeg, .png" required>
                                    @error('service_img_name')
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
                        <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> EDIT SERVICE</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'ServiceController@updateService', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="service_id" id="service_id">
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
                            <td width="10%"><label class="form-label" for="category"><span class="text-danger">*</span> Category :</label></td>
                            <td colspan="4">
                                <select name="category" id="category" class="category form-control" required>
                                    <option value="" disabled> Please select</option>
                                    <option value="Skin Care">Skin Care</option>
                                    <option value="Body Care">Body Care</option>
                                    <option value="Massage">Massage</option>
                                    <option value="Beauty">Beauty</option>
                                 </select>
                                @error('category')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="duration"><span class="text-danger">*</span> Duration (Min.) :</label></td>
                            <td colspan="4">
                                <input type="number" class="duration form-control" id="duration" name="duration" required>
                                @error('duration')
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
                            <td width="10%"><label class="form-label" for="img_name"> Image :</label></td>
                            <td colspan="4">
                                <input type="file" class="form-control" id="img_name" name="img_name" accept=".jpg, .jpeg, .png">
                                @error('img_name')
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

                $('#service_category').select2({
                    dropdownParent: $('#crud-modal')
                });
            });

            $('#crud-modals').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('service');
                var modal = $(this);

                $.ajax({
                    url: '/get-service/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        modal.find('.modal-body #service_id').val(data.id);
                        modal.find('.modal-body #name').val(data.service_name);
                        modal.find('.modal-body #description').val(data.service_description);
                        modal.find('.modal-body #category').val(data.service_category).trigger('change');
                        modal.find('.modal-body #duration').val(data.service_duration);
                        modal.find('.modal-body #price').val(data.service_price);
                        modal.find('.modal-body #img_name').val(data.service_img_name);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching service:', error);
                    }
                });

                $('.category').select2({
                    dropdownParent: modal
                });
            });

            var table = $('#srv').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/data-service",
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                },
                columns: [
                        { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                        { className: 'text-center', data: 'service_img_name', name: 'service_img_name' },
                        { className: 'text-center', data: 'service_name', name: 'service_name' },
                        { className: 'text-center', data: 'service_category', name: 'service_category' },
                        { className: 'text-center', data: 'service_duration', name: 'service_duration' },
                        { className: 'text-center', data: 'service_price', name: 'service_price' },
                        { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    orderCellsTop: true,
                    "order": [[ 0, "desc" ]],
                    "initComplete": function(settings, json) {

                    }
            });

            $('#srv').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');

                Swal.fire({
                    title: 'Delete Service?',
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
                            $('#srv').DataTable().draw(false);
                        });
                    }
                })
            });

        });
    </script>
@endsection
