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
                        <h2>Block</h2>
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
                                {!! Form::open(['action' => 'Space\SpaceSetting\BlockController@uploadBlock', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <table class="table table-bordered">
                                  <tr>
                                    <td>Template</td>
                                    <td><a href="/space/block-template" class="btn btn-info btn-sm" target="_blank">Template</a></td>
                                  </tr>
                                  <tr>
                                    <td>Upload</td>
                                    <td><input type="file" name="upload_block" class="form-control"></td>
                                  </tr>
                                </table>
                                <button class="btn btn-success btn-sm float-right">Submit</button>
                                {!! Form::close() !!}
                              </div>
                              <div class="col-md-12 mt-5">
                                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#major" aria-expanded="false">
                                                <i class="fal fa-list-ul width-2 fs-xl"></i>
                                                Room Type
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
                                                <table class="table table-bordered" id="room_list" style="width:100%">
                                                    <thead class="bg-primary-50 text-center">
                                                        <tr>
                                                            <td>ROOM TYPE</td>
                                                            <td>NAME</td>
                                                            <td>DESCRIPTION</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Room Type"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Description"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($room_type as $room_types)
                                                    <tr>
                                                      <td>{{ $room_types->id }}</td>
                                                      <td>{{ $room_types->name }}</td>
                                                      <td>{{ $room_types->description }}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#equipment" aria-expanded="false">
                                                <i class="fal fa-list-ul width-2 fs-xl"></i>
                                                Equipment
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
                                        <div id="equipment" class="collapse" data-parent="#equipment">
                                            <div class="card-body">
                                                <table class="table table-bordered" id="equipment_list" style="width:100%">
                                                    <thead class="bg-primary-50 text-center">
                                                        <tr>
                                                            <td>EQUIPMENT CATEGORY</td>
                                                            <td>EQUIPMENT ID</td>
                                                            <td>NAME</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Category"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search ID"></td>
                                                            <td class="hasinput"><input type="text" class="form-control" placeholder="Search Name"></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($asset as $assets)
                                                        <tr>
                                                            <td>1</td>
                                                            <td>{{ $assets->id }}</td>
                                                            <td>{{ $assets->asset_type }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @foreach($category as $categories)
                                                        <tr>
                                                            <td>3</td>
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
                                <div class="accordion accordion-outline" id="js_demo_accordion-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#status" aria-expanded="false">
                                                <i class="fal fa-list-ul width-2 fs-xl"></i>
                                                Equipment Status (Screen Projector, VGA Port, HDMI Port, HDMI Cable, VGA Cable)
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
                                        <div id="status" class="collapse" data-parent="#status">
                                            <div class="card-body">
                                                <table class="table table-bordered" id="status_list" style="width:100%">
                                                    <thead class="bg-primary-50 text-center">
                                                        <tr>
                                                            <td>EQUIPMENT STATUS</td>
                                                            <td>DESCRIPTION</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <tr>
                                                        <td>Y</td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td>N</td>
                                                        <td></td>
                                                      </tr>
                                                      <tr>
                                                        <td>-</td>
                                                        <td></td>
                                                      </tr>
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
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('#equipment_list thead tr .hasinput').each(function(i)
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

    var table = $('#equipment_list').DataTable({
        columnDefs: [],
            orderCellsTop: true,
            "order": [[ 0, "asc" ]],
            "initComplete": function(settings, json) {
            }
    });

    $('#room_list thead tr .hasinput').each(function(i)
    {
        $('input', this).on('keyup change', function()
        {
            if (room_table.column(i).search() !== this.value)
            {
                room_table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    var room_table = $('#room_list').DataTable({
        columnDefs: [],
            orderCellsTop: true,
            "order": [[ 0, "asc" ]],
            "initComplete": function(settings, json) {
            }
    });

});
</script>
@endsection
