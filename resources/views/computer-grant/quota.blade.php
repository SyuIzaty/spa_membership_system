@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">

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
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Quota</th>
                                            <th class="text-center">Effective Date</th>
                                            <th class="text-center">Duration (Year)</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
                                            <td class="hasinput"></td>
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
                        <h5 class="card-title w-100">Add</h5>
                    </div>
                    <div class="modal-body">
                    {!! Form::open(['action' => 'ComputerGrantController@addQuota', 'method' => 'POST']) !!}

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Title</label>
                            <input type="text" id="title" name="title" class="form-control">
                            <span style="font-size: 10px; color: red;"><i>*Limit to 80 characters only</i></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="datepicker-modal-2"><span class="text-danger">*</span> Date Range</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fs-xl"><i class="fal fa-calendar"></i></span>
                                </div>
                                <input type="text" name="dates" class="form-control" placeholder="Select a date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Quota</label>
                            <select class="custom-select form-control" name="quota" id="quota" required>
                                @for ($quota = 100; $quota <= 500; $quota++)
                                <option value="{{ $quota }}">{{ $quota }}</option>
                                @endfor
                             </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Duration (Year)</label>
                            <select class="custom-select form-control" name="duration" id="duration" required>
                                @for ($duration = 1; $duration <= 10; $duration++)
                                <option value="{{ $duration }}">{{ $duration }}</option>
                                @endfor
                             </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Status</label>
                            <select class="custom-select form-control" name="status" id="status" required>
                                <option value="Y">Active</option>
                                <option value="N">Inactive</option>
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
                        <h5 class="card-title w-100">Edit</h5>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'ComputerGrantController@editQuota', 'method' => 'POST']) !!}
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Title</label>
                            <input type="text" id="title" name="title" class="form-control">
                            <span style="font-size: 10px; color: red;"><i>*Limit to 80 characters only</i></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="datepicker-modal-2"><span class="text-danger">*</span> Date Range</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fs-xl"><i class="fal fa-calendar"></i></span>
                                </div>
                                <input type="text" name="dates" id="date" class="form-control" placeholder="Select a date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Quota</label>
                            <select class="custom-select form-control" name="quota" id="quota" required>
                             @for ($quota = 100; $quota <= 500; $quota++)
                                <option value="{{ $quota }}">{{ $quota }}</option>
                             @endfor
                             </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Duration (Year)</label>
                            <select class="custom-select form-control" name="duration" id="duration" required>
                                @for ($duration = 1; $duration <= 10; $duration++)
                                <option value="{{ $duration }}">{{ $duration }}</option>
                                @endfor
                             </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><span class="text-danger">*</span> Status</label>
                            <select class="custom-select form-control" name="status" id="status" required>
                                <option value="Y">Active</option>
                                <option value="N">Inactive</option>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $('input[name="dates"]').daterangepicker();

    $(document).ready(function()
    {

        $('#edit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id')
        var title = button.data('title')
        var quota = button.data('quota')
        var date = button.data('dates')
        var duration = button.data('duration')
        var status = button.data('status')

        $('.modal-body #id').val(id);
        $('.modal-body #title').val(title);
        $('.modal-body #quota').val(quota);
        $('.modal-body #date').val(date);
        $('.modal-body #duration').val(duration);
        $('.modal-body #status').val(status);


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
                    { className: 'text-center', data: 'title', name: 'title' },
                    { className: 'text-center', data: 'quota', name: 'quota' },
                    { className: 'text-center', data: 'effective_date', name: 'effective_date' },
                    { className: 'text-center', data: 'duration', name: 'duration' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

    //limit word in textarea
    jQuery(document).ready(function($) {
        var max = 80;
        $('#title').keypress(function(e) {
            if (e.which < 0x20) {
                // e.which < 0x20, then it's not a printable character
                // e.which === 0 - Not a character
                return;     // Do nothing
            }
            if (this.value.length == max) {
                e.preventDefault();
            } else if (this.value.length > max) {
                // Maximum exceeded
                this.value = this.value.substring(0, max);
            }
        });
    }); //end if ready(fn)

</script>
@endsection
