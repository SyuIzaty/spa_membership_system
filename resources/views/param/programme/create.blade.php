@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Programme Registration
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>Programme</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('programme.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p><span class="text-danger">*</span> Required fields</p>
                            <table id="program" class="table table-bordered table-hover table-striped w-100">
                                <thead>

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="id">Programme ID <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('id') }}" class="form-control @error('id') is-invalid @enderror" id="id" name="id" readonly>
                                            @error('id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                        </td>
                                    <td width="15%"><label class="form-label" for="programme_code">Programme Code <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('programme_code') }}" class="form-control @error('programme_code') is-invalid @enderror" id="programme_code" name="programme_code">
                                            @error('programme_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                        </td>
                                </div>
                            </tr>
                                    
                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="programme_name">Programme Name <span class="text-danger">*</span></label></td>
                                    <td colspan="5"><input value="{{ old('programme_name') }}" class="form-control @error('programme_name') is-invalid @enderror" id="programme_name" name="programme_name">
                                        @error('programme_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror</td>
                                    <td width="15%"><label class="form-label" for="scroll_name">Programme Scroll Name <span class="text-danger">*</span></label></td>
                                    <td colspan="5"><input value="{{ old('scroll_name') }}" class="form-control @error('scroll_name') is-invalid @enderror" id="scroll_name" name="scroll_name">
                                        @error('scroll_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror</td>
                                </div>
                            </tr>

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="programme_name_malay">Programme Name (Malay) <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('programme_name_malay') }}" class="form-control @error('programme_name_malay') is-invalid @enderror" id="programme_name_malay" name="programme_name_malay">
                                            @error('programme_name_malay')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror</td>
                                    <td width="15%"><label class="form-label" for="scroll_name_malay">Programme Scroll Name (Malay) <span class="text-danger">*</span></label></td>
                                    <td colspan="5"><input value="{{ old('scroll_name_malay') }}" class="form-control @error('scroll_name_malay') is-invalid @enderror" id="scroll_name_malay" name="scroll_name_malay">
                                        @error('scroll_name_malay')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror</td>
                                </div>
                            </tr>

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="programme_duration">Programme Duration <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('programme_duration') }}" class="form-control @error('programme_duration') is-invalid @enderror" id="programme_duration" name="programme_duration">
                                            @error('programme_duration')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                            @enderror
                                        </td>
                                        <td width="15%"><label class="form-label" for="programme_status">Status <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><select class="form-control @error('programme_status') is-invalid @enderror" id="programme_status" name="programme_status">
                                            <option value="">-- Select Programme Status --</option>
                                            <option value="1" {{ old('programme_status') == '1' ? 'selected':''}} >Active</option>
                                            <option value="0" {{ old('programme_status') == '0' ? 'selected':''}} >Inactive</option>
                                        </select>
                                        @error('programme_status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                    @enderror</td>
                                </div>
                            </tr>

                            </thead>
                        </table>
                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                <a style="margin-right:5px" href="{{ URL::route('programme.index') }}" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
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
        $('#programme_code').on('change', function() {
            $('#id').val($(this).val());
        });
    });
</script>

@endsection
