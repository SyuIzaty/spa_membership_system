@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-folder-open'></i>TRAINING EVALUATION REPORT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        EVALUATION REPORT<span class="fw-300"><i> LIST</i></span>
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
                            <table id="report" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="text-center bg-primary-50" style="white-space: nowrap">
                                        <th>NO.</th>
                                        <th>#ID</th>
                                        <th>TRAINING TITLE</th>
                                        <th>TRAINING DATE</th>
                                        <th>TYPE</th>
                                        <th>PARTICIPANT</th>
                                        <th>RESPONDANT</th>
                                        <th>SUBMIT PERCENTAGE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Type"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Participant"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Respondant"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Percentage"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </thead>
                            </table>
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
        $('#report thead tr .hasinput').each(function(i)
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

        var table = $('#report').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data-evaluation-report",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { className: 'text-center', data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { className: 'text-center', data: 'start_date', name: 'start_date' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'participant', name: 'evaluation' },
                    { className: 'text-center', data: 'respondant', name: 'evaluation' },
                    { className: 'text-center', data: 'percentage', name: 'evaluation' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                } 
        });

    });
</script>

@endsection
