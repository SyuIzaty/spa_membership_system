@extends('layouts.applicant')

@section('content')
    <style>
        .table {
            border: 0.5px solid #000000;
        }

        .table-bordered>thead>tr>th,
        .table-bordered>tbody>tr>th,
        .table-bordered>tfoot>tr>th,
        .table-bordered>thead>tr>td,
        .table-bordered>tbody>tr>td,
        .table-bordered>tfoot>tr>td {
            border: 0.5px solid #000000;
        }

        .square {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            display: inline-block;
            margin-bottom: -3px;
        }

        .description {
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }

        #footer {
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
        }

        #container {
            display: flex;
            /* establish flex container */
            justify-content: space-between;
            /* switched from default (flex-start, see below) */
            margin-top: 350px;
        }
    </style>
    <main id="js-page-content" role="main" class="page-content">
        <div class="row">
            <div class="col-xl-12" style="padding: 100px; margin-bottom: 20px; font-size: 15px; color: black;">

                <center><img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="110" width="300" alt="INTEC"
                        style="margin-top: -65px"></center><br>
                <center>
                    <h1><b>LAPTOP GRANT APPLICATION</b></h1>
                </center>

                <div class="table-responsive" style="margin-top: 30px;">
                    <table id="info" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th colspan="5" style="background-color: rgb(216, 215, 215)">A. Personal Information</th>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Application Date : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ date('d/m/Y', strtotime($application->created_at)) }}</td>
                                <th width="20%" style="vertical-align: middle">Approval Date : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ date('d/m/Y', strtotime($application->approved_at)) }}</td>
                            </tr>

                            <tr>
                                <th width="20%" style="vertical-align: middle">Ticket No : </th>
                                <td colspan="2" style="vertical-align: middle">{{ $application->ticket_no }}</td>
                                <th width="20%" style="vertical-align: middle">Staff Email : </th>
                                <td colspan="2" style="vertical-align: middle">{{ $application->staff->staff_email }}
                                </td>
                            </tr>

                            <tr>
                                <th width="20%" style="vertical-align: middle">Staff Name : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ strtoupper($application->staff->staff_name) }}</td>
                                <th width="20%" style="vertical-align: middle">Staff ID : </th>
                                <td colspan="2" style="vertical-align: middle">{{ $application->staff->staff_id }}</td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Staff Department : </th>
                                <td colspan="2" style="vertical-align: middle">{{ $application->staff->staff_dept }}
                                </td>
                                <th width="20%" style="vertical-align: middle">Staff Designation : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ $application->staff->staff_position }}
                                </td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle"></span> Staff H/P No. : </th>
                                <td colspan="2" style="vertical-align: middle">{{ $application->hp_no }}</td>
                                <th width="20%" style="vertical-align: middle"></span> Staff Office No. : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ isset($application->office_no) ? $application->office_no : '-' }}</td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Grant Period Eligibility : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">5 Years (60
                                    Months)</b></td>
                                <th width="20%" style="vertical-align: middle">Grant Amount Eligibility : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">RM 1,500</b>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive" style="margin-top: 10px;">
                    <table id="info" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th colspan="5" style="background-color: rgb(216, 215, 215)">B. Bank Information</th>
                            </tr>
                            <tr>
                                <th width="25%" style="vertical-align: top">Name of Account Holder : </th>
                                <td colspan="5" style="vertical-align: middle">
                                    {{ isset($application->name_acc_holder) ? $application->name_acc_holder : '' }}
                                </td>
                            </tr>

                            <tr>
                                <th width="20%" style="vertical-align: middle">Bank Name : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ isset($application->getBankName->bank_description) ? $application->getBankName->bank_description : '' }}
                                </td>
                                <th width="20%" style="vertical-align: middle">Account No. : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ isset($application->acc_no) ? $application->acc_no : '' }}</td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive" style="margin-top: 10px;">
                    <table id="info" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th colspan="5" style="background-color: rgb(216, 215, 215)">C. Laptop Information (For
                                    IT
                                    Department
                                    Use Only)</th>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Nominee has a rental Computer / Laptop :
                                </th>
                                <td colspan="2" width="30%" style="vertical-align: middle">
                                    <div
                                        style="width:50px;height:30px;border:1px solid #000;display: inline-block;margin-top: 15px;">
                                    </div>
                                    <div
                                        style="display: inline-block;vertical-align: middle;margin-bottom: 15px; margin-left: 10px;">
                                        Yes
                                    </div>
                                </td>
                                <td colspan="2" width="30%" style="vertical-align: middle">
                                    <div
                                        style="width:50px;height:30px;border:1px solid #000;display: inline-block;margin-top: 15px;">
                                    </div>
                                    <div
                                        style="display: inline-block;vertical-align: middle;margin-bottom: 15px; margin-left: 10px;">
                                        No
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: top">Device Type : </th>
                                <td colspan="2" style="vertical-align: middle">
                                    {{ $application->getType->description }}
                                </td>
                                <th width="20%" style="vertical-align: middle">Serial No. : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">
                                    {{ $application->serial_no }}</b></td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Brand : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">
                                    {{ $application->brand }}</b></td>
                                <th width="20%" style="vertical-align: middle">Model : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">
                                    {{ $application->model }}</b></td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Price : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">RM
                                    {{ $application->price }}</b></td>
                                <th width="20%" style="vertical-align: middle">Invoice No. : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">
                                    {{ isset($application->invoice_no) ? $application->invoice_no : '' }}</b></td>

                            </tr>
                        </thead>
                    </table>
                </div>
                <br>
                <p>I, {{ strtoupper($application->staff->staff_name) }} CONFIRM THAT THE PERSONAL DETAILS AND PURCHASE
                    PROOF GIVEN ARE GENUINE. I UNDERSTAND AND AGREE TO COMPLY WITH ALL RULES AND REGULATIONS OF THE COMPUTER
                    GRANT.</p>

                <p>Terms:</p>
                <ol>
                    <li>Application is eligible for permanent and contract academic staff only.</li>
                    <li>Grant period is {{ $application->getQuota->duration }} years only.</li>
                    <li>Device purchase must be made within one month after obtaining approval.</li>
                    <li>Device can be purchased from any supplier, including online.</li>
                    <li>Type of device that can be purchased are Laptop or Tablet only.</li>
                </ol>
                <div id="container">
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center"
                                    style="background-color: rgb(216, 215, 215); vertical-align: middle;">
                                    <th>Requestor</th>
                                </tr>
                                <tr height="100">
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Name: {{ strtoupper($application->staff->staff_name) }}</td>
                                </tr>
                                <tr>
                                    <td>Position: {{ $application->staff->staff_position }}</td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center"
                                    style="background-color: rgb(216, 215, 215); vertical-align: middle;">
                                    <th>Approved by IT</th>
                                </tr>
                                <tr height="100">
                                    <td class="text-center">
                                        <div class="square"></div>
                                        <div class="description">Approved</div>
                                        <div style="margin-left: 10px;" class="square"></div>
                                        <div class="description"> Not Approved</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name: SAIFUL HAWARI KAMAL</td>
                                </tr>
                                <tr>
                                    <td>Position: IT MANAGER</td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center"
                                    style="background-color: rgb(216, 215, 215); vertical-align: middle;">
                                    <th>Approved by Finance</th>
                                </tr>
                                <tr height="100">
                                    <td class="text-center">
                                        <div class="square"></div>
                                        <div class="description">Approved</div>
                                        <div style="margin-left: 10px;" class="square"></div>
                                        <div class="description"> Not Approved</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Name: </td>
                                </tr>
                                <tr>
                                    <td>Position: </td>
                                </tr>
                                <tr>
                                    <td>Date:</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="info" class="table table-bordered w-100" style="margin-top: 50px;">
                        <thead>
                            <tr>
                                <th colspan="5" style="background-color: rgb(216, 215, 215)">D. Finance & Accounts
                                    Department Use Only</th>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Document Checked
                                </th>
                                <td colspan="4" style="vertical-align: middle">
                                    <div class="square"></div>
                                    <div class="description">Invoice</div>
                                    <div style="margin-left: 10px;" class="square"></div>
                                    <div class="description"> Receipt/Proof of Payment</div>
                                    <div style="margin-left: 10px;" class="square"></div>
                                    <div class="description">Any Related Document (i.e. : Approval form from IT)</div>
                                </td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: top">Remark : </th>
                                <td colspan="4" style="vertical-align: middle"></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="table-responsive">
                    <table id="info" class="table table-bordered w-100">
                        <thead>
                            <tr class="text-center" style="background-color: rgb(216, 215, 215); vertical-align: middle;">
                                <th>Payment Voucher No</th>
                                <th>Amount</th>
                            </tr>
                            <tr height="100">
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div id="footer" class="text-center">
                    <p>UiTM Private Education Sdn Bhd, 947874-D, INTEC Education College, Jalan Senangin Satu 17/2A, Seksyen
                        17, 40200 Shah Alam, Selangor Darul Ehsan, MALAYSIA
                        No Tel : +603 5522 7000 No Fax : +603 5522 7010
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
