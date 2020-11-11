@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-envelope'></i>Email Blast
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Blast Email <span class="fw-300"><i>Lead</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if (Session::has('message'))
                            <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                        @endif
                        {{-- <form action="{{ route('email') }}" method="POST" enctype="multipart/form-data"> --}}
                            <form action="{{ route('email') }}" method="POST">
                            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                            @csrf
                              <table id="email" class="table table-bordered table-hover table-striped w-100">
                                <thead>
                                    <p><span class="text-danger">*</span> Required fields</p>
                                    <tr>
                                        <div class="form-group">
                                            <td width="10%"><label class="form-label" for="group"><span class="text-danger">*</span> Group :</label></td>
                                            <td colspan="3">
                                                {{-- <input value="{{ old('group') }}" class="form-control" id="group" name="group"> --}}
                                                <select name="group" id="group" class="form-control">
                                                    <option value="">-- Select Group --</option>
                                                        @foreach ($groups as $grp)
                                                            <option value="{{ $grp->id }}" {{ old('group') ? 'selected' : '' }}> {{ $grp->group_name}} </option>
                                                        @endforeach
                                                </select>
                                                @error('group')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                            <td width="10%"><label class="form-label" for="status"><span class="text-danger">*</span> Status :</label></td>
                                            <td colspan="3">
                                                {{-- <input value="{{ old('status') }}" class="form-control" id="status" name="status"> --}}
                                                <select name="status" id="status" class="form-control">
                                                    <option value="">-- Select Status --</option>
                                                        @foreach ($status as $stat)
                                                            <option value="{{ $stat->status_code }}" {{ old('status') ? 'selected' : '' }}> {{ $stat->status_name}} </option>
                                                        @endforeach
                                                </select>
                                                @error('status')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="form-group">
                                            <td width="10%"><label class="form-label" for="email_sub"><span class="text-danger">*</span> Subject :</label></td>
                                            <td colspan="6"><input value="{{ old('email_sub') }}" class="form-control" id="email_sub" name="email_sub">
                                                @error('email_sub')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                    </tr>
                                    <tr>
                                        <div class="form-group">
                                            <td width="10%"><label class="form-label" for="email_cont"><span class="text-danger">*</span> Contents :</label></td>
                                            <td colspan="6"><textarea value="{{ old('email_cont') }}" class="form-control summernote" id="email_cont" name="email_cont"></textarea>
                                                @error('email_cont')
                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                @enderror
                                            </td>
                                        </div>
                                    </tr>
                                </thead>
                            </table>

                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-location-arrow"> Send</i></button>	
                                <button style="margin-right:5px" type="reset" class="btn btn-danger ml-auto float-right"><i class="fal fa-redo"> Reset</i></button>
                                <br><br>
                                
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
    $('.summernote').summernote({
        height: 400
    });
</script>

@endsection
