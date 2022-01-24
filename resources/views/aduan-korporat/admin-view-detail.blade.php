@extends('layouts.admin')

@section('content')

<main id="js-page-content" role="main" class="page-content">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file-alt'></i> i-Complaint
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr bg-primary">
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>

                <div class="panel-container show">
                    <div class="panel-content">
                        
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="3" class="bg-warning text-center"><h5>Status:  <b>{{strtoupper($data->getStatus()->first()->description)}}</b></h5></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-info-50"><label class="form-label"><i class="fal fa-user"></i> USER PROFILE</label></td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Ticket No : </th>
                                                <td colspan="2" style="vertical-align: middle">{{isset($data->ticket_no) ? $data->ticket_no : '-'}}</td>
                                                <th width="20%" style="vertical-align: middle">Email : </th>
                                                <td colspan="2" style="vertical-align: middle">{{isset($data->email) ? $data->email : '-'}}</td>
                                            </tr>

                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Name : </th>
                                                <td colspan="2" style="vertical-align: middle">{{strtoupper($data->name)}}</td>
                                                <th width="20%" style="vertical-align: middle">Staff ID / Student ID / IC No. / Passport No. : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$data->created_by}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Phone Number : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$data->phone_no}}</td>
                                                <th width="20%" style="vertical-align: middle">Address : </th>
                                                <td colspan="2" style="vertical-align: middle">{!! nl2br($data->address) !!}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle"></span> User Category : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$data->getUserCategory->description}}</td>
                                                <th width="20%" style="vertical-align: middle"></span> Category : </th>
                                                <td colspan="2" style="vertical-align: middle">{{$data->getCategory->description}}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped w-100">
                                        <thead>
                                            <tr>
                                                <td colspan="5" class="bg-info-50"><label class="form-label"><i class="fal fa-file"></i> DETAILS</label></td>
                                            </tr>
                                            
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Title : </th>
                                                <td colspan="4" style="vertical-align: middle">{{$data->title}}</td>
                                            </tr>
                                            <tr>
                                                <th width="20%" style="vertical-align: middle">Description : </th>
                                                <td colspan="4" style="vertical-align: middle">{!! nl2br($data->description) !!}</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                @if ($file->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <td colspan="5" class="bg-info-50"><label class="form-label"><i class="fal fa-file"></i> FILE</label></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="4" style="vertical-align: middle">
                                                        <ol>
                                                            @foreach ( $file as $f )
                                                                <li>
                                                                    <a target="_blank" href="/get-files/{{$f->id}}">{{$f->original_name}}</a>
                                                                </li>
                                                                <br>
                                                            @endforeach
                                                        </ol>
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                @endif

                                @if ($data->status == '1')
                                    @can('assign department')
                                        <form id="formId">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-striped w-100">
                                                    <thead>
                                                        <input type="hidden" id="id" name="id" value="{{ $data->id }}" required>
                                                        <tr>
                                                            <td colspan="5" class="bg-info-50"><label class="form-label"><i class="fal fa-pencil"></i> ASSIGN DEPARTMENT</label></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <th width="20%" style="vertical-align: middle">Department : </th>
                                                            <td colspan="4" style="vertical-align: middle">
                                                                <select class="form-control" name="department" id="department" required>
                                                                    <option disabled>Choose Department</option>
                                                                    @foreach ($department as $d)
                                                                        <option value="{{ $d->id }}" {{ old('department') == $d->id  ? 'selected' : '' }}>{{ $d->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            <button type="submit" class="btn btn-warning ml-auto float-right mr-2 waves-effect waves-themed" id="assign" style="margin-bottom: 20px;"><i class="fal fa-times-circle"></i> Submit</button>
                                        </form>
                                    @endcan
                                @endif

                                @if ($data->status == '2')
                                        @can('take action')
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="5" class="bg-info-50">
                                                                    <label class="form-label"><i class="fal fa-comment-alt"></i> REMARK: 
                                                                        @can('assign department')
                                                                            <form id="changedept" style="display: inline-block;">
                                                                                @csrf
                                                                                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                                                                <select name="department" id="department" >
                                                                                    <option disabled>Choose Department</option>
                                                                                    @foreach ($department as $d)
                                                                                        <option value="{{ $d->id }}" {{ $data->assign == $d->id  ? 'selected' : '' }}>{{ $d->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <button type="submit" id="submitDept" class="btn btn-danger btn-xs float-right waves-effect waves-themed" style="margin-left: 10px; display: none;"><i class="fal fa-times-circle"></i> Change</button>
                                                                            </form>
                                                                        @endcan
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <form id="formRemark">
                                                                @csrf                
                                                                <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                                                                <tr>
                                                                    <td colspan="4" style="vertical-align: middle">
                                                                        <textarea value="{{ old('remark') }}" class="form-control summernote" id="remark" name="remark"></textarea>                                        
                                                                    </td>
                                                                </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                                <button type="submit" class="btn btn-danger ml-auto float-right mr-2 waves-effect waves-themed" id="remarks" style="margin-bottom: 20px;"><i class="fal fa-times-circle"></i> Submit</button>
                                                            </form>
                                        @endcan
                                @endif

                                @if ($data->status == '3' || $data->status == '4')
                                        @can('view complaint')
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="5" class="bg-info-50"><label class="form-label"><i class="fal fa-comment-alt"></i> REMARK: {{$data->getDepartment->name}} DEPARTMENT</label></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td colspan="4" style="vertical-align: middle">
                                                                    <p style="font-size: 10px;"><i style="color:#858c93">{{isset($dataRemark->staff->staff_name) ? $dataRemark->staff->staff_name : ''}} &nbsp; {{isset($dataRemark->created_at) ? $dataRemark->created_at : ''}}</i></p>
                                                                    {!! nl2br($dataRemark->remark) !!}
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                        @endcan
                                    @endif

                                    @if ($data->status == '3')
                                        @can('assign department')
                                            <form id="formAdminRemark">
                                                @csrf
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <input type="hidden" id="id" name="id" value="{{ $data->id }}" required>
                                                            <tr>
                                                                <td colspan="5" class="bg-info-50"><label class="form-label"><i class="fal fa-user"></i> ADMIN REMARK</label></td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td colspan="4" style="vertical-align: middle">   
                                                                    <textarea value="{{ old('adminremarks') }}" class="form-control summernote" id="adminremarks" name="adminremarks" required>{!! nl2br($dataRemark->remark) !!}</textarea>                                        
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <button type="submit" class="btn btn-danger ml-auto float-right mr-2 waves-effect waves-themed" id="adminremark" style="margin-bottom: 20px;"><i class="fal fa-times-circle"></i> Complete</button>
                                            </form>
                                        @endcan
                                    @endif

                                    @if ($data->status == '4')
                                        @can('assign department')
                                            @if ($dataRemark->admin_remark != '')
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover table-striped w-100">
                                                        <thead>
                                                            <tr>
                                                                <td colspan="5" class="bg-info-50"><label class="form-label"><i class="fal fa-user"></i> ADMIN REMARK</label></td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="4" style="vertical-align: middle">
                                                                    <p style="font-size: 10px;"><i style="color:#858c93">{{isset($dataRemark->staffAdmin->staff_name) ? $dataRemark->staffAdmin->staff_name : ''}} &nbsp; {{isset($dataRemark->updated_at) ? $dataRemark->updated_at : ''}}</i></p>
                                                                    {!! nl2br($dataRemark->admin_remark) !!}
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            @endif
                                        @endcan
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

        $('.summernote').summernote({
            height: 200,
            width: 1165,
            spellCheck: true
        });

        $("#assign").on('click', function(e) {
            e.preventDefault();

            var datas = $('#formId').serialize();

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            Swal.fire({
                title: 'Are you sure you want to assign this department?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {

                    Swal.fire({
                    title: 'Loading..',
                    text: 'Please wait..',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    onOpen: () => {
                        Swal.showLoading()
                    }
                })
                    $.ajax({
                        type: "POST",
                        url: "{{ url('assign-department')}}",
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
            })
        });

        $("#remarks").on('click', function(e) {
            e.preventDefault();

            var datas = $('#formRemark').serialize();

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            Swal.fire({
                title: 'Submit remark?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {

                    Swal.fire({
                    title: 'Loading..',
                    text: 'Please wait..',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    onOpen: () => {
                        Swal.showLoading()
                    }
                })
                    $.ajax({
                        type: "POST",
                        url: "{{ url('submit-remark')}}",
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
            })
        });

        $("#adminremark").on('click', function(e) {
            e.preventDefault();

            var datas = $('#formAdminRemark').serialize();

            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            Swal.fire({
                title: 'Complete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {

                    Swal.fire({
                    title: 'Loading..',
                    text: 'Please wait..',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    onOpen: () => {
                        Swal.showLoading()
                    }
                })
                    $.ajax({
                        type: "POST",
                        url: "{{ url('submit-complete')}}",
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
            })
        });

        $(function() { 
            $(document).on('change','#department',function(){

                $("#submitDept").show();

            });
        });

        $("#submitDept").on('click', function(e) {
        
        e.preventDefault();

        var datas = $('#changedept').serialize();

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

        $.ajax({
            type: "POST",
            url: "{{ url('change-dept')}}",
            data: datas,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if(response){
                    Swal.fire(response.success);
                    $("#submitDept").hide();
                }
            },
            error:function(error){
                console.log(error)
                alert("Error");
            }
        });

    });

        
</script>
@endsection

