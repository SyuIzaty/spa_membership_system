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
            <i class='subheader-icon fal fa-folder'></i> eDocument Management
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Upload Document</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                                <div class="row" style="margin-bottom:15px;">   
                                    <div class="col-md-12">
                                        <div class="row mt-5">
                                            <div class="col-md-6">
                                                <div class="card card-success card-outline">
                                                    <div class="card-header bg-info text-white">
                                                        <h5 class="card-title w-100"><i class="fal fa-upload width-2 fs-xl"></i>UPLOAD DOCUMENTS</h5>                                            
                                                    </div>
                                                        
                                                    <div class="card-body">
                                                        <form method="post" action="{{url('store-doc')}}" enctype="multipart/form-data" class="dropzone needsclick dz-clickable" id="dropzone">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$id}}">
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
                                                <div class="card card-success card-outline">
                                                    <div class="card-header bg-info text-white">
                                                        <h5 class="card-title w-100"><i class="fal fa-file width-2 fs-xl"></i>FILE LIST</h5>                                            
                                                    </div>
                                                    @if ($file->isNotEmpty())    
                                                        <div class="card-body">
                                                            <ol>
                                                                @foreach ( $file as $f )
                                                                    <li>
                                                                        <a target="_blank" href="/get-doc/{{$f->id}}">{{$f->original_name}}</a>
                                                                        <a href="#" data-path ="{{$f->id}}" class="btn btn-danger btn-xs delete-alert" id="delete"><i class="fal fa-trash"></i></a>
                                                                    </li>
                                                                    <br>
                                                                @endforeach
                                                            </ol>
                                                        </div>
                                                    @else
                                                        <div class="card-body">
                                                            <p class="text-center"><b>NO DOCUMENTS UPLOADED</b></p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <a style="margin-right:5px" href="/get-list/{{$id}}" class="btn btn-info ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a>                                            
                                        </div>
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
                        url: "/delete-doc/" + id,
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
