@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Venue
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Manage Venue</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
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
                            <table class="table table-bordered" id="year_table">
                              <thead>
                                  <tr class="bg-primary-50 text-center">
                                      <th>ID</th>
                                      <th>VENUE</th>
                                      <th>MAXIMUM</th>
                                      <th>OPEN TO STUDENT</th>
                                      <th>STATUS</th>
                                      <th>DEPARTMENT</th>
                                      <th>ACTION</th>
                                  </tr>
                                  <tr id="filterRow">
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th class="hasInputFilter"></th>
                                    <th><button id="resetFilter" class="btn btn-block btn-outline-danger"><i class="bx bx-block font-size-16 align-middle me-2"></i>Clear All Filter</button></th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                            <a class="btn btn-success btn-sm float-right mb-2 mt-2" href="javascript:;" data-toggle="modal" id="new">Add Venue</a>
                          </div>
                        </div>

                        <div class="modal fade" id="crud-modal" aria-hidden="true" >
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title"> Add Venue</h4>
                                  </div>
                                  <div class="modal-body">
                                      {!! Form::open(['action' => 'Space\VenueDetailController@store', 'method' => 'POST']) !!}
                                      <table class="table table-bordered">
                                        <tr>
                                          <td>Venue <span class="text-danger">*</span></td>
                                          <td><input type="text" class="form-control" name="name"></td>
                                        </tr>
                                        <tr>
                                          <td>Description <span class="text-danger">*</span></td>
                                          <td><input type="text" class="form-control" name="description"></td>
                                        </tr>
                                        <tr>
                                          <td>Maximum <span class="text-danger">*</span></td>
                                          <td><input type="number" class="form-control" name="maximum"></td>
                                        </tr>
                                        <tr>
                                          <td>Open to Student <span class="text-danger">*</span></td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="open_student" id="store_open">
                                              <label class="custom-control-label" for="store_open"></label>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Department <span class="text-danger">*</span></td>
                                          <td>
                                            <select class="form-control" name="department_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($department as $departments)
                                              <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Status</td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="status" id="store_status">
                                              <label class="custom-control-label" for="store_status"></label>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Sent Email?</td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="email_sent" id="store_email">
                                              <label class="custom-control-label" for="store_email"></label>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Email to</td>
                                          <td>
                                            <select class="form-control" name="staff_id[]" id="staff_id" multiple>
                                              @foreach($staff as $staffs)
                                              <option value="{{ $staffs->staff_id }}">{{ $staffs->staff_name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                      </table>
                                      <button class="btn btn-success btn-sm float-right">Submit</button>
                                      {!! Form::close() !!}
                                  </div>
                              </div>
                          </div>
                        </div>
                        <div class="modal fade editModal" id="editModal" aria-hidden="true" >
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title">Update Venue</h4>
                                  </div>
                                  {!! Form::open(['action' => ['Space\VenueDetailController@update', '1'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                  <input type="hidden" name="venue_id" id="venue_id">
                                  <div class="modal-body">
                                      <table class="table table-bordered">
                                        <tr>
                                          <td>Name <span class="text-danger">*</span></td>
                                          <td><input type="text" class="form-control" name="name" id="name"></td>
                                        </tr>
                                        <tr>
                                          <td>Description <span class="text-danger">*</span></td>
                                          <td><input type="text" class="form-control" name="description" id="description"></td>
                                        </tr>
                                        <tr>
                                          <td>Maximum <span class="text-danger">*</span></td>
                                          <td><input type="number" class="form-control" name="maximum" id="maximum"></td>
                                        </tr>
                                        <tr>
                                          <td>Open to Student <span class="text-danger">*</span></td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="open_student" id="open_student">
                                              <label class="custom-control-label" for="open_student"></label>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Department <span class="text-danger">*</span></td>
                                          <td>
                                            <select class="form-control" name="department_id" id="department_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($department as $departments)
                                              <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Status</td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="status" id="status">
                                              <label class="custom-control-label" for="status"></label>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Sent Email?</td>
                                          <td>
                                            <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" name="email_sent" id="email_sent">
                                              <label class="custom-control-label" for="email_sent"></label>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Email to</td>
                                          <td>
                                            <select class="form-control" name="staff_id[]" id="staff_id2" multiple>
                                            </select>
                                          </td>
                                        </tr>
                                      </table>
                                  </div>
                                  <div class="modal-footer">
                                      <button class="btn btn-success btn-sm float-right">Update</button>
                                      <button type="button" class="btn btn-secondary btn-sm text-white" data-dismiss="modal">Close</button>
                                  </div>
                                  {{Form::hidden('_method', 'PUT')}}
                                  {!! Form::close() !!}
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

  $('#staff_id').select2({
      dropdownParent: $('#crud-modal')
  });

  $('#staff_id2').select2({
      dropdownParent: $('.editModal')
  });

  $(document).ready(function() {
      var table = $('#year_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: false,
        ajax: {
            url: window.location.href,
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 200, "All"]],
        iDisplayLength: 10,
        columns: [
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'maximum', name: 'maximum'},
                { data: 'open_to_student', name: 'openStudent.name'},
                {
                data: 'venue_status',
                name: 'spaceStatus.name',
                  render: function (data) {
                      badge = 'info';
                      if (data == 'Inactive') {
                          badge = 'danger';
                      } else if(data == 'Active') {
                          badge = 'success';
                      }
                      return '<span class="badge badge-' + badge + '">' + data + '</span>';
                  }
                },
                { data: 'department_name', name: 'departmentList.name'},
                { data: 'action'},
            ],
        order: [[ 0, "asc" ]],
        orderCellsTop: true,
        dom:"tpr",
        initComplete: function () {
          $("#year_table thead #filterRow .hasInputFilter").each( function ( i ) {
              var colIdx = $(this).index();
              var input = $('<input class="form-control" type="text">')
                  .appendTo( $(this).empty() )
                  .on( 'keyup', function () {
                      table.column(colIdx)
                          .search( $(this).val() )
                          .draw();
                  } );

          } );
        }
      });

      $.ajaxSetup({
        headers:{
        'X-CSRF-Token' : $("input[name=_token]").val()
        }
      });

      $(document).on('click', '.edit_data', function(){
        var id = $(this).attr("data-id");
        $.ajax({
            url: '{{ url("get-venue-detail") }}',
            method:"POST",
            data:{id:id},
            dataType:"json",
            success:function(data){
                $('#venue_id').val(data.id);
                $('#name').val(data.name);
                $('#description').val(data.description);
                $('#maximum').val(data.maximum);
                $('#department_id').val(data.department_id);

                if(data.status == 1){
                  $('#status').prop('checked', true);
                } if(data.status != 1) {
                  $('#status').prop('checked', false);
                }

                if(data.email_sent == 1){
                  $('#email_sent').prop('checked', true);
                } if(data.email_sent != 1) {
                  $('#email_sent').prop('checked', false);
                }

                if(data.open_student == 7){
                  $('#open_student').prop('checked', true);
                }if(data.open_student != 7) {
                  $('#open_student').prop('checked', false);
                }
                $('.editModal').modal('show');
            }
        });

        $.ajax({
            type: 'GET',
            url: "{{url('/get-venue-email')}}/" + id,
            success: function (respond) {
                $('#staff_id2').empty();
                respond.interest.forEach(function(ele){
                    $('#staff_id2').append(`<option value="${ele.staff_id}">${ele.staff_id} - ${ele.staff_name}</option>
                    `);
                });
                $('#staff_id2').val(respond.offer);
            }
        });
      });
  });

  $('#year_table').on('click', '.btn-delete[data-remote]', function (e) {
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
                $('#year_table').DataTable().draw(false);
            });
        }
    })
  });
</script>
@endsection
