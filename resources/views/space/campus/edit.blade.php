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
            <i class='subheader-icon fal fa-plus-circle'></i> Campus Information Update
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
                        Update <span class="fw-300"><i>Campus {{ $campus->name }}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('campus.update',$campus->id) }}" enctype="multipart/form-data" method="POST">
                            @method('PUT')
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="form-label" for="code">Code</label>
                                    <input class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ $campus->code }}">
                                        @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $campus->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="description">Description</label>
                                    <input class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ $campus->description }}">
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="address1">Address 1</label>
                                    <input class="form-control @error('address1') is-invalid @enderror" id="address1" name="address1" value="{{ $campus->address1 }}">
                                        @error('address1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="address2">Address 2</label>
                                    <input class="form-control @error('address2') is-invalid @enderror" id="address2" name="address2" value="{{ $campus->address2 }}">
                                        @error('address2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="postcode">Postcode</label>
                                    <input class="form-control @error('postcode') is-invalid @enderror" id="postcode" name="postcode" value="{{ $campus->postcode }}">
                                        @error('postcode')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="city">City</label>
                                    <input class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ $campus->city }}">
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="state_id">State</label>
                                    <select class="form-control" id="state_id" name="state_id" class="form-control @error('state_id') is-invalid @enderror">
                                        <option value="">Please Select</option>
                                        <option value="Johor" {{ old('state_id', $campus->state_id) == 'Johor' ? 'selected':''}}>Johor</option>
                                        <option value="Kedah" {{ old('state_id', $campus->state_id) == 'Kedah' ? 'selected':''}}>Kedah</option>
                                        <option value="Kelantan" {{ old('state_id', $campus->state_id) == 'Kelantan' ? 'selected':''}}>Kelantan</option>
                                        <option value="Melaka" {{ old('state_id', $campus->state_id) == 'Melaka' ? 'selected':''}}>Melaka</option>
                                        <option value="Negeri Sembilan" {{ old('state_id', $campus->state_id) == 'Negeri Sembilan' ? 'selected':''}}>Negeri Sembilan</option>
                                        <option value="Pahang" {{ old('state_id', $campus->state_id) == 'Pahang' ? 'selected':''}}>Pahang</option>
                                        <option value="Pulau Pinang" {{ old('state_id', $campus->state_id) == 'Pulau Pinang' ? 'selected':''}}>Pulau Pinang</option>
                                        <option value="Perak" {{ old('state_id', $campus->state_id) == 'Perak' ? 'selected':''}}>Perak</option>
                                        <option value="Perlis" {{ old('state_id', $campus->state_id) == 'Perlis' ? 'selected':''}}>Perlis</option>
                                        <option value="Selangor" {{ old('state_id', $campus->state_id) == 'Selangor' ? 'selected':''}}>Selangor</option>
                                        <option value="Terengganu" {{ old('state_id', $campus->state_id) == 'Terengganu' ? 'selected':''}}>Terengganu</option>
                                        <option value="Sabah" {{ old('state_id', $campus->state_id) == 'Sabah' ? 'selected':''}}>Sabah</option>
                                        <option value="Sarawak" {{ old('state_id', $campus->state_id) == 'Sarawak' ? 'selected':''}}>Sarawak</option>
                                        <option value="Wilayah Persekutuan Kuala Lumpur" {{ old('state_id', $campus->state_id) == 'Wilayah Persekutuan Kuala Lumpur' ? 'selected':''}}>Wilayah Persekutuan Kuala Lumpur</option>
                                        <option value="Wilayah Persekutuan Labuan" {{ old('state_id', $campus->state_id) == 'Wilayah Persekutuan Labuan' ? 'selected':''}}>Wilayah Persekutuan Labuan</option>
                                        <option value="Wilayah Persekutuan Putrajaya" {{ old('state_id', $campus->state_id) == 'Wilayah Persekutuan Putrajaya' ? 'selected':''}}>Wilayah Persekutuan Putrajaya</option>
                                    </select>
                                        @error('state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="active">Active</label>
                                    <select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
                                        <option value="">Please Select</option>
                                        <option value="0" {{ old('active', $campus->active) == 'No' ? 'selected':''}} >No</option>
                                        <option value="1" {{ old('active', $campus->active) == 'Yes' ? 'selected':''}} >Yes</option>
                                    </select>
                                    @error('active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong> *{{ $message }} </strong>
                                    </span>
                                @enderror
                                </div>

                               <div class="panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted">
                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button> 
                                    <a style="margin-right:5px" href="{{ URL::route('campus.index') }}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a>
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
