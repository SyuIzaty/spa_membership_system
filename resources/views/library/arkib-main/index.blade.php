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
                                <div class="col-sm-4 col-xl-4">
                                    <div class="p-3 bg-primary-100 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $total }}
                                                <small class="m-0 l-h-n">TOTAL UPLOAD</small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-cube position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xl-4">
                                    <div class="p-3 bg-primary-100 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $publish }}
                                                <small class="m-0 l-h-n">PUBLISH</small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-cube position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xl-4">
                                    <div class="p-3 bg-primary-100 rounded overflow-hidden position-relative text-white mb-g">
                                        <div class="">
                                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                                {{ $draft }}
                                                <small class="m-0 l-h-n">UNPUBLISH</small>
                                            </h3>
                                        </div>
                                        <i class="fal fa-cube position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                    </div>
                                </div>
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
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#publish" role="tab">
                                                <i class="fal fa-check text-primary"></i>
                                                <span class="hidden-sm-down ml-1">Published</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#draft" role="tab">
                                                <i class="fal fa-times text-primary"></i>
                                                <span class="hidden-sm-down ml-1">Unpublished</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane active" id="publish" role="tabpanel">
                                        <div class="table-responsive mt-2">
                                            <table class="table table-bordered" id="paper" style="width:100%">
                                              <thead>
                                                  <tr class="bg-primary-50 text-center">
                                                      <th>TITLE</th>
                                                      <th>DESCRIPTION</th>
                                                      <th>DEPARTMENT</th>
                                                      <th>STATUS</th>
                                                      <th>DATE</th>
                                                      <th>ACTION</th>
                                                  </tr>
                                                  <tr>
                                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Description"></td>
                                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Status"></td>
                                                      <td class="hasinput"><input type="text" class="form-control" placeholder="Search Date"></td>
                                                      <td></td>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="draft" role="tabpanel">
                                        <div class="table-responsive mt-2">
                                            <table class="table table-bordered" id="draft_paper" style="width:100%">
                                              <thead>
                                                <tr class="bg-primary-50 text-center">
                                                    <th>TITLE</th>
                                                    <th>DESCRIPTION</th>
                                                    <th>DEPARTMENT</th>
                                                    <th>STATUS</th>
                                                    <th>DATE</th>
                                                    <th>ACTION</th>
                                                </tr>
                                                <tr>
                                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Title"></td>
                                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Description"></td>
                                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Department"></td>
                                                    <td class="hasinput"><input type="text" class="form-control" placeholder="Search Status"></td>
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
                            <div class="py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex float-right">
                                <a class="btn btn-primary float-right btn-sm" href="javascript:;" data-toggle="modal" id="new">New Arkib</a>
                            </div>
                        </div>
                        <div class="modal fade" id="crud-modal" aria-hidden="true" >
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"> New Arkib</h4>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::open(['action' => 'Library\Arkib\ArkibMainController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Department</td>
                                                <td>
                                                    <select class="form-control" name="department_code" id="department_code">
                                                        <option disabled selected>Please Select</option>
                                                        @foreach($department as $departments)
                                                        <option value="{{ $departments->department_code }}" {{ old('department_code') ? 'selected' : '' }}>
                                                            {{ $departments->department_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Title</td>
                                                <td><input type="text" class="form-control" name="title" value="{{ old('title') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>Description</td>
                                                <td><input type="text" class="form-control" name="description" value="{{ old('description') }}"></td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    <select class="form-control" name="status" id="status">
                                                        <option disabled selected>Please Select</option>
                                                        @foreach($status as $statuses)
                                                        <option value="{{ $statuses->arkib_status }}" {{ old('status') ? 'selected' : '' }}>
                                                            {{ $statuses->arkib_description }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Attachment(s)</td>
                                                <td>
                                                    <input type="file" name="arkib_attachment[]" multiple required>
                                                </td>
                                            </tr>
                                        </table>
                                        <button class="btn btn-success btn-sm float-right mb-2">Submit</button>
                                        <button type="button" class="btn btn-secondary btn-sm float-right mr-2 text-white" data-dismiss="modal">Close</button>
                                        {!! Form::close() !!}
                                    </div>
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
            stateSave: true,
            ajax: {
                url: "/data_publishedarkib",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'title', name: 'title'},
                    { data: 'description', name: 'description'},
                    { data: 'dept', name: 'department.department_name'},
                    { data: 'stat', name: 'arkibStatus.arkib_description'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
    
    
                }
        });
    
        $('#draft_paper thead tr .hasinput').each(function(i)
        {
            $('input', this).on('keyup change', function()
            {
                if (table_draft.column(i).search() !== this.value)
                {
                    table_draft
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    
    
        var table_draft = $('#draft_paper').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/data_draftarkib",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { data: 'title', name: 'title'},
                    { data: 'description', name: 'description'},
                    { data: 'dept', name: 'department.department_name'},
                    { data: 'stat', name: 'arkibStatus.arkib_description'},
                    { data: 'created_at', name: 'created_at'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {
    
    
                }
        });

    });

    
    $('#paper').on('click', '.btn-delete[data-remote]', function (e) {
      e.preventDefault();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var url = $(this).data('remote');
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.value) {
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
              url: url,
              type: 'DELETE',
              dataType: 'json',
              data: {method: '_DELETE', submit: true}
              }).always(function (data) {
                $('#paper').DataTable().draw(false);
              });
          }
      })
    });

    $('#draft_paper').on('click', '.btn-delete2[data-remote]', function (e) {
      e.preventDefault();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var url = $(this).data('remote');
      Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
          if (result.value) {
              var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
              $.ajax({
              url: url,
              type: 'DELETE',
              dataType: 'json',
              data: {method: '_DELETE', submit: true}
              }).always(function (data) {
                $('#draft_paper').DataTable().draw(false);
              });
          }
      })
    });
</script>
@endsection
