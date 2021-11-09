@extends('layouts.applicant')

@section('content')

<style>
.flex-container {
  display: flex;
}

.flex-container > div {
  /* margin: 10px; */
  padding: 20px;
}

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

                <center><img src="{{ URL::to('/') }}/img/INTEC_PRIMARY_LOGO.png" height="110" width="300" alt="INTEC" style="margin-top: -65px"></center><br>

                <div class="table-responsive" style="margin-top: 50px;">
                    <table id="info" class="table table-bordered w-100">
                        <thead>
                            <tr class="text-center">
                                <th colspan="5">COMPUTER GRANT APPLICATION</th>
                            </tr>

                            <tr>
                                <th width="20%" style="vertical-align: middle">Application Date : </th>
                                <td colspan="2" style="vertical-align: middle">{{date('d/m/Y', strtotime($application->created_at))}}</td>
                                <th width="20%" style="vertical-align: middle">Approval Date : </th>
                                <td colspan="2" style="vertical-align: middle">{{date('d/m/Y', strtotime($application->approved_at))}}</td>
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
                            <tr>
                                <th width="20%" style="vertical-align: top">Device Type : </th>
                                <td colspan="5" style="vertical-align: middle">{{$application->getType->description}}</td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Brand : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">{{$application->brand}}</b></td>
                                <th width="20%" style="vertical-align: middle">Serial No. : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">{{$application->serial_no}}</b></td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Model : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">{{$application->model}}</b></td>
                                <th width="20%" style="vertical-align: middle">Price : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">RM {{$application->price}}</b></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <br>
                <p>I, {{strtoupper($application->staff->staff_name)}} CONFIRM THAT THE PERSONAL DETAILS AND PURCHASE PROOF GIVEN ARE GENUINE. I UNDERSTAND AND AGREE TO COMPLY WITH ALL RULES AND REGULATIONS OF THE COMPUTER GRANT.</p>
                
                <p>Terms:</p>
                <ol>
                    <li>Application is eligible for permanent and contract academic staff only.</li>
                    <li>Grant period is {{$application->getQuota->duration}} years only.</li>
                    <li>Device purchase must be made within one month after obtaining approval.</li>
                    <li>Device can be purchased from any supplier, including online.</li>
                    <li>Type of device that can be purchased are Laptop or Tablet only.</li>
                </ol>

                <div style="float: left; margin-top: 100px;">
                    .......................................................................................

                    <p style="margin-top: 10px;">{{strtoupper($application->staff->staff_name)}}</p>
                    <p>{{$application->staff->staff_position}}</p>
                    <br>
                    <p>Date:</p>
                </div>
                <div style="float: right; margin-top: 100px;">
                    .......................................................................................

                    <p style="margin-top: 10px;">MOHD YUZI BIN ZALI</p>
                    <p>HEAD OF INFORMATION TECHNOLOGY UNIT (IITU)</p>
                    <br>
                    <p>Date:</p>
                </div>
        </div>
    </div>
</main>
@endsection