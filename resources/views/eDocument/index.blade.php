@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-folder'></i> eDocument Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Document List</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="col-sm-6">
                                <button class="btn btn-success dropdown-toggle waves-effect waves-themed" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if ($id != '')
                                      {{$getDepartment->name}}

                                    @else
                                        Select Department
                                    @endif
                                </button>
                                <div class="dropdown-menu" style="">
                                    @foreach ($department as $d)
                                        <a  href="/get-list/{{$d->id}}" class="dropdown-item" name="list" value="{{$d->id}}">{{$d->name}}</a>
                                    @endforeach                                                                           
                                </div>
                            </div>
                            <br>
                            @if ($id != '')
                                <div class="table-responsive">
                                    <table id="list" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Document</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="hasinput"></td>
                                                <td class="hasinput"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @role('eDocument (Admin)')
                                        <a href= "/upload/{{$id}}" class="btn btn-info waves-effect waves-themed float-right" style="margin-top: 15px; margin-bottom: 10px;"><i class="fal fa-upload"></i> Upload</a>
                                @endrole
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Document</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="text-center text-danger"><b>PLEASE CHOOSE DEPARMENT</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
        var department = @json($id);
        var table = $('#list').DataTable({
        
            processing: true,
            serverSide: true,
            ajax: {
                url: "/view-list/" + department,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                    { className: 'text-left', data: 'document', name: 'document' },

                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

</script>
@endsection
