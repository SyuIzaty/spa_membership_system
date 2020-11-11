@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Edit Group List<span class="fw-300"><i></i></span>
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Update <span class="fw-300"><i> {{ $group->group_name}}</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        
                        {!! Form::open(['action' => ['LeadController@updateGroup'], 'method' => 'POST'])!!}
                        {{Form::hidden('id', $group->id)}}
                              <table id="edit_group" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <p><span class="text-danger">*</span> Required fields</p>
                                    <tr>
                                        <div class="form-group">   
                                            <td width="15%"><label class="form-label" for="group_code"><span class="text-danger">*</span> Group Code</label></td>
                                                <td colspan="3"><input class="form-control" id="group_code" name="group_code" value="{{ $group->group_code }}">
                                                    @error('group_code')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                            <td width="15%"><label class="form-label" for="group_name"><span class="text-danger">*</span> Group Name</label></td>
                                                <td colspan="3"><input class="form-control" id="group_name" name="group_name" value="{{ $group->group_name }}">
                                                    @error('group_name')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                                </td>
                                        </div>
                                    </tr>    

                                    <tr>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="group_desc">Description :</label></td>
                                            <td colspan="3">
                                            <textarea class="form-control @error('group_desc') is-invalid @enderror" id="group_desc" name="group_desc" value="{{ old('group_desc')}}" rows="10">{{ $group->group_desc }}</textarea>
                                                @error('group_desc')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> *{{ $message }} </strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td width="15%"><label class="form-label" for="group_status">Group Status :</label></td>
                                            <td colspan="3">
                                                <select class="form-control" id="group_status" name="group_status">
                                                    <option value="">-- Select Status --</option>
                                                    <option value="1" {{ old('group_status', $group->group_status) == '1' ? 'selected':''}} >Active</option>
                                                    <option value="0" {{ old('group_status', $group->group_status) == '0' ? 'selected':''}} >Inactive</option>
                                                </select>
                                                    @error('group_status')
                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                    @enderror
                                            </td>
                                        </div>
                                    </tr>
                                    
                                </thead>
                            </table>

                            <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                            <a style="margin-right:5px" href="/lead/group_list" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
                        {!! Form::close() !!}  
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@section('script')

@endsection
