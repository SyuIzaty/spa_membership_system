@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Applicant Offer
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Applicant Offer</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <span id="intake"></span>
                            <table class="table table-bordered" id="offer">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>STUDENT ID</th>
                                        <th>APPLICANT</th>
                                        <th>IC</th>
                                        <th>INTAKE</th>
                                        <th>SPONSOR</th>
                                        <th>BATCH</th>
                                        <th>PROG</th>
                                        <th>MAJOR</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Student ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="IC"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Intake"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Sponsor"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Batch"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Programme"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Major"></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
        $('#offer thead tr .hasinput').each(function(i)
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
        });

        var table = $('#offer').DataTable({
            processing: true,
            serverSide: true,
            autowidth: false,
            ajax: {
                url: "/data_offerapplicant",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'student_id', name: 'student_id' },
                    { data: 'applicant_name', name: 'applicant_name' },
                    { data: 'applicant_ic', name: 'applicant_ic' },
                    { data: 'intake_id', name: 'intake_id' },
                    { data: 'sponsor_code', name: 'sponsor_code' },
                    { data: 'batch_code', name: 'batch_code' },
                    { data: 'offered_programme', name: 'offered_programme' },
                    { data: 'offered_major', name: 'offered_major' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                    var column = this.api().column(4);
                    var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $('#intake').empty().text('Intake: ') )
                    .on('change',function(){
                        var val = $.fn.DataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                        .search(val ? '^'+val+'$' : '', true, false).draw();
                    });
                    column.data().unique().sort().each(function (d, j){
                        select.append( '<option value="'+d+'">'+d+'</option>' );
                    });
                }
        });

    });

</script>
@endsection
