@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-book'></i> File Detail
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Detail <span class="fw-300"><i></i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      <div class="row">
                        <div class="col-md-4">
                          <img src="{{ asset('img/intec_logo_new.png') }}" class="mt-2" style="width: 200px; height:100px; border:1px solid black"/>
                        </div>
                        <div class="col-md-8">
                          <table class="table w-10">
                            <tr>
                              <td>Title</td>
                              <td>{{ $main->title }}</td>
                            </tr>
                            <tr>
                              <td>Description</td>
                              <td>{{ $main->description }}</td>
                            </tr>
                            <tr>
                              <td>Department</td>
                              <td>{{ isset($main->department->department_name) ? Str::title($main->department->department_name) : '' }}</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>{{ isset($main->arkibStatus->arkib_description) ? $main->arkibStatus->arkib_description : '' }}</td>
                            </tr>
                            <tr>
                              <td>Uploaded</td>
                              <td>{{ $main->created_at }}</td>
                            </tr>
                          </table>
                          @if($attach->count() >= 1)
                          <table class="table w-10">
                            <tr>
                              <td>File Name</td>
                              <td>File Size</td>
                              <td>Action</td>
                            </tr>
                            @foreach($attach as $attaches)
                            <tr>
                              <td>{{ $attaches->file_name }}</td>
                              <td>{{ $attaches->file_size }}</td>
                              <td>
                                <a href="/library/arkib-main/{{ $attaches->id }}">View</a>
                              </td>
                            </tr>
                            @endforeach
                          </table>
                        </div>
                      </div>
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    $('#department_code, #status').select2();
</script>
@endsection
