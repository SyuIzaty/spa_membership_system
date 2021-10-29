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
                                <div class="col-sm-5">
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
                                                        <div class="form-group">
                                                            <td width="25%"><label class="form-label" for="title"> Title:</label></td>
                                                            <td colspan="4">
                                                                <input type="text" id="title" name="title" class="form-control max" value="{{ $data->title }}" required>
                                                                    @error('title')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="25%"><label class="form-label" for="party1"> Engage Party One:</label></td>
                                                            <td colspan="4">
                                                                <input type="text" id="party1" name="party1" class="form-control max" value="{{ isset($data->engage_party_one) ? $data->engage_party_one : 'N/A' }}" required>
                                                                    @error('party1')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <div class="form-group">
                                                            <td width="25%"><label class="form-label" for="party2"> Engage Party Two:</label></td>
                                                            <td colspan="4">
                                                                <input type="text" id="party2" name="party2" class="form-control max" value="{{ isset($data->engage_party_two) ? $data->engage_party_two : 'N/A' }}">
                                                                    @error('party2')
                                                                        <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                                    @enderror
                                                            </td>
                                                        </div>
                                                    </tr>
                                                    <tr>
                                                        <td width="25%"><label class="form-label" for="member"> Team Member:</label></td>
                                                        <td colspan="4"> 
                                                            @php $i = 1; @endphp
                                                            @if ($member->isNotEmpty())
                                                                <ol>
                                                                    @foreach ( $member as $m )
                                                                    <form id="form-id">
                                                                        @csrf
                                                                        <li>
                                                                            <input type="hidden" name="id" value="{{ $data->id }}">

                                                                            &nbsp{{ $m->memberDetails->name }}
                                                                            <button type="submit" class="btn btn-xs btn-danger" data-path="{{ $m->staff_id }}" id="delete"><i class="fal fa-trash"></i></button>
                                                                        </li>
                                                                    </form>
                                                                    @endforeach
                                                                </ol>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                    
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
                                                </thead>
                                            </table>
                                            </div>
                                                <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Update</button>
                                        </div>
                                    </div>    
                                {!! Form::close() !!}
                            </div>
                                <br>
                            <div class="col-sm-7">
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

                                <br>
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
                                                    <th>Attachment</th>
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
                                                </tr>                                                    
                                            </thead>
                                        </table>
                                        </div>
                                        <a href="#" data-target="#crud-modal" data-id="{{$data->id}}" data-toggle="modal" class="btn btn-primary ml-auto float-right" style="margin-top: 15px;"><i class="fal fa-plus-square"></i> Add Progress</a>
                                    </div>

                                </div>
                            </div>
                                   
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="crud-modal" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header">
                                    <h5 class="card-title w-100 text-center ">NEW PROGRESS</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'EngagementManagementController@createProgress', 'method' => 'POST']) !!}
                                    <input type="hidden" name="id" id="id">
                                     
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Remark</span>
                                            </div>
                                            <textarea class="form-control" aria-label="With textarea" name="remark" id="remark" rows="5" cols="40" maxlength="200" required></textarea>
                                        </div>
                                        <span style="font-size: 10px; color: red;"><i>*Limit to 200 characters only</i></span>
                                    </div>   

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

                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="edit" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="card-header">
                                    <h5 class="card-title w-100 text-center ">EDIT PROGRESS</h5>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['action' => 'EngagementManagementController@editProgress', 'method' => 'POST']) !!}
                                    <input type="hidden" name="id" id="id">
                                     
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Remark</span>
                                            </div>
                                            <textarea class="form-control" aria-label="With textarea" name="remark" id="remark" rows="5" cols="40" maxlength="200" required></textarea>
                                        </div>
                                        <span style="font-size: 10px; color: red;"><i>*Limit to 200 characters only</i></span>
                                    </div>   

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Status</span>
                                            </div>
                                            <select class="custom-select form-control" name="status" id="status" required>
                                               @if (isset($status))
                                                    @foreach ( $status as $s )
                                                        <option value="{{$s->id}}">{{$s->description}}</option>
                                                   @endforeach
                                               @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="footer">
                                        <button type="submit" class="btn btn-primary ml-auto float-right"><i class="fal fa-save"></i> Save</button>
                                        <button type="button" class="btn btn-success ml-auto float-right mr-2" data-dismiss="modal"><i class="fal fa-window-close"></i> Close</button>
                                    </div>
                                    {!! Form::close() !!}
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

    $("#delete").on('click', function(e) {
        e.preventDefault();

        let id = $(this).data('path');
        var datas = $('#form-id').serialize();

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
                        type: "POST",
                        url: "/delete-member/" + id,
                        data: datas,
                        dataType: "json",
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

        $('#crud-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id') // data-id

        $('.modal-body #id').val(id);

        });

        $('#edit').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) 
        var id = button.data('id')
        var remark = button.data('remark')
        var status = button.data('status')

        $('.modal-body #id').val(id);
        $('.modal-body #remark').val(remark);
        $('.modal-body #status').val(status);

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
                    { className: 'text-center', data: 'id', name: 'id' },
                    { className: 'text-center', data: 'remark', name: 'remark' },
                    { className: 'text-center', data: 'date', name: 'date' },
                    { className: 'text-center', data: 'status', name: 'status' },
                    { className: 'text-center', data: 'member', name: 'member' },
                    { className: 'text-center', data: 'attachment', name: 'attachment' },
                    { className: 'text-center', data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                orderCellsTop: true,
                "order": [[ 0, "asc" ]],
                "initComplete": function(settings, json) {

                }
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
