@extends('layouts.admin')

@section('content')
<style>
    .select2-selection--single {
        height: 100% !important;
    }
    .select2-selection__rendered{
        word-wrap: break-word ;
        text-overflow: inherit;
        white-space: normal !important;
    }
</style>
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
                        <h2>Create New Profile</h2>
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
                                        {!! Form::open(['action' => ['EngagementManagementController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                        <div class="card card-primary card-outline">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title w-100 text-center">PROFILE</h5>
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('message'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100" id="addorg">
                                                        <thead>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="title"><span class="text-danger">*</span><b> Title</b></label></td>
                                                                    <td colspan="4">
                                                                        <input type="text" id="title" name="title" class="form-control" value="{{old('title')}}" required>
                                                                            @error('title')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="member"><span class="text-danger">*</span><b> Team Member</b></label></td>
                                                                    <td colspan="4">
                                                                    <select class="form-control member" name="member_id[]" multiple required>
                                                                        @foreach ($user as $u)
                                                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                                        @endforeach
                                                                    </select>                                                                    
                                                                        @error('member')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td width="15%"><label class="form-label" for="engage1"><span class="text-danger">*</span><b> Organization 1</b></label></td>
                                                                    <td>
                                                                        <label class="form-label" for="name1"> Name:</label>
                                                                        <input type="text" id="name1" name="name1" class="form-control"  value="{{old('name1')}}" required>
                                                                            @error('name1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                    <td>
                                                                        <label class="form-label" for="email1"> Email:</label>
                                                                        <input type="text" id="email1" name="email1" class="form-control"  value="{{old('email1')}}" required>
                                                                            @error('email1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                    <td>
                                                                        <label class="form-label" for="phone1"> Phone Number:</label>
                                                                        <input type="text" id="phone1" name="phone1" class="form-control"  value="{{old('phone1')}}" required>
                                                                            @error('phone1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                    <td>
                                                                        <label class="form-label" for="designation1"> Designation:</label>
                                                                        <input type="text" id="designation1" name="designation1" class="form-control"  value="{{old('designation1')}}" required>
                                                                            @error('designation1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                        <br>
                                                                            <button type="button" id ="btn1" class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed float-right"><i class="fal fa-plus"></i></button>                                                    
                                                                    </td>  
                                                                </div>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                                <br>
                        </div>
                    </div>   
                    <div class="panel-container show">
                        <div class="panel-content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title w-100 text-center">TO DO LIST
                                                    <span>
                                                        <button type="button" style="margin-left: 5px;" id ="btn2" class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed"><i class="fal fa-plus"></i></button>
                                                    </span>
                                                </h5>                                            
                                            </div>
                                            <div class="card-body">
                                                @if (Session::has('message'))
                                                    <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table class="table table-borderless table-hover table-striped w-100" id="addtodo">
                                                    
                                                    </table>                                                
                                                </div>
                                            </div>
                                        </div>    
                                        
                                    </div>
                                </div>
                                <br>
                        </div>
                    </div>  
                    <button type="submit" class="btn btn-primary ml-auto" style="margin-right: 20px; margin-bottom: 20px;"><i class="fal fa-save"></i> Save</button>
                    {!! Form::close() !!}                     
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>
       $(document).ready(function() {
            $('.member').select2();
            
            $('#btn1').click(function(){
                i++;
                $('#addorg').append(`
                <tr id="row${i}">
                    <div class="form-group">
                        <td width="15%"><label class="form-label" for="engage2"><b>Organization ${i}</b></label></td>
                        <td>
                            <label class="form-label" for="name2"> Name:</label>
                            <input type="text" id="name2" name="names[]" class="form-control"  value="{{old('name2')}}">
                                @error('name2')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                        </td>
                        <td>
                            <label class="form-label" for="email2"> Email:</label>
                            <input type="text" id="email2" name="email[]" class="form-control"  value="{{old('email2')}}">
                                @error('email2')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                        </td>
                        <td>
                            <label class="form-label" for="phone2"> Phone Number:</label>
                            <input type="text" id="phone2" name="phone[]" class="form-control"  value="{{old('phone2')}}">
                                @error('phone2')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                        </td>
                        <td>
                            <label class="form-label" for="designation2"> Designation:</label>
                            <input type="text" id="designation2" name="designation[]" class="form-control"  value="{{old('designation2')}}">
                                @error('designation2')
                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                @enderror
                                <br>
                                <button type="button" id="${i}" class="btn_remove btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed float-right"><i class="fal fa-times"></i></button>
                        </td>                                                        
                    </div>
                </tr>`);
        });

        var i=1;
        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $('#btn2').click(function(){
            i++;
            $('#addtodo').append(`
            <tr id="row${i}">
                <td>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="todolist[]" id="todolist">
                        <div class="input-group-append">
                            <button class="btn_removeToDo btn btn-danger btn-sm btn-icon" id="${i}" type="button"><i class="fal fa-times"></i></button>
                        </div>
                    </div>
                </td>
            </tr>`);
    });

        var i=1;
        $(document).on('click', '.btn_removeToDo', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

});




</script>

@endsection
