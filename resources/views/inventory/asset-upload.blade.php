@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-upload'></i>Bulk Upload
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Upload <span class="fw-300"><i>Asset List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                    @foreach ($errors->all() as $error)
                                        <i class="icon fal fa-check-circle"></i> {{ $error }}
                                    @endforeach
                            </div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('success') }}</div>
                        @endif

                        <form action={{ url('import-asset') }} method="post" name="importform" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <div class="panel-content">
                                    <div class="table-responsive">
                                        <table id="new_lead" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <p style="margin-bottom: -15px"><span class="text-danger">*</span> Required fields</p>
                                                <tr>
                                                    <div class="form-group">
                                                        <td width="20%"><label class="form-label" for="import_file"><span class="text-danger">*</span> File :</label></td>
                                                        <td colspan="5"><input type="file" name="import_file" class="form-control mb-3"></td>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <button class="btn btn-success btn-sm float-right mb-3"><i class="fal fa-upload"></i> Upload File</button>
                                    <a href="/assetTemplates" class="btn btn-primary btn-sm float-right mr-2"><i class="fal fa-download"></i> Download Template</a>
                                </div>
                            </div>
                        </form>

                        <div class="col-md-12 mt-5">
                            <div class="panel-content">
                                <div class="panel-tag">Code List</div>
                                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#code" aria-expanded="false">
                                                <i class="fal fa-clone width-2 fs-xl"></i>
                                                Code Type
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
                                        <div id="code" class="collapse" data-parent="#code">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="code_list" style="width: 100%">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>CODE ID</td>
                                                            <td>CODE NAME</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code ID"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Code Name"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($code as $codes)
                                                            <tr align="center">
                                                                <td>{{ $codes->id ?? '--' }}</td>
                                                                <td>{{ $codes->code_name ?? '--' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#type" aria-expanded="false">
                                                <i class="fal fa-bookmark width-2 fs-xl"></i>
                                                Asset Type
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
                                        <div id="type" class="collapse" data-parent="#type">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="type_list" style="width: 100%">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>DEPARTMENT</td>
                                                            <td>TYPE CODE</td>
                                                            <td>ASSET TYPE NAME</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput">
                                                                <select id="data_department" name="data_department" class="form-control">
                                                                    <option value="">All</option>
                                                                    @foreach($data_department as $data_departments)
                                                                        <option value="{{$data_departments->department_name}}">{{ $data_departments->department_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Type Code"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Type Name"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($type as $types)
                                                            <tr align="center">
                                                                <td>{{ $types->department->department_name ?? '--' }}</td>
                                                                <td>{{ $types->id ?? '--' }}</td>
                                                                <td>{{ $types->asset_type ?? '--' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#status" aria-expanded="false">
                                                <i class="fal fa-check-circle width-2 fs-xl"></i>
                                                Status
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
                                        <div id="status" class="collapse" data-parent="#status">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 100%" id="status_list">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>STATUS CODE</td>
                                                            <td>STATUS NAME</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Status Code"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Status Name"></td>
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
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#acquisition" aria-expanded="false">
                                                <i class="fal fa-adjust width-2 fs-xl"></i>
                                                Acquisition Type
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
                                        <div id="acquisition" class="collapse" data-parent="#acquisition">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 100%" id="acquisition_list">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>ACQUISITION CODE</td>
                                                            <td>ACQUISITION NAME</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Acquisition Code"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Acquisition Name"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($acquisition as $acq)
                                                            <tr align="center">
                                                                <td>{{ $acq->id ?? '--' }}</td>
                                                                <td>{{ $acq->acquisition_type ?? '--' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#availability" aria-expanded="false">
                                                <i class="fal fa-info-circle width-2 fs-xl"></i>
                                                Availability
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
                                        <div id="availability" class="collapse" data-parent="#availability">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 100%" id="availability_list">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>AVAILABILITY CODE</td>
                                                            <td>AVAILABILITY NAME</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Availibility Code"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Availibility Name"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($availability as $availabilitys)
                                                            <tr align="center">
                                                                <td>{{ $availabilitys->id ?? '--' }}</td>
                                                                <td>{{ $availabilitys->name ?? '--' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#custodian" aria-expanded="false">
                                                <i class="fal fa-user width-2 fs-xl"></i>
                                                Custodian
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
                                        <div id="custodian" class="collapse" data-parent="#custodian">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 100%" id="custodian_list">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>CUSTODIAN ID</td>
                                                            <td>CUSTODIAN NAME</td>
                                                            <td>CUSTODIAN POSITION</td>
                                                            <td>CUSTODIAN DEPARTMENT</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Custodian ID"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Custodian Name"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Custodian Position"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Custodian Department"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($custodian as $custodians)
                                                            <tr align="center">
                                                                <td>{{ $custodians->id ?? '--' }}</td>
                                                                <td>{{ $custodians->name ?? '--' }}</td>
                                                                <td>{{ $custodians->staff->staff_position ?? '--' }}</td>
                                                                <td>{{ $custodians->staff->staff_dept ?? '--' }}</td>
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

                    </div>
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
        $('#data_department').select2();

        $('#code_list thead tr .hasinput').each(function(i)
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

        var table = $('#code_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(document).ready(function() {

        $('#type_list thead tr .hasinput').each(function(i)
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

        var table = $('#type_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(document).ready(function() {

        $('#status_list thead tr .hasinput').each(function(i)
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

        var table = $('#status_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(document).ready(function() {

        $('#acquisition_list thead tr .hasinput').each(function(i)
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

        var table = $('#acquisition_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(document).ready(function() {

        $('#availability_list thead tr .hasinput').each(function(i)
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

        var table = $('#availability_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

    $(document).ready(function() {

        $('#custodian_list thead tr .hasinput').each(function(i)
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

        var table = $('#custodian_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });

    });

</script>

@endsection
