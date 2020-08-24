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
            <i class='subheader-icon fal fa-plus-circle'></i> Campus Registration
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
                        Register <span class="fw-300"><i>Campus</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                      
                        <form action="{{ route('campus.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <p><span class="text-danger">*</span> Required fields</p>
                              <table id="campus" class="table table-bordered table-hover table-striped w-100">
                                <thead>

                                    <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="code">Code <span class="text-danger">*</span></label></td>
                                        <td colspan="2"><input value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" id="code" name="code">
                                            @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                            @enderror</td>
                                            
                                        <td width="15%"><label class="form-label" for="name">Name <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><input value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                            @enderror</td>
                                    </div>
                                    </tr>

                                    {{-- <tr>
                                    <div class="form-group">
                                        <td width="21%"><label class="form-label" for="name">Name <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><input value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name"></td>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                    </div>
                                    </tr> --}}

                                    <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="description">Description <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><input value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                        <!-- sent message error input -->
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                        @enderror</td>
                                        <!-- end sent message error input -->
                                    </div>
                                    </tr>

                                    <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="address1">Address 1 <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><input value="{{ old('address1') }}" class="form-control @error('address1') is-invalid @enderror" id="address1" name="address1">
                                        @error('address1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror</td>
                                    </div>
                                    </tr>

                                    <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="address2">Address 2</label></td>
                                        <td colspan="10"><input value="{{ old('address2') }}" class="form-control @error('address2') is-invalid @enderror" id="address2" name="address2">
                                            @error('address2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror</td>
                                    </div>
                                    </tr>
                                    
                                    <tr>
                                    <div class="form-group">
                                        <td width="10%"><label class="form-label" for="postcode">Postcode <span class="text-danger">*</span></label></td>
                                        <td colspan="2"><input value="{{ old('postcode') }}" class="form-control @error('postcode') is-invalid @enderror" id="postcode" name="postcode">
                                            @error('postcode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror</td>
                                        <td width="10%"><label class="form-label" for="city">City <span class="text-danger">*</span></label></td>
                                        <td colspan="2"><input value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" id="city" name="city">
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror</td>
                                        <td width="10%"><label class="form-label" for="state_id">State <span class="text-danger">*</span></label></td>
                                        <td colspan="2"><select id="state_id" name="state_id" class="form-control @error('state_id') is-invalid @enderror">
                                            <option value="">-- Select State --</option>
                                            <option value="Johor" {{ old('state_id') == 'Johor' ? 'selected':''}}>Johor</option>
                                            <option value="Kedah" {{ old('state_id') == 'Kedah' ? 'selected':''}}>Kedah</option>
                                            <option value="Kelantan" {{ old('state_id') == 'Kelantan' ? 'selected':''}}>Kelantan</option>
                                            <option value="Melaka" {{ old('state_id') == 'Melaka' ? 'selected':''}}>Melaka</option>
                                            <option value="Negeri Sembilan" {{ old('state_id') == 'Negeri Sembilan' ? 'selected':''}}>Negeri Sembilan</option>
                                            <option value="Pahang" {{ old('state_id') == 'Pahang' ? 'selected':''}}>Pahang</option>
                                            <option value="Pulau Pinang" {{ old('state_id') == 'Pulau Pinang' ? 'selected':''}}>Pulau Pinang</option>
                                            <option value="Perak" {{ old('state_id') == 'Perak' ? 'selected':''}}>Perak</option>
                                            <option value="Perlis" {{ old('state_id') == 'Perlis' ? 'selected':''}}>Perlis</option>
                                            <option value="Selangor" {{ old('state_id') == 'Selangor' ? 'selected':''}}>Selangor</option>
                                            <option value="Terengganu" {{ old('state_id') == 'Terengganu' ? 'selected':''}}>Terengganu</option>
                                            <option value="Sabah" {{ old('state_id') == 'Sabah' ? 'selected':''}}>Sabah</option>
                                            <option value="Sarawak" {{ old('state_id') == 'Sarawak' ? 'selected':''}}>Sarawak</option>
                                            <option value="Wilayah Persekutuan Kuala Lumpur" {{ old('state_id') == 'Wilayah Persekutuan Kuala Lumpur' ? 'selected':''}}>Wilayah Persekutuan Kuala Lumpur</option>
                                            <option value="Wilayah Persekutuan Labuan" {{ old('state_id') == 'Wilayah Persekutuan Labuan' ? 'selected':''}}>Wilayah Persekutuan Labuan</option>
                                            <option value="Wilayah Persekutuan Putrajaya" {{ old('state_id') == 'Wilayah Persekutuan Putrajaya' ? 'selected':''}}>Wilayah Persekutuan Putrajaya</option>
                                        </select>
                                            @error('state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                            @enderror</td>
                                    </div>
                                    </tr>
                                    
                                    {{-- <tr>
                                    <div class="form-group">
                                        <td width="21%"><label class="form-label" for="city">City <span class="text-danger">*</span></label></td>
                                        <td colspan="2"><input value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" id="city" name="city"></td>
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror
                                    </div>
                                    </tr>

                                    <tr>
                                    <div class="form-group">
                                        <td width="21%"><label class="form-label" for="state_id">State <span class="text-danger">*</span></label></td>
                                        <td colspan="2"><select id="state_id" name="state_id" class="form-control @error('state_id') is-invalid @enderror">
                                            <option value="">Please Select</option>
                                            <option value="Johor" {{ old('state_id') == 'Johor' ? 'selected':''}}>Johor</option>
                                            <option value="Kedah" {{ old('state_id') == 'Kedah' ? 'selected':''}}>Kedah</option>
                                            <option value="Kelantan" {{ old('state_id') == 'Kelantan' ? 'selected':''}}>Kelantan</option>
                                            <option value="Melaka" {{ old('state_id') == 'Melaka' ? 'selected':''}}>Melaka</option>
                                            <option value="Negeri Sembilan" {{ old('state_id') == 'Negeri Sembilan' ? 'selected':''}}>Negeri Sembilan</option>
                                            <option value="Pahang" {{ old('state_id') == 'Pahang' ? 'selected':''}}>Pahang</option>
                                            <option value="Pulau Pinang" {{ old('state_id') == 'Pulau Pinang' ? 'selected':''}}>Pulau Pinang</option>
                                            <option value="Perak" {{ old('state_id') == 'Perak' ? 'selected':''}}>Perak</option>
                                            <option value="Perlis" {{ old('state_id') == 'Perlis' ? 'selected':''}}>Perlis</option>
                                            <option value="Selangor" {{ old('state_id') == 'Selangor' ? 'selected':''}}>Selangor</option>
                                            <option value="Terengganu" {{ old('state_id') == 'Terengganu' ? 'selected':''}}>Terengganu</option>
                                            <option value="Sabah" {{ old('state_id') == 'Sabah' ? 'selected':''}}>Sabah</option>
                                            <option value="Sarawak" {{ old('state_id') == 'Sarawak' ? 'selected':''}}>Sarawak</option>
                                            <option value="Wilayah Persekutuan Kuala Lumpur" {{ old('state_id') == 'Wilayah Persekutuan Kuala Lumpur' ? 'selected':''}}>Wilayah Persekutuan Kuala Lumpur</option>
                                            <option value="Wilayah Persekutuan Labuan" {{ old('state_id') == 'Wilayah Persekutuan Labuan' ? 'selected':''}}>Wilayah Persekutuan Labuan</option>
                                            <option value="Wilayah Persekutuan Putrajaya" {{ old('state_id') == 'Wilayah Persekutuan Putrajaya' ? 'selected':''}}>Wilayah Persekutuan Putrajaya</option>
                                        </select></td>
                                        @error('state_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong> *{{ $message }} </strong>
                                        </span>
                                        @enderror
                                    </div>
                                    </tr> --}}

                                    <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="active">Active <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
                                            <option value="">-- Select Active Status --</option>
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
                                    
                                </thead>
                            </table>
                                {{-- <button type="submit" class="btn btn-primary btn-sm">Save</button> --}}
                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                <a style="margin-right:5px" href="{{ URL::route('campus.index') }}" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@section('script')

{{-- <script>

    $.ajax{{
        type:'get',
        url:'{!!URL::to('findsubact')!!}',
        data:{'id':mainactid},
        success:function(data)
        {
            op+='<option value="">-- Sila Pilih Sub Aktiviti --</option>';
            for (var i=0; i<data.length; i++)
            {
                var selected = (data[i].id=="{{old('subact_id', $rpa->subact_id)}}") ? "selected='selected'" : '';
                op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].subactname+'</option>';
            }

            $('.subactname').html(op);
        },
        error:function(){
            console.log('success');
        },
    }};
    
</script> --}}

@endsection
