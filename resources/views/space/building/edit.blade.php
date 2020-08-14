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
            <i class='subheader-icon fal fa-plus-circle'></i> Building Information Update
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
                        Update <span class="fw-300"><i>Building {{ $building->name }}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('building.update',$building->id) }}" enctype="multipart/form-data" method="POST">
                            @method('PUT')
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p><span class="text-danger">*</span> Required fields</p>
                                <div class="form-group">
                                    <label class="form-label" for="building_code">Code <span class="text-danger">*</span></label>
                                    <input class="form-control @error('building_code') is-invalid @enderror" id="building_code" name="building_code" value="{{ $building->building_code }}">
                                        @error('building_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                
                                <div class="form-group">
                                    <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $building->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="campus_id">Campus <span class="text-danger">*</span></label>
                                    <select name="campus_id" id="campus_id" class="form-control @error('campus_id') is-invalid @enderror">
                                        <option value="" disabled>Select Campus</option>
                                        @foreach ($campus as $campuses) 
                                            <option value="{{ $campuses->id }}" {{ $campuses->id == $building->campus_id ? 'selected' : '' }}>
                                                {{ $campuses->name }}</option>
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
                                        <option value="" disabled>Select Zone</option>
                                        @foreach ($zone as $zones) 
                                            <option value="{{ $zones->id }}" {{ $zones->id == $building->zone_id ? 'selected' : '' }}>
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
                                    <label class="form-label" for="description">Description <span class="text-danger">*</span></label>
                                    <input class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ $building->description }}">
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
                                        <option value="0" {{ old('active', $building->active) == 'No' ? 'selected':''}} >No</option>
                                        <option value="1" {{ old('active', $building->active) == 'Yes' ? 'selected':''}} >Yes</option>
                                    </select>
                                    @error('active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> *{{ $message }} </strong>
                                    </span>
                                @enderror
                                </div>

                               <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button> 
                                    <a style="margin-right:5px" href="{{ URL::route('building.index') }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a>
                                </div><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script></script>

@endsection
