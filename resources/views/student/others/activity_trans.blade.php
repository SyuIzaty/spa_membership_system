@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2 style="font-size: 25px;">
                        Student's Activities Transcript <small>| student's activities record</small> <span class="fw-300"><i> </i></span>
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
                                Please check your activities record
                            </div>
                            
                            <div class="card-body">
                                <div align="right" id="non-printable"><a class="btn btn-app" onclick="javascript:window.print()"><i class="fal fa-print"></i> Print </a></div>
                                
                                <div class="box box-primary" id="">
                                    <div class="box-header with-border" align="center">
                                      <div><img src="{{ URL::to('/') }}/img/intec_logo_new.png" height="70" width="180" alt="INTEC"></div>
                                      <div><p></p><h3 valign="center" class="box-title"><strong>INTEC EDUCATION COLLEGE<br>STUDENT'S ACTIVITIES TRANSCRIPT</strong></h3><p></p></div>
                                    </div>

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
                                                <th>IC/Passport No</th>
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
                                                <td colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%">Academic Advisor</th>
                                                <td colspan="3"></td>
                                            </tr>
                                        </tbody>
                                      </table>
                                      
                                        <div class="box-header with-border">
                                            <h3 class="box-title" style="font-weight: bold;">ACTIVITIES LIST</h3>
                                        </div>

                                        <div class="box-body table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr class="bg-highlight"> 
                                                        <th>No</th>
                                                        <th>SESSION / SEMESTER</th>
                                                        <th>NAME OF ACTIVITY</th>
                                                        <th>DATE</th>
                                                        <th>LEADERSHIP</th>
                                                        <th>ORGANIZATION</th>
                                                        <th>PARTICIPATION</th>
                                                        <th>AWARD</th>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right" colspan="8">Printed date: ?</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" colspan="8">This is a computer generated document, no signature is required.<br>
                                                                                    All the data displayed here is valid.  INTEC shall have no liability whatsoever <br>
                                                                                    or any inaccuracies due to manipulation or alteration of information.</td>
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

</main>
@endsection

