@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content"
        style="background-image: url({{ asset('img/bg-form.jpg') }}); background-size: cover">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file'></i> File Classification
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            {{ strtoupper($department->department_name) }} DEPARTMENT
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                data-offset="0,10" data-original-title="Fullscreen"></button>
                            <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10"
                                data-original-title="Close"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            @if (Session::has('message'))
                                <div class="alert alert-success" style="color: #3b6324; background-color: #d3fabc;"> <i
                                        class="icon fal fa-check-circle"></i> {{ Session::get('message') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-success" style="color: #000000; background-color: #ffdf89;">
                                    <i class="icon fal fa-exclamation-circle"></i> {{ $errors->first() }}
                                </div>
                            @endif


                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <p class="card-title w-100" style="font-weight: 500">Add Admin</p>
                                        </div>

                                        {!! Form::open(['action' => 'FCSController@storeOwner', 'method' => 'POST']) !!}
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="card-body">
                                            <table class="table text-center table-borderless">
                                                <tr>
                                                    <div class="form-group">
                                                        <td style="vertical-align: middle"><label
                                                                class="float-right form-label" for="admin">Add
                                                                Owner:</label></td>
                                                        <td colspan="4">
                                                            <select class="form-control admin" name="admin[]" multiple>
                                                                @foreach ($staff as $s)
                                                                    <option value="{{ $s->staff_id }}">
                                                                        {{ $s->staff_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('admin')
                                                                <p style="color: red"><strong> * {{ $message }} </strong>
                                                                </p>
                                                            @enderror
                                                        </td>
                                                        <td><button type="submit"
                                                                class="float-left ml-auto btn btn-primary"><i
                                                                    class="fal fa-save"></i> Save</button></td>
                                                    </div>
                                                </tr>
                                            </table>
                                        </div>
                                        {!! Form::close() !!}

                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead class="text-center bg-primary-50">
                                                    <tr>
                                                        <td>No</td>
                                                        <td>Owner</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp

                                                    @if ($data->isNotEmpty())
                                                        @foreach ($data as $a)
                                                            <tr class="data-row">
                                                                <td style="text-align: center">{{ $i }}</td>
                                                                <td>
                                                                    <b>{{ isset($a->staff->staff_name) ? $a->staff->staff_name : '--' }}</b><br>
                                                                    Department :
                                                                    {{ isset($a->staff->staff_dept) ? $a->staff->staff_dept : '--' }}<br>
                                                                    Email :
                                                                    {{ isset($a->staff->staff_email) ? $a->staff->staff_email : '--' }}<br>
                                                                </td>
                                                                <td style="vertical-align: middle" class="text-center">
                                                                    <form action="{{ route('deleteOwner', $a->id) }}"
                                                                        method="POST" class="deleteOwner">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm delete-alert"><i
                                                                                class="fal fa-trash"></i> Delete</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @php $i++; @endphp
                                                        @endforeach
                                                    @else
                                                        <tr class="data-row">
                                                            <td colspan="3" class="text-center">NO OWNER</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="/owner" class="mb-3 ml-3 mr-auto btn btn-dark btn-sm"><i class="fal fa-arrow-alt-left"></i>
                        Back</a>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.admin').select2();
            $('.staff').select2();


            $("form.deleteOwner").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                Swal.fire({
                        title: 'Are you sure to delete this owner?',
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
                            Swal.fire({
                                text: "Owner deleted!",
                                icon: 'success'
                            });
                        }
                    });
            });
        });
    </script>
@endsection
