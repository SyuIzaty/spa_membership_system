@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> Role
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Update Role</h2>
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
                                {!! Form::open(['action' => ['RoleController@update', $role['id']], 'method' => 'PATCH'])!!}
                                    <table class="table table-bordered">
                                        <input type="hidden" name="guard_name" value="web">
                                        <tr>
                                            <td>Role</td>
                                            <td>{{ Form::text('id', $role['id'], ['class' => 'form-control', 'placeholder' => 'Role', 'readonly' => 'true']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Role Name</td>
                                            <td>{{ Form::text('name', $role['name'], ['class' => 'form-control', 'placeholder' => 'Role Name']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Role Module</td>
                                            <td>
                                                <select class="form-control module" name="module">
                                                    @foreach ($module as $modules)
                                                        <option value="{{ $modules->id }}" {{ $role->module == $modules->id ? 'selected="selected"' : ''}}>{{ $modules->module_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Permission ID</td>
                                            <td>
                                                <select class="form-control permission" name="permission_id[]" multiple>
                                                    @foreach ($permission as $permissions)
                                                        <option value="{{ $permissions->name }}">{{ $permissions->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <button class="btn btn-success btn-sm ml-auto float-right mb-5">Update</button>
                                {!! Form::close() !!}
                                <table class="table table-bordered">
                                    <tr class="bg-primary-50 text-center">
                                        <td>PERMISSION ID</td>
                                        <td>PERMISSION NAME</td>
                                        <td>MODULE</td>
                                        <td>ACTION</td>
                                    </tr>
                                    @foreach ($role_permission as $role_permissions)
                                    <tr>
                                        <td>{{ $role_permissions->id }}</td>
                                        <td>{{ $role_permissions->name }}</td>
                                        <td>{{ $role_permissions->module }}</td>
                                        <td>
                                            <a href="{{ action('RoleController@delete', ['id' => $role_permissions->id, 'role_id' => $role->id]) }}" class="btn btn-danger btn-sm permissiondel"><i class="fal fa-trash"></i></a>
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
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.permission, .module').select2();
        });
    </script>
@endsection
