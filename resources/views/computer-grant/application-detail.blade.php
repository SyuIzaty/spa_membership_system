@extends('layouts.admin')

@section('content')

    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">

        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr bg-primary">
                        <h2 style="color: white;">
                            GRANT APPLICATION</b>
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

                            @error('price')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                        class="icon fal fa-check-circle"></i> {{ $message }}</div>
                            @enderror

                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="3" class="bg-warning text-center" align="center">
                                                        <h5>Status:
                                                            <b>{{ strtoupper($activeData->getStatus->description) }}</b>
                                                        </h5>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="info" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-primary-50"><label class="form-label"><i
                                                                class="fal fa-user"></i> APPLICANT INFORMATION</label></td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Ticket No : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($activeData->ticket_no) ? $activeData->ticket_no : '-' }}
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle">Staff Email : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($user_details->staff_email) ? $user_details->staff_email : '-' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Staff Name : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ strtoupper($user->name) }}</td>
                                                    <th width="20%" style="vertical-align: middle">Staff ID : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ $user->username }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Staff Department :
                                                    </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($user_details->staff_dept) ? $user_details->staff_dept : '-' }}
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle">Staff Designation :
                                                    </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($user_details->staff_position) ? $user_details->staff_position : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"></span> Staff H/P No.
                                                        : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ $activeData->hp_no }}</td>
                                                    <th width="20%" style="vertical-align: middle"></span> Staff Office
                                                        No. : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($activeData->office_no) ? $activeData->office_no : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"></span> Name of
                                                        Account Holder
                                                        : </th>
                                                    <td colspan="4" style="vertical-align: middle">
                                                        {{ isset($activeData->name_acc_holder) ? $activeData->name_acc_holder : 'N/A' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"></span> Bank Name
                                                        : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($activeData->getBankName->bank_description) ? $activeData->getBankName->bank_description : 'N/A' }}
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle"></span> Account Number
                                                        No. : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($activeData->acc_no) ? $activeData->acc_no : 'N/A' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Grant Period
                                                        Eligibility : </th>
                                                    <td colspan="2" style="vertical-align: middle; color: red;"><b>5
                                                            Years (60 Months)</b></td>
                                                    <th width="20%" style="vertical-align: middle">Grant Amount
                                                        Eligibility : </th>
                                                    <td colspan="2" style="vertical-align: middle; color: red;"><b>RM
                                                            1,500</b></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    @if ($activeData->status == 1 || $activeData->status == 2 || $activeData->status == 3)
                                        <form id="form-id">
                                            @csrf
                                            <input type="hidden" id="id" name="id"
                                                value="{{ $activeData->id }}" required>
                                            <button type="submit"
                                                class="btn btn-danger ml-auto float-right mr-2 waves-effect waves-themed"
                                                id="cancel" style="margin-bottom:10px;"><i
                                                    class="fal fa-times-circle"></i> Request for Cancellation</button>
                                        </form>
                                    @endif

                                    @if ($activeData->status == 2)
                                        <div class="table-responsive">
                                            <table id="upload"
                                                class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    {!! Form::open(['action' => 'ComputerGrantController@update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                    <input type="hidden" id="id" name="id"
                                                        value="{{ $activeData->id }}" required>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label
                                                                class="form-label"><i class="fal fa-file"></i> PURCHASE
                                                                DETAILS</label></td>
                                                    </tr>

                                                    @if ($activeData->remark != null)
                                                        <tr>
                                                            <th width="20%" class="bg-warning-50"
                                                                style="vertical-align: top">Remark by IT Admin : </th>
                                                            <td colspan="4" class="bg-warning-50"
                                                                style="vertical-align: middle">{{ $activeData->remark }}
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle"><span
                                                                class="text-danger">*</span> Type of Device : </th>
                                                        <td colspan="2">
                                                            <select class="form-control kategori" name="type"
                                                                id="type" required>
                                                                <option disabled selected>Choose Type of Device</option>
                                                                @foreach ($deviceType as $d)
                                                                    <option value="{{ $d->id }}"
                                                                        {{ old('type') == $d->id ? 'selected' : '' }}>
                                                                        {{ $d->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <th width="20%" style="vertical-align: middle"><span
                                                                class="text-danger">*</span> Serial No : </th>
                                                        <td colspan="2"><input class="form-control" id="serial_no"
                                                                name="serial_no" value="{{ old('serial_no') }}"
                                                                required></td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle"><span
                                                                class="text-danger">*</span> Brand : </th>
                                                        <td colspan="2"><input class="form-control" id="brand"
                                                                name="brand" value="{{ old('brand') }}" required>
                                                        </td>
                                                        <th width="20%" style="vertical-align: middle"><span
                                                                class="text-danger">*</span> Model : </th>
                                                        <td colspan="2"><input class="form-control" id="model"
                                                                name="model" value="{{ old('model') }}" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle"><span
                                                                class="text-danger">*</span> Purchase Receipt : </th>
                                                        <td colspan="2">

                                                            <input type="file" class="form-control" id="receipt"
                                                                name="receipt" required>

                                                            @error('receipt')
                                                                <p style="color: red">{{ $message }}</p>
                                                            @enderror
                                                        </td>
                                                        <th width="20%" style="vertical-align: middle"><span
                                                                class="text-danger">*</span> Device Image : </th>
                                                        <td colspan="2">

                                                            <input type="file" class="form-control" id="upload_image"
                                                                name="upload_image" required>

                                                            @error('upload_image')
                                                                <p style="color: red">{{ $message }}</p>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top"><span
                                                                class="text-danger">*</span> Price : RM</th>
                                                        <td colspan="2"><input class="form-control" id="price"
                                                                name="price" value="{{ old('price') }}" required>
                                                        </td>
                                                        <th width="20%" style="vertical-align: top"><span
                                                                class="text-danger">*</span> Invoice/Receipt Number : </th>
                                                        <td colspan="2"><input class="form-control" id="invoice"
                                                                name="invoice" value="{{ old('invoice') }}" required>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="verifikasi"
                                                class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label
                                                                class="form-label"><i class="fal fa-check-square"></i>
                                                                CONFIRMATION OF AGREEMENT</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="form-label" for="check">
                                                                <input type="checkbox" name="check" id="agree"
                                                                    onclick="agreement()" />
                                                                &emsp;I, <b><u>{{ strtoupper($user->name) }}</u></b>
                                                                CONFIRMED THAT THE PERSONAL DETAILS AND PURCHASE PROOF GIVEN
                                                                ARE GENUINE. I AGREE TO ACCEPT THIS APPLICATION AND ABIDE
                                                                ALL REGULATIONS.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="table-responsive">
                                            <div class="form-group">
                                                <button style="margin-top: 5px;" class="btn btn-danger float-right"
                                                    id="submit" name="submit" disabled><i class="fal fa-check"></i>
                                                    Submit</button></td>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    @elseif ($activeData->status == '3' || $activeData->status == '4' || $activeData->status == '5' || $activeData->status == '6')
                                        <div class="table-responsive">
                                            <table id="upload"
                                                class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <input type="hidden" id="id" name="id"
                                                        value="{{ $activeData->id }}" required>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label
                                                                class="form-label"><i class="fal fa-file"></i> PURCHASE
                                                                DETAILS</label></td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle">Type of Device :
                                                        </th>
                                                        <td colspan="2" style="vertical-align: middle">
                                                            {{ $activeData->getType->first()->description }}</td>
                                                        <th width="20%" style="vertical-align: middle">Serial No :
                                                        </th>
                                                        <td colspan="2" style="vertical-align: middle">
                                                            {{ $activeData->serial_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle">Brand : </th>
                                                        <td colspan="2" style="vertical-align: middle">
                                                            {{ $activeData->brand }}</td>
                                                        <th width="20%" style="vertical-align: middle">Model : </th>
                                                        <td colspan="2" style="vertical-align: middle">
                                                            {{ $activeData->model }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle">Purchase Receipt
                                                            : </th>
                                                        <td colspan="2">
                                                            @if ($proof->isNotEmpty())
                                                                <a target="_blank"
                                                                    href="/get-receipt/{{ $proof->where('type', 1)->first()->id }}">{{ $proof->where('type', 1)->first()->upload }}</a>
                                                            @endif
                                                        </td>
                                                        <th width="20%" style="vertical-align: middle">Device Image :
                                                        </th>
                                                        <td colspan="2">
                                                            @if ($proof->isNotEmpty())
                                                                <a target="_blank"
                                                                    href="/get-image/{{ $proof->where('type', 2)->first()->id }}">{{ $proof->where('type', 2)->first()->upload }}</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top">Price :</th>
                                                        <td colspan="2" style="vertical-align: middle"> RM
                                                            {{ $activeData->price }}</td>
                                                        <th width="20%" style="vertical-align: top">Invoice No. :</th>
                                                        <td colspan="2" style="vertical-align: middle">
                                                            {{ isset($activeData->invoice_no) ? $activeData->invoice_no : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    @endif

                                    @if ($activeData->status == 4 || $activeData->status == 5 || $activeData->status == 6)
                                        @if (isset($declaration_doc))
                                            <div class="table-responsive">
                                                <table id="info"
                                                    class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="5" class="bg-primary-50"><label
                                                                    class="form-label"><i class="fal fa-user"></i> SIGNED
                                                                    DECLARATION FORM</label></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: top">Verified
                                                                Declaration : </th>
                                                            <td colspan="4">
                                                                <a class="btn btn-primary" target="_blank"
                                                                    href="/get-declaration/{{ $declaration_doc->id }}">
                                                                    <i class="fal fa-download"></i> Signed Declaration Form
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        @endif
                                    @endif

                                    @if ($activeData->status == '3' || $activeData->status == '4' || $activeData->status == '5' || $activeData->status == '6')
                                        <div class="table-responsive">
                                            <table id="verifikasi"
                                                class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label
                                                                class="form-label"><i class="fal fa-check-square"></i>
                                                                CONFIRMATION OF AGREEMENT</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="form-label" for="check">
                                                                <input type="checkbox" checked disabled />
                                                                &emsp;I, <b><u>{{ strtoupper($user->name) }}</u></b>
                                                                CONFIRMED THAT THE PERSONAL DETAILS AND PURCHASE PROOF GIVEN
                                                                ARE GENUINE. I AGREE TO ACCEPT THIS APPLICATION AND ABIDE
                                                                ALL REGULATIONS.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
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
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="table-responsive">
                                <table id="application" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr class="bg-primary-50 text-center">
                                            <th class="text-center">Ticket No.</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Staff Department/Position</th>
                                            <th class="text-center">Grant Status</th>
                                            <th class="text-center">Total Price</th>
                                            <th class="text-center">Grant Amount/Period</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-center">Brand/Model/Serial No.</th>
                                            <th class="text-center">Approval Date</th>
                                            <th class="text-center">Expiry Date</th>
                                            <th class="text-center">Remaining Grant Period</th>
                                            <th class="text-center">Balance Penalty</th>
                                            <th class="text-center">View</th>
                                            <th class="text-center">Activity Log</th>
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
        function Print(button) {
            var url = $(button).data('page');
            var printWindow = window.open('{{ url('/') }}' + url + '', 'Print',
                'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            }, true);
        }

        $(document).ready(function() {
            var table = $('#application').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/datalist",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        className: 'text-left',
                        data: 'ticket_no',
                        name: 'ticket_no'
                    },
                    {
                        className: 'text-left',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        className: 'text-left',
                        data: 'details',
                        name: 'details'
                    },
                    {
                        className: 'text-left',
                        data: 'status',
                        name: 'status'
                    },
                    {
                        className: 'text-left',
                        data: 'price',
                        name: 'price'
                    },
                    {
                        className: 'text-left',
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        className: 'text-left',
                        data: 'type',
                        name: 'type'
                    },
                    {
                        className: 'text-left',
                        data: 'purchase',
                        name: 'purchase'
                    },
                    {
                        className: 'text-left',
                        data: 'approvalDate',
                        name: 'approvalDate'
                    },
                    {
                        className: 'text-left',
                        data: 'expiryDate',
                        name: 'expiryDate'
                    },
                    {
                        className: 'text-left',
                        data: 'remainingPeriod',
                        name: 'remainingPeriod'
                    },
                    {
                        className: 'text-left',
                        data: 'penalty',
                        name: 'penalty'
                    },
                    {
                        className: 'text-left',
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        className: 'text-left',
                        data: 'log',
                        name: 'log',
                        orderable: false,
                        searchable: false
                    }
                ],
                orderCellsTop: true,
                "order": [
                    [1, "asc"]
                ],
                "initComplete": function(settings, json) {

                }
            });
        });

        $("#cancel").on('click', function(e) {
            e.preventDefault();

            var datas = $('#form-id').serialize();

            Swal.fire({
                title: 'Are you sure you want to cancel this application?',
                text: "Data cannot be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel!',
                cancelButtonText: 'No'
            }).then((result) => {

                if (result.value) {
                    Swal.fire({
                        title: 'Loading..',
                        text: 'Please wait..',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        onOpen: () => {
                            Swal.showLoading()
                        }
                    })
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ url('requestCancellation') }}",
                        data: datas,
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            if (response) {
                                Swal.fire(response.success);
                                location.reload();
                            }
                        }
                    });
                }
            })
        });

        function agreement() {
            var agree = document.getElementById("agree")
            var submit = document.getElementById("submit");
            submit.disabled = agree.checked ? false : true;
            if (!submit.disabled) {
                submit.focus();
            }
        }
    </script>
@endsection
