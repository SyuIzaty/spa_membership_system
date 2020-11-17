@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-list'></i> Study Plan Information
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        {{-- Plan :<span class="fw-300"><i> {{ $std->programs->programme_name}} </i></span> --}}
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                   
                <div class="panel-content">
                    {{-- <table id="planInfo" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="plan_progs">Programme :</label></td>
                                    <td width="40%"><b>{{ $std->plan_progs}}</b> - {{ $std->programs->programme_name}}</td>
                                    <td width="15%"><label class="form-label" for="plan_sm">Study Mode :</label></td>
                                    <td width="40%"><b>{{ $std->plan_sm}}</b> - {{ $std->modes->mode_name}}</td>
                                </div>
                            </tr>

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="plan_stat">Total Credit Hours</label></td>
                                    <td width="40%">{{ $std->plan_cr_hr_total}}</td>
                                    <td width="15%"><label class="form-label" for="plan_semester">Effective Semester :</label></td>
                                    <td colspan="2">{{ $std->plan_semester}}</td>
                                </div>
                            </tr>
                        
                        </thead>
                    </table>

                    <br> --}}

                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card card-primary card-outline">
                                <div class="card-header bg-primary-50">
                                    <b>Plan</b> :<span class="fw-300"><i> {{ $std->programs->programme_name}} </i></span>
                                </div>

                                <div class="card-body">

                                    <table id="planInfo" class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <div class="form-group">
                                                    <td width="15%"><label class="form-label" for="plan_progs">Programme :</label></td>
                                                    <td width="40%"><b>{{ $std->plan_progs}}</b> - {{ $std->programs->programme_name}}</td>
                                                    <td width="15%"><label class="form-label" for="plan_sm">Study Mode :</label></td>
                                                    <td width="40%"><b>{{ $std->plan_sm}}</b> - {{ $std->modes->mode_name}}</td>
                                                </div>
                                            </tr>
                
                                            <tr>
                                                <div class="form-group">
                                                    <td width="15%"><label class="form-label" for="plan_stat">Total Credit Hours</label></td>
                                                    <td width="40%">{{ $std->plan_cr_hr_total}}</td>
                                                    <td width="15%"><label class="form-label" for="plan_semester">Effective Semester :</label></td>
                                                    <td colspan="2">{{ $std->plan_semester}}</td>
                                                </div>
                                            </tr>
                                        
                                        </thead>
                                    </table>

                                    <br>

                                    <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                        <thead>
                                            <tr align="center" class="card-header">
                                                <th style="width: 50px;">No.</th>
                                                <th>Course</th>
                                                <th>Credit Hours</th>
                                                <th>Course Type</th>
                                                <th>Course Elective</th>
                                            </tr>
                                            @if(!empty($stdHd) && $stdHd->count() > 0)
                                                @foreach($stdHd as $Hd) 
                                                    <tr align="center" class="data-row">
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $Hd->std_hd_course }} - {{ $Hd->courses->course_name }}</td>
                                                        <td>{{ $Hd->std_hd_cr_hr }}</td>
                                                        <td>
                                                            @if ($Hd->std_hd_type == 'C') Core @endif
                                                            @if ($Hd->std_hd_type == 'E') Elective @endif
                                                        </td>
                                                        {{-- @dd($Hd->studyEl) --}}
                                                        <td>
                                                            @if($Hd->std_hd_type == 'E')
                                                                @foreach($Hd->studyEl as $value)
                                                                    <ul>
                                                                        <li align="left">{{ $value->std_elec_course }} {{ $value->courses->course_name }}<br></li>
                                                                    </ul>   
                                                                @endforeach
                                                            @else
                                                                -- NO DATA --
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr align="center" class="data-row">
                                                    <td valign="top" colspan="5" class="dataTables_empty">No data available in table</td>
                                                </tr>
                                            @endif
                                        </thead>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>
                     
                </div>

                    {{-- <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href="/param/course/{{$course->id}}/edit" class="btn btn-warning ml-auto float-right"><i class="fal fa-pencil"></i> Edit</a> 
                        <a style="margin-right:5px" href="{{ URL::route('course.index') }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
                    </div> --}}

            </div>
        </div>
    </div>

    </div>
</main>
@endsection

