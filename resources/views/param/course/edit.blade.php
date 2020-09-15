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
                        Update Course : <span class="fw-300"><i> {{ $course->course_name }}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('course.update', $course->id) }}" enctype="multipart/form-data" method="POST"> 
                            @method('PUT')
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p><span class="text-danger">*</span> Required fields</p>
                            <table id="major" class="table table-bordered table-hover table-striped w-100">
                                <thead>

                                <tr>
                                    <div class="form-group">   
                                        <td width="15%"><label class="form-label" for="id">Course ID <span class="text-danger">*</span></label></td>
                                            <td colspan="5"><input class="form-control @error('id') is-invalid @enderror" id="id" name="id" value="{{ $course->id }}" readonly>
                                                @error('id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> *{{ $message }} </strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        <td width="15%"><label class="form-label" for="course_code">Course Code <span class="text-danger">*</span></label></td>
                                            <td colspan="5"><input class="form-control @error('course_code') is-invalid @enderror" id="course_code" name="course_code" value="{{ $course->course_code }}">
                                                @error('course_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> *{{ $message }} </strong>
                                                    </span>
                                                @enderror
                                            </td>
                                    </div>
                                </tr>        

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="course_name">Course Name <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input class="form-control @error('course_name') is-invalid @enderror" id="course_name" name="course_name" value="{{ $course->course_name }}">
                                            @error('course_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                        </td>
                                        <td width="15%"><label class="form-label" for="credit_hours">Credit Hours <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input type="number" class="form-control @error('credit_hours') is-invalid @enderror" id="credit_hours" name="credit_hours" value="{{ $course->credit_hours }}">
                                            @error('credit_hours')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                        </td>
                                    </div>
                                </tr>

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="course_status">Status <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><select class="form-control @error('course_status') is-invalid @enderror" id="course_status" name="course_status">
                                            <option value="">-- Select Course Status --</option>
                                            <option value="1" {{ old('course_status', $course->course_status) == '1' ? 'selected':''}} >Active</option>
                                            <option value="0" {{ old('course_status', $course->course_status) == '0' ? 'selected':''}} >Inactive</option>
                                        </select>
                                            @error('major_status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
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
            </div>
        </div>

    </div>
</main>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready( function() {
        $('#course_code').on('change', function() {
            $('#id').val($(this).val());
        });
    });
</script>


@endsection
