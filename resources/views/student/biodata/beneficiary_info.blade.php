@extends('layouts.admin')

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
                        Beneficiary Info <small>| student's beneficiary information</small> <span class="fw-300"><i> </i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>

                    {{-- <div class="callout callout-info" id="non-printable">
                        <h4>Message</h4>
                        Please check your biodata information. Contact Academic Management Office (Undergraduates) or Centre For Graduate Studies (Postgraduates) if have an errors.		
                    </div> --}}

                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">
                            
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fal fa-info"></i> Message</h5>
                                Please check your beneficiary information. Contact Academic Management Office (Undergraduates) or Centre For Graduate Studies (Postgraduates) if have an errors.
                            </div>

                        <div class="card-header bg-highlight">
                            <h5 class="card-title w-100">FATHER'S INFORMATION <small>| GUARDIAN I</small></h5>
                        </div>
                            <div class="card-body">
                                <table id="father" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td width="21%"><b>Father's Name :</b></td>
                                            <td style="text-transform: uppercase;" colspan="5">{{ $student->studentGuardian->guardian_one_name }}</td>
                                            <td width="21%"><b>IC / Passport :</b></td>
                                            <td style="text-transform: uppercase;" colspan="5"> {{ $student->studentGuardian->guardian_one_ic }} </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Address :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Position :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Salary :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>
        
                                        <tr>
                                            <td width="21%"><b>Nationality :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Occupation :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Position :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Salary :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="21%"><b>Dependents :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Mobile No. :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Email :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>

                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">
                        <div class="card-header bg-highlight">
                            <h5 class="card-title w-100">MOTHER'S INFORMATION <small>| GUARDIAN II</small></h5>
                        </div>
                            <div class="card-body">
                                <table id="mother" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td width="21%"><b>Mother's Name :</b></td>
                                            <td style="text-transform: uppercase;" colspan="5">{{ $student->studentGuardian->guardian_two_name }}</td>
                                            <td width="21%"><b>IC / Passport :</b></td>
                                            <td style="text-transform: uppercase;" colspan="5">{{ $student->studentGuardian->guardian_two_ic}} </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Address :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Nationality :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Occupation :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Position :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Salary :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="21%"><b>Dependents :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Mobile No. :</b></td>
                                            <td colspan="5"> </td>
                                            <td width="21%"><b>Email :</b></td>
                                            <td colspan="5"> </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="card card-primary card-outline">
                        <div class="card-header bg-highlight">
                            <h5 class="card-title w-100">EMERGENCY CONTACT</h5>
                        </div>
                            <div class="card-body">
                                <table id="emergency" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <td width="21%"><b>Name :</b></td>
                                            <td style="text-transform: uppercase;" colspan="5">{{ $student->studentEmergency->emergency_name }}</td>
                                            <td width="21%"><b>Relationship :</b></td>
                                            <td style="text-transform: uppercase;" colspan="5">{{ $student->studentEmergency->emergency_relationship }}</td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Address :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>

                                        <tr>
                                            <td width="21%"><b>Mobile No. :</b></td>
                                            <td colspan="10"> </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</main>
@endsection

