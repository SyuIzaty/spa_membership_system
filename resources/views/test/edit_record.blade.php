@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">

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
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;">
                            </center><br>
                            <h4 style="text-align: center">
                                <b>ICT EQUIPMENT RENTAL FORM</b>
                            </h4>
                        </div>

                        <div class="panel-container show">
                            <div class="panel-content">
                                <table class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td colspan="6" class="bg-warning text-center">
                                                <h5>Status:
                                                    <b>{{ strtoupper($user->status) }}</b>
                                                </h5>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>

                                {!! Form::open([
                                    'action' => 'TestController@updateApplication',
                                    'method' => 'POST',
                                    'enctype' => 'multipart/form-data',
                                ]) !!}
                                <input type="hidden" name="id" value="{{ $id }}">
                                <table id="rent" class="table table-bordered table-hover table-striped w-100">
                                    <tr>
                                        <th>Name</th>
                                        <td>
                                            <input class="form-control" type="text" name="username" size="40"
                                                required="required" value="{{ $staff->staff_name }}" disabled>
                                        </td>
                                        <th>Designation</th>
                                        <td>
                                            <input class="form-control" type="text" name="des" size="40"
                                                placeholder="Designation" value="{{ $staff->staff_position }}" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Staff ID No</th>
                                        <td>
                                            <input class="form-control" type="text" name="id" size="40"
                                                placeholder="Staff ID No" value="{{ $staff->staff_id }}" disabled>
                                        </td>
                                        <th>HP/ Extension No.</th>
                                        <td>
                                            <input class="form-control" type="text" name="hpno" size="40"
                                                placeholder="Hp/ Extension No." value="{{ $user->hp_no }}" disabled>
                                        </td>
                                    </tr> <br><br>
                                    <tr>
                                        <th>Department</th>
                                        <td>
                                            <input class="form-control" type="text" name="department" size="40"
                                                placeholder="department" value="{{ $staff->staff_dept }}" disabled>
                                        </td>
                                        <th>Room No:</th>
                                        <td>
                                            <input class="form-control" type="text" name="room_no" size="40"
                                                placeholder="Room No" value="{{ $user->room_no }}" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rental date commences</th>
                                        <td>
                                            <input class="form-control" type="text" name="rentdate" size="40"
                                                value="{{ $user->rent_date }}" disabled>
                                        </td>
                                        <th>returned date:</th>
                                        <td>
                                            <input class="form-control" type="text" name="retdate" size="40"
                                                value="{{ $user->return_date }}" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Purpose</th>
                                        <td>
                                            <input class="form-control" type="text" name="purpose" size="40"
                                                placeholder="purpose" value="{{ $user->purpose }}">
                                        </td>
                                    </tr>
                                </table>
                                <div align="right">
                                    <button type="submit" id="btnSubmit"
                                        class="btn btn-primary ml-auto float-center waves-effect waves-themed"><i
                                            class="fal fa-location-arrow"></i> Submit Form</button>
                                    <button style="margin-right:5px" type="reset"
                                        class="btn btn-danger ml-auto float-center waves-effect waves-themed"><i
                                            class="fal fa-redo"></i> Reset</button>
                                </div><br><br>
                                <div class="subheader">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <span class=""> Equipment Rented</span>
                                            </a>
                                        </li>
                                        <p>
                                    </ol>
                                </div>
                                <table class="table table-bordered table-hover table-striped w-80" align="center">
                                    <tr align="center">
                                        <th style="width:200px">Item</th>
                                        <th style="width:400px">Serial Number</th>
                                        <th style="width:400px">Description</th>
                                    </tr>
                                    {{-- take from database --}}
                                    {{-- equipment from controller-fx index --}}
                                    {{-- //get from compact --}}

                                    @foreach ($rent as $rents)
                                        <tr>
                                            <td>{{ $rents->equipment->equipment_name }}</td>
                                            <td>{{ $rents->ser_no }}</td>
                                            <td>{{ $rents->desc }}</td>
                                        </tr>
                                    @endforeach
                                </table><br />
                                {!! Form::close() !!}

                                <div class="btn-group">
                                    {!! Form::open([
                                        'action' => 'TestController@operationVerifyApplication',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button style="margin-top: 5px;"
                                        class="btn btn-warning ml-auto float-right mr-2 mt-2 mb-4 waves-effect waves-themed operationverify"
                                        id="submit" name="submit"><i class="fal fa-check"></i> Verify
                                        Application</button>&nbsp;
                                    {!! Form::close() !!}

                                    {!! Form::open([
                                        'action' => 'TestController@operationRejectApplication',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) !!}
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button style="margin-top: 5px;"
                                        class="btn btn-danger ml-auto float-right mt-2 mb-2 waves-effect waves-themed click"
                                        id="submit" name="submit"><i class="fal fa-times-circle"></i> Reject</button>
                                    {!! Form::close() !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
