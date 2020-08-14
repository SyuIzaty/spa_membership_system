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
            <i class='subheader-icon fal fa-plus-circle'></i> Level Registration
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
                        Register <span class="fw-300"><i>Level</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('level.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p><span class="text-danger">*</span> Required fields</p>
                                <div class="form-group">
                                    <label class="form-label" for="level_code">Code <span class="text-danger">*</span></label>
                                    <input value="{{ old('level_code') }}" class="form-control @error('level_code') is-invalid @enderror" id="level_code" name="level_code">
                                        @error('level_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                    <input value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="campus_id">Campus <span class="text-danger">*</span></label>
                                    <select name="campus_id" id="campus_id" class="form-control @error('campus_id') is-invalid @enderror">
                                        <option value="">Select Campus</option>
                                        @foreach ($campus as $campus) 
                                            <option value="{{ $campus->id }}" {{ $campus->id == $level->level_id ? 'selected' : '' }}>
                                                {{ $campus->name }}</option>
                                        @endforeach
                                     </select>
                                    @error('campus_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="zone_id">Zone <span class="text-danger">*</span></label>
                                    <select name="zone_id" id="zone_id" class="form-control @error('zone_id') is-invalid @enderror">
                                        <option value="">Select Zone</option>
                                        @foreach ($zone as $zones) 
                                            <option value="{{ $zones->id }}" {{ $zones->id == $level->level_id ? 'selected' : '' }}>
                                                {{ $zones->name }}</option>
                                        @endforeach
                                     </select>
                                    @error('zone_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="zone_id">Building <span class="text-danger">*</span></label>
                                    <select name="building_id" id="building_id" class="form-control @error('building_id') is-invalid @enderror">
                                        <option value="">Select Building</option>
                                        @foreach ($building as $buildings) 
                                            <option value="{{ $buildings->id }}" {{ $buildings->id == $level->level_id ? 'selected' : '' }}>
                                                {{ $buildings->name }}</option>
                                        @endforeach
                                     </select>
                                    @error('building_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                                    <input value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                     @error('description')
                                     <span class="invalid-feedback" role="alert">
                                         <strong> *{{ $message }} </strong>
                                     </span>
                                     @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="active">Active <span class="text-danger">*</span></label>
                                    <select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
                                        <option value="">Please Select</option>
                                        <option value="0" {{ old('active') == 'No' ? 'selected':''}} >No</option>
                                        <option value="1" {{ old('active') == 'Yes' ? 'selected':''}} >Yes</option>
                                    </select>
                                    @error('active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> *{{ $message }} </strong>
                                    </span>
                                @enderror
                                </div>

                                <button type="submit" class="btn btn-primary ml-auto"><i class="fal fa-save"></i> Save</button>	
                                <button type="reset" class="btn btn-danger ml-auto"><i class="fal fa-redo"></i> Reset</button>
                                <a href="{{ URL::route('level.index') }}" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto"><i class="fal fa-trash-alt"></i> Discard</a>
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
