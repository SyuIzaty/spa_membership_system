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
                                                    @if(count($applicantresult) > 0)
                                                    <table class="table table-bordered table-sm">
                                                        <tr>
                                                            <th>Applied Programme</th>
                                                            <th>Major</th>
                                                            <th>Result</th>
                                                            <th>Reason</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @foreach($aapplicant as $aapplicant_all_app)
                                                                    @foreach($aapplicant_all_app['programme_1'] as $etc)
                                                                    <p>{{$etc['programme_name']}}</p>
                                                                    @endforeach
                                                                    @foreach($aapplicant_all_app['programme_2'] as $etc)
                                                                    <p>{{$etc['programme_name']}}</p>
                                                                    @endforeach
                                                                    @foreach($aapplicant_all_app['programme_3'] as $etc)
                                                                    <p>{{$etc['programme_name']}}</p>
                                                                    @endforeach
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <p>{{ $applicant->applicant_major }}</p><br>
                                                                <p>{{ $applicant->applicant_major_2 }}</p><br>
                                                                <p>{{ $applicant->applicant_major_3 }}</p>
                                                            </td>
                                                            <td>
                                                                @if($aapplicant_all_app['programme_status']== '1')
                                                                    <p style="color:green">Accepted</p>
                                                                @else
                                                                    <p style="color: red">Rejected</p>
                                                                @endif
                                                                @if($aapplicant_all_app['programme_status_2']== '1')
                                                                    <p style="color: green">Accepted</p>
                                                                @else
                                                                    <p style="color: red">Rejected</p>
                                                                @endif
                                                                @if($aapplicant_all_app['programme_status_3']== '1')
                                                                    <p style="color: green">Accepted</p>
                                                                @else
                                                                    <p style="color: red">Rejected</p>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <p>{{$applicant->reason_fail}}</p><br>
                                                                <p>{{$applicant->reason_fail_2}}</p><br>
                                                                <p>{{$applicant->reason_fail_3}}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr class="mt-2 mb-3">
                                        </div>
                                        <div class="col-md-12 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-header">Personal Profile</div>
                                                    <div class="card-body">
                                                    <table class="table table-bordered table-sm">
                                                        <tr>
                                                            <td>Full Name</td>
                                                            <td>{{$applicant->applicant_name}}</td>
                                                            <td>IC Number</td>
                                                            <td>{{$applicant->applicant_ic}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>{{$applicant->applicant_email}}</td>
                                                            <td>Mobile No</td>
                                                            <td>{{$applicant->applicant_phone}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nationality</td>
                                                            <td>{{$applicant->applicant_nationality}}</td>
                                                            <td>Gender</td>
                                                            <td>{{$applicant->applicant_gender}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Marital Status</td>
                                                            <td>{{$applicant->applicant_marital}}</td>
                                                            <td>Date of Birth</td>
                                                            <td>{{$applicant->dob}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Religion</td>
                                                            <td>{{$applicant->applicant_religion}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-3">
                                    <div class="card">
                                        <div class="card-header">Parent Information</div>
                                        <div class="card-body">
                                            @if(isset($applicant_guardian))
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>Name (Father / Guardian I)</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_one_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Relationship</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_one_relationship}}</td>
                                                </tr>
                                                <tr>
                                                    <td>IC/passport</td>
                                                    <td>{{$applicant_guardian->guardian_one_ic}}</td>
                                                    <td>Nationality</td>
                                                    <td>{{$applicant_guardian->guardian_one_nationality}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mobile Phone</td>
                                                    <td>{{$applicant_guardian->guardian_one_mobile}}</td>
                                                    <td>Email</td>
                                                    <td>{{$applicant_guardian->guardian_one_email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_one_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Occupation</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_one_occupation}}</td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>Name (Mother / Guardian I)</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_two_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Relationship</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_two_relationship}}</td>
                                                </tr>
                                                <tr>
                                                    <td>IC/passport</td>
                                                    <td>{{$applicant_guardian->guardian_two_ic}}</td>
                                                    <td>Nationality</td>
                                                    <td>{{$applicant_guardian->guardian_two_nationality}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mobile Phone</td>
                                                    <td>{{$applicant_guardian->guardian_two_mobile}}</td>
                                                    <td>Email</td>
                                                    <td>{{$applicant_guardian->guardian_two_email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_two_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Occupation</td>
                                                    <td colspan="3">{{$applicant_guardian->guardian_two_occupation}}</td>
                                                </tr>
                                            </table>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-3">
                                    <div class="card">
                                        <div class="card-header">Emergency Contact</div>
                                        <div class="card-body">
                                            @if(isset($applicant_emergency))
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>Name</td>
                                                    <td colspan="3">{{$applicant_emergency->emergency_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Relationship</td>
                                                    <td colspan="3">{{$applicant_emergency->emergency_relationship}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mobile Phone</td>
                                                    <td>{{$applicant_emergency->emergency_phone}}</td>
                                                    <td>Email</td>
                                                    <td>{{$applicant_emergency->emergency_email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Address</td>
                                                    <td colspan="3">{{$applicant_emergency->emergency_address}}</td>
                                                </tr>
                                            </table>
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
                                                                    @if($aapplicant_all_app['programme_status']== '1')
                                                                        <p style="color: green">Accepted</p>
                                                                    @else
                                                                        <p style="color: red">Rejected</p>
                                                                    @endif
                                                                    @if($aapplicant_all_app['programme_status_2']== '1')
                                                                        <p style="color: green">Accepted</p>
                                                                    @else
                                                                        <p style="color: red">Rejected</p>
                                                                    @endif
                                                                    @if($aapplicant_all_app['programme_status_3']== '1')
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
