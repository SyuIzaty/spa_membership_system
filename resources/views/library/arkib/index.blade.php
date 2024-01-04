@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Arkib
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>List of Arkib Paper</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-12">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                                </div>
                      
                                <div class="col-md-12">
                                  <table class="table table-bordered" id="paper" style="width:100%">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                          <th>ID</th>
                                          <th>Title</th>
                                          <th>File Classification No</th>
                                          <th>Department</th>
                                          <th>Date</th>
                                          <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search File Classification No"></td>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
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
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
    $('#new').click(function () {
        $('#crud-modal').modal('show');
    });

    $('#department_code, #status').select2({
        dropdownParent: $('#crud-modal')
    });

    $(document).ready(function()
    {
        $('#paper thead tr .hasinput').each(function(i)
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
        
    
        var table = $('#paper').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_userarkib",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'id', name: 'id'},
                    { data: 'title', name: 'title'},
                    { data: 'file_classification_no', name: 'file_classification_no'},
                    { data: 'dept', name: 'department.name'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {
    
    
                }
        });

    });
</script>
@endsection
