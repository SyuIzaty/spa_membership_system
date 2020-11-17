@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-university'></i>Study Plan Management
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Study Plan <span class="fw-300"><i>List</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        
                        <table id="st_plan" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr class="bg-primary-50 text-center">
                                    <th style="width:30px">No</th>
                                    <th>Programme</th>
                                    <th>Study Mode</th>
                                    <th>Total Credit Hours</th>
                                    <th>Effective Semester</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme"></td>
                                    <td class="hasinput">
                                        <select id="sm" name="sm" class="form-control">
                                            <option value="">All</option>
                                            <option value="FT">Full Time</option>
                                            <option value="PT">Part Time</option>
                                        </select>
                                    </td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Hour"></td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Semester"></td>
                                    <td class="hasinput">
                                        <select id="course_status" name="course_status" class="form-control">
                                            <option value="">All</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </td>
                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                    <td class="hasinput"></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="javascript:;" data-toggle="modal" id="new" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add New Study Plan</a>
                    </div>
                </div>

                <div class="modal fade" id="crud-modal" aria-hidden="true" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="card-header">
                                <h5 class="card-title w-100">ADD NEW STUDY PLAN</h5>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'StudyPlanController@createPlan', 'method' => 'POST']) !!}

                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="plan_progs">Programme :</label></td>
                                        <td colspan="4">
                                            <select name="plan_progs" id="plan_progs" class="plan_progs form-control">
                                                <option value="">-- Select Programme --</option>
                                                @foreach ($program as $progs) 
                                                    <option value="{{ $progs->id }}" {{ old('plan_progs') ? 'selected' : '' }}>
                                                        {{ $progs->programme_name }}</option>
                                                @endforeach
                                             </select>
                                            @error('plan_progs')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>

                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="plan_sm">Study Mode :</label></td>
                                        <td colspan="4">
                                            <select name="plan_sm" id="plan_sm" class="plan_sm form-control">
                                                <option value="">-- Select Study Mode --</option>
                                                @foreach ($mode as $mod) 
                                                    <option value="{{ $mod->id }}" {{ old('plan_sm') ? 'selected' : '' }}>
                                                        {{ $mod->mode_name }}</option>
                                                @endforeach
                                             </select>
                                            @error('plan_sm')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>

                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="plan_stat">Status :</label></td>
                                        <td colspan="4">
                                            <select class="form-control" id="plan_stat" name="plan_stat">
                                                <option value="">-- Select Status --</option>
                                                <option value="1" {{ old('plan_stat') == '1' ? 'selected':''}} >Active</option>
                                                <option value="0" {{ old('plan_stat') == '0' ? 'selected':''}} >Inactive</option>
                                            </select>
                                            @error('plan_stat')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>

                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="plan_semester">Effective Semester :</label></td>
                                        <td colspan="4">
                                            <input value="{{ old('plan_semester') }}" class="form-control" id="plan_semester" name="plan_semester">
                                            @error('plan_semester')
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
        });

        $('#st_plan thead tr .hasinput').each(function(i)
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


        var table = $('#st_plan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/st_plan/list",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'plan_progs', name: 'plan_progs' },
                    { data: 'plan_sm', name: 'plan_sm' },
                    { data: 'plan_cr_hr_total', name: 'plan_cr_hr_total' },
                    { data: 'plan_semester', name: 'plan_semester'},
                    { data: 'plan_stat', name: 'plan_stat'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "desc" ]],
                "initComplete": function(settings, json) {

                } 
        });

        $('#st_plan').on('click', '.btn-delete[data-remote]', function (e) {
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
                        $('#st_plan').DataTable().draw(false);
                    });
                }
            })
        });

    });

</script>

@endsection
