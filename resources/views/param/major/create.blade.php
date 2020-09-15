@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Major Registration
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>Major</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('major.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p><span class="text-danger">*</span> Required fields</p>
                            <table id="major" class="table table-bordered table-hover table-striped w-100">
                                <thead>

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="id">Major ID <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('id') }}" class="form-control @error('id') is-invalid @enderror" id="id" name="id" readonly>
                                            @error('id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                        </td>
                                    <td width="15%"><label class="form-label" for="major_code">Major Code <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('major_code') }}" class="form-control @error('major_code') is-invalid @enderror" id="major_code" name="major_code">
                                            @error('major_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                        </td>
                                </div>
                            </tr>
                                    
                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="major_name">Major Name <span class="text-danger">*</span></label></td>
                                    <td colspan="5"><input value="{{ old('major_name') }}" class="form-control @error('major_name') is-invalid @enderror" id="major_name" name="major_name">
                                        @error('major_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                    </td>
                                    <td width="15%"><label class="form-label" for="major_status">Status <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><select class="form-control @error('major_status') is-invalid @enderror" id="major_status" name="major_status">
                                            <option value="">-- Select Major Status --</option>
                                            <option value="1" {{ old('major_status') == '1' ? 'selected':''}} >Active</option>
                                            <option value="0" {{ old('major_status') == '0' ? 'selected':''}} >Inactive</option>
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
                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                <a style="margin-right:5px" href="{{ URL::route('major.index') }}" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
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
        $('#major_code').on('change', function() {
            $('#id').val($(this).val());
        });
    });
</script>

@endsection
