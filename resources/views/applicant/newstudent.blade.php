@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Offered Programme
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Offered Programme</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <span id="intake_fail"></span>
                            <table class="table table-bordered" id="rejected">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>STUDENT ID</th>
                                        <th>APPLICANT NAME</th>
                                        <th>APPLICANT IC</th>
                                        <th>PROGRAMME CODE</th>
                                        <th>MAJOR CODE</th>
                                        <th>BATCH CODE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    <tr>
                                        {{-- <td class="hasinput"><input type="text" class="form-control" placeholder="Search Intake"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Batch Code"></td>
                                        <td></td> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applicant as $applicants)
                                        <tr>
                                            <td>{{ $applicants->id }}</td>
                                            <td>{{ $applicants->student_id }}</td>
                                            <td>{{ $applicants->applicant_name }}</td>
                                            <td>{{ $applicants->applicant_ic }}</td>
                                            <td>{{ $applicants->offered_programme }}</td>
                                            <td>{{ $applicants->offered_major }}</td>
                                            <td>{{ $applicants->batch_code }}</td>
                                        </tr>
                                    @endforeach
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
{{-- <script>


    $(document).ready(function()
    {
        $('#rejected thead tr .hasinput').each(function(i)
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

        var table = $('#rejected').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_newstudent",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'applicant_name', name: 'applicant_name'},
                    { data: 'applicant_ic', name: 'applicant_ic' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });
    });


</script> --}}
@endsection
