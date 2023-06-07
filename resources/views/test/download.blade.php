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
                            <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 80px; width: 260px;">
                            </center>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <br>
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
                                    </tr> 
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
                                            <input class="form-control" type="text" name="retdate" size="40"
                                                value="{{ $user->purpose }}" disabled>
                                        </td>
                                    </tr>
                                </table>
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
                                    @foreach ($rent as $rents)
                                        <tr>
                                            <td>{{ $rents->equipment->equipment_name }}</td>
                                            <td>{{ $rents->ser_no }}</td>
                                            <td>{{ $rents->desc }}</td>
                                        </tr>
                                    @endforeach
                                </table><br>
                                {!! Form::close() !!}

                                <h6>1. I agree to be responsible for all the equipment I am renting, as documented on this
                                    form.</h6>
                                <h6>2. Borrowed equipment will be returned no later than 1 DAY after the last date of use.
                                </h6>
                                <h6>3. I may be subject to action if I do not comply with the rules.</h6><br><br><br>
                                <table>
                                    <tr>
                                        <th>.......................................</th>
                                        <th></th>
                                        <th>.......................................</th>
                                    </tr>
                                    <tr>
                                        <td>Application's Signature</td>
                                        <td></td>
                                        <td>Checked Out By :</td>
                                    </tr>
                                    <tr>
                                        <td>Date :</td>
                                        <td width="400">&nbsp;</td>
                                        <td>Date :</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Stamp :</td>
                                    </tr>
                                </table><br>
                                <div class="subheader">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <span class=""> Returned Equipment</span>
                                            </a>
                                        </li>
                                        <p>
                                    </ol>
                                </div><br>
                                <table>
                                    <tr>
                                        <th>.......................................</th>
                                        <th></th>
                                        <th>.......................................</th>
                                    </tr>
                                    <tr>
                                        <td>Application's Signature</td>
                                        <td width="400">&nbsp;</td>
                                        <td>Checked Out By :</td>
                                    </tr>
                                    <tr>
                                        <td>Date :</td>
                                        <td></td>
                                        <td>Date :</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Stamp :</td>
                                    </tr>
                                </table>
                                <a href="javascript:window.print()" download="document.docx" class="btn btn-primary float-center waves-effect waves-themed">Download File</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection