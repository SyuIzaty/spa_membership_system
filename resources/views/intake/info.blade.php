@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Intake
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Intake</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="pull-right mb-4">
                                <a class="btn btn-success" href="{{ route('intake.create') }}"> Create Intake Type</a>
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Intake Code</th>
                                    <th>Intake Description</th>
                                    <th>Application Start Date</th>
                                    <th>Application End Date</th>
                                    <th>Check Status Start Date </th>
                                    <th>Check Status End Date</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($intakeInfo as $intakeInfos)
                                    <tr>
                                        <td>{{$intakeInfos['intake_code']}}</td>
                                        <td>{{$intakeInfos['intake_description']}}</td>
                                        <td>{{$intakeInfos['intake_app_open']}}</td>
                                        <td>{{$intakeInfos['intake_app_close']}}</td>
                                        <td>{{$intakeInfos['intake_check_open']}}</td>
                                        <td>{{$intakeInfos['intake_check_close']}}</td>
                                        <td>
                                            {{-- <p><input type="checkbox" @if($intakeInfos['status'] == "Active") checked @endif data-toggle="toggle" data-on="Active" data-off="Inactive" data-onstyle="success" ></p>
                                            <a class="btn btn-primary" href="{{ route('intake.edit',$intakeInfos['intake_id']) }}">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button> --}}
                                        </td>
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