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
                            @can('check requirement')
                            <form action="{{ route('applicant-check') }}" method="post" name="form">
                                @csrf
                                    <button type="button" class="btn btn-info pull-right" onclick="window.location='{{ route("check-requirements") }}'">Check All</button>
                                    <button type="submit" class="btn btn-primary pull-right"><i class="fal fa-user"></i> Check Multiple</button>
                                    @endcan
                                    <div class="intake_pass" id="intake_all"></div>
                                    <table class="table table-bordered" id="applicant">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>APPLICANT</th>
                                                <th>IC</th>
                                                <th>INTAKE</th>
                                                <th>PROG 1</th>
                                                <th>PROG 2</th>
                                                <th>PROG 3</th>
                                                <th>BM</th>
                                                <th>ENG</th>
                                                <th>MATH</th>
                                                <th>ACTION</th>
                                            </tr>
                                            <tr>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Applicant Name"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Applicant IC"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Name"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Bahasa Melayu"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search English"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Mathematics"></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                            {{-- <div class="tab-pane" role="tabpanel" id="accepted_all">
                                <table class="table table-bordered" id="accepted">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>STUDENT ID</th>
                                            <th>APPLICANT</th>
                                            <th>INTAKE</th>
                                            <th>PROG 1</th>
                                            <th>PROG 2</th>
                                            <th>PROG 3</th>
                                            <th>BM</th>
                                            <th>ENG</th>
                                            <th>MATH</th>
                                            <th>ACTION</th>
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
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Mathematics"></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div> --}}
                            </form>
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
        $('#applicant thead tr .hasinput').each(function(i)
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

        var table = $('#applicant').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_allapplicant",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'applicant_name', name: 'applicant_name' },
                    { data: 'applicant_ic', name: 'applicant_ic' },
                    { data: 'intake_id', name: 'intake_id' },
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
                    var column = this.api().column(2);
                    var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $('#intake_all').empty().text('Intake: ') )
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


    // $(document).ready(function()
    // {
    //     $('#accepted thead tr .hasinput').each(function(i)
    //     {
    //         $('input', this).on('keyup change', function()
    //         {
    //             if (table.column(i).search() !== this.value)
    //             {
    //                 table
    //                     .column(i)
    //                     .search(this.value)
    //                     .draw();
    //             }
    //         });

    //         $('select', this).on('keyup change', function()
    //         {
    //             if (table.column(i).search() !== this.value)
    //             {
    //                 table
    //                     .column(i)
    //                     .search(this.value)
    //                     .draw();
    //             }
    //         });
    //     });

    //     var table = $('#accepted').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             url: "/data_acceptedapplicant",
    //             type: 'POST',
    //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    //         },
    //         columns: [
    //                 { data: 'applicant_id', name: 'applicant_id' },
    //                 { data: 'student_id', name: 'student_id' },
    //                 { data: 'applicant_name', name: 'applicant_name' },
    //                 { data: 'intake_id', name: 'intake_id' },
    //                 { data: 'prog_name', name: 'prog_name' },
    //                 { data: 'prog_name_2', name: 'prog_name_2' },
    //                 { data: 'prog_name_3', name: 'prog_name_3' },
    //                 { data: 'bm', name: 'bm' },
    //                 { data: 'english', name: 'english' },
    //                 { data: 'math', name: 'math' },
    //                 { data: 'action', name: 'action', orderable: false, searchable: false}
    //             ],
    //             orderCellsTop: true,
    //             "order": [[ 1, "asc" ]],
    //             "initComplete": function(settings, json) {

    //             }
    //     });
    // });

</script>
@endsection
