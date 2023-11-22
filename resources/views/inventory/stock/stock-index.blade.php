@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-dolly'></i>STOCK LIST MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        List <span class="fw-300"><i>Of Stock</i></span>
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
                            <table id="stock" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                        <th>#ID</th>
                                        @can('view stock')
                                            <th>DEPARTMENT</th>
                                        @endcan
                                        <th>CODE</th>
                                        <th>NAME</th>
                                        <th>STATUS</th>
                                        @can('view stock')
                                            <th>CURRENT OWNER</th>
                                        @endcan
                                        <th>CURRENT BALANCE</th>
                                        <th>BALANCE STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        @can('view stock')
                                            <td class="hasinput"><input type="text" class="form-control" placeholder=" Department"></td>
                                        @endcan
                                        <td class="hasinput"><input type="text" class="form-control" placeholder=" Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder=" Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder=" Status"></td>
                                        @can('view stock')
                                            <td class="hasinput"><input type="text" class="form-control" placeholder=" Current Owner"></td>
                                        @endcan
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    @cannot('view stock')
                        <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                            <a href="javascript:;" data-toggle="modals" id="news" class="btn btn-info float-right mr-2 ml-auto"><i class="fal fa-file-excel"></i> Import</a>
                            <a class="btn btn-warning float-right mr-2" href="/export-stock"><i class="fal fa-file-excel"></i> Export</a>
                            <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary float-right"><i class="fal fa-plus-square"></i> Add New Stock</a>
                        </div>
                    @endcannot
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-dolly width-2 fs-xl"></i>NEW STOCK DETAIL</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Inventory\StockController@newStockStore', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <p><span class="text-danger">*</span> Required fields</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                            <td colspan="4">
                                <input value="{{ $staff->departments->department_name }}" class="form-control" id="department_id" name="department_id" disabled>
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="stock_name"><span class="text-danger">*</span> Name :</label></td>
                                <td colspan="4"><input value="{{ old('stock_name') }}" class="form-control" id="stock_name" name="stock_name" style="text-transform: uppercase" required>
                                    @error('stock_name')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="model"><span class="text-danger">*</span> Model :</label></td>
                                <td colspan="4"><input value="{{ old('model') }}" class="form-control" id="model" name="model" style="text-transform: uppercase">
                                    @error('model')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="brand"> Brand :</label></td>
                                <td colspan="4"><input value="{{ old('brand') }}" class="form-control" id="brand" name="brand" style="text-transform: uppercase">
                                    @error('brand')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="status"><span class="text-danger">*</span> Status :</label></td>
                            <td colspan="4">
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Please select</option>
                                    <option value="1" {{ old('status') == '1' ? 'selected':''}} >Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected':''}} >Inactive</option>
                                </select>
                                @error('status')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="upload_image"> Image :</label></td>
                            <td colspan="4">
                                <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple accept=".jpg, .jpeg, .png, .gif">
                                @error('upload_image')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        @if($staff->staff_code == 'OFM')
                            <div class="form-group">
                                <label class="form-label mr-4" for="applicable_for_stationary"> Applicable for i-Stationery ?</label>
                                <label style="vertical-align: middle;">
                                    <input type="checkbox" name="applicable_for_stationary" value="1" id="applicable_for_stationary" style="vertical-align: middle;">
                                </label> Yes
                            </div>
                        @endif
                        @if($staff->staff_code == 'OFM' || $staff->staff_code == 'IITU' )
                            <div class="form-group">
                                <label class="form-label mr-4" for="applicable_for_aduan"> Applicable for e-Aduan ?</label>
                                <label style="vertical-align: middle;">
                                    <input type="checkbox" name="applicable_for_aduan" value="1" id="applicable_for_aduan" style="vertical-align: middle;">
                                </label> Yes
                            </div>
                        @endif
                        <div class="footer">
                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                            <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modals" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>IMPORT STOCK LIST</h5>
                </div>
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                                @foreach ($errors->all() as $error)
                                    <i class="icon fal fa-check-circle"></i> {{ $error }}
                                @endforeach
                        </div>
                    @endif
                    {!! Form::open(['action' => 'Inventory\StockController@bulkStockStore', 'method' => 'POST', 'id' => 'data', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table mb-0">
                            <p><span class="text-danger">*</span> Required fields</p>
                            <tr>
                                <div class="form-group">
                                    <td width="20%"><label class="form-label" for="import_file"><span class="text-danger">*</span> File : </td>
                                    <td colspan="5"><input type="file" name="import_file" class="form-control mb-3" required>
                                        <p style="color:red; font-size: 14px"><span class="text-danger">**</span><i>Notes:</i><br>
                                        - This upload function is suitable to use for only first time stock entry.<br>
                                        - Delete the example column data when uploading to avoid data error.<br>
                                        - io_no = invoice number.<br>
                                        - Required: stock_name, model, status, department_id, created_by, stock_in.<br>
                                        </p>
                                    </td>
                                </div>
                            </tr>
                        </table>
                        <div class="col-md-12">
                            <div class="panel-content">
                                <div class="panel-tag">Code List</div>
                                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#stat" aria-expanded="false">
                                                <i class="fal fa-clone width-2 fs-xl"></i>
                                                Status List
                                                <span class="ml-auto">
                                                    <span class="collapsed-reveal">
                                                        <i class="fal fa-minus fs-xl"></i>
                                                    </span>
                                                    <span class="collapsed-hidden">
                                                        <i class="fal fa-plus fs-xl"></i>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                        <div id="stat" class="collapse" data-parent="#stat">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="stat_list" style="width: 100%">
                                                        <thead>
                                                            <tr class="bg-primary-50 text-center">
                                                                <td> ID</td>
                                                                <td> NAME</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr align="center">
                                                                <td>0</td>
                                                                <td>INACTIVE</td>
                                                            </tr>
                                                            <tr align="center">
                                                                <td>1</td>
                                                                <td>ACTIVE</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#dept" aria-expanded="false">
                                                <i class="fal fa-clone width-2 fs-xl"></i>
                                                Department List
                                                <span class="ml-auto">
                                                    <span class="collapsed-reveal">
                                                        <i class="fal fa-minus fs-xl"></i>
                                                    </span>
                                                    <span class="collapsed-hidden">
                                                        <i class="fal fa-plus fs-xl"></i>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                        <div id="dept" class="collapse" data-parent="#dept">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="dept_list" style="width: 100%">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>ID</td>
                                                            <td>NAME</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($department as $departs)
                                                            <tr align="center">
                                                                <td>{{ $departs->department_code ?? '--' }}</td>
                                                                <td>{{ $departs->department_name ?? '--' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                            <a href="/stockTemplate" class="btn btn-info float-right upload_view mr-2"><i class="fal fa-download"></i> Template</a>
                            <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal-owner" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i> CHANGE OWNERSHIP</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'Inventory\StockController@changeOwner', 'method' => 'POST']) !!}
                    <input type="hidden" name="owner_id" id="id">
                    <p><span class="text-danger">*</span> Required fields</p>
                    <div class="form-group int">
                        <td width="15%"><label class="form-label" for="current_owner"><span class="text-danger">*</span> Staff :</label></td>
                        <td colspan="7">
                            <select class="form-control current_owner" name="current_owner" id="current_owner" required>
                                <option value="" disabled selected> Please select </option>
                                @foreach ($role as $roles)
                                    <option value="{{ $roles->id }}" {{ old('current_owner') ==  $roles->id  ? 'selected' : '' }}>{{ $roles->id }} - {{ $roles->name }}</option>
                                @endforeach
                            </select>
                            @error('current_owner')
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

</main>
@endsection

@section('script')

<script>
    $(document).ready(function()
    {
        $('#status').select2({
            dropdownParent: $('#crud-modal')
        });

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#news').click(function () {
            $('#crud-modals').modal('show');
        });

        $('#crud-modal-owner').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')

            $('.modal-body #id').val(id);

            $('#current_owner').select2({
                dropdownParent: $('#crud-modal-owner')
            });
        });

        $('#stock thead tr .hasinput').each(function(i)
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

        var table = $('#stock').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/stockList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    @can('view stock')
                        { className: 'text-center', data: 'department_id', name: 'departments.department_name' },
                    @endcan
                    { className: 'text-center', data: 'stock_code', name: 'stock_code' },
                    { className: 'text-center', data: 'stock_name', name: 'stock_name' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    @can('view stock')
                        { className: 'text-center', data: 'current_owner', name: 'user.name' },
                    @endcan
                    { className: 'text-center', data: 'current_balance', name: 'current_balance', orderable: false, searchable: false },
                    { className: 'text-center', data: 'balance_status', name: 'balance_status', orderable: false, searchable: false },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "desc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#stock').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#stock').DataTable().draw(false);
                    });
                }
            })
        });

    });

    $(document).ready(function() {

        $('#stat_list thead tr .hasinput').each(function(i)
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

        var table = $('#stat_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(document).ready(function() {

        $('#dept_list thead tr .hasinput').each(function(i)
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

        var table = $('#dept_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });


</script>

@endsection
