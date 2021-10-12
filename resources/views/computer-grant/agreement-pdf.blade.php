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
                                <td colspan="2" style="vertical-align: middle">{{$application->office_no}}</td>
                            </tr>
                            <tr>
                                <th width="20%" style="vertical-align: middle">Grant Period Eligibility : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">1825 Days (Maximum is 60 Months = 1825 days)</b></td>
                                <th width="20%" style="vertical-align: middle">Grant Amount Eligibility : </th>
                                <td colspan="2" style="vertical-align: middle; text-transform: capitalize;">RM 1,500</b></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <br>
                <p>I, {{strtoupper($application->staff->staff_name)}} CONFIRMED THAT THE PERSONAL DETAILS AND PURCHASE PROOF GIVEN ARE GENUINE. I AGREE TO ACCEPT THIS APPLICATION AND ABIDE ALL REGULATIONS.</p>

                <!-- <div class="flex-container"> -->
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
                <!-- </div> -->
                

                {{-- <div style="font-style: italic; font-size: 10px">
                    <p style="float: left">@ Copyright INTEC Education College</p>
                    <p style="float: right">Review Date : {{ date(' j F Y | h:i:s A ', strtotime($student->created_at)) }}</p><br>
                </div> --}}
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
</script>
@endsection
