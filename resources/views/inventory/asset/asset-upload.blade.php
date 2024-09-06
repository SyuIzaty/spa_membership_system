@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-upload'></i> Asset Bulk Upload
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
                            <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('success') }}</div>
                        @endif

                        <form action={{ url('import-asset-list') }} method="post" name="importform" enctype="multipart/form-data">
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
                                                        <td colspan="5"><input type="file" name="import_file" class="form-control mb-3" required></td>
                                                    </div>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <button class="btn btn-success btn-sm float-right mb-3"><i class="fal fa-upload"></i> Upload File</button>
                                    <a href="/asset-template" class="btn btn-primary btn-sm float-right mr-2"><i class="fal fa-download"></i> Download Template</a>
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
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($code as $codes)
                                                            <tr align="center">
                                                                <td>{{ $codes->id ?? '-' }}</td>
                                                                <td>{{ $codes->code_name ?? '-' }}</td>
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
                                                            <td>ID</td>
                                                            <td>DEPARTMENT</td>
                                                            {{-- <td>TYPE CODE</td> --}}
                                                            <td>ASSET TYPE NAME</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($type as $types)
                                                            <tr align="center">
                                                                <td>{{ $types->id ?? '-' }}</td>
                                                                <td>{{ $types->department->department_name ?? '-' }}</td>
                                                                {{-- <td>{{ $types->id ?? '-' }}</td> --}}
                                                                <td>{{ $types->asset_type ?? '-' }}</td>
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
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#class" aria-expanded="false">
                                                <i class="fal fa-bookmark width-2 fs-xl"></i>
                                                Asset Class
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
                                        <div id="class" class="collapse" data-parent="#class">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="class_list" style="width: 100%">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>CLASS CODE</td>
                                                            <td>CLASS NAME</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($class as $classes)
                                                            <tr align="center">
                                                                <td>{{ $classes->class_code ?? '-' }}</td>
                                                                <td>{{ $classes->class_name ?? '-' }}</td>
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
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($acquisition as $acq)
                                                            <tr align="center">
                                                                <td>{{ $acq->id ?? '-' }}</td>
                                                                <td>{{ $acq->acquisition_type ?? '-' }}</td>
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
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($availability as $availabilitys)
                                                            <tr align="center">
                                                                <td>{{ $availabilitys->id ?? '-' }}</td>
                                                                <td>{{ $availabilitys->name ?? '-' }}</td>
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
                                                            <td> ID</td>
                                                            <td> NAME</td>
                                                            <td> DEPARTMENT</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($custodian as $custodians)
                                                            <tr align="center">
                                                                <td>{{ $custodians->custodian_id ?? '-' }}</td>
                                                                <td>{{ $custodians->custodian->name ?? '-' }}</td>
                                                                <td>{{ $custodians->department->department_name ?? '-' }}</td>
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
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#space" aria-expanded="false">
                                                <i class="fal fa-house width-2 fs-xl"></i>
                                                Location
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
                                        <div id="space" class="collapse" data-parent="#space">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 100%" id="space_list">
                                                    <thead>
                                                        <tr class="bg-primary-50 text-center">
                                                            <td> ID</td>
                                                            <td> NAME</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($space as $spaces)
                                                            <tr align="center">
                                                                <td>{{ $spaces->id ?? '-' }}</td>
                                                                <td>{{ $spaces->name ?? '-' }}</td>
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
        var table = $('#code_list, #type_list, #class_list, #status_list, #acquisition_list, #availability_list, #custodian_list, #space_list').DataTable({
            columnDefs: [],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });
    });

</script>

@endsection
