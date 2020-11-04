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
                        <h2>Create Role</h2>
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
                                {!! Form::open(['action' => 'RoleController@store', 'method' => 'POST']) !!}
                                    <table class="table table-bordered">
                                        <input type="hidden" name="guard_name" value="web">
                                        <tr>
                                            <td>Role ID</td>
                                            <td>{{ Form::text('id', '', ['class' => 'form-control', 'placeholder' => 'Role']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Role Name</td>
                                            <td>{{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Role Name']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Role Module</td>
                                            <td>{{ Form::text('module', '', ['class' => 'form-control', 'placeholder' => 'Role Module']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Permission ID</td>
                                            <td>
                                                <select class="form-control permission" name="permission_id[]" multiple>
                                                    @foreach ($permission as $permissions)
                                                        <option value="{{ $permissions->id }}">{{ $permissions->id }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <button class="btn btn-success btn-sm ml-auto float-right mb-5">Submit</button>
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
            $('.permission').select2();
        });
    </script>
@endsection
