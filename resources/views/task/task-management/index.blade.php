@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Task Management
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Task Calendar</h2>
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
                            <div class="row">
                              <div class="col-md-12">
                                <button class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#taskModal">Add Task</button>
                              </div>
                            </div>
                            <div class="row">
                              <div id="calendar" class="col-md-9"></div>
                              <div id="taskDetails" class="col-md-3 overflow-auto" style="max-height: 700px;"></div>
                            </div>

                            <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    {!! Form::open(['action' => 'Task\TaskManagement\TaskCalendarController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <table class="table table-bordered">
                                      <tr>
                                        <td style="width: 20%">Category <span class="text-danger">*</span></td>
                                        <td style="width: 80%" colspan="3">
                                          <select class="form-control select" name="category">
                                            <option disabled selected>Please Select</option>
                                            @foreach($category as $categories)
                                              <option value="{{ $categories->id }}" {{ old('category') ==  $categories->id  ? 'selected' : '' }}>{{ $categories->name }}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">Sub category <span class="text-danger">*</span></td>
                                        <td style="width: 80%" colspan="3"><input type="text" class="form-control" name="sub_category" value="{{ old('sub_category') }}"></td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">Type <span class="text-danger">*</span></td>
                                        <td style="width: 30%">
                                          <select class="form-control select" name="type">
                                            <option disabled selected>Please Select</option>
                                            @foreach($type as $types)
                                              <option value="{{ $types->id }}" {{ old('type') ==  $types->id  ? 'selected' : '' }}>{{ $types->name }}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                        <td style="width: 20%">Department <span class="text-danger">*</span></td>
                                        <td style="width: 30%">
                                          <select class="form-control select" name="department">
                                            <option disabled selected>Please Select</option>
                                            @foreach($department as $departments)
                                              <option value="{{ $departments->id }}" {{ old('department') ==  $departments->id  ? 'selected' : '' }}>{{ $departments->name }}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">Progress <span class="text-danger">*</span></td>
                                        <td style="width: 30%">
                                          <select class="form-control select" name="progress">
                                            <option disabled selected>Please Select</option>
                                            @foreach($status->where('category','Progress') as $statuses)
                                              <option value="{{ $statuses->id }}" {{ old('progress') ==  $statuses->id  ? 'selected' : '' }}>{{ $statuses->name }}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                        <td style="width: 20%">Priority <span class="text-danger">*</span></td>
                                        <td style="width: 30%">
                                          <select class="form-control select" name="priority">
                                            <option disabled selected>Please Select</option>
                                            @foreach($status->where('category','Priority') as $statuses)
                                              <option value="{{ $statuses->id }}" {{ old('priority') ==  $statuses->id  ? 'selected' : '' }}>{{ $statuses->name }}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">Start Date <span class="text-danger">*</span></td>
                                        <td style="width: 30%"><input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}"></td>
                                        <td style="width: 20%">End Date <span class="text-danger">*</span></td>
                                        <td style="width: 30%"><input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}"></td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">PIC <span class="text-danger">*</span></td>
                                        <td style="width: 80%" colspan="3">
                                          <select class="form-control select" name="user_id[]" multiple>
                                            @foreach($user as $users)
                                              <option value="{{ $users->id }}">{{ $users->short_name }}</option>
                                            @endforeach
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">Detail</td>
                                        <td style="width: 80%" colspan="3"><input type="text" class="form-control" name="detail" value="{{ old('detail') }}"></td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">Comment</td>
                                        <td style="width: 80%" colspan="3"><input type="text" class="form-control" name="comment" value="{{ old('comment') }}"></td>
                                      </tr>
                                      <tr>
                                        <td style="width: 20%">Email PIC?</td>
                                        <td style="width: 80%" colspan="3"><input type="checkbox" name="sent_email"></td>
                                      </tr>
                                    </table>
                                    <button class="btn btn-success float-right btn-sm">Submit</button>
                                    {!! Form::close() !!}
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="modal fade editModal" id="editModal" aria-hidden="true" >
                              <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Update Task</h4>
                                    </div>
                                    {!! Form::open(['action' => ['Task\TaskManagement\TaskCalendarController@update', '1'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <input type="hidden" name="task_id" id="task_id">
                                    <div class="modal-body">
                                      <table class="table table-bordered">
                                        <tr>
                                          <td style="width: 20%">Category <span class="text-danger">*</span></td>
                                          <td style="width: 80%" colspan="3">
                                            <select class="form-control" name="category" id="category">
                                              <option disabled selected>Please Select</option>
                                              @foreach($category as $categories)
                                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">Sub category <span class="text-danger">*</span></td>
                                          <td style="width: 80%" colspan="3"><input type="text" class="form-control" name="sub_category" id="sub_category"></td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">Type <span class="text-danger">*</span></td>
                                          <td style="width: 30%">
                                            <select class="form-control" name="type" id="type_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($type as $types)
                                                <option value="{{ $types->id }}">{{ $types->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                          <td style="width: 20%">Department <span class="text-danger">*</span></td>
                                          <td style="width: 30%">
                                            <select class="form-control" name="department" id="department_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($department as $departments)
                                                <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">Progress <span class="text-danger">*</span></td>
                                          <td style="width: 30%">
                                            <select class="form-control" name="progress" id="progress_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($status->where('category','Progress') as $statuses)
                                                <option value="{{ $statuses->id }}">{{ $statuses->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                          <td style="width: 20%">Priority <span class="text-danger">*</span></td>
                                          <td style="width: 30%">
                                            <select class="form-control" name="priority" id="priority_id">
                                              <option disabled selected>Please Select</option>
                                              @foreach($status->where('category','Priority') as $statuses)
                                                <option value="{{ $statuses->id }}">{{ $statuses->name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">Start Date <span class="text-danger">*</span></td>
                                          <td style="width: 30%"><input type="date" class="form-control" name="start_date" id="start_date"></td>
                                          <td style="width: 20%">End Date <span class="text-danger">*</span></td>
                                          <td style="width: 30%"><input type="date" class="form-control" name="end_date" id="end_date"></td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">PIC <span class="text-danger">*</span></td>
                                          <td style="width: 80%" colspan="3">
                                            <select class="form-control" name="user_id" id="user_id">
                                              @foreach($user as $users)
                                                <option value="{{ $users->id }}">{{ $users->short_name }}</option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">Detail</td>
                                          <td style="width: 80%" colspan="3"><input type="text" class="form-control" name="detail" id="detail"></td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">Comment</td>
                                          <td style="width: 80%" colspan="3"><input type="text" class="form-control" name="comment" id="comment"></td>
                                        </tr>
                                        <tr>
                                          <td style="width: 20%">Email to PIC?</td>
                                          <td style="width: 80%" colspan="3"><input type="checkbox" name="sent_email" id="sent_email"></td>
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

                            <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; min-width: 200px;">
                              <div class="toast customToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                                <div class="toast-header">
                                  <strong class="mr-auto">Status</strong>
                                </div>
                                <div class="toast-body">
                                </div>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


<script>
  function showToast(message) {
      $('.customToast .toast-body').text(message);
      $('.customToast').toast('show');
  }

  $('.select').select2({
    dropdownParent: $("#taskModal")
  });

  $(document).ready(function() {
    $('#calendar').fullCalendar({
      eventLimit: true,
      editable: true,
      events: {
          url: '/task/task-management/all-event',
          method: 'GET',
      },
        
      eventClick: function(calEvent, jsEvent, view) {
          $('#taskDetails').html(`
              <div class="card mb-2">
                  <div class="card-header font-weight-bold">
                    ${moment(calEvent.start).format('MMMM Do YYYY')}
                  </div>
                  <div class="card-body">
                      <p class="card-text font-weight-bold">${calEvent.title}</p>
                      <p class="card-text">Date: ${moment(calEvent.start).format('MMMM Do YYYY')} - ${moment(calEvent.endDate).format('MMMM Do YYYY')}</p>
                      <p class="card-text"><button class="btn btn-outline-primary btn-sm edit_data" data-toggle="modal" data-id="${calEvent.taskId}" id="edit" name="edit">Edit</button></p>
                  </div>
              </div>
          `);
      },
        
      dayClick: function(date, jsEvent, view) {
        var clickedDate = date.format();
        var tasksOnDate = [];
        $('#calendar').fullCalendar('clientEvents', function(event) {
            if (moment(clickedDate).isBetween(event.start, event.endDate, null, '[]') || moment(clickedDate).isSame(event.start, 'day') || moment(clickedDate).isSame(event.endDate, 'day')) {
                tasksOnDate.push(event);
            }
        });

        var tasksDetailsHTML = '';
        tasksOnDate.forEach(function(task) {
            tasksDetailsHTML += `
                <div class="card">
                    <div class="card-body">
                        <p class="card-text font-weight-bold">${task.title}</p>
                        <p class="card-text">Date: ${moment(task.start).format('MMMM Do YYYY')} - ${moment(task.endDate).format('MMMM Do YYYY')}</p>
                        <p class="card-text">PIC: ${task.pic}</p>
                        <p class="card-text">
                          <button class="btn btn-outline-primary btn-sm edit_data" data-toggle="modal" data-id="${task.taskId}" id="edit" name="edit">Edit</button>
                          <button class="btn btn-sm btn-outline-danger btn-delete delete" data-remote="/task/task-management/task-calendar/${task.taskId}">Delete</button>
                        </p>
                    </div>
                </div>
            `;
        });

        $('#taskDetails').html(`
            <div class="card mb-2">
                <div class="card-header font-weight-bold">
                  ${moment(clickedDate).format('MMMM Do YYYY')}
                </div>
            </div>
            ${tasksDetailsHTML}
        `);
      },

      eventDrop: function(event, delta, revertFunc) {
        handleEventUpdate(event, revertFunc);
      },
      eventResize: function(event, delta, revertFunc) {
          handleEventUpdate(event, revertFunc);
      }

    });

    function handleEventUpdate(event, revertFunc) {
      var newStartDate = event.start.format('YYYY-MM-DD');
      var newEndDate = event.end.format('YYYY-MM-DD');
      var taskId = event.taskId;

      $.ajax({
          url: '/task/task-calendar/event-date',
          method: 'POST',
          data: {
              task_id: taskId,
              new_start_date: newStartDate,
              new_end_date: newEndDate,
              _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
              showToast('Date Updated.');
          },
          error: function(xhr, status, error) {
              revertFunc();
          }
      });
    }

    $.ajaxSetup({
      headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
      }
    });

    $(document).on('click', '.edit_data', function(){
      var id = $(this).attr("data-id");
      $.ajax({
          url: '/task/task-management/task-calendar/1',
          method:"GET",
          data:{id:id},
          dataType:"json",
          success:function(data){
              $('#task_id').val(data.id);
              $('#category').val(data.category_id);
              $('#sub_category').val(data.sub_category);
              $('#type_id').val(data.type_id);
              $('#department_id').val(data.department_id);
              $('#progress_id').val(data.progress_id);
              $('#priority_id').val(data.priority_id);
              $('#start_date').val(data.start_date);
              $('#end_date').val(data.end_date);
              $('#user_id').val(data.user_id);
              $('#detail').val(data.detail);
              $('#comment').val(data.comment);
              if(data.email_sent == 1){
                $('#sent_email').prop('checked', true);
              } if(data.email_sent == 2) {
                $('#sent_email').prop('checked', false);
              }
              $('.editModal').modal('show');
          }
      });
    });

    $(document).on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
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
                showToast('Deleted.');
                location.reload();
              });
          }
        });
    });
  });
</script>

@endsection
