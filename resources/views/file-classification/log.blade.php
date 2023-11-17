@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file'></i> File Classification
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    @if (session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Whoops!</strong> There were some problems with your
                                            input.<br><br>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-header">Log for {{ $data->code }}
                                                    ({{ $data->file }})</b>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="fileClass"
                                                            class="table table-bordered table-hover table-striped w-100">
                                                            <thead>
                                                                <tr class="bg-primary-50 text-center">
                                                                    <th class="text-center">No</th>
                                                                    <th class="text-center">Log</th>
                                                                    <th class="text-center">Created By</th>
                                                                    <th class="text-center">Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="hasinput"></td>
                                                                    <td class="hasinput"></td>
                                                                    <td class="hasinput"></td>
                                                                    <td class="hasinput"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <a href="/file-classification"
                                                            class="btn btn-success ml-auto float-left mt-4 waves-effect waves-themed"><i
                                                                class="fal fa-arrow-alt-left"></i> Back
                                                        </a>
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
        $(document).ready(function() {

            var id = @json($id);

            var table = $('#fileClass').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/log-list/" + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        className: 'text-center',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        className: 'text-left',
                        data: 'log',
                        name: 'log'
                    },
                    {
                        className: 'text-center',
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        className: 'text-center',
                        data: 'date',
                        name: 'date'
                    },
                ],
                orderCellsTop: true,
                "order": [
                    [0, "asc"]
                ],
                "initComplete": function(settings, json) {}
            });
        });
    </script>
@endsection
