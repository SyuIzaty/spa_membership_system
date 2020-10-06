@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Applicant
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Applicant</h2>
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
                                        <th style="width: 1%">NO</th>
                                        <th style="width: 5%">STUDENT ID</th>
                                        <th style="width: 15%">APPLICANT</th>
                                        <th>INTAKE</th>
                                        <th style="width: 5%">PROG 1</th>
                                        <th style="width: 5%">PROG 2</th>
                                        <th style="width: 5%">PROG 3</th>
                                        <th style="width: 5%">BM</th>
                                        <th style="width: 5%">ENG</th>
                                        <th style="width: 5%">MATH</th>
                                        <th style="width: 50%">ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Student ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Applicant Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Bahasa Melayu"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search English"></td>
                                        <td class="hasinput" style="width: 2px"><input type="text" class="form-control" placeholder="Search Mathematics"></td>
                                        <td style="width: 50px"></td>
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
            ajax: {
                url: "/data_offerapplicant",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'student_id', name: 'student_id' },
                    { data: 'applicant_name', name: 'applicant_name' },
                    { data: 'intake_id', name: 'intake_id', visible:false },
                    { data: 'prog_name', name: 'prog_name' },
                    { data: 'prog_name_2', name: 'prog_name_2' },
                    { data: 'prog_name_3', name: 'prog_name_3' },
                    { data: 'bm', name: 'bm' },
                    { data: 'english', name: 'english' },
                    { data: 'math', name: 'math' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                    var column = this.api().column(3);
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
