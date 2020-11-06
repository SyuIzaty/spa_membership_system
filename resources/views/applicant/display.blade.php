@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> @isset($applicant->status)
                    {{ $applicant->status->status_description }}
                @endisset
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            @isset($applicant->status)
                                {{ $applicant->status->status_description }}
                            @endisset
                        </h2>
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
                                @if ($applicant->programme_status == '3G' && $applicant->programme_status_2 == '3G' && $applicant->programme_status_3 == '3G')
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#individual" role="tab">Requirement Check</a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#qualification" role="tab">Qualification</a>
                                </li>
                                <li class="nav-item">
                                    <a data-toggle="tab" class="nav-link" href="#academic" role="tab">Personal Information</a>
                                </li>
                            </ul>
                            <div class="row">
                                <div class="tab-content col-md-8">
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
                                                    @if ( isset($applicant->applicant_programme) )
                                                        <div class="card-header">Program Selection</div>
                                                        <div class="card-body">
                                                        @if(session()->has('message'))
                                                        <div class="alert alert-success">
                                                            {{ session()->get('message') }}
                                                        </div>
                                                        @endif
                                                            <table class="table table-bordered table-sm">
                                                                <tr class="bg-primary-50 text-center">
                                                                    <td>Programme</td>
                                                                    <td>Major</td>
                                                                    <td>Study Mode</td>
                                                                    <td>Result</td>
                                                                    <td>Highest <br> Qualification</td>
                                                                    <td>Action</td>
                                                                </tr>
                                                                {!! Form::open(['action' => ['ApplicantController@applicantstatus'], 'method' => 'POST'])!!}
                                                                <tr>
                                                                    <input type="hidden" name="id" value="{{ $applicant->id }}">
                                                                    <input type="hidden" name="batch_code" value="{{ isset($batch_1->first()->batch_code) ? $batch_1->first()->batch_code : '' }}">
                                                                    <td>{{ Form::text('applicant_programme', $applicant->applicant_programme, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ Form::text('applicant_major', $applicant->applicant_major, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ Form::text('applicant_mode', $applicant->applicant_mode, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ isset($applicant->programme_status) ? $applicant->programmeStatus->status_description : '' }}</td>
                                                                    <td>
                                                                        <select class="form-control" name="applicant_qualification" id="qua1">
                                                                            <option disabled selected>Please select</option>
                                                                            @foreach ($qualification as $app_qualification)
                                                                            <option value="{{ $app_qualification->id }}" {{ $applicant->applicant_qualification == $app_qualification->id ? 'selected="selected"' : ''}}>{{ $app_qualification->qualification_code }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        @if ($applicant->programme_status == '4A' && $applicant->applicant_status != '5A')
                                                                        <div class="col-md-2"><button class="btn btn-primary btn-xs">Offer</button></div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                {!! Form::close() !!}
                                                                @isset($applicant->applicant_programme_2)
                                                                {!! Form::open(['action' => ['ApplicantController@applicantstatus'], 'method' => 'POST'])!!}
                                                                <tr>
                                                                    <input type="hidden" name="id" value="{{ $applicant->id }}">
                                                                    <input type="hidden" name="batch_code" value="{{ isset($batch_2->first()->batch_code) ? $batch_2->first()->batch_code : '' }}">
                                                                    <td>{{ Form::text('applicant_programme', $applicant->applicant_programme_2, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ Form::text('applicant_major', $applicant->applicant_major_2, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ Form::text('applicant_mode', $applicant->applicant_mode_2, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ isset($applicant->programme_status_2) ? $applicant->programmeStatusTwo->status_description : '' }}</td>
                                                                    <td>
                                                                        <select class="form-control" name="applicant_qualification" id="qua2">
                                                                            <option disabled selected>Please select</option>
                                                                            @foreach ($qualification as $app_qualification)
                                                                            <option value="{{ $app_qualification->id }}" {{ $applicant->applicant_qualification == $app_qualification->id ? 'selected="selected"' : ''}}>{{ $app_qualification->qualification_code }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        @if ($applicant->programme_status_2 == '4A' && $applicant->applicant_status != '5A')
                                                                        <div class="col-md-2"><button class="btn btn-primary btn-xs">Offer</button></div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                {!! Form::close() !!}
                                                                @endisset
                                                                @isset($applicant->applicant_programme_3)
                                                                {!! Form::open(['action' => ['ApplicantController@applicantstatus'], 'method' => 'POST'])!!}
                                                                <tr>
                                                                    <input type="hidden" name="id" value="{{ $applicant->id }}">
                                                                    <input type="hidden" name="batch_code" value="{{ isset($batch_3->first()->batch_code) ? $batch_3->first()->batch_code : '' }}">
                                                                    <td>{{ Form::text('applicant_programme', $applicant->applicant_programme_3, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ Form::text('applicant_major', $applicant->applicant_major_3, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ Form::text('applicant_mode', $applicant->applicant_mode_3, ['class' => 'form-control', 'readonly' => 'true']) }}</td>
                                                                    <td>{{ isset($applicant->programme_status_3) ? $applicant->programmeStatusThree->status_description : '' }}</td>
                                                                    <td>
                                                                        <select class="form-control" name="applicant_qualification" id="qua3">
                                                                            <option disabled selected>Please select</option>
                                                                            @foreach ($qualification as $app_qualification)
                                                                            <option value="{{ $app_qualification->id }}" {{ $applicant->applicant_qualification == $app_qualification->id ? 'selected="selected"' : ''}}>{{ $app_qualification->qualification_code }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        @if ($applicant->programme_status_3 == '4A' && $applicant->applicant_status != '5A')
                                                                        <div class="col-md-2"><button class="btn btn-primary btn-xs">Offer</button></div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                {!! Form::close() !!}
                                                                @endisset
                                                            </table>
                                                        {{-- @isset($applicant->offered_programme) --}}
                                                            <table class="table table-bordered table-sm">
                                                                <th colspan="2" style="text-align:center">Offered Programme</th>
                                                                <tr>
                                                                    <td>Offer Programme</td>
                                                                    <td>{{ isset($applicant->offered_programme) ? $applicant->offeredProgramme->programme_name : 'No Information Found' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Offered Major</td>
                                                                    <td>{{ isset($applicant->offered_major) ? $applicant->offeredMajor->major_name : 'No Information Found' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Offered Mode</td>
                                                                    <td>{{ isset($applicant->offered_mode) ? $applicant->OfferedMode->mode_name : 'No Information Found' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Batch Code</td>
                                                                    <td>{{ isset($applicant->batch_code) ? $applicant->batch_code : 'No Information Found' }}</td>
                                                                </tr>
                                                                {!! Form::open(['action' => ['ApplicantController@intakestatus'], 'method' => 'POST'])!!}
                                                                <tr>
                                                                    <td>Intake Session Apply</td>
                                                                    <td>
                                                                        <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                                                        <select name="intake_id" class="form-control" id="intake_id">
                                                                            <option value="{{ $applicant->intake_id }}">{{ $applicant->applicantIntake->intake_code }}</option>
                                                                            @foreach ($intake as $in)
                                                                                <option value="{{ $in->id }}">{{ $in->intake_code }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td>Intake Session Offer</td>
                                                                    <td>
                                                                        <select class="form-control" name="intake_offer" id="intake_offer">
                                                                            <option disabled selected>Please select</option>
                                                                            @foreach ($intake as $in)
                                                                                <option value="{{ $in->id }}" {{ $applicant->intake_offer == $in->id ? 'selected="Selected"' : ''}}>{{ $in->intake_code }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr> --}}
                                                            </table>
                                                            <button class="btn btn-primary btn-sm mt-2 float-right">Update</button>
                                                            {!! Form::close() !!}
                                                        {{-- @endisset --}}
                                                    </div>
                                                    @else
                                                    <div class="card-header">Program Selection</div>
                                                    <div class="card-body"><p>No Information Found</p></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mt-2 mb-3">
                                        <div class="card">
                                            <div class="card-header">Minimum Qualification</div>
                                            <div class="card-body">
                                                @if(($applicant->applicant_programme == ''))
                                                    <p>No Information Found</p>
                                                @endif
                                                @if(($applicant->applicant_programme == 'IAT12') || ( $applicant->applicant_programme_2 == 'IAT12') || ($applicant->applicant_programme_3 == 'IAT12'))
                                                    <p>American Degree Transfer Programme</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'IAL10') || ( $applicant->applicant_programme_2 == 'IAL10') || ($applicant->applicant_programme_3 == 'IAL10'))
                                                    <p>A Level Programme</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'IGR22') || ( $applicant->applicant_programme_2 == 'IGR22') || ($applicant->applicant_programme_3 == 'IGR22'))
                                                    <p>A Level German Programme</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'IAM10') || ( $applicant->applicant_programme_2 == 'IAM10') || ($applicant->applicant_programme_3 == 'IAM10'))
                                                    <p>SACE International</p>
                                                    <ul>
                                                        <li>Pass SPM / O-Level with minimum five (5) credits including English and Mathematics or other equivalent qualifications recognised by Malaysian Government.</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'ILE12') || ($applicant->applicant_programme_2 == 'ILE12') || ($applicant->applicant_programme_3 == 'ILE12'))
                                                    <p>Japanese Preparatory Course</p>
                                                    <ol>
                                                        <li>Science: Minimum credit in 5 subjects including Mathematics <b>OR</b> any science subject in SPM / GCE O-Level or equivalent <b>OR</b></li>
                                                        <li>Non-Science: Minimum credit in 5 subjects including Mathematics in SPM / GCE O-Level or equivalent</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->applicant_programme == 'IKR09') || ($applicant->applicant_programme_2 == 'IKR09') || ($applicant->applicant_programme_3 == 'IKR09'))
                                                    <p>Korean Preparatory Course</p>
                                                    <ul>
                                                        <li>Open (Minimum ability and knowledge in English)</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'IBM20') || ($applicant->applicant_programme_2 == 'IBM20') || ($applicant->applicant_programme_3 == 'IBM20'))
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
                                                @if(($applicant->applicant_programme == 'IPG20') || ($applicant->applicant_programme_2 == 'IPG20') || ($applicant->applicant_programme_3 == 'IPG20'))
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
                                                @if(($applicant->applicant_programme == 'IHP20') || ($applicant->applicant_programme_2 == 'IHP20') || ($applicant->applicant_programme_3 == 'IHP20'))
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
                                                @if(($applicant->applicant_programme == 'IAC20') || ($applicant->applicant_programme_2 == 'IAC20') || ($applicant->applicant_programme_3 == 'IAC20'))
                                                    <p>Diploma in Accounting</p>
                                                    <ol>
                                                        <li>Pass Sijil Pelajaran Malaysia (SPM) or equivalent, with at least three credits, including Mathematics and pass English <b>OR</b></li>
                                                        <li>Pass Sijil Tinggi Pelajaran Malaysia (STPM) or equivalent, with at least Grade C (CGPA 2.0) in any subjects, and credit in Mathematics and pass English in SPM level <b>OR</b></li>
                                                        <li>Pass Sijil Tinggi Agama Malaysia (STAM) with minimum of Maqbul Grade and credit in Mathematics and pass English in SPM level <b>OR</b></li>
                                                        <li>Pass Sijil Kemahiran Malaysia (SKM) Level 3 in related field and pass SPM with minimum one credit in any subject, credit in Mathematics and pass English in SPM level <b>OR</b></li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->applicant_programme == 'IIF20') || ($applicant->applicant_programme_2 == 'IIF20') || ($applicant->applicant_programme_3 == 'IIF20'))
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
                                                @if(($applicant->applicant_programme == 'PAC150') || ($applicant->applicant_programme_2 == 'PAC150') || ($applicant->applicant_programme_3 == 'PAC150'))
                                                    <p>Certified Accounting Technician</p>
                                                    <ol>
                                                        <li>Pass Sijil Pelajaran Malaysia (SPM) with at least five credits including Bahasa Malaysia, Mathematics and English <b>OR</b></li>
                                                        <li>Other qualifications with equivalent recognition by the Malaysian Government.</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->applicant_programme == 'PAC170') || ($applicant->applicant_programme_2 == 'PAC170') || ($applicant->applicant_programme_3 == 'PAC170'))
                                                    <p>Certified in Finance, Accounting & Business (CFAB)</p>
                                                    <ol>
                                                        <li>Pass Sijil Pelajaran Malaysia (SPM) with at least creditfive credits including Bahasa Malaysia, Mathematics and English <b>OR</b></li>
                                                        <li>Other qualifications with equivalent recognition by the Malaysian Government.</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->applicant_programme == 'PAC580') || ($applicant->applicant_programme_2 == 'PAC580') || ($applicant->applicant_programme_3 == 'PAC580'))
                                                    <p>The Malaysian Institute of Certified Public Accountants (MICPA)</p>
                                                    <ol>
                                                        <li>Degree holder with CGPA of at least 3.00; 5.0 (New Zealand); 4.0 (Australia)</li>
                                                        <li>Degree must be from universities which are accredited by MICPA in order to obtain full exemption</li>
                                                    </ol>
                                                @endif
                                                @if(($applicant->applicant_programme == 'PAC551') || ($applicant->applicant_programme_2 == 'PAC551') || ($applicant->applicant_programme_3 == 'PAC551'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from Diploma</p>
                                                    <ul>
                                                        <li>Diploma in Accountancy (Level 4, KKM) with minimum CGPA of 3.00</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'PAC552') || ($applicant->applicant_programme_2 == 'PAC552') || ($applicant->applicant_programme_3 == 'PAC552'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from CAT</p>
                                                    <ul>
                                                        <li>Pass Certified Accounting Technician (CAT)</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'PAC553') || ($applicant->applicant_programme_2 == 'PAC553') || ($applicant->applicant_programme_3 == 'PAC553'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from CAT</p>
                                                    <ul>
                                                        <li>Bachelor of Accountancy or with related fields with CGPA of at least 2.50</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'PAC554') || ($applicant->applicant_programme_2 == 'PAC554') || ($applicant->applicant_programme_3 == 'PAC554'))
                                                    <p>The Association of Chartered Certified Accountants (ACCA)(UK) from CAT</p>
                                                    <ul>
                                                        <li>Bachelor of Accountancy or with related fields with CGPA of at least 2.50</li>
                                                    </ul>
                                                @endif
                                                @if(($applicant->applicant_programme == 'PAC570') || ($applicant->applicant_programme_2 == 'PAC570') || ($applicant->applicant_programme_3 == 'PAC570'))
                                                    <p>The Association of Chartered Certified Accountants (ACA) for Institute of Chartered Accountants in England and Wales (ICAEW)</p>
                                                    <ol>
                                                        <li>Pass ICAEW Certificate in Finance, Accounting, and Business (ICAEW CFAB) <b>OR</b></li>
                                                        <li>Pass Bachelor of Accountancy (Level 6, KKM) with CGPA of at least 2.75</li>
                                                    </ol>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- <hr class="mt-2 mb-3">
                                        @if ($applicant->applicant_status == '3')
                                            <div class="card">
                                                <div class="card-header">Cancel Offer</div>
                                                <div class="card-body">
                                                    {!! Form::open(['action' => ['ApplicantController@cancelOffer'], 'method' => 'POST'])!!}
                                                        <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                                        {{ Form::label('title', 'Reason') }}
                                                        {{ Form::textarea('cancel_reason',isset($applicant->applicantstatus) ? $applicant->applicantstatus->cancel_reason : '',['class' => 'form-control', 'placeholder' => 'Reason']) }}
                                                        <button class="btn btn-primary">Submit</button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        @endif --}}
                                    </div>
                                    <div class="tab-pane" id="individual" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="card">
                                            <div class="card-header">Requirement Check</div>
                                            <div class="card-body">
                                                <form action="{{ route('checkIndividual') }}" method="post" name="form">
                                                    @csrf
                                                    @if ($applicant_recheck->count() == 0)
                                                    <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                                    <button type="submit" class="btn btn-primary">Recheck</button>
                                                    @endif
                                                </form>
                                                @isset($applicant_recheck)
                                                <p class="mt-3">Qualified Programme</p>
                                                @if ($message = Session::get('success'))
                                                    <div class="alert alert-success alert-block">
                                                        <button type="button" class="close" data-dismiss="alert">x</button>
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @endif
                                                    <table class="table table-bordered">
                                                        <tr class="bg-primary-50 text-center">
                                                            <td>Programme <br>Code</td>
                                                            <td>Major Code</td>
                                                            <td>Study Mode</td>
                                                            <td>Highest <br>Qualification</td>
                                                            <td>Action</td>
                                                        </tr>
                                                        @foreach ($applicant_recheck as $app_recheck)
                                                        <form action="{{ route('qualifiedProgramme') }}" method="post" name="form">
                                                            <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                                            <input type="hidden" name="intake_id" value="{{ $applicant->intake_id }}">
                                                            @csrf
                                                            <tr>
                                                                <td>
                                                                    {{ $app_recheck->programme_code }}
                                                                    <input type="hidden" name="programme_code" value="{{ $app_recheck->programme_code }}">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="major">
                                                                        <?php
                                                                            $major_list = $app_recheck->programme->major;
                                                                            $test = $major_list->each(function($item, $value){
                                                                        ?>
                                                                        <option name="major_code" value="{{ $item['major_code'] }}">{{ $item['major_code'] }}</option>
                                                                        <?php
                                                                            });
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="offered_mode" id="offered_mode">
                                                                        @foreach ($mode as $modes)
                                                                        <option value="{{ $modes->id }}">{{ $modes->mode_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="app_qualification" id="high_qua">
                                                                        <option disabled selected>Please select</option>
                                                                        @foreach ($qualification as $app_qualification)
                                                                        <option value="{{ $app_qualification->id }}" {{ $applicant->applicant_qualification == $app_qualification->id ? 'selected="selected"' : ''}}>{{ $app_qualification->qualification_code }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @if ($app_recheck->applicant->applicant_status != '5A' || $app_recheck->applicant->applicant_status != '5C')
                                                                        <div class="col-md-2"><button class="btn btn-primary btn-xs">Offer</button></div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </form>
                                                        @endforeach
                                                    </table>
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="qualification" role="tabpanel">
                                        <hr class="mt-2 mb-3">
                                        <div class="card">
                                            <div class="card-header">Applicant Academic</div>
                                            <div class="card-body">
                                            @if($applicant->applicantresult->count() == 0)
                                            <p>No Information Found</p>
                                            @endif
                                            @if(count($spm)!=0)
                                            <h5>SPM</h5>
                                            @if(isset($spm->first()->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$spm->first()->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif

                                            {{-- {!! isset($spm->first()->file->web_path) ? '<a href="' .  url($spm->first()->file->web_path) . '">Supporting Document</a>' : 'No Supporting Document' !!} --}}
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-primary-50 text-center">
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
                                            @if(isset($stpm->first()->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$stpm->first()->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-primary-50 text-center">
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
                                            @if(isset($stam->first()->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$stam->first()->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-primary-50 text-center">
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
                                            @if(isset($uec->first()->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$uec->first()->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-primary-50 text-center">
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
                                            @if(isset($alevel->first()->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$alevel->first()->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-primary-50 text-center">
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
                                            @if(isset($olevel->first()->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$olevel->first()->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                                <table class="table table-bordered table-sm">
                                                <thead class="bg-primary-50 text-center">
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
                                            @if(isset($muet->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$muet->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>Band</td>
                                                    <td>{{ $muet->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if(isset($matriculation))
                                            <h5>Matriculation</h5>
                                            @if(isset($matriculation->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$matriculation->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
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
                                            @if(isset($foundation->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$foundation->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
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
                                            @if(isset($diploma->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$diploma->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
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
                                            @if(isset($degree->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$degree->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
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
                                            @if(isset($skm->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$skm->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>SKM Level</td>
                                                    <td>{{ $skm->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($sace))
                                            <h5>South Australian Certificate of Education</h5>
                                            @if(isset($sace->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$sace->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>ATAR</td>
                                                    <td>{{ $sace->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($mqf))
                                            <h5>MQF</h5>
                                            @if(isset($mqf->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$mqf->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>MQF Level</td>
                                                    <td>{{ $mqf->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($kkm))
                                            <h5>Kolej Komuniti Malaysia</h5>
                                            @if(isset($kkm->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$kkm->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>KKM Level</td>
                                                    <td>{{ $kkm->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($cat))
                                            <h5>Certified Accounting Technician</h5>
                                            @if(isset($cat->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$cat->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
                                            <table class="table table-bordered table-sm">
                                                <tr>
                                                    <td>CAT</td>
                                                    <td>{{ $cat->applicant_cgpa }}</td>
                                                </tr>
                                            </table>
                                            @endif
                                            @if (isset($icaew))
                                            <h5>ICAEW</h5>
                                            @if(isset($icaew->file->web_path))
                                                <a target="_blank" href="{{ url('qualificationfile')."/".$icaew->file->file_name }}/Download"">Supporting Document</a>
                                            @else
                                                <p>No Supporting Document</p>
                                            @endif
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
                                                                @if ($applicant->applicant_race == '0000')
                                                                    {{ Form::label('title', 'Other Race') }}
                                                                    <input type="text" class="form-control" name="other_race" value="{{ $applicant->other_race }}">
                                                                @endif
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                {{ Form::label('title', 'Religion') }}
                                                                <select class="form-control religion" name="applicant_religion" id="applicant_religion">
                                                                    @foreach ($religion as $religions)
                                                                        <option value="{{ $religions->religion_code }}" {{ $applicant->applicant_religion == $religions->religion_code ? 'selected="selected"' : ''}}>{{ $religions->religion_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($applicant->applicant_religion == 'O')
                                                                    {{ Form::label('title', 'Other Religion') }}
                                                                    <input type="text" class="form-control" name="other_religion" value="{{ $applicant->other_religion }}">
                                                                @endif
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
                                                        <button class="btn btn-primary btn-sm float-right"><i class="fal fa-arrow-alt-from-bottom"></i> Update</button>
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
                                                        <button class="btn btn-primary btn-sm float-right mt-4"><i class="fal fa-arrow-alt-from-bottom"></i> Update</button>
                                                        @endcan
                                                        {!! Form::close() !!}
                                                        @else
                                                        <p>No Information Found</p>
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
                                                        <button class="btn btn-primary btn-sm float-right mt-4"><i class="fal fa-arrow-alt-from-bottom"></i> Update</button>
                                                        @endcan
                                                        {!! Form::close() !!}
                                                        @else
                                                        <p>No Information Found</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="tab-content col-md-4 mt-4">
                                <div class="card">
                                    <div class="card-header">Activity Log</div>
                                    <div class="card-body">
                                        @if (isset($activity))
                                        <table class="table table-bordered">
                                            <tr class="bg-primary-50 text-center">
                                                <td>Date</td>
                                                <td>Activity</td>
                                                <td>User</td>
                                            </tr>
                                            @foreach ($activity as $activities)
                                            <tr>
                                                <td>{{ $activities->created_at }}</td>
                                                <td>{{ $activities->description }}</td>
                                                <td>{{ $activities->name }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                        @endif
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
    $(document).ready(function() {
        $('.country, .gender, .marital, .race, .religion, .relation, .qualification, .qua, #intake_id ,#intake_offer, #qua1, #qua2, #qua3').select2();
    });
</script>
@endsection
