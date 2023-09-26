@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-clone'></i> VOTER INFO MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        VOTER <span class="fw-300"><i>LIST</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                            </button>
                            <div class="d-flex align-items-center">
                                {{-- <div class="alert-icon width-8">
                                    <span class="icon-stack icon-stack-sm">
                                        <i class="base-2 icon-stack-3x color-danger-400"></i>
                                        <i class="base-10 text-white icon-stack-1x"></i>
                                        <i class="fal fa-info-circle color-danger-800 icon-stack-2x"></i>
                                    </span>
                                </div> --}}
                                <div class="flex-1 pl-1">
                                    All data are <b>CONFIDENTIAL</b> and strictly <b>PROHIBITED</b> from being accessed or shared with outsiders, third parties, or any unauthorized individuals.
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="list" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th style="width:30px">#VOTING ID</th>
                                        <th>VOTER ID</th>
                                        <th>VOTER NAME</th>
                                        <th>VOTER PROGRAMME</th>
                                        <th>CREATED DATE</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Id"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Programme"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Date"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                        <a href="/voting-setting/{{$candidate->programme->category->vote->id}}" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a>
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
        $('#list thead tr .hasinput').each(function(i)
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

        var id = "<?php echo $candidate->id; ?>";
        var table = $('#list').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-voter-list/"+ id,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'voter_id', name: 'voter_id' },
                    { className: 'text-center', data: 'voter_name', name: 'student.students_name' },
                    { className: 'text-center', data: 'voter_programme', name: 'programme.programme_name' },
                    { className: 'text-center', data: 'created_at', name: 'created_at' }
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

    });

</script>

@endsection
