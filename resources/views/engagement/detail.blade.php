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

    /* Customize the label (the container) */
    .container {
    position: relative;
    padding-left: 50px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 15px;
    }

    /* Hide the browser's default checkbox */
    .container input[type="checkbox"] {
    display: none
    }

    /* Create a custom checkbox - using ::before */
    .checkmark::before {
    content: "";
    height: 25px;
    width: 25px;
    background-color: #fff;
    border: solid 1px;
    position: absolute;
    left:0;
    top:0;
    /* margin-right: 10px; */
    margin-top: 5px;
    }

    /* Show the checkmark when checked */
    .container input:checked~.checkmark:after {
    display: block;
    left: 9px;
    top: 8px;
    width: 8px;
    height: 14px;
    border: solid #194263;
    border-width: 0 3px 3px 0;
    transform: rotate(45deg);
    content: "";
    position: absolute;
    margin-right: 10px;
    }
    /* strike through the text */
    .container input:checked ~ input {
      text-decoration: line-through
    }

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
            <i class='subheader-icon fal fa-plus-circle'></i> ENGAGEMENT DETAILS
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2 style="font-size: 20px;"></h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>

                    <div class="panel-container show">
                        <div class="panel-content">
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;">
                                    <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-exclamation-circle"></i> {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header text-white bg-dark">
                                            <h5 class="card-title w-100 text-center">Progress Update</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="progress" class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <tr align="center" class="card-header">
                                                            <th style="width: 50px;">No.</th>
                                                            <th>Remark</th>
                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>File</th>
                                                            <th>Member</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        <tbody>
                                                            <tr  align="center"  class="data-row">
                                                                <td class="hasinput"></td>
                                                                <td class="hasinput"></td>
                                                                <td class="hasinput"></td>
                                                                <td class="hasinput"></td>
                                                                <td class="hasinput"></td>
                                                                <td class="hasinput"></td>
                                                                <td class="hasinput"></td>
                                                            </tr>
                                                        </tbody>
                                                    </thead>
                                                </table>
                                            </div>
                                            @if ($data->status != 7)
                                            <a href="/new-progress/{{$data->id}}" class="btn btn-primary ml-auto float-right" style="margin-top: 15px;"><i class="fal fa-plus-square"></i> Add New Progress</a>
                                            @endif
                                        </div>
                                    </div>                                    
                                </div>
                                <br>
                                <div class="col-sm-4">
                                    @role('Engagement (Admin)')
                                            <div class="card card-primary card-outline">
                                                <div class="card-header text-white bg-success">
                                                    <h5 class="card-title w-100 text-center">TO DO LIST
                                                        <span>
                                                            <button type="button" style="margin-left: 5px;" id ="btn1" class="btn btn-sm btn-warning btn-icon rounded-circle waves-effect waves-themed"><i class="fal fa-plus"></i></button>
                                                        </span>
                                                    </h5>
                                                </div>
                                            
                                                <div class="card-body">
                                                    @if (Session::has('messages'))
                                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('messages') }}</div>
                                                    @endif
                                                    <div class="table-responsive">
                                                        {!! Form::open(['action' => ['EngagementManagementController@updateToDoList'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                                        <input type="hidden" name="idEngage" value="{{ $data->id }}">
                                                            <table class="table table-borderless table-hover table-striped w-100" id="addtodo">
                                                                @if ($todo->isNotEmpty())
                                                                    @foreach ($todo as $t )
                                                                        <tr>
                                                                            <td>
                                                                                <label class="container">    
                                                                                    {{-- <input type="checkbox" name="check" value="{{ $t->id }}" onClick="this.form.submit()" @if ($t->active == 'N') checked @endif/> --}}
                                                                                    {{-- <input type="hidden" name="checkboxName[]" value="0|{{$t->id}}"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value" @if ($t->active == 'N') checked @endif> --}}
                                                                                    <input type="hidden" name="id[{{ $t->id }}]" value="{{ $t->id }}"/>
                                                                                    <input type="checkbox" name="check[{{ $t->id }}]" value="{{ $t->id }}" @if ($t->active == 'Y') checked @endif/>
                                                                                    <input type="text" class="form-control" name="content[{{ $t->id }}]" value="{{$t->title}}">
                                                                                    <div class="form-status-holder"></div>
                                                                                    <span class="checkmark"></span>
                                                                                </label>
                                                                            </td>
                                                                            <td><a href="#" data-path ="{{$t->id}}" class="btn_delete btn btn-danger btn-sm btn-icon"><i class="fal fa-times"></i></a></td>
                                                                        </tr>
                                                                    @endforeach
                                                                    
                                                                @endif
                                                            </table>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                                    {!! Form::close() !!}
                                                </div>
                                            </div> 
                                           
                                    @endrole
                                    <br>
                                </div>
                            </div>
                            {!! Form::open(['action' => ['EngagementManagementController@updateProfile'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                                        <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                        <div class="card card-primary card-outline">
                                            <div class="card-header text-white bg-primary">
                                                <h5 class="card-title w-100 text-center">PROFILE</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="5"><b>TITLE</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">
                                                                    <input type="text" id="title" name="title" class="form-control" value="{{ $data->title }}" required>
                                                                        @error('title')
                                                                            <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                        @enderror
                                                                </td>
                                                            </tr>
                                                            
                                                            
                                                            @php $i = 1; @endphp
                                                            @if ($org->isNotEmpty())
                                                                @foreach ( $org as $o)                                                                
                                                                    <tr>
                                                                        <td width="15%"><label class="form-label" for="engage1"><span class="text-danger">*</span><b> Organization {{$i}}</b></label></td>
                                                                        <input type="hidden" name="ids[]" value="{{ $o->id }}">
                                                                    </tr>
                                                                    <tr>    
                                                                            <td>
                                                                                <label class="form-label" for="name"> Name:</label>
                                                                                <input type="text" id="name" name="name[]" class="form-control"  value="{{ $o->name }}" required>
                                                                                    @error('name')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                            </td>
                                                                    
                                                                            <td>
                                                                                <label class="form-label" for="contact"> Contact Number:</label>
                                                                                <input type="text" id="contact" name="phone[]" class="form-control"  value="{{ $o->phone }}" required>
                                                                                    @error('contact')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                            </td>
                                                                        
                                                                        
                                                                            <td>
                                                                                <label class="form-label" for="email"> Email:</label>
                                                                                <input type="text" id="email" name="email[]" class="form-control"  value="{{ $o->email }}" required>
                                                                                    @error('email')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                            </td>
                                                                            <td>
                                                                                <label class="form-label" for="designation"> Designation:</label>
                                                                                <input type="text" id="designation" name="designation[]" class="form-control"  value="{{ $o->designation }}" required>
                                                                                    @error('designation')
                                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                    @enderror
                                                                            </td>
                                                                    
                                                                    </tr>
                                                                    @php $i++ @endphp
                                                                @endforeach
                                                            @endif
                                                            <tr>
                                                                <td colspan="5"><b>TEAM MEMBER</b></td>
                                                            </tr>
                                                            <tr>                                                            
                                                                <td colspan="5"> 
                                                                    @if ($member->isNotEmpty())
                                                                        <ol>
                                                                            @foreach ( $member as $m )
                                                                                <li>
                                                                                    &nbsp{{ $m->memberDetails->name }}
                                                                                    <a href="#" data-path ="{{$m->id}}" class="btn btn-danger btn-xs delete-alert" id="delete"><i class="fal fa-trash"></i></a>                                                        
                                                                                </li>
                                                                            </form>
                                                                            @endforeach
                                                                        </ol>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @if ($data->status != 7)
                                                                @role('Engagement (Admin)')
                                                                    <tr>
                                                                        <div class="form-group">
                                                                            <td width="25%"><label class="form-label" for="member">Add Team Member:</label></td>
                                                                            <td colspan="4">
                                                                            <select class="form-control memberList" name="member_id[]" multiple>
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
                                                                @endrole
                                                            @endif
                                                        </thead>
                                                    </table>
                                                </div>
                                                @if ($data->status != 7)
                                                    @role('Engagement (Admin)')
                                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                                    @endrole
                                                @endif
                                            </div>
                                        </div>    
                                    {!! Form::close() !!}
                        </div>
                    </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>

    $(document).ready(function()
    {
        $('.memberList').select2();

        $('#btn1').click(function()
        {
            i++;
            $('#addtodo').append(`
            <tr id="row${i}">
                <td>
                    <label class="container">                                                                        
                        <input type="checkbox">
                        <input type="text" class="form-control" name="newtodo[]">
                        <div class="form-status-holder"></div>
                        <span class="checkmark"></span>
                    </label>
                </td>
                <td>
                    <button class="btn_remove btn btn-danger btn-sm btn-icon" id="${i}" type="button"><i class="fal fa-times"></i></button>
                </td>
            </tr>`);        
        });

        var i=1;
        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        
    });

    $(function () 
    {
        $('input:checkbox').on('change',  function () {
            var input = $(this).next('span');
            if (this.checked) {
                $(input).css('textDecoration', 'line-through');
            } else {
                $(input).css('textDecoration', 'none');
            }
        })
    })

    $(".delete-alert").on('click', function(e) {
        e.preventDefault();

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
                        url: "/delete-member/" + id,
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

        $(".btn_delete").on('click', function(e) {
        e.preventDefault();

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
                        url: "/delete-todolist/" + id,
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

        var id= @json($data->id);

        var table = $('#progress').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/getProgress/" + id,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            },
            columns: [
                    { className: 'text-center', data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false },
                    { className: 'text-center', data: 'remark', name: 'remark' },
                    { className: 'text-center', data: 'date', name: 'date' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'file', name: 'file' },
                    { className: 'text-center', data: 'member', name: 'member' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
        });

        $('#progress').on('click', '.btn-delete[data-remote]', function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#progress').DataTable().draw(false);
                    });
                }
            })
        });


    // $(document).on('dblclick','li', function(){
    //     // $(this).toggleClass('strike').fadeOut('slow');    
    //   });

</script>
@endsection
