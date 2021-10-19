@extends('layouts.applicant')

@section('content')

<style>
    .table {
    border: 0.5px solid #000000;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > tbody > tr > th,
    .table-bordered > tfoot > tr > th,
    .table-bordered > thead > tr > td,
    .table-bordered > tbody > tr > td,
    .table-bordered > tfoot > tr > td {
    border: 0.5px solid #000000;
    }
</style>

<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12" style="padding: 100px; margin-bottom: 20px; font-size: 15px; color: black;">

                <center><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="120" width="280" alt="INTEC" style="margin-top: -65px"></center><br>

                <div class="table-responsive" style="margin-top: 80px;">
                    <table id="info" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr class="text-center">
                                <th colspan="5">COMPUTER GRANT APPLICATION</th>
                            </tr>

                            <tr>
                                <th width="20%" style="vertical-align: top">Application Date : </th>
                                <td colspan="4" style="vertical-align: middle; text-transform: capitalize;">{{ date('d/m/Y', strtotime($application->created_at)) }}</td>
                            </tr>

                            <tr>
                                <th width="20%" style="vertical-align: middle">Ticket No : </th>
                                <td colspan="2" style="vertical-align: middle">{{$application->ticket_no}}</td>
                                <th width="20%" style="vertical-align: middle">Staff Email : </th>
                                <td colspan="2" style="vertical-align: middle">{{$application->staff->staff_email}}</td>
                            </tr>

                            <tr>
                                <th width="20%" style="vertical-align: middle">Staff Name : </th>
                                <td colspan="2" style="vertical-align: middle">{{strtoupper($application->staff->staff_name)}}</td>
                                <th width="20%" style="vertical-align: middle">Staff ID : </th>
                                <td colspan="2" style="vertical-align: middle">{{$application->staff->staff_id}}</td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Staff Department : </th>
                                <td colspan="2" style="vertical-align: middle">{{$application->staff->staff_dept}}</td>
                                <th width="20%" style="vertical-align: middle">Staff Designation : </th>
                                <td colspan="2" style="vertical-align: middle">{{$application->staff->staff_position}}</td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle"></span> Staff H/P No. : </th>
                                <td colspan="2" style="vertical-align: middle">{{$application->hp_no}}</td>
                                <th width="20%" style="vertical-align: middle"></span> Staff Office No. : </th>
                                <td colspan="2" style="vertical-align: middle">{{isset($application->office_no) ? $application->office_no : '-'}}</td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Grant Period Eligibility : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">5 Years (60 Months)</b></td>
                                <th width="20%" style="vertical-align: middle">Grant Amount Eligibility : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">RM 1,500</b></td>
                            </tr>
                        </thead>
                    </table>
                </div>

                <table style="table-layout:fixed; width:800px; word-wrap: break-word; margin-top: 100px"> 
                    <tr>
                        <td>....................................</td>
                        <td></td>
                        <td>....................................</td>
                        <td></td>
                        <td>....................................</td>
                    </tr>
                    <tr>
                        <td>{{strtoupper($application->staff->staff_name)}}</td>
                        <td></td>
                        <td>MOHD YUZI BIN ZALI</td>
                        <td></td>
                        <td>PROFESSOR DR ROSHAYANI BINTI DATO’ ARSHAD</td>
                    </tr>

                    <tr>
                        <td>{{$application->staff->staff_position}}</td>
                        <td></td>
                        <td>HEAD OF INFORMATION TECHNOLOGY UNIT (IITU)</td>
                        <td></td>
                        <td>CHIEF EXECUTIVE</td>
                    </tr>

                    <tr>
                        <td>Date:</td>
                        <td></td>
                        <td>Date:</td>
                        <td></td>
                        <td>Date:</td>

                    </tr>
                </table>
        </div>
    </div>
</main>
@endsection