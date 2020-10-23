@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Physical Registration
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Physical Registration</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <span id="intake_fail"></span>
                            @csrf
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <table class="table table-bordered" id="newstudent">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
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
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Student ID"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Student Name"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Student IC"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Programme Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Major Code"></td>
                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Batch Code"></td>
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

        var table = $('#newstudent').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_newstudent",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id' },
                    { data: 'student_id', name: 'student_id' },
                    { data: 'applicant_name', name: 'applicant_name'},
                    { data: 'applicant_ic', name: 'applicant_ic' },
                    { data: 'offered_programme', name: 'offered_programme' },
                    { data: 'offered_major', name: 'offered_major' },
                    { data: 'batch_code', name: 'batch_code' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
                }
        });
    });


</script>
@endsection
