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
                            @if(session()->has('message'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{ session()->get('message') }}</strong>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="intake_fail" class="mb-3 col-md-12 float-left"></div>
                                </div>
                            </div>
                            <table class="table table-bordered" id="offer">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>NO</th>
                                        <th></th>
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
                                        <td></td>
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
        $(function(){
            $('.select2').select2();
            showdefault();
        });

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
            columnDefs: [{ "visible": false,"targets":[1]}],
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'applicant_intake.status' },
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
                    var column = this.api().column(5);
                    var select = $('<select id="filterselect" class="select2 form-control" multiple></select>')
                    .appendTo( $('#intake_fail').empty().text('Intake: ') )
                    .on('change',function(){
                        // var val = $.fn.DataTable.util.escapeRegex(
                        //     $(this).val()
                        // );
                        var selected = $(this).val().join('|');
                        if(selected)
                        {
                            table
                            .columns()
                            .search( '' )
                            .column(5)
                            .search(selected ? selected : '', true, false).draw();
                        }
                    });

                    @foreach($intakecode as $key => $ic)
                    select.append('<option value="{{ $ic["intake_code"] }}" <?php if($ic["status"] == "1") echo "selected" ?> >{{ $ic["intake_code"] }}</option>' );
                    @endforeach
                    $('#filterselect').select2();
                }
        });

        function showdefault()
        {
            var value = [];
            @foreach($intakecode as $ic)
              if( "{{ $ic["status"] }}" == "1")
              {
                value.push("{{ $ic["intake_code"] }}");
              }
            @endforeach

            table
            .column(1)
            .search("1",true,false)
            .column(5)
            .search(value ? value.join('|') : '', true, false)
            .draw();
        }

    });

</script>
@endsection
