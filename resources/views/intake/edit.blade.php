@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Intake
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Edit Intake</h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body">
                                {!! Form::open(['action' => ['IntakeController@update', $intake['id']], 'method' => 'POST'])!!}
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Intake Code')}}
                                            {{Form::text('intake_code', $intake->intake_code, ['class' => 'form-control', 'placeholder' => 'Intake Code'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Intake Description')}}
                                            {{Form::text('intake_description', $intake->intake_description, ['class' => 'form-control', 'placeholder' => 'Intake Description'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Start Application Date')}}
                                            {{Form::date('intake_app_open', $intake->intake_app_open, ['class' => 'form-control', 'placeholder' => 'Start Application Date'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Close Application Date')}}
                                            {{Form::date('intake_app_close', $intake->intake_app_close, ['class' => 'form-control', 'placeholder' => 'Close Application Date'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Application Status Start Date')}}
                                            {{Form::date('intake_check_open', $intake->intake_app_open, ['class' => 'form-control', 'placeholder' => 'Start Application Date'])}}
                                        </div>
                                        <div class="form-group col-md-6">
                                            {{Form::label('title', 'Application Status End Date')}}
                                            {{Form::date('intake_check_close', $intake->intake_app_close, ['class' => 'form-control', 'placeholder' => 'Close Application Date'])}}
                                        </div>
                                    </div>
                                    {{Form::hidden('_method', 'PUT')}}
                                    <button class="btn btn-primary">Submit</button>
                                {!! Form::close() !!}
                            <div class="card-body">
                            <div class="form-group">
                                <a class="btn btn-info pull-right" href="javascript:;" data-toggle="modal" id="new">Add Program Info</a>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered table-hover w-100">
                                    <tr class="bg-primary-100 text-center">
                                        <th>PROGRAMME CODE</th>
                                        <th>INTAKE TYPE</th>
                                        <th>BATCH</th>
                                        <th>DATE</th>
                                        <th>TIME</th>
                                        <th>VENUR</th>
                                        <th>STATUS</th>
                                        <th>SUFFICIENT QUOTA</th>
                                        <th>ACTION</th>
                                    </tr>
                                    @foreach($intake_detail as $intake_del)
                                    <tr class="data-row">
                                        <td class="programme_code">{{$intake_del->programme->programme_code}}</td>
                                        <td class="intake_type_code">{{$intake_del->intake_type}}</td>
                                        <td class="batch_code">{{$intake_del->batch_code}}</td>
                                        <td class="intake_date">{{$intake_del->intake_date}}</td>
                                        <td class="intake_time">{{$intake_del->intake_time}}</td>
                                        <td class="intake_venue">{{$intake_del->intake_venue}}</td>
                                        <td>
                                            @if ($intake_del->status == '1') Active @endif
                                            @if ($intake_del->status == '0') Inactive @endif
                                        </td>
                                        <td class="intake_quota">{{$intake_del->intake_quota ? "Yes" : "No"}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{$intake_del->id}}" id="edit">Edit</button>
                                            @if (in_array($intake_del->intake_programme, $offer_intake))
                                                <button class="btn btn-danger btn-sm deleteProgram" data-id="{{$intake_del->id}}" data-action="{{route('deleteProgramInfo', $intake_del->id)}}">Delete</button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="crud-modal" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Add Program Info</h4>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'IntakeController@createProgramInfo', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input name="intake_code" value="{{$intake->id}}" hidden>
                        <div class="form-group">
                            {{Form::label('title', 'Program Code')}}
                            <select name="intake_programme" id="intake_programme" class="form-control">
                                <option disabled selected>Please select</option>
                                @foreach($programme as $programmes)
                                  <option value="{{ $programmes->id }}">{{ $programmes->programme_code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Intake Description')}}
                            {{Form::text('intake_programme_description', '', ['class' => 'form-control', 'placeholder' => 'Intake Description'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Batch Code')}}
                            <select class="form-control" name="batch_code" id="batches_code">
                            </select>
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Intake Type')}}
                            <select name="intake_type" id="intake_type" class="form-control">
                                @foreach($intake_type as $intaketype)
                                  <option value="{{ $intaketype->id }}">{{ $intaketype->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                {{Form::label('title', 'Intake Date')}}
                                {{Form::date('intake_date', '', ['class' => 'form-control', 'placeholder' => 'Intake Date', 'required'])}}
                            </div>
                            <div class="col-md-6">
                                {{Form::label('title', 'Intake Time')}}
                                {{Form::time('intake_time', '', ['class' => 'form-control', 'placeholder' => 'Intake Time', 'required'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'Intake Venue')}}
                            {{Form::text('intake_venue', '', ['class' => 'form-control', 'placeholder' => 'Intake Venue', 'required'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('title', 'File')}}
                            {{Form::file('file[]', ['class' => 'form-control','multiple' => 'multiple', 'accept' => 'application/pdf'])}}
                        </div>
                        <input type="hidden" name="intake_quota" value="1">
                        <div class="footer">
                            <button class="btn btn-primary pull-right">Save</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

           <div class="modal fade" id="editModal" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> Edit Program Info</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['action' => 'IntakeController@updateProgramInfo', 'method' => 'POST', 'id' => 'edit-form', 'enctype' => 'multipart/form-data']) !!}
                            @csrf
                            <input name="id" id="program_id" hidden>
                            <input name="intake_code" value="{{$intake['id']}}" hidden>
                            <div class="form-group">
                                {{Form::label('title', 'Program Code')}}
                                <select name="intake_programme" id="programme_code" class="form-control">
                                    @foreach($intake_detail as $in_prog)
                                        <option value="{{ $in_prog->programme->id }}">{{ $in_prog->programme->programme_code }}</option>
                                    @endforeach
                                    @foreach($programme as $programmes)
                                    <option value="{{ $programmes->id }}">{{ $programmes->programme_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {{Form::label('title', 'Intake Description')}}
                                {{Form::text('intake_programme_description', '', ['id' => 'programme_desc','class' => 'form-control','placeholder' => 'Intake Description'])}}
                            </div>
                                {{Form::hidden('batch_code', '', ['class' => 'form-control', 'id' => 'batch_code' ,'placeholder' => 'Batch Code', 'required'])}}
                            <div class="form-group">
                                {{Form::label('title', 'Intake Type')}}
                                <select name="intake_type" id="intake_type_code" class="form-control">
                                    @foreach($intake_type as $intaketype)
                                      <option value="{{ $intaketype->id }}">{{ $intaketype->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    {{Form::label('title', 'Intake Date')}}
                                    {{Form::date('intake_date', '', ['class' => 'form-control', 'id' => 'intake_date' ,'placeholder' => 'Intake Date', 'required'])}}
                                </div>
                                <div class="col-md-6">
                                    {{Form::label('title', 'Intake Time')}}
                                    {{Form::time('intake_time', '', ['class' => 'form-control', 'id' => 'intake_time' ,'placeholder' => 'Intake Time', 'required'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('title', 'Intake Venue')}}
                                {{Form::text('intake_venue', '', ['class' => 'form-control', 'id' => 'intake_venue' ,'placeholder' => 'Intake Venue', 'required'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('title', 'Sufficient Quota')}}
                                <select name="intake_quota" id="intake_quota" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div id="existfile">

                            </div>
                            <div class="form-group">
                                {{Form::label('title', 'File')}}
                                {{Form::file('file[]', ['class' => 'form-control','multiple' => 'multiple', 'accept' => 'application/pdf'])}}
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.batch').select2();
        });

        $('#new').click(function () {
            $('#crud-modal').modal('show');
        });

        $(document).ready(function () {
            $('#intake_programme').on('change', function() {
                var programme = $(this).val();
                if(programme) {
                    $.ajax({
                        url: '/programme-batch/' + programme,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            if(data) {
                                $('#batch_code').empty();
                                $('#batch_code').focus;
                                $('#batch_code').append('<option value="">Select Batch</option>');
                                $.each(data, function(key, value){
                                    $('select[name="batch_code"]').append('<option value="'+ value.batch_code +'">' + value.batch_code + '</option>');
                                });
                            }else{
                                $('#batches_code').empty();
                            }
                        }
                    });
                }else{
                    $('#batches_code').empty();
                }
            });
        });

        $(document).ready(function() {
            $(document).on('click', "#edit", function() {
                $(this).addClass('edit-item-trigger-clicked');
                var options = {
                    'backdrop': 'static'
                };
                $('#editModal').modal(options)
            })
            $('#editModal').on('show.bs.modal', function() {
                var el = $(".edit-item-trigger-clicked");
                var row = el.closest(".data-row");
                var id = el.data('id');
                var programme_code = row.children(".programme_code").text();
                var programme_desc = row.children(".programme_desc").text();
                var intake_date = row.children(".intake_date").text();
                var intake_time = row.children(".intake_time").text();
                var intake_venue = row.children(".intake_venue").text();
                var intake_type_code = row.children(".intake_type_code").text();
                var batch_code = row.children(".batch_code").text();
                var status = row.children(".status").text();
                var intake_quota = row.children(".intake_quota").text() == "Yes" ? "1" : "0";
                $("#program_id").val(id);
                $("#programme_code").val(programme_code);
                $("#programme_desc").val(programme_desc);
                $("#intake_date").val(intake_date);
                $("#intake_time").val(intake_time);
                $("#intake_venue").val(intake_venue);
                $("#intake_type_code").val(intake_type_code);
                $("#batch_code").val(batch_code);
                $("#status").val(status);
                $('#intake_quota').val(intake_quota).change();

                $.ajax({
                    type: 'GET',
                    url: "{{url('getIntakeFiles')}}/" + batch_code,
                    success: function (respond) {
                        $('#existfile').empty();
                        respond.files.forEach(function(ele){
                            $('#existfile').append(`
                                <div id="attachment${ele.id}">
                                <a href="{{url('storageFile')}}/${ele.file_name}/View" target="_blank">View</a> | <a href="{{url('storageFile')}}/${ele.file_name}/Download">Download</i> | <a href="#" onclick="DeleteFile(${ele.id})">Delete</a> <br/>
                                </div>
                            `);
                        });

                    }
                });
            })
            $('#editModal').on('hide.bs.modal', function() {
                $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
                $("#edit-form").trigger("reset");
            })
        });

        function DeleteFile(Id)
        {
            $.ajax({
                type: 'GET',
                url: "{{url('deleteStorage')}}/" + Id,
                success: function (respond) {
                    $('#attachment'+Id).remove();
                }
            });
        }

        $('.deleteProgram').click(function() {
            console.log('asdaa');
            var id = $(this).data('id');
            var url = '{{route("deleteProgramInfo", "id")}}';
            url = url.replace('id', id );
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
                        type: 'DELETE',
                        url: url,
                        data: {_token: CSRF_TOKEN},
                        dataType: 'JSON',
                        success: function () {
                            Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            })
        })


    </script>
@endsection
