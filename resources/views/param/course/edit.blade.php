@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Course Information Update
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Update <span class="fw-300"><i> {{ $course->course_name}}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                        <div class="card card-primary card-outline">
                            <div class="card-header bg-primary-50">
                                <h5 class="card-title w-100">COURSE DETAILS</h5>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('course.update', $course->id) }}" enctype="multipart/form-data" method="POST"> 
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{ $course->id}}">
                                    <p><span class="text-danger">*</span> Required fields</p>
                                        <table id="major" class="table table-bordered table-hover table-striped w-100">
                                            <thead>

                                            <tr>
                                                <div class="form-group">   
                                                    <td width="15%"><label class="form-label" for="course_id"><span class="text-danger">*</span> Course ID</label></td>
                                                        <td colspan="3"><input class="form-control" id="course_id" name="course_id" value="{{ $course->id }}" readonly>
                                                            @error('course_id')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                    <td width="15%"><label class="form-label" for="course_code"><span class="text-danger">*</span> Course Code</label></td>
                                                        <td colspan="3"><input class="form-control" id="course_code" name="course_code" value="{{ $course->course_code }}">
                                                            @error('course_code')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                </div>
                                            </tr>        

                                            <tr>
                                                <div class="form-group">
                                                    <td width="15%"><label class="form-label" for="course_name"><span class="text-danger">*</span> Course Name</label></td>
                                                    <td colspan="3"><input class="form-control" id="course_name" name="course_name" value="{{ $course->course_name }}">
                                                        @error('course_name')
                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                    <td width="15%"><label class="form-label" for="course_name_bm"><span class="text-danger">*</span> Course Name [Malay]</label></td>
                                                    <td colspan="3"><input class="form-control" id="course_name_bm" name="course_name_bm" value="{{ $course->course_name_bm }}">
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
                                                            <input class="ml-5" type="radio" name="final_exam" id="final_exam" value="Yes" {{ $course->final_exam == "Yes" ? 'checked="checked"' : '' }}> Yes
                                                            <input class="ml-5" type="radio" name="final_exam" id="final_exam" value="No" {{ $course->final_exam == "No" ? 'checked="checked"' : '' }}> No
                                                            <br><br>
                                                            <input class="ml-5" type="radio" name="project_course" id="project_course" value="Yes" {{ $course->project_course == "Yes" ? 'checked="checked"' : '' }}> Yes
                                                            <input class="ml-5" type="radio" name="project_course" id="project_course" value="No" {{ $course->project_course == "No" ? 'checked="checked"' : '' }}> No
                                                        
                                                        </td>
                                                    <td width="15%"><label class="form-label" for="exam_duration"><span class="text-danger">*</span> Exam Duration</label></td>
                                                        <td colspan="2"><input type="text" class="form-control" id="exam_duration" name="exam_duration" value="{{ $course->exam_duration }}">
                                                            @error('exam_duration')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                    <td width="15%"><label class="form-label" for="lab_hours"><span class="text-danger">*</span> Lab Hours</label></td>
                                                        <td colspan="2"><input type="number" class="form-control" id="lab_hours" name="lab_hours" value="{{ $course->lab_hours }}">
                                                            @error('lab_hours')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="form-group">
                                                    <td width="15%"><label class="form-label" for="credit_hours"><span class="text-danger">*</span> Credit Hours</label></td>
                                                    <td colspan="2"><input type="number" class="form-control" id="credit_hours" name="credit_hours" value="{{ $course->credit_hours }}">
                                                        @error('credit_hours')
                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                    <td width="15%"><label class="form-label" for="tutorial_hours"><span class="text-danger">*</span> Tutorial Hours</label></td>
                                                    <td colspan="2"><input type="number" class="form-control" id="tutorial_hours" name="tutorial_hours" value="{{ $course->tutorial_hours }}">
                                                        @error('tutorial_hours')
                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                        @enderror
                                                    </td>
                                                    <td width="15%"><label class="form-label" for="lecturer_hours"><span class="text-danger">*</span> Lecturer Hours</label></td>
                                                    <td colspan="2"><input type="number" class="form-control" id="lecturer_hours" name="lecturer_hours" value="{{ $course->lecturer_hours }}">
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
                                                        <option value="">-- Select Course Status --</option>
                                                        <option value="1" {{ old('course_status', $course->course_status) == '1' ? 'selected':''}} >Active</option>
                                                        <option value="0" {{ old('course_status', $course->course_status) == '0' ? 'selected':''}} >Inactive</option>
                                                    </select>
                                                    @error('course_status')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                    </td>
                                                </div>
                                            </tr>

                                        </thead>
                                </table>
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button> 
                                        <a style="margin-right:5px" href="{{ url()->previous() }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
                                </form>

                            </div>

                        </div>
                        
                        <br>

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="card card-primary card-outline">
                                    <div class="card-header bg-primary-50">
                                        <h5 class="card-title w-100">PRE-REQUISITES</h5>
                                    </div>

                                    <div class="card-body">

                                        <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                            <thead>
                                                <tr align="center" class="card-header">
                                                    <th style="width: 50px;">No.</th>
                                                    <th>Pre-Requisite Course</th>
                                                </tr>
                                                @php $data = []; @endphp
                                                @if(!empty($pre) && $pre->count() > 0)
                                                    @foreach($pre as $pres) 
                                                    @php $data[] = $pres->pre_requisite_course; @endphp
                                                    <tr align="center" class="data-row">
                                                        <td>{{ $no++ }}</td>
                                                        <td><input type="text" class="form-control text-center" value="{{ $pres->pre_requisite_course ?? '-- NO DATA --' }}" disabled></td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="data-row">
                                                        <td></td>
                                                        <td><input type="text" class="form-control text-center" value="-- NO DATA --" disabled></div></td>
                                                    </tr>
                                                @endif
                                            </thead>
                                        </table>

                                        <a href="" data-toggle="modal" data-target="#pre-modal" data-pre="{{ json_encode($data) }}" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add Pre-Requisites</a>
                                       
                                    </div>

                                </div>

                            </div>

                            <div class="modal fade" id="pre-modal" aria-hidden="true" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="card-header">
                                            <h5 class="card-title w-100">LIST OF COURSES</h5>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['action' => 'CourseController@preInfo', 'method' => 'POST']) !!}
                                            {{Form::hidden('id', $course->id)}}
                                            
                                                <div class="form-group"  style="max-height: 500px; overflow-y: auto;">
                                                    <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                                        <thead>
                                                            <tr align="center" class="card-header">
                                                                <th style="width: 80px;">Course Code</th>
                                                                <th>Course Name</th>
                                                                <th style="width: 80px;">Action</th>
                                                            </tr>
                                                            @foreach($pcCourse as $preCourse)
                                                            <tr align="center" class="data-row">
                                                                <td align="left" >{{ $preCourse->course_code }}</td>
                                                                <td align="left" >{{ $preCourse->course_name }}</td>
                                                                <td>  
                                                                    <input type="checkbox" name="pre_requisite_course[]" value="{{ $preCourse->course_code }}" multiple="multiple">
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </thead>
                                                    </table>
                                                </div>

                                            <div class="footer">
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                                <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <br>
                        
                            <div class="col-sm-6">

                                <div class="card card-primary card-outline">
                                    <div class="card-header bg-primary-50">
                                        <h5 class="card-title w-100">CO-REQUISITES</h5>
                                    </div>

                                    <div class="card-body">

                                        <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                            <thead>
                                                <tr align="center" class="card-header">
                                                    <th style="width: 50px;">No.</th>
                                                    <th>Co-Requisite Course</th>
                                                </tr>
                                                @php $value = []; @endphp
                                                @if(!empty($co) && $co->count() > 0)
                                                    @foreach($co as $cos)
                                                    @php $value[] = $cos->co_requisite_course; @endphp
                                                    <tr align="center" class="data-row">
                                                        <td>{{ $nos++ }}</td>
                                                        <td><input type="text" class="form-control text-center" value="{{ $cos->co_requisite_course ?? '-- NO DATA --' }}" disabled></td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr align="center" class="data-row">
                                                        <td></td>
                                                        <td><input type="text" class="form-control text-center" value="-- NO DATA --" disabled></div></td>
                                                    </tr>
                                                @endif
                                            </thead>
                                        </table>

                                        <a href="" data-toggle="modal" data-target="#co-modal" data-pre="{{ json_encode($value) }}" class="btn btn-primary ml-auto float-right"><i class="fal fa-plus-square"></i> Add Co-Requisites</a>

                                    </div>

                                </div>     
                            </div>

                            <div class="modal fade" id="co-modal" aria-hidden="true" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="card-header">
                                            <h5 class="card-title w-100">LIST OF COURSES</h5>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['action' => 'CourseController@coInfo', 'method' => 'POST']) !!}
                                            {{Form::hidden('id', $course->id)}}
                                            
                                                <div class="form-group"  style="max-height: 500px; overflow-y: auto;">
                                                    <table class="table table-bordered table-hover table-striped w-100" style="table-layout:fixed">
                                                        <thead>
                                                            <tr align="center" class="card-header">
                                                                <th style="width: 80px">Course Code</th>
                                                                <th>Course Name</th>
                                                                <th style="width: 80px;">Action</th>
                                                            </tr>
                                                            @foreach($pcCourse as $coCourse)
                                                            <tr align="center" class="data-row">
                                                                <td align="left" >{{ $coCourse->course_code}}</td>
                                                                <td align="left" >{{ $coCourse->course_name}}</td>
                                                                <td>
                                                                    <input type="checkbox" name="co_requisite_course[]" value="{{ $coCourse->course_code}}" multiple="multiple">
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </thead>
                                                    </table>
                                                </div>

                                            <div class="footer">
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                                <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                            </div>
                                            {!! Form::close() !!}
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
$(function () {
    $('#pre-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var pre = <?php echo json_encode($data); ?>;

        $('.modal-body #pre').val(pre);
        $("input:checkbox").val(pre);
    });

    $('#co-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var co = <?php echo json_encode($value); ?>;

        $('.modal-body #co').val(co);
        $("input:checkbox").val(co);
    });

    $('#course_code').on('change', function() {
        $('#course_id').val($(this).val());
    });

    $('#new-co').click(function () {
        $('#co-modal').modal('show');
    });
});
</script>
@endsection
