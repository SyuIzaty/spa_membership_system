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
                        Course Performance <small>| student's course performance details</small> <span class="fw-300"><i> </i></span>
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
                                Please check your course performance details. Contact your Lecturer, Academic Advisor or Faculty if have an errors.
                            </div>
                            
                            <div class="card-header">
                                <form action="" class="form-inline" method="">
                                    <input type="hidden" name="" value="">
                                    <span>SESSION / SEMESTER :</span> 
                                    <div class="form-group" id="">
                                        <select name="session" class="form-control" id="">
                                            <option value="0"> - Please choose - </option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                        </select>
                                    </div>
                                    <button type="#" style="margin-left:5px" class="btn btn-sm btn-warning btn-flat"><i class="fal fa-eye"></i> View</button>
                                </form>
                            </div>

                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label>SESSION / SEMESTER / YEAR : </label> 
                                    <form action="{{ route('course_performance') }}" method="GET">  <!-- post kepada StudentController.php dalam function course_performance() -->
                                        <div class="input-group select2-bootstrap-append">
                                            <select class="form-control" name="year" id="year">
                                            @php
                                                $current_year = date('Y', strtotime(" + 2 year")); // Sets the top option to be the current year.
                                                $earliest_year = 2015; // Year to start available options at
                                            @endphp
                                            @foreach (range( $current_year, $earliest_year ) as $i)
                                                <option value="{{ $i }}" {{ $req_year == $i ? ' selected' : '' }}>{{ $i }}</option>
                                            @endforeach
                                            </select>  
                                            <span class="input-group-btn"><button type="submit" class="btn bg-gradient-info btn-md"> View </button></span>
                                        </div>
                                    </form>
                                </div>  
                            </div> --}}

                            <div class="card-body border-primary ">
                                {{-- display only when selected by dropdown session --}}
                                {{-- <div class="ml-auto" id=""><a class="btn btn-app" href=""><i class="fal fa-print"></i> Print Slip </a></div> --}}
                                <div align="right"><a class="btn btn-app" href="#" onclick="Slip()" ><i class="fal fa-file-alt"></i> Slip </a></div>
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 style="font-weight: bold;" class="box-title">COURSE REGISTERED FOR SESSION ? SEMESTER ?</h3>
                                    </div>
                                    <div class="box-body table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr class="bg-highlight">
                                                    <th rowspan="2" style="text-align: left;">COURSE CODE</th>
                                                    <th rowspan="2" style="text-align: left;">COURSE NAME</th>
                                                    <th rowspan="2" style="text-align: center;">SECTION</th>
                                                    <th rowspan="2" style="text-align: center;">CREDIT</th>
                                                    <th colspan="2" style="text-align: center;">STATUS</th>
                                                    <th rowspan="2" style="text-align: center;">ATTENDANCE (%)</th>
                                                    <th rowspan="2" style="text-align: center;">WARNING LETTER</th>
                                                    <th rowspan="2" style="text-align: center;">COURSEWORK MARKS (%)</th>
                                                    <th rowspan="2" style="text-align: center;">GRADE</th>
                                                </tr>

                                                <tr class="bg-highlight">
                                                    <th style="text-align: center;">COURSE</th>
                                                    <th style="text-align: center;">REGISTRATION</th>
                                                </tr>
                                                
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"></td>
                                                    <td style="text-align: center;"><a href="#" onclick="Course()">CourseMark</a></td>  
                                                    <td style="text-align: center;"></td>
                                                </tr>
                                            
                                                <tr>
                                                    <td colspan="10"><span style="color: red; font-weight: bold;">NOTE</span>
                                                        <li>* Coursework marks are not displayed</li>
                                                        <li>Coursework marks are excluded final examination mark</li>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>           
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                     <!-- display when coursework mark clicked in table -->
                     <div class="panel-content" id="courseMark" style="display:none">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div align="right"><a class="btn btn-app" onclick="javascript:window.print()"><i class="fal fa-print"></i> Print </a></div>
                                <div class="box box-primary box-header" id="printable">    
                                    <div class="box-header with-border">
                                        <h3 style="font-weight: bold;" class="box-title">ASSESSMENT LIST FOR ? ( SESSION ? SEM ? )</h3>
                                    </div>
                                    <div>
                                        <div class="box-body table-responsive">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                    <td style="vertical-align: middle; width: 25%;"><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="70" width="180" alt="INTEC"></td>
                                                    <td style="width: 75%; text-align: right;"><strong>ASSESSMENT LIST</strong><br>SEMESTER : ?<br>SESSION : ?</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
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
                                                            <th style="width: 10%">Course Name</th>
                                                            <td colspan="3"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    <tr class="bg-highlight">
                                                        <th style="text-align: left;">ASSESSMENT</th>
                                                        <th style="text-align: left;">METHOD</th>
                                                        <th style="text-align: center;">MARK</th>
                                                        <th style="text-align: center;">FULLMARK</th>
                                                        <th style="text-align: center;">PERCENTAGE</th>
                                                        <th style="ext-align: center;">TOTAL (%)</th>
                                                    </tr>
                                                     <tr>
                                                        <td style="text-align: left;"></td>
                                                        <td style="text-align: left;"></td>
                                                        <td style="text-align: center;"></td>
                                                        <td style="text-align: center;"></td>
                                                        <td style="text-align: center;"></td>
                                                        <td style="text-align: center; background-color: #eee;"></td>
                                                    </tr>
                                                     <tr style="background-color: maroon;">
                                                        <td colspan="4" style="text-align: right; font-weight: bold; color: white;">TOTAL</td>
                                                        <td style="text-align: center; font-weight: bold; color: white;"></td>
                                                        <td style="text-align: center; font-weight: bold; color: white;"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div align="left"><span style="color: red; font-weight: bold;">NOTE</span>
                                                            <li>Total (%) = (Mark/Fullmark)*Percentage</li>
                                                            <li>Total coursework marks are excluded final examination</li>
                                                            <li>All marks and assessment details are subject to amendments</li><p></p></div>
                                                <div align="left">Printed date: ?</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- display when coursework mark clicked in table -->
                    <div class="panel-content" id="courseSlip" style="display:none">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div align="right"><a class="btn btn-app" onclick="javascript:window.print()"><i class="fal fa-print"></i> Print </a></div>
                                <div class="box box-primary box-header"  id="printable">    
                                    <div class="box-header with-border">
                                        <h3 style="font-weight: bold;" class="box-title">COURSE REGISTRATION SLIP SEMESTER ? SESSION ?</h3>
                                    </div>
                                    <div id="">
                                        <div class="box-body table-responsive">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td style="vertical-align: middle; width: 25%;"><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="70" width="180" alt="INTEC"></td>
                                                        <td style="width: 75%; text-align: right;"><strong>COURSE REGISTRATION SLIP</strong><br>SEMESTER : ?<br>SESSION : ?</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                                                            <th rowspan="2" style="text-align: left;">NO.</th>
                                                            <th rowspan="2" style="text-align: left;">COURSE CODE</th>
                                                            <th rowspan="2" style="text-align: left;">COURSE NAME</th>
                                                            <th rowspan="2" style="text-align: center;">SECTION</th>
                                                            <th colspan="2" style="text-align: center;">STATUS</th>
                                                            <th rowspan="2" style="text-align: center;">CREDIT</th>
                                                        </tr>
                                                        <tr class="bg-highlight">
                                                            <th style="text-align: center;">COURSE</th>
                                                            <th style="text-align: center;">REGISTRATION</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left;"></td>
                                                            <td style="text-align: left;"></td>
                                                            <td style="text-align: left;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                            <td style="text-align: center;"></td>
                                                        </tr>
                                                        <tr style="background-color: maroon; font-weight: bold; color: white;">
                                                            <td colspan="6" style="text-align: right;">TOTAL CREDITS REGISTERED</td>
                                                            <td style="text-align: center;"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                                <div align="left"><span style="color: red; font-weight: bold;">NOTE</span>
                                                    <li>If mistakenly registered, please do amendation immediately. Please inform your Academic Advisor if you have make any changes.</li>
                                                </div>
                                                <p>
                                                </p><div align="left">Printed date: ?</div>
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

function Course() {
  var x = document.getElementById("courseMark");
  var y = document.getElementById("courseSlip");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
  } else {
    x.style.display = "none";
  }
}

function Slip() {
  var x = document.getElementById("courseSlip");
  var y = document.getElementById("courseMark");
  if (x.style.display === "none") {
    x.style.display = "block";
    y.style.display = "none";
  } else {
    x.style.display = "none";
  }
}

</script>

@endsection



