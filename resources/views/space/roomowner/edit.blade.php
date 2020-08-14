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
            <i class='subheader-icon fal fa-plus-circle'></i> Room Owner Information Update
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
                        Update <span class="fw-300"><i>Room Owner {{ $roomowner->name }}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('roomowner.update',$roomowner->id) }}" enctype="multipart/form-data" method="POST">
                            @method('PUT')
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $roomowner->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="phone_number">Phone Number</label>
                                    <input class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ $roomowner->phone_number }}">
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $roomowner->email }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="dateofbirth">Date of Birth</label>
                                    <input type="date" class="form-control @error('dateofbirth') is-invalid @enderror" id="dateofbirth" name="dateofbirth" value="{{ $roomowner->dateofbirth }}">
                                        @error('dateofbirth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                        <option value="">Please Select</option>
                                        <option value="male" {{ old('gender', $roomowner->gender) == 'male' ? 'selected':''}}>Male</option>
                                        <option value="female" {{ old('gender', $roomowner->gender) == 'female' ? 'selected':''}}>Female</option>
                                    </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="active">Active</label>
                                    <select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
                                        <option value="">Please Select</option>
                                        <option value="0" {{ old('active', $roomowner->active) == 'No' ? 'selected':''}} >No</option>
                                        <option value="1" {{ old('active', $roomowner->active) == 'Yes' ? 'selected':''}} >Yes</option>
                                    </select>
                                    @error('active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> *{{ $message }} </strong>
                                    </span>
                                @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="image">Image</label>
                                    <div class="col-sm-6"><input type="file" id="image" name="image"></div><br>
                                    <div class="clearfix"></div>
                                    @if($roomowner->image)
                                    <div class="col-md-3"></div>
                                    <div class="col-sm-9">
                                        <img src="{{ asset('storage/space/'.$roomowner->image) }}" style="width: 150px;">
                                    </div>
                                    <div class="clearfix"></div>
                                    @endif
                                  </div>

                               <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button> 
                                    <a style="margin-right:5px" href="{{ URL::route('roomowner.index') }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a>
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
