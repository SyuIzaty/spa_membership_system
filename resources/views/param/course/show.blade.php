@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Course Information
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        View Course :<span class="fw-300"><i> {{ $course->id }} [ {{ $course->course_status ? 'Active' : 'Inactive' }} ]</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                   
                <div class="panel-content">
                    <table id="course" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th colspan="10" class="bg-primary-50"><i class="fal fa-list"></i> {{ strtoupper($course->course_name) }}</th>
                            </tr>
                            <tr>
                                <div class="form-group">   
                                    <td width="15%"><label class="form-label">COURSE ID :</label></td>
                                    <td width=""><strong style="cursor:context-menu" class="form-control" readonly>{{ strtoupper($course->id) }}<strong></td>
                                    <td width="15%"><label class="form-label">COURSE CODE :</label></td>
                                    <td width=""><strong style="cursor:context-menu" class="form-control" readonly>{{ strtoupper($course->course_code) }}<strong></td>
                                </div>
                            </tr>        

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label">COURSE NAME :</label></td>
                                    <td width="15%"><strong style="cursor:context-menu" class="form-control h-100" readonly>{{ strtoupper($course->course_name) }}<strong></td>
                                    <td width="15%"><label class="form-label">CREDIT HOURS :</label></td>
                                    <td width="15%"><strong style="cursor:context-menu" class="form-control" readonly>{{ strtoupper($course->credit_hours) }}<strong></td>
                                </div>
                            </tr>

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label">COURSE STATUS :</label></td>
                                    <td colspan="10"><strong style="cursor:context-menu" class="form-control" readonly>{{ strtoupper($course->course_status ? 'Active' : 'Inactive') }}<strong></td>
                                </div>
                            </tr>

                        </thead>
                    </table>
                     
                </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href="/param/course/{{$course->id}}/edit" class="btn btn-warning ml-auto float-right"><i class="fal fa-pencil"></i> Edit</a> 
                        <a style="margin-right:5px" href="{{ URL::route('course.index') }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
                    </div>

            </div>
        </div>
    </div>

    </div>
</main>
@endsection

