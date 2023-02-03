@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-table'></i> Arkib
        </h1>
    </div>
    {!! Form::open(['action' => ['Library\Arkib\ArkibController@search'], 'method' => 'POST'])!!}
    <div class="row">
      <div class="col-md-3 mb-5">
        <h3><b>Department</b></h3>
        <select class="form-control" name="department" id="department">
          <option disabled selected>Please Select</option>
          @foreach($department as $departments)
          <option value="{{ $departments->department_code }}" {{ \Request::get('department') == $departments->department_code ? 'selected="selected"' : ''}}>{{ $departments->department_name }}</option>
          {{-- <option value="{{ $departments->department_code }}">{{ $departments->department_name }}</option> --}}
          @endforeach
        </select>
      </div>
      <div class="col-md-7 mb-5">
        <h3><b>Search</b></h3>
        <input type="text" class="form-control" name="search_data" value="{{ \Request::get('search_data') }}">
      </div>
      <div class="col-md-2 mt-5">
        <div class="row">
          <button class="btn btn-success btn-sm mr-2"><i class="fal fa-search"></i> Search</button>
          <a href="/library/arkib/search" class="btn btn-warning btn-sm"><i class="fal fa-search"></i> Reset</a>
        </div>
      </div>
    </div>
    {!! Form::close() !!}
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row">
      @isset($main)
      @foreach($main as $mains)
      <div class="col-md-6 mb-2">
        <div class="card h-100">
            <div class="card-body">
              <div class="row">
                {{-- <div class="col-md-3 mt-2">
                  <img src="{{ asset('img/pdf_icon.png') }}" class="mt-2 ml-2" style="width: 130px; height:150px"/>
                </div> --}}
                <div class="col-12">
                    <table class="table w-10 mt-2">  
                      <tr>
                        <td style="width:150px">Title</td>
                        <td style="width:20px">:</td>
                        <td>{{ Str::title($mains->title) }}</td>
                      </tr>
                      <tr>
                        <td>File Classification No</td>
                        <td>:</td>
                        <td>{{ ucfirst($mains->file_classification_no) }}</td>
                      </tr>
                      <tr>
                        <td>Department</td>
                        <td>:</td>
                        <td>{{ isset($mains->department->department_name) ? Str::title($mains->department->department_name) : '' }}</td>
                      </tr>
                      <tr>
                        <td>Created At</td>
                        <td>:</td>
                        <td>{{ $mains->created_at }}</td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>
            <div class="card-footer h-20 border-0">
              {{-- <a href="/library/arkib/{{ $mains->id }}" class="btn btn-primary btn-sm float-right">
                <i class="fal fa-file-pdf"></i> 
              View</a> --}}
              <button class="btn btn-primary btn-sm float-right edit_data" data-toggle="modal" data-id="{{ $mains->id }}" id="edit" name="edit">
                <i class="fal fa-file-pdf"></i> View
              </button>
           </div>
        </div>
      </div>
      @endforeach
      @endisset
    </div>
    <div class="row">
      <div class="col-md-12">
        @isset($main)
        {{ $main->appends(\Request::except('page'))->links() }}
        @endisset
      </div>
    </div>

    <div class="modal fade editModal" id="editModal" aria-hidden="true" >
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Detail</h4>
              </div>
              <div class="modal-body">
                <table class="table w-10">
                  <tr>
                    <td>Title</td>
                    <td id="arkib_title"></td>
                  </tr>
                  <tr>
                    <td>File Classification No</td>
                    <td id="arkib_classification"></td>
                  </tr>
                  <tr>
                    <td>Description</td>
                    <td id="arkib_description"></td>
                  </tr>
                  <tr>
                    <td>Department</td>
                    <td id="arkib_department"></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td id="arkib_status"></td>
                  </tr>
                  <tr>
                    <td>Created At</td>
                    <td id="arkib_date"></td>
                  </tr>
                  <tr>
                    <td>Uploaded</td>
                    <td>
                      <div id="existfile">

                      </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm text-white" data-dismiss="modal">Close</button>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection

@section('script')

<script>
  $('#department').select2();

  $(document).ready(function()
  {
      $.ajaxSetup({
          headers:{
          'X-CSRF-Token' : $("input[name=_token]").val()
          }
      });

      $(document).on('click', '.edit_data', function(){
          var id = $(this).attr("data-id");
          $.ajax({
              url: '{{ url("get-arkib") }}',
              method:"POST",
              data:{id:id},
              dataType:"json",
              success:function(data){
                  $('#arkib_id').html(data.id);
                  $('#arkib_title').html(data.title);
                  $('#arkib_classification').html(data.file_classification_no);
                  $('#arkib_description').html(data.description);
                  $('#arkib_department').html(data.department.department_name);
                  $('#arkib_status').html(data.arkib_status.arkib_description);
                  $('#arkib_date').html(new Date(data.created_at));
                  $('#existfile').empty();
                  data.arkib_attachments.forEach(function(ele){
                      $('#existfile').append(`
                          <div id="attachment${ele.id}">
                              ${ele.file_name} <a href="/library/arkib/${ele.file_name}" target="_blank">View</a> <br/>
                          </div>
                      `);
                  });
                  $('.editModal').modal('show');
              }
          });
      });
  });
</script>


@endsection
