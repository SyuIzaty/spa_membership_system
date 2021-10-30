@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-server'></i> MY ASSET MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        List <span class="fw-300"><i>of Asset in Custody</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="mine" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center" style="white-space: nowrap">
                                        <th>#ID</th>
                                        <th>DEPARTMENT</th>
                                        <th>CODE TYPE</th>
                                        <th>ASSET TYPE</th>
                                        <th>ASSET CLASS</th>
                                        <th>ASSET DETAILS</th>
                                        <th>ASSIGN BY</th>
                                        <th>ASSIGN DATE</th>
                                        <th>VERIFY DATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput">
                                            <select id="data_department" name="data_department" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_department as $data_departments)
                                                    <option value="{{$data_departments->department_name}}">{{ $data_departments->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput">
                                            <select id="data_code" name="data_code" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_code as $data_codes)
                                                    <option value="{{$data_codes->code_name}}">{{ $data_codes->code_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput">
                                            <select id="data_type" name="data_type" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_type as $data_types)
                                                    <option value="{{$data_types->asset_type}}">{{ $data_types->asset_type }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput">
                                            <select id="data_class" name="data_class" class="form-control">
                                                <option value="">All</option>
                                                @foreach($data_class as $data_classes)
                                                    <option value="{{$data_classes->class_code}}">{{ $data_classes->class_code }} - {{ $data_classes->class_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Asset Details"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Assigned By"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Assigned Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Verify Date"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a class="btn btn-warning ml-auto float-right" href="/export-individual-asset"><i class="fal fa-file-excel"></i> Export</a>
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
        $('#data_department, #data_code, #data_type, #data_class').select2();

        $('#mine thead tr .hasinput').each(function(i)
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

        var table = $('#mine').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/individualList",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'department', name: 'department' },
                    { className: 'text-center', data: 'asset_code_type', name: 'asset_code_type' },
                    { className: 'text-center', data: 'asset_type', name: 'asset_type' },
                    { className: 'text-center', data: 'asset_class', name: 'asset_class' },
                    { data: 'asset_name', name: 'asset_name' },
                    { className: 'text-center', data: 'assigned_by', name: 'assigned_by' },
                    { className: 'text-center', data: 'assigned_date', name: 'assigned_date' },
                    { className: 'text-center', data: 'verification_date', name: 'verification_date' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
        
                orderCellsTop: true,
                "order": [[ 7, "desc" ]],
                "initComplete": function(settings, json) {
                } 
        });
    });

</script>

@endsection
