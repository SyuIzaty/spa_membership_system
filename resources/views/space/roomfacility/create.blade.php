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
            <i class='subheader-icon fal fa-plus-circle'></i> Room Facility Registration
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
                        Register <span class="fw-300"><i>Room Facility</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <form action="{{ route('roomfacility.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p><span class="text-danger">*</span> Required fields</p>
                            <table id="campus" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    
                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="code">Code <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><input value="{{ old('code') }}" class="form-control @error('code') is-invalid @enderror" id="code" name="code">
                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong> *{{ $message }} </strong>
                                                </span>
                                            @enderror</td>
                                    <td width="15%"><label class="form-label" for="name">Name <span class="text-danger">*</span></label></td>
                                    <td colspan="5"><input value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror</td>
                                </div>
                            </tr>

                                <tr>
                                    <div class="form-group">
                                        <td width="15%"><label class="form-label" for="roomtype_id">Room Type <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><select name="roomtype_id" id="roomtype_id" class="roomtype form-control @error('roomtype_id') is-invalid @enderror select2">
                                            <option value="">-- Select Room Type --</option>
                                            @foreach ($roomtype as $roomtype) 
                                                <option value="{{ $roomtype->id }}" {{ old('roomtype_id') ? 'selected' : '' }}>
                                                    {{ $roomtype->name }}</option>
                                            @endforeach
                                         </select>
                                        @error('roomtype_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror</td>

                                        <td width="15%"><label class="form-label" for="roomsuitability_id">Room Suitability <span class="text-danger">*</span></label></td>
                                        <td colspan="5"><select name="roomsuitability_id" id="roomsuitability_id" class="roomsuitability form-control @error('roomsuitability_id') is-invalid @enderror select2">
                                         </select>
                                        @error('roomsuitability_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                        @enderror</td>
                                        
                                    </div>
                                </tr>

                            <tr>
                                <div class="form-group">
                                    <td width="15%"><label class="form-label" for="description">Description <span class="text-danger">*</span></label></td>
                                        <td colspan="10"><input value="{{ old('description') }}" class="form-control @error('description') is-invalid @enderror" id="description" name="description">
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong> *{{ $message }} </strong>
                                            </span>
                                            @enderror
                                        </td>
                                </div>
                            </tr>

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
                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"></i> Reset</button>
                                <a style="margin-right:5px" href="{{ URL::route('roomfacility.index') }}" onclick="return confirm('Are you sure to discard data?')" class="btn btn-success ml-auto float-right"><i class="fal fa-trash-alt"></i> Discard</a><br><br>
                        </form>
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

        // Start for Dynamic Drop down with ajax jquery
        if($('.roomtype').val()!=''){
            UpdateRoomsuitability($('.roomtype'));
        }
        $(document).on('change','.roomtype',function(){
            UpdateRoomsuitability($(this));
        });

        function UpdateRoomsuitability(elem){
        var roomtypeid=elem.val();
        var op=" "; 

        $.ajax({
            type:'get',
            url:'{!!URL::to('findroomsuitability')!!}',
            data:{'id':roomtypeid},
            success:function(data)
            {
                op+='<option value="">-- Please Select Room Suitability --</option>';
                for (var i=0; i<data.length; i++)
                {
                    var selected = (data[i].id=="{{old('roomsuitability_id', $roomfacility->roomsuitability_id)}}") ? "selected='selected'" : '';
                    op+='<option value="'+data[i].id+'" '+selected+'>'+data[i].name+'</option>';
                }

                $('.roomsuitability').html(op);
            },
            error:function(){
                console.log('success');
            },
        });
    }

    })
</script>

@endsection
