@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Applicant
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Applicant</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#details" role="tab">Applicant Details</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#academic" role="tab">Applicant Academic</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#bucket" role="tab">Applicant Bucket Details</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="details" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-header">Preffered Programme</div>
                                                    <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr>
                                                            <th>Applied Programme</th>
                                                            <th>Major</th>
                                                            <th>Result</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <p>{{ $applicant->applicant_programme }}</p>
                                                                <p>{{ $applicant->applicant_programme_2 }}</p>
                                                                <p>{{ $applicant->applicant_programme_3 }}</p>
                                                            </td>
                                                            <td>
                                                                <p>{{ $applicant->applicant_major }}</p>
                                                                <p>{{ $applicant->applicant_major_2 }}</p>
                                                                <p>{{ $applicant->applicant_major_3 }}</p>
                                                            </td>
                                                            <td>
                                                                @if($applicant['programme_status']== '1')
                                                                    <p style="color:green">Accepted</p>
                                                                @elseif($applicant['programme_status'] == NULL)
                                                                    <p></p>
                                                                @else
                                                                    <p style="color: red">Rejected</p>
                                                                @endif
                                                                @if($applicant['programme_status_2']== '1')
                                                                    <p style="color: green">Accepted</p>
                                                                @elseif($applicant['programme_status_2'] == NULL)
                                                                <p></p>
                                                                @else
                                                                    <p style="color: red">Rejected</p>
                                                                @endif
                                                                @if($applicant['programme_status_3']== '1')
                                                                    <p style="color: green">Accepted</p>
                                                                @elseif($applicant['programme_status_3'] == NULL)
                                                                <p></p>
                                                                @else
                                                                    <p style="color: red">Rejected</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <p>{{$applicant->reason_fail}}</p>
                                                                <p>{{$applicant->reason_fail_2}}</p>
                                                                <p>{{$applicant->reason_fail_3}}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-3">
                                        </div>
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-header">Personal Profile</div>
                                                    <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" name="applicant_name" value="{{ $applicant->applicant_name }}">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="form-label">IC Number</label>
                                                            <input type="text" class="form-control" name="applicant_ic" value="{{ $applicant->applicant_ic }}">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="form-label">Birth Date</label>
                                                            <input type="date" class="form-control" name="applicant_dob" value="{{ $applicant->applicant_dob }}">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="form-label">Phone Number</label>
                                                            <input type="text" class="form-control" name="applicant_phone" value="{{ $applicant->applicant_phone }}">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="applicant_email" value="{{ $applicant->applicant_email }}">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="form-label">Gender</label>
                                                            <input type="text" class="form-control" name="applicant_gender" value="{{ $applicant->applicant_gender }}">
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label class="form-label">Marital Status</label>
                                                            <input type="text" class="form-control" name="applicant_marital" value="{{ $applicant->applicant_marital }}">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="form-label">Race</label>
                                                            <input type="text" class="form-control" name="applicant_race" value="{{ $applicant->applicant_race }}">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="form-label">Religion</label>
                                                            <input type="text" class="form-control" name="applicant_religion" value="{{ $applicant->applicant_religion }}">
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <label class="form-label">Nationality</label>
                                                            <input type="text" class="form-control" name="applicant_nationality" value="{{ $applicant->applicant_nationality }}">
                                                        </div>
                                                        @if(isset($applicant->applicantContactInfo))
                                                        <div class="col-md-12 form-group">
                                                            <label class="form-label">Address</label>
                                                            <input type="text" class="form-control" name="applicant_address_1" value="{{ $applicant->applicantContactInfo->applicant_address_1 }}"><br>
                                                            <input type="text" class="form-control" name="applicant_address_2" value="{{ $applicant->applicantContactInfo->applicant_address_2 }}">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="form-label">Postcode</label>
                                                            <input type="text" class="form-control" name="applicant_poscode" value="{{ $applicant->applicantContactInfo->applicant_poscode }}">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="form-label">City</label>
                                                            <input type="text" class="form-control" name="applicant_city" value="{{ $applicant->applicantContactInfo->applicant_city }}">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="form-label">State</label>
                                                            <input type="text" class="form-control" name="applicant_state" value="{{ $applicant->applicantContactInfo->applicant_state }}">
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <label class="form-label">Country</label>
                                                            <input type="text" class="form-control" name="applicant_country" value="{{ $applicant->applicantContactInfo->applicant_country }}">
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-3">
                                    <div class="card">
                                        <div class="card-header">Parent Information</div>
                                        <div class="card-body">
                                            @if(isset($applicant->applicantGuardian))
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Name(Father / Guardian I)</label>
                                                    <input type="text" class="form-control" name="guardian_one_name" value="{{ $applicant->applicantGuardian->guardian_one_name }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Relationship</label>
                                                    <input type="text" class="form-control" name="guardian_one_relationship" value="{{ $applicant->applicantGuardian->guardian_one_relationship }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">IC / Passport</label>
                                                    <input type="text" class="form-control" name="guardian_one_ic" value="{{ $applicant->applicantGuardian->guardian_one_ic }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Nationality</label>
                                                    <input type="text" class="form-control" name="guardian_one_nationality" value="{{ $applicant->applicantGuardian->guardian_one_nationality }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Occupation</label>
                                                    <input type="text" class="form-control" name="guardian_one_occupation" value="{{ $applicant->applicantGuardian->guardian_one_occupation }}">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" name="guardian_one_address" value="{{ $applicant->applicantGuardian->guardian_one_address }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Mobile Phone</label>
                                                    <input type="text" class="form-control" name="guardian_one_mobile" value="{{ $applicant->applicantGuardian->guardian_one_mobile }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="guardian_one_email" value="{{ $applicant->applicantGuardian->guardian_one_email }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Name(Mother / Guardian II)</label>
                                                    <input type="text" class="form-control" name="guardian_two_name" value="{{ $applicant->applicantGuardian->guardian_two_name }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Relationship</label>
                                                    <input type="text" class="form-control" name="guardian_two_relationship" value="{{ $applicant->applicantGuardian->guardian_two_relationship }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">IC / Passport</label>
                                                    <input type="text" class="form-control" name="guardian_two_ic" value="{{ $applicant->applicantGuardian->guardian_two_ic }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Nationality</label>
                                                    <input type="text" class="form-control" name="guardian_two_nationality" value="{{ $applicant->applicantGuardian->guardian_two_nationality }}">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="form-label">Occupation</label>
                                                    <input type="text" class="form-control" name="guardian_two_occupation" value="{{ $applicant->applicantGuardian->guardian_two_occupation }}">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" name="guardian_two_address" value="{{ $applicant->applicantGuardian->guardian_two_address }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Mobile Phone</label>
                                                    <input type="text" class="form-control" name="guardian_two_mobile" value="{{ $applicant->applicantGuardian->guardian_two_mobile }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="guardian_two_email" value="{{ $applicant->applicantGuardian->guardian_two_email }}">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-3">
                                    <div class="card">
                                        <div class="card-header">Emergency Contact</div>
                                        <div class="card-body">
                                            @if(isset($applicant->applicantEmergency))
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="emergency_name" value="{{ $applicant->applicantEmergency->emergency_name }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Relationship</label>
                                                    <input type="text" class="form-control" name="emergency_relationship" value="{{ $applicant->applicantEmergency->emergency_relationship }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Mobile Phone</label>
                                                    <input type="text" class="form-control" name="emergency_phone" value="{{ $applicant->applicantEmergency->emergency_phone }}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="emergency_email" value="{{ $applicant->applicantEmergency->emergency_email }}">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" name="emergency_address" value="{{ $applicant->applicantEmergency->emergency_address }}">
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="academic" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">Academic Qualification</div>
                                            <div class="card-body">
                                                @if(count($spm)!=0)
                                                <h5>SPM</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>Subject Code</td>
                                                        <td>Subject Name</td>
                                                        <td>Grade</td>
                                                    </tr>
                                                    @foreach($spm as $spms)
                                                        <tr>
                                                            <td>{{$spms->subjects->first()->subject_code}}</td>
                                                            <td>{{$spms->subjects->first()->subject_name}}</td>
                                                            <td>{{$spms->grades->grade_code}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </table>
                                                @endif
                                                @if(count($stpm)!=0)
                                                <h5>STPM</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>Subject Code</td>
                                                        <td>Subject Name</td>
                                                        <td>Grade</td>
                                                    </tr>
                                                    @foreach($stpm as $stpms)
                                                        <tr>
                                                            <td>{{$stpms->subjects->first()->subject_code}}</td>
                                                            <td>{{$stpms->subjects->first()->subject_name}}</td>
                                                            <td>{{$stpms->grades->grade_code}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </table>
                                                @endif
                                                @if(count($stam)!=0)
                                                <h5>STAM</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>Subject Code</td>
                                                        <td>Subject Name</td>
                                                        <td>Grade</td>
                                                    </tr>
                                                    @foreach($stam as $stams)
                                                        <tr>
                                                            <td>{{$stams->subjects->first()->subject_code}}</td>
                                                            <td>{{$stams->subjects->first()->subject_name}}</td>
                                                            <td>{{$stams->grades->grade_code}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </table>
                                                @endif
                                                @if(count($uec)!=0)
                                                <h5>UEC</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>Subject Code</td>
                                                        <td>Subject Name</td>
                                                        <td>Grade</td>
                                                    </tr>
                                                    @foreach($uec as $uecs)
                                                        <tr>
                                                            <td>{{$uecs->subjects->first()->subject_code}}</td>
                                                            <td>{{$uecs->subjects->first()->subject_name}}</td>
                                                            <td>{{$uecs->grades->grade_code}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </table>
                                                @endif
                                                @if(count($alevel)!=0)
                                                <h5>A Level</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>Subject Code</td>
                                                        <td>Subject Name</td>
                                                        <td>Grade</td>
                                                    </tr>
                                                    @foreach($alevel as $alevels)
                                                        <tr>
                                                            <td>{{$alevels->subjects->first()->subject_code}}</td>
                                                            <td>{{$alevels->subjects->first()->subject_name}}</td>
                                                            <td>{{$alevels->grades->first()->grade_code}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </table>
                                                @endif
                                                @if(count($olevel)!=0)
                                                <h5>O Level</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>Subject Code</td>
                                                        <td>Subject Name</td>
                                                        <td>Grade</td>
                                                    </tr>
                                                    @foreach($olevel as $olevels)
                                                        <tr>
                                                            <td>{{$olevels->subjects->first()->subject_code}}</td>
                                                            <td>{{$olevels->subjects->first()->subject_name}}</td>
                                                            <td>{{$olevels->grades->grade_code}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </table>
                                                @endif
                                                @if(isset($matriculation))
                                                <h5>Matriculation</h5>
                                                    <table class="table table-bordered table-sm">
                                                        <tr>
                                                            <td>Matriculation</td>
                                                            <td colspan="3">{{$matriculation->applicantAcademic->applicant_study}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Major</td>
                                                            <td colspan="3">{{ $matriculation->applicantAcademic->applicant_major }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Graduation Year</td>
                                                            <td>{{ $matriculation->applicantAcademic->applicant_year }}</td>
                                                            <td>CGPA</td>
                                                            <td>{{$matriculation->cgpa}}</td>
                                                        </tr>
                                                    </table>
                                                @endif
                                                @if(isset($diploma))
                                                <h5>Diploma</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>University</td>
                                                        <td colspan="3">{{ $diploma->applicantAcademic->applicant_study }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Major</td>
                                                        <td colspan="3">{{ $diploma->applicantAcademic->applicant_major }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Graduation Year</td>
                                                        <td>{{ $diploma->applicantAcademic->applicant_year }}</td>
                                                        <td>CGPA</td>
                                                        <td>{{ $diploma->cgpa }}</td>
                                                    </tr>
                                                    </table>
                                                @endif
                                                @if(isset($degree))
                                                <h5>Degree</h5>
                                                    <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>University</td>
                                                        <td colspan="3">{{$degree->applicantAcademic->applicant_study}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Major</td>
                                                        <td colspan="3">{{ $degree->applicantAcademic->applicant_major }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Graduation Year</td>
                                                        <td>{{ $degree->applicantAcademic->applicant_year }}</td>
                                                        <td>CGPA</td>
                                                        <td>{{$degree->cgpa}}</td>
                                                    </tr>
                                                    </table>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="bucket" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Applicant Bucket Details</div>
                                                        <div class="card-body">
                                                        @if(count($applicantresult) > 0)
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th>Applicant Programme</th>
                                                                <th>Applicant Major</th>
                                                                <th>Result</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            <tr id={{$applicant->id}}>
                                                                <td>
                                                                    <p>{{ $applicant->applicant_programme }}</p>
                                                                    <p>{{ $applicant->applicant_programme_2 }}</p>
                                                                    <p>{{ $applicant->applicant_programme_3 }}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{ $applicant->applicant_major }}</p>
                                                                    <p>{{ $applicant->applicant_major_2 }}</p>
                                                                    <p>{{ $applicant->applicant_major_3 }}</p>
                                                                </td>
                                                                <td>
                                                                    @if($applicant['programme_status']== '1')
                                                                        <p style="color: green">Accepted</p>
                                                                    @else
                                                                        <p style="color: red">Rejected</p>
                                                                    @endif
                                                                    @if($applicant['programme_status_2']== '1')
                                                                        <p style="color: green">Accepted</p>
                                                                    @else
                                                                        <p style="color: red">Rejected</p>
                                                                    @endif
                                                                    @if($applicant['programme_status_3']== '1')
                                                                        <p style="color: green">Accepted</p>
                                                                    @else
                                                                        <p style="color: red">Rejected</p>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @foreach($aapplicant as $aapplicant_all_app)
                                                                    @if($aapplicant_all_app['programme_status'] == '1')
                                                                    <select name="applicant_status" class="form-control" id="status_{{$aapplicant_all_app['applicant_programme']}}">
                                                                        <option disabled selected>Please select</option>
                                                                        <option value="3">Selected</option>
                                                                        <option value="4">Selected for Interview</option>
                                                                    </select>
                                                                    @else
                                                                    <input class="form-control" value="Not Selected" name="applicant_status" disabled>
                                                                    @endif
                                                                    @endforeach
                                                                    @foreach($aapplicant as $aapplicant_all_app)
                                                                    @if($aapplicant_all_app['programme_status_2'] == '1')
                                                                    <select name="applicant_status" class="form-control" id="status_{{$aapplicant_all_app['applicant_programme_2']}}">
                                                                        <option disabled selected>Please select</option>
                                                                        <option value="3">Selected</option>
                                                                        <option value="4">Selected for Interview</option>
                                                                    </select>
                                                                    @else
                                                                    <input class="form-control" value="Not Selected" name="applicant_status" disabled>
                                                                    @endif
                                                                    @endforeach
                                                                    @foreach($aapplicant as $aapplicant_all_app)
                                                                    @if($aapplicant_all_app['programme_status_3'] == '1')
                                                                    <select name="applicant_status_3" class="form-control" id="status_{{$aapplicant_all_app['applicant_programme_3']}}">
                                                                        <option disabled selected>Please select</option>
                                                                        <option value="3">Selected</option>
                                                                        <option value="4">Selected for Interview</option>
                                                                    </select>
                                                                    @else
                                                                    <input class="form-control" value="Not Selected" name="applicant_status" disabled>
                                                                    @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-3">
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
    @foreach($aapplicant as $aapplicant_all_app)
    $(function(){
        $('#status_{{$aapplicant_all_app['applicant_programme']}}').on('change',function(){
            var programme = "{{$aapplicant_all_app['applicant_programme']}}";
            var major = "{{$applicant->applicant_major}}";
            var selectedValue = $(this).val();
            var trid = $(this).closest('tr').attr('id');
            console.log(programme);
            console.log(major);
            console.log(selectedValue);
            console.log(trid);
            $.ajax({
                url: "{{url('/programmestatus')}}",
                method: "post",
                data: { "_token": "{{ csrf_token() }}", applicant_id: trid, applicant_programme: programme, applicant_major: major,applicant_status: selectedValue },
                success: function(response) {
                alert('Data has been updated');
                return response;
                },
                error: function() {
                    alert('error');
                }

            });
        });
        $('#status_{{$aapplicant_all_app['applicant_programme_2']}}').on('change',function(){
            var programme = "{{$aapplicant_all_app['applicant_programme_2']}}";
            var major = "{{$applicant->applicant_major_2}}";
            var selectedValue = $(this).val();
            var trid = $(this).closest('tr').attr('id');
            console.log(programme);
            console.log(major);
            console.log(selectedValue);
            console.log(trid);
            $.ajax({
                url: "{{url('/programmestatus')}}",
                method: "post",
                data: { "_token": "{{ csrf_token() }}", applicant_id: trid, applicant_programme: programme,applicant_major: major,applicant_status: selectedValue },
                success: function(response) {
                alert('Data has been updated');
                return response;
                },
                error: function() {
                    alert('error');
                }

            });
        });
        $('#status_{{$aapplicant_all_app['applicant_programme_3']}}').on('change',function(){
            var programme = "{{$aapplicant_all_app['applicant_programme_3']}}";
            var major = "{{$applicant->applicant_major_3}}";
            var selectedValue = $(this).val();
            var trid = $(this).closest('tr').attr('id');
            console.log(programme);
            console.log(major);
            console.log(selectedValue);
            console.log(trid);
            $.ajax({
                url: "{{url('/programmestatus')}}",
                method: "post",
                data: { "_token": "{{ csrf_token() }}", applicant_id: trid, applicant_programme: programme,applicant_major: major,applicant_status: selectedValue },
                success: function(response) {
                alert('Data has been updated');
                return response;
                },
                error: function() {
                    alert('error');
                }

            });
        });
    });
    @endforeach
</script>


@endsection
