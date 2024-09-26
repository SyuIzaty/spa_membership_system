@extends('layouts.admin')
@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Space Setting
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Space Upload</h2>
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
                            {!! Form::open(['action' => 'Space\SpaceSetting\SpaceUploadController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <table class="table table-bordered">
                              <tr>
                                <td>Download Template</td>
                                <td><a href="/space/space-setting/space-upload/1">Download</a></td>
                              </tr>
                              <tr>
                                <td>Upload File <span class="text-danger">*</span></td>
                                <td><input type="file" name="upload_file"></td>
                              </tr>
                            </table>
                            <button class="btn btn-success btn-sm float-right mb-3">Upload</button>
                            {!! Form::close() !!}
                          </div>

                          <div class="col-md-12" style="margin-top: 50px">
                            <div class="panel-tag">Code List</div>
                            <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#major" aria-expanded="false">
                                            <i class="fal fa-list-ul width-2 fs-xl"></i>
                                            Room
                                            <span class="ml-auto">
                                                <span class="collapsed-reveal">
                                                    <i class="fal fa-minus fs-xl"></i>
                                                </span>
                                                <span class="collapsed-hidden">
                                                    <i class="fal fa-plus fs-xl"></i>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div id="major" class="collapse" data-parent="#major">
                                        <div class="card-body">
                                            <table class="table table-bordered" id="major_list" style="width:100%">
                                                <thead class="bg-primary-50 text-center">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>BLOCK</td>
                                                        <td>NAME</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Block"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($room as $rooms)
                                                  <tr>
                                                      <td>{{ $rooms->id }}</td>
                                                      <td>{{ isset($rooms->spaceBlock->name) ? $rooms->spaceBlock->name : '' }}</td>
                                                      <td>{{ $rooms->name }}</td>
                                                  </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#mode" aria-expanded="false">
                                            <i class="fal fa-list-ul width-2 fs-xl"></i>
                                            Item
                                            <span class="ml-auto">
                                                <span class="collapsed-reveal">
                                                    <i class="fal fa-minus fs-xl"></i>
                                                </span>
                                                <span class="collapsed-hidden">
                                                    <i class="fal fa-plus fs-xl"></i>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                    <div id="mode" class="collapse" data-parent="#mode">
                                        <div class="card-body">
                                            <table class="table table-bordered" id="mode_list" style="width: 100%">
                                                <thead class="bg-primary-50 text-center">
                                                    <tr>
                                                        <td>ID</td>
                                                        <td>NAME</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Mode Code"></td>
                                                        <td class="hasinput"><input type="text" class="form-control" placeholder="Search Mode Name"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($category as $categories)
                                                        <tr>
                                                            <td>{{ $categories->id }}</td>
                                                            <td>{{ $categories->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
  $('.new').click(function () {
      $('#crud-modal').modal('show');
  });

  $(document).ready(function() {
    $('#sponsor,#intake_offer').select2();

    $('#major_list thead tr .hasinput').each(function(i)
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

    var table = $('#major_list').DataTable({
        columnDefs: [],
            orderCellsTop: true,
            "order": [[ 0, "asc" ]],
            "initComplete": function(settings, json) {
            }
    });
  });

  $(document).ready(function() {

    $('#mode_list thead tr .hasinput').each(function(i)
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

    var table = $('#mode_list').DataTable({
        columnDefs: [],
            orderCellsTop: true,
            "order": [[ 0, "asc" ]],
            "initComplete": function(settings, json) {
            }
    });

  });
</script>
@endsection
