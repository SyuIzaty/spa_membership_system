@extends('layouts.admin')

@section('content')

<style>
    #delete{
        display: none;
    }

    li:hover #delete {
        display:inline;  
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
                        <h2>Edit Progress</h2>
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
                                        {!! Form::open(['action' => 'EngagementManagementController@editProgress', 'method' => 'POST']) !!}
                                        <input type="hidden" name="id" id="id" value="{{ $progress->id }}">
                                    
                                        <div class="card card-primary card-outline">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="card-title w-100"><i class="fal fa-clipboard-list width-2 fs-xl"></i>DETAILS</h5>  
                                            </div>
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
                                                                    <textarea value="{{ old('content') }}" class="form-control summernote" id="content" name="content">{{$progress->content}}</textarea>                                        
                                                                </div>
                                                            </div>   
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">Remark</span>
                                                                        </div>
                                                                        <input class="form-control" type="text" name="remark" value="{{ $progress->remark }}"></input>
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
                                                                            @foreach ( $status as $s )
                                                                                <option value="{{ $s->id }}" {{ $s->id == $progress->status ? 'selected' : '' }}>{{ $s->description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>                                                        
                                                            </tr>
                                                        </thead>
                                                        @if (!isset($eStatus))
                                                            @if ($progress->created_by == $user)
                                                              <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                                            @endif
                                                        @endif
                                                        {!! Form::close() !!}    
                                                        <a style="margin-right:5px" href="/engagement-detail/{{$progress->engagement_id}}" class="btn btn-info ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a>                                            
                                                    </table>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>  
                                </div>
                                <div class="row" style="margin-bottom:15px;">   
                                    <div class="col-md-12">
                                        @if (!isset($eStatus))
                                        @if ($progress->created_by == $user)
                                        <div class="row mt-5">
                                            <div class="col-md-6">
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header bg-info text-white">
                                                        <h5 class="card-title w-100"><i class="fal fa-file width-2 fs-xl"></i>UPLOAD FILES</h5>                                            
                                                    </div>
                                                        
                                                    <div class="card-body">
                                                        <form method="post" action="{{url('store-files')}}" enctype="multipart/form-data" class="dropzone needsclick dz-clickable" id="dropzone">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$progress->id}}">
                                                            <div class="dz-message needsclick">
                                                                <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                                                                <span class="text-uppercase">Drop files here or click to upload.</span>
                                                                <br>
                                                                <span class="fs-sm text-muted">This is a dropzone. Selected files <strong>.pdf,.doc,.docx,.jpeg,.jpg,.png</strong> are actually uploaded.</span>
                                                            </div>
                                                        </form>   
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card card-primary card-outline">
                                                    <div class="card-header bg-info text-white">
                                                        <h5 class="card-title w-100"><i class="fal fa-file width-2 fs-xl"></i>FILE LIST</h5>                                            
                                                    </div>
                                                        
                                                    <div class="card-body">
                                                        <ol>
                                                            @foreach ( $file as $f )
                                                                <li>
                                                                    <a target="_blank" href="/get-uploaded-file/{{$f->id}}">{{$f->upload}}</a>
                                                                    <a href="#" data-path ="{{$f->id}}" class="btn btn-danger btn-xs delete-alert" id="delete"><i class="fal fa-trash"></i></a>
                                                                </li>
                                                                <br>
                                                            @endforeach
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <br>
                                        <div class="card card-primary card-outline">
                                            <div class="card-header bg-info text-white">
                                                <h5 class="card-title w-100"><i class="fal fa-file width-2 fs-xl"></i>FILE LIST</h5>                                            
                                            </div>
                                                
                                            <div class="card-body">
                                                <ol>
                                                    @foreach ( $file as $f )
                                                        <li>
                                                            <a target="_blank" href="/get-uploaded-file/{{$f->id}}">{{$f->upload}}</a>
                                                            @if ($progress->created_by == $user)
                                                                <a href="#" data-path ="{{$f->id}}" class="btn btn-danger btn-xs delete-alert" id="delete"><i class="fal fa-trash"></i></a>                                                        
                                                            @endif
                                                        </li>
                                                        <br>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                        </div>
                    </div>                       
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>
        
        Dropzone.autoDiscover = false;

       $(document).ready(function() {
            $('.member').select2();

            $('.summernote').summernote({
            height: 200,
            width: 1100,
            spellCheck: true
            
        });

    $("#dropzone").dropzone({
        addRemoveLinks: true,
        maxFiles: 10, //change limit as per your requirements
        dictMaxFilesExceeded: "Maximum upload limit reached",
        init: function () {
            this.on("queuecomplete", function (file) {
            location.reload();
            });
        },
    });

    $(".delete-alert").on('click', function(e) {

        let id = $(this).data('path');

            Swal.fire({
                title: 'Delete?',
                text: "Data cannot be restored!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'No'
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: "DELETE",
                        url: "/delete-file/" + id,
                        data: id,
                        dataType: "json",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                        console.log(response);
                        if(response){
                        Swal.fire(response.success);
                        location.reload();
                    }
                        }
                    });
                }
                else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        });


        });



</script>

@endsection
