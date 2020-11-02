@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Course Registration
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>Course</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p><span class="text-danger">*</span> Required fields</p>
                            <table id="course" class="table table-bordered table-hover table-striped w-100">
                                <thead>

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="course_id"><span class="text-danger">*</span> Course ID </label></td>
                                            <td colspan="3"><input value="{{ old('course_id') }}" class="form-control" id="course_id" name="course_id" readonly>
                                                @error('course_id')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        <td width="15%"><label class="form-label" for="course_code"><span class="text-danger">*</span> Course Code</label></td>
                                            <td colspan="3"><input value="{{ old('course_code') }}" class="form-control" id="course_code" name="course_code">
                                                @error('course_code')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                    </div>
                                </tr>
                                        
                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="course_name"><span class="text-danger">*</span> Course Name</label></td>
                                        <td colspan="3"><input value="{{ old('course_name') }}" class="form-control" id="course_name" name="course_name">
                                            @error('course_name')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                        <td width="15%"><label class="form-label" for="course_name_bm"><span class="text-danger">*</span> Course Name [Malay]</label></td>
                                        <td colspan="3"><input value="{{ old('course_name_bm') }}" class="form-control" id="course_name_bm" name="course_name_bm">
                                            @error('course_name_bm')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                </tr>

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="final_exam"><span class="text-danger">*</span> Have Final Exam ?</label><br><br>
                                        <label class="form-label" for="project_course"><span class="text-danger">*</span> Have Project Course ?</label></td>
                                        <td colspan="2" style="padding-top: 20px;">
                                            <input class="ml-5" type="radio" name="final_exam" id="final_exam" value="Yes" {{ old('final_exam') == "Yes" ? 'checked' : '' }}> Yes
                                            <input class="ml-5" type="radio" name="final_exam" id="final_exam" value="No" {{ old('final_exam') == "No" ? 'checked' : '' }}> No
                                            <br><br>
                                            <input class="ml-5" type="radio" name="project_course" id="project_course" value="Yes" {{ old('project_course') == "Yes" ? 'checked' : '' }}> Yes
                                            <input class="ml-5" type="radio" name="project_course" id="project_course" value="No" {{ old('project_course') == "No" ? 'checked' : '' }}> No
                                          
                                        </td>
                                        <td width="15%"><label class="form-label" for="exam_duration"><span class="text-danger">*</span> Exam Duration</label></td>
                                        <td colspan="2"><input type="text" value="{{ old('exam_duration') }}" class="form-control" id="exam_duration" name="exam_duration">
                                            @error('exam_duration')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                        <td width="15%"><label class="form-label" for="lab_hours"><span class="text-danger">*</span> Lab Hours</label></td>
                                        <td colspan="2"><input type="number" value="{{ old('lab_hours') }}" class="form-control" id="lab_hours" name="lab_hours">
                                            @error('lab_hours')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                </tr>

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="credit_hours"><span class="text-danger">*</span> Credit Hours</label></td>
                                        <td colspan="2"><input type="number" value="{{ old('credit_hours') }}" class="form-control" id="credit_hours" name="credit_hours">
                                            @error('credit_hours')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                        <td width="15%"><label class="form-label" for="tutorial_hours"><span class="text-danger">*</span> Tutorial Hours</label></td>
                                        <td colspan="2"><input type="number" value="{{ old('tutorial_hours') }}" class="form-control" id="tutorial_hours" name="tutorial_hours">
                                            @error('tutorial_hours')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                        <td width="15%"><label class="form-label" for="lecturer_hours"><span class="text-danger">*</span> Lecturer Hours</label></td>
                                        <td colspan="2"><input type="number" value="{{ old('lecturer_hours') }}" class="form-control" id="lecturer_hours" name="lecturer_hours">
                                            @error('lecturer_hours')
                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                            @enderror
                                        </td>
                                    </div>
                                </tr>

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="course_status"><span class="text-danger">*</span> Status</label></td>
                                        <td colspan="8"><select class="form-control" id="course_status" name="course_status">
                                            <option value="">-- Select Active Status --</option>
                                            <option value="1" {{ old('course_status') == '1' ? 'selected':''}} >Active</option>
                                            <option value="0" {{ old('course_status') == '0' ? 'selected':''}} >Inactive</option>
                                        </select>
                                        @error('course_status')
                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                        @enderror
                                        </td>
                                    </div>
                                </tr>
                                
                            </thead>
                        </table>

                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                <a style="margin-right:5px" href="{{ URL::route('course.index') }}" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@endsection

@section('script')

<script type="text/javascript">
    $(document).ready( function() {
        $('#course_code').on('change', function() {
            $('#course_id').val($(this).val());
        });
    });
</script>

@endsection
