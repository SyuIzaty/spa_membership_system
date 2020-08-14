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
            <i class='subheader-icon fal fa-plus-circle'></i> Room Owner Information
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
                        View <span class="fw-300"><i>Room Owner {{ $roomowner->name }}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <table id="roomowner" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                                <tr>
                                    <td width="21%"><b>IMAGE :</b></td>
                                    <td colspan="2"><center><img src="{{ asset('storage/space/'.$roomowner->image) }}" style="height: 200px; width: 200px;"></center></td>
                                </tr>
                                <tr>
                                    <td width="21%"><b>OWNER NAME :</b></td>
                                    <td colspan="2">{{ $roomowner->name }}</td>
                                </tr>
                                <tr>
                                    <td width="21%"><b>PHONE NUMBER :</b></td>
                                    <td colspan="2">{{ $roomowner->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td width="21%"><b>EMAIL :</b></td>
                                    <td colspan="2">{{ $roomowner->email }}</td>
                                </tr>
                                <tr>
                                    <td width="21%"><b>DATE OF BIRTH :</b></td>
                                    <td colspan="2">{{ date('jS F Y', strtotime($roomowner->dateofbirth)) }}</td>
                                    {{-- <td>{{ date('d-M-y D', strtotime($expenses->date)) }}</td> --}}
                                </tr>
                                <tr>
                                    <td width="21%"><b>GENDER :</b></td>
                                    <td colspan="2">{{ ucfirst($roomowner->gender) }}</td> {{--ucfirst() to capitalize first word, strtoupper() for uppercase --}}
                                </tr>
                                <tr>
                                    <td width="21%"><b>ACTIVE STATUS :</b></td>
                                    <td colspan="2">{{ $roomowner->active }}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href="/space/roomowner/{{$roomowner->id}}/edit" class="btn btn-warning ml-auto float-right"><i class="fal fa-pencil"></i> Edit</a> 
                        <a style="margin-right:5px" href="{{ URL::route('roomowner.index') }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection

