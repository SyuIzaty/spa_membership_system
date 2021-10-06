@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-laptop'></i> Computer Grant Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of Grant Quota per Year</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="quotaList" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">Year</th>
                                            <th class="text-center">Quota</th>
                                            <th class="text-center">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href= "#" data-target="#add" data-toggle="modal" class="btn btn-danger waves-effect waves-themed float-right" style="margin-right:7px;"><i class="fal fa-plus-square"></i> Add New Quota</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="add" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Add New Year and Quota </h5>
                    </div>
                    <div class="modal-body">
                    {!! Form::open(['action' => 'ComputerGrantController@addQuota', 'method' => 'POST']) !!}
                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span>Year</label>
                            <select class="custom-select form-control" name="year" id="year" required>
                                @for ($year = 2021; $year <= 2030; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                             </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span>Quota</label>
                            <select class="custom-select form-control" name="quota" id="quota" required>
                             @for ($quota = 100; $quota <= 500; $quota++)
                             <option value="{{ $quota }}">{{ $quota }}</option>
                             @endfor
                             </select>
                        </div>

                        <div class="footer">
                            <button type="submit" id="btn_search" class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i class="fal fa-save"></i> Add</button>
                            <button type="button" class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="card-header">
                        <h5 class="card-title w-100">Edit Year and Quota </h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'ComputerGrantController@editQuota', 'method' => 'POST']) !!}
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span>Year</label>
                            <select class="custom-select form-control" name="year" id="year" required>
                                @for ($year = 2021; $year <= 2030; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                             </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span>Quota</label>
                            <select class="custom-select form-control" name="quota" id="quota" required>
                             @for ($quota = 100; $quota <= 500; $quota++)
                                <option value="{{ $quota }}">{{ $quota }}</option>
                             @endfor
                             </select>
                        </div>

                        <div class="footer">
                            <button type="submit" id="btn_search" class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i class="fal fa-save"></i> Update</button>
                            <button type="button" class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
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

        $('#edit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') // data-id
        var year = button.data('year') // data-year
        var quota = button.data('quota') // data-quota

        $('.modal-body #id').val(id);
        $('.modal-body #year').val(year);
        $('.modal-body #quota').val(quota);

        });

        var table = $('#quotaList').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/getQuota",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'year', name: 'year' },
                    { className: 'text-center', data: 'quota', name: 'quota' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

</script>
@endsection
