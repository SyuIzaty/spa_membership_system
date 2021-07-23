@extends('layouts.admin')

@section('content')

    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Public View (Details)
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                        <h2>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>

                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                            <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;">
                            </center>
                            <br>
                            <h4 style="text-align: center">
                                <b>INTEC EDUCATION COLLEGE ACADEMIC TEAM</b>
                            </h4>
                            <div>
                                {{-- <p style="padding-left: 40px; padding-right: 40px" align="center">
                                    *<i><b>IMPORTANT!</b></i> : All staff are required to fill in the vaccination survey for
                                    the purpose of data collection. This survey can be updated anytime if there are any
                                    information changed.
                                </p> --}}
                            </div>
                            <hr class="mt-2 mb-2">
                            <h1 class="text-center heading text-iceps-blue">
                                Short Course - <b class="semi-bold">{{ $event->name }}</b>
                            </h1>
                            <hr class="mt-2 mb-2">
                            {{-- Start Update Form --}}
                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="card">
                                                <div class="card-header">Poster</div>
                                                <div class="card-body">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="card">
                                                <div class="card-header">General Information</div>
                                                <div class="card-body">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="row">
                                        <div class="col">

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="heading text-iceps-blue">
                                                                        Description
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="heading text-iceps-blue">
                                                                        Who should attend?
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr class="mt-2 mb-2">
                                                    <div class="panel-container show">
                                                        <div class="panel-content">
                                                            <ul class="nav nav-pills" role="tablist">
                                                                <li class="nav-item">
                                                                    <a data-toggle="tab" class="nav-link active"
                                                                        href="#objective" role="tab">Objective</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a data-toggle="tab" class="nav-link" href="#outline"
                                                                        role="tab">Outline</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a data-toggle="tab" class="nav-link" href="#tentative"
                                                                        role="tab">tentative</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content col-md-12 mt-3">
                                                                <div class="tab-pane active" id="objective" role="tabpanel">
                                                                    Objective
                                                                </div>
                                                                <div class="tab-pane" id="outline" role="tabpanel">
                                                                    Outline
                                                                </div>
                                                                <div class="tab-pane" id="tentative" role="tabpanel">
                                                                    Tentative
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
                            {{-- End Update Form --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

@endsection
