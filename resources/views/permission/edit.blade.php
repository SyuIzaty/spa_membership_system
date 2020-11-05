@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Permission
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Update Permission</h2>
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
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            @endif
                            <div class="card-body">
                                {!! Form::open(['action' => ['PermissionController@update', $permission['id']], 'method' => 'PATCH'])!!}
                                    <table class="table table-bordered">
                                        <input type="hidden" name="guard_name" value="web">
                                        <tr>
                                            <td>Permission ID</td>
                                            <td>{{ Form::text('id', $permission['id'], ['class' => 'form-control', 'placeholder' => 'Permission ID', 'readonly' => 'true']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Permission Name</td>
                                            <td>{{ Form::text('name', $permission['name'], ['class' => 'form-control', 'placeholder' => 'Permission Name']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Permission Module</td>
                                            <td>
                                                <select class="form-control module" name="module">
                                                    @foreach ($module as $modules)
                                                        <option value="{{ $modules->id }}" {{ $permission->module == $modules->id ? 'selected="selected"' : ''}}>{{ $modules->module_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <button class="btn btn-success btn-sm ml-auto float-right mb-5">Update</button>
                                {!! Form::close() !!}
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
            $('.module').select2();
        });
    </script>
@endsection
