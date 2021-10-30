@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
        <i class='subheader-icon fal fa-archive'></i>{{ strtoupper($department->department_name) }} DEPARTMENT
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        DEPARTMENT MANAGER <span class="fw-300"><i>LIST</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 mb-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <p class="card-title w-100" style="font-weight: 500">Add Manager</p>
                                    </div>
                                    {!! Form::open(['action' => 'AssetCustodianController@storeDepartCust', 'method' => 'POST']) !!}
                                    <input type="hidden" name="ids" value="{{ $department->id }}">
                                        <div class="card-body test" id="test">
                                                <table class="table table-bordered text-center" id="head_field">
                                                    <tr class="bg-primary-50">
                                                        <td>Manager</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select name="custodian_id[]" id="custodian_id" class="custodian_id form-control">
                                                                <option value="">Select Manager</option>
                                                                @foreach ($members as $member) 
                                                                    <option value="{{ $member->id }}" {{ old('custodian_id') ? 'selected' : '' }}>{{ $member->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td style="vertical-align: middle"><button type="button" name="addhead" id="addhead" class="btn btn-success btn-sm"><i class="fal fa-plus"></i></button></td>
                                                    </tr>
                                                </table>
                                                <div class="footer">
                                                    <button type="submit" class="btn btn-primary ml-auto float-right" name="submit" id="submithead"><i class="fal fa-save"></i> Save</button>
                                                    <a href="/asset-custodian" class="btn btn-success ml-auto float-right mr-2" ><i class="fal fa-arrow-alt-left"></i> Back</a>
                                                </div><br><br>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>

                            <br>

                            <div class="col-sm-12 col-md-6 mb-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <p class="card-title w-100" style="font-weight: 500">Manager List</p>
                                    </div>
                                
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            @if (Session::has('message'))
                                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                            @endif
                                            <table class="table table-bordered">
                                                <thead class="bg-primary-50 text-center">
                                                    <tr>
                                                        <td>No</td>
                                                        <td>Manager</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($custodian as $clo)
                                                    <tr class="data-row">
                                                        <td style="text-align: center">{{ isset($clo->sequence) ? $clo->sequence : $loop->iteration }}</td>
                                                        <td>
                                                            <b>{{ $clo->custodian->name }}</b><br>
                                                            Department : {{ isset($clo->custodian->staff->staff_dept) ? $clo->custodian->staff->staff_dept : '--' }}<br>
                                                            Phone no : {{ $clo->custodian->staff->staff_phone }}<br>
                                                            Email : {{ $clo->custodian->staff->staff_email }}
                                                        </td>
                                                        <td align="center" style="vertical-align: middle">
                                                            <form action="{{route('deleteCustodian', $clo->id)}}" method="POST" class="delete_form"> 
                                                                @method('DELETE')  
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm delete-alert"><i class="fal fa-trash"></i> Delete</button>               
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
    $(document).ready(function()
    {
        $('#custodian_id').select2();

        // Add Custodian
        $('#addhead').click(function(){
            i++;
            $('#head_field').append(`
            <tr id="row${i}" class="head-added">
            <td>
                <select name="custodian_id[]" class="custodians_id form-control">
                    <option value="">Select Manager</option>
                    @foreach ($members as $member) 
                        <option value="{{ $member->id }}" {{ old('custodian_id') ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><button type="button" name="remove" id="${i}" class="btn btn-sm btn-danger btn_remove"><i class="fal fa-trash"></i></button></td>
            </tr>
            `); 
            $('.custodians_id').select2();
        });

        var postURL = "<?php echo url('addmore'); ?>";
        var i=1;

        $.ajaxSetup({
            headers:{
            'X-CSRF-Token' : $("input[name=_token]").val()
            }
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function(){
            $.ajax({
                url:postURL,
                method:"POST",
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.dynamic-added').remove();
                    }
                }
            });
        });

        $('#submithead').click(function(){
            $.ajax({
                url:postURL,
                method:"POST",
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.head-added').remove();
                    }
                }
            });
        });

    });

    $("form.delete_form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then((willDelete) => {
            if (willDelete.value) {
                    form[0].submit();
                    Swal.fire({ text: "Successfully delete the data.", icon: 'success'
                });
            } 
        });
    });

</script>

@endsection
