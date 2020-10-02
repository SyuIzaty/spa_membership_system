@extends('layouts.admin')

@section('css') 
<link rel="stylesheet" href="{{ asset('css/print_select.css') }}" />
@endsection

@section('content')
<main id="js-page-content" role="main" class="page-content">

    {{-- <div class="subheader">
        <h1>
            <i class='subheader-icon fal fa-plus-circle'></i> Basic Info <small>| student's basic information</small>
        </h1>
    </div> --}}

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Graduation Audit <small>| student's graduation audit checklist</small> <span class="fw-300"><i> </i></span>
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

                            <div class="alert alert-warning alert-dismissible"  id="non-printable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fal fa-info"></i> Message</h5>
                                Please check your graduation audit checklist. If have an errors, please consult your academic advisor or faculty
                            </div>
                            
                            <div class="card-body">
                                <div align="right" id="non-printable"><a class="btn btn-app" onclick="javascript:window.print()"><i class="fal fa-print"></i> Print </a></div>
                                <div class="box box-primary"  id="printable">
                                    <div class="box-header with-border" align="center">
                                      <div><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="80" width="180" alt="INTEC"></div>
                                      <div><p></p><h3 valign="center" class="box-title"><strong>INTEC EDUCATION COLLEGE<br>GRADUATION AUDIT CHECKLIST</strong></h3><p></p></div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">

                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 10%">Name</th>
                                                    <td style="width: 60%"></td>
                                                    <th style="width: 10%">Registration Status</th>
                                                    <td style="width: 20%"></td>
                                                </tr>
                                                <tr>
                                                    <th>Student ID</th>
                                                    <td></td>
                                                    <th>Used Sem</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>IC/Passport No</th>
                                                    <td></td>
                                                    <th>Maximum Sem</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>Programme</th>
                                                    <td></td>
                                                    <th>Session Enroll</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>Faculty</th>
                                                    <td></td>
                                                    <th>Year of Study</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>Curriculum</th>
                                                    <td></td>
                                                    <th>Current GPA</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>Approval</th>
                                                    <td></td>
                                                    <th>Current CPA</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th>Reference No</th>
                                                    <td></td>
                                                    <th>Pass Credits</th>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 10%">Academic Advisor</th>
                                                    <td colspan="3"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="box-header with-border">
                                            <h3 class="box-title" style="font-weight: bold;">COURSE LISTS</h3>
                                        </div>

                                         <div class="box-body table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="bg-highlight"> 
                                                        <th>No</th>
                                                        <th>COURSE CODE</th>
                                                        <th>COURSE NAME</th>
                                                        <th style="text-align: center;">EXPECTED SEM TAKEN</th>
                                                        <th style="text-align: center;">SESSION TAKEN</th>
                                                        <th>STATUS</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td style="text-align: center;"></td>
                                                        <td style="text-align: center;"></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" style="text-align: right;">Printed date: ? </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                   
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="box box-primary">
                                                    <div class="box-body table-responsive">
                                                        <div class="box-header">
                                                            <h3 class="box-title" style="font-weight: bold;">CREDITS REQUIREMENT</h3>
                                                        </div>
                                                        <table class="table table-hover table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td>[A] OBTAINED CREDITS</td>
                                                                    <td style="text-align: center"></td>
                                                                    <td>[B] CURRENT CREDITS</td>
                                                                    <td style="text-align: center"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>[C] CREDITS TRANSFERRED</td>
                                                                    <td style="text-align: center"></td>
                                                                    <td>[D] CREDITS REDEMPTION</td>
                                                                    <td style="text-align: center"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>[E] TOTAL CO-CURRICULAR CREDITS TAKEN</td>
                                                                    <td style="text-align: center"></td>
                                                                    <td>[F] TOTAL CO-CURRICULAR CREDITS CALCULATED</td>
                                                                    <td style="text-align: center"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">[G] EXPECTED TOTAL CREDITS ACCUMULATED<br>G = (A+B+C)-(D)</td>
                                                                    <td style="text-align: center"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-weight: bold;" colspan="3">[H] EXPECTED TOTAL CREDITS FOR GRADUATION<br>H = (A+B+C+F)-(D+E)</td>
                                                                    <td style="font-weight: bold; text-align: center"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font-weight: bold;" colspan="3">PASS CREDITS</td>
                                                                    <td style="font-weight: bold; text-align: center"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="box box-primary">
                                                    <div class="box-body table-responsive">
                                                        <div class="box-header">
                                                            <h3 class="box-title" style="font-weight: bold;">OTHER REQUIREMENTS AND INFORMATION</h3>
                                                        </div>
                                                        <table class="table table-hover table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td>NATIONALITY</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>BM SPM / BM JULAI</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>MUET</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>DEBT STATUS</td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="box box-primary">
                                                    <div class="box-body table-responsive">
                                                        <div class="box-header">
                                                            <h3 class="box-title" style="font-weight: bold;">RECOMMENDATION BY ACADEMIC ADVISOR / FACULTY</h3>
                                                        </div>
                                                        <table class="table table-hover table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="50px"><input type="checkbox" class="form-control"></td>
                                                                    <td>QUALIFIED FOR GRADUATION</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="50px"><input type="checkbox" class="form-control"></td>
                                                                    <td>NOT QUALIFIED FOR GRADUATION</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">Signature and date:<br><br><br><br><br><br></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
        </div>
    </div>

</main>
@endsection

