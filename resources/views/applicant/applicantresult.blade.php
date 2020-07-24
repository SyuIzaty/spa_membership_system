@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Applicant
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Applicant</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <button type="button" class="btn btn-info pull-right mb-5" onclick="window.location='{{ route("check-requirements") }}'">Check Requirement</button>
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Applicant Name</th>
                                    <th colspan = "2">Applicant Programme</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($aapplicant as $aapplicant_all_app)
                                    <tr id={{$aapplicant_all_app['id']}}>
                                        <td>{{$aapplicant_all_app['id']}}</td>
                                        <td>{{$aapplicant_all_app['applicant_name']}}</td>
                                        <td>
                                            @foreach($aapplicant_all_app['programme_1'] as $etc)
                                            <p>{{$etc['programme_name']}}</p>
                                            @endforeach
                                            @foreach($aapplicant_all_app['programme_2'] as $etc)
                                            <p>{{$etc['programme_name']}}</p>
                                            @endforeach
                                            @foreach($aapplicant_all_app['programme_3'] as $etc)
                                            <p>{{$etc['programme_name']}}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if($aapplicant_all_app['programme_status']== 'Accepted')
                                                <p><span class="badge bg-success pull-right">{{$aapplicant_all_app['programme_status']}}</span></p><br>
                                            @else
                                                <p><span class="badge bg-danger pull-right">{{$aapplicant_all_app['programme_status']}}</span></p><br>
                                            @endif
                                            @if($aapplicant_all_app['programme_status_2']== 'Accepted')
                                                <p><span class="badge bg-success pull-right">{{$aapplicant_all_app['programme_status_2']}}</span></p><br>
                                            @else
                                                <p><span class="badge bg-danger pull-right">{{$aapplicant_all_app['programme_status_2']}}</span></p><br>
                                            @endif
                                            @if($aapplicant_all_app['programme_status_3']== 'Accepted')
                                                <p><span class="badge bg-success pull-right">{{$aapplicant_all_app['programme_status_3']}}</span></p><br>
                                            @else
                                                <p><span class="badge bg-danger pull-right">{{$aapplicant_all_app['programme_status_3']}}</span></p><br>
                                            @endif
                                        </td>
                                        <td><a href="/applicant/{{$aapplicant_all_app['id']}}" class="btn btn-success">Detail</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection