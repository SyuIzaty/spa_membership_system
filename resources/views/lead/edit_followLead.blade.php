@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Edit Follow Up <span class="fw-300"><i>by {{ $leadNote->follow_type_id}} [ {{ $leadNote->follow_date}} ]</i></span>
        </h1>
    </div>
    <div class="row">

        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        
                        {!! Form::open(['action' => ['LeadController@updateEditFollow'], 'method' => 'POST'])!!}
                        {{Form::hidden('id', $leadNote->id)}}
                              <table id="edit_followup" class="table table-bordered table-hover table-striped w-100">
                                <thead>

                                    <tr>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="follow_type_id"> Follow Up Type :</label></td>
                                            <td colspan="1">
                                                <select name="follow_type_id" id="follow_type_id" class="follow_type_id form-control" style="pointer-events: none;" readonly>
                                                    <option value="">-- Select Follow Up Type --</option>
                                                    @foreach ($followType as $type) 
                                                        <option value="{{ $type->id }}" {{ $leadNote->follow_type_id == $type->id ? 'selected="selected"' : '' }}>
                                                            {{ $type->follow_name }}</option>
                                                    @endforeach
                                                 </select>
                                            </td>
                                            <td width="15%"><label class="form-label" for="follow_remark"> Content / Remarks :</label></td>
                                            <td colspan="6">
                                            <textarea class="form-control @error('follow_remark') is-invalid @enderror" id="follow_remark" name="follow_remark" value="{{ old('follow_remark')}}" rows="10">{{ $leadNote->follow_remark }}</textarea>
                                                @error('follow_remark')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong> *{{ $message }} </strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </div>
                                    </tr>

                                    <tr>
                                        <div class="form-group">
                                            <td width="15%"><label class="form-label" for="status_id"> Lead Status :</label></td>
                                            <td colspan="5">
                                                <select class="form-control" name="status_id" id="status_id" style="pointer-events: none;" readonly>
                                                    <option value="">-- Select Status --</option>
                                                        @foreach($status as $stat)
                                                            <option value="{{$stat->status_code}}"  {{ $leadNote->status_id == $stat->status_code ? 'selected="selected"' : '' }}>
                                                                {{$stat->status_name}}</option>
                                                        @endforeach
                                                            @error('status_id')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                </select>
                                            </td>
                                            <td width="15%"><label class="form-label" for="follow_date"> Date | Time :</label></td>
                                            <td colspan="2"><input type="datetime_local" value="{{ date('Y-m-d | h:i A', strtotime($leadNote->follow_date)) }}" class="form-control @error('follow_date') is-invalid @enderror" id="follow_date" name="follow_date" style="pointer-events: none;" readonly>
                                                @error('follow_date')
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
                            <a style="margin-right:5px" href="/lead/follow_lead/{{$leadNote->leads_id}}" class="btn btn-success ml-auto float-right"><i class="fal fa-angle-double-left"></i> Back</a><br><br>
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
