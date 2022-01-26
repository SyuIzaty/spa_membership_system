@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content" style="background-image: url({{asset('img/bg-form.jpg')}}); background-size: cover">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-file-alt'></i> i-Complaint
        </h1>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        {{ strtoupper($department->name) }} DEPARTMENT
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
                            <div class="col-sm-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <p class="card-title w-100" style="font-weight: 500">Add Admin</p>
                                    </div>

                                    @if (Session::has('message'))
                                        <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i class="icon fal fa-check-circle"></i> {{ Session::get('message') }}</div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                            <i class="icon fal fa-exclamation-circle"></i> {{ $errors->first() }}
                                        </div>
                                    @endif

                                    {!! Form::open(['action' => 'AduanKorporatController@storeAdmin', 'method' => 'POST']) !!}
                                    <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="card-body">
                                            <table class="table table-borderless text-center">
                                                <tr>
                                                    <div class="form-group">
                                                        <td style="vertical-align: middle"><label class="form-label float-right" for="admin">Add Admin:</label></td>
                                                        <td colspan="4">
                                                            <select class="form-control admin" name="admin[]" multiple>
                                                                @foreach ($mainAdmin as $m)
                                                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                                                @endforeach
                                                            </select>                                                                    
                                                            @error('admin')
                                                                <p style="color: red"><strong> * {{ $message }} </strong></p>
                                                            @enderror
                                                        </td>
                                                        <td><button type="submit" class="btn btn-primary ml-auto float-left"><i class="fal fa-save"></i> Save</button></td>
                                                    </div>
                                                </tr>
                                            </table>
                                        </div>
                                    {!! Form::close() !!}

                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead class="bg-primary-50 text-center">
                                                <tr>
                                                    <td>No</td>
                                                    <td>Admin</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $i = 1; @endphp 

                                                @if ($admin->isNotEmpty())
                                                    @foreach ($admin as $a)
                                                        <tr class="data-row">
                                                            <td style="text-align: center">{{ $i }}</td>
                                                            <td>
                                                                <b>{{ $a->staff->staff_name }}</b><br>
                                                                Department : {{ isset($a->staff->staff_dept) ? $a->staff->staff_dept : '--' }}<br>
                                                                Staff ID : {{ $a->staff->staff_id }}<br>
                                                                Email : {{ $a->staff->staff_email }}
                                                            </td>
                                                            <td style="vertical-align: middle" class="text-center">
                                                                <a href="#" data-path ="{{$a->id}}" class="btn btn-danger btn-xs delete-alert" id="delete"><i class="fal fa-trash"></i></a>                                                        
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp                                                        
                                                    @endforeach
                                                @else
                                                    <tr class="data-row">
                                                        <td colspan="3" class="text-center">NO ADMIN</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="/admin-list" class="btn btn-dark btn-sm mr-auto ml-3 mb-3"><i class="fal fa-arrow-alt-left"></i> Back</a>                                            
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
        $('.admin').select2();


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
                        url: "/delete-admin/" + id,
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
