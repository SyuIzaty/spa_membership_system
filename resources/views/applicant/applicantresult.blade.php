@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Pending Application
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Pending Application</h2>
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
                            @can('check requirement')
                            <form action="{{ route('applicant-check') }}" method="post" name="form">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="intake_fail" class="mb-3 col-md-12 float-left"></div>
                                            <span id="sponsor" class="mb-3 col-md-12 float-left"></span>
                                        </div>
                                    </div>
                                            {{-- <button type="button" class="btn btn-success float-right" onclick="window.location='{{ route("check-requirements") }}'">Check All</button>
                                            <button type="submit" class="btn btn-primary float-right mr-2">Check Multiple</button> --}}
                                    @endcan
                                    <table class="table table-bordered" id="applicant">
                                        <thead>
                                            <tr class="bg-primary-50 text-center">
                                                <th></th>
                                                <th>NO</th>
                                                <th>APPLICANT</th>
                                                <th>IC</th>
                                                <th>INTAKE</th>
                                                <th>SPONSOR CODE</th>
                                                <th>PROG 1</th>
                                                <th>PROG 2</th>
                                                <th>PROG 3</th>
                                                <th></th>
                                                <th></th>
                                                <th>ACTION</th>
                                            </tr>
                                            <tr>
                                                <td class="hasinput"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Applicant Name"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Applicant IC"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Sponsor"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme"></td>
                                                <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                                        <button type="button" class="btn btn-success ml-auto mr-2" onclick="window.location='{{ route("check-requirements") }}'"><i class="fal fa-check-circle"></i> Run All</button>
                                        <button type="submit" class="btn btn-primary float-right mr-2"><i class="fal fa-check"></i> Run Selected</button>
                                        <button type="button" class="btn btn-success float-right" onclick="window.location='{{ route("jpa-reminder") }}'"><i class="fal fa-check-circle"></i> Email Sponsor Applicant</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-danger">** Run All: All applicants</div>
                                        <div class="col-md-12 text-danger">** Run Selected: Selected applicants</div>
                                        <div class="col-md-12 text-danger">** Email Sponsor Applicant: Email Sponsor applicants</div>
                                    </div>
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
        $(function(){
            $('.select2').select2();
            showdefault();
        });

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
            columnDefs: [{ "visible": false,"targets":[9]}, { "visible": false,"targets":[10]}],
            columns: [
                    { data: 'checkone', name: 'checkone', orderable: false, searchable: false},
                    { data: 'id', name: 'id' },
                    { data: 'applicant_name', name: 'applicant_name' },
                    { data: 'applicant_ic', name: 'applicant_ic' },
                    { data: 'intake_id', name: 'intake_id' },
                    { data: 'sponsor_code', name: 'sponsor_code' },
                    { data: 'prog_name', name: 'prog_name' },
                    { data: 'prog_name_2', name: 'prog_name_2' },
                    { data: 'prog_name_3', name: 'prog_name_3' },
                    // { data: 'bm', name: 'bm' },
                    // { data: 'english', name: 'english' },
                    // { data: 'math', name: 'math' },
                    { data: 'applicant_intake.intake_app_close' },
                    { data: 'applicant_intake.intake_app_open' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                    var column = this.api().column(4);
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
                            .column(4)
                            .search(selected ? selected : '', true, false).draw();
                        }
                    });

                    @foreach($intakecode as $key => $ic)
                    select.append('<option value="{{ $ic["intake_code"] }}" <?php if($ic["intake_app_close"] >= now() && $ic["intake_app_open"] <= now()) echo "selected" ?> >{{ $ic["intake_code"] }}</option>' );
                    @endforeach
                    $('#filterselect').select2();

                    var column = this.api().column(5);
                    var select = $('<select class="form-control"><option value=""></option></select>')
                    .appendTo( $('#sponsor').empty().text('Sponsor: ') )
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
        function showdefault()
        {
            var value = [];
            @foreach($intakecode as $ic)
              if( "{{ $ic["intake_app_close"] }}" >= "{{ now() }}" && "{{ $ic["intake_app_open"] }}" <= "{{ now() }}" )
              {
                value.push("{{ $ic["intake_code"] }}");
              }
            @endforeach

            table
            .column(9)
            .search("1",true,false)
            .column(4)
            .search(value ? value.join('|') : '', true, false)
            .draw();
        }
    });

</script>
@endsection
