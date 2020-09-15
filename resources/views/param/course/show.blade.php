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
                        View Course :<span class="fw-300"><i> {{ $course->course_name }}</i></span>
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
                                    <td width="15%"><b>COURSE ID :</b></td>
                                    <td colspan="3"><strong>{{ strtoupper($course->id) }}<strong></td>
                                    <td width="15%"><b>COURSE CODE :</b></td>
                                    <td colspan="3"><strong>{{ strtoupper($course->course_code) }}<strong></td>
                                    <td width="15%"><b>COURSE NAME :</b></td>
                                    <td colspan="4"><strong>{{ strtoupper($course->course_name) }}<strong></td>
                                </tr>
                                <tr>
                                    <td width="15%"><b>CREDIT HOURS :</b></td> 
                                    <td colspan="5"><strong>{{ strtoupper($course->credit_hours) }}<strong></td> 
                                    <td width="15%"><b>COURSE STATUS :</b></td> 
                                    {{-- <td colspan="5"><strong>{{ strtoupper($course->course_status) }}<strong></td>  --}}
                                    <td colspan="5"><strong>{{ strtoupper($course->course_status ? 'Active' : 'Inactive') }}<strong></td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                        <a href="/param/course/{{$course->id}}/edit" class="btn btn-warning ml-auto float-right"><i class="fal fa-pencil"></i> Edit</a> 
                        <a style="margin-right:5px" href="{{ url()->previous() }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
@endsection

