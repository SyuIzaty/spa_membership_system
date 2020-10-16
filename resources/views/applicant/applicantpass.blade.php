@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Applicant Qualified
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Applicant Qualified</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="intake_pass" id="intake_pass"></div>
                            <table class="table table-bordered" id="pass">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>APPLICANT</th>
                                        <th>IC</th>
                                        <th>INTAKE</th>
                                        <th>SPONSOR CODE</th>
                                        <th>PROG 1</th>
                                        <th>PROG 2</th>
                                        <th>PROG 3</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Applicant Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Applicant IC"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Sponsor"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
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
        $('#pass thead tr .hasinput').each(function(i)
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

        var table = $('#pass').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_passapplicant",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'applicant_name', name: 'applicant_name' },
                    { data: 'applicant_ic', name: 'applicant_ic'},
                    { data: 'intake_id', name: 'intake_id'},
                    { data: 'sponsor_code', name: 'sponsor_code'},
                    { data: 'prog_name', name: 'prog_name' },
                    { data: 'prog_name_2', name: 'prog_name_2' },
                    { data: 'prog_name_3', name: 'prog_name_3' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                    var column = this.api().column(3);
                    var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $('#intake_pass').empty().text('Intake: ') )
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
