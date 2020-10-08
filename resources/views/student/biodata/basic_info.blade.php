@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 25px;">
                            Personal Info <small>| student's basic information</small> <span class="fw-300"><i> </i></span>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fal fa-info"></i> Message</h5>
                        Please check your information. Contact Academic Management Office (Undergraduates) or Centre For Graduate Studies (Postgraduates) if have an errors.
                    </div> 

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#personal" role="tab">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#beneficiary" role="tab">Beneficiary Information</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#sponsorship" role="tab">Sponsorship Information</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="personal" role="tabpanel"><br>
                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-highlight">
                                            <h5 class="card-title w-100">PERSONAL DETAILS</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="profile" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td width="21%"><b>Name :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="10">{{ $student->students_name }}</td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Student ID :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="10"> </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Registration Status :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="10"> </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>IC/Passport Number :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="10">{{ $student->students_ic }}</td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Sex :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="5"> {{ $student->gender->gender_name }}</td>
                                                        <td width="21%"><b>Date of Birth :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="5"> {{ $student->students_dob }} </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Religion :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="5"> {{ $student->religion->religion_name }}</td>
                                                        <td width="21%"><b>Race :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="5"> {{ $student->race->race_name }}</td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Nationality :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="5">{{ $student->students_nationality }} </td>
                                                        <td width="21%"><b>Country :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="5"> {{ $student->studentContactInfo->country->country_name }}</td> 
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Phone No. :</b></td>
                                                        <td colspan="5">{{ $student->students_phone }} </td>
                                                        <td width="21%"><b>Email :</b></td>
                                                        <td colspan="5">{{ $student->students_email }} </td>
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
                                            <h5 class="card-title w-100">ACADEMIC DETAILS</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="profile" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td width="21%"><b>Level of Study :</b></td>
                                                        <td colspan="10"> </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Faculty :</b></td>
                                                        <td colspan="10"> </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Programme :</b></td>
                                                        <td style="text-transform: uppercase;" colspan="10">{{ $student->programme->programme_name }}</td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Curriculum Code :</b></td>
                                                        <td colspan="10"></td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Type of Study :</b></td>
                                                        <td colspan="5"> </td>
                                                        <td width="21%"><b>Mode of Study :</b></td>
                                                        <td colspan="5"> </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Session Enroll :</b></td>
                                                        <td colspan="5"> </td>
                                                        <td width="21%"><b>Date of Enroll :</b></td>
                                                        <td colspan="5"> </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Year of Study (Current) :</b></td>
                                                        <td colspan="5"> </td>
                                                        <td width="21%"><b>Semester Duration :</b></td>
                                                        <td colspan="5"> </td>
                                                    </tr>
                                    
                                                    <tr>
                                                        <td width="21%"><b>Academic Advisor :</b></td>
                                                        <td colspan="10"> </td>
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
                                            <h5 class="card-title w-100">DOCUMENT SUBMISSION STATUS</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="profile" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td width="21%"><b>Personal File</b></td>
                                                        <td><div class="form-check">
                                                            <input class="form-check-input" type="checkbox" checked disabled>
                                                            {{-- <input type="checkbox" class="form-control"> --}}
                                                        </div></td>
                                                        <td width="21%"><b>Medical File</b></td>
                                                        <td><div class="form-check">
                                                            <input class="form-check-input" type="checkbox" checked disabled>
                                                        </div></td>
                                                        <td width="21%"><b>Financial Guarantee Forms</b></td>
                                                        <td><div class="form-check">
                                                            <input class="form-check-input" type="checkbox" checked disabled>
                                                        </div></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="beneficiary" role="tabpanel"><br>
                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="card card-primary card-outline">
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
                                                        <td style="text-transform: uppercase;" colspan="5">{{ $student->studentGuardian->guardian_one_ic }}</td>
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
                                                        <td style="text-transform: uppercase;" colspan="5">{{ $student->studentGuardian->guardian_two_ic}}</td>
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

                        <div class="tab-pane" id="sponsorship" role="tabpanel"><br>
                            <div class="panel-container show">
                                <div class="panel-content">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header bg-highlight">
                                            <h5 class="card-title w-100">BANK ACCOUNT DETAILS</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="bank" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td width="21%"><b>Account Number:</b></td>
                                                        <td colspan="10"> </td>
                                                    </tr>
            
                                                    <tr>
                                                        <td width="21%"><b>Bank Name :</b></td>
                                                        <td colspan="10"> </td>
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
                                            <h5 class="card-title w-100">SPONSORSHIP DETAILS</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="sponsor" class="table table-bordered table-hover table-striped w-100">
                                                <thead>
                                                    <tr>
                                                        <td width="21%"><b>Sponsor Name :</b></td>
                                                        <td colspan="10"> </td>
                                                    </tr>
            
                                                    <tr>
                                                        <td width="21%"><b>Sponsorship Status :</b></td>
                                                        <td colspan="10"> </td>
                                                    </tr>
            
                                                    <tr>
                                                        <td width="21%"><b>Amount Per Semester :</b></td>
                                                        <td colspan="5"> </td>
                                                        <td width="21%"><b>Amount Per Year :</b></td>
                                                        <td colspan="5"> </td>
                                                    </tr>
            
                                                    <tr>
                                                        <td width="21%"><b>Guarantor I :</b></td>
                                                        <td colspan="5"> </td>
                                                        <td width="21%"><b>Guarantor's Address :</b></td>
                                                        <td colspan="5"> </td>
                                                    </tr>
            
                                                    <tr>
                                                        <td width="21%"><b>Guarantor II :</b></td>
                                                        <td colspan="5"> </td>
                                                        <td width="21%"><b>Guarantor's Address :</b></td>
                                                        <td colspan="5"> </td>
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
        </div>
    </div>

</main>
@endsection

