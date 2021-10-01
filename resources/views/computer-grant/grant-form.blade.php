@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <h2 style="color: white;">
                        GRANT APPLICATION</b>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <center><img src="{{ asset('img/intec_logo.png') }}" style="height: 120px; width: 270px;"></center><br>

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        @error('hp_no')
                        <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i class="icon fal fa-check-circle"></i> {{ $message }}</div>
                        @enderror

                        @error('office_no')
                        <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i class="icon fal fa-check-circle"></i> {{ $message }}</div>
                        @enderror


                        <div class="panel-container show">
                            <div class="panel-content">

                                @if ($totalApplication >= 100)

                                    <div class="alert alert-success" style="color: #000000; background-color: #fc572e;"> <i class="icon fal fa-check-circle"></i>
                                        Sorry, you are unable to apply for new grant due to registration has reached the total quota.
                                    </div>


                                @elseif ($activeData->isNotEmpty())

                                <div class="alert alert-success" style="color: #000000; background-color: #ffa489;"> <i class="icon fal fa-check-circle"></i>
                                    Sorry, you are unable to apply for new grant due to your grant application is in progress. Kindly view your grant application in table below.
                                </div>

                                @else

                                {!! Form::open(['action' => 'ComputerGrantController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i class="fal fa-user"></i> APPLICANT INFORMATION</label></td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Ticket No : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{$ticket}}</td>
                                                    <th width="20%" style="vertical-align: middle">Staff Email : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{isset($user_details->staff_email) ? $user_details->staff_email : '-'}}</td>
                                                </tr>

                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Staff Name : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{strtoupper($user->name)}}</td>
                                                    <th width="20%" style="vertical-align: middle">Staff ID : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{$user->username}}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Staff Department : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{isset($user_details->staff_dept) ? $user_details->staff_dept : '-' }}</td>
                                                    <th width="20%" style="vertical-align: middle">Staff Designation : </th>
                                                    <td colspan="2" style="vertical-align: middle">{{isset($user_details->staff_position) ? $user_details->staff_position : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Staff H/P No. : </th>
                                                    <td colspan="2"><input class="form-control" id="hp_no" name="hp_no" value="{{ old('hp_no') }}" placeholder="0111234567" required ></td>
                                                    <th width="20%" style="vertical-align: middle"><span class="text-danger">*</span> Staff Office No. : </th>
                                                    <td colspan="2"><input class="form-control" id="office_no" name="office_no" value="{{ old('office_no') }}" placeholder="0111234567" required ></td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Grant Period Eligibility : </th>
                                                    <td colspan="2" style="vertical-align: middle; color: red;"><b>1825 Days (Maximum is 60 Months = 1825 days)</b></td>
                                                    <th width="20%" style="vertical-align: middle">Grant Amount Eligibility : </th>
                                                    <td colspan="2" style="vertical-align: middle; color: red;"><b>RM 1,500</b></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="form-group">
                                            <button style="margin-top: 5px;" class="btn btn-danger float-right" id="submit" name="submit"><i class="fal fa-check"></i> Submit</button></td>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <h2 style="color: white;">
                        GRANT INFORMATION HISTORY</b>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="table-responsive">
                            <table id="application" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <tr class="bg-primary-50 text-center">
                                        <th class="text-center">Ticket No.</th>
                                        <th class="text-center">Staff Department/Position</th>
                                        <th class="text-center">Grant Status</th>
                                        <th class="text-center">Total Price</th>
                                        <th class="text-center">Grant Amount/Period</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Brand/Model/Serial No.</th>
                                        <th class="text-center">Expiry Date</th>
                                        <th class="text-center">Remaining Grant Period</th>
                                        <th class="text-center">Balance Penalty</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                        <td class="hasinput"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



</main>

@endsection

@section('script')
<script>
    $(document).ready(function()
    {
        var table = $('#application').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/datalist",
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'ticket_no', name: 'ticket_no' },
                    { className: 'text-center', data: 'details', name: 'details' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'price', name: 'price' },
                    { className: 'text-center', data: 'amount', name: 'amount' },
                    { className: 'text-center', data: 'type', name: 'type' },
                    { className: 'text-center', data: 'purchase', name: 'purchase' },
                    { className: 'text-center', data: 'expiryDate', name: 'expiryDate' },
                    { className: 'text-center', data: 'remainingPeriod', name: 'remainingPeriod' },
                    { className: 'text-center', data: 'penalty', name: 'penalty' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                orderCellsTop: true,
                "order": [[ 1, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });
    });

</script>
@endsection

