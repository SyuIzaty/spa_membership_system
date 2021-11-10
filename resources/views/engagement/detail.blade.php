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
                                                                <td colspan="5" class="text-center"><b>TITLE</b></td>
                                                            </tr>
                                                            <tr>
                                                                <div class="form-group">
                                                                    <td colspan="4">
                                                                        <input type="text" id="title" name="title" class="form-control max" value="{{ $data->title }}" required>
                                                                            @error('title')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5" class="text-center"><b>ORGANIZATION ONE</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">Name:</td>
                                                            </tr>
                                                                <div class="form-group">
                                                                    <td colspan="4">
                                                                        <input type="text" id="name1" name="name1" class="form-control" value="{{ $org->whereIn('no', 1)->first()->name }}" required>
                                                                            @error('name1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">Contact Number:</td>
                                                            </tr>
                                                                <div class="form-group">
                                                                    <td colspan="4">
                                                                        <input type="text" id="phone1" name="phone1" class="form-control" value="{{ $org->whereIn('no', 1)->first()->phone }}" required>
                                                                            @error('phone1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">Email:</td>
                                                            </tr>
                                                                <div class="form-group">
                                                                    <td colspan="4">
                                                                        <input type="text" id="email1" name="email1" class="form-control" value="{{ $org->whereIn('no', 1)->first()->email }}" required>
                                                                            @error('email1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5">Designation:</td>
                                                            </tr>
                                                                <div class="form-group">
                                                                    <td colspan="4">
                                                                        <input type="text" id="designation1" name="designation1" class="form-control" value="{{ $org->whereIn('no', 1)->first()->designation }}" required>
                                                                            @error('designation1')
                                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                            @enderror
                                                                    </td>
                                                                </div>
                                                            </tr>
                                                            
                                                            @if (($org->whereIn('no', 2))->isNotEmpty())
                                                                <tr>
                                                                    <td colspan="5" class="text-center"><b>ORGANIZATION TWO</b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">Name:</td>
                                                                </tr>
                                                                    <div class="form-group">
                                                                        <td colspan="4">
                                                                            <input type="text" id="name2" name="name2" class="form-control" value="{{ $org->whereIn('no', 2)->first()->name }}" required>
                                                                                @error('name2')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">Contact Number:</td>
                                                                </tr>
                                                                    <div class="form-group">
                                                                        <td colspan="4">
                                                                            <input type="text" id="phone2" name="phone2" class="form-control" value="{{ $org->whereIn('no', 2)->first()->phone }}" required>
                                                                                @error('phone2')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">Email:</td>
                                                                </tr>
                                                                    <div class="form-group">
                                                                        <td colspan="4">
                                                                            <input type="text" id="email2" name="email2" class="form-control" value="{{ $org->whereIn('no', 2)->first()->email }}" required>
                                                                                @error('email2')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">Designation:</td>
                                                                </tr>
                                                                    <div class="form-group">
                                                                        <td colspan="4">
                                                                            <input type="text" id="designation2" name="designation2" class="form-control" value="{{ $org->whereIn('no', 2)->first()->designation }}" required>
                                                                                @error('designation2')
                                                                                    <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                                @enderror
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="5" class="text-center"><b>TEAM MEMBER</b></td>
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
                                    <br>
                                    @role('Engagement (Admin)')
                                        <form class="savetodolist">
                                            @csrf
                                            <div class="card card-primary card-outline">
                                                <div class="card-header text-white bg-success">
                                                    <h5 class="card-title w-100 text-center">TO DO LIST</h5>
                                                </div>
                                            
                                                <div class="card-body">
                                                    @if (Session::has('messages'))
                                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('messages') }}</div>
                                                    @endif
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless table-hover table-striped w-100">
                                                            <thead>
                                                                <tr>
                                                                    <td>
                                                                        <label class="container">
                                                                            <input type="checkbox">
                                                                            <input type="text" class="form-control max" name="todo" placeholder="Add an item" >
                                                                            <div class="form-status-holder"></div>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>    
                                        </form>
                                    @endrole
                                    <br>
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

    $(document).ready(function() {
        $('.memberList').select2();
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

// var timeoutId;
// $('form input, form textarea').on('input propertychange change', function() {
//     console.log('Textarea Change');
    
//     clearTimeout(timeoutId);
//     timeoutId = setTimeout(function() {
//         // Runs 1 second (1000 ms) after the last change    
//         saveToDB();
//     }, 1000);
// });

// function saveToDB()
// {
//     console.log('Saving to the db');
//     form = $('.savetodolist');
// 	$.ajax({
// 		url: "/todolist-create",
// 		type: "POST",
// 		data: form.serialize(), // serializes the form's elements.
// 		beforeSend: function(xhr) {
//             // Let them know we are saving
// 			$('.form-status-holder').html('Saving...');
// 		},
// 		success: function(data) {
// 			var jqObj = jQuery(data); // You can get data returned from your ajax call here. ex. jqObj.find('.returned-data').html()
//             // Now show them we saved and when we did
//             var d = new Date();
//             $('.form-status-holder').html('Saved! Last: ' + d.toLocaleTimeString());
// 		},
// 	});
// }

// // This is just so we don't go anywhere  
// // and still save if you submit the form
// $('.savetodolist').submit(function(e) {
// 	saveToDB();
// 	e.preventDefault();
// });
</script>
@endsection
