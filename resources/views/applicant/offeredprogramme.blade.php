@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Offered Programme
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Offered Programme</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <span id="intake_fail"></span>
                            {!! Form::open(['action' => ['ApplicantController@sendupdateApplicant'], 'method' => 'POST'])!!}
                            {{-- <button type="submit" class="btn btn-primary pull-right mb-3 float-right"><i class="fal fa-envelope"></i> Send Email & Update Status</button> --}}
                            @if(session()->has('message'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <strong>{{ session()->get('message') }}</strong>
                                </div>
                            @endif
                            <table class="table table-bordered" id="rejected">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th>NO</th>
                                        <th>PROGRAMME CODE</th>
                                        <th>BATCH CODE</th>
                                        <th>TOTAL APPLICANT</th>
                                        <th>EMAIL SEND</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($intake->first()->intakeDetails as $intakes)
                                        <tr>
                                            <td>{{ $intakes->id }}</td>
                                            <input type="hidden" name="intake_id" value="{{ $intakes->intake_code }}">
                                            <td>{{ $intakes->intake_programme }}</td>
                                            <td>{{ $intakes->batch_code }}</td>
                                            <td>{{ $intakes->applicant->count() }}</td>
                                            <td>{{ $intakes->applicant->where('email_sent','1')->count() }}/{{ $intakes->applicant->count() }}</td>
                                            <td>
                                                @if($intakes['intake_quota'] == '1')
                                                <input type="checkbox" name="check[]" value="{{ $intakes->batch_code }}">
                                                @else
                                                <div class="badge border border-danger text-danger">Insufficient Quota</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted d-flex  pull-right">
                                <button type="submit" class="btn btn-success float-right ml-auto"><i class="fal fa-envelope"></i> Send Email & Update Status</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
