@extends('layouts.admin')

@section('content')
    
<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-users'></i> ENGAGEMENT MANAGEMENT
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Create New Progress</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                                <div class="row">
                                    <div class="col-sm-12">
                                    {!! Form::open(['action' => 'EngagementManagementController@createProgress', 'method' => 'POST']) !!}
                                    <input type="hidden" name="id" id="id" value="{{ $data->id }}">

                                        <div class="card card-primary card-outline">
                                            <!-- <div class="card-header bg-primary text-white">
                                                <h5 class="card-title w-100 text-center">PROFILE</h5>
                                            </div> -->
                                            <div class="card-body">
                                                @if (Session::has('message'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Content</span>
                                                                </div>
                                                                <textarea value="{{ old('content') }}" class="form-control summernote" id="content" name="content"></textarea>                                        
                                                            </div>
                                                        </div>   
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Remark</span>
                                                                    </div>
                                                                    <input class="form-control" type="text" name="remark"></input>
                                                                </div>
                                                            </div>                                                           
                                                        </tr>
                                                        <tr>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status</span>
                                                                    </div>
                                                                    <select class="custom-select form-control" name="status" id="status" required>
                                                                        <option disabled selected>Please Select Status</option>
                                                                    @if (isset($status))
                                                                            @foreach ( $status as $s )
                                                                                <option value="{{$s->id}}">{{$s->description}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                    </select>
                                                                </div>
                                                            </div>                                                        
                                                        </tr>
                                                    </thead>
                                                </table>
                                                </div>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                            </div>
                                        </div>    
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <br>
                        </div>
                    </div>                       
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>
       $(document).ready(function() {
            $('.member').select2();
        });

        $('.summernote').summernote({
            height: 200,
            width: 1100,
            spellCheck: true
        });
</script>

@endsection
