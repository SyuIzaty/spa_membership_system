@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Offer Letter
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Offer Letter</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="tab-content">
                                <div class="tab-pane active" id="details" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Applicant ID</th>
                                                    <th>Programme Name</th>
                                                    <th>Register Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                @foreach ($applicant as $applicantt)
                                                    <tr>
                                                        <td>{{$applicantt->applicant_name}}</td>
                                                        <td>{{$applicantt->programme_name}}</td>
                                                        <td></td>
                                                        <td><a href="" class="btn btn-primary">Offer Letter</a></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            <hr class="mt-2 mb-3">
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