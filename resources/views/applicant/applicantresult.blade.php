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
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#applicant" role="tab">Applicant</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#not_qualified" role="tab">Not Qualified</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#offer" role="tab">Offer <span class="badge bg-primary">{{$app_offer->count()}}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#accept" role="tab">Accept Offer</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="applicant" role="tabpanel">
                                    <button type="button" class="btn btn-info pull-right mb-5" onclick="window.location='{{ route("check-requirements") }}'">Check Requirement</button>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>No</th>
                                            <th>Applicant Name</th>
                                            <th>Programme 1</th>
                                            <th>Programme 2</th>
                                            <th>Programme 3</th>
                                            <th>Bahasa Melayu</th>
                                            <th>English</th>
                                            <th>Mathematics</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($aapplicant as $aapplicant_all_app)
                                            <tr id={{$aapplicant_all_app['id']}}>
                                                <td>{{$aapplicant_all_app['id']}}</td>
                                                <td>{{$aapplicant_all_app['applicant_name']}}</td>
                                                <td>
                                                    @foreach($aapplicant_all_app['programme_1'] as $etc)
                                                    <p>{{$etc['programme_code']}}</p>
                                                    @endforeach
                                                    @if($aapplicant_all_app['programme_status']== 'Accepted')
                                                        <p><span class="badge bg-success">{{$aapplicant_all_app['programme_status']}}</span></p><br>
                                                    @else
                                                        <p><span class="badge bg-danger">{{$aapplicant_all_app['programme_status']}}</span></p><br>
                                                    @endif
                                                </td>
                                                <td>@foreach($aapplicant_all_app['programme_2'] as $etc)
                                                    <p>{{$etc['programme_code']}}</p>
                                                    @endforeach
                                                    @if($aapplicant_all_app['programme_status_2']== 'Accepted')
                                                        <p><span class="badge bg-success">{{$aapplicant_all_app['programme_status_2']}}</span></p><br>
                                                    @else
                                                        <p><span class="badge bg-danger">{{$aapplicant_all_app['programme_status_2']}}</span></p><br>
                                                    @endif
                                                </td>
                                                <td>@foreach($aapplicant_all_app['programme_3'] as $etc)
                                                    <p>{{$etc['programme_code']}}</p>
                                                    @endforeach
                                                    @if($aapplicant_all_app['programme_status_3']== 'Accepted')
                                                        <p><span class="badge bg-success">{{$aapplicant_all_app['programme_status_3']}}</span></p><br>
                                                    @else
                                                        <p><span class="badge bg-danger">{{$aapplicant_all_app['programme_status_3']}}</span></p><br>
                                                    @endif
                                                </td>
                                                <td>
                                                    @foreach($aapplicant_all_app['bm'] as $app_result)
                                                        <p>{{$app_result->grades->grade_code}}</p>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($aapplicant_all_app['eng'] as $app_result)
                                                        <p>{{$app_result->grades->grade_code}}</p>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($aapplicant_all_app['math'] as $app_result)
                                                        <p>{{$app_result->grades->grade_code}}</p>
                                                    @endforeach
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
            </div>
        </div>
    </main>
@endsection