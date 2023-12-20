@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-file-alt'></i> SOP Management
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <p class="card-title w-100" style="font-weight: 500">Add Owner</p>
                                        </div>

                                        @if (Session::has('message'))
                                            <div class="alert alert-success"
                                                style="color: #3b6324; background-color: #d3fabc;"> <i
                                                    class="icon fal fa-check-circle"></i> {{ Session::get('message') }}
                                            </div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-success"
                                                style="color: #000000; background-color: #ffdf89;">
                                                <i class="icon fal fa-exclamation-circle"></i> {{ $errors->first() }}
                                            </div>
                                        @endif

                                        {!! Form::open(['action' => 'SOPController@storeSOPOwner', 'method' => 'POST']) !!}
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="card-body">
                                            <table class="table table-borderless text-center">
                                                <tr>
                                                    <div class="form-group">
                                                        <td style="vertical-align: middle"><label
                                                                class="form-label float-right" for="owner">Add
                                                                Owner:</label></td>
                                                        <td colspan="4">
                                                            <select class="form-control owner" name="owner[]" multiple>
                                                                @foreach ($staff as $s)
                                                                    <option value="{{ $s->staff_id }}">{{ $s->staff_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('owner')
                                                                <p style="color: red"><strong> * {{ $message }} </strong>
                                                                </p>
                                                            @enderror
                                                        </td>
                                                        <td><button type="submit"
                                                                class="btn btn-primary ml-auto float-left"><i
                                                                    class="fal fa-save"></i> Save</button></td>
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
                                                        <td>Owner</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp

                                                    @if ($owner->isNotEmpty())
                                                        @foreach ($owner as $o)
                                                            <tr class="data-row">
                                                                <td style="text-align: center">{{ $i }}</td>
                                                                <td>
                                                                    <b>{{ $o->staff->staff_name }}</b><br>
                                                                    Department :
                                                                    {{ isset($o->staff->staff_dept) ? $o->staff->staff_dept : '--' }}
                                                                </td>
                                                                <td style="vertical-align: middle" class="text-center">
                                                                    <a href="#" data-path="{{ $o->id }}"
                                                                        class="btn btn-danger btn-xs delete-alert"
                                                                        id="delete"><i class="fal fa-trash"></i></a>
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
                                        <a href="/sop-owner" class="btn btn-dark btn-sm mr-auto ml-3 mb-3"><i
                                                class="fal fa-arrow-alt-left"></i> Back</a>
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
        $(document).ready(function() {
            $('.owner').select2();


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
                }).then(function(e) {
                    if (e.value === true) {
                        $.ajax({
                            type: "DELETE",
                            url: "/delete-sop-owner/" + id,
                            data: id,
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response);
                                if (response) {
                                    Swal.fire(response.success);
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        e.dismiss;
                    }
                }, function(dismiss) {
                    return false;
                })
            });
        });
    </script>
@endsection
