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
                        <h2>Upload Arkib Paper</h2>
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
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#student_file" role="tab">
                                                <i class="fal fa-user text-primary"></i>
                                                <span class="hidden-sm-down ml-1">Student File</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#other" role="tab">
                                                <i class="fal fa-file text-primary"></i>
                                                <span class="hidden-sm-down ml-1">Other</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane active" id="student_file" role="tabpanel">
                                        <div class="table-responsive mt-2">
                                          {!! Form::open(['action' => 'Library\Arkib\ArkibMainController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                          <input type="hidden" name="category_id" value="1">
                                          <table class="table table-bordered">
                                            <tr>
                                              <td style="width: 15%">Department <span class="text-danger">*</span></td>
                                              <td style="width: 35%">
                                                <select class="form-control department_code" name="department_code">
                                                  <option disabled selected>Please Select</option>
                                                  @foreach($department as $departments)
                                                  <option value="{{ $departments->id }}" {{ old('department_code') ? 'selected' : '' }}>
                                                    {{ $departments->name }}</option>
                                                  @endforeach
                                                </select>
                                              </td>
                                              <td style="width: 15%">File Classification No <span class="text-danger">*</span></td>
                                              <td style="width: 35%"><input type="text" class="form-control" name="file_classification_no" value="{{ old('file_classification_no') }}"></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Student <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%">
                                                <select class="form-control" name="student" id="student"></select>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Student ID</td>
                                              <td style="width: 35%"><div id="student_id"></div></td>
                                              <td style="width: 15%">Student IC</td>
                                              <td style="width: 35%"><div id="student_ic"></div></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Intake Code</td>
                                              <td style="width: 35%"><div id="student_intake"></div></td>
                                              <td style="width: 15%">Batch Code</td>
                                              <td style="width: 35%"><div id="student_batch"></div></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Programme</td>
                                              <td style="width: 85%" colspan="3"><div id="student_programme"></div></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Title <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%"><input type="text" class="form-control" name="title" value="{{ old('title') }}"></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Description <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%"><input type="text" class="form-control" name="description" value="{{ old('description') }}"></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Status <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%">
                                                <select class="form-control status" name="status" id="status_stud">
                                                    <option disabled selected>Please Select</option>
                                                    @foreach($status as $statuses)
                                                    <option value="{{ $statuses->arkib_status }}" {{ old('status') ? 'selected' : '' }}>
                                                        {{ $statuses->arkib_description }}</option>
                                                    @endforeach
                                                </select>
                                              </td>
                                            </tr>
                                            <tr style="width: 15%">
                                              <td>Attachment(s) <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%">
                                                  <input type="file" name="arkib_attachment[]" multiple required>
                                              </td>
                                            </tr>
                                          </table>
                                          <button class="btn btn-success btn-sm float-right mb-2">Submit</button>
                                          <a href="/library/arkib-main/" class="btn btn-secondary btn-sm float-right mr-2 text-white">Back</a>
                                          {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="other" role="tabpanel">
                                        <div class="table-responsive mt-2">
                                          {!! Form::open(['action' => 'Library\Arkib\ArkibMainController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                          <input type="hidden" name="category_id" value="2">
                                          <table class="table table-bordered">
                                            <tr>
                                              <td style="width: 15%">Department <span class="text-danger">*</span></td>
                                              <td style="width: 35%">
                                                <select class="form-control department_code" name="department_code">
                                                  <option disabled selected>Please Select</option>
                                                  @foreach($department as $departments)
                                                  <option value="{{ $departments->id }}" {{ old('department_code') ? 'selected' : '' }}>
                                                    {{ $departments->name }}</option>
                                                  @endforeach
                                                </select>
                                              </td>
                                              <td style="width: 15%">File Classification No <span class="text-danger">*</span></td>
                                              <td style="width: 35%"><input type="text" class="form-control" name="file_classification_no" value="{{ old('file_classification_no') }}"></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Title <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%"><input type="text" class="form-control" name="title" value="{{ old('title') }}"></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Description <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%"><input type="text" class="form-control" name="description" value="{{ old('description') }}"></td>
                                            </tr>
                                            <tr>
                                              <td style="width: 15%">Status <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%">
                                                <select class="form-control status" name="status" id="status_other">
                                                    <option disabled selected>Please Select</option>
                                                    @foreach($status as $statuses)
                                                    <option value="{{ $statuses->arkib_status }}" {{ old('status') ? 'selected' : '' }}>
                                                        {{ $statuses->arkib_description }}</option>
                                                    @endforeach
                                                </select>
                                              </td>
                                            </tr>
                                            <tr style="width: 15%">
                                              <td>Attachment(s) <span class="text-danger">*</span></td>
                                              <td colspan="3" style="width: 85%">
                                                  <input type="file" name="arkib_attachment[]" multiple required>
                                              </td>
                                            </tr>
                                          </table>
                                          <button class="btn btn-success btn-sm float-right mb-2">Submit</button>
                                          <a href="/library/arkib-main/" class="btn btn-secondary btn-sm float-right mr-2 text-white">Back</a>
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
    </main>
@endsection
@section('script')
<script>

  $('.department_code, #student, #status_stud, #status_other').select2();

  $(document).ready(function()
  {
    $('#student').select2({
        placeholder: "Enter Student ID / Name / IC",
        minimumInputLength: 2,
        ajax: {
          url: '/autocomplete',
          dataType: 'json',
          data: function (params) {
            return {
              student: $.trim(params.term)
            };
          },
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
    });

    $('#student').on('change', function() {
      var student = $(this).val();
      if(student) {
          $.ajax({
              url: '/library/arkib-main/'+student,
              type: "GET",
              data : {"_token":"{{ csrf_token() }}"},
              dataType: "json",
              success:function(data) {
                if(data){
                    $('#student_id').html(data.students_id);
                    $('#student_ic').html(data.students_ic);
                    $('#student_intake').html(data.intake_code);
                    $('#student_batch').html(data.batch_code);
                    $('#student_programme').html(data.programmes.programme_name);
                }else{
                    $('#student_id').empty();
                    $('#student_ic').empty();
                    $('#student_intake').empty();
                    $('#student_batch').empty();
                    $('#student_programme').empty();
                }
              }
          });
      }else{
      $('#student_name').empty();
      }
    });
  });
</script>
@endsection
