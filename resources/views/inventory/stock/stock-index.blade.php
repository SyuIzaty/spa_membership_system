@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-dolly'></i>STOCK LISTS
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
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table id="stock" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                        <th>#ID</th>
                                        <th>DEPARTMENT</th>
                                        <th>CODE</th>
                                        <th>NAME</th>
                                        <th>MODEL</th>
                                        <th>BRAND</th>
                                        <th>CURRENT BALANCE</th>
                                        <th style="width: 150px">BALANCE STATUS</th>
                                        <th style="width: 150px">STATUS</th>
                                        <th>CREATED DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Model"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Brand"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Current Balance"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Balance Status"></td>
                                        <td class="hasinput">
                                            <select id="statuss" name="statuss" class="form-control">
                                                <option value="">ALL</option>
                                                <option value="1">ACTIVE</option>
                                                <option value="0">INACTIVE</option>
                                            </select>
                                        </td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Created Date"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="javascript:;" data-toggle="modals" id="news" class="btn btn-info float-right mr-2 ml-auto"><i class="fal fa-file-excel"></i> Import</a>
                        <a class="btn btn-warning float-right mr-2" href="/export-stock"><i class="fal fa-file-excel"></i> Export</a>
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary float-right"><i class="fal fa-plus-square"></i> Add New Stock</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crud-modal" aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-dolly width-2 fs-xl"></i>NEW STOCK DETAILS</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'StockController@newStockStore', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <p><span class="text-danger">*</span> Required fields</p>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="department_id"><span class="text-danger">*</span> Department :</label></td>
                            <td colspan="4">
                                <select name="department_id" id="department_id" class="department form-control" required>
                                    <option value="">Select Department</option>
                                    @foreach ($department as $depart)
                                        <option value="{{ $depart->id }}" {{ old('department_id') ? 'selected' : '' }}>{{ $depart->department_name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="stock_name"><span class="text-danger">*</span> Stock Name :</label></td>
                                <td colspan="4"><input value="{{ old('stock_name') }}" class="form-control" id="stock_name" name="stock_name" style="text-transform: uppercase" required>
                                    @error('stock_name')
                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                    @enderror
                                </td>
                            </td>
                        </div>
                        <div class="form-group">
                            <td width="10%"><label class="form-label" for="model"><span class="text-danger">*</span> Model :</label></td>
                                <td colspan="4"><input value="{{ old('model') }}" class="form-control" id="model" name="model" style="text-transform: uppercase" required>
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
                                <select class="form-control stat" id="status" name="status" required>
                                    <option value="">Select Status</option>
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
                                <input type="file" class="form-control" id="upload_image" name="upload_image[]" multiple>
                                @error('upload_image')
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

    <div class="modal fade" id="crud-modals" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title w-100"><i class="fal fa-info width-2 fs-xl"></i>IMPORT STOCK LIST</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['action' => 'StockController@bulkStockStore', 'method' => 'POST', 'id' => 'data', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table class="table mb-0">
                            <p><span class="text-danger">*</span> Required fields</p>
                            <tr>
                                <div class="form-group">
                                    <td width="20%"><label class="form-label" for="import_file"><span class="text-danger">*</span> File : </td>
                                    <td colspan="5"><input type="file" name="import_file" class="form-control mb-3" required> 
                                        <p style="color:red; font-size: 10px"><span class="text-danger">**</span><i>Note: this upload function is suitable to use for only first time stock entry.</i></p>
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
                                                                <td>{{ $departs->id ?? '--' }}</td>
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

</main>
@endsection

@section('script')

<script>
    $(document).ready(function()
    {
        $('#statuss').select2();

        $('.stat, .department').select2({
            dropdownParent: $('#crud-modal')
        });

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $('#news').click(function () {
            $('#crud-modals').modal('show');
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
                    { className: 'text-center', data: 'department_id', name: 'department_id' },
                    { className: 'text-center', data: 'stock_code', name: 'stock_code' },
                    { className: 'text-center', data: 'stock_name', name: 'stock_name' },
                    { className: 'text-center', data: 'model', name: 'model' },
                    { className: 'text-center', data: 'brand', name: 'brand' },
                    { className: 'text-center', data: 'current_balance', name: 'current_balance' },
                    { className: 'text-center', data: 'balance_status', name: 'balance_status' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'created_at', name: 'created_at'},
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 9, "desc" ]],
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
