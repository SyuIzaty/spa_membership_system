@extends('layouts.admin')

@section('content')
<style>
    .centered {
        position: absolute;
        top: 21%;
        left: 15%;
        transform: translate(-50%, -50%);
    }
</style>
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-building'></i>MEMBER MANAGEMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        List of <span class="fw-300"><i>Member</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="tab-content">
                            <div class="tab-pane show active" role="tabpanel">
                              <div class="row">
                                <div class="col-md-12">
                                  <button class="btn btn-primary mb-3 mt-2" data-toggle="modal" data-target="#taskModal">Add Member</button>
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
                                @if($member->count())
                                  @foreach($member as $members)
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-3">
                                        <div class="card mb-3">
                                          <div class="card-header pb-0 pt-2">
                                              <p style="font-size: 16px; float: left" class="ml-3 mb-1 mt-1"><b style="padding-bottom: -10px;">{{ strtoupper($members->short_name) }}</b></p>
                                              <p style="float: right" class="mb-2">
                                                @if(!isset($members->taskMains))
                                                <button class="btn btn-danger btn-icon rounded-circle ml-1 waves-effect waves-themed text-white btn-delete delete" data-remote="/task/task-setting/task-user/{{ $members->id }}"> 
                                                  <i class="fal fa-trash"></i>
                                                </button>
                                                @endif
                                            </p>
                                          </div>
                                          <center>
                                            <i class="fal fa-user-circle fa-9x mt-3 mb-3"></i>
                                            {{-- <img src="{{ URL::to('/') }}/img/default.png" alt="default" style="width:225px; height:200px;" class="img-fluid mt-3 mb-3"> --}}
                                          </center>
                                          <div class="card-footer p-0">
                                              <div class="row no-gutters row-grid">
                                                  <div class="col-12">
                                                      <div class="text-center py-3">
                                                          <h5 class="mb-0 fw-700">
                                                              {{ isset($members->taskMains) ? $members->taskMains->where('user_id',$members->id)->count() : 0 }}
                                                              <small class="text-muted mb-0">Total Task</small>
                                                          </h5>
                                                      </div>
                                                  </div>
                                                  @foreach($status->where('category','Progress') as $statuses)
                                                  <div class="col-4">
                                                    <div class="text-center py-3">
                                                        <h5 class="mb-0 fw-700">
                                                          {{ isset($members->taskMains) ? $members->taskMains->where('user_id',$members->id)->where('progress_id',$statuses->id)->count() : 0 }}
                                                          <small class="text-muted mb-0"> {{ Str::title($statuses->name) }}</small>
                                                        </h5>
                                                    </div>
                                                </div>
                                                  @endforeach
                                              </div>

                                              <div class="text-center">
                                                  <div class="row row-grid no-gutters">
                                                      <div class="col-12">
                                                      </div>
                                                      @can('manage registration')
                                                          <style>
                                                              a.gridDisabled {
                                                                  pointer-events: none;
                                                                  cursor: default;
                                                              }
                                                          </style>
                                                          <div class="col-6">
                                                            <a type="button" class="text-center p-3 d-flex flex-column hover-highlight edit_data" data-toggle="modal" data-id="{{ $members->id }}" id="edit" name="edit">
                                                              <i class="fal fa-pencil text-primary fa-3x"></i>
                                                                <span class="d-block text-muted fs-xs mt-3">EDIT</span>
                                                            </a>
                                                          </div>
                                                          <div class="col-6">
                                                            <a href="/task/task-setting/task-user/{{ $members->id }}/edit" class="text-center p-3 d-flex flex-column hover-highlight">
                                                              <i class="fal fa-tasks fa-3x"></i>
                                                                <span class="d-block text-muted fs-xs mt-3">TASK</span>
                                                            </a>
                                                          </div>
                                                      @endcan
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                    </div>
                                  @endforeach
                                @else
                                    <div>
                                        <h3>NO MEMBER AVAILABLE</h3>
                                    </div>
                                @endif

                                <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="taskModalLabel">Add Member</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        {!! Form::open(['action' => 'Task\TaskSetting\TaskUserController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                        <table class="table table-bordered">
                                          <tr>
                                            <td style="width: 30%">Member <span class="text-danger">*</span></td>
                                            <td style="width: 70%" colspan="3">
                                              <select class="form-control select" name="user_id">
                                                <option disabled selected>Please Select</option>
                                                @foreach($user as $users)
                                                <option value="{{ $users->id }}" {{ old('user_id') ==  $users->id  ? 'selected' : '' }}>{{ $users->name }}</option>
                                                @endforeach
                                              </select>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Short name <span class="text-danger">*</span></td>
                                            <td><input type="text" class="form-control" name="short_name" value="{{ old('short_name') }}"></td>
                                          </tr>
                                          <tr>
                                            <td>Color <span class="text-danger">*</span></td>
                                            <td><input type="color" class="form-control" name="color" value="{{ old('color') }}"></td>
                                          </tr>
                                          <tr>
                                            <td>Status</td>
                                            <td>
                                              <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="status_id" id="store_status">
                                                <label class="custom-control-label" for="store_status"></label>
                                              </div>
                                            </td>
                                          </tr>
                                        </table>
                                        <button class="btn btn-success float-right btn-sm">Submit</button>
                                        {!! Form::close() !!}
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="modal fade editModal" id="editModal" aria-hidden="true" >
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title">Update Member</h4>
                                        </div>
                                        {!! Form::open(['action' => ['Task\TaskSetting\TaskUserController@update', '1'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                        <input type="hidden" name="member_id" id="member_id">
                                        <div class="modal-body">
                                          <table class="table table-bordered">
                                            <tr>
                                              <td style="width: 30%">User <span class="text-danger">*</span></td>
                                              <td style="width: 70%" colspan="3">
                                                <select class="form-control" name="user_id" id="user_id">
                                                  <option disabled selected>Please Select</option>
                                                  @foreach($user as $users)
                                                    <option value="{{ $users->id }}">{{ $users->name }}</option>
                                                  @endforeach
                                                </select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>Short name <span class="text-danger">*</span></td>
                                              <td><input type="text" class="form-control" name="short_name" id="short_name"></td>
                                            </tr>
                                            <tr>
                                              <td>Color <span class="text-danger">*</span></td>
                                              <td><input type="color" class="form-control" name="color" id="color"></td>
                                            </tr>
                                            <tr>
                                              <td>Status</td>
                                              <td>
                                                <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input" name="status_id" id="update_status">
                                                  <label class="custom-control-label" for="update_status"></label>
                                                </div>
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
                </div>


            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
  $('.select').select2({
    dropdownParent: ("#taskModal")
  });

  $(document).ready(function() {
    $.ajaxSetup({
      headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
      }
    });

    $(document).on('click', '.edit_data', function(){
      var id = $(this).attr("data-id");
      $.ajax({
          url: '/task/task-setting/task-user/1',
          method:"GET",
          data:{id:id},
          dataType:"json",
          success:function(data){
              $('#member_id').val(data.id);
              $('#user_id').val(data.user_id);
              $('#short_name').val(data.short_name);
              $('#color').val(data.color);
              if(data.status_id == 1){
                $('#update_status').prop('checked', true);
              } if(data.status_id == 2) {
                $('#update_status').prop('checked', false);
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
                location.reload();
              });
          }
        });
    });
  });
</script>
@endsection
