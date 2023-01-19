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
      <div class="col-md-4 mb-5">
        <h3><b>Department</b></h3>
        <select class="form-control" name="department" id="department">
          <option disabled selected>Please Select</option>
          {{-- @foreach($department as $departments)
          <option value="{{ $departments->department_code }}" {{ \Request::get('department') == $departments->department_code ? 'selected="selected"' : ''}}>{{ $departments->department_name }}</option>
          @endforeach --}}
        </select>
      </div>
      <div class="col-md-7 mb-5">
        <h3><b>Search</b></h3>
        <input type="text" class="form-control" name="search_data" value="{{ \Request::get('search_data') }}">
      </div>
      <div class="col-md-1 mt-5">
        <button class="btn btn-success btn-sm"><i class="fal fa-search"></i> Search</button>
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
                        <td style="width:30px">Title</td>
                        <td style="width:20px">:</td>
                        {{-- <td>{{ Str::title($mains->title) }}</td> --}}
                        <td>{{ Str::title($mains->students_name) }}</td>
                      </tr>
                      <tr>
                        <td>Description</td>
                        <td>:</td>
                        {{-- <td>{{ Str::title($mains->description) }}</td> --}}
                        <td>{{ Str::title($mains->students_id) }}</td>
                      </tr>
                      <tr>
                        <td>Department</td>
                        <td>:</td>
                        {{-- <td>{{ isset($mains->department->department_name) ? Str::title($mains->department->department_name) : '' }}</td> --}}
                      </tr>
                      <tr>
                        <td>Created At</td>
                        <td>:</td>
                        {{-- <td>{{ $mains->created_at }}</td> --}}
                      </tr>
                    </table>
                </div>
              </div>
            </div>
            <div class="card-footer h-20 border-0">
              <a href="/library/arkib/{{ $mains->id }}" class="btn btn-primary btn-sm float-right">
                <i class="fal fa-file-pdf"></i> 
              View</a>
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
</main>
@endsection

@section('script')

<script>
  $('#department').select2();
</script>


@endsection
