@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-car'></i> e-Kenderaan
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr bg-primary">
                        <h2 style="color: white;">
                            e-KENDERAAN APPLICATION</b>
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
                            <center><img src="{{ asset('img/INTEC_PRIMARY_LOGO.png') }}" style="width: 300px;"></center>
                            <br>
                            <div class="row">
                                <div class="col-sm-6 col-xl-6">
                                    <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            @if ($data->hod_hop_approval != null)
                                                @if ($data->hod_hop_approval == 'Y')
                                                    Approved
                                                @endif
                                                @if ($data->hod_hop_approval == 'N')
                                                    Rejected
                                                @endif
                                            @else
                                                Pending
                                            @endif
                                            <small class="m-0 l-h-n">HOD/HOP</small>
                                        </h3>
                                        <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                                            style="font-size:6rem"></i>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xl-6">
                                    <div class="p-3 bg-info-100 rounded overflow-hidden position-relative text-white mb-g">
                                        <h3 class="display-5 d-block l-h-n m-0 fw-500">
                                            @if ($data->operation_approval != null)
                                                @if ($data->operation_approval == 'Y')
                                                    Approved
                                                @endif
                                                @if ($data->operation_approval == 'N')
                                                    Rejected
                                                @endif
                                            @else
                                                Pending
                                            @endif
                                            <small class="m-0 l-h-n">Operation</small>
                                        </h3>
                                        <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                                            style="font-size:6rem"></i>
                                    </div>
                                </div>
                            </div>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            @error('hp_no')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-check-circle"></i> {{ $message }}
                                </div>
                            @enderror

                            @error('driver')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-check-circle"></i> {{ $message }}
                                </div>
                            @enderror

                            @error('vehicle')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-check-circle"></i> {{ $message }}
                                </div>
                            @enderror


                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="bg-warning text-center">
                                                        <h5>Status:
                                                            <b>{{ strtoupper($data->statusList->name) }}</b>
                                                        </h5>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        @if ($data->hod_hop_approval == 'N')
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="6" class="bg-warning-50"><label class="form-label">
                                                                <i class="fal fa-user"></i> HOD/HOP REMARK</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">{{ $remark->remark }}</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        @elseif($data->operation_approval == 'N')
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="6" class="bg-warning-50"><label class="form-label">
                                                                <i class="fal fa-user"></i> OPERATION REMARK</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">{{ $remark->remark }}</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        @endif
                                    </div>
                                    <div class="table-responsive">
                                        <table id="applicant" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="bg-primary-50"><label class="form-label">
                                                            <i class="fal fa-file"></i> APPLICANT INFORMATION</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">Name</th>
                                                    <td style="vertical-align: middle">
                                                        <input class="form-control" value="{{ $name }}" readonly>
                                                    </td>
                                                    <th style="vertical-align: middle">ID</th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        <input class="form-control" value="{{ $data->intec_id }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">Department/Programme</th>
                                                    <td style="vertical-align: middle">
                                                        <input class="form-control" value="{{ $progfac }}" readonly>
                                                    </td>
                                                    <th style="vertical-align: middle">H/P No.</th>
                                                    <td colspan="2">
                                                        <input class="form-control" value="{{ $data->phone_no }}"
                                                            readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">
                                                        Departure Date</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $departdate }}" readonly>
                                                    </td>
                                                    <th style="vertical-align: middle">
                                                        Departure Time</th>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control"
                                                            value="{{ $departtime }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">
                                                        Return Date</th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $returndate }}" readonly>
                                                    </td>
                                                    <th style="vertical-align: middle">
                                                        Return Time</th>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control"
                                                            value="{{ $returntime }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">
                                                        Destination (Full Address)</th>
                                                    <td colspan="5" style="vertical-align: middle">
                                                        <textarea class="form-control" id="example-textarea" rows="3" readonly>{{ $data->destination }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">
                                                        Waiting Area</th>
                                                    <td colspan="5">
                                                        <input type="text" class="form-control"
                                                            value="{{ $data->waitingArea->department_name }}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">
                                                        Purpose</th>
                                                    <td colspan="5" style="vertical-align: middle">
                                                        <textarea class="form-control" id="example-textarea" rows="3"readonly>{{ $data->purpose }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align: middle">Attachment</th>
                                                    <td colspan="5">
                                                        @if (isset($file->id))
                                                            <a class="btn btn-primary" target="_blank"
                                                                href="/get-file-attachment/{{ $file->id }}">
                                                                <i class="fal fa-download"></i> {{ $file->upload }}
                                                            </a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table class="table table-bordered table-hover table-striped w-100 testing">
                                            <thead>
                                                <tr>
                                                    <td colspan="6" class="bg-primary-50"><label class="form-label">
                                                            <i class="fal fa-user"></i> PASSENGER DETAILS</label>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="table-responsive">
                                            <table id="passenger"
                                                class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr class="bg-success-50 text-center">
                                                        <th class="text-center">NO.</th>
                                                        <th class="text-center">NAME</th>
                                                        <th class="text-center">FACULTY/PROGRAMME</th>
                                                        <th class="text-center">IC</th>
                                                        <th class="text-center">ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="hasinput"></td>
                                                        <td class="hasinput"></td>
                                                        <td class="hasinput"></td>
                                                        <td class="hasinput"></td>
                                                        <td class="hasinput"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @if ($data->operation_approval == 'Y')
                                            <table class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50">
                                                            <label class="form-label"><i class="fal fa-car"></i>
                                                                Operation</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top">Driver</th>
                                                        <td colspan="4" style="vertical-align: middle">
                                                            {{ $data->driverList->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top">Vehicle</th>
                                                        <td colspan="4" style="vertical-align: middle">
                                                            {{ $data->vehicleList->name }} -
                                                            {{ $data->vehicleList->plate_no }}
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        @endif
                                    </div>
                                    @if ($data->status == '1')
                                        @canany('Verify eKenderaan Application')
                                            {{-- HOD/HOP REJECT APPLICATION --}}
                                            <button
                                                class="btn btn-danger ml-auto float-right waves-effect waves-themed click mt-2 mb-2">
                                                <i class="fal fa-times-circle"></i>
                                                Reject
                                            </button>
                                            <div class="remark mt-2">
                                                {!! Form::open([
                                                    'action' => 'EKenderaanController@rejectApplication',
                                                    'method' => 'POST',
                                                    'enctype' => 'multipart/form-data',
                                                ]) !!}
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <input type="hidden" id="id" name="id"
                                                                value="{{ $data->id }}" required>
                                                            <tr>
                                                                <td colspan="5" class="bg-primary-50">
                                                                    <label class="form-label"><i class="fal fa-pencil"></i>
                                                                        REMARK</label>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed float-right reject-cancel">
                                                                        <i class="fal fa-times"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="20%" style="vertical-align: top"><span
                                                                        class="text-danger">*</span> Reason : </th>
                                                                <td colspan="4" style="vertical-align: middle">
                                                                    <textarea class="form-control" maxlength="255" id="textarea" rows="3"
                                                                        placeholder="Please fill in rejection reason" name="remark" required></textarea>
                                                                    <span style="font-size: 10px; color: red;"><i>*Limit to 255
                                                                            characters only</i></span>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                @csrf
                                                <input type="hidden" id="id" name="id"
                                                    value="{{ $data->id }}">
                                                <button type="submit"
                                                    class="btn btn-danger ml-auto float-right mt-2 mb-2 waves-effect waves-themed"
                                                    id="reject"><i class="fal fa-times-circle"></i> Submit
                                                </button>
                                                {!! Form::close() !!}
                                            </div>

                                            {{-- HOD/HOP VERIFY APPLICATION --}}
                                            {!! Form::open([
                                                'action' => 'EKenderaanController@verifyApplication',
                                                'method' => 'POST',
                                                'enctype' => 'multipart/form-data',
                                            ]) !!}
                                            <input type="hidden" id="id" name="id"
                                                value="{{ $data->id }}">
                                            <button type="submit"
                                                class="btn btn-warning ml-auto float-right mr-2 mt-2 mb-4 waves-effect waves-themed verify">
                                                <i class="fal fa-check"></i> Verify Application
                                            </button>
                                            {!! Form::close() !!}
                                        @endcanany
                                    @elseif ($data->status == '2')
                                        {{-- OPERATION REJECT APPLICATION --}}
                                        @canany('Manage and Verify eKenderaan Application')
                                            <button
                                                class="btn btn-danger ml-auto float-right mt-2 mb-2 waves-effect waves-themed click">
                                                <i class="fal fa-times-circle"></i> Reject
                                            </button>
                                            <div class="remark mt-2">
                                                {!! Form::open([
                                                    'action' => 'EKenderaanController@operationRejectApplication',
                                                    'method' => 'POST',
                                                    'enctype' => 'multipart/form-data',
                                                ]) !!}
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <input type="hidden" id="id" name="id"
                                                                value="{{ $data->id }}" required>
                                                            <tr>
                                                                <td colspan="5" class="bg-primary-50">
                                                                    <label class="form-label"><i class="fal fa-pencil"></i>
                                                                        REMARK</label>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed float-right reject-cancel">
                                                                        <i class="fal fa-times"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="20%" style="vertical-align: top"><span
                                                                        class="text-danger">*</span> Reason</th>
                                                                <td colspan="4" style="vertical-align: middle">
                                                                    <textarea class="form-control" maxlength="255" id="textarea" rows="3"
                                                                        placeholder="Please fill in rejection reason" name="remark" required></textarea>
                                                                    <span style="font-size: 10px; color: red;"><i>*Limit to 255
                                                                            characters only</i></span>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                @csrf
                                                <input type="hidden" id="id" name="id"
                                                    value="{{ $data->id }}">
                                                <button type="submit"
                                                    class="btn btn-danger ml-auto float-right mt-2 mb-2 waves-effect waves-themed"
                                                    id="reject"><i class="fal fa-times-circle"></i> Submit
                                                </button>
                                                {!! Form::close() !!}
                                            </div>

                                            {{-- OPERATION VERIFY APPLICATION --}}
                                            <button
                                                class="btn btn-warning ml-auto float-right mr-2 mt-2 mb-4 waves-effect waves-themed operationverify">
                                                <i class="fal fa-check"></i> Verify Application
                                            </button>
                                            <div class="operation mt-2">
                                                {!! Form::open([
                                                    'action' => 'EKenderaanController@operationVerifyApplication',
                                                    'method' => 'POST',
                                                    'enctype' => 'multipart/form-data',
                                                ]) !!}
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <input type="hidden" id="id" name="id"
                                                                value="{{ $data->id }}" required>
                                                            <tr>
                                                                <td colspan="5" class="bg-primary-50">
                                                                    <label class="form-label"><i class="fal fa-car"></i>
                                                                        Operation</label>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed float-right verify-cancel">
                                                                        <i class="fal fa-times"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="20%" style="vertical-align: top"><span
                                                                        class="text-danger">*</span> Driver</th>
                                                                <td colspan="4" style="vertical-align: middle">
                                                                    <select class="form-control" name="driver"
                                                                        id="driver" required>
                                                                        <option disabled selected>Choose Driver</option>
                                                                        @foreach ($driver as $d)
                                                                            <option value="{{ $d->id }}"
                                                                                {{ old('driver') == $d->id ? 'selected' : '' }}>
                                                                                {{ $d->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th width="20%" style="vertical-align: top"><span
                                                                        class="text-danger">*</span> Vehicle</th>
                                                                <td colspan="4" style="vertical-align: middle">
                                                                    <select class="form-control" name="vehicle"
                                                                        id="vehicle" required>
                                                                        <option disabled selected>Choose Vehicle</option>
                                                                        @foreach ($vehicle as $v)
                                                                            <option value="{{ $v->id }}"
                                                                                {{ old('vehicle') == $d->id ? 'selected' : '' }}>
                                                                                {{ $v->name }} - {{ $v->plate_no }}
                                                                            </option>verify application
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                @csrf
                                                <input type="hidden" id="id" name="id"
                                                    value="{{ $data->id }}">
                                                <button type="submit"
                                                    class="btn btn-warning ml-auto float-right mb-2 waves-effect waves-themed"
                                                    id="verify"><i class="fal fa-check"></i> Verify Application
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        @endcanany
                                    @endif

                                    {{-- SUBMIT FEEDBACK --}}
                                    @if ($data->status == '3')
                                        <div class="mt-2">
                                            {!! Form::open([
                                                'action' => 'EKenderaanController@feedback',
                                                'method' => 'POST',
                                                'enctype' => 'multipart/form-data',
                                            ]) !!}
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <input type="hidden" id="id" name="id"
                                                            value="{{ $data->id }}" required>
                                                        <tr>
                                                            <td colspan="5" class="bg-primary-50">
                                                                <label class="form-label"><i class="fal fa-pencil"></i>
                                                                    APPLICANT FEEDBACK</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5" class="bg-warning-50">
                                                                This division is working to improve the quality of service
                                                                to all student and staff. In order to achieve that goal,
                                                                we ask for your cooperation in providing feedback and
                                                                suggestions/comments.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: top"><span
                                                                    class="text-danger">*</span> Please provide feedback
                                                                upon arrival at INTEC</th>
                                                            <td colspan="4" style="vertical-align: middle">
                                                                <textarea class="form-control" id="textarea" rows="3" name="feedback" required></textarea>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="form-label" for="check">
                                                                <input type="checkbox" name="check" id="agree"
                                                                    onclick="agreement()" />
                                                                Please verify your return to INTEC
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @csrf
                                            <input type="hidden" id="id" name="id"
                                                value="{{ $data->id }}">
                                            <button type="submit"
                                                class="btn btn-danger ml-auto float-right mt-2 mb-2 waves-effect waves-themed"
                                                id="verify" disabled><i class="fal fa-times-circle"></i> Verify
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    @endif
                                    @if ($data->status == '5')
                                        <div class="mt-2">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="5" class="bg-primary-50">
                                                                <label class="form-label"><i class="fal fa-pencil"></i>
                                                                    APPLICANT FEEDBACK</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: top">Feedback about
                                                                the trip/driver</th>
                                                            <td colspan="4" style="vertical-align: middle">
                                                                {!! nl2br(isset($feedback->remark) ? $feedback->remark : '') !!}
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
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
        $(document).ready(function() {
            $('#vehicle,#driver').select2();

            var id = @json($id);

            var table = $('#passenger').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/passenger-details/" + id,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        className: 'text-center',
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        className: 'text-left',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        className: 'text-left',
                        data: 'progfac',
                        name: 'progfac'
                    },
                    {
                        className: 'text-center',
                        data: 'ic',
                        name: 'ic'
                    },
                    {
                        className: 'text-center',
                        data: 'id',
                        name: 'id'
                    }
                ],
                orderCellsTop: true,
                "order": [
                    [0, "asc"]
                ],
                "initComplete": function(settings, json) {

                }
            });

            $('.remark').hide();
            $('.click').click(function() {
                $('.remark').show();
                $('.click').hide();
                $('.verify').hide();
            });

            $('.reject-cancel').click(function() {
                $('.remark').hide();
                $('.click').show();
                $('.verify').show();
            });

            $('.operation').hide();
            $('.operationverify').click(function() {
                $('.operation').show();
                $('.operationverify').hide();
                $('.remark').hide();
                $('.click').hide();

            });

            $('.verify-cancel').click(function() {
                $('.operation').hide();
                $('.operationverify').show();
                $('.click').show();
            });
        });

        function agreement() {
            var agree = document.getElementById("agree")
            var submit = document.getElementById("verify");
            submit.disabled = agree.checked ? false : true;
            if (!submit.disabled) {
                submit.focus();
            }
        }
    </script>
@endsection
