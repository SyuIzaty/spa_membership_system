@extends('layouts.admin')

@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        .rating {
            display: flex;
            width: 100%;
            justify-content: center;
            overflow: hidden;
            flex-direction: row-reverse;
            /* height: 150px; */
            position: relative;
        }

        .rating-0 {
            filter: grayscale(100%);
        }

        .rating>input {
            display: none;
        }

        .rating>label {
            cursor: pointer;
            width: 40px;
            height: 40px;
            margin-top: auto;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23e3e3e3' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 76%;
            transition: 0.3s;
        }

        .rating>input:checked~label,
        .rating>input:checked~label~label {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23fcd93a' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
        }

        .rating>input:not(:checked)~label:hover,
        .rating>input:not(:checked)~label:hover~label {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='126.729' height='126.73'%3e%3cpath fill='%23d8b11e' d='M121.215 44.212l-34.899-3.3c-2.2-.2-4.101-1.6-5-3.7l-12.5-30.3c-2-5-9.101-5-11.101 0l-12.4 30.3c-.8 2.1-2.8 3.5-5 3.7l-34.9 3.3c-5.2.5-7.3 7-3.4 10.5l26.3 23.1c1.7 1.5 2.4 3.7 1.9 5.9l-7.9 32.399c-1.2 5.101 4.3 9.3 8.9 6.601l29.1-17.101c1.9-1.1 4.2-1.1 6.1 0l29.101 17.101c4.6 2.699 10.1-1.4 8.899-6.601l-7.8-32.399c-.5-2.2.2-4.4 1.9-5.9l26.3-23.1c3.8-3.5 1.6-10-3.6-10.5z'/%3e%3c/svg%3e");
        }
    </style>
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
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif

                            @error('rating')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-check-circle"></i> Please rate the driver service
                                </div>
                            @enderror

                            @error('scale')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-check-circle"></i> Please rate the quality of service
                                </div>
                            @enderror

                            @error('feedback')
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
                                        @if ($data->operation_approval == 'N')
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
                                                        <input class="form-control" value="{{ $data->phone_no }}" readonly>
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
                                    @if ($data->status == '2')
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
                                                            <td colspan="7" class="bg-primary-50">
                                                                <label class="form-label"><i class="fal fa-pencil"></i>
                                                                    APPLICANT FEEDBACK</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7" class="bg-warning-50">
                                                                This division is working to improve the quality of service
                                                                to all student and staff. In order to achieve that goal,
                                                                we ask for your cooperation in providing rating, feedback
                                                                and
                                                                suggestions/comments.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            {{-- <div class="container">
                                                                <div class="feedback">

                                                                </div>
                                                            </div> --}}
                                                            <td colspan="7">
                                                                <h4 class="text-center" style="color:red;">
                                                                    <b>Please rate the driver service</b>
                                                                </h4>
                                                                <div class="rating">
                                                                    <input type="radio" name="rating" id="rating-5"
                                                                        value="5">
                                                                    <label for="rating-5"></label>
                                                                    <input type="radio" name="rating" id="rating-4"
                                                                        value="4">
                                                                    <label for="rating-4"></label>
                                                                    <input type="radio" name="rating" id="rating-3"
                                                                        value="3">
                                                                    <label for="rating-3"></label>
                                                                    <input type="radio" name="rating" id="rating-2"
                                                                        value="2">
                                                                    <label for="rating-2"></label>
                                                                    <input type="radio" name="rating" id="rating-1"
                                                                        value="1">
                                                                    <label for="rating-1"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="text-center border" style="background-color: #c6c6c6;">
                                                            <td width="100px">5</td>
                                                            <td width="100px">4</td>
                                                            <td width="100px" colspan="2">3</td>
                                                            <td width="100px">2</td>
                                                            <td width="100px" colspan="2">1</td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td width="100px">Excellent</td>
                                                            <td width="100px">Very Good</td>
                                                            <td width="100px" colspan="2">Good</td>
                                                            <td width="100px">Satisfying</td>
                                                            <td width="100px" colspan="2">Less Satisfactory</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"></td>
                                                        </tr>
                                                        <tr class="text-center" style="background-color: #a2d2ff;">
                                                            <td>NO</td>
                                                            <td width="100px">QUALITY OF SERVICES PROVIDED</td>
                                                            <td width="100px">5</td>
                                                            <td width="100px">4</td>
                                                            <td width="100px">3</td>
                                                            <td width="100px">2</td>
                                                            <td width="100px">1</td>
                                                        </tr>
                                                        @php $i = 1 @endphp
                                                        @foreach ($feedbackQuestion as $f)
                                                            <tr>
                                                                <td class="text-center">{{ $i }}</td>
                                                                <td>{{ $f->question }}</td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->id }}]" id="scale-5"
                                                                        value="5">
                                                                    <label for="scale-5"></label>
                                                                </td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->id }}]" id="scale-4"
                                                                        value="4">
                                                                    <label for="scale-4"></label>
                                                                </td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->id }}]" id="scale-3"
                                                                        value="3">
                                                                    <label for="scale-3"></label>
                                                                </td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->id }}]" id="scale-2"
                                                                        value="2">
                                                                    <label for="scale-2"></label>
                                                                </td>
                                                                <td class="text-center"> <input type="radio"
                                                                        name="scale[{{ $f->id }}]" id="scale-1"
                                                                        value="1">
                                                                    <label for="scale-1"></label>
                                                                </td>
                                                            </tr>
                                                            @php $i++ @endphp
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="7"></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: top"><span
                                                                    class="text-danger">*</span> Please provide feedback
                                                                upon arrival at INTEC</th>
                                                            <td colspan="7" style="vertical-align: middle">
                                                                <textarea class="form-control" id="textarea" rows="3" name="feedback" required>{{ Request::old('feedback') }}</textarea>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tr>
                                                        <td colspan="7">
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
                                                            <td colspan="7" class="bg-primary-50">
                                                                <label class="form-label"><i class="fal fa-pencil"></i>
                                                                    APPLICANT FEEDBACK</label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7">
                                                                <h4 class="text-center" style="color:red;">
                                                                    <b>Driver Service Rating</b>
                                                                </h4>
                                                                <div class="rating">
                                                                    <input type="radio" name="rating" id="rating-5"
                                                                        value="5" disabled
                                                                        @if ($feedback->rating == '5') checked @endif>
                                                                    <label for="rating-5"></label>
                                                                    <input type="radio" name="rating" id="rating-4"
                                                                        value="4" disabled
                                                                        @if ($feedback->rating == '4') checked @endif>
                                                                    <label for="rating-4"></label>
                                                                    <input type="radio" name="rating" id="rating-3"
                                                                        value="3" disabled
                                                                        @if ($feedback->rating == '3') checked @endif>
                                                                    <label for="rating-3"></label>
                                                                    <input type="radio" name="rating" id="rating-2"
                                                                        value="2" disabled
                                                                        @if ($feedback->rating == '2') checked @endif>
                                                                    <label for="rating-2"></label>
                                                                    <input type="radio" name="rating" id="rating-1"
                                                                        value="1" disabled
                                                                        @if ($feedback->rating == '1') checked @endif>
                                                                    <label for="rating-1"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="text-center border" style="background-color: #c6c6c6;">
                                                            <td width="100px">5</td>
                                                            <td width="100px">4</td>
                                                            <td width="100px" colspan="2">3</td>
                                                            <td width="100px">2</td>
                                                            <td width="100px" colspan="2">1</td>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <td width="100px">Excellent</td>
                                                            <td width="100px">Very Good</td>
                                                            <td width="100px" colspan="2">Good</td>
                                                            <td width="100px">Satisfying</td>
                                                            <td width="100px" colspan="2">Less Satisfactory</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="7"></td>
                                                        </tr>
                                                        <tr class="text-center" style="background-color: #a2d2ff;">
                                                            <td>NO</td>
                                                            <td width="100px">QUALITY OF SERVICES PROVIDED</td>
                                                            <td width="100px">5</td>
                                                            <td width="100px">4</td>
                                                            <td width="100px">3</td>
                                                            <td width="100px">2</td>
                                                            <td width="100px">1</td>
                                                        </tr>
                                                        @php $i = 1 @endphp
                                                        @foreach ($feedbackScale as $f)
                                                            <tr>
                                                                <td class="text-center">{{ $i }}</td>
                                                                <td>{{ $f->questionList->question }}</td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->ekn_feedback_questions_id }}]"
                                                                        id="scale-5" value="5"
                                                                        @if ($f->scale == '5') checked @else disabled @endif>
                                                                    <label for="scale-5"></label>
                                                                </td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->ekn_feedback_questions_id }}]"
                                                                        id="scale-4" value="4"
                                                                        @if ($f->scale == '4') checked @else disabled @endif>
                                                                    <label for="scale-4"></label>
                                                                </td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->ekn_feedback_questions_id }}]"
                                                                        id="scale-3" value="3"
                                                                        @if ($f->scale == '3') checked @else disabled @endif>
                                                                    <label for="scale-3"></label>
                                                                </td>
                                                                <td class="text-center"><input type="radio"
                                                                        name="scale[{{ $f->ekn_feedback_questions_id }}]"
                                                                        id="scale-2" value="2"
                                                                        @if ($f->scale == '2') checked @else disabled @endif>
                                                                    <label for="scale-2"></label>
                                                                </td>
                                                                <td class="text-center"> <input type="radio"
                                                                        name="scale[{{ $f->ekn_feedback_questions_id }}]"
                                                                        id="scale-1" value="1"
                                                                        @if ($f->scale == '1') checked @else disabled @endif>
                                                                    <label for="scale-1"></label>
                                                                </td>
                                                            </tr>
                                                            @php $i++ @endphp
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="7"></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: top">Feedback about
                                                                the trip/driver</th>
                                                            <td colspan="7" style="vertical-align: middle">
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
