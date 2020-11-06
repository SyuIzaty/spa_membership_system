@extends('layouts.admin')

@section('content')
    <main id="js-page-content" role="main" class="page-content">
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-table'></i> User
            </h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>Create User</h2>
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
                                {!! Form::open(['action' => 'UserController@store', 'method' => 'POST']) !!}
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>User ID</td>
                                            <td>{{ Form::text('id', '', ['class' => 'form-control', 'placeholder' => 'User']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Full Name</td>
                                            <td>{{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Full Name', 'onkeyup' => 'this.value = this.value.toUpperCase()']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td>{{ Form::text('username','',['class' => 'form-control', 'placeholder' => 'Username']) }}</td>
                                        </tr>
                                        <tr>
                                            <td>User Password</td>
                                            <td><input type="password" class="form-control" name="password" placeholder="Password"></td>
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
