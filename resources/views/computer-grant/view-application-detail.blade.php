@extends('layouts.admin')

@section('content')

    <script>


    </script>

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

                            @error('hp_no')
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;"> <i
                                        class="icon fal fa-check-circle"></i> {{ $message }}</div>
                            @enderror

                            @error('office_no')
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
                                                                class="fal fa-user"></i> APPLICANT INFORMATION</label>
                                                    </td>
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
                                                        {{ strtoupper($user_details->staff_name) }}</td>
                                                    <th width="20%" style="vertical-align: middle">Staff ID : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ $user_details->staff_id }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Staff Department : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($user_details->staff_dept) ? $user_details->staff_dept : '-' }}
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle">Staff Designation : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($user_details->staff_position) ? $user_details->staff_position : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle"></span> Staff H/P No.
                                                        : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ $activeData->hp_no }}
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle"></span> Staff Office No.
                                                        : </th>
                                                    <td colspan="2" style="vertical-align: middle">
                                                        {{ isset($activeData->office_no) ? $activeData->office_no : '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="20%" style="vertical-align: middle">Grant Period Eligibility
                                                        : </th>
                                                    <td colspan="2"
                                                        style="vertical-align: middle; color: red; text-transform: uppercase;">
                                                        <b>5 Years (60 Months)</b>
                                                    </td>
                                                    <th width="20%" style="vertical-align: middle">Grant Amount Eligibility
                                                        : </th>
                                                    <td colspan="2" style="vertical-align: middle; color: red;"><b>RM
                                                            1,500</b></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    @if ($activeData->status == 1 || $activeData->status == 2 || $activeData->status == 3 || $activeData->status == 4 || $activeData->status == 5 || $activeData->status == 6)
                                        @role('Computer Grant (IT Admin)')
                                            <a class="btn btn-info ml-auto float-right"
                                                data-page="/applicationPDF/{{ $activeData->id }}" onclick="Print(this)"
                                                style="color: rgb(0, 0, 0); margin-top: 5px; margin-bottom: 15px;">
                                                <i class="fal fa-download"></i> Application Doc
                                            </a>
                                        @endrole
                                    @endif

                                    @role('Computer Grant (IT Admin)')
                                        @if ($activeData->status == 3 || $activeData->status == 4 || $activeData->status == 5 || $activeData->status == 6)
                                            <a class="btn btn-primary mr-2 float-right"
                                                data-page="/agreementPDF/{{ $activeData->id }}" onclick="Print(this)"
                                                style="color: rgb(0, 0, 0); margin-top: 5px; margin-bottom: 15px;">
                                                <i class="fal fa-download"></i> Declaration Doc
                                            </a>
                                        @endif
                                    @endrole

                                    @if ($activeData->status == 1)
                                        @role('Computer Grant (IT Admin)')
                                            {!! Form::open(['action' => 'ComputerGrantController@verifyApplication', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden" id="id" name="id" value="{{ $activeData->id }}">

                                            <div class="table-responsive">
                                                <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="5" class="bg-primary-50"><label
                                                                    class="form-label"><i class="fal fa-user"></i> IT
                                                                    ADMIN & CE APPROVAL</label></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="20%" style="vertical-align: top"><span
                                                                    class="text-danger">*</span> Upload Signed Application :
                                                            </th>
                                                            <td colspan="4"><input type="file" class="form-control"
                                                                    accept=".pdf" id="upload_image" name="upload_image">

                                                                @error('upload_image')
                                                                    <p style="color: red">{{ $message }}</p>
                                                                @enderror
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <div class="table-responsive">
                                                <div class="form-group">
                                                    <button style="margin-top: 5px;" class="btn btn-danger float-right"
                                                        id="submit" name="submit"><i class="fal fa-check"></i> Verify
                                                        Application</button></td>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        @endrole
                                    @endif

                                    @if ($activeData->status == 2 || $activeData->status == 3 || $activeData->status == 4 || $activeData->status == 5 || $activeData->status == 6)
                                        <div class="table-responsive">
                                            <table id="info" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label
                                                                class="form-label"><i class="fal fa-user"></i> IT
                                                                ADMIN & CE APPROVAL</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4">
                                                            @if (isset($verified_doc))
                                                                <a class="btn btn-info" target="_blank"
                                                                    href="/get-file/{{ $verified_doc->id }}">
                                                                    <i class="fal fa-download"></i> Application Form
                                                                </a>
                                                            @endif

                                                            <a class="btn btn-success" target="_blank"
                                                                href="/Grant-Reimbursement-Form">
                                                                <i class="fal fa-download"></i> Grant Reimbursement Form
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    @endif

                                    @if ($activeData->status == '3' || $activeData->status == '4' || $activeData->status == '5' || $activeData->status == '6')
                                        <div class="table-responsive">
                                            <table id="upload" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <input type="hidden" id="id" name="id" value="{{ $activeData->id }}"
                                                        required>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label
                                                                class="form-label"><i class="fal fa-file"></i>
                                                                PURCHASE DETAILS</label></td>
                                                    </tr>

                                                    <tr>
                                                        <th width="20%" style="vertical-align: middle">Type of Device :
                                                        </th>
                                                        <td colspan="2" style="vertical-align: middle">
                                                            {{ $activeData->getType->first()->description }}</td>
                                                        <th width="20%" style="vertical-align: middle">Serial No : </th>
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
                                                        <th width="20%" style="vertical-align: middle">Purchase Receipt :
                                                        </th>
                                                        <td colspan="2">
                                                            @if ($proof->isNotEmpty())
                                                                <a target="_blank"
                                                                    href="/get-receipt/{{ $proof->where('type', 1)->first()->id }}">{{ $proof->where('type', 1)->first()->upload }}</a>
                                                            @endif
                                                        </td>
                                                        <th width="20%" style="vertical-align: middle">Device Image : </th>
                                                        <td colspan="2">
                                                            @if ($proof->isNotEmpty())
                                                                <a target="_blank"
                                                                    href="/get-image/{{ $proof->where('type', 2)->first()->id }}">{{ $proof->where('type', 2)->first()->upload }}</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="20%" style="vertical-align: top">Price :</th>
                                                        <td colspan="4" style="vertical-align: middle"> RM
                                                            {{ $activeData->price }}</td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    @endif

                                    @if ($activeData->status == '5' || $activeData->status == '6')
                                        <div class="table-responsive">
                                            <table id="verifikasi"
                                                class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5" class="bg-primary-50"><label
                                                                class="form-label"><i class="fal fa-check-square"></i>
                                                                CONFIRMATION OF AGREEMENT BY APPLICANT</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="form-label" for="check">
                                                                <input type="checkbox" checked disabled />
                                                                &emsp;CONFIRMED THAT THE PERSONAL DETAILS AND PURCHASE PROOF
                                                                GIVEN ARE GENUINE AND AGREE TO ACCEPT THIS APPLICATION AND
                                                                ABIDE ALL REGULATIONS.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    @endif

                                    @if ($activeData->status == 4 || $activeData->status == 5 || $activeData->status == 6)
                                        @role('Computer Grant (IT Admin)')
                                            @if (!isset($declaration_doc))
                                                {!! Form::open(['action' => 'ComputerGrantController@uploadAgreement', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                <input type="hidden" id="id" name="id" value="{{ $activeData->id }}"
                                                    required>

                                                <div class="table-responsive">
                                                    <table id="info"
                                                        class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="5" class="bg-primary-50"><label
                                                                        class="form-label"><i class="fal fa-user"></i>
                                                                        SIGNED DECLARATION FORM</label></td>
                                                            </tr>
                                                            <tr>
                                                                <th width="20%" style="vertical-align: top"><span
                                                                        class="text-danger">*</span> Upload Signed
                                                                    Application : </th>
                                                                <td colspan="4"><input type="file" class="form-control"
                                                                        accept=".pdf" id="upload_image" name="upload_image"
                                                                        required>

                                                                    @error('upload_image')
                                                                        <p style="color: red">{{ $message }}</p>
                                                                    @enderror
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>

                                                <div class="table-responsive">
                                                    <div class="form-group">
                                                        <button style="margin-top: 5px;" class="btn btn-danger float-right"
                                                            id="submit" name="submit"><i class="fal fa-check"></i>
                                                            Submit</button></td>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            @else
                                                <div class="table-responsive">
                                                    <table id="info"
                                                        class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="5" class="bg-primary-50"><label
                                                                        class="form-label"><i class="fal fa-user"></i>
                                                                        SIGNED DECLARATION FORM</label></td>
                                                            </tr>
                                                            <tr>
                                                                <th width="20%" style="vertical-align: top">Verified Declaration
                                                                    : </th>
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
                                        @endrole
                                    @endif

                                    @if ($activeData->status == 3)
                                        @role('Computer Grant (IT Admin)')
                                            <button
                                                class="btn btn-warning ml-auto float-right mr-2 waves-effect waves-themed click"
                                                style="margin-bottom:10px;"><i class="fal fa-times-circle"></i> Reject</button>

                                            <div class="remark">
                                                {!! Form::open(['action' => 'ComputerGrantController@rejectPurchase', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                                <div class="table-responsive">
                                                    <table id="upload"
                                                        class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <input type="hidden" id="id" name="id"
                                                                value="{{ $activeData->id }}" required>
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
                                                                    <textarea class="form-control max" id="example-textarea" rows="3" placeholder="Please fill in rejection reason"
                                                                        name="remark" required></textarea>
                                                                    <span style="font-size: 10px; color: red;"><i>*Limit to 150
                                                                            characters only</i></span>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                @csrf
                                                <input type="hidden" id="id" name="id" value="{{ $activeData->id }}"
                                                    required>
                                                <button type="submit"
                                                    class="btn btn-warning ml-auto float-right mr-2 waves-effect waves-themed"
                                                    id="reject" style="margin-bottom:10px;"><i class="fal fa-times-circle"></i>
                                                    Submit</button>
                                                {!! Form::close() !!}
                                            </div>


                                            {!! Form::open(['action' => 'ComputerGrantController@verifyPurchase', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                            <input type="hidden" id="id" name="id" value="{{ $activeData->id }}" required>
                                            <button type="submit"
                                                class="btn btn-primary ml-auto float-right mr-2 waves-effect waves-themed"
                                                style="margin-bottom:10px;"><i class="fal fa-check"></i> Verify
                                                Purchase</button>
                                            {!! Form::close() !!}
                                        @endrole
                                    @elseif ($activeData->status == 5)
                                        @role('Computer Grant (Finance Admin)')
                                            <form id="reimburse">
                                                @csrf
                                                <input type="hidden" id="id" name="id" value="{{ $activeData->id }}"
                                                    required>

                                                <div class="table-responsive">
                                                    <div class="form-group">
                                                        <button style="margin-top: 5px;" class="btn btn-danger float-right"
                                                            type="submit" id="reimbursement"><i class="fal fa-check"></i>
                                                            Complete Reimbursement</button></td>
                                                    </div>
                                                </div>
                                            </form>
                                        @endrole
                                    @elseif ($activeData->status == 6)
                                        @role('Computer Grant (Finance Admin)')
                                            <form id="cancelreimburse">
                                                @csrf
                                                <input type="hidden" id="id" name="id" value="{{ $activeData->id }}"
                                                    required>

                                                <div class="table-responsive">
                                                    <div class="form-group">
                                                        <button style="margin-top: 5px;" class="btn btn-warning float-right"
                                                            type="submit" id="cancelreimbursement"><i
                                                                class="fal fa-check"></i> Cancel Reimbursement</button></td>
                                                    </div>
                                                </div>
                                            </form>
                                        @endrole
                                    @endif

                                    @if ($activeData->status == 7)
                                        <form id="formId">
                                            @csrf
                                            <input type="hidden" id="id" name="id" value="{{ $activeData->id }}"
                                                required>
                                            <button type="submit"
                                                class="btn btn-danger ml-auto float-right mr-2 waves-effect waves-themed"
                                                id="cancel" style="margin-bottom: 20px;"><i
                                                    class="fal fa-times-circle"></i> Verify Cancellation</button>
                                        </form>
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
        function Print(button) {
            var url = $(button).data('page');
            var printWindow = window.open('{{ url('/') }}' + url + '', 'Print',
                'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
            printWindow.addEventListener('load', function() {
                printWindow.print();
            }, true);
        }

        $("#cancel").on('click', function(e) {
            e.preventDefault();

            var datas = $('#formId').serialize();

            Swal.fire({
                title: 'Verify cancellation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
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
                        url: "{{ url('verifyCancellation') }}",
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

        $("#reimbursement").on('click', function(e) {
            e.preventDefault();

            var datas = $('#reimburse').serialize();

            Swal.fire({
                title: 'Complete reimbursement?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
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
                        url: "{{ url('verify-reimbursement') }}",
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

        $("#cancelreimbursement").on('click', function(e) {
            e.preventDefault();

            var datas = $('#cancelreimburse').serialize();

            Swal.fire({
                title: 'Cancel reimbursement?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: "POST",
                        url: "{{ url('cancel-reimbursement') }}",
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

        //limit word in textarea
        jQuery(document).ready(function($) {
            var max = 150;
            $('textarea.max').keypress(function(e) {
                if (e.which < 0x20) {
                    // e.which < 0x20, then it's not a printable character
                    // e.which === 0 - Not a character
                    return; // Do nothing
                }
                if (this.value.length == max) {
                    e.preventDefault();
                } else if (this.value.length > max) {
                    // Maximum exceeded
                    this.value = this.value.substring(0, max);
                }
            });
        }); //end if ready(fn)

        $(document).ready(function() {
            $('.remark').hide();
            $('.click').click(function() {
                $('.remark').show();
                $('.click').hide();
            });

            $('.reject-cancel').click(function() {
                $('.remark').hide();
                $('.click').show();
            });
        });
    </script>
@endsection
