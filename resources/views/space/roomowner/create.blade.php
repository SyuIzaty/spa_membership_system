@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    {{-- <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
        <li class="breadcrumb-item">Page Views</li>
        <li class="breadcrumb-item active">Profile</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol> --}}
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Room Owner Registration
            {{-- <small>
                Register Supervisor, Co-Supervisor & Advisor
            </small> --}}
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Register <span class="fw-300"><i>Room Owner</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('roomowner.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <p><span class="text-danger">*</span> Required fields</p>
                                <table id="campus" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                        
                                <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="name">Name <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror</td>
                                    <td width="15%"><label class="form-label" for="phone_number">Phone Number <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number">
                                            @error('phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror</td>
                                </div>
                                </tr>   

                                {{-- <div class="form-group">
                                    <label class="form-label" for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                    <input value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number">
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div> --}}

                                <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="email">Email <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><input value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                            @enderror</td>
                                </div>
                                </tr>
                                
                                <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="dateofbirth">Date of Birth <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><input type="date" value="{{ old('dateofbirth') }}" class="form-control @error('dateofbirth') is-invalid @enderror" id="dateofbirth" name="dateofbirth">
                                            @error('dateofbirth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                            @enderror</td>
                                </div>
                                </tr>

                                <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="gender">Gender <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                            <option value="">Please Select</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected':''}}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected':''}}>Female</option>
                                        </select>
                                        @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                    @enderror</td>
                                </div>
                                </tr>

                                <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="active">Active <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
                                            <option value="">Please Select</option>
                                            <option value="0" {{ old('active') == 'No' ? 'selected':''}} >No</option>
                                            <option value="1" {{ old('active') == 'Yes' ? 'selected':''}} >Yes</option>
                                        </select>
                                        @error('active')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                    @enderror</td>
                                </div>
                                </tr>

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="image">Image <span class="text-danger">*</span></label></td>
                                            <td colspan="10"><div value="{{ old('image') }}" class="col-sm-6 form-control @error('image') is-invalid @enderror"><input type="file" name="image" id="image"></div>
                                                <div class="clearfix"></div>
                                                <!-- sent message error input -->
                                                @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                                @enderror
                                            </td>
                                    </div>
                                </tr>

                            </thead>
                            </table>
                                {{-- <button type="submit" class="btn btn-primary btn-sm">Save</button> --}}
                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                <a style="margin-right:5px" href="{{ URL::route('roomowner.index') }}" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@section('script')



@endsection
