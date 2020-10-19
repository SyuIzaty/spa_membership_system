@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-search'></i> Export
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Export</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <form action="{{url('export_applicant')}}" method="GET" id="upload_form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Intake</label>
                                        <select class="form-control" name="intake" id="intake">
                                            <option>All</option>
                                            @foreach($intake as $int)
                                            <option value="{{$int->id}}" <?php if($request->intake == $int->id) echo "selected"; ?> >{{$int->intake_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Batch</label>
                                        <select class="form-control" name="batch_code" id="batch_code">
                                            <option>All</option>
                                            @foreach($batch as $bat)
                                            <option <?php if($request->batch_code == $bat->batch_code) echo "selected"; ?> >{{$bat->batch_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Programme</label>
                                        <select class="form-control" name="program" id="program">
                                            <option>All</option>
                                            @foreach($program as $pro)
                                            <option <?php if($request->program == $pro->id) echo "selected"; ?> >{{$pro->programme_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option>All</option>
                                            @foreach($status as $statuses)
                                            <option <?php if($request->status == $statuses->status_code) echo "selected"; ?> >{{$statuses->status_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <a class="btn btn-primary btn-md form-group mt-4" href="" id="exportbtn" onclick="Export()">Export</a>
                                <button class="btn btn-success btn-md form-group" type="submit">Search</button>
                            </form>

                            <table class="table table-bordered" id="applicantTable">
                                <thead class="bg-highlight">
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>IC</th>
                                    <th>Email</th>
                                    <th>Intake Code</th>
                                    <th>Program Code</th>
                                    <th>Batch Code</th>
                                    <th>Status</th>
                                </thead>
                                @if($selectedintake || $selectedprogramme || $selectedbatch || $selectedstatus)
                                <tbody>
                                    @foreach($list as $listvalue)
                                    <tr>
                                        <td>{{$listvalue->id}}</td>
                                        <td>{{$listvalue->applicant_name}}</td>
                                        <td>{{$listvalue->applicant_ic}}</td>
                                        <td>{{$listvalue->applicant_email}}</td>
                                        <td>{{ isset($listvalue->intake->intake_code) ? $listvalue->intake->intake_code : "-" }}</td>
                                        <td>{{ $listvalue->offered_programme }}</td>
                                        <td>{{$listvalue->batch_code}}</td>
                                        <td>{{ $listvalue->status->status_description }}</td>
                                    </tr>

                                    @endforeach
                                </tbody>
                                @endif
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script >
    $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
    });

    function Export()
    {
        var url = '{{url("exportapplicant")}}/' + $('#intake').val() + "/" + $('#program').val() + "/" + $('#batch_code').val() + "/" + $('#status').val() ;
        // var url = '{{url("exportapplicant")}}/' + $('#intake').val() + "/" + $('#program').val() + "/" + $('#batch_code').val() ;
        $('#exportbtn').attr('href',url);
    }
</script>
@endsection
