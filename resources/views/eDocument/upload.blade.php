@extends('layouts.admin')

@section('content')

<style>
    #buttons{
        display: none;
    }

    li:hover #buttons {
        display:inline;  
    }

    #edit{
        display: none;
    }

    li:hover #edit {
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
                            <div class="col-sm-6">
                                <button class="btn btn-success dropdown-toggle waves-effect waves-themed" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if ($id != '')
                                      {{$getDepartment->name}}

                                    @else
                                        Select Department
                                    @endif
                                </button>
                                <div class="dropdown-menu" style="">
                                    @foreach ($department as $d)
                                        <a  href="/upload/{{$d->id}}" class="dropdown-item" name="list" value="{{$d->id}}">{{$d->name}}</a>
                                    @endforeach                                                                           
                                </div>
                            </div>
                            <br>
                            @if ($id != '')
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
                                                                        {{-- <a target="_blank" href="/get-doc/{{$f->id}}" class="text-info">{{$f->title}}</a> --}}

                                                                        {{-- <label for="{{$f->id}}" class="control-label"><p class="text-info">{{$f->title}}</p></label> --}}
                                                                        {{-- <form id="formID">
                                                                            @csrf --}}
                                                                            <a target="_blank" href="/get-doc/{{$f->id}}" class="text-info">{{$f->title}}</a>
                                                                            <input type="hidden" name="id" value="{{$f->id}}">
                                                                            {{-- <button type="submit" class="btn btn-warning btn-xs submitdata" id="edit"><i class="fal fa-save"></i></button> --}}
                                                                        

                                                                        <a href="#" data-path ="{{$f->id}}" class="btn btn-danger btn-xs delete-alert" id="buttons"><i class="fal fa-trash"></i></a>
                                                                        {{-- <a href="#" target="_blank" href="/get-doc/{{$f->id}}" class="btn btn-primary btn-xs" id="buttons"><i class="fal fa-eye"></i></a> --}}
                                                                        <a href="#" data-toggle="addModal" data-id="{{$f->id}}" data-title="{{$f->title}}" id="buttons" class="btn btn-warning btn-xs editTitle"><i class="fal fa-pencil"></i></a>
                                                                    {{-- </form>   --}}
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
                                            <a style="margin-top: 10px; margin-right: 12px;" href="/index" class="btn btn-info ml-auto float-right"><i class="fal fa-arrow-alt-left"></i> Back</a>                                            
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="modal fade" id="addModal" aria-hidden="true" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="card-header">
                                            <h5 class="card-title w-100">Edit Title</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form-title">
                                                @csrf
                                            <input type="hidden" name="id" id="id"/>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Title</span>
                                                    </div>
                                                    <input class="form-control"  name="title" id="title">
                                                </div>
                                            </div>
                                                                                                
                                            <div class="footer">
                                                <button type="submit" id="saves" class="btn btn-primary ml-auto float-right waves-effect waves-themed"><i class="fal fa-save"></i> Save</button>
                                                <button type="button" class="btn btn-success ml-auto float-right mr-2 waves-effect waves-themed" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                            </div>
                                        </form>
                                        </div>
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

    $(".editTitle").on('click', function(e) {

        var id = $(this).data('id');
        var title = $(this).data('title');


    $(".modal-body #id").val( id );
    $(".modal-body #title").val( title );


    $('#addModal').modal('show');
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


        //edit title



        
        // $('#edit').click(function() {
        // var text = $('.text-info').text();
        // var input = $('<input id="attribute" type="text" value="' + text + '" />')
        // $('.text-info').text('').append(input);
        // input.select();

        // input.blur(function() {
        // var text = $('#attribute').val();
        // $('#attribute').parent().text(text);
        // $('#attribute').remove();
        // });
        // });


    //     $("#formID").submit(function(e) {
        
    //     e.preventDefault();

    //     $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });

    //     var datas = $(this).serialize();

    //     $.ajax({
    //         type: "POST",
    //         url: "{{ url('update-title')}}",
    //         data: datas,
    //         dataType: "json",
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         success: function(response) {
    //             console.log(response);
    //             if(response){
    //                 Swal.fire(response.success);
    //             }
    //         },
    //         error:function(error){
    //             console.log(error)
    //             alert("Error");
    //         }
    //     });

    // });

    $("#addModal").submit(function(e) {
        
        e.preventDefault();

        var datas = $('#form-title').serialize();

        $.ajax({
            type: "POST",
            url: "{{ url('update-title')}}",
            data: datas,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if(response){
                    $('#addModal').modal('hide');
                    Swal.fire(response.success);
                    location.reload();
                }
            },
            error:function(error){
                console.log(error)
                alert("Error");
            }
        });

    });
});



</script>

@endsection
