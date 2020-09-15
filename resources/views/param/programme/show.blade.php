@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    {{-- <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
        <li class="breadcrumb-item">Page Views</li>
        <li class="breadcrumb-item active">Profile</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol> --}}
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Programme Information
            {{-- <small>
                Register Supervisor, Co-Supervisor & Advisor
            </small> --}}
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        View Programme :<span class="fw-300"><i> {{ $programme->programme_name }}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <table id="programs" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <td width="15%"><b>PROGRAMME ID :</b></td>
                                    <td width=""><strong>{{ strtoupper($programme->id) }}</strong></td>
                                    {{-- <td width="">{{ $programme->id }}</td> --}}
                                    <td width="15%"><b>PROGRAMME CODE :</b></td>
                                    <td width=""><strong>{{ strtoupper($programme->programme_code) }}</strong></td>
                                </tr>
                                <tr>
                                    <td width="15%"><b>PROGRAMME NAME :</b></td>
                                    <td width=""><strong>{{ strtoupper($programme->programme_name) }}</strong></td>
                                    <td width="15%"><b>PROGRAMME SCROLL NAME :</b></td>
                                    <td width=""><strong>{{ strtoupper($programme->scroll_name) }}</strong></td>
                                </tr>
                                <tr>
                                    <td width="15%"><b>PROGRAMME NAME [MALAY] :</b></td>
                                    <td width="15%"><strong>{{ strtoupper($programme->programme_name_malay) }}</strong></td>
                                    <td width="15%"><b>PROGRAMME SCROLL NAME [MALAY] :</b></td>
                                    <td width="15%"><strong>{{ strtoupper($programme->scroll_name_malay) }}</strong></td>
                                </tr>
                                <tr>
                                    <td width="15%"><b>PROGRAMME DURATION :</b></td>
                                    <td width="15%"><strong>{{ strtoupper($programme->programme_duration) }}</strong></td>
                                    <td width="15%"><b>PROGRAMME STATUS :</b></td> 
                                    {{-- <td width="15%"><strong>{{ strtoupper($programme->programme_status) }}</strong></td> --}}
                                    <td width="15%"><strong>{{ strtoupper($programme->programme_status ? 'Active' : 'Inactive') }}<strong></td>
                                </tr>
                                
                            </thead>
                        </table>
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href="/param/programme/{{$programme->id}}/edit" class="btn btn-warning ml-auto float-right"><i class="fal fa-pencil"></i> Edit</a> 
                        <a style="margin-right:5px" href="{{ url()->previous() }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
@endsection

