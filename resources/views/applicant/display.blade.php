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
                                    <a data-toggle="tab" class="nav-link" href="#qualification" role="tab">Qualification</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#academic" role="tab">Personal Information</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-12">
                                    <div class="tab-pane active" id="details" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <div class="card">
                                                    <div class="card-header">Applicant</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                {{Form::label('title', 'Name')}}
                                                                {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'readonly' => 'true'])}}
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                {{ Form::label('title', 'IC Number') }}
                                                                {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number', 'readonly' => 'true']) }}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{ Form::label('title', 'Email') }}
                                                                {{ Form::text('applicant_email', $applicant->applicant_email, ['class' => 'form-control', 'readonly' => 'true']) }}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{ Form::label('title', 'Phone Number') }}
                                                                {{ Form::text('applicant_phone', $applicant->applicant_phone, ['class' => 'form-control', 'readonly' => 'true']) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-3">
                                                <div class="card">
                                                    <div class="card-header">Offer Program</div>
                                                        <div class="card-body">
                                                        @if(isset($applicant->applicant_name) )
                                                        {{-- @if(count($applicantresult) > 0) --}}
                                                        {{-- <table class="table table-sm">
                                                            <tr id={{ $applicant->id }}>
                                                                <td>Intake Sessions</td>
                                                                <td>
                                                                    <select name="applicant_intake" class="form-control" id="intake_1">
                                                                        <option value="{{ $applicant->intake_id }}">{{ $applicant->applicantIntake->intake_code }}</option>
                                                                        @foreach ($intake as $in)
                                                                            <option value="{{ $in->id }}">{{ $in->intake_code }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr id="{{ $applicant->id }}">
                                                                <td>Applicant Status</td>
                                                                <td>
                                                                    <select class="form-control" id="app_stat" name="app_stat">
                                                                        <option disabled selected>Please select</option>
                                                                        <option value="">Register</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        </table> --}}
                                                        {!! Form::open(['action' => ['ApplicantController@intakestatus'], 'method' => 'POST'])!!}
                                                            <div class="row">
                                                                <div class="col-md-5 form-group">
                                                                    <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                                                    {{ Form::label('title', 'Intake Session') }}
                                                                    <select name="intake_id" class="form-control" id="intake_id">
                                                                        <option value="{{ $applicant->intake_id }}">{{ $applicant->applicantIntake->intake_code }}</option>
                                                                        @foreach ($intake as $in)
                                                                            <option value="{{ $in->id }}">{{ $in->intake_code }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    {{ Form::label('title', 'Applicant Status') }}
                                                                    <select class="form-control" id="applicant_status" name="applicant_status">
                                                                        @foreach ($applicant_status as $app_stat)
                                                                            <option value="{{ $app_stat->status_code }}" {{ $applicant->applicant_status == $app_stat->status_code ? 'selected="selected"' : ''}}>{{ $app_stat->status_description }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2"><button class="btn btn-primary mt-4">Submit</button></div>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="bg-highlight">
                                                                <th>Applicant Programme</th>
                                                                <th>Applicant Major</th>
                                                                <th>Batch Code</th>
                                                                <th>Result</th>
                                                                <th>Action</th>
                                                            </thead>
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
                                                                    <p>{{ isset($batch_1->batch_code) ? $batch_1->batch_code : '' }}</p>
                                                                    <p>{{ isset($batch_2->batch_code) ? $batch_2->batch_code : '' }}</p>
                                                                    <p>{{ isset($batch_3->batch_code) ? $batch_3->batch_code : '' }}</p>
                                                                </td>
                                                                <td>
                                                                    @if($applicant['programme_status']== '1')
                                                                        <p style="color: green">Qualified</p>
                                                                    @endif
                                                                    @if($applicant['programme_status']== '2')
                                                                        <p style="color: red">Not Qualified</p>
                                                                    @endif
                                                                    @if($applicant['programme_status_2']== '1')
                                                                        <p style="color: green">Qualified</p>
                                                                    @endif
                                                                    @if($applicant['programme_status_2']== '2')
                                                                        <p style="color: red">Not Qualified</p>
                                                                    @endif
                                                                    @if($applicant['programme_status_3']== '1')
                                                                        <p style="color: green">Qualified</p>
                                                                    @endif
                                                                    @if($applicant['programme_status_3']== '2')
                                                                        <p style="color: red">Not Qualified</p>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @foreach($aapplicant as $aapplicant_all_app)
                                                                    @if($aapplicant_all_app['programme_status'] == '1')
                                                                    <select name="applicant_status" class="form-control" id="status_{{ $aapplicant_all_app['applicant_programme'] }}">
                                                                        @if (isset($applicant->applicant_status))
                                                                            <option value="{{ $applicant->applicant_status }}">{{ $applicant->status->status_description }}</option>
                                                                            <option value="3">Selected</option>
                                                                            <option value="4">Selected for Interview</option>
                                                                        @else
                                                                            <option disabled selected>Please Select</option>
                                                                            <option value="3">Selected</option>
                                                                            <option value="4">Selected for Interview</option>
                                                                        @endif
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
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-3">
                                        <div class="card">
                                            <div class="card-header">Minimum Qualification</div>
                                            <div class="card-body">
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IAT12') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IAT12') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IAT12'))
                                                    <p>American Degree Transfer Programme</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IAL10') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IAL10') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IAL10'))
                                                    <p>A Level Programme</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IGR22') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IGR22') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IGR22'))
                                                    <p>A Level German Programme</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IAM11') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IAM11') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IAM11'))
                                                    <p>SACE International</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'ILE12') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'ILE12') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'ILE12'))
                                                    <p>Japanese Preparatory Course</p>
                                                    <ol>
                                                        <li>Science: Minimum credit in 5 subjects including Mathematics <b>OR</b> any science subject in SPM / GCE O-Level or equivalent <b>OR</b></li>
                                                        <li>Non-Science: Minimum credit in 5 subjects including Mathematics in SPM / GCE O-Level or equivalent</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IKR09') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IKR09') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IKR09'))
                                                    <p>Korean Preparatory Course</p>
                                                    <ul>
                                                        <li>Open (Minimum ability and knowledge in English)</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IBM20') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IBM20') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IBM20'))
                                                    <p>Diploma in Business Management</p>
                                                    <ol>
                                                        <li>Obtain a minimum of 3 credits in Sijil Pelajaran Malaysia (SPM) <b>OR</b></li>
                                                        <li>Pass STPM or equivalent with a minimum of Grade C (CGPA 2.0) in ONE subject <b>OR</b></li>
                                                        <li>Pass STAM with a minimum of Maqbul Grade <b>OR</b></li>
                                                        <li>Pass UEC with a minimum of Grade B in 3 subjects <b>OR</b></li>
                                                        <li>Pass O-level with a minimum of Grade C in 3 subjects <b>OR</b></li>
                                                        <li>Pass SKM Level 3 in related field with a minimum credit of 1 subject in SPM <b>OR</b></li>
                                                        <li>Pass Community College Certificate which is equivalent with MQF level 3 in related field with minimum ONE credit in SPM <b>OR</b></li>
                                                        <li>Pass certificate (MQF Level 3) in a related field with at least CGPA 2.00</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IPG20') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IPG20') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IPG20'))
                                                    <p>Diploma in Public Management and Governance</p>
                                                    <ol>
                                                        <li>Obtain a minimum of 3 credits in Sijil Pelajaran Malaysia (SPM) <b>OR</b></li>
                                                        <li>Pass STPM or equivalent with at least a Grade C (CGPA 2.0) in any subjects <b>OR</b></li>
                                                        <li>Pass STAM with a minimum of Maqbul Grade <b>OR</b></li>
                                                        <li>Pass UEC with minimum of Grade B in 3 subjects <b>OR</b></li>
                                                        <li>Pass O-level with a minimum of Grade C in 3 subjects <b>OR</b></li>
                                                        <li>Pass SKM Level 3 in related field with a minimum credit of 1 subject in SPM <b>AND</b> through reinforcement programme (if required)<b>OR</b></li>
                                                        <li>Pass Community College Certificate which is equivalent with MQF level 3 in related field with minimum ONE credit in SPM <b>OR</b></li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IHP20') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IHP20') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IHP20'))
                                                    <p>Diploma in Scientific Halal and Practice</p>
                                                    <ol>
                                                        <li>Sijil Pelajaran Malaysia (SPM)</li>
                                                        <ul>
                                                            <li>Science stream: obtain three (3) credits in Chemistry, Biology and Islamic Studies or Syariah <b>OR</b></li>
                                                            <li>Non-science stream: obtain minimum B+ in science, AND three (3) credits in Islamic Studies or Syariah and one other subjects</li>
                                                            <li><b>AND</b>must pass Bahasa Melayu. Sejarah, Bahasa Inggeris and Mathematics <b>OR</b></li>                                                            </li>
                                                        </ul>
                                                        <li>Sijil Tinggi Pelajaran Malaysia (STPM): Pass with minimum C (NGMP 2.0) in Biology and Chemistry; AND pass Bahasa Inggeris and Mathematics <b>OR</b></li>
                                                        <li>Pass O-level/IGCSE with a minimum of Grade C in 3 subjects including Biology, Chemistry or science, AND pass English and Mathematics <b>OR</b></li>
                                                        <li>South Australian Certificate of Education (SACE) with minimum ATAR 50 <b>OR</b></li>
                                                        <li>A-Level: Pass with minimum C in three (3) subjects including Biology and Chemistry</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IAC20') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IAC20') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IAC20'))
                                                    <p>Diploma in Accounting</p>
                                                    <ol>
                                                        <li>Pass Sijil Pelajaran Malaysia (SPM) or equivalent, with at least three credits, including Mathematics and pass English <b>OR</b></li>
                                                        <li>Pass Sijil Tinggi Pelajaran Malaysia (STPM) or equivalent, with at least Grade C (CGPA 2.0) in any subjects, and credit in Mathematics and pass English in SPM level <b>OR</b></li>
                                                        <li>Pass Sijil Tinggi Agama Malaysia (STAM) with minimum of Maqbul Grade and credit in Mathematics and pass English in SPM level <b>OR</b></li>
                                                        <li>Pass Sijil Kemahiran Malaysia (SKM) Level 3 in related field and pass SPM with minimum one credit in any subject, credit in Mathematics and pass English in SPM level <b>OR</b></li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'IIF20') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'IIF20') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'IIF20'))
                                                    <p>Diploma in Islamic Finance</p>
                                                    <ol>
                                                        <li>Pass Sijil Pelajaran Malaysia (SPM) with at least credit in three subjects and pass Mathematics <b>OR</b></li>
                                                        <li>Pass Sijil Tinggi Pelajaran Malaysia (STPM) or equivalent with at least Grade C (CGPA 2.00) in one subject AND pass Mathematics at SPM level (or equivalent) or at STPM <b>OR</b></li>
                                                        <li>Pass Sijil Tinggi Agama Malaysia (STAM)(Maqbul Grade) <b>AND</b> pass Mathematics at SPM level (or equivalent) <b>OR</b></li>
                                                        <li>Pass UEC (Unified Examination Certificate) with a minimum of Grade B in three subjects ans pass Mathematics <b>OR</b></li>
                                                        <li>Pass O-Level with a minimum of Grade C in three subjects and pass Mathematics <b>OR</b></li>
                                                        <li>Pass Sijil Kemahiran Malaysia (SKM) Level 3 in related field AND pass SPM with a minimum credit for one subject and pass Mathematics at SPM level <b>OR</b></li>
                                                        <li>Pass Comunity College Certificate which is equivalent to KKM Level 3 in related field <b>AND</b> pass SPM with a minimum credit for one subject and <b>PASS</b> Mathematics at SPM level</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC150') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC150') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC150'))
                                                    <p>Certified Accounting Technician</p>
                                                    <ol>
                                                        <li>Pass Sijil Pelajaran Malaysia (SPM) with at least five credits including Bahasa Malaysia, Mathematics and English <b>OR</b></li>
                                                        <li>Other qualifications with equivalent recognition by the Malaysian Government.</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC170') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC170') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC170'))
                                                    <p>Certified in Finance, Accounting & Business (CFAB)</p>
                                                    <ol>
                                                        <li>Pass Sijil Pelajaran Malaysia (SPM) with at least creditfive credits including Bahasa Malaysia, Mathematics and English <b>OR</b></li>
                                                        <li>Other qualifications with equivalent recognition by the Malaysian Government.</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC580') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC580') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC580'))
                                                    <p>The Malaysian Institute of Certified Public Accountants (MICPA)</p>
                                                    <ol>
                                                        <li>Degree holder with CGPA of at least 3.00; 5.0 (New Zealand); 4.0 (Australia)</li>
                                                        <li>Degree must be from universities which are accredited by MICPA in order to obtain full exemption</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC551') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC551') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC551'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from Diploma</p>
                                                    <ul>
                                                        <li>Diploma in Accountancy (Level 4, KKM) with minimum CGPA of 3.00</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC552') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC552') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC552'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from CAT</p>
                                                    <ul>
                                                        <li>Pass Certified Accounting Technician (CAT)</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC553') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC553') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC553'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from CAT</p>
                                                    <ul>
                                                        <li>Bachelor of Accountancy or with related fields with CGPA of at least 2.50</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC554') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC554') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC554'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from CAT</p>
                                                    <ul>
                                                        <li>Bachelor of Accountancy or with related fields with CGPA of at least 2.50</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->programme_status == '2' && $applicant->applicant_programme == 'PAC570') || ( $applicant->programme_status_2 == '2' && $applicant->applicant_programme_2 == 'PAC570') || ($applicant->programme_status_3 == '2' && $applicant->applicant_programme_3 == 'PAC570'))
                                                    <p>The Association of Chartered Certified Accountants (ACA) for Institute of Chartered Accountants in England and Wales (ICAEW)</p>
                                                    <ol>
                                                        <li>Pass ICAEW Certificate in Finance, Accounting, and Business (ICAEW CFAB) <b>OR</b></li>
                                                        <li>Pass Bachelor of Accountancy (Level 6, KKM) with CGPA of at least 2.75</li>
                                                    </ol>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="qualification" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">Applicant Academic</div>
                                            <div class="card-body">
                                            @if(count($spm)!=0)
                                            <h5>SPM</h5>
                                            {!! isset($spm->first()->file->web_path) ? '<a href="' .  storage_path($spm->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-highlight">
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Grade</th>
                                                </thead>
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
                                            {!! isset($stpm->first()->file->web_path) ? '<a href="' . url($stpm->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-highlight">
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Grade</th>
                                                </thead>
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
                                            {!! isset($stam->first()->file->web_path) ? '<a href="' . url($stam->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-highlight">
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Grade</th>
                                                </thead>
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
                                            {!! isset($uec->first()->file->web_path) ? '<a href="' . url($uec->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-highlight">
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Grade</th>
                                                </thead>
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
                                            {!! isset($alevel->first()->file->web_path) ? '<a href="' . url($alevel->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-highlight">
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Grade</th>
                                                </thead>
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
                                            {!! isset($olevel->first()->file->web_path) ? '<a href="' . url($olevel->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-highlight">
                                                    <th>Subject Code</th>
                                                    <th>Subject Name</th>
                                                    <th>Grade</th>
                                                </thead>
                                                @foreach($olevel as $olevels)
                                                    <tr>
                                                        <td>{{$olevels->subjects->first()->subject_code}}</td>
                                                        <td>{{$olevels->subjects->first()->subject_name}}</td>
                                                        <td>{{$olevels->grades->grade_code}}</td>
                                                    </tr>
                                                @endforeach
                                                </table>
                                            @endif
                                            @if(isset($muet))
                                            <h5>MUET</h5>
                                            {!! isset($muet->first()->file->web_path) ? '<a href="' . url($muet->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>Band</td>
                                                    <td>{{ $muet->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if(isset($matriculation))
                                            <h5>Matriculation</h5>
                                            {!! isset($matriculation->first()->file->web_path) ? '<a href="' . url($matriculation->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                    <tr>
                                                        <td>Matriculation</td>
                                                        <td colspan="3">{{ $matriculation->applicant_study }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Graduation Year</td>
                                                        <td>{{ $matriculation->applicant_year }}</td>
                                                        <td>CGPA</td>
                                                        <td>{{ $matriculation->applicant_cgpa }}</td>
                                                    </tr>
                                                </table>
                                            @endif
                                            @if (isset($foundation))
                                            <h5>Foundation</h5>
                                            {!! isset($foundation->first()->file->web_path) ? '<a href="' . url($foundation->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>Foundation</td>
                                                    <td colspan="3">{{ $foundation->applicant_study }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Major</td>
                                                    <td colspan="3">{{ $foundation->applicant_major }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Graduation Year</td>
                                                    <td>{{ $foundation->applicant_year }}</td>
                                                    <td>CGPA</td>
                                                    <td>{{ $foundation->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if(isset($diploma))
                                            <h5>Diploma</h5>
                                            {!! isset($diploma->first()->file->web_path) ? '<a href="' . url($diploma->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>University</td>
                                                    <td colspan="3">{{ $diploma->applicant_study }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Major</td>
                                                    <td colspan="3">{{ $diploma->applicant_major }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Graduation Year</td>
                                                    <td>{{ $diploma->applicant_year }}</td>
                                                    <td>CGPA</td>
                                                    <td>{{ $diploma->applicant_cgpa }}</td>
                                                </tr>
                                                </table>
                                            @endif
                                            @if(isset($degree))
                                            <h5>Degree</h5>
                                            {!! isset($degree->first()->file->web_path) ? '<a href="' . url($degree->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                                <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>University</td>
                                                    <td colspan="3">{{ $degree->applicant_study }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Major</td>
                                                    <td colspan="3">{{ $degree->applicant_major }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Graduation Year</td>
                                                    <td>{{ $degree->applicant_year }}</td>
                                                    <td>CGPA</td>
                                                    <td>{{ $degree->applicant_cgpa }}</td>
                                                </tr>
                                                </table>
                                            @endif
                                            @if (isset($skm))
                                            <h5>Sijil Kemahiran Malaysia</h5>
                                            {!! isset($skm->first()->file->web_path) ? '<a href="' . url($skm->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>SKM Level</td>
                                                    <td>{{ $skm->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($sace))
                                            <h5>South Australian Certificate of Education</h5>
                                            {!! isset($sace->first()->file->web_path) ? '<a href="' . url($sace->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>ATAR</td>
                                                    <td>{{ $sace->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($mqf))
                                            <h5>MQF</h5>
                                            {!! isset($mqf->first()->file->web_path) ? '<a href="' . url($mqf->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>MQF Level</td>
                                                    <td>{{ $mqf->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($kkm))
                                            <h5>Kolej Komuniti Malaysia</h5>
                                            {!! isset($kkm->first()->file->web_path) ? '<a href="' . url($kkm->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>KKM Level</td>
                                                    <td>{{ $kkm->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($cat))
                                            <h5>Certified Accounting Technician</h5>
                                            {!! isset($cat->first()->file->web_path) ? '<a href="' . url($cat->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>CAT</td>
                                                    <td>{{ $cat->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($icaew))
                                            <h5>ICAEW</h5>
                                            {!! isset($icaew->first()->file->web_path) ? '<a href="' . url($icaew->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!}
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>ICAEW</td>
                                                    <td>{{ $icaew->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                    <div class="tab-pane" id="academic" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-12 grid-margin stretch-card">
                                                <hr class="mt-2 mb-3">
                                                <div class="card">
                                                    <div class="card-header">Personal Profile</div>
                                                        <div class="card-body">
                                                        {!! Form::open(['action' => ['ApplicantController@updateApplicant'], 'method' => 'POST'])!!}
                                                        {{Form::hidden('id', $applicant->id)}}
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                {{Form::label('title', 'Name')}}
                                                                {{Form::text('applicant_name', $applicant->applicant_name, ['class' => 'form-control', 'placeholder' => 'Applicant Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                {{ Form::label('title', 'IC Number') }}
                                                                {{ Form::text('applicant_ic', $applicant->applicant_ic, ['class' => 'form-control', 'placeholder' => 'Applicant IC Number']) }}
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                {{ Form::label('title', 'Birth Date') }}
                                                                {{ Form::date('applicant_dob', $applicant->applicant_dob, ['class' => 'form-control', 'placeholder' => 'Applicant Date of Birth']) }}
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                {{ Form::label('title', 'Phone Number') }}
                                                                {{ Form::text('applicant_phone', $applicant->applicant_phone, ['class' => 'form-control' , 'placeholder' => 'Applicant Phone']) }}
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                {{ Form::label('title', 'Email') }}
                                                                {{ Form::email('applicant_email', $applicant->applicant_email, ['class' => 'form-control', 'placeholder' => 'Applicant Email']) }}
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                {{ Form::label('title', 'Gender') }}
                                                                <select class="form-control gender" name="applicant_gender" id="applicant_gender" >
                                                                    @foreach($gender as $genders)
                                                                        <option value="{{$genders->gender_code}}"  {{ $applicant->applicant_gender == $genders->gender_code ? 'selected="selected"' : '' }}>{{$genders->gender_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                {{ Form::label('title', 'Marital') }}
                                                                <select class="form-control marital" name="applicant_marital" id="applicant_marital">
                                                                    @foreach($marital as $maritals)
                                                                        <option value="{{ $maritals->marital_code }}" {{ $applicant->applicant_marital == $maritals->marital_code ? 'selected="selected"' : ''}}>{{ $maritals->marital_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                {{ Form::label('title', 'Race') }}
                                                                <select class="form-control race" name="applicant_race" id="applicant_race">
                                                                    @foreach ($race as $races)
                                                                        <option value="{{ $races->race_code }}" {{ $applicant->applicant_race == $races->race_code ? 'selected="Selected"' : ''}}>{{ $races->race_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                {{ Form::label('title', 'Religion') }}
                                                                <select class="form-control religion" name="applicant_religion" id="applicant_religion">
                                                                    @foreach ($religion as $religions)
                                                                        <option value="{{ $religions->religion_code }}" {{ $applicant->applicant_religion == $religions->religion_code ? 'selected="selected"' : ''}}>{{ $religions->religion_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                {{ Form::label('title', 'Nationality') }}
                                                                <select class="form-control country" name="applicant_nationality" id="applicant_nationality" >
                                                                    @foreach($country as $countries)
                                                                        <option value="{{$countries->country_code}}"  {{ $applicant->applicant_nationality == $countries->country_code ? 'selected="selected"' : '' }}>{{$countries->country_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @if(isset($applicant->applicantContactInfo))
                                                            <div class="col-md-12 form-group">
                                                                {{ Form::label('title', 'Address') }}
                                                                {{ Form::text('applicant_address_1', $applicant->applicantContactInfo->applicant_address_1, ['class' => 'form-control', 'placeholder' => 'Address 1', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}<br>
                                                                {{ Form::text('applicant_address_2', $applicant->applicantContactInfo->applicant_address_2, ['class' => 'form-control', 'placeholder' => 'Address 2', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                {{ Form::label('title', 'Postcode') }}
                                                                {{ Form::text('applicant_poscode', $applicant->applicantContactInfo->applicant_poscode, ['class' => 'form-control', 'placeholder' => 'Postcode', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                {{ Form::label('title', 'City') }}
                                                                {{ Form::text('applicant_city', $applicant->applicantContactInfo->applicant_city, ['class' => 'form-control', 'placeholder' => 'Applicant City', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                {{ Form::label('title', 'State') }}
                                                                {{ Form::text('applicant_state', $applicant->applicantContactInfo->applicant_state, ['class' => 'form-control', 'placeholder' => 'State', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                {{ Form::label('title', 'Country') }}
                                                                <select class="form-control country" name="applicant_country" id="applicant_country" >
                                                                    @foreach($country as $countries)
                                                                        <option value="{{$countries->country_code}}"  {{ $applicant->applicantContactInfo->applicant_country == $countries->country_code ? 'selected="selected"' : '' }}>{{$countries->country_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        @can('update applicant detail')
                                                        <button class="btn btn-primary">Update</button>
                                                        {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-3">
                                                <div class="card">
                                                    <div class="card-header">Parent Information</div>
                                                    <div class="card-body">
                                                        @if(isset($applicant->applicantGuardian))
                                                        {!! Form::open(['action' => ['ApplicantController@updateGuardian'], 'method' => 'POST'])!!}
                                                        {{Form::hidden('id', $applicant->id)}}
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                {{Form::label('title', 'Name(Father / Guardian I)')}}
                                                                {{Form::text('guardian_one_name', $applicant->applicantGuardian->guardian_one_name, ['class' => 'form-control', 'placeholder' => 'Guardian Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{ Form::label('title', 'Relationship') }}
                                                                <select class="form-control relation" name="guardian_one_relationship" id="guardian_one_relationship">
                                                                    @foreach($family as $families)
                                                                        <option value="{{ $families->family_code }}" {{ $applicant->applicantGuardian->guardian_one_relationship == $families->family_code ? 'selected="selected"' : '' }}>{{ $families->family_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{Form::label('title', 'Mobile Phone')}}
                                                                {{Form::text('guardian_one_mobile', $applicant->applicantGuardian->guardian_one_mobile, ['class' => 'form-control', 'placeholder' => 'Mobile'])}}
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                {{Form::label('title', 'Address')}}
                                                                {{Form::text('guardian_one_address', $applicant->applicantGuardian->guardian_one_address, ['class' => 'form-control', 'placeholder' => 'Address', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                            </div>
                                                        </div>
                                                        <div class="row mt-5">
                                                            <div class="form-group col-md-12">
                                                                {{Form::label('title', 'Name(Mother / Guardian II)')}}
                                                                {{Form::text('guardian_two_name', $applicant->applicantGuardian->guardian_two_name, ['class' => 'form-control', 'placeholder' => 'Guardian Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{ Form::label('title', 'Relationship') }}
                                                            <select class="form-control relation" name="guardian_two_relationship" id="guardian_two_relationship">
                                                                @foreach($family as $families)
                                                                    <option value="{{ $families->family_code }}" {{ $applicant->applicantGuardian->guardian_two_relationship == $families->family_code ? 'selected="selected"' : '' }}>{{ $families->family_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{Form::label('title', 'Mobile Phone')}}
                                                                {{Form::text('guardian_two_mobile', $applicant->applicantGuardian->guardian_two_mobile, ['class' => 'form-control', 'placeholder' => 'Mobile'])}}
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                {{Form::label('title', 'Address')}}
                                                                {{Form::text('guardian_two_address', $applicant->applicantGuardian->guardian_two_address, ['class' => 'form-control', 'placeholder' => 'Address', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                            </div>
                                                        </div>
                                                        @can('update applicant detail')
                                                        <button class="btn btn-primary">Update</button>
                                                        @endcan
                                                        {!! Form::close() !!}
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-3">
                                                <div class="card">
                                                    <div class="card-header">Emergency Contact</div>
                                                    <div class="card-body">
                                                        @if(isset($applicant->applicantEmergency))
                                                        {!! Form::open(['action' => ['ApplicantController@updateEmergency'], 'method' => 'POST'])!!}
                                                        <div class="row">
                                                            {{Form::hidden('id', $applicant->id)}}
                                                            <div class="form-group col-md-12">
                                                                {{Form::label('title', 'Name')}}
                                                                {{Form::text('emergency_name', $applicant->applicantEmergency->emergency_name, ['class' => 'form-control', 'placeholder' => 'Name', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{ Form::label('title', 'Relationship') }}
                                                                <select class="form-control relation" name="emergency_relationship" id="emergency_relationship">
                                                                    @foreach ($family as $families)
                                                                        <option value="{{ $families->family_code }}" {{ $applicant->applicantEmergency->emergency_relationship == $families->family_code ? 'selected="selected"' : '' }}>{{ $families->family_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                {{Form::label('title', 'Emergency Phone Number')}}
                                                                {{Form::text('emergency_phone', $applicant->applicantEmergency->emergency_phone, ['class' => 'form-control', 'placeholder' => 'Emergency Number'])}}
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                {{Form::label('title', 'Address')}}
                                                                {{Form::text('emergency_address', $applicant->applicantEmergency->emergency_address, ['class' => 'form-control', 'placeholder' => 'Address', 'onkeyup' => 'this.value = this.value.toUpperCase()'])}}
                                                            </div>
                                                        </div>
                                                        @can('update applicant detail')
                                                        <button class="btn btn-primary">Update</button>
                                                        @endcan
                                                        {!! Form::close() !!}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            {{-- <div class="tab-content col-md-4 mt-4">
                                <div class="card">
                                    <div class="card-header">Activity Log</div>
                                    <div class="card-body">
                                        @if (isset($activity))
                                        <table class="table table-bordered">
                                            <tr class="bg-highlight">
                                                <td>Date</td>
                                                <td>Activity</td>
                                            </tr>
                                            @foreach ($activity as $activities)
                                            <tr>
                                                <td>{{ $activities->created_at }}</td>
                                                <td>{{ $activities->description }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.country, .gender, .marital, .race, .religion, .relation').select2();
    });
    @foreach($aapplicant as $aapplicant_all_app)
    $(function(){
        $('#status_{{$aapplicant_all_app['applicant_programme']}}').on('change',function(){
            var programme = "{{$aapplicant_all_app['applicant_programme']}}";
            var major = "{{$applicant->applicant_major}}";
            var batch = "{{ isset($batch_1->batch_code) ? $batch_1->batch_code : '' }}";
            var selectedValue = $(this).val();
            var trid = $(this).closest('tr').attr('id');
            console.log(programme);
            console.log(major);
            console.log(selectedValue);
            console.log(trid);
            $.ajax({
                url: "{{url('/programmestatus')}}",
                method: "post",
                data: { "_token": "{{ csrf_token() }}", applicant_id: trid, applicant_programme: programme, applicant_major: major, batch_code: batch, applicant_status: selectedValue },
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
            var batch = "{{ isset($batch_2->batch_code) ? $batch_2->batch_code : '' }}";
            var selectedValue = $(this).val();
            var trid = $(this).closest('tr').attr('id');
            console.log(programme);
            console.log(major);
            console.log(selectedValue);
            console.log(trid);
            $.ajax({
                url: "{{url('/programmestatus')}}",
                method: "post",
                data: { "_token": "{{ csrf_token() }}", applicant_id: trid, applicant_programme: programme,applicant_major: major, batch_code: batch, applicant_status: selectedValue },
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
            var batch = "{{ isset($batch_3->batch_code) ? $batch_3->batch_code : '' }}";
            var selectedValue = $(this).val();
            var trid = $(this).closest('tr').attr('id');
            console.log(programme);
            console.log(major);
            console.log(selectedValue);
            console.log(trid);
            $.ajax({
                url: "{{url('/programmestatus')}}",
                method: "post",
                data: { "_token": "{{ csrf_token() }}", applicant_id: trid, applicant_programme: programme,applicant_major: major, batch_code: batch, applicant_status: selectedValue },
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
