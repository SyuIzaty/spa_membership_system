@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">

    <div class="row">
        <div class="col-md-12 col-sm-12 mb-4">
            <div id="panel-1" class="panel">
                <div class="panel-hdr" style="background-color:rgb(97 63 115)">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <a data-page="/application-pdf/{{ $application->id }}" class="text-primary ml-auto float-right" style="color: purple; cursor: pointer" onclick="Print(this)"><i class="fa-2x fal fa-print"></i></a><br><br>
                        <center><img src="{{ asset('img/intec_logo_new.png') }}" style="height: 120px; width: 320px;"></center><br>
                            <h4 style="text-align: center">
                                <b>I-STATIONERY APPLICATION #{{ $application->id }}</b>
                                    @php
                                        $statusColor = [
                                            'NA' => 'blue',
                                            'PA' => 'orange',
                                            'RC' => 'purple',
                                            'AC' => 'red',
                                            'RV' => 'black',
                                            'RA' => 'black',
                                        ];

                                        $color = $statusColor[$application->current_status] ?? 'green';
                                    @endphp
                                    <p><span style="text-transform: uppercase; font-size: 15px; color: {{ $color }}"><b>[ {{ $application->status->status_name ?? 'N/A' }} ]</b></span></p>
                            </h4>
                        <div class="panel-container show">
                            <div class="panel-content">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" style="color: #3b6324"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                @endif
                                @php
                                    $trackData = \App\IsmApplicationTrack::where('application_id', $application->id)
                                        ->where('status_id', $application->current_status)
                                        ->first();
                                @endphp
                                <div class="table-responsive">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <i class="fal fa-user"></i>
                                                <span class=""> APPLICANT INFORMATION</span>
                                            </a>
                                        </li>
                                        <p></p>
                                    </ol>
                                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                                        <tr>
                                            <th style="vertical-align: middle">Name : </th>
                                            <td  style="vertical-align: middle; text-transform: uppercase">{{ $application->staff->staff_name }} ({{ $application->applicant_id }})</td>
                                            <th  style="vertical-align: middle">Email : </th>
                                            <td  style="vertical-align: middle">{{ $application->applicant_email }}</td>
                                        </tr>
                                        <tr>
                                            <th  style="vertical-align: middle">Department : </th>
                                            <td  style="vertical-align: middle; text-transform: uppercase">{{ $application->department->department_name }}</td>
                                            <th  style="vertical-align: middle">Phone Number : </th>
                                            <td  style="vertical-align: middle; text-transform: uppercase">{{ $application->applicant_phone }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                        <li>
                                            <a href="#" disabled style="pointer-events: none">
                                                <i class="fal fa-info"></i>
                                                <span class=""> STATIONERY INFORMATION</span>
                                            </a>
                                        </li>
                                        <p></p>
                                    </ol>
                                    {!! Form::open(['action' => ['Stationery\StationeryManagementController@application_verify'], 'method' => 'POST', 'id' => 'verifyData', 'enctype' => 'multipart/form-data'])!!}
                                        {{Form::hidden('id', $application->id)}}
                                        @can('Manage Stationery')
                                            @if($application->current_status == 'NA')
                                                <div class="form-group">
                                                    <label class="form-label" for="status"><span class="text-danger">*</span> Application Status :</label>
                                                    <select class="form-control" id="status" name="status" required>
                                                        <option value="" disabled selected>Please select</option>
                                                        <option value="1" {{ old('status') == '1' ? 'selected':''}}>Accept Application</option>
                                                        <option value="0" {{ old('status') == '0' ? 'selected':''}}>Reject Application</option>
                                                    </select>
                                                    @error('status')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                </div>

                                                <div class="form-group rejStationery" style="display: none;">
                                                    <label class="form-label" for="remark"><span class="text-danger">*</span> Remark :</label>
                                                    <textarea rows="3" class="form-control" id="remark" name="remark" required>{{ old('remark') }}</textarea>
                                                    @error('remark')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                </div>
                                            @endif
                                        @endcan

                                        <div class="form-group" id="stationery">
                                            <table class="table table-bordered table-hover table-striped w-100 text-center">
                                                <tr class="bg-primary-50">
                                                    <th>No</th>
                                                    <th>Item/Description</th>
                                                    <th>Request Quantity</th>
                                                    <th>Request Remark</th>
                                                    @if(!in_array($application->current_status, ['RV', 'RA']))
                                                        @if($application->applicant_id == Auth::user()->id && !Auth::user()->hasPermissionTo('Manage Stationery'))
                                                            @if(in_array($application->current_status, ['AC', 'CP', 'RC']))
                                                                <th>Approve Quantity</th>
                                                                <th>Approve Remark</th>
                                                            @endif
                                                        @else
                                                            @if(Auth::user()->hasPermissionTo('Manage Stationery'))
                                                                @if($application->current_status == 'NA')
                                                                    <th class="appStationery" style="display: none;">Approve Quantity</th>
                                                                    <th class="appStationery" style="display: none;">Approve Remark</th>
                                                                @else
                                                                    <th>Approve Quantity</th>
                                                                    <th>Approve Remark</th>
                                                                @endif
                                                            @else
                                                                @if(in_array($application->current_status, ['PA', 'AC', 'CP', 'RC']))
                                                                    <th>Approve Quantity</th>
                                                                    <th>Approve Remark</th>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                </tr>
                                                @foreach($application->stationeries as $stationery)
                                                {{ Form::hidden('stationery_id[]', $stationery->id) }}
                                                    <tr>
                                                        <td style="vertical-align:middle">{{ $loop->iteration }}</td>
                                                        <td align="left" style="vertical-align:middle">{{ $stationery->stock->stock_name ?? 'N/A' }}</td>
                                                        <td style="vertical-align:middle">{{ $stationery->request_quantity ?? 'N/A' }}</td>
                                                        <td style="vertical-align:middle">{{ $stationery->request_remark ?? 'N/A' }}</td>
                                                        @if(!in_array($application->current_status, ['RV', 'RA']))
                                                            @if($application->applicant_id == Auth::user()->id && !Auth::user()->hasPermissionTo('Manage Stationery'))
                                                                @if(in_array($application->current_status, ['AC', 'CP', 'RC']))
                                                                    <td>{{ $stationery->approve_quantity ?? 'N/A' }}</td>
                                                                    <td>{{ $stationery->approve_remark ?? 'N/A' }}</td>
                                                                @endif
                                                            @else
                                                                @if(Auth::user()->hasPermissionTo('Manage Stationery'))
                                                                    @if($application->current_status == 'NA')
                                                                        <td class="appStationery" style="display: none;">
                                                                            @php
                                                                                $total_bal = 0;
                                                                                $stockId = $stationery->stock_id;
                                                                                $stockData = \App\Stock::where('id', $stockId)->first();

                                                                                if ($stockData) {
                                                                                    foreach ($stockData->transaction as $list) {
                                                                                        $total_bal += ($list->stock_in - $list->stock_out);
                                                                                    }

                                                                                    $numbers = $total_bal > 0 ? range(1, $total_bal) : [];
                                                                                }
                                                                            @endphp
                                                                            <select class="form-control approve_quantity" name="approve_quantity[]" id="approve_quantity_{{ $loop->index }}">
                                                                                <option value="" disabled selected>Please select</option>
                                                                                @foreach ($numbers as $value)
                                                                                    <option value="{{ $value }}" {{ old('approve_quantity') !== null && old('approve_quantity') == $value ? 'selected' : '' }}>
                                                                                        {{ $value }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td class="appStationery" style="display: none;">
                                                                            <input class="form-control" id="approve_remark" name="approve_remark[]" value="{{ old('approve_remark') }}">
                                                                        </td>
                                                                    @else
                                                                        <td>{{ $stationery->approve_quantity ?? 'N/A' }}</td>
                                                                        <td>{{ $stationery->approve_remark ?? 'N/A' }}</td>
                                                                    @endif
                                                                @else
                                                                    @if(in_array($application->current_status, ['PA', 'AC', 'CP', 'RC']))
                                                                        <td>{{ $stationery->approve_quantity ?? 'N/A' }}</td>
                                                                        <td>{{ $stationery->approve_remark ?? 'N/A' }}</td>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                        @if($application->applicant_id == Auth::user()->id)
                                            <div class="table-responsive">
                                                <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                    <li>
                                                        <a href="#" disabled style="pointer-events: none">
                                                            <i class="fal fa-check-square"></i>
                                                            <span class=""> CONSENT VERIFICATION</span>
                                                        </a>
                                                    </li>
                                                    <p></p>
                                                </ol>
                                                <table id="verification" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <div class="form-group">
                                                                <td colspan="4"><p class="form-label" for="applicant_verification">
                                                                <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px" type="checkbox" @if($application->applicant_verification == 'Y') disabled checked @endif/>
                                                                ALL INFORMATION PROVIDED ARE ACCURATE. I CONSENT TO BE CONTACTED FOR ANY FURTHER INQUIRIES RELATED TO THE SUBMITTED APPLICATION.
                                                            </div>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            @if($application->current_status == 'CP')
                                                <div class="table-responsive">
                                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                        <li>
                                                            <a href="#" disabled style="pointer-events: none">
                                                                <i class="fal fa-check-square"></i>
                                                                <span class=""> CONFIRMATION</span>
                                                            </a>
                                                        </li>
                                                        <p></p>
                                                    </ol>
                                                    <table id="verification" class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="4"><p class="form-label">
                                                                    <input style="margin-top: 15px; margin-right: 30px; margin-left: 15px" type="checkbox" disabled checked/>
                                                                        THIS APPLICATION HAVE BEEN SUCCESSFULLY CONFIRMED ON
                                                                        {{ isset($trackData->created_at) ? date('d-m-Y', strtotime($trackData->created_at)) . ' ( '. date('l', strtotime($trackData->created_at)) .' ) | ' . date('h:i A', strtotime($trackData->created_at)).'.' : 'N/A' }}
                                                                </div>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            @endif
                                            @if($application->current_status == 'RV' || $application->current_status == 'RA')
                                                <div class="table-responsive">
                                                    <ol class="breadcrumb breadcrumb-md breadcrumb-arrow">
                                                        <li>
                                                            <a href="#" disabled style="pointer-events: none">
                                                                <i class="fal fa-eye"></i>
                                                                <span class=""> REJECTION INFORMATION</span>
                                                            </a>
                                                        </li>
                                                        <p></p>
                                                    </ol>
                                                    <table id="info" class="table table-bordered table-hover w-100">
                                                        <tr>
                                                            <th style="vertical-align: middle">Remark : </th>
                                                            <td  style="vertical-align: middle">{{ ucwords($trackData->remark) ?? 'N/A' }}</td>
                                                            <th  style="vertical-align: middle">Date : </th>
                                                            <td  style="vertical-align: middle">{{ isset($trackData->created_at) ? date('d-m-Y', strtotime($trackData->created_at)) . ' | ' . date('h:i A', strtotime($trackData->created_at)) : 'N/A' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            @endif
                                        @endif

                                        @if(Auth::user()->hasPermissionTo('Manage Stationery'))
                                            @if($application->current_status == 'NA')
                                                <button type="submit" id="verifyBtn" class="btn btn-primary ml-2 float-right"><i class="fal fa-save"></i> Verify Application</button>
                                             @endif
                                        @endif
                                    {!! Form::close() !!}

                                    @unless(Auth::user()->hasPermissionTo('Manage Stationery'))
                                        @if(Auth::user()->hasPermissionTo('Manage Approval'))
                                            @if($application->current_status == 'PA')
                                                {!! Form::open(['action' => ['Stationery\StationeryManagementController@application_approve'], 'method' => 'POST', 'id' => 'approveData', 'enctype' => 'multipart/form-data'])!!}
                                                {{Form::hidden('id', $application->id)}}
                                                {{Form::hidden('status', 'RC')}}
                                                    <button type="submit" id="approveBtn" class="btn btn-primary ml-2 float-right"><i class="fal fa-check-circle"></i> Accept Application</button>
                                                {!! Form::close() !!}
                                                <a href="#" class="btn btn-danger ml-2 float-right" id="rejectButton"><i class="fal fa-times-circle"></i> Reject Application</a>
                                            @endif
                                        @else
                                            @if($application->current_status == 'AC')
                                                {!! Form::open(['action' => ['Stationery\StationeryManagementController@application_confirm'], 'method' => 'POST', 'id' => 'confirmData', 'enctype' => 'multipart/form-data'])!!}
                                                {{Form::hidden('id', $application->id)}}
                                                        <button type="submit" id="confirmBtn" class="btn btn-primary ml-2 float-right"><i class="fal fa-check-circle"></i> Confirm Application</button>
                                                {!! Form::close() !!}
                                            @endif
                                        @endif
                                    @endunless

                                    @if(Auth::user()->hasPermissionTo('Manage Stationery'))
                                        @if($application->current_status == 'RC' || $application->current_status == 'AC')
                                            {!! Form::open(['action' => ['Stationery\StationeryManagementController@application_reminder'], 'method' => 'POST', 'id' => 'reminderData', 'enctype' => 'multipart/form-data']) !!}
                                            {{ Form::hidden('id', $application->id) }}
                                            {{ Form::hidden('status', 'AC') }}
                                                <button type="submit" id="reminderBtn" class="btn btn-danger ml-2 float-right"><i class="fal fa-location-arrow"></i> Send Reminder</button>
                                            {!! Form::close() !!}
                                        @endif
                                    @endif

                                    @if(Auth::user()->hasPermissionTo('Manage Approval') || Auth::user()->hasPermissionTo('Manage Stationery'))
                                        <?php
                                            $previousPageUrl = url()->previous();
                                        ?>
                                        @if (Str::contains($previousPageUrl, '/application-list'))
                                            <a href="/application-list" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                        @else
                                            @if($application->current_status == 'RA' || $application->current_status == 'RV')
                                                <a href="/stationery-manage/RV" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                            @else
                                                <a href="/stationery-manage/{{ $application->current_status }}" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                            @endif
                                        @endif
                                    @else
                                        <a href="/application-list" class="btn btn-success ml-auto float-right" ><i class="fal fa-arrow-alt-left"></i> Back</a><br>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::user()->hasPermissionTo('Manage Stationery') || Auth::user()->hasPermissionTo('Manage Approval'))
            <div class="col-md-12 col-sm-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title w-100"><i class="fal fa-cog width-2 fs-xl"></i>APPLICATION TRACK</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="log" class="table table-bordered w-100 text-center">
                                <tr class="bg-primary-50" style="white-space: nowrap">
                                    <th>STATUS</th>
                                    <th>REMARK</th>
                                    <th>DATE</th>
                                    <th>CHANGED BY</th>
                                </tr>
                                @foreach($application->applicationTracks as $track)
                                    <tr>
                                        <td>
                                            @php
                                                $statusColor = [
                                                    'NA' => 'blue',
                                                    'PA' => 'orange',
                                                    'RC' => 'purple',
                                                    'AC' => 'red',
                                                    'RV' => 'black',
                                                    'RA' => 'black',
                                                ];

                                                $color = $statusColor[$track->status_id] ?? 'green';
                                            @endphp
                                            <span style="text-transform: uppercase; color: {{ $color }}"><b>{{ $track->status->status_name ?? 'N/A' }}</b></span>
                                            @if($track->status_id == 'AC')
                                                <br><sub>Reminder : {{ $track->confirmationReminders->count() ?? 'N/A'}}</sub>
                                            @endif
                                        </td>
                                        <td>{{ isset($track->remark) ? ucwords($track->remark) : 'N/A' }}</td>
                                        <td>{{ isset($track->created_at) ? date('d-m-Y', strtotime($track->created_at)) . ' | ' . date('h:i A', strtotime($track->created_at)) : 'N/A' }}</td>
                                        <td>{{ $track->staff->staff_name ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</main>

@endsection

@section('script')
<script>

    $(document).ready(function() {

        $('#status').select2();

        $('.approve_quantity').each(function() {

            $(this).select2();

        });

        $('#status').change(function () {

            var selectedOption = $(this).val();

            $('.appStationery, .rejStationery').hide();

            $('#remark').prop('required', false);

            if (selectedOption == '1') {

                $('.appStationery').show();

            } else if (selectedOption == '0') {

                $('.rejStationery').show();

                $('#remark').prop('required', true);
            }

            $('#stationery').show();
        });

        $("#verifyData").submit(function () {

            $("#verifyBtn").attr("disabled", true);

            return true;

        });

    });

    document.addEventListener('DOMContentLoaded', function () {
        const verifyBtn = document.getElementById('verifyBtn');
        const verifyForm = document.getElementById('verifyData');

        verifyBtn.addEventListener('click', function () {
            event.preventDefault();

            if (verifyForm.checkValidity()) {
                Swal.fire({
                    title: 'Application Verification',
                    text: 'Are you sure you want to verify this application?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        verifyForm.submit();
                    } else {
                        //
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all required fields!',
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const approveBtn = document.getElementById('approveBtn');
        const approveForm = document.getElementById('approveData');

        approveBtn.addEventListener('click', function () {
            event.preventDefault();

            Swal.fire({
                title: 'Application Approval',
                text: 'Are you sure you want to approve this application?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    approveForm.submit();
                } else {
                    //
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const reminderBtn = document.getElementById('reminderBtn');
        const reminderForm = document.getElementById('reminderData');

        reminderBtn.addEventListener('click', function () {
            event.preventDefault();

            Swal.fire({
                title: 'Application Reminder',
                text: 'Are you sure you want to send a reminder for this application?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    reminderForm.submit();
                } else {
                    //
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const confirmBtn = document.getElementById('confirmBtn');
        const confirmForm = document.getElementById('confirmData');

        confirmBtn.addEventListener('click', function () {
            event.preventDefault();

            Swal.fire({
                title: 'Application Confirmation',
                text: 'Are you sure you want to confirm this application?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    confirmForm.submit();
                } else {
                    //
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on('click', '#rejectButton', function () {
            Swal.fire({
                title: 'Reject Application',
                html: '<p>You are about to reject this application.</p><textarea id="rejectReason" class="form-control" placeholder="Fill rejection reason" required></textarea>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reject it!',
                cancelButtonText: 'Cancel',
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        const rejectReason = document.getElementById('rejectReason').value;
                        const status = 'RA';
                        const id = '<?php echo $application->id; ?>';

                        if (!rejectReason) {
                            Swal.showValidationMessage('Rejection reason is required.');
                            resolve(false); // Reject the promise, preventing further processing
                        } else {
                            $.ajax({
                                method: 'POST',
                                url: '/application-approve',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    rejectReason: rejectReason,
                                    status: status,
                                    id: id,
                                },
                                success: function (response) {
                                    Swal.fire('Success', response.message, 'success').then(() => {
                                        window.location.reload();
                                    });
                                    resolve(false); // Resolve the promise after showing the success popup
                                },
                                error: function (xhr) {
                                    Swal.fire('Error', 'Error rejecting the application: ' + xhr.statusText, 'error');
                                    resolve(false); // Resolve the promise in case of an error
                                }
                            });
                        }
                    });
                }
            });
        });
    });

    function Print(button)
    {
        var url = $(button).data('page');
        var printWindow = window.open( '{{url("/")}}'+url+'', 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
        printWindow.addEventListener('load', function(){
            printWindow.print();
        }, true);
    }

</script>
@endsection

