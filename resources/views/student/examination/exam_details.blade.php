@extends('layouts.admin')

@section('css') 
<link rel="stylesheet" href="{{ asset('css/print_select.css') }}" />
@endsection

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Examination Details <small>| student's examination details</small> <span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">

                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fal fa-info"></i> Message</h5>
                                Please check your examination details. Contact your Faculty, Academic Management Office (Undergraduates) or Centre For Graduate Studies (Postgraduates) if have an errors.
                            </div>
                            
                            <div class="card-body">

                                <div class="box box-primary" id="">
                                    <div class="box-header with-border">
                                        <h3 style="font-weight: bold;" class="box-title">SUMMARY OF ACADEMIC ACCOMPLISHMENT</h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr class="bg-highlight">
                                                    <th rowspan="2" style="text-align: left;">SESSION</th>
                                                    <th rowspan="2" style="text-align: left;">SEMESTER</th>
                                                    <th rowspan="2" style="text-align: center;">SEM CREDITS COUNTED</th>
                                                    <th rowspan="2" style="text-align: center;">SEM CREDITS OBTAINED</th>
                                                    <th colspan="2" style="text-align: center;">CGPA</th>
                                                    <th rowspan="2" style="text-align: center;">CUMULATIVE CREDITS OBTAINED</th>
                                                    <th rowspan="2" style="text-align: center;">ACADEMIC STATUS</th>
                                                    <th rowspan="2" style="text-align: center;">EXAMINATION SCHEDULE</th>
                                                </tr>

                                                <tr class="bg-highlight">
                                                    <th style="text-align: center;">GPA</th>
                                                    <th style="text-align: center;">CPA</th>
                                                </tr>
                                                
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"><a href="#" onclick="GPA_CPA()" >GPA</a></td>
                                                    <td style="text-align: center;"><a href="#" onclick="GPA_CPA()" >CPA</a></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>  
                                                    <td style="text-align: center;"><a href="#" onclick="examSchedule()">Schedule</a></td>
                                                </tr>
                                            </tbody>
                                        </table>           
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- examination schedule display popup when click schedule on table -->
                    <div class="panel-content" id="exam_schedule" style="display:none">
                        <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div align="right"><a class="btn btn-app" onclick="javascript:window.print()"><i class="fal fa-print"></i> Print </a></div>
                            <div class="box box-primary box-header"  id="printable">    
                                <div class="box-header with-border">
                                    <h3 style="font-weight: bold;" class="box-title">EXAMINATION SCHEDULE FOR SEMESTER ? SESSION ?</h3>
                                </div>
                                <div>
                                    <div class="box-body table-responsive">
                                        <table>
                                            <tbody><tr>  
                                                <td style="vertical-align: middle; width: 25%;"><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="70" width="180" alt="INTEC"></td>
                                                <td style="width: 75%; text-align: right;"><strong>EXAMINATION SCHEDULE</strong><br>SEMESTER : ?<br>SESSION : ?</td>
                                            </tr>
                                        </tbody></table>
                                        <div>
                                            <table class="table table-bordered">
                                                <tbody><tr>
                                                    <th style="width: 10%">Name</th>
                                                    <td colspan="3"></td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 10%">Student ID</th>
                                                    <td></td>
                                                    <th style="width: 10%">IC/Passport</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>Programme</th>
                                                    <td></td>
                                                    <th>Faculty</th>
                                                    <td></td>
                                                </tr>
                                            </tbody></table>
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr class="bg-highlight">
                                                    <th style="text-align: left;">COURSE CODE</th>
                                                    <th style="text-align: left;">COURSE NAME</th>
                                                    <th style="text-align: center;">DATE</th>
                                                    <th style="text-align: center;">TIME</th>
                                                    <th style="text-align: center;">EXAMINATION ROOM</th>
                                                    <th style="text-align: center;">SEATING NUMBER</th>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"></td>
                                                    <td style="text-align: left;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                </tr>
                                                 <tr>
                                                    <td colspan="6" style="font-weigt: bold; color: red;">NOTIFICATION :</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6"><li>Student needs to bring student card and final examination slip to the examination hall.</li>
                                                                    <li>Student is required to sit for exam at the seating number as indicated in the final examination slip.</li>
                                                                    <li>Students are not allowed to bring any unauthorised materials including course note, mobile phone, pencil box, etc into the examination hall.</li>
                                                                    <li>Please comply with the INTEC Final Examination Regulation.</li>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                            <div align="right">Printed date: </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- cgpa display popup when click cpa/gpa on table -->
                    <div class="panel-content" id="gpa_cpa" style="display:none">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div align="right"><a class="btn btn-app" onclick="javascript:window.print()"><i class="fal fa-print"></i> Print </a></div>
                                <div class="box box-primary box-header"  id="printable">    
                                    <div class="box-header with-border">
                                        <h3 style="font-weight: bold;" class="box-title">EXAMINATION RESULT (CGPA) FOR SEMESTER ? SESSION ?</h3>
                                    </div>
                                    <div id="">
                                        <div class="box-body table-responsive">
                                            <table>
                                                <tbody><tr>
                                                    <td style="vertical-align: middle; width: 25%;"><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="70" width="180" alt="INTEC"></td>
                                                    <td style="width: 75%; text-align: right;"><strong>EXAMINATION RESULT</strong><br>SEMESTER : ?<br>SESSION : ?</td>
                                                </tr>
                                            </tbody></table>
                                            <div>
                                                <table class="table table-bordered">
                                                    <tbody><tr>
                                                        <th style="width: 10%">Name</th>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 10%">Student ID</th>
                                                        <td></td>
                                                        <th style="width: 10%">IC/Passport</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Programme</th>
                                                        <td></td>
                                                        <th>Faculty</th>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Academic Advisor</th>
                                                        <td colspan="3"></td>
                                                    </tr>
                                                </tbody></table>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr class="bg-highlight">
                                                            <th style="text-align: left;">COURSE CODE</th>
                                                            <th style="text-align: left;">COURSE NAME</th>
                                                            <th style="text-align: center;">SECTION</th>
                                                            <th style="text-align: center;">CR</th>
                                                            <th style="text-align: center;">ST</th>
                                                            <th style="text-align: center;">CS</th>
                                                            <th style="text-align: center;">GR</th>
                                                            <th style="text-align: center;">KD</th>
                                                            <th style="text-align: center;">KK</th>
                                                            <th style="text-align: center;">MN</th>
                                                            <th style="text-align: center;">KM</th>
                                                            <th style="text-align: center;">MM</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left;"></td>
                                                            <td style="text-align: left;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                        </tr>
                                                        <tr>
                                                            <th colspan="7">Legend</th>						
                                                            <td class="bg-highlight" width="2%" style="text-align: center;"></td>
                                                            <th class="bg-highlight" width="10%" colspan="2" style="text-align: center;">This Semester</th>
                                                            <th class="bg-highlight" width="10%" colspan="2" style="text-align: center;">All Semester</th>
                                                        </tr>
                                                    
                                                        <tr>
                                                            <td colspan="7" rowspan="8">							
                                                                <table class="table">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>CR : Credit</td>
                                                                        <td>ST : Registration Status</td>
                                                                        <td>CS : Course Status</td>
                                                                        <td>GR : Grade</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>KD : Credits Obtained</td>
                                                                        <td>KK : Credits Counted</td>
                                                                        <td>MR : Mark</td>
                                                                        <td>MN : Point</td>
                                                                    </tr>
                                                                    <tr>
                                                                        
                                                                        <td>JMN : Total Point</td>
                                                                        <td>KM : Credits Cancelled</td>
                                                                        <td>MM : Point Cancelled</td>
                                                                        <td>KP : Transfer Credit</td>
                                                                    </tr>
                                                                    <tr>
                                                                        
                                                                        <td>UM : Repeat</td>
                                                                        <td>KB : Satisfactory</td>
                                                                        <td>KS : Probation</td>
                                                                        <td>KG : Fail</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>

                                                                <span style="color: red">* NOTE<br></span>
                                                                <span>This examination result is only valid if certified by Academic Management Office's (PPA) stamp
                                                                and officer's signature for undergraduate students or Centre of Graduate Studies (PS) stamp
                                                                and officer's signature for postgraduate students
                                                                </span>

                                                            </td>

                                                            <td style="text-align: center;">KD</td>
                                                            <td style="text-align: center;" colspan="2"></td>
                                                            <td style="text-align: center;" colspan="2"></td>
                                                        </tr>

                                                    <tr>
                                                        <td style="text-align: center;">KP</td>
                                                        <td style="text-align: center;" colspan="2"></td>
                                                        <td style="text-align: center;" colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">KK</td>
                                                        <td style="text-align: center;" colspan="2"></td>
                                                        <td style="text-align: center;" colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">JMN</td>
                                                        <td style="text-align: center;" colspan="2"></td>
                                                        <td style="text-align: center;" colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">GPA</td>
                                                        <th style="text-align: center;" colspan="4"></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">CPA</td>
                                                        <th style="text-align: center;" colspan="4"></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="background-color: maroon;"></td>
                                                        <th colspan="4" style="background-color: maroon; color: white; text-align: center;">Academic Status</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <th style="text-align: center;" colspan="4">KB</th>
                                                    </tr>
                                                </tbody></table>
                                                <div align="right">Printed date: ?</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

function GPA_CPA() {
  var x = document.getElementById("gpa_cpa");
  var y = document.getElementById("exam_schedule");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
  } else {
    x.style.display = "none";
  }
}

function examSchedule() {
  var x = document.getElementById("exam_schedule");
  var y = document.getElementById("gpa_cpa");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
  } else {
    x.style.display = "none";
  }
}

</script>

@endsection
